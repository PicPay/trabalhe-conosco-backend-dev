package br.com.picpay.elasticsearch;

import java.io.IOException;

import org.elasticsearch.client.RestHighLevelClient;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import br.com.picpay.trabalheconosco.api.User;
import br.com.picpay.trabalheconosco.api.UserIndex;
import br.com.picpay.trabalheconosco.api.UserQueryResult;

public class ElasticSearchUserIndex implements UserIndex {

	public static final String USERS_INDEX_NAME = "users";

	private static final Logger LOGGER = LoggerFactory.getLogger(ElasticSearchUserIndex.class);

	private final RestHighLevelClient client;

	public ElasticSearchUserIndex(RestHighLevelClient client) {
		this.client = client;
	}

	public UserQueryResult query(String keyWord, int page, int pageSize) throws Exception{
		return 
				new ElasticSearchUserQueryResult(
						this.client.search(
								new UserQuerySearchRequest(keyWord, page, pageSize).value()));
	}

	public void put(User user, int relevance) throws Exception {
		try {
			this.client.index(new UserIndexRequest(user, relevance, USERS_INDEX_NAME, "default").value());
			if (LOGGER.isDebugEnabled()) {
				LOGGER.debug("User with id: " + user.id() + " indexado com sucesso usando a relevancia: " + relevance);
			}
		} catch (IOException e) {
			throw new RuntimeException("Erro ao indexar user: " + user.id(), e);
		}
	}

}
