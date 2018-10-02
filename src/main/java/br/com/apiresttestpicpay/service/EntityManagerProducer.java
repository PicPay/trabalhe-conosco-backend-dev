/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package br.com.apiresttestpicpay.service;

import javax.enterprise.context.ApplicationScoped;
import javax.enterprise.context.RequestScoped;
import javax.enterprise.inject.Produces;
import javax.persistence.EntityManager;
import javax.persistence.PersistenceContext;

/**
 *
 * @author guita
 */
@ApplicationScoped
public class EntityManagerProducer {

    @PersistenceContext(unitName="picpayPU")
    private EntityManager entityManager;

    @Produces
    @RequestScoped
    public EntityManager getEntityManager() {
        return entityManager;
    }

}
