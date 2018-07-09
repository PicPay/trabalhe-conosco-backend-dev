package br.com.picpay.challenge.backend.argumentresolver;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.MethodParameter;
import org.springframework.web.bind.support.WebDataBinderFactory;
import org.springframework.web.context.request.NativeWebRequest;
import org.springframework.web.method.support.HandlerMethodArgumentResolver;
import org.springframework.web.method.support.ModelAndViewContainer;

import br.com.picpay.challenge.backend.annotation.AuthenticatedUser;
import br.com.picpay.challenge.backend.auth.UserAuthContext;
import br.com.picpay.challenge.backend.auth.UserAuth;

public class AuthenticatedUserMethodArgumentResolver implements HandlerMethodArgumentResolver {
	
	@Autowired
	private UserAuthContext authContext;
	
	@Override
	public boolean supportsParameter(MethodParameter parameter) {
		return parameter.hasParameterAnnotation(AuthenticatedUser.class);
	}

	@Override
	public Object resolveArgument(MethodParameter parameter, ModelAndViewContainer mavContainer, NativeWebRequest webRequest, WebDataBinderFactory binderFactory) throws Exception {
		Class<?> parameterType = parameter.getParameterType();
		if (!UserAuth.class.isAssignableFrom(parameterType)) {
			throw new IllegalArgumentException("The parameter to receive authenticated user should be of type " + UserAuth.class);
		}
		return authContext.getUser();
	}

}
