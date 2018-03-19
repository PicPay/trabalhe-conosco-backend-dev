package com.kklein.business;

import javax.persistence.EntityManager;
import javax.persistence.EntityTransaction;

import com.kklein.hibernate.ConnectionFactory;

public abstract class AbstractBusiness implements Business {
	private EntityManager entityManager;

	public EntityTransaction entityTransaction;


	private void close(final EntityManager entityManager) {
		
			if (entityManager != null && entityManager.isOpen())
				entityManager.close();
		
	}

	private void rollback(final EntityManager entityManager) {
			if (entityManager != null && entityManager.getTransaction().isActive())
				entityManager.getTransaction().rollback();
	}

	public void beginTransaction() {
		if (!(entityTransaction = getEntityManager().getTransaction()).isActive())
			entityTransaction.begin();
	}

	public void commitTransaction() {
		if (entityManager.getTransaction().isActive())
			entityManager.getTransaction().commit();
	}

	public EntityManager getEntityManager() {
		return entityManager == null || !entityManager.isOpen() ? entityManager = ConnectionFactory.getConnection()
				: entityManager;
	}

	public void setEntityManager(final EntityManager entityManager) {
		this.entityManager = entityManager;
	}

}