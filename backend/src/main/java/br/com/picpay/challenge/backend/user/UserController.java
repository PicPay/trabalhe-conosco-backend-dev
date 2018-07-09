package br.com.picpay.challenge.backend.user;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import br.com.picpay.challenge.backend.annotation.AuthenticatedUser;
import br.com.picpay.challenge.backend.auth.UserAuth;
import br.com.picpay.challenge.backend.model.support.NavDirection;
import br.com.picpay.challenge.backend.model.support.Page;

/**
 * Controler responsável por disponibilização serviços para pesquisa de usuários.<br>
 * 
 * @author francofabio
 *
 */
@RestController
@RequestMapping(value="/users", produces = MediaType.APPLICATION_JSON_VALUE)
public class UserController {
	
	private static final Logger logger = LoggerFactory.getLogger(UserController.class);
	
	@Autowired
	private UserService userService;
	
	@DeleteMapping("/reset-index")
	public ResponseEntity<Void> dropIndex(@AuthenticatedUser UserAuth user) {
		logger.info("Reset Index. Authenticated user: {}", user.getUsername());
		userService.resetIndex();
		return ResponseEntity.ok().build();
	}
	
	@CrossOrigin
	@PostMapping("/search")
	public Page<User> search(@AuthenticatedUser UserAuth user, @RequestBody SearchRequest searchRequest) {
		/*
		 * Foi necessário utilizar método POST devido a possibilidade do navRef ser longo.
		 */
		logger.info("Search. Authenticated user: {}", user.getUsername());
		return userService.search(searchRequest.getTerm(), searchRequest.getNavRef(), 
				NavDirection.valueOf(searchRequest.getDirection().toUpperCase()), searchRequest.getPageSize());
	}
	
}
