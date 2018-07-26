package br.com.picpay.elasticsearch;

import org.cactoos.Scalar;
import org.elasticsearch.action.search.SearchRequest;

public class UserQuerySearchRequest implements Scalar<SearchRequest> {

	private final String keyWord;
	private final int page;
	private final int pageSize;

	public UserQuerySearchRequest(String keyWord, int page, int pageSize) {
		this.keyWord = keyWord;
		this.page = page;
		this.pageSize = pageSize;
	}

	@Override
	public SearchRequest value() throws Exception {
		return new SearchRequest(ElasticSearchUserIndex.USERS_INDEX_NAME)
				.source(
						new UserQuerySearchRequestSourceBuilder(
								this.keyWord, 
								this.page, 
								this.pageSize)
						.value());
	}
}
