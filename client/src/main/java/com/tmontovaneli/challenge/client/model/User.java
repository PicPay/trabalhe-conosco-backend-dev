package com.tmontovaneli.challenge.client.model;

import java.io.Serializable;

import com.fasterxml.jackson.annotation.JsonIgnoreProperties;

@JsonIgnoreProperties(ignoreUnknown = true)
public class User implements Serializable {

	private String id;

	private String nome;

	private String apelido;

	public User() {
		super();
	}

	public User(String id, String nome, String apelido) {
		this.id = id;
		this.nome = nome;
		this.apelido = apelido;
	}

	public String getId() {
		return id;
	}

	public String getNome() {
		return nome;
	}

	public String getApelido() {
		return apelido;
	}

	@Override
	public String toString() {
		return "User [id=" + id + ", nome=" + nome + ", apelido=" + apelido + "]";
	}

}
