package com.picpay.service;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import com.picpay.model.User;
import com.picpay.repository.UserFileRepository;
import com.picpay.repository.UserFilter;

@Service
public class UserFileService implements UserService{

	private UserFileRepository repository;
	
	@Autowired
	public UserFileService( @Qualifier("prod") UserFileRepository repository) {
		super();
		this.repository = repository;
	}

	@Override
	public Page<User> findUsers(UserFilter filter,Pageable page) {
		List<User> users = repository.findUser(page.getPageNumber(),0);
		Page<User> usersPage = new PageImpl<>(users, page, users.size());
		return usersPage;
	}
}