/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.picpay.demo.service;

import com.picpay.demo.core.Credentials;

/**
 *
 * @author Carlos Eduardo
 */
public interface CredentialsService {

    void signup(Credentials credentials) throws Exception;
}
