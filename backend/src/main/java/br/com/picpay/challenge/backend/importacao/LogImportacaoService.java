package br.com.picpay.challenge.backend.importacao;

import java.net.URL;
import java.time.Duration;
import java.util.Collections;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import br.com.picpay.challenge.backend.DurationUtils;

@Service
public class LogImportacaoService {

	/*
	 * Controle in-memory das importações
	 * 
	 * Key: Hash do arquivo a ser importado
	 * Value: Status da importacao
	 */
	private static final Map<String, StatusImportacao> IMPORT_LIST = Collections.synchronizedMap(new HashMap<>());
	
	@Autowired
	private LogImportacaoRepository logImportacaoRepository;
	
	/**
	 * Cria um novo log de importação
	 * 
	 * @return Log de importação criado
	 */
	public LogImportacao createLogImportacao(URL fileUrl, long fileSize, String fileHashSha2) {
		LogImportacao logImportacao = new LogImportacao();
		logImportacao.setDate(new Date());
		logImportacao.setCurrent(true);
		logImportacao.setStatus(StatusImportacao.EM_ANDAMENTO);
		logImportacao.setLastUpdate(new Date());
		logImportacao.setFileUrl(fileUrl.toString());
		logImportacao.setFileSize(fileSize);
		logImportacao.setFileHashSha2(fileHashSha2);
		
		/*
		 * Existe um débito tecnico nesta abortagem, pois a atualização não é ACID (Atomicity, Consistency, Isolation and Durability)
		 */
		addToImportList(fileHashSha2);
		
		logImportacaoRepository.save(logImportacao);
		
		logImportacaoRepository.unmarkPreviousCurrent(logImportacao.getId());
		
		return logImportacao;
	}
	
	/**
	 * Busca um log de importação pela hash do arquivo
	 * 
	 * @param hash Hash
	 * @return
	 */
	public LogImportacao findByFileHash(String hash) {
		return logImportacaoRepository.findFirstByFileHashSha2OrderByDateDesc(hash);
	}
	
	/**
	 * Busca o log de importação pela URL e status
	 * @param url URL do arquivo importado
	 * @param status Status desejado
	 * @return
	 */
	public LogImportacao findByUrlAndStatus(String url, StatusImportacao status) {
		return logImportacaoRepository.findByFileUrlAndStatus(url, status);
	}
	
	/**
	 * Retorna o status atual (in-memory) da importação do arquivo.<br>
	 * A inexistencia do status não indica que não houve importação do arquivo.
	 * 
	 * @param hash Hash do arquivo
	 * @return
	 */
	public StatusImportacao getImportStatus(String hash) {
		return IMPORT_LIST.get(hash);
	}
	
	/**
	 * Returna o log da importação atual
	 * @return
	 */
	public LogImportacao findCurrentLogImportacao() {
		return logImportacaoRepository.findCurrrent().orElse(null);
	}
	
	/**
	 * Retorna o log de importação pelo id
	 * @param id Id do log de importação
	 * @return
	 */
	public LogImportacao findById(String id) {
		return logImportacaoRepository.findById(id).orElse(null);
	}
	
	/**
	 * Atualiza o log de importação para o status de concluído
	 * 
	 * @param logImportacao Registro de importação ser atualizado
	 */
	public void updateToDone(LogImportacao logImportacao, Duration elapsedTime) {
		logImportacao.setElapsedTime(DurationUtils.toString(elapsedTime));
		updateStatus(logImportacao, StatusImportacao.CONCLUIDO, null);
	}
	
	/**
	 * Atualiza o log de importação para o status de erro
	 * @param logImportacao Registro de importação ser atualizado
	 * @param descricao Descricao do erro
	 */
	public void updateToError(LogImportacao logImportacao, String descricao) {
		updateStatus(logImportacao, StatusImportacao.ERRO, descricao);
	}
	
	/**
	 * Excluí todos os logs de importação
	 */
	public void deleteAll() {
		logImportacaoRepository.deleteAll();
	}
	
	private void updateStatus(LogImportacao logImportacao, StatusImportacao novoStatus, String descricaoStatus) {
		/*
		 * Existe um débito tecnico nesta abortagem, pois a atualização não é ACID (Atomicity, Consistency, Isolation and Durability)
		 */
		logImportacao.setStatus(novoStatus);
		logImportacao.setDescricaoStatus(descricaoStatus);
		logImportacao.setLastUpdate(new Date());
		logImportacaoRepository.save(logImportacao);
		
		IMPORT_LIST.put(logImportacao.getFileHashSha2(), novoStatus);
	}
	
	/**
	 * Adiciona nova entrada a lista de importações
	 * @param hash Hash do arquivo a ser importado
	 */
	private void addToImportList(String hash) {
		IMPORT_LIST.put(hash, StatusImportacao.EM_ANDAMENTO);
	}
	
}
