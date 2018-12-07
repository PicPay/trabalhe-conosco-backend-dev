package com.picpay.service;

import java.util.Arrays;
import java.util.Collections;
import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import com.picpay.model.Usuario;
import com.picpay.repository.UsuarioFilter;
import com.picpay.repository.UsuarioMongoRepository;

@Service
public class UsuarioMongoService implements UsuarioService {

	private UsuarioMongoRepository repository;
	
	@Autowired
	public UsuarioMongoService(UsuarioMongoRepository repository) {
		super();
		this.repository = repository;
	}

	@Override
	public Page<Usuario> buscarUsuarios(UsuarioFilter filter,Pageable page) {
		
		boolean filteredNome = filter.isFilteredNome();
		boolean filteredId = filter.isFilteredId();
		boolean filteredUserName = filter.isFilteredUserName();
		
		String nome = filter.getNome();
		String username = filter.getUsername();
		String id = filter.getId();
		
		
		if(filteredNome && filteredUserName && filteredId)
			return repository.findByNomeStartingWithAndUsernameStartingWithAndIdAllIgnoreCase(nome, username, id, page);
		else if (filteredNome && filteredUserName)
			return repository.findByNomeStartingWithAndUsernameStartingWithAllIgnoreCase(nome, username, page);
		else if(filteredId)
			return findById(id);
		else if(filteredNome)
			return repository.findByNomeStartingWithIgnoreCaseOrderByRelevanciaDescNomeAsc(nome, page);
		else if(filteredUserName)
			return repository.findByUsernameStartingWithIgnoreCaseOrderByRelevanciaDescNomeAsc(username, page);
		else
			return repository.findByNomeStartingWithIgnoreCaseOrderByRelevanciaDescNomeAsc("a", page);
		
		
	}
	
	private Page<Usuario> findById(String id) {
		Optional<Usuario> findById = repository.findById(id);
		
		if(findById.isPresent())
			return  new PageImpl<>(Arrays.asList(findById.get()));
		else
			return  new PageImpl<>(Collections.emptyList());
	}
}
