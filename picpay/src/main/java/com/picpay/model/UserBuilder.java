package com.picpay.model;

import java.util.Optional;

public class UserBuilder {

	private String id;
	private String name;
	private String username;
	private SearchRelevance searchRelevance;
	
	private void resetValues() {
		id = null;
		name = null;
		username = null;
		searchRelevance =  null;
	}
	
	public UserBuilder withNameAndUsername(String name, String username) {
		this.name = name;
		this.username = username;
		return this;
	}
	
	public UserBuilder withId(String id) {
		this.id = id;
		return this;
	}
	
	public UserBuilder withSearchRelevance( SearchRelevance searchRelevance) {
		this.searchRelevance = searchRelevance;
		return this;
	}
	
	public User build() {
		
		Optional<SearchRelevance> ofNullable = Optional.ofNullable(searchRelevance);
		User user = new User(id, name, username, ofNullable.orElse(new SearchRelevance(0)));
		resetValues();
		return user;
	}
}