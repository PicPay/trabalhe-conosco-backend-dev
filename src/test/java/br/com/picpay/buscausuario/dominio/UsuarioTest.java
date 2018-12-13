package br.com.picpay.buscausuario.dominio;

import static br.com.picpay.buscausuario.ObjetosParaTestes.alanTuring;
import static java.util.Arrays.asList;
import static java.util.Collections.emptySet;
import static java.util.UUID.randomUUID;
import static org.hamcrest.CoreMatchers.is;
import static org.junit.Assert.assertThat;

import java.util.HashSet;
import java.util.Set;
import java.util.UUID;

import org.junit.Test;

public class UsuarioTest {
	
	
	@Test
	public void possuiUmDosIDs() {
		Set<UUID> uuids = new HashSet<>(asList(randomUUID(), randomUUID(), alanTuring.getId()));
		
		assertThat(alanTuring.possuiUmDessesIds(uuids), is(true));
	}
	
	@Test
	public void naoPossuiUmDosIDs() {
		Set<UUID> uuids = new HashSet<>(asList(randomUUID(), randomUUID(), randomUUID()));
		
		assertThat(alanTuring.possuiUmDessesIds(uuids), is(false));
	}
	
	@Test
	public void naoPossuiUmDosIDsPoisAListaDeIDsEhNula() {
		assertThat(alanTuring.possuiUmDessesIds(null), is(false));
	}
	
	@Test
	public void naoPossuiUmDosIDsPoisAListaDeIDsEhVazia() {
		assertThat(alanTuring.possuiUmDessesIds(emptySet()), is(false));
	}
}
