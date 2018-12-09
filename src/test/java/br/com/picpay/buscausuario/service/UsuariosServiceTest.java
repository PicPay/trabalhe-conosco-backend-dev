package br.com.picpay.buscausuario.service;

import static br.com.picpay.buscausuario.ObjetosParaTestes.alanTuring;
import static br.com.picpay.buscausuario.ObjetosParaTestes.rodrigoVieira;
import static br.com.picpay.buscausuario.ObjetosParaTestes.usuariosRelevantes1;
import static br.com.picpay.buscausuario.ObjetosParaTestes.usuariosRelevantes2;
import static java.util.Arrays.asList;
import static org.hamcrest.Matchers.contains;
import static org.junit.Assert.assertThat;
import static org.mockito.Mockito.mock;
import static org.mockito.Mockito.when;

import java.io.FileNotFoundException;
import java.util.UUID;

import org.junit.Before;
import org.junit.Test;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;

import br.com.picpay.buscausuario.dominio.IdentificadoresUsuariosPrioritarios;
import br.com.picpay.buscausuario.dominio.PalavraChave;
import br.com.picpay.buscausuario.dominio.TodosUsuarios;
import br.com.picpay.buscausuario.dominio.Usuario;
import br.com.picpay.buscausuario.dominio.Usuarios;
import br.com.picpay.buscausuario.infra.IdentificadoresUsuariosPrioritariosTxt;

public class UsuariosServiceTest {
	
	private TodosUsuarios todosUsuarios;
	private IdentificadoresUsuariosPrioritarios idsPrioridade1;
	private IdentificadoresUsuariosPrioritarios idsPrioridade2;
	
	private UsuariosService servico;
	
	@Before
	public void setUp() throws FileNotFoundException {
		todosUsuarios = mock(TodosUsuarios.class);
		idsPrioridade1 = new IdentificadoresUsuariosPrioritariosTxt(usuariosRelevantes1);
		idsPrioridade2 = new IdentificadoresUsuariosPrioritariosTxt(usuariosRelevantes2);
		
		servico = new UsuariosService(todosUsuarios, idsPrioridade1, idsPrioridade2);
	}
	
	@Test
	public void priorizarUsuariosUsandoTodasAsListasDeRelevancia() {
		PalavraChave palavraChave = new PalavraChave("a");
		Pageable pagina = PageRequest.of(0, 2);
		Usuario usuarioIrrelevante = new Usuario(UUID.randomUUID(), "marina silva", "marina.silva");
		when(todosUsuarios.findByUsernameLikeIgnoreCase(palavraChave.toString(), pagina)).thenReturn(asList(usuarioIrrelevante, rodrigoVieira, alanTuring));
		
		Usuarios usuarios = servico.buscarUsuariosPorPalavraChave(palavraChave, pagina);
		
		assertThat(usuarios, contains(alanTuring, rodrigoVieira, usuarioIrrelevante));
	}
}
