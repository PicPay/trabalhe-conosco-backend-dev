package br.com.picpay.challenge.backend.es.support;

/**
 * Estrutura básica de um documento do elasticsearch
 * 
 * @author francofabio
 *
 */
public class BaseEsDocument {

	protected String id;
	
	public String getId() {
		return id;
	}
	
	public void setId(String id) {
		this.id = id;
	}
	
}
