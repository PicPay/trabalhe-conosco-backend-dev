package com.tmontovaneli.challenge.controller;

import java.util.ArrayList;
import java.util.List;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;

import com.tmontovaneli.challenge.model.User;
import com.tmontovaneli.challenge.mongodb.MongoConnection;
import com.tmontovaneli.challenge.repository.RelevanciaRepository;
import com.tmontovaneli.challenge.repository.UserRepository;

@Controller
public class UserController {

	private UserRepository userRepository;
	private RelevanciaRepository relevanciaRepository;

	public UserController() {
		MongoConnection mongoConnection = new MongoConnection();
		userRepository = new UserRepository(mongoConnection);
		relevanciaRepository = new RelevanciaRepository(mongoConnection);
	}

	@RequestMapping("/users/count/{page}")
	@ResponseBody
	public Long count(@PathVariable int page, @RequestParam String query) {

		return userRepository.count(query, page);

	}

	@RequestMapping("/users/{page}")
	@ResponseBody
	public List<User> getUsers(@PathVariable("page") Integer page, @RequestParam String query) {

		try {
			List<User> find = userRepository.find(query, page);

			List<User> prioridade1 = new ArrayList<User>();
			List<User> prioridade2 = new ArrayList<User>();
			List<User> outros = new ArrayList<User>();

			for (User user : find) {

				String id = user.getId();
				if (relevanciaRepository.usuarioTemPrioridade1(id)) {
					System.out.println("Encontrou prioridade 1 " + user.toString());

					prioridade1.add(user);
				} else if (relevanciaRepository.usuarioTemPrioridade2(id)) {

					System.out.println("Encontrou prioridade 2 " + user.toString());
					prioridade2.add(user);

				} else {
					outros.add(user);
				}
			}

			//relevanciaRepository.close();

			List<User> result = new ArrayList<User>();
			result.addAll(0, outros);
			result.addAll(0, prioridade2);
			result.addAll(0, prioridade1);

			return result;
		} catch (Exception e) {
			e.printStackTrace();
			return null;
		}

	}

}
