package com.kklein.dao;

import java.io.Serializable;
import java.util.List;

import javax.persistence.EntityManager;

import com.google.common.reflect.TypeToken;
import com.kklein.bean.Bean;

public abstract class AbstractJpaDao<T extends Bean> extends AbstractDao {

	private final Class<T> classe;
	
	public AbstractJpaDao(EntityManager entityManager) {
		super(entityManager);
		classe = (Class<T>) new TypeToken<T>(getClass()) {
		}.getType();
	}

	public T incluir(final T object) {
		entityManager.persist(object);
		return object;
	}

	public T alterar(final T object) {
		return entityManager.merge(object);
	}

	public void excluir(final T object) {
		if (object == null)
			return;

		entityManager.remove(object);
	}

	public T read(final Serializable id) {
		if (id == null)
			return null;

		final T objeto = entityManager.find(classe, id);

		if (objeto == null)
			return null;

		objeto.setObjectClone(objeto.clone());

		return objeto;
	}
	
	protected List<T> getListChecked(final CharSequence sql) {
		return getList(sql, classe);
	}

	@SuppressWarnings("unchecked")
	protected T getSingleResultChecked(final CharSequence sql) {
		return (T) getSingleResult(sql);
	}
}
