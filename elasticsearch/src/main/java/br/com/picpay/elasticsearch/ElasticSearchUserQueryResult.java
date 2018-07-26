package br.com.picpay.elasticsearch;

import java.util.Arrays;
import java.util.stream.Stream;

import org.elasticsearch.action.search.SearchResponse;

import br.com.picpay.trabalheconosco.api.User;
import br.com.picpay.trabalheconosco.api.UserQueryResult;

public class ElasticSearchUserQueryResult implements UserQueryResult {

	private final SearchResponse searchResponse;

	public ElasticSearchUserQueryResult(SearchResponse searchResponse) {
		this.searchResponse = searchResponse;
	}
	
	@Override
	public long total() {
		return this.searchResponse.getHits().getTotalHits();
	}

	@Override
	public Stream<User> users() {
		return Arrays.stream(this.searchResponse.getHits().getHits()).map(h -> new UserFromHit(h));
	}
	
	

}
