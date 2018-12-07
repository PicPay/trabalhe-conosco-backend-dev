package com.picpay;

import static org.junit.Assert.assertThat;

import java.util.Arrays;
import java.util.List;

import org.hamcrest.Matchers;
import org.junit.BeforeClass;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.data.mongo.DataMongoTest;
import org.springframework.data.domain.Page;
import org.springframework.test.context.junit4.SpringRunner;

import com.picpay.model.RelevanciaBusca;
import com.picpay.model.Usuario;
import com.picpay.model.UsuarioBuilder;
import com.picpay.repository.UsuarioMongoRepository;


@RunWith(SpringRunner.class)
@DataMongoTest
public class RepositorioMongoTest {
	
	private static Usuario heitor;
	private static Usuario tatiana;
	private static Usuario rafael;
	private static Usuario donizete;
	private static Usuario alax;
	private static Usuario candisse;
	private static UsuarioBuilder usuarioBuilder;
	
	@Autowired
	private UsuarioMongoRepository repositorio;
	
	@BeforeClass
	public static void setUp() {
		
		usuarioBuilder = new UsuarioBuilder();
		
		heitor = usuarioBuilder.comId("6e172695-c76c-4364-8dd9-44e6d2d3aed9")
			.comNomeEUserName("Heitor Rovaron","heitor.rovaron")
			.comRelevanciaBusca(new RelevanciaBusca(2))
			.build();
		
		tatiana = usuarioBuilder.comId("7e3d4092-6664-4162-9866-c4256507a35e")
			.comNomeEUserName("Tatiana Arrieiro Filgueira","tatianaarrieirofilgueira")
			.comRelevanciaBusca(new RelevanciaBusca(2))
			.build();
			
		rafael = usuarioBuilder.comId("657eb911-3fd1-4317-9430-f5f53199754c")
			.comNomeEUserName("Rafael Furtado","rafael.furtado")
			.comRelevanciaBusca(new RelevanciaBusca(1))
			.build();
			
		donizete = usuarioBuilder.comId("6dec2c10-1522-4cc7-8e45-89d78a6274c2")
			.comNomeEUserName("Donizete Kohler","donizete.kohler")
			.comRelevanciaBusca(new RelevanciaBusca(1))
			.build();
				
		alax = usuarioBuilder.comId("c720558d-652d-48d3-b952-40b16124b989")
			.comNomeEUserName("Alax Kaiser Raquel","alax.kaiser.raquel")
			.build();
			
		candisse = usuarioBuilder.comId("bea7457f-3d0a-48f8-9ee9-c3ff79bf756b")
			.comNomeEUserName("Candisse Mattis","candisse.mattis")
			.build();
	}
	
	@Test
	public void salvarTodos() {
		List<Usuario> usuarios = Arrays.asList(heitor,tatiana,rafael,donizete,alax,candisse);
		repositorio.saveAll(usuarios);
	}
	
	@Test
	public void salvarTodos2() {
		repositorio.save(heitor);
		repositorio.save(heitor);
	}
	
	@Test
	public void buscarTodos() {
		
		Page<Usuario> findAll = repositorio.findAllOrderByOrderByRelevanciaDescNomeAsc(null);
		List<Usuario> lista = findAll.getContent();
		assertThat(lista, Matchers.contains(heitor,tatiana,donizete,rafael,alax,candisse));
	}
	
	@Test
	public void buscarPeloNome() {
		
		Page<Usuario> findAll = repositorio.findByNomeStartingWithIgnoreCaseOrderByRelevanciaDescNomeAsc("h",null);
		List<Usuario> lista = findAll.getContent();
		assertThat(lista, Matchers.contains(heitor));
	}
	
	@Test
	public void buscarPeloUserName() {
		
		Page<Usuario> findAll = repositorio.findByUsernameStartingWithIgnoreCaseOrderByRelevanciaDescNomeAsc("rafael",null);
		List<Usuario> lista = findAll.getContent();
		assertThat(lista, Matchers.contains(rafael));
	}
	
	@Test
	public void buscarPeloNomeEUserName() {
		
		Page<Usuario> findAll = repositorio.findByNomeStartingWithAndUsernameStartingWithAllIgnoreCase("r","r",null);
		List<Usuario> lista = findAll.getContent();
		assertThat(lista, Matchers.contains(rafael));
	}
	
	@Test
	public void buscarUsuario() {
		
		Page<Usuario> findAll = repositorio.findByNomeStartingWithAndUsernameStartingWithAndIdAllIgnoreCase("r","r","657eb911-3fd1-4317-9430-f5f53199754c",null);
		List<Usuario> lista = findAll.getContent();
		assertThat(lista, Matchers.contains(rafael));
	}
}
