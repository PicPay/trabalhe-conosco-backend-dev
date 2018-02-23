/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.picpay.demo.repository;

import com.picpay.demo.core.Credentials;
import org.springframework.data.repository.CrudRepository;

/**
 *
 * @author Carlos Eduardo
 */
public interface CredentialsRepository extends CrudRepository<Credentials, String> {

}
