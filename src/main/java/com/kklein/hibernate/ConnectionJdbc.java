package com.kklein.hibernate;

import javax.persistence.EntityManagerFactory;
import javax.persistence.Persistence;

public class ConnectionJdbc {
	private static final EntityManagerFactory entityManagerFactory = Persistence.createEntityManagerFactory("picpay");

	public static EntityManagerFactory getEntityManagerFactory() {
		return entityManagerFactory;
	}
}
