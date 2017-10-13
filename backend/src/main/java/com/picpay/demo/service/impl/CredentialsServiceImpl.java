/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.picpay.demo.service.impl;

import com.picpay.demo.core.Credentials;
import com.picpay.demo.repository.CredentialsRepository;
import com.picpay.demo.service.CredentialsService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Component;

/**
 *
 * @author Carlos Eduardo
 */
@Component("credentialsService")
public class CredentialsServiceImpl implements CredentialsService {

    @Autowired
    private CredentialsRepository credentialsRepository;

    @Autowired
    private PasswordEncoder passwordEncoder;

    private void validateCredentials(String username) throws Exception {
        if (credentialsRepository.exists(username)) {
            throw new Exception("Este username já está sendo utilizado. Tente outro.");
        }
    }

    @Override
    public void signup(Credentials credentials) throws Exception {
        validateCredentials(credentials.getUsername());

        String encodedPass = passwordEncoder.encode(credentials.getPassword());
        credentials.setPassword(encodedPass);

        credentialsRepository.save(credentials);
    }

}
