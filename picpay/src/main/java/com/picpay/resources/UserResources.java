package com.picpay.resources;

import static org.springframework.http.MediaType.APPLICATION_JSON_VALUE;
import static org.springframework.http.MediaType.APPLICATION_XML_VALUE;

import java.util.ArrayList;
import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.web.PageableDefault;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.picpay.model.User;
import com.picpay.repository.UserFilter;
import com.picpay.service.UserMongoService;

@RestController
@RequestMapping("/resources/users")
public class UserResources {

	private UserMongoService serviceMongo;
	
	@Autowired
	public UserResources(UserMongoService serviceMongo) {
		super();
		this.serviceMongo = serviceMongo;
	}
	
	
	@GetMapping(produces = {APPLICATION_JSON_VALUE,APPLICATION_XML_VALUE})
	public  ResponseEntity<List<User>> usuariosMongo( UserFilter filter ,@PageableDefault(size = 15) Pageable page) {
		Page<User> users = serviceMongo.findUsers(filter,page);
		List<User> list = users == null ? new ArrayList<>() : users.getContent();
		return ResponseEntity.ok(list);
	}
}