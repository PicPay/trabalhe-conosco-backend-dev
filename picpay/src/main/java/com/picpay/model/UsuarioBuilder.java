package com.picpay.model;

import java.util.Optional;

public class UsuarioBuilder {

	private String id;
	private String nome;
	private String username;
	private RelevanciaBusca relevanciaBusca;
	
	private void resetValues() {
		id = null;
		nome = null;
		username = null;
		relevanciaBusca =  null;
	}
	
	public UsuarioBuilder comNomeEUserName(String nome, String username) {
		this.nome = nome;
		this.username = username;
		return this;
	}
	
	public UsuarioBuilder comId(String id) {
		this.id = id;
		return this;
	}
	
	public UsuarioBuilder comRelevanciaBusca( RelevanciaBusca relevanciaBusca) {
		this.relevanciaBusca = relevanciaBusca;
		return this;
	}
	
	public Usuario build() {
		
		Optional<RelevanciaBusca> ofNullable = Optional.ofNullable(relevanciaBusca);
		Usuario usuario = new Usuario(id, nome, username, ofNullable.orElse(new RelevanciaBusca(0)));
		resetValues();
		return usuario;
	}
}
