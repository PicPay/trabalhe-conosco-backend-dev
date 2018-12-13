package br.com.picpay.buscausuario.infra;

import static br.com.picpay.buscausuario.ObjetosParaTestes.usuariosRelevantes;
import static java.util.UUID.fromString;
import static org.hamcrest.Matchers.contains;
import static org.junit.Assert.assertThat;

import java.io.FileNotFoundException;
import java.util.Set;
import java.util.UUID;

import org.junit.Before;
import org.junit.Test;

import br.com.picpay.buscausuario.dominio.IdentificadoresUsuariosPrioritarios;

public class IdentificadoresUsuariosPrioritariosTxtTest {
	
	private IdentificadoresUsuariosPrioritarios idsUsuariosPrioritarios;
	
	@Before
	public void setUp() throws FileNotFoundException {
		idsUsuariosPrioritarios = new IdentificadoresUsuariosPrioritariosTxt(usuariosRelevantes);
	}
	
	@Test
	public void lerTodos() {
		Set<UUID> identificadores = idsUsuariosPrioritarios.lerTodos();
		
		assertThat(identificadores, contains(fromString("e5e1f9bf-628a-4a16-be50-82100d10c745"), fromString("b2b14b84-6bdc-4a54-81e7-5fbe25f2c41b"),
											 fromString("919d269c-09f4-4ec3-971a-00433bec409f"), fromString("8fab32b1-d575-405e-bdb7-8ac0cc3cb886")));
	}
}