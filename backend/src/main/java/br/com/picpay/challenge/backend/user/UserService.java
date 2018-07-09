package br.com.picpay.challenge.backend.user;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.math.BigDecimal;
import java.net.URL;
import java.nio.file.Files;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.time.Duration;
import java.time.Instant;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.TreeMap;
import java.util.concurrent.CancellationException;
import java.util.concurrent.CompletableFuture;
import java.util.concurrent.ExecutionException;
import java.util.concurrent.ForkJoinPool;
import java.util.zip.GZIPInputStream;

import org.apache.commons.codec.binary.Hex;
import org.apache.commons.csv.CSVFormat;
import org.apache.commons.csv.CSVParser;
import org.apache.commons.csv.CSVRecord;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Service;

import br.com.picpay.challenge.backend.ApplicationProperties;
import br.com.picpay.challenge.backend.BackendException;
import br.com.picpay.challenge.backend.DurationUtils;
import br.com.picpay.challenge.backend.es.support.SimpleIndexStats;
import br.com.picpay.challenge.backend.importacao.LogImportacao;
import br.com.picpay.challenge.backend.importacao.LogImportacaoService;
import br.com.picpay.challenge.backend.importacao.StatusImportacao;
import br.com.picpay.challenge.backend.model.support.NavDirection;
import br.com.picpay.challenge.backend.model.support.Page;

@Service
public class UserService {

	private static final Logger logger = LoggerFactory.getLogger(UserService.class);
	
	private static final int PRIORITY_1 = 1;
	private static final int PRIORITY_2 = 1;
	private static final int DEFAULT_PRIORITY = 3;
	
	private static final int DEFAULT_LARGE_BUFFER_SIZE = 1024 * 5;

	@Autowired
	private ApplicationProperties applicationProperties;
	
	@Autowired
	private UserRepository userRepository;
	
	@Autowired
	private LogImportacaoService logImportacaoService;

	/**
	 * Cria o índice para armazenamento dos usuários caso ele ainda não exista
	 */
	public void createIndexIfNeeded() {
		if (!userRepository.indexExists()) {
			userRepository.createIndex();
		}
	}
	
	/**
	 * Excluí o índice de usuários e todos os registros de importação
	 */
	public void resetIndex() {
		userRepository.dropIndex();
		logImportacaoService.deleteAll();
	}
	
	/**
	 * Pesquisa na base de usuários
	 * 
	 * @param term Termo a ser pesquisado
	 * @param navRef Referência para navegação entre as páginas, podendo assumir <code>null</code> quando for a primeira página.
	 * @param direction Direção para navegação entre as páginas
	 * @param size Quantidade de registros a serem retornados
	 * @return
	 */
	public Page<User> search(String term, String navRef, NavDirection direction, int size) {
		return userRepository.findByNameOrUsername(term, navRef, direction, size);
	}
	
	/**
	 * Realiza a importação dos dados para o índice.<br>
	 * O índice de usuário será ordenado considerando a pripridade de cada usuário.<br>
	 * Serão considerados 3 valores para prioridade 1, 2 e 3 sendo 1 a maior prioridade 
	 * e 3 a menor. Para os usuários que não estiverem nas listas de
	 * prioridades 1 ou 2 serão associados a prioridade 3
	 * 
	 * @param urlCsv URL do arquivo CSV contendo os dados a serem importados no índice
	 * @param urlIdsWithPriority1 Arquivo contendo a lista dos IDs com prioridade 1
	 * @param urlIdsWithPriority2 Arquivo contendo a lista dos IDs com prioridade 2
	 * @return Quantidade total de registros importados
	 */
	@Async
	public CompletableFuture<Void> bulkImport(URL urlCsv, URL urlIdsWithPriority1, URL urlIdsWithPriority2) {
		logger.debug("Iniciando importadação dos dados para o índice. Arquivo CSV: {}, Lista relevancia1: {}, Lista de relevancia 2: {}",
				urlCsv, urlIdsWithPriority1, urlIdsWithPriority2);
		
		LogImportacao logImportacaoUrl = logImportacaoService.findByUrlAndStatus(urlCsv.toString(), StatusImportacao.CONCLUIDO);
		if (logImportacaoUrl != null) {
			logger.warn("O arquivo {} já foi importado", urlCsv);
			return CompletableFuture.completedFuture(null);
		}
		
		// Realiza o download dos arquivos utilizando threads separadas
		CompletableFuture<File> taskDownloadPriority1 = CompletableFuture.supplyAsync(() -> downloadFile(urlIdsWithPriority1));
		CompletableFuture<File> taskDownloadPriority2 = CompletableFuture.supplyAsync(() -> downloadFile(urlIdsWithPriority2));
		CompletableFuture<File> taskDownloadCSV = CompletableFuture.supplyAsync(() -> downloadFile(urlCsv));

		CompletableFuture<Void> allDownloadTasks = CompletableFuture.allOf(taskDownloadPriority1, taskDownloadPriority2, taskDownloadCSV);

		// Aguarda execução do download
		try {
			allDownloadTasks.get();
		} catch (InterruptedException e) {
			throw new BackendException("Download interrompido", e);
		} catch (ExecutionException e) {
			throw new BackendException("Erro ao executar download", e);
		} catch (CancellationException e) {
			throw new BackendException("Download cancelado", e);
		}

		File filePriority1;
		File filePriority2;
		File fileCsvGZ;
		File fileCsv;
		String fileHashSha2;
		try {
			filePriority1 = taskDownloadPriority1.get();
		} catch (InterruptedException | ExecutionException e) {
			throw new BackendException("Erro ao obter resultado do download do arquivo " + urlIdsWithPriority1, e);
		}
		try {
			filePriority2 = taskDownloadPriority2.get();
		} catch (InterruptedException | ExecutionException e) {
			throw new BackendException("Erro ao obter resultado do download do arquivo " + urlIdsWithPriority2, e);
		}
		try {
			fileCsvGZ = taskDownloadCSV.get();
		} catch (InterruptedException | ExecutionException e) {
			throw new BackendException("Erro ao obter resultado do download do arquivo " + urlCsv, e);
		}
		try {
			fileCsv = ungz(fileCsvGZ);
		} catch (IOException e) {
			throw new BackendException("Erro ao descompactar arquivo de usuários " + fileCsvGZ, e);
		}
		
		try {
			fileHashSha2 = calcSha2(fileCsv);
			StatusImportacao statusImportacao = logImportacaoService.getImportStatus(fileHashSha2);
			/*
			 * Qualquer operação em andamento que não esteja em memória não sejá considerada, pois
			 * se uma operação está em andamento indica que há processamento e se há processamento deve estar
			 * em memória.
			 */
			if (statusImportacao != null && statusImportacao == StatusImportacao.EM_ANDAMENTO) {
				logger.warn("A importação do arquivo {} está em andamento. Não será possível importa-lo novamente", urlCsv);
				return CompletableFuture.completedFuture(null);
			}
			
			LogImportacao logImportacaoByHash = logImportacaoService.findByFileHash(fileHashSha2);
			if (logImportacaoByHash != null && logImportacaoByHash.getStatus() == StatusImportacao.CONCLUIDO) {
				logger.warn("O arquivo {} já foi importado", urlCsv);
				return CompletableFuture.completedFuture(null);
			}
		} catch (NoSuchAlgorithmException | IOException e1) {
			throw new BackendException("Erro ao calcular hash do arquivo " + fileCsv, e1);
		}

		LogImportacao logImportacao;
		try {
			logImportacao = logImportacaoService.createLogImportacao(urlCsv, fileCsv.length(), fileHashSha2);
		} catch (Exception e) {
			throw new BackendException("Erro ao criar novo log de importacao", e);
		}
		
		Map<String, Integer> idsWithPriority;
		try {
			idsWithPriority = mapIdsWithPriority(filePriority1, filePriority2);
		} catch (Exception e) {
			logImportacaoService.updateToError(logImportacao, "Erro ao carregar lista de prioridades: " + e.getMessage());
			return CompletableFuture.completedFuture(null);
		}

		try (BufferedReader reader = Files.newBufferedReader(fileCsv.toPath())) {
			SynchronizedReader syncBuffer = new SynchronizedReader(reader);
			Instant start = Instant.now();

			List<CompletableFuture<Boolean>> tasks = new ArrayList<>();
			
			final int bulkSize = applicationProperties.getBulkSize();
			
			userRepository.prepareIndexForBulkOperation();
			
			ForkJoinPool localThreadPool = new ForkJoinPool(applicationProperties.getNumTasksCargaInicial());
			try {
				for (int i = 1; i <= applicationProperties.getNumTasksCargaInicial(); i++) {
					tasks.add(CompletableFuture.runAsync(() -> bulkTask(syncBuffer, bulkSize, idsWithPriority), localThreadPool)
							.handle((result, t) -> {
								if (t != null) {
									logger.error("Erro durante processamento", t);
									logImportacaoService.updateToError(logImportacao, "Erro durante processamento em lote (task): " + t.getMessage());
									return Boolean.FALSE;
								}
								return Boolean.TRUE;
							}));
				}
				logger.debug("{} tasks criadas", tasks.size());
	
				CompletableFuture<Void> allTasks = CompletableFuture.allOf(tasks.toArray(new CompletableFuture[0]));
				allTasks.get();
	
				userRepository.restoreDefaultIndexSettings();
				
				Instant end = Instant.now();
				
				Duration elapsedTime = Duration.between(start, end);
				
				boolean completedOk = true;
				for (CompletableFuture<Boolean> task : tasks) {
					if (!task.get()) {
						completedOk = false;
						break;
					}
				}
				
				if (completedOk) {
					logImportacaoService.updateToDone(logImportacao, elapsedTime);
				}
				
				logger.info("Tempo total para indexação da base de usuários: {}. Sucesso: {}", DurationUtils.toString(elapsedTime), completedOk);
				
				return CompletableFuture.completedFuture(null);
			} finally {
				localThreadPool.shutdown();
			}
		} catch (Exception e) {
			logImportacaoService.updateToError(logImportacao, "Erro durante processamento em lote: " + e.getMessage());
			throw new BackendException("Erro durante processamento em lote", e);
		}
	}

