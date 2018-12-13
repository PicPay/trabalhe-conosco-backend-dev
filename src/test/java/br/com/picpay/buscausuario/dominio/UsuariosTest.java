package br.com.picpay.buscausuario.dominio;

import static br.com.picpay.buscausuario.ObjetosParaTestes.alanTuring;
import static br.com.picpay.buscausuario.ObjetosParaTestes.rodrigoVieira;
import static java.util.Arrays.asList;
import static java.util.Collections.emptyList;
import static java.util.Collections.emptySet;
import static java.util.Collections.singleton;
import static java.util.UUID.randomUUID;
import static org.hamcrest.CoreMatchers.is;
import static org.hamcrest.Matchers.contains;
import static org.hamcrest.Matchers.emptyIterable;
import static org.junit.Assert.assertThat;

import java.util.List;

import org.junit.Test;

public class UsuariosTest {
	
	@Test
	public void priorizarOUltimoUsuarioDaLista() {
		List<Usuario> listaDeUsuarios = asList(alanTuring, rodrigoVieira);
		Usuarios usuarios = new Usuarios(listaDeUsuarios);
		
		usuarios.priorizar(singleton(rodrigoVieira.getId()));
		
		assertThat(usuarios, contains(rodrigoVieira, alanTuring));
	}
	
	@Test
	public void naoPriorizarNenhumUsuarioPoisUUIDUsadoNaoPertenceANenhumUsuarioDaLista() {
		List<Usuario> listaDeUsuarios = asList(alanTuring, rodrigoVieira);
		Usuarios usuarios = new Usuarios(listaDeUsuarios);
		
		usuarios.priorizar(singleton(randomUUID()));
		
		assertThat(usuarios, contains(alanTuring, rodrigoVieira));
	}
	
	@Test
	public void naoPriorizarNenhumUsuarioPoisListaDePrioritariosEstaVazia() {
		List<Usuario> listaDeUsuarios = asList(alanTuring, rodrigoVieira);
		Usuarios usuarios = new Usuarios(listaDeUsuarios);
		
		usuarios.priorizar(emptySet());
		
		assertThat(usuarios, contains(alanTuring, rodrigoVieira));
	}
	
	@Test
	public void naoRealizarNenhumaOperacaoPoisListaDeUsuariosEstaVazia() {
		Usuarios usuarios = new Usuarios(emptyList());
		
		usuarios.priorizar(singleton(randomUUID()));
		
		assertThat(usuarios, is(emptyIterable()));
	}
}
