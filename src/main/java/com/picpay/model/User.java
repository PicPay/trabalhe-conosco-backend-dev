package com.picpay.model;

import lombok.Data;
import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.Table;

/**
 * @author Bruno Carreira
 */
// tag::code[]
@Data
@Entity
@Table(name = "tb_user")
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