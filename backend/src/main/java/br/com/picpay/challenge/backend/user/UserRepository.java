package br.com.picpay.challenge.backend.user;

import static br.com.picpay.challenge.backend.es.support.ElasticsearchMapper.createIndexRequestForDoc;
import static org.apache.commons.lang3.StringUtils.isBlank;

import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.StringWriter;
import java.math.BigDecimal;
import java.nio.charset.StandardCharsets;
import java.time.Duration;
import java.time.Instant;
import java.util.Base64;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.zip.GZIPInputStream;
import java.util.zip.GZIPOutputStream;

import org.apache.commons.io.IOUtils;
import org.elasticsearch.action.admin.indices.create.CreateIndexRequest;
import org.elasticsearch.action.admin.indices.create.CreateIndexResponse;
import org.elasticsearch.action.admin.indices.delete.DeleteIndexRequest;
import org.elasticsearch.action.admin.indices.delete.DeleteIndexResponse;
import org.elasticsearch.action.admin.indices.get.GetIndexRequest;
import org.elasticsearch.action.admin.indices.refresh.RefreshRequest;
import org.elasticsearch.action.admin.indices.refresh.RefreshResponse;
import org.elasticsearch.action.admin.indices.settings.put.UpdateSettingsRequest;
import org.elasticsearch.action.admin.indices.settings.put.UpdateSettingsResponse;
import org.elasticsearch.action.bulk.BulkItemResponse;
import org.elasticsearch.action.bulk.BulkRequest;
import org.elasticsearch.action.bulk.BulkResponse;
import org.elasticsearch.action.get.GetRequest;
import org.elasticsearch.action.get.GetResponse;
import org.elasticsearch.action.index.IndexResponse;
import org.elasticsearch.action.search.SearchRequest;
import org.elasticsearch.action.search.SearchResponse;
import org.elasticsearch.action.search.ShardSearchFailure;
import org.elasticsearch.client.Response;
import org.elasticsearch.client.RestHighLevelClient;
import org.elasticsearch.common.settings.Settings;
import org.elasticsearch.index.query.QueryBuilders;
import org.elasticsearch.search.builder.SearchSourceBuilder;
import org.elasticsearch.search.sort.SortOrder;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Repository;

import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;

import br.com.picpay.challenge.backend.BackendException;
import br.com.picpay.challenge.backend.es.support.ElasticsearchMapper;
import br.com.picpay.challenge.backend.es.support.SimpleIndexStats;
import br.com.picpay.challenge.backend.model.support.NavDirection;
import br.com.picpay.challenge.backend.model.support.Page;

/**
 * Repositório ElasticSearch para a classe {@link User}
 * 
 * @author francofabio
 *
 */
@Repository
public class UserRepository {

	private static final Logger logger = LoggerFactory.getLogger(UserRepository.class);

	private static final ObjectMapper JSON_MAPPER = new ObjectMapper();

	public static final String USER_INDEX = "user";
	public static final String USER_TYPE = "doc";

	public static final String DEFAULT_REFRESH_INTERVAL = "10s";

	@Autowired
	private RestHighLevelClient esClient;

	/**
	 * Criar o índice para armazenamento e pesquisa dos usuários
	 */
	public void createIndex() {
		CreateIndexRequest createIndexRequest = new CreateIndexRequest(USER_INDEX);
		// Configurações básicas. Para produção deve ser feita análise mais detalhada em
		// relação a quantidade de shards
		createIndexRequest.settings(Settings.builder().put("refresh_interval", DEFAULT_REFRESH_INTERVAL)
				.put("number_of_shards", 1).put("number_of_replicas", 0));
		createIndexRequest.mapping(USER_TYPE, "name", "type=text", "username", "type=keyword", "priority",
				"type=integer");
		try {
			CreateIndexResponse createIndexResponse = esClient.indices().create(createIndexRequest);
			if (!createIndexResponse.isAcknowledged()) {
				throw new BackendException("Falha ao criar índice");
			}
		} catch (IOException e) {
			throw new BackendException("Erro ao criar índice", e);
		}
	}