	/**
	 * Calcula hash do arquivo utilizando algoritmo sha-256
	 * 
	 * @param file Arquivo para calculo da hash
	 * @return
	 */
	private String calcSha2(File file) throws IOException, NoSuchAlgorithmException {
		logger.debug("Calculando SHA-256 do arquivo {}", file);
		Instant start = Instant.now();
		try (FileInputStream inputStream = new FileInputStream(file)) {
			MessageDigest md = MessageDigest.getInstance("SHA-256");
			byte[] buffer = new byte[DEFAULT_LARGE_BUFFER_SIZE];
			int read;
			while ((read = inputStream.read(buffer)) != -1) {
				md.update(buffer, 0, read);
			}
			String sha2 = Hex.encodeHexString(md.digest());
			
			Instant end = Instant.now();
			
			logger.debug("SHA-256 do arquivo {} calculado. Tempo {}", file, DurationUtils.toString(Duration.between(start, end)));
			
			return sha2;
		}
	}

	private void bulkTask(SynchronizedReader syncReader, int bulkSize, Map<String, Integer> idsWithPriority) {
		Line line;
		List<User> bulkData = new ArrayList<>();
		Duration totalDuration = Duration.ofMillis(0);
		try {
			Instant start = Instant.now();
			int count = 0;
			while ((line = syncReader.readLine()) != null) {
				CSVRecord record = CSVParser.parse(line.line, CSVFormat.RFC4180).getRecords().get(0);
				if (record.size() < 3) {
					logger.warn("Registro {} inválido. Eram esperados 3 colunas", line.lineNumber);
				} else {
					final String id = record.get(0);
					final String name = record.get(1);
					final String username = record.get(2);
					bulkData.add(new User(id, name, username, idsWithPriority.getOrDefault(id, DEFAULT_PRIORITY)));
					if (bulkData.size() >= bulkSize) {
						totalDuration = totalDuration.plus(bulkIndex(bulkData));
						bulkData.clear();
					}
				}
				count++;
				if (count % 500_000 == 0) {
					logger.debug("{} usuários indexados. Tempo médio: {}, {} docs/s", 
							count, 
							DurationUtils.toString(totalDuration.dividedBy(count)),
							calcDocsPerSeconds(totalDuration, count));
				}
			}
			// Os dados que sobrarem deve ser enviados
			if (bulkData.size() > 0) {
				totalDuration = totalDuration.plus(bulkIndex(bulkData));
				bulkData.clear();
			}
			Instant end = Instant.now();

			double docsPerSecs = calcDocsPerSeconds(totalDuration, count);
			if (count > 0) {
				logger.debug("{} usuários indexados. Tempo médio: {}. {} docs/s", 
						count, 
						DurationUtils.toString(totalDuration.dividedBy(count)),
						docsPerSecs);
			}
			
			logger.debug("Task completa. {} registros processados em {}. {} docs/s", count, 
					DurationUtils.toString(Duration.between(start, end)),
					docsPerSecs);
		} catch (IOException e) {
			throw new RuntimeException("Erro durante leitura dos dados", e);
		}
	}
	
	private double calcDocsPerSeconds(Duration duration, int count) {
		long durationSecs = duration.getSeconds();
		if (count > 0) {
			return new BigDecimal((double) count / durationSecs)
					.setScale(2, BigDecimal.ROUND_HALF_EVEN)
					.doubleValue();
		}
		return 0d;
	}
	
	/**
	 * Executa a indexação em massa dos usuários informados
	 * @param users Lista de usuários a ser indexados
	 * @return Tempo gasto para indexação do lote de usuários
	 */
	private Duration bulkIndex(List<User> users) {
		Instant start = Instant.now();
		userRepository.bulkIndex(users);
		Instant end = Instant.now();
		return Duration.between(start, end);
	}

