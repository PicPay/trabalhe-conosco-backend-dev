package br.com.picpay.challenge.backend.auth;

import javax.validation.Valid;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import br.com.picpay.challenge.backend.annotation.Public;

@RestController
@RequestMapping(value="/auth", consumes=MediaType.APPLICATION_JSON_VALUE, produces=MediaType.APPLICATION_JSON_VALUE)
public class UserAuthController {

	@Autowired
	private UserAuthService userAuthService;
	
	@PostMapping("/")
	@Public
	public UserAuthDataResponse postApiKey(@Valid @RequestBody UserAuthDataRequest userAuthData) {
		UserAuth userAuth = new UserAuth();
		userAuth.setUsername(userAuthData.getUsername());
		userAuth.setName(userAuthData.getName());
		userAuth = userAuthService.insert(userAuth);
		return new UserAuthDataResponse(userAuth.getName(), userAuth.getUsername(), userAuth.getApiKey());
	}
	
}
