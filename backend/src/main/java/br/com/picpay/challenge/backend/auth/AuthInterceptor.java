package br.com.picpay.challenge.backend.auth;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.method.HandlerMethod;
import org.springframework.web.servlet.handler.HandlerInterceptorAdapter;

import br.com.picpay.challenge.backend.BackendException;
import br.com.picpay.challenge.backend.ResponseError;
import br.com.picpay.challenge.backend.annotation.Public;

public class AuthInterceptor extends HandlerInterceptorAdapter {

	private static final Logger logger = LoggerFactory.getLogger(AuthInterceptor.class);

	@Autowired
	private UserAuthService authService;
	@Autowired
	private UserAuthContext authContext;
	
	@Override
	public boolean preHandle(HttpServletRequest request, HttpServletResponse response, Object handler) throws Exception {
		logger.debug("AuthInterceptor::preHandle");
		
		if (!(handler instanceof HandlerMethod)) {
			logger.debug("CORS request");
			logger.debug("Handler: " + handler);
			return true;
		}
		
		HandlerMethod handlerMethod = (HandlerMethod) handler;
		boolean publicAction = handlerMethod.getMethodAnnotation(Public.class) != null; 
		if (!publicAction) {
			String authorization = request.getHeader("Authorization");
			if (authorization == null || authorization.trim().isEmpty()) {
				throw new BackendException(new ResponseError(HttpServletResponse.SC_UNAUTHORIZED, "API Key não informada no header 'Authorization'"));
			}
			try {
				UserAuth user = authService.verifyAuthorization(authorization);
				authContext.setUser(user);
			} catch (Exception e) {
				logger.error("Erro durante processamento da requisição: " + request.getRequestURI());
				String message = "Erro durante processamento";
				if (e instanceof BackendException) {
					message = e.getMessage();
				}
				throw new BackendException(new ResponseError(HttpServletResponse.SC_INTERNAL_SERVER_ERROR, message));
			}
		} else {
			logger.debug("public resource: " + request.getRequestURI());
		}
		return true;
	}

}
