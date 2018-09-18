package com.picpay.model;

import lombok.Data;
import javax.persistence.Entity;
import javax.persistence.Id;

/**
 * @author Bruno Carreira
 */
// tag::code[]
@Data
@Entity
public class User {
	@Id
	private String id;
	private String name;
	private String username;

	private User() {}

	public User(String id, String name, String username) {
		this.id = id;
		this.name = name;
		this.username = username;
	}
}
// end::code[]