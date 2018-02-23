/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.picpay.demo.controller;

import com.picpay.demo.core.Credentials;
import com.picpay.demo.service.CredentialsService;
import javax.validation.Valid;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.security.core.AuthenticationException;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;

/**
 *
 * @author Carlos Eduardo
 */
@RestController
@RequestMapping("/signup")
public class CredentialsRestController {

    @Autowired
    private CredentialsService credentialsService;

    @RequestMapping(method = RequestMethod.POST, consumes = "application/json", produces = "application/json")
    public ResponseEntity authenticate(@Valid @RequestBody Credentials credentials) throws AuthenticationException, Exception {
        credentialsService.signup(credentials);

        return ResponseEntity.ok().build();
    }
}
