package com.picpay.service;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import com.picpay.model.User;
import com.picpay.repository.UserFilter;

public interface UserService {

	public Page<User> findUsers(UserFilter filter,Pageable page);
}
