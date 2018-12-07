package com.picpay.model;

import java.io.Serializable;

import org.springframework.data.annotation.Id;
import org.springframework.data.annotation.PersistenceConstructor;
import org.springframework.data.mongodb.core.index.CompoundIndex;
import org.springframework.data.mongodb.core.index.CompoundIndexes;
import org.springframework.data.mongodb.core.mapping.Document;

@Document
@CompoundIndexes(value = { 
	@CompoundIndex(def = "{'relevancia.nivel' : -1, 'nome': 1 , 'username' : 1}") 
})
public class Usuario implements Serializable {
	
	@Id
	private String id;
	
	private String nome;
	
	private String username;

	private RelevanciaBusca relevancia;
	
	Usuario() {}
	
	@PersistenceConstructor
	public Usuario(String id, String nome, String username, RelevanciaBusca relevancia) {
		super();
		this.id = id;
		this.nome = nome;
		this.username = username;
		this.relevancia = relevancia;
	}

	public String getId() {
		return id;
	}

	public String getNome() {
		return nome;
	}

	public String getUsername() {
		return username;
	}

	public RelevanciaBusca getRelevancia() {
		return relevancia;
	}

	@Override
	public int hashCode() {
		final int prime = 31;
		int result = 1;
		result = prime * result + ((id == null) ? 0 : id.hashCode());
		result = prime * result + ((nome == null) ? 0 : nome.hashCode());
		result = prime * result + ((username == null) ? 0 : username.hashCode());
		return result;
	}

	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		Usuario other = (Usuario) obj;
		if (id == null) {
			if (other.id != null)
				return false;
		} else if (!id.equals(other.id))
			return false;
		if (nome == null) {
			if (other.nome != null)
				return false;
		} else if (!nome.equals(other.nome))
			return false;
		if (username == null) {
			if (other.username != null)
				return false;
		} else if (!username.equals(other.username))
			return false;
		return true;
	}

	@Override
	public String toString() {
		return "Usuario [id=" + id + ", nome=" + nome + ", username=" + username + "]";
	}
}
