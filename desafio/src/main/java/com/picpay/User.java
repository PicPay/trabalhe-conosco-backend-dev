package com.picpay;

public class User {
	
	private String id;
	private String nome;
	private String login;
	private transient int ordem;
	
	public User(String id, String nome, String login) {
		this.id=id;
		this.nome=nome;
		this.login=login;
		this.setOrdem(3);
	}
	
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
	
	public String getLogin() {
		return login;
	}
	
	public void setLogin(String login) {
		this.login = login;
	}

	public int getOrdem() {
		return ordem;
	}

	public void setOrdem(int ordem) {
		this.ordem = ordem;
	}
}
