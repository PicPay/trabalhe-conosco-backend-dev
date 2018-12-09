package br.com.picpay.buscausuario.infra.initbase;

import static br.com.picpay.buscausuario.ObjetosParaTestes.alanTuring;
import static br.com.picpay.buscausuario.ObjetosParaTestes.arquivoCsvComDuasLinhas;
import static br.com.picpay.buscausuario.ObjetosParaTestes.arquivoCsvComUmaLinha;
import static br.com.picpay.buscausuario.ObjetosParaTestes.rodrigoVieira;
import static org.hamcrest.CoreMatchers.equalTo;
import static org.hamcrest.CoreMatchers.is;
import static org.junit.Assert.assertThat;

import java.io.FileNotFoundException;

import org.junit.Test;

import br.com.picpay.buscausuario.dominio.LeitorDeUsuariosDaFonte;
import br.com.picpay.buscausuario.dominio.Usuario;

public class LeitorDeUsuariosDaFonteCSVTest {
	
	@Test
	public void lerUmArquivoComUmaLinha() throws FileNotFoundException {
		LeitorDeUsuariosDaFonte leitor = new LeitorDeUsuariosDaFonteCSV(arquivoCsvComUmaLinha);
		Usuario usuarioObtido = leitor.lerUsuario();
			
		assertThat(usuarioObtido, is(equalTo(rodrigoVieira)));
		assertThat(leitor.encontrouMaisUsuarios(), is(false));
	}
	
	@Test
	public void lerArquivoComDuasLinhas() throws FileNotFoundException {
		LeitorDeUsuariosDaFonte leitor = new LeitorDeUsuariosDaFonteCSV(arquivoCsvComDuasLinhas);
		Usuario umUsuarioObtido = leitor.lerUsuario();
		
		assertThat(umUsuarioObtido, is(equalTo(rodrigoVieira)));
		assertThat(leitor.encontrouMaisUsuarios(), is(true));
		
		Usuario outroUsuarioObtido = leitor.lerUsuario();
		
		assertThat(outroUsuarioObtido, is(equalTo(alanTuring)));
		assertThat(leitor.encontrouMaisUsuarios(), is(false));
	}
}
