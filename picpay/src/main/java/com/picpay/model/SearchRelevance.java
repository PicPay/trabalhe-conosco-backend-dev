package com.picpay.model;

public class SearchRelevance implements Comparable<SearchRelevance> {

	private Integer level;
	
	public SearchRelevance(Integer level) {
		super();
		this.level = level;
	}

	public Integer getLevel() {
		return level;
	}

	public void setNivel(Integer nivel) {
		this.level = nivel;
	}

	@Override
	public int compareTo(SearchRelevance o) {
		return Integer.compare(getLevel(),o.getLevel());
	}
}