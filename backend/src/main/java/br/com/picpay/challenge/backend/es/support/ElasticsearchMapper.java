package br.com.picpay.challenge.backend.es.support;

import java.lang.reflect.InvocationTargetException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.apache.commons.beanutils.BeanMap;
import org.apache.commons.beanutils.BeanUtils;
import org.elasticsearch.action.get.GetResponse;
import org.elasticsearch.action.index.IndexRequest;
import org.elasticsearch.common.xcontent.XContentType;
import org.elasticsearch.search.SearchHit;
import org.elasticsearch.search.SearchHits;

/**
 * Classe utilitária para realizar o mapeapento de objetos java para docs do elasticsearch
 * e vice-versa.
 * 
 * @author francofabio
 *
 */
public class ElasticsearchMapper {

	private static final String ID_FIELD = "id";
	
	private static final List<String> ES_EXCLUDED_FIELDS = Arrays.asList(ID_FIELD, "class");
	
	public static <T extends BaseEsDocument> T mapperGetResponse(GetResponse getResponse, Class<T> cls) {
		//O ID não está presente na resposta, por isso devemos adiciona-lo manualmente no map
		Map<String, Object> data = new HashMap<>(getResponse.getSourceAsMap());
		data.put(ID_FIELD, getResponse.getId());
		try {
			T inst = cls.newInstance();
			BeanUtils.populate(inst, data);
			return inst;
		} catch (InstantiationException | IllegalAccessException | InvocationTargetException e) {
			throw new IllegalArgumentException("Erro ao tentar mapear o 'get response' para um objeto do tipo " + cls.getName() + ": "
					+ getResponse.getSourceAsString(), e);
		}
	}
	
	/**
	 * Realiza o mapeamento de um ES hit para um objeto java
	 * @param hit Elasticsearch hit a ser mapeado
	 * @param cls Classe do objeto a ser retornado
	 * @return Objeto da classe <code>cls</code> contendo os dados do hit
	 */
	public static <T extends BaseEsDocument> T mapperHit(SearchHit hit, Class<T> cls) {
		//O ID não está presente no hit, por isso devemos adiciona-lo manualmente no map
		Map<String, Object> data = new HashMap<>(hit.getSourceAsMap());
		data.put(ID_FIELD, hit.getId());
		try {
			T inst = cls.newInstance();
			BeanUtils.populate(inst, data);
			return inst;
		} catch (InstantiationException | IllegalAccessException | InvocationTargetException e) {
			throw new IllegalArgumentException("Erro ao tentar mapear o ES hit para um objeto do tipo " + cls.getName() + ": "
					+ hit.getSourceAsString(), e);
		}
	}
	
	/**
	 * Realiza o mapeamento de uma lista de hits para uma lista de objetos java
	 * @param hits Elasticsearch hits a serem mapeados
	 * @param cls Classe do objeto a ser retornado
	 * @return Lista contendo os hits mapeados para objeto
	 */
	public static <T extends BaseEsDocument> List<T> mapperHits(SearchHits hits, Class<T> cls) {
		List<T> result = new ArrayList<>();
		for (SearchHit hit : hits) {
			result.add(mapperHit(hit, cls));
		}
		return Collections.unmodifiableList(result);
	}
	
	/**
	 * Prepara o documento para ser incluído no índice<br>
	 * Após o documento ter sido preparado não qualquer alteração realizada, não terá efeito no
	 * nos dados a serem indexados
	 * 
	 * @param indexRequest Index request a ser utilizado para inclusão do objeto no índice
	 * @param doc Documento a ser incluído no índice
	 */
	public static <T extends BaseEsDocument> void source(IndexRequest indexRequest, T doc) {
		indexRequest.id(doc.getId());
		BeanMap beanMap = new BeanMap(doc);
		Map<String, Object> docData = new HashMap<String, Object>();
		beanMap.entrySet().forEach(e -> {
			String key = e.getKey().toString();
			Object value = e.getValue();
			if (!ES_EXCLUDED_FIELDS.contains(key)) {
				docData.put(key, value);
			}
		});
		indexRequest.source(docData, XContentType.JSON);
	}
	
	/**
	 * Cria uma requisção para inclusão de documento no índice do elasticsearch
	 * @param index Nome do indice
	 * @param type Tipo do documento no indice
	 * @param doc Documento a ser incluído no índice
	 * @return Requisição para inclusão de documento no índice do elasticsearch
	 */
	public static <T extends BaseEsDocument> IndexRequest createIndexRequestForDoc(String index, String type, T doc) {
		IndexRequest indexRequest = new IndexRequest(index, type);
		source(indexRequest, doc);
		return indexRequest;
	}
	
}