	/**
	 * Excluí o índice de usuários
	 */
	public void dropIndex() {
		DeleteIndexRequest deleteIndexRequest = new DeleteIndexRequest(USER_INDEX);
		try {
			DeleteIndexResponse response = esClient.indices().delete(deleteIndexRequest);
			if (!response.isAcknowledged()) {
				throw new BackendException("Falha ao excluir índice");
			}
		} catch (IOException e) {
			throw new BackendException("Erro ao excluir índice", e);
		}
	}

	/**
	 * Verifica se o índice para armazenamento dos usuários existe
	 * 
	 * @return <code>true</code> se o índice existe ou <code>false</code> caso
	 *         contrário.
	 */
	public boolean indexExists() {
		GetIndexRequest getIndexRequest = new GetIndexRequest();
		getIndexRequest.indices(USER_INDEX);
		try {
			return esClient.indices().exists(getIndexRequest);
		} catch (IOException e) {
			throw new BackendException("Erro ao verificar se o índice existe", e);
		}
	}

	/**
	 * Prepara o índice de usuários para receber operações em lote obtendo melhor
	 * desempenho do índice.
	 */
	public void prepareIndexForBulkOperation() {
		/*
		 * Conforme recomendação da elastic, utilizar um refresh iterval longo ou
		 * 'desabilita-lo' durante o carregamento dos dados, garante melhor perforcance
		 * nas 'bulk operations'
		 */
		try {
			UpdateSettingsRequest updateSettingsRequest = new UpdateSettingsRequest(USER_INDEX);
			updateSettingsRequest.settings(Settings.builder().put("refresh_interval", "-1"));
			UpdateSettingsResponse updateSettingsResponse = esClient.indices().putSettings(updateSettingsRequest);
			if (!updateSettingsResponse.isAcknowledged()) {
				throw new BackendException("Falha ao preparar índice para 'bulk operations'");
			}
		} catch (IOException e) {
			throw new BackendException("Erro ao preparar índice para 'bulk operations'", e);
		}
	}

	/**
	 * Restaura as configurações padrão do índice de usuários
	 */
	public void restoreDefaultIndexSettings() {
		try {
			UpdateSettingsRequest updateSettingsRequest = new UpdateSettingsRequest(USER_INDEX);
			updateSettingsRequest.settings(Settings.builder().put("refresh_interval", DEFAULT_REFRESH_INTERVAL));
			UpdateSettingsResponse updateSettingsResponse = esClient.indices().putSettings(updateSettingsRequest);
			if (!updateSettingsResponse.isAcknowledged()) {
				throw new BackendException("Falha ao restaurar configurações do índice");
			}
		} catch (IOException e) {
			throw new BackendException("Erro ao restaurar configurações do índice", e);
		}
	}

	/**
	 * Retorna estatísticas básicas sobre o índice
	 */
	public SimpleIndexStats getIndexStats() {
		try {
			final String URI = String.format("/%s/_stats/docs,store", USER_INDEX);
			Response response = esClient.getLowLevelClient().performRequest("GET", URI);
			String responseContent;
			try (InputStream input = response.getEntity().getContent(); StringWriter output = new StringWriter()) {
				IOUtils.copy(input, output, StandardCharsets.UTF_8);
				responseContent = output.toString();
			}
			if (logger.isDebugEnabled()) {
				logger.debug("Resposta {}. Status: {}, content: {}", URI, response.getStatusLine().getStatusCode(),
						responseContent);
			}
			if (HttpStatus.valueOf(response.getStatusLine().getStatusCode()).is2xxSuccessful()) {
				JsonNode rootNode = JSON_MAPPER.readTree(responseContent);
				JsonNode indicesNode = rootNode.get("indices");
				JsonNode userIndexNode = indicesNode.get(USER_INDEX);
				if (userIndexNode != null) {
					JsonNode primariesNode = userIndexNode.get("primaries");
					JsonNode docsNode = primariesNode.get("docs");
					JsonNode storeNode = primariesNode.get("store");

					long totalDocs = docsNode.get("count").asLong();
					long totalSize = storeNode.get("size_in_bytes").asLong();

					return new SimpleIndexStats(totalDocs, totalSize);
				}
			} else {
				logger.error("Falha ao obter estatísticas do índice. Status code: {}, response: {}",
						response.getStatusLine().getStatusCode(), responseContent);
			}
			return null;
		} catch (IOException e) {
			throw new BackendException("Erro ao obter estatísticas do índice", e);
		}
	}

