package com.picpay.repository;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.mongodb.repository.MongoRepository;

import com.picpay.model.User;

public interface UserMongoRepository extends MongoRepository<User,String>{

	Page<User> findAllOrderByOrderByRelevanceDescNameAsc(Pageable page);
	
	Page<User> findByNameContainingIgnoreCaseOrderByRelevanceDescNameAsc(String name,Pageable page);
	Page<User> findByNameStartingWithIgnoreCaseOrderByRelevanceDescNameAsc(String name,Pageable page);
	Page<User> findByUsernameContainingIgnoreCaseOrderByRelevanceDescNameAsc(String username,Pageable page);
	Page<User> findByIdStartingWithIgnoreCaseOrderByRelevanceDescNameAsc(String id,Pageable page);
	Page<User> findByNameContainingAndUsernameContainingAllIgnoreCase(String name, String username,Pageable page);
	
}