	/**
	 * Realiza o download de um arquivo a partir de uma URL e grava no em disco
	 * 
	 * @param url
	 *            URL do arquivo a ser baixado
	 * @return Caminho para o arquivo baixado
	 * @throws IOException
	 */
	private File downloadFile(URL url) {
		try {
			File tempFile = File.createTempFile("download", ".tmp");
			
			logger.debug("Iniciand download do arquivo {} para {}", url, tempFile);
			
			Instant start = Instant.now();
			try (InputStream input = url.openStream();
					FileOutputStream fileOut = new FileOutputStream(tempFile)) {
				copyLarge(input, fileOut);
			}
			Instant end = Instant.now();
			
			logger.debug("Download do arquivo {} concluído com sucesso. Tempo: {}", url, DurationUtils.toString(Duration.between(start, end)));
			return tempFile;
		} catch (Exception e) {
			throw new BackendException("Erro durante download do arquivo " + url, e);
		}
	}

	private Map<String, Integer> mapIdsWithPriority(File filePriority1, File filePriority2) {
		Map<String, Integer> idsWithPriority = new TreeMap<>();
		try {
			Files.lines(filePriority1.toPath()).forEach(id -> idsWithPriority.put(id, PRIORITY_1));
		} catch (IOException e) {
			throw new BackendException("Erro ao carregar lista de prioridades 1", e);
		}

		try {
			Files.lines(filePriority2.toPath()).forEach(id -> idsWithPriority.put(id, PRIORITY_2));
		} catch (IOException e) {
			throw new BackendException("Erro ao carregar lista de prioridades 2", e);
		}

		return idsWithPriority;
	}
	
	/**
	 * Descompacta um arquivo .gz e grava na área temporária do SO
	 * @param file Arquivo compactado no formato GZIP
	 * @return Caminho para o arquivo descompactado
	 * @throws IOException
	 */
	private File ungz(File file) throws IOException {
		File tempFile = File.createTempFile("gunzip", ".tmp");
		
		logger.debug("Descompactando arquivo {}", tempFile);
		
		Instant start = Instant.now();
		
		try (GZIPInputStream gzipInput = new GZIPInputStream(new FileInputStream(file));
				FileOutputStream gunziped = new FileOutputStream(tempFile)) {
			copyLarge(gzipInput, gunziped);
		}
		Instant end = Instant.now();
		
		logger.debug("Arquivo {} descompactado em {}. Tempo: {}", file, tempFile, DurationUtils.toString(Duration.between(start, end)));
		
		return tempFile;
	}
	
	/**
	 * Realiza a cópia dos dados de um Stream de entrada para um stream de saída utilizando um buffer de 5KB
	 * @param from Stream de origem
	 * @param to Stream de destino
	 * @throws IOException
	 */
	private void copyLarge(InputStream from, OutputStream to) throws IOException {
		byte[] buffer = new byte[DEFAULT_LARGE_BUFFER_SIZE];
		int read;
		while ((read = from.read(buffer)) != -1) {
			to.write(buffer, 0, read);
		}
	}
	
	/**
	 * Obtem as estatísticas do indice de usuários
	 */
	public SimpleIndexStats getIndexStats() {
		return userRepository.getIndexStats();
	}

	/**
	 * Sincroniza o acesso ao a leitura de dados do buffered reader para permitir
	 * acesso concorrente a leitura dos dados do arquivo.
	 * 
	 * @author francofabio
	 *
	 */
	private static class SynchronizedReader {

		private final BufferedReader bufferedReader;
		private int lineNumber;

		public SynchronizedReader(BufferedReader bufferedReader) {
			this.bufferedReader = bufferedReader;
			this.lineNumber = 0;
		}

		/**
		 * Lê a próxima linha o arquivo. Caso o arquivo tenha chegado ao fim, retorna <code>null</code>.
		 * @return Próxima linha do arquivo ou <code>null</code> caso o arquivo tenha chegado ao fim.
		 * @throws IOException
		 */
		public synchronized Line readLine() throws IOException {
			String line = bufferedReader.readLine();
			if (line != null) {
				return new Line(++lineNumber, line);
			}
			return null;
		}
	}

	/**
	 * Representa a linha de um arquivo, contendo o conteúdo da linha e o número da linha no arquivo.
	 * 
	 * @author francofabio
	 *
	 */
	private static class Line {
		public final int lineNumber;
		public final String line;

		public Line(int lineNumber, String line) {
			this.lineNumber = lineNumber;
			this.line = line;
		}
	}

}
