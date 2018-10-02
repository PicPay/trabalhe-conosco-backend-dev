package com.picpay.api.services;

import org.springframework.data.domain.Page;

import com.picpay.api.documents.User;

public interface UserService {

	Page<User> findByNomeAndUsername(String termo, int page);
}
