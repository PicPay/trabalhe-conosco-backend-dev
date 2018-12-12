package com.picpay.user.search.api.user.service;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import com.picpay.user.search.api.user.model.User;

public interface UserService {

	Page<User> findByKeyword(String keyword, Pageable pageable);
}