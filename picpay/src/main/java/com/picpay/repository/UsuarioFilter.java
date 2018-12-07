package com.picpay.repository;

public class UsuarioFilter {

	private String id;
	private String nome;
	private String username;
	
	public UsuarioFilter() {}
	
	public String getId() {
		return id;
	}
	public void setId(String id) {
		this.id = id;
	}
	public String getNome() {
		return nome;
	}
	public void setNome(String nome) {
		this.nome = nome;
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
	
	public boolean isFilteredNome() {
		return nome != null && !"".equals(nome.trim());
	}
	
	public boolean isFilteredUserName() {
		return username != null && !"".equals(username.trim());
	}
}