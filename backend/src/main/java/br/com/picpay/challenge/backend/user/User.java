package br.com.picpay.challenge.backend.user;

import br.com.picpay.challenge.backend.es.support.BaseEsDocument;

/**
 * Representa um usuário no índice do elastic search (ES)
 * 
 * @author francofabio
 *
 */
public class User extends BaseEsDocument {
	private String name;
	private String username;
	private Integer priority;
	
	public User() { }
	
	public User(String id, String name, String username, Integer priority) {
		this.id = id;
		this.name = name;
		this.username = username;
		this.priority = priority;
	}
	
	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getUsername() {
		return username;
	}

	public void setUsername(String username) {
		this.username = username;
	}

	public Integer getPriority() {
		return priority;
	}

	public void setPriority(Integer priority) {
		this.priority = priority;
	}

}
