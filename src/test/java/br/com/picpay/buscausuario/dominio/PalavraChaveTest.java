package br.com.picpay.buscausuario.dominio;

import static org.hamcrest.CoreMatchers.is;
import static org.junit.Assert.assertThat;

import org.junit.Test;

public class PalavraChaveTest {
	
	@Test
	public void palavraChaveServeParaBuscaPorUsernamePoisContemUmPonto() {
		PalavraChave palavraChave = new PalavraChave("usuario.ponto");
		
		assertThat(palavraChave.paraBuscarPorUsername(), is(true));
	}
	
	@Test
	public void palavraChaveServeParaBuscaPorUsernamePoisNaoContemEspacosENemPontos() {
		PalavraChave palavraChave = new PalavraChave("usuarioponto");
		
		assertThat(palavraChave.paraBuscarPorUsername(), is(true));
	}
	
	@Test
	public void palavraChaveServeParaBuscaPorNomePoisContemEspacos() {
		PalavraChave palavraChave = new PalavraChave("usuario ponto");
		
		assertThat(palavraChave.paraBuscarPorUsername(), is(false));
	}
	
	@Test
	public void palavraChaveServeParaBuscaPorNomePoisContemEspacosEPontos() {
		PalavraChave palavraChave = new PalavraChave("usuario. ponto");
		
		assertThat(palavraChave.paraBuscarPorUsername(), is(false));
	}
}
