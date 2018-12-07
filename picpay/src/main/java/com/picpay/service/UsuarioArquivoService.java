package com.picpay.service;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import com.picpay.model.Usuario;
import com.picpay.repository.UsuarioArquivoRepository;
import com.picpay.repository.UsuarioFilter;

@Service
public class UsuarioArquivoService implements UsuarioService{

	private UsuarioArquivoRepository repository;
	
	@Autowired
	public UsuarioArquivoService( @Qualifier("prod") UsuarioArquivoRepository repository) {
		super();
		this.repository = repository;
	}

	@Override
	public Page<Usuario> buscarUsuarios(UsuarioFilter filter,Pageable page) {
		List<Usuario> usuarios = repository.buscarUusuario(page.getPageNumber(),0);
		Page<Usuario> pageUsuarios = new PageImpl<>(usuarios, page, usuarios.size());
		return pageUsuarios;
	}
}
