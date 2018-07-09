package br.com.picpay.challenge.backend.auth;

import java.security.SecureRandom;
import java.util.Base64;
import java.util.Optional;
import java.util.Set;

import javax.validation.ConstraintViolation;
import javax.validation.ConstraintViolationException;
import javax.validation.Validator;

import org.apache.commons.lang3.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import br.com.picpay.challenge.backend.BackendException;

@Service
public class UserAuthService {

	private static final Logger logger = LoggerFactory.getLogger(UserAuthService.class);
	
	private static final String APIKEY_TYPE = "ApiKey";
	
	@Autowired
	private UserAuthRepository userAuthRepository;
	
	@Autowired
	private Validator validator;
	
	/**
	 * Insere um novo usuário e gera uma API Key para o usuário
	 * @param userAuth Novo usuário
	 * @return
	 */
	public UserAuth insert(UserAuth userAuth) {
		if (userAuth.getApiKey() == null) {
			userAuth.setApiKey(generateApiKey());
		}
		Set<ConstraintViolation<UserAuth>> violations = validator.validate(userAuth);
		if (!violations.isEmpty()) {
			throw new ConstraintViolationException(violations);
		}
		return userAuthRepository.save(userAuth);
	}
	
	/**
	 * Recupera o usuário utilizando o nome de usuário (username)
	 * @return Username do usuário
	 */
	public UserAuth findByUsername(String username) {
		return userAuthRepository.findByUsername(username);
	}
	
	/**
	 * Recupera o usuário pela API Key
	 * @param apiKey
	 */
	public UserAuth findByApiKey(String apiKey) {
		return userAuthRepository.findByApiKey(apiKey);
	}

	/**
	 * Verifica se o token de autorização é válidao. Caso seja retorna o usuário associado a ele.
	 * @param authorization
	 * @return
	 */
	public UserAuth verifyAuthorization(String authorization) {
		/*
		 * Geramente a API Key é informada a query string e não no header da aplicação.
		 * Utilizei esta abordagem para abordar a validação de token de autorização também via header http
		 * Em uma situação real e o uso de um JWT outroas validações devem ser aplicadas.
		 * 
		 * Em produção deve-se utilizar um cache distribuído para acesso aos dados do usuário logado, escopo e etc... 
		 */
		Optional<AuthorizationData> authorizationData = parseAuthorizationData(authorization);
		if (authorizationData.isPresent()) {
			String apiKey = authorizationData.get().getApiKey();
			if (!StringUtils.isBlank(apiKey)) {
				if (APIKEY_TYPE.equals(authorizationData.get().getType())) {
					UserAuth user = userAuthRepository.findByApiKey(apiKey);
					if (user != null) {
						return user;
					}
					logger.warn("API Key não localizada no banco de dados. Authorization: {}", authorization);
				} else {
					logger.debug("Tipo da chave API Key inválido. Authorization: {}", authorization);
				}
			} else {
				logger.debug("API Key não informada. Authorization: {}", authorization);
			}
		} else {
			logger.debug("API Key inválida. Authrozation: {}", authorization);
		}
		throw new BackendException("ApiKey inválida");
	}

	private Optional<AuthorizationData> parseAuthorizationData(String authorization) {
		if (authorization == null) return null;
		authorization = authorization.trim();
		int spaceIndex = authorization.indexOf(" ");
		if (spaceIndex == -1) {
			return Optional.empty();
		}
		String tokenType = authorization.substring(0, spaceIndex).trim();
		String accessToken = authorization.substring(spaceIndex+1, authorization.length()).trim();
		return Optional.of(new AuthorizationData(tokenType, accessToken));
	}
	
	/**
	 * Gera API Key para um usuário utilizando gerador de números aleatórios
	 * @return
	 */
	private String generateApiKey() {
		try {
			SecureRandom secureRandom = new SecureRandom();
			byte[] bytes = new byte[32];
			secureRandom.nextBytes(bytes);
			return Base64.getMimeEncoder().encodeToString(bytes);
		} catch (Exception e) {
			throw new BackendException("Erro ao gerar API Key", e);
		}
	}
	
}
