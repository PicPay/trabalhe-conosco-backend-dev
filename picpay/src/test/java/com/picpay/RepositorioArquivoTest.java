package com.picpay;

import static org.hamcrest.CoreMatchers.equalTo;
import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertThat;
import static org.mockito.Mockito.mock;
import static org.mockito.Mockito.when;

import java.util.Arrays;
import java.util.List;
import java.util.Optional;
import java.util.stream.Collectors;

import org.hamcrest.Matchers;
import org.junit.BeforeClass;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.test.context.junit4.SpringRunner;

import com.picpay.model.RelevanciaBusca;
import com.picpay.model.Usuario;
import com.picpay.model.UsuarioBuilder;
import com.picpay.repository.UsuarioArquivoRepository;

@RunWith(SpringRunner.class)
@SpringBootTest
public class RepositorioArquivoTest {

	@Autowired
	@Qualifier("test")
	private UsuarioArquivoRepository usuarioArquivoRepositorio;
	private static UsuarioBuilder usuarioBuilder;
	
	private static Usuario heitor;
	private static Usuario tatiana;
	private static Usuario rafael;
	private static Usuario donizete;
	private static Usuario alax;
	private static Usuario candisse;
	
	
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
	public void testaCount() {
		long quantidadeUsuariosArquivo = usuarioArquivoRepositorio.getQuantidadeUsuarios();
		List<Usuario> usuarios = usuarioArquivoRepositorio.recuperaUsuariosNaPaginaNumero(0,0);
		assertEquals(quantidadeUsuariosArquivo,usuarios.size());
	}
	
	@Test
	public void testaBuscaUsuarios() {
		
		List<Usuario> usuarios = usuarioArquivoRepositorio.buscarUusuario(0,0);
		
		 List<Usuario> usuariosRelevancia0 = usuarios
			.stream()
			.filter(u -> u.getRelevancia().getNivel() == 0)
			.collect(Collectors.toList());
		 
		 List<Usuario> usuariosRelevancia1 = usuarios
			.stream()
			.filter(u -> u.getRelevancia().getNivel() == 1)
			.collect(Collectors.toList());
		
		 List<Usuario> usuariosRelevancia2  = usuarios
			.stream()
			.filter(u -> u.getRelevancia().getNivel() == 2)
			.collect(Collectors.toList());
		 
		
		assertEquals(2,usuariosRelevancia2.size());
		assertThat(usuariosRelevancia2, Matchers.containsInAnyOrder(heitor,tatiana));
		
		assertEquals(2,usuariosRelevancia1.size());
		assertThat(usuariosRelevancia1, Matchers.containsInAnyOrder(rafael,donizete));
		
		assertEquals(2,usuariosRelevancia0.size());
		assertThat(usuariosRelevancia0, Matchers.containsInAnyOrder(alax,candisse));
	}
	
	@Test
	public void testaBuscaUsuariosOrdem() {
		
		List<Usuario> usuarios = usuarioArquivoRepositorio.buscarUusuario(0,0);
		assertThat(usuarios, Matchers.contains(heitor,tatiana,donizete,rafael,alax,candisse));
	}
	
	@Test
	public void testaBuscaUsuario() {
		Optional<Usuario> recuperaUsuario = usuarioArquivoRepositorio.recuperaUsuario(heitor.getId());
		assertThat(recuperaUsuario.get(), Matchers.is(equalTo(heitor)));
	}
	
	@Test
	public void testPaginacaoPar() {
		
		UsuarioArquivoRepository mock = mock(UsuarioArquivoRepository.class);
		when(mock.getTamanhoPagina()).thenReturn(4);
		when(mock.recuperaUsuariosNaPaginaNumero(0,0)).thenCallRealMethod();
		when(mock.recuperaUsuariosNaPaginaNumero(1,0)).thenCallRealMethod();
	
		List<Usuario> importarPaginaNumero1 = Arrays.asList(heitor,tatiana,rafael,donizete);
		List<Usuario> importarPaginaNumero2 = Arrays.asList(alax,candisse);
		assertEquals(4,importarPaginaNumero1.size());
		assertEquals(2,importarPaginaNumero2.size());
	}
	
	@Test
	public void testPaginacaoImpar() {
		
		UsuarioArquivoRepository mock = mock(UsuarioArquivoRepository.class);
		when(mock.getTamanhoPagina()).thenReturn(3);
		when(mock.recuperaUsuariosNaPaginaNumero(0,0)).thenCallRealMethod();
		when(mock.recuperaUsuariosNaPaginaNumero(1,1)).thenCallRealMethod();
		
		List<Usuario> importarPaginaNumero1 = Arrays.asList(heitor,tatiana,rafael);
		List<Usuario> importarPaginaNumero2 = Arrays.asList(alax,candisse,donizete);
		
		assertEquals(3,importarPaginaNumero1.size());
		assertEquals(3,importarPaginaNumero2.size());
	}
	
	@Test
	public void testCalcularQuantidadePaginas() {
		
		UsuarioArquivoRepository importador1 = mock(UsuarioArquivoRepository.class);
		when(importador1.getQuantidadeUsuarios()).thenReturn(5l);
		when(importador1.getTamanhoPagina()).thenReturn(10);
		when(importador1.getQuantidadePaginas()).thenCallRealMethod();
		
		UsuarioArquivoRepository importador2 = mock(UsuarioArquivoRepository.class);
		when(importador2.getQuantidadeUsuarios()).thenReturn(6l);
		when(importador2.getTamanhoPagina()).thenReturn(4);
		when(importador2.getQuantidadePaginas()).thenCallRealMethod();
		
		UsuarioArquivoRepository importador3 = mock(UsuarioArquivoRepository.class);
		when(importador3.getQuantidadeUsuarios()).thenReturn(9l);
		when(importador3.getTamanhoPagina()).thenReturn(3);
		when(importador3.getQuantidadePaginas()).thenCallRealMethod();
		
		assertEquals(importador1.getQuantidadePaginas(),1);
		assertEquals(importador2.getQuantidadePaginas(),2);
		assertEquals(importador3.getQuantidadePaginas(),3);
		
	}
}
