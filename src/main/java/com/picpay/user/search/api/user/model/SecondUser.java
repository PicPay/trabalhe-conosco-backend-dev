package com.picpay.user.search.api.user.model;

import javax.persistence.Entity;
import javax.persistence.Id;

@Entity
public class SecondUser {

	@Id
	private String id;

	public String getId() {
		return id;
	}
}