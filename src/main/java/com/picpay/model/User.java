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
	private String Id;
	private String name;
	private String username;

	private User() {}

	public User(String Id, String name, String username) {
		this.Id = Id;
		this.name = name;
		this.username = username;
	}
}
// end::code[]