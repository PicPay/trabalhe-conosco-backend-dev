package br.com.picpay.challenge.backend.auth;

public class AuthorizationData {

	private String type;
	private String apiKey;
	
	public AuthorizationData(String type, String apiKey) {
		this.type = type;
		this.apiKey = apiKey;
	}

	public String getType() {
		return type;
	}

	public String getApiKey() {
		return apiKey;
	}

}
