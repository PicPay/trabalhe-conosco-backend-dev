package br.com.picpay.challenge.backend.auth;

import javax.validation.constraints.NotBlank;

import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.index.Indexed;
import org.springframework.data.mongodb.core.mapping.Document;

import br.com.picpay.challenge.backend.validation.UniqueApiKey;
import br.com.picpay.challenge.backend.validation.UniqueUsername;

@Document(collection = "users")
public class UserAuth {

	@Id
	private String id;
	@NotBlank(message = "Informe o nome do usuário")
	private String name;
	
	@Indexed(name = "idx_username", unique = true)
	@NotBlank(message = "Informe nome de usuário (username)")
	@UniqueUsername
	private String username;
	
	@Indexed(name = "idx_apiKey", unique = true)
	@UniqueApiKey
	private String apiKey;
	
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

	public String getApiKey() {
		return apiKey;
	}

	public void setApiKey(String apiKey) {
		this.apiKey = apiKey;
	}

}
