package com.tmontovaneli.challenge.model;

import java.io.Serializable;

import com.fasterxml.jackson.annotation.JsonIgnoreProperties;

import net.sf.jsefa.csv.annotation.CsvDataType;
import net.sf.jsefa.csv.annotation.CsvField;

@CsvDataType()
@JsonIgnoreProperties(ignoreUnknown = true)
public class User implements Serializable {

	@CsvField(pos = 1)
	private String id;

	@CsvField(pos = 2)
	private String nome;

	@CsvField(pos = 3)
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
