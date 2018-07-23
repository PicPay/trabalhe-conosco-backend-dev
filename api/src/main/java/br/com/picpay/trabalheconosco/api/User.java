package br.com.picpay.trabalheconosco.api;

import com.fasterxml.jackson.annotation.JsonProperty;

public interface User {
	String id();

	String name();

	String username();

	public static class Fixed implements User {
		
		private final String username;

		private final String name;
		
		private final String id;

		public Fixed(String id, String name, String username) {
			this.id = id;
			this.name = name;
			this.username = username;
		}

		
		@JsonProperty("id")
		public String id() {
			return this.id;
		}

		@JsonProperty("name")
		public String name() {
			return this.name;
		}

		@JsonProperty("username")
		public String username() {
			return this.username;
		}
	}
}
