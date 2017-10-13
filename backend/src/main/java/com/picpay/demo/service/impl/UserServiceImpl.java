/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.picpay.demo.service.impl;

import com.picpay.demo.core.User;
import com.picpay.demo.repository.UserRepository;
import com.picpay.demo.service.UserService;
import java.util.Collection;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Component;

/**
 *
 * @author Carlos Eduardo
 */
@Component
public class UserServiceImpl implements UserService {

    @Autowired
    private UserRepository userRepository;

    @Override
    public Page<User> search(String keyword, int page, int pageSize) {
        return userRepository.search(keyword, new PageRequest(page, pageSize));
    }
}
