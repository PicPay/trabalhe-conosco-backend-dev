package br.com.picpay.challenge.backend.validation;

import javax.validation.ConstraintValidator;
import javax.validation.ConstraintValidatorContext;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

import br.com.picpay.challenge.backend.auth.UserAuthService;

@Component
public class UniqueUsernameValidator implements ConstraintValidator<UniqueUsername, String> {

	@Autowired
	private UserAuthService userAuthService;
	
	@Override
	public boolean isValid(String value, ConstraintValidatorContext context) {
		return userAuthService.findByUsername(value) == null;
	}

}
