package com.kklein.business;

import javax.persistence.EntityManager;

public interface Business {
	EntityManager getEntityManager();
	void beginTransaction();
	void commitTransaction();
}
