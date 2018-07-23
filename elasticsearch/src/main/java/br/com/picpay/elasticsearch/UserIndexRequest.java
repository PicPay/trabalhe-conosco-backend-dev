package br.com.picpay.elasticsearch;

import org.cactoos.Scalar;
import org.elasticsearch.action.index.IndexRequest;

import br.com.picpay.trabalheconosco.api.User;

public class UserIndexRequest implements Scalar<IndexRequest>{

	private final User user;
	private final String indexName;
	private final String type;
	private final int relevance;

	public UserIndexRequest(User user, int relevance, String indexName, String type) {
		this.user = user;
		this.relevance = relevance;
		this.indexName = indexName;
		this.type = type;
	}
	
	@Override
	public IndexRequest value() throws Exception {
		return 
				new IndexRequest(
						this.indexName, 
						this.type, 
						this.user.id())
				.source(
						new UserIndexSource(
								this.user, 
								this.relevance)
						.value());
	}
}
