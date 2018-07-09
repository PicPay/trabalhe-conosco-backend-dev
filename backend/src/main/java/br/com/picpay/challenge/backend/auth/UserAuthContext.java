package br.com.picpay.challenge.backend.auth;

import org.springframework.stereotype.Component;
import org.springframework.web.context.annotation.RequestScope;

@Component
@RequestScope
public class UserAuthContext {

	private UserAuth user;
	
	public UserAuth getUser() {
		return user;
	}
	
	void setUser(UserAuth user) {
		this.user = user;
	}
	
}
