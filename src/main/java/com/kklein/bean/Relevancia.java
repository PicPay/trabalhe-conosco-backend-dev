package com.kklein.bean;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;

@Entity
@Table(name="relevancia")
public class Relevancia extends AbstractJpaBean {

	
	@Id
	@Column(name = "rel_cd_relevancia")
	@GeneratedValue(strategy = GenerationType.IDENTITY)
	private long relCdRelevancia;
	
	@Column(name = "rel_ds_codigo")
	private String relDsCodigo;
	
	@Column(name = "rel_fl_nivel_relevancia")
	private int relFlNivelRelevancia;

	public Relevancia() {
	}	
	
	public Relevancia(long relCdRelevancia, String relDsCodigo, int relFlNivelRelevancia) {
		super();
		this.relCdRelevancia = relCdRelevancia;
		this.relDsCodigo = relDsCodigo;
		this.relFlNivelRelevancia = relFlNivelRelevancia;
	}

	public long getRelCdRelevancia() {
		return relCdRelevancia;
	}

	public void setRelCdRelevancia(long relCdRelevancia) {
		this.relCdRelevancia = relCdRelevancia;
	}

	public String getRelDsCodigo() {
		return relDsCodigo;
	}

	public void setRelDsCodigo(String relDsCodigo) {
		this.relDsCodigo = relDsCodigo;
	}

	public int getRelFlNivelRelevancia() {
		return relFlNivelRelevancia;
	}

	public void setRelFlNivelRelevancia(int relFlNivelRelevancia) {
		this.relFlNivelRelevancia = relFlNivelRelevancia;
	}
	
	
	
	
}
