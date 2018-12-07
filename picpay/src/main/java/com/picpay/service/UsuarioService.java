package com.picpay.service;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import com.picpay.model.Usuario;
import com.picpay.repository.UsuarioFilter;

public interface UsuarioService {

	public Page<Usuario> buscarUsuarios(UsuarioFilter filter,Pageable page);
}