	/**
	 * Solicita atualização do índice manualmente
	 */
	public void refreshIndex() {
		try {
			RefreshResponse refreshResponse = esClient.indices().refresh(new RefreshRequest(USER_INDEX));
			if (refreshResponse.getFailedShards() > 0) {
				throw new BackendException("Falha ao executar refresh do índice");
			}
		} catch (IOException e) {
			throw new BackendException("Erro ao realizar refresh no índice", e);
		}
	}

	/**
	 * Incluí um usuário no índice de pesquisa
	 * 
	 * @param user
	 * @return
	 */
	public User index(User user) {
		try {
			IndexResponse indexResponse = esClient.index(createIndexRequestForDoc(USER_INDEX, USER_TYPE, user));
			user.setId(indexResponse.getId());
		} catch (IOException e) {
			throw new BackendException("Erro ao indexar usuário", e);
		}
		return user;
	}

	/**
	 * Recupera um usuário pelo Id
	 * 
	 * @param id Identificador do usuário
	 * @return Usuário caso ela exista no índice, caso contrário retorno <code>null</code>
	 */
	public User findById(String id) {
		try {
			GetRequest getRequest = new GetRequest(USER_INDEX, USER_TYPE, id);
			GetResponse getResponse = esClient.get(getRequest);
			if (getResponse.isExists()) {
				return ElasticsearchMapper.mapperGetResponse(getResponse, User.class);
			}
			return null;
		} catch (IOException e) {
			throw new BackendException("Erro ao recuperar usuário pelo id", e);
		}
	}

	/**
	 * Realiza a inclusão em lote de novos usuários no índice de pesquisa
	 * 
	 * @param users Lista de usuários a ser incluída
	 * @return <code>true</code> Caso todos os usuários sejam incluídos com sucesso,
	 *         caso contrário será retornado <code>false</code>
	 */
	public boolean bulkIndex(List<User> users) {
		BulkRequest bulkRequest = new BulkRequest();
		for (User user : users) {
			bulkRequest.add(createIndexRequestForDoc(USER_INDEX, USER_TYPE, user));
		}
		try {
			logger.debug("Bulking {} users to user index", users.size());

			BulkResponse bulkResponse = esClient.bulk(bulkRequest);
			logger.debug("Process time: {}, hasFailures: {}", bulkResponse.getTook(), bulkResponse.hasFailures());
			if (bulkResponse.hasFailures()) {
				for (BulkItemResponse item : bulkResponse.getItems()) {
					logger.error("Id: {}, status: {} , failed: {}, message: {}", item.getId(), item.status(),
							item.isFailed(), item.getFailureMessage());
				}
			}
			for (BulkItemResponse item : bulkResponse.getItems()) {
				users.get(item.getItemId()).setId(item.getId());
			}
			return bulkResponse.hasFailures();
		} catch (IOException e) {
			throw new BackendException("Erro ao realizar a indexação em lote", e);
		}
	}

