package com.kklein.dao;

import java.util.List;

import javax.persistence.EntityManager;

import com.kklein.bean.Relevancia;

public class RelevanciaDao extends AbstractJpaDao<Relevancia> {

	public RelevanciaDao(EntityManager entityManager) {
		super(entityManager);
	}

	
	public List<?> consultaListaRelevancia(final int nivel) throws Exception {
		StringBuilder sql = new StringBuilder();
		sql.append(" SELECT rel ")
		   .append(" from Relevancia rel ");
		
		if(nivel > 0) {
			sql.append(" where rel.relFlNivel = " + nivel);	
		}
		
		return getList(sql.toString());
	}
}
