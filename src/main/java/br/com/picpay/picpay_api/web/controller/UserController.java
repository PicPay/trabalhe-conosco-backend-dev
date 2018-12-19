 package br.com.picpay.picpay_api.web.controller;

import static org.springframework.http.HttpStatus.CREATED;

import java.util.List;
import java.util.Optional;

import javax.annotation.PostConstruct;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseStatus;
import org.springframework.web.bind.annotation.RestController;

import br.com.picpay.picpay_api.entity.User;
import br.com.picpay.picpay_api.service.DataService;
import br.com.picpay.picpay_api.service.UserService;
import lombok.extern.slf4j.Slf4j;

@RestController
@RequestMapping("/api/users")
@Slf4j
public class UserController {

	private final UserService userService;
	private final DataService dataService;
	@Autowired
	public UserController(UserService userService, DataService dataService) {
		this.userService = userService;
		this.dataService = dataService;
	}

	@GetMapping("/{pagina}")
	public List<User> getUsers(@PathVariable Integer pagina) {
		log.info("process=get-users");
		return userService.getAllUsers(pagina);
	}

	@GetMapping("/{username}/{name}")
	public List<User> getUser(@PathVariable String username, @PathVariable String name) {
		log.info("process=get-user, username={} name={}", username, name);
		return userService.getByNameAndUsername(name, username);
	}
		
	@GetMapping("/{id}")
	public ResponseEntity<User> getUser(@PathVariable Long id) {
		log.info("process=get-user, user_id={}", id);
		Optional<User> user = userService.getUserById(id);
		return user.map(u -> ResponseEntity.ok(u)).orElse(ResponseEntity.notFound().build());
	}

	@PostMapping("")
	@ResponseStatus(CREATED)
	public User createUser(@RequestBody User user) {
		log.info("process=create-user, username={}", user.getUsername());
		return userService.createUser(user);
	}

	@PutMapping("/{id}")
	public User updateUser(@PathVariable Long id, @RequestBody User user) {
		log.info("process=update-user, user_id={}", id);
		user.setId(id);
		return userService.updateUser(user);
	}

	@DeleteMapping("/{id}")
	public void deleteUser(@PathVariable Long id) {
		log.info("process=delete-user, user_id={}", id);
		userService.deleteUser(id);
	}
	
	@PostConstruct
	public void inicializa() {
		log.info("Inicializando banco de dados");
		dataService.loadAllData();
		log.info("Fim do load");
	}
}
