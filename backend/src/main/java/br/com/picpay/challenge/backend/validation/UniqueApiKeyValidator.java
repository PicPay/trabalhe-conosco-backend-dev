package br.com.picpay.challenge.backend.validation;

import javax.validation.ConstraintValidator;
import javax.validation.ConstraintValidatorContext;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

import br.com.picpay.challenge.backend.auth.UserAuthService;

@Component
public class UniqueApiKeyValidator implements ConstraintValidator<UniqueApiKey, String> {

	@Autowired
	private UserAuthService userAuthService;
	
	@Override
	public boolean isValid(String value, ConstraintValidatorContext context) {
		return userAuthService.findByApiKey(value) == null;
	}

}
