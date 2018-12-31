package com.picpay.repository;

import java.io.Serializable;

public class UserFilter implements Serializable {

	private String id;
	private String name;
	private String username;
	
	public UserFilter() {}
	
	public String getId() {
		return id;
	}
	public void setId(String id) {
		this.id = id;
	}
	public String getName() {
		return name;
	}
	public void setName(String nome) {
		this.name = nome;
	}
	public String getUsername() {
		return username;
	}
	public void setUsername(String username) {
		this.username = username;
	}
	
	public boolean isFilteredId() {
		return id != null && !"".equals(id.trim());
	}
	
	public boolean isFilteredName() {
		return name != null && !"".equals(name.trim());
	}
	
	public boolean isFilteredUserName() {
		return username != null && !"".equals(username.trim());
	}
}