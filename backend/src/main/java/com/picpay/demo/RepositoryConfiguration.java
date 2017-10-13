/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.picpay.demo;

import org.springframework.boot.autoconfigure.EnableAutoConfiguration;
import org.springframework.boot.autoconfigure.domain.EntityScan;
import org.springframework.context.annotation.Configuration;
import org.springframework.data.jpa.repository.config.EnableJpaRepositories;
import org.springframework.transaction.annotation.EnableTransactionManagement;

/**
 *
 * @author Carlos Eduardo
 */
@Configuration
@EnableAutoConfiguration
@EntityScan(basePackages = {"com.picpay.demo.core"})
@EnableJpaRepositories(basePackages = {"com.picpay.demo.repository"})
@EnableTransactionManagement
public class RepositoryConfiguration {
    
}
