package br.com.picpay.buscausuario.controller;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.core.io.ResourceLoader;
import org.springframework.data.domain.PageRequest;
import org.springframework.util.ResourceUtils;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RestController;

import br.com.picpay.buscausuario.dominio.IdentificadoresUsuariosPrioritarios;
import br.com.picpay.buscausuario.dominio.PalavraChave;
import br.com.picpay.buscausuario.dominio.TodosUsuarios;
import br.com.picpay.buscausuario.dominio.Usuarios;
import br.com.picpay.buscausuario.infra.IdentificadoresUsuariosPrioritariosTxt;
import br.com.picpay.buscausuario.service.UsuariosService;

@RestController
public class UsuariosController {
	
	private final UsuariosService service;
	
	public UsuariosController(TodosUsuarios todosUsuarios, 
			File arquivoDePrioridades1, 
			File arquivoDePrioridades2) throws FileNotFoundException {
		IdentificadoresUsuariosPrioritarios prioridades1 = new IdentificadoresUsuariosPrioritariosTxt(arquivoDePrioridades1);
		IdentificadoresUsuariosPrioritarios prioridades2 = new IdentificadoresUsuariosPrioritariosTxt(arquivoDePrioridades2);
		this.service = new UsuariosService(todosUsuarios, prioridades1, prioridades2);
	}
	
	@Autowired
	public UsuariosController(TodosUsuarios todosUsuarios, 
			@Value("${prioridade1}") String arquivoDePrioridades1, 
			@Value("${prioridade2}") String arquivoDePrioridades2,
			ResourceLoader loader) throws IOException {
		this(todosUsuarios, 
				ResourceUtils.getFile(arquivoDePrioridades1), 
				ResourceUtils.getFile(arquivoDePrioridades2));
	}
	
	@GetMapping("/usuarios/{palavraChave}/pagina/{pagina}")
	public Usuarios buscarUsuarios(@PathVariable("palavraChave") String stringPalavraChave, @PathVariable("pagina") int pagina) {
		final int totalDeUsuariosPorPagina = 15;
		PalavraChave palavraChave = new PalavraChave(stringPalavraChave);
		return service.buscarUsuariosPorPalavraChave(palavraChave, PageRequest.of(pagina, totalDeUsuariosPorPagina));
	}
}
