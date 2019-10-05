package com.picpay.api.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.picpay.api.documents.User;
import com.picpay.api.services.UserService;

@RestController
@RequestMapping(path="/api/users")
public class ClienteController {

	@Autowired
	private UserService userService;
	
	@GetMapping(path = "/listagem-usuarios/{termo}/{page}")
	public ResponseEntity<Page<User>> listarUsuariosPaginado(@PathVariable("termo") String termo, @PathVariable("page") int page) {
		ResponseEntity<Page<User>> lista = ResponseEntity.ok(this.userService.findByNomeAndUsername(termo, page));
		return lista;
	}
}
