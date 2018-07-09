package br.com.picpay.challenge.backend.user;

import com.fasterxml.jackson.annotation.JsonAlias;

public class SearchRequest {

	@JsonAlias("q")
	private String term;
	private String navRef;
	private String direction;
	private int pageSize;

	public SearchRequest() {
		this.direction = "next";
		this.pageSize = 15;
	}
	
	public String getTerm() {
		return term;
	}

	public void setTerm(String term) {
		this.term = term;
	}

	public String getNavRef() {
		return navRef;
	}

	public void setNavRef(String navRef) {
		this.navRef = navRef;
	}

	public String getDirection() {
		return direction;
	}

	public void setDirection(String direction) {
		this.direction = direction;
	}

	public int getPageSize() {
		return pageSize;
	}

	public void setPageSize(int pageSize) {
		this.pageSize = pageSize;
	}
	
}
