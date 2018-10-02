package com.picpay.api.services.Impl;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Sort.Direction;
import org.springframework.stereotype.Service;

import com.picpay.api.documents.User;
import com.picpay.api.repository.UserRepository;
import com.picpay.api.services.UserService;

@Service
public class UserServiceImpl implements UserService {

	@Autowired
	private UserRepository userRepository;
	
	@Override
	public Page<User> findByNomeAndUsername(String termo, int page) {
		return this.userRepository.findByNomeAndUsername(termo, PageRequest.of(page, 15, Direction.ASC, "prioridade", "nome"));
	}

}
