/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.picpay.demo.service;

import com.picpay.demo.core.Credentials;
import com.picpay.demo.security.JwtCredentialsRequest;

/**
 *
 * @author Carlos Eduardo
 */
public interface AuthService {

    String authenticate(JwtCredentialsRequest jwtCredentialsRequest);

}
