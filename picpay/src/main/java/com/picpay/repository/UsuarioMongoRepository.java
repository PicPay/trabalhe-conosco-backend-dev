package com.picpay.repository;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.mongodb.repository.MongoRepository;

import com.picpay.model.Usuario;

public interface UsuarioMongoRepository extends MongoRepository<Usuario,String>{

	Page<Usuario> findAllOrderByOrderByRelevanciaDescNomeAsc(Pageable page);
	
	Page<Usuario> findByNomeStartingWithIgnoreCaseOrderByRelevanciaDescNomeAsc(String nome,Pageable page);
	Page<Usuario> findByUsernameStartingWithIgnoreCaseOrderByRelevanciaDescNomeAsc(String username,Pageable page);
	Page<Usuario> findByIdStartingWithIgnoreCaseOrderByRelevanciaDescNomeAsc(String id,Pageable page);
	
	Page<Usuario> findByNomeStartingWithAndUsernameStartingWithAllIgnoreCase(String nome, String username,Pageable page);
	Page<Usuario> findByNomeStartingWithAndUsernameStartingWithAndIdAllIgnoreCase(String nome, String username , String id ,Pageable page);
	
}
