package com.kklein.dao;

import java.util.ArrayList;

import javax.persistence.EntityManager;

public abstract class AbstractDao {
	
	protected EntityManager entityManager;

	public AbstractDao(final EntityManager entityManager) {
		this.entityManager = entityManager;
	}
	
	
	@SuppressWarnings("unchecked")
	protected <T> ArrayList<T> getListSqlNativo(final CharSequence sql) {
		return (ArrayList<T>) entityManager.createNativeQuery(sql.toString()).getResultList();
	}

	@SuppressWarnings("unchecked")
	protected <T> ArrayList<T> getListSqlNativo(final CharSequence sql, final Class<T> classeRetorno) {
		return (ArrayList<T>) getListSqlNativo(sql);
	}

	@SuppressWarnings("unchecked")
	protected <T> T getSingleSqlNativo(final CharSequence sql) {
		return (T) entityManager.createNativeQuery(sql.toString()).getSingleResult();
	}

	@SuppressWarnings("unchecked")
	protected <T> T getSingleSqlNativo(final CharSequence sql, final Class<T> classeRetorno) {
		return (T) getSingleSqlNativo(sql);
	}

	protected int executeQuery(final CharSequence sql) {
		return entityManager.createQuery(sql.toString()).executeUpdate();
	}

	protected int executeQueryNativo(final CharSequence sql) {
		return entityManager.createNativeQuery(sql.toString()).executeUpdate();
	}

	protected Object getSingleResult(final CharSequence sql) {
		return entityManager.createQuery(sql.toString()).getSingleResult();
	}

	@SuppressWarnings("unchecked")
	protected <T> T getSingleResult(final CharSequence sql, final Class<T> classeRetorno) {
		return (T) getSingleResult(sql);
	}

	protected ArrayList<?> getList(final CharSequence sql) {
		return (ArrayList<?>) entityManager.createQuery(sql.toString()).getResultList();
	}

	@SuppressWarnings("unchecked")
	protected <T> ArrayList<T> getList(final CharSequence sql, final Class<T> classeRetorno) {
		return (ArrayList<T>) getList(sql);
	}

	@SuppressWarnings("unchecked")
	protected <T> ArrayList<T> getList(final CharSequence sql, final int limit) {
		return (ArrayList<T>) entityManager.createQuery(sql.toString()).setMaxResults(limit).getResultList();
	}

	@SuppressWarnings("unchecked")
	protected <T> ArrayList<T> getList(final CharSequence sql, final int limit, final int primeiroItem) {
		return (ArrayList<T>) entityManager.createQuery(sql.toString()).setMaxResults(limit).setFirstResult(primeiroItem).getResultList();
	}
	
}
