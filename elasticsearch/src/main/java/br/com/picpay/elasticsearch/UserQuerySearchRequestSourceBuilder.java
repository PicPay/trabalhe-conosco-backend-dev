package br.com.picpay.elasticsearch;

import org.cactoos.Scalar;
import org.elasticsearch.search.builder.SearchSourceBuilder;
import org.elasticsearch.search.sort.SortOrder;

public class UserQuerySearchRequestSourceBuilder implements Scalar<SearchSourceBuilder>{

	private final String keyWord;
	private final int page;
	private final int pageSize;

	public UserQuerySearchRequestSourceBuilder(String keyWord, int page, int pageSize) {
		this.keyWord = keyWord;
		this.page = page;
		this.pageSize = pageSize;
	}

	@Override
	public SearchSourceBuilder value() throws Exception{
		return new SearchSourceBuilder()
				.query(new UserSearchQueryBuilder(this.keyWord).value())
				.from(this.page * this.pageSize)
				.size(this.pageSize)
				.sort("relevance", SortOrder.DESC);
	}

}
