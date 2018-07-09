package br.com.picpay.challenge.backend.auth;

public class UserAuthDataResponse extends UserAuthData {

	private String apiKey;

	public UserAuthDataResponse(String name, String username, String apiKey) {
		this.name = name;
		this.username = username;
		this.apiKey = apiKey;
	}

	public String getApiKey() {
		return apiKey;
	}

	public void setApiKey(String apiKey) {
		this.apiKey = apiKey;
	}

}
