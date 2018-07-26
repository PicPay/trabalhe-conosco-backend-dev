package br.com.picpay.elasticsearch;

import static org.elasticsearch.index.query.QueryBuilders.boolQuery;
import static org.elasticsearch.index.query.QueryBuilders.queryStringQuery;

import org.cactoos.Scalar;
import org.elasticsearch.index.query.QueryBuilder;

public class UserSearchQueryBuilder implements Scalar<QueryBuilder>{

	private final String keyWord;

	public UserSearchQueryBuilder(String keyWord) {
		this.keyWord = keyWord;
	}

	public QueryBuilder value() {
		return boolQuery()
				.should(queryStringQuery(username()))
				.should(queryStringQuery(name()));
	}

	private String name() {
		return new StringBuilder().append("name_lower:").append("*").append(this.keyWord.toLowerCase()).append("*").toString();
	}

	private String username() {
		return new StringBuilder().append("username_lower:").append("*").append(this.keyWord.toLowerCase()).append("*").toString();
	}

}
