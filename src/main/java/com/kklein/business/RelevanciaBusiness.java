package com.kklein.business;

import java.util.HashMap;
import java.util.List;

import com.kklein.bean.Relevancia;

public class RelevanciaBusiness extends AbstractBusiness {

	
	public HashMap<String,Integer> listaRelevanciaMap(List<Relevancia> lista){
		HashMap<String,Integer> lista_relevancia = new HashMap<>();
		
		try {
			for (Relevancia relevancia : lista)
				lista_relevancia.put(relevancia.getRelDsCodigo(), relevancia.getRelFlNivelRelevancia());	
		} catch (Exception e) {
			return null;
		}
		
		return lista_relevancia;
	}
}
