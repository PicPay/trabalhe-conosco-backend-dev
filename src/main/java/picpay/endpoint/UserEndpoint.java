package picpay.endpoint;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import picpay.model.User;
import picpay.repositories.UserRepository;

@RestController
@RequestMapping("users")
public class UserEndpoint {
	private final UserRepository userRepository;
	
	@Autowired
	public UserEndpoint(UserRepository UserRepository) {
		this.userRepository = UserRepository;
	}

	@GetMapping(path = "findByNameOrUsername/{nameOrUsername}")
	public ResponseEntity<?> getStudentByName(@PathVariable("nameOrUsername") String nameOrUsername, Pageable pageable) {
		Page<User> page = userRepository.findByNameIgnoreCaseContainingOrUsernameIgnoreCaseContainingOrderByPrior1DescPrior2DescNameAsc(nameOrUsername, nameOrUsername, pageable);
		return new ResponseEntity<>(page, HttpStatus.OK);
	}
}
