package com.picpay.service;

import java.util.Arrays;
import java.util.Collections;
import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import com.picpay.model.User;
import com.picpay.repository.UserFilter;
import com.picpay.repository.UserMongoRepository;

@Service
public class UserMongoService implements UserService {

	private UserMongoRepository repository;
	
	@Autowired
	public UserMongoService(UserMongoRepository repository) {
		super();
		this.repository = repository;
	}

	@Override
	public Page<User> findUsers(UserFilter filter,Pageable page) {
		
		boolean filteredName = filter.isFilteredName();
		boolean filteredId = filter.isFilteredId();
		boolean filteredUserName = filter.isFilteredUserName();
		
		String name = filter.getName();
		String username = filter.getUsername();
		String id = filter.getId();
		
		
		if (filteredName && filteredUserName)
			return repository.findByNameContainingAndUsernameContainingAllIgnoreCase(name, username, page);
		else if(filteredId)
			return findById(id);
		else if(filteredName)
			return repository.findByNameContainingIgnoreCaseOrderByRelevanceDescNameAsc(name, page);
		else if(filteredUserName)
			return repository.findByUsernameContainingIgnoreCaseOrderByRelevanceDescNameAsc(username, page);
		else
			return repository.findByNameStartingWithIgnoreCaseOrderByRelevanceDescNameAsc("a", page);
		
	}
	
	private Page<User> findById(String id) {
		Optional<User> findById = repository.findById(id);
		
		if(findById.isPresent())
			return  new PageImpl<>(Arrays.asList(findById.get()));
		else
			return  new PageImpl<>(Collections.emptyList());
	}
}