	/**
	 * Realiza uma pesquisa no índice pelo nome do usuário ou pelo username
	 * 
	 * @param term Termo a ser pesquisado
	 * @param encodedNavRef Referência para navegação entre as páginas, podendo assumir <code>null</code> quando for a primeira página.
	 * @param direction Direção para navegação entre as páginas, podendo assumir <code>null</code> quando for a primeira página.
	 * @param size Quantidade de registros a serem retornados
	 * @return Lista de usuários encontrados que satisfazem aos termos da pesquisa
	 */
	public Page<User> findByNameOrUsername(String term, String encodedNavRef, NavDirection direction, int size) {
		/*
		 * Por questões de performance o elasticsearch tem limitação em relação ao uso do from / size (limite de 10000 docs de navegação),
		 * ou seja, from + size não pode ser superior a 10000.
		 * O tamanho desta janela é configurável, porém não é recomendado seu uso, pois gera um custo muito alto de processamento e memória.
		 * Os operações from / size executam tarefas muito custosas para cada shard, fazendo com que seu uso seja desencorajado pela equipe
		 * do elasticsearch em favor do search_after.
		 * O operador search_after trabalha de forma semelhante ao curso do solr, realizando a pesquisa sempre a partir do valor informado.
		 * 
		 * Devido a natureza do operador search_after, não é possível fazer uma pesquisa do tipo "backward" sempre "forward", com isso
		 * eu implemetei uma solução para atender os requisitos de navegação que imagino que foram pensados por quem elaborou o desafio.
		 * O recurso é simples e deve ser utilizado em produção com cautela, pois dependendo da quantidade de paginas navegadas (deep pagigation)
		 * pode consumir muita memória do backend e também tempo de CPU para decodificação do navRef, além do cliente ter a necessidade de 
		 * armazenar um navRef muito grande.
		 * 
		 * Essa abordagem basicamente guarda o histórico de navegação até a página atual. 
		 * Na medida que o usuário "mergulha" nas páginas, mais dados de referência das páginas anteriores são armazenados, por isso 
		 * deve-se ter cautela no uso desta abordagem.
		 * 
		 * O que é armazenado de cada página navegada?
		 * São armazenado os dados para "chegar" até uma página anterior, em outras palavras, são armazenados os "sort values" de cada página navegada.
		 * Exemplo:
		 * Se o usuário navegou até a página 10, serão armazenados os "sort values" das páginas de 1 à 9.
		 * 
		 * Todos os dados de referência são compactados e codificados em base64.
		 * 
		 * Armazenamento no cliente do navRef.
		 * O navRef (dados e navegação entre as páginas) deve ser armazenados no cliente, se o cliente perder os dados ele não será capaz
		 * de continuar a navegação de onde parou e deverá iniciar a navegação a partir do inicio.
		 * Como o armazenamento dos dados de navegação é feito no cliente, quando temos uma navegação profunda mais dados são 
		 * gerados para o cliente armazenar.
		 * 
		 * 
		 */
		NavigationRef navRef = decodeNavRef(encodedNavRef);
		Object[] searchRef = null;
		SearchRequest searchRequest = new SearchRequest(USER_INDEX);
		searchRequest.types(USER_TYPE);
		SearchSourceBuilder sourceBuilder = new SearchSourceBuilder();
		sourceBuilder.query(QueryBuilders.multiMatchQuery(term, "username", "name"));
		sourceBuilder.sort("priority", SortOrder.ASC).sort("_score", SortOrder.DESC).sort("_id", SortOrder.DESC);
		sourceBuilder.size(size);
		if (navRef != null) {
			if (direction == NavDirection.NEXT && isValidPageRef(navRef.getNext())) {
				searchRef = navRef.getNext().getRef();
			} else if (direction == NavDirection.PREV && navRef.getCurrent() != null && navRef.getPrev() != null) {
				int prevPage = Math.max(1, navRef.getCurrent().getPage() - 1);
				PageRef prev = navRef.getPrev().get(prevPage);
				if (isValidPageRef(prev)) {
					searchRef = prev.getRef();
				}
			}
			if (searchRef != null) {
				sourceBuilder.searchAfter(searchRef);
			}
		}
		searchRequest.source(sourceBuilder);

		try {
			SearchResponse searchResponse = esClient.search(searchRequest);

			logger.debug("Process time: {}, failed shards: {}", searchResponse.getTook(),
					searchResponse.getFailedShards());

			if (searchResponse.getFailedShards() > 0) {
				StringBuilder fail = new StringBuilder();
				for (ShardSearchFailure failure : searchResponse.getShardFailures()) {
					if (fail.length() > 0) {
						fail.append("\n");
					}
					fail.append("Status: ").append(failure.status()).append(", reason: ").append(failure.reason())
							.append(", shardid: ").append(failure.shardId());
				}
				logger.error("A pesquisa falhou em alguns shards. Failures: {}", fail);
			}
			long totalElements = searchResponse.getHits().getTotalHits();
			int totalPages = (int) totalElements / size;
			if (totalElements % size != 0) {
				totalPages++;
			}
			
			Map<Integer, PageRef> respPrevPageRef = null;
			PageRef respCurrentPageRef = null;
			PageRef respNextPageRef = null;
			
			//Sempre que o navRef for nulo indica que é a primeira página
			if (navRef == null || navRef.getCurrent() == null) {
				respCurrentPageRef = new PageRef(1, null);
			} else {
				if (navRef.getPrev() == null) {
					respPrevPageRef = new HashMap<>();
				} else {
					respPrevPageRef = navRef.getPrev();
				}
				
				if (direction == null || direction == NavDirection.NEXT) {
					int newCurrentPage = Math.max(1, navRef.getCurrent().getPage() + 1);
					respCurrentPageRef = new PageRef(newCurrentPage, searchRef);
					
					//Adicional pagina atual (passada como parâmetro) a lista de páginas navegadas
					respPrevPageRef.put(navRef.getCurrent().getPage(), navRef.getCurrent());
				} else {
					int newCurrentPage = Math.max(1, navRef.getCurrent().getPage() - 1);
					respCurrentPageRef = new PageRef(newCurrentPage, searchRef);
					
					//Deve-se manter somente as páginas navegadas anteriores a página atual
					respPrevPageRef.keySet().removeIf(page -> page >= newCurrentPage);
				}
			}
			
			int hitsLength = searchResponse.getHits().getHits().length;
			//Só haverá próxima página se existirem resultado e o total retornado for ao menos do tamanho do página
			if (hitsLength > 0 && hitsLength >= size) {
				Object[] nextRef = searchResponse.getHits().getAt(hitsLength - 1).getSortValues();
				respNextPageRef = new PageRef(Math.max(2, respCurrentPageRef.getPage()+1), nextRef);
			}
			
			String respNavRef = encodeNavRef(new NavigationRef(respPrevPageRef, respCurrentPageRef, respNextPageRef));
			
			List<User> content = ElasticsearchMapper.mapperHits(searchResponse.getHits(), User.class);

			double seconds = new BigDecimal(searchResponse.getTook().getMillis() / 1000d)
					.setScale(3, BigDecimal.ROUND_HALF_EVEN).doubleValue();

			return new Page<User>(seconds, respCurrentPageRef.getPage(), totalPages, size, totalElements, respNavRef, content);
		} catch (IOException e) {
			throw new BackendException("Erro ao realizar pesquisa", e);
		}
	}

