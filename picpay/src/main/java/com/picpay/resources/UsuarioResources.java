package com.picpay.resources;

import static org.springframework.http.MediaType.APPLICATION_JSON_VALUE;
import static org.springframework.http.MediaType.APPLICATION_XML_VALUE;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.web.PageableDefault;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.picpay.model.Usuario;
import com.picpay.repository.UsuarioFilter;
import com.picpay.service.UsuarioMongoService;

@RestController
@RequestMapping("/resources/usuarios")
public class UsuarioResources {

	private UsuarioMongoService serviceMongo;
	
	@Autowired
	public UsuarioResources(UsuarioMongoService serviceMongo) {
		super();
		this.serviceMongo = serviceMongo;
	}
	
	@GetMapping(produces = {APPLICATION_JSON_VALUE,APPLICATION_XML_VALUE})
	public  ResponseEntity<List<Usuario>> usuariosMongo( UsuarioFilter filter ,@PageableDefault(size = 15) Pageable page) {
		Page<Usuario> listarusuarios = serviceMongo.buscarUsuarios(filter,page);
		List<Usuario> list = listarusuarios.getContent();
		return ResponseEntity.ok(list);
	}
}
