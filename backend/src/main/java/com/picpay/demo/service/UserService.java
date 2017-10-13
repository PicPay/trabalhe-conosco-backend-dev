/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.picpay.demo.service;

import com.picpay.demo.core.User;
import org.springframework.data.domain.Page;

/**
 *
 * @author Carlos Eduardo
 */
public interface UserService {

    Page<User> search(String keyword, int page, int pageSize);
}