	/**
	 * Verifica se um objeto do tipo {@link PageRef} contém uma refêrencia válida
	 * @param pageRef PageRef a ser analisado
	 * @return <code>true</code> se o page ref é válido ou <code>false</code> se não é válido
	 */
	private boolean isValidPageRef(PageRef pageRef) {
		return pageRef != null && pageRef.getRef() != null && pageRef.getRef().length > 0;
	}

	/**
	 * Codifica a referência de navegação.
	 * 
	 * @param navRef Referência de navegação a ser codificada
	 * @return Referência de navegação codificada
	 */
	private String encodeNavRef(NavigationRef navRef) {
		Instant start = Instant.now();
		String json;
		try {
			json = JSON_MAPPER.writeValueAsString(navRef);
		} catch (Exception e) {
			throw new BackendException("Erro ao serializar o objeto navRef para JSON", e);
		}
		byte[] gziped;
		try {
			gziped = gzipStr(json);
		} catch (Exception e) {
			throw new BackendException("Erro ao compactar o JSON do navRef", e);
		}
		try {
			String navRefEncoded = Base64.getEncoder().encodeToString(gziped);
			Instant end = Instant.now();
			
			logger.debug("NavRef encode time: {}ms", Duration.between(start, end).toMillis());
			
			return navRefEncoded;
		} catch (Exception e) {
			throw new BackendException("Erro codificar navRef para base64", e);
		}
	}

