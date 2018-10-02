package com.picpay.api.repository;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.mongodb.repository.MongoRepository;
import org.springframework.data.mongodb.repository.Query;

import com.picpay.api.documents.User;

public interface UserRepository extends MongoRepository<User, String>{

	@Query("{ $or : [{'nome': { $regex : ?0, $options : 'i'}}, {'username': { $regex : ?0, $options : 'i'} } ]}")
	Page<User> findByNomeAndUsername(String termo, Pageable page);
}
