package br.com.picpay.picpay_api.service;

import java.util.List;
import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.PageRequest;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import br.com.picpay.picpay_api.entity.User;
import br.com.picpay.picpay_api.repo.UserRepository;

@Service
@Transactional
public class UserService {
	private final UserRepository userRepository;

	@Autowired
	public UserService(UserRepository userRepository) {
		this.userRepository = userRepository;
	}
	
	public Optional<User> getUserByHash(String hash) {
		return userRepository.getByHash(hash);
	}
	
	public List<User> getByNameAndUsername(String name, String username) {
		return userRepository.getByNameAndUsername(name, username);
	}

	public Optional<User> getUserById(Long id) {
		return userRepository.findById(id);
	}

	public List<User> getAllUsers(int pagina) {
		return userRepository.findAll(PageRequest.of(pagina, 15)).getContent();
	}

	public User createUser(User user) {
		return userRepository.saveAndFlush(user);
	}

	public User updateUser(User user) {
		return userRepository.save(user);
	}

	public void deleteUser(Long userId) {
		userRepository.deleteById(userId);
	}
}
