/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.picpay.demo.controller;

import com.picpay.demo.security.JwtCredentialsRequest;
import com.picpay.demo.service.AuthService;
import java.util.HashMap;
import java.util.Map;
import org.springframework.beans.factory.annotation.Autowired;
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
@RequestMapping("/auth")
public class AuthRestController {

    @Autowired
    private AuthService authService;

    @RequestMapping(method = RequestMethod.POST, consumes = "application/json", produces = "application/json")
    public Map<String, String> authenticate(@RequestBody JwtCredentialsRequest jwtCredentialsRequest) throws AuthenticationException {
        Map<String, String> map = new HashMap<>();
        String token = authService.authenticate(jwtCredentialsRequest);
        map.put("token", token);

        return map;
    }
}
