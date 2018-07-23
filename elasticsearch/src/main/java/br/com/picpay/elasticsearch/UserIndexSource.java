package br.com.picpay.elasticsearch;

import java.util.HashMap;
import java.util.Map;

import org.cactoos.Scalar;

import br.com.picpay.trabalheconosco.api.User;

public class UserIndexSource implements Scalar<Map<String, Object>> {

	private final User user;
	
	private final int relevance;

	public UserIndexSource(User user, int relevance) {
		this.user = user;
		this.relevance = relevance;
	}

	@Override
	public Map<String, Object> value() throws Exception {
		Map<String, Object> map = new HashMap<>();
		map.put("name", this.user.name());
		map.put("username", this.user.username());
		map.put("relevance", this.relevance);
		map.put("name_lower", this.user.name().toLowerCase());
		map.put("username_lower", this.user.username().toLowerCase());

		return map;
	}

}
