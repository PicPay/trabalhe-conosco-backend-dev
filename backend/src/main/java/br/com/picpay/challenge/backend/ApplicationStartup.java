package br.com.picpay.challenge.backend;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.concurrent.CompletableFuture;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.context.event.ApplicationReadyEvent;
import org.springframework.context.ApplicationListener;
import org.springframework.stereotype.Component;

import br.com.picpay.challenge.backend.auth.UserAuth;
import br.com.picpay.challenge.backend.auth.UserAuthService;
import br.com.picpay.challenge.backend.user.UserService;

@Component
public class ApplicationStartup implements ApplicationListener<ApplicationReadyEvent> {

	private static final Logger logger = LoggerFactory.getLogger(ApplicationStartup.class);
	
	@Autowired
	private UserService userService;
	
	@Autowired
	private UserAuthService userAuthService;
	
	@Autowired
	private ApplicationProperties applicationProperties;
	
	@Override
	public void onApplicationEvent(ApplicationReadyEvent event) {
		userService.createIndexIfNeeded();
		
		if (applicationProperties.isCargaAutomaticaInicializacao()) {
			try {
				CompletableFuture<Void> bulkImportComletable = userService.bulkImport(new URL(applicationProperties.getUsersUrl()), 
						new URL(applicationProperties.getPrioridade1Url()), new URL(applicationProperties.getPrioridade2Url()));
				logger.info("Importação iniciada");
				
				bulkImportComletable.handle((result, t) -> {
					if (t != null) {
						logger.error("Erro durante importação", t);
					}
					return null;
				});
			} catch (MalformedURLException e) {
				throw new BackendException("Verifica as URLs para cara inicial", e);
			}
		}
		if (applicationProperties.getUserAuthApiKey() != null && applicationProperties.getUserAuthUsername() != null
				&& applicationProperties.getUserAuthName() != null) {
			UserAuth userAuth = userAuthService.findByApiKey(applicationProperties.getUserAuthApiKey());
			if (userAuth == null) {
				logger.debug("Criando usuário padrão");
				userAuth = new UserAuth();
				userAuth.setName(applicationProperties.getUserAuthName());
				userAuth.setUsername(applicationProperties.getUserAuthUsername());
				userAuth.setApiKey(applicationProperties.getUserAuthApiKey());
				
				userAuthService.insert(userAuth);
			}
		}
	}
	
}
