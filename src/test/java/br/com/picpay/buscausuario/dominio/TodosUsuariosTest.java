package br.com.picpay.buscausuario.dominio;

import static br.com.picpay.buscausuario.ObjetosParaTestes.alanTuring;
import static br.com.picpay.buscausuario.ObjetosParaTestes.rodrigoVieira;
import static org.hamcrest.CoreMatchers.hasItems;
import static org.hamcrest.Matchers.contains;
import static org.junit.Assert.assertThat;

import java.util.List;

import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.data.mongo.DataMongoTest;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.test.context.TestPropertySource;
import org.springframework.test.context.junit4.SpringRunner;

@RunWith(SpringRunner.class)
@DataMongoTest
@TestPropertySource(locations= {"classpath:application-test.properties"})
public class TodosUsuariosTest {
	
	@Autowired
	private TodosUsuarios todosUsuarios;
	
	private Pageable pagina;
	
	@Before
	public void setUp() {
		pagina = PageRequest.of(0, 2);
		todosUsuarios.save(alanTuring);
		todosUsuarios.save(rodrigoVieira);
	}
	
	@After
	public void tearDown() {
		todosUsuarios.deleteAll();
	}
	
	@Test
	public void buscarUsuarioCujaPalavraChaveBateExatamenteComONomeDeUmUsuario() {
		List<Usuario> usuarios = todosUsuarios.findByNomeLikeIgnoreCase(rodrigoVieira.getNome(), pagina);
		
		assertThat(usuarios, contains(rodrigoVieira));
	}
	
	@Test
	public void buscarUsuarioCujaPalavraChaveBateExatamenteComOUsernameDeUmUsuario() {
		List<Usuario> usuarios = todosUsuarios.findByUsernameLikeIgnoreCase(rodrigoVieira.getUsername(), pagina);
		
		assertThat(usuarios, contains(rodrigoVieira));
	}
	
	@Test
	public void buscarUsuarioCujaPalavraChaveEhParteDoNomeDeUmUsuario() {
		String palavraChave = rodrigoVieira.getNome().substring(0, 5);
		List<Usuario> usuarios = todosUsuarios.findByNomeLikeIgnoreCase(palavraChave, pagina);
		
		assertThat(usuarios, contains(rodrigoVieira));
	}
	
	@Test
	public void buscarUsuarioCujaPalavraChaveEhParteDoUsernameDeUmUsuario() {
		String palavraChave = rodrigoVieira.getUsername().substring(0, 5);
		List<Usuario> usuarios = todosUsuarios.findByUsernameLikeIgnoreCase(palavraChave, pagina);
		
		assertThat(usuarios, contains(rodrigoVieira));
	}
	
	@Test
	public void buscarMaisDeUmUsuario() {
		String palavraChave = "a";
		List<Usuario> usuarios = todosUsuarios.findByNomeLikeIgnoreCase(palavraChave, pagina);
		
		assertThat(usuarios, hasItems(rodrigoVieira, alanTuring));
	}
	
	@Test
	public void buscarApenasUmaPaginaDeResultados() {
		pagina = PageRequest.of(0, 1);
		String palavraChave = "a";
		List<Usuario> usuarios = todosUsuarios.findByUsernameLikeIgnoreCase(palavraChave, pagina);
		
		assertThat(usuarios, contains(alanTuring));
		
		pagina = PageRequest.of(1, 1);
		usuarios = todosUsuarios.findByNomeLikeIgnoreCase(palavraChave, pagina);
		
		assertThat(usuarios, contains(rodrigoVieira));
	}
}
