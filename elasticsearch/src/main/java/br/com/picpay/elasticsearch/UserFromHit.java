package br.com.picpay.elasticsearch;

import org.elasticsearch.search.SearchHit;

import br.com.picpay.trabalheconosco.api.User;

public class UserFromHit implements User {

	private final User user;

	public UserFromHit(SearchHit h) {
		this.user = new User.Fixed(h.getSourceAsMap().get("id").toString(), h.getSourceAsMap().get("name").toString(),
				h.getSourceAsMap().get("username").toString());
	}

	@Override
	public String id() {
		return this.user.id();
	}

	@Override
	public String name() {
		return this.user.name();
	}

	@Override
	public String username() {
		return this.user.username();
	}

}