	/**
	 * Decodifica a referência de navegação<br>
	 * O <code>navRefEncoded</code> é a representação em JSON de um objeto da classe {@link NavigationRef}, 
	 * compactado com algoritmo GZip e codificado em base64
	 * 
	 * @param navRefEncoded Referência de navagação codificada
	 * @return Referência de navegação ou <code>null</code> caso seja informado <code>navRef</code> <code>null</code> ou o formato esteja inválido
	 */
	private NavigationRef decodeNavRef(String navRefEncoded) {
		if (isBlank(navRefEncoded)) {
			return null;
		}
		Instant start = Instant.now();
		
		byte[] gziped;
		try {
			gziped = Base64.getDecoder().decode(navRefEncoded);
		} catch (Exception e) {
			logger.error("Erro ao decodificar o navigation ref: " + navRefEncoded, e);
			return null;
		}
		String json;
		try {
			json = ungzipStr(gziped);
		} catch (Exception e) {
			logger.error("Erro ao descompactar o navigation ref: " + navRefEncoded, e);
			return null;
		}
		try {
			NavigationRef navRef = JSON_MAPPER.readValue(json, NavigationRef.class);
			Instant end = Instant.now();
			
			logger.debug("NavRef decode time: {}ms", Duration.between(start, end).toMillis());
			
			return navRef;
		} catch (Exception e) {
			logger.error("Erro ao realizar o parse do JSON do navigation ref: " + json, e);
			return null;
		}
	}
	
	/**
	 * Compacta um string utilizando o algoritmo GZIP
	 * @param s String a ser compactada
	 * @return Resultado da compactação
	 * @throws IOException
	 */
	private byte[] gzipStr(String s) throws IOException {
		try (ByteArrayInputStream input = new ByteArrayInputStream(s.getBytes())) {
			try (ByteArrayOutputStream out = new ByteArrayOutputStream()) {
				try (GZIPOutputStream gzipOutput = new GZIPOutputStream(out)) {
					byte[] buf = new byte[1024 * 2];
					int read;
					while ((read = input.read(buf)) != -1) {
						gzipOutput.write(buf, 0, read);
					}
				}
				return out.toByteArray();
			}
		}
	}
	
	/**
	 * Descompacta string utilizando algoritmo GZip
	 * @param buf dados binários da string a ser descompactada
	 * @return String descompactada
	 * @throws IOException
	 */
	private String ungzipStr(byte[] buf) throws IOException {
		StringBuilder ungzipedStr = new StringBuilder();
		try (ByteArrayInputStream input = new ByteArrayInputStream(buf)) {
			try (GZIPInputStream gzipInput = new GZIPInputStream(input)) {
				byte[] ungzipedBuf = new byte[1024 *2];
				int read;
				while ((read = gzipInput.read(ungzipedBuf)) != -1) {
					ungzipedStr.append(new String(ungzipedBuf, 0, read));
				}
			}
		}
		return ungzipedStr.toString();
	}

	public static class PageRef {
		private int page;
		private Object[] ref;

		public PageRef() {}
		
		public PageRef(int page, Object[] ref) {
			super();
			this.page = page;
			this.ref = ref;
		}

		public int getPage() {
			return page;
		}

		public Object[] getRef() {
			return ref;
		}
	}

	public static class NavigationRef {
		private Map<Integer, PageRef> prev;
		private PageRef current;
		private PageRef next;

		public NavigationRef() {}
		
		public NavigationRef(Map<Integer, PageRef> prev, PageRef current, PageRef next) {
			this.prev = prev;
			this.current = current;
			this.next = next;
		}

		public Map<Integer, PageRef> getPrev() {
			return prev;
		}

		public PageRef getCurrent() {
			return current;
		}

		public PageRef getNext() {
			return next;
		}

	}

}
