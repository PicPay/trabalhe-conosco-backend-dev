package com.picpay.model;

public class RelevanciaBusca implements Comparable<RelevanciaBusca> {

	private Integer nivel;
	
	public RelevanciaBusca(Integer nivel) {
		super();
		this.nivel = nivel;
	}

	public Integer getNivel() {
		return nivel;
	}

	public void setNivel(Integer nivel) {
		this.nivel = nivel;
	}

	@Override
	public int compareTo(RelevanciaBusca o) {
		return Integer.compare(getNivel(),o.getNivel());
	}
}
