package br.com.picpay.buscausuario.controller;

import static br.com.picpay.buscausuario.ObjetosParaTestes.alanTuring;
import static br.com.picpay.buscausuario.ObjetosParaTestes.rodrigoVieira;
import static br.com.picpay.buscausuario.ObjetosParaTestes.usuariosRelevantes1;
import static br.com.picpay.buscausuario.ObjetosParaTestes.usuariosRelevantes2;
import static java.util.Arrays.asList;
import static org.hamcrest.CoreMatchers.hasItems;
import static org.junit.Assert.assertThat;

import java.io.FileNotFoundException;

import org.junit.Before;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.data.mongo.DataMongoTest;
import org.springframework.test.context.TestPropertySource;
import org.springframework.test.context.junit4.SpringRunner;

import br.com.picpay.buscausuario.dominio.TodosUsuarios;
import br.com.picpay.buscausuario.dominio.Usuarios;

@RunWith(SpringRunner.class)
@DataMongoTest
@TestPropertySource(locations= {"classpath:application-test.properties"})
public class UsuariosControllerTest {
	
	private UsuariosController controller;
	
	@Autowired
	private TodosUsuarios todosUsuarios;
	
	@Before
	public void setUp() throws FileNotFoundException {
		todosUsuarios.saveAll(asList(alanTuring, rodrigoVieira));
		controller = new UsuariosController(todosUsuarios, usuariosRelevantes1, usuariosRelevantes2);
	}
	
	@Test
	public void buscarUsuarios() {
		Usuarios usuarios = controller.buscarUsuarios("a", 0);
		
		assertThat(usuarios, hasItems(alanTuring, rodrigoVieira));
	}
}
