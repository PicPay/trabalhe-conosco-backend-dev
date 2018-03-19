package com.kklein.hibernate;

import javax.persistence.EntityManager;

public class ConnectionFactory {
	public static EntityManager getConnection() {
		try {
			return ConnectionJdbc.getEntityManagerFactory().createEntityManager();
		} catch (final Throwable e) {
			throw new RuntimeException("Erro ao abrir conexao!");
		}
	}
}
