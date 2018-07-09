package br.com.picpay.challenge.backend.auth;

import javax.validation.constraints.NotBlank;
import javax.validation.constraints.Size;

public class UserAuthData {
	
	@NotBlank(message = "Informe o nome do usuário")
	protected String name;
	
	@NotBlank(message = "Informe o nome de usuário")
	@Size(min=3, max=40, message="O nome de usuário (username) deve ter entre 3 e 40 caracteres")
	protected String username;

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getUsername() {
		return username;
	}

	public void setUsername(String username) {
		this.username = username;
	}
}
