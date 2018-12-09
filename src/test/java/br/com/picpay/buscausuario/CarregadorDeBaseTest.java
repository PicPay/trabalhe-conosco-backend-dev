package br.com.picpay.buscausuario;

import static br.com.picpay.buscausuario.ObjetosParaTestes.alanTuring;
import static br.com.picpay.buscausuario.ObjetosParaTestes.arquivoCsvComDuasLinhas;
import static br.com.picpay.buscausuario.ObjetosParaTestes.rodrigoVieira;
import static org.hamcrest.CoreMatchers.hasItems;
import static org.junit.Assert.assertThat;

import java.io.FileNotFoundException;

import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.data.mongo.DataMongoTest;
import org.springframework.test.context.TestPropertySource;
import org.springframework.test.context.junit4.SpringRunner;

import br.com.picpay.buscausuario.dominio.LeitorDeUsuariosDaFonte;
import br.com.picpay.buscausuario.dominio.TodosUsuarios;
import br.com.picpay.buscausuario.dominio.Usuario;
import br.com.picpay.buscausuario.infra.initbase.LeitorDeUsuariosDaFonteCSV;

@RunWith(SpringRunner.class)
@DataMongoTest
@TestPropertySource(locations= {"classpath:application-test.properties"})
public class CarregadorDeBaseTest {
	
	private LeitorDeUsuariosDaFonte leitor;
	private CarregadorDeBase carregador;
	
	@Autowired
	private TodosUsuarios todosUsuarios;
	
	@Before
	public void setUp() throws FileNotFoundException {
		leitor = new LeitorDeUsuariosDaFonteCSV(arquivoCsvComDuasLinhas);
		carregador = new CarregadorDeBase(leitor, todosUsuarios, 2);
	}
	
	@After
	public void tearDown() {
		todosUsuarios.deleteAll();
	}

	@Test
	public void carregarABaseComUsuarios() {
		carregador.carregarUsuarios();
		
		Iterable<Usuario> usuariosPersistidos = todosUsuarios.findAll();
		assertThat(usuariosPersistidos, hasItems(rodrigoVieira, alanTuring));
	}
}
