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

import com.picpay.model.SearchRelevance;
import com.picpay.model.User;
import com.picpay.model.UserBuilder;
import com.picpay.repository.UserFileRepository;

@RunWith(SpringRunner.class)
@SpringBootTest
public class RepositoryFileTest {

	@Autowired
	@Qualifier("test")
	private UserFileRepository userFileRepository;
	private static UserBuilder userBuilder;
	
	private static User heitor;
	private static User tatiana;
	private static User rafael;
	private static User donizete;
	private static User alax;
	private static User candisse;
	
	
	@BeforeClass
	public static void setUp() {

		userBuilder = new UserBuilder();
		
		heitor = userBuilder.withId("6e172695-c76c-4364-8dd9-44e6d2d3aed9")
			.withNameAndUsername("Heitor Rovaron","heitor.rovaron")
			.withSearchRelevance(new SearchRelevance(2))
			.build();
		
		tatiana = userBuilder.withId("7e3d4092-6664-4162-9866-c4256507a35e")
			.withNameAndUsername("Tatiana Arrieiro Filgueira","tatianaarrieirofilgueira")
			.withSearchRelevance(new SearchRelevance(2))
			.build();
			
		rafael = userBuilder.withId("657eb911-3fd1-4317-9430-f5f53199754c")
			.withNameAndUsername("Rafael Furtado","rafael.furtado")
			.withSearchRelevance(new SearchRelevance(1))
			.build();
			
		donizete = userBuilder.withId("6dec2c10-1522-4cc7-8e45-89d78a6274c2")
			.withNameAndUsername("Donizete Kohler","donizete.kohler")
			.withSearchRelevance(new SearchRelevance(1))
			.build();
				
		alax = userBuilder.withId("c720558d-652d-48d3-b952-40b16124b989")
			.withNameAndUsername("Alax Kaiser Raquel","alax.kaiser.raquel")
			.build();
			
		candisse = userBuilder.withId("bea7457f-3d0a-48f8-9ee9-c3ff79bf756b")
			.withNameAndUsername("Candisse Mattis","candisse.mattis")
			.build();
	}
	
	@Test
	public void testCount() {
		long quantidadeUsuariosArquivo = userFileRepository.getAmountUsers();
		List<User> usuarios = userFileRepository.getUsersOnPage(0,0);
		assertEquals(quantidadeUsuariosArquivo,usuarios.size());
	}
	
	@Test
	public void testSearchUsers() {
		
		List<User> usuarios = userFileRepository.findUser(0,0);
		
		 List<User> usuariosRelevancia0 = usuarios
			.stream()
			.filter(u -> u.getRelevance().getLevel() == 0)
			.collect(Collectors.toList());
		 
		 List<User> usuariosRelevancia1 = usuarios
			.stream()
			.filter(u -> u.getRelevance().getLevel() == 1)
			.collect(Collectors.toList());
		
		 List<User> usuariosRelevancia2  = usuarios
			.stream()
			.filter(u -> u.getRelevance().getLevel() == 2)
			.collect(Collectors.toList());
		 
		
		assertEquals(2,usuariosRelevancia2.size());
		assertThat(usuariosRelevancia2, Matchers.containsInAnyOrder(heitor,tatiana));
		
		assertEquals(2,usuariosRelevancia1.size());
		assertThat(usuariosRelevancia1, Matchers.containsInAnyOrder(rafael,donizete));
		
		assertEquals(2,usuariosRelevancia0.size());
		assertThat(usuariosRelevancia0, Matchers.containsInAnyOrder(alax,candisse));
	}
	
	@Test
	public void testSearchUserOrder() {
		
		List<User> usuarios = userFileRepository.findUser(0,0);
		assertThat(usuarios, Matchers.contains(heitor,tatiana,donizete,rafael,alax,candisse));
	}
	
	@Test
	public void testaSearchUser() {
		Optional<User> user = userFileRepository.getUser(heitor.getId());
		assertThat(user.get(), Matchers.is(equalTo(heitor)));
	}
	
	@Test
	public void testPageEven() {
		
		UserFileRepository mock = mock(UserFileRepository.class);
		when(mock.getPageSize()).thenReturn(4);
		when(mock.getUsersOnPage(0,0)).thenCallRealMethod();
		when(mock.getUsersOnPage(1,0)).thenCallRealMethod();
	
		List<User> importarPaginaNumero1 = Arrays.asList(heitor,tatiana,rafael,donizete);
		List<User> importarPaginaNumero2 = Arrays.asList(alax,candisse);
		assertEquals(4,importarPaginaNumero1.size());
		assertEquals(2,importarPaginaNumero2.size());
	}
	
	@Test
	public void testPageOdd() {
		
		UserFileRepository mock = mock(UserFileRepository.class);
		when(mock.getPageSize()).thenReturn(3);
		when(mock.getUsersOnPage(0,0)).thenCallRealMethod();
		when(mock.getUsersOnPage(1,1)).thenCallRealMethod();
		
		List<User> importarPaginaNumero1 = Arrays.asList(heitor,tatiana,rafael);
		List<User> importarPaginaNumero2 = Arrays.asList(alax,candisse,donizete);
		
		assertEquals(3,importarPaginaNumero1.size());
		assertEquals(3,importarPaginaNumero2.size());
	}
	
	@Test
	public void testCalcularQuantidadePaginas() {
		
		UserFileRepository importador1 = mock(UserFileRepository.class);
		when(importador1.getAmountUsers()).thenReturn(5l);
		when(importador1.getPageSize()).thenReturn(10);
		when(importador1.getAmountOfPages()).thenCallRealMethod();
		
		UserFileRepository importador2 = mock(UserFileRepository.class);
		when(importador2.getAmountUsers()).thenReturn(6l);
		when(importador2.getPageSize()).thenReturn(4);
		when(importador2.getAmountOfPages()).thenCallRealMethod();
		
		UserFileRepository importador3 = mock(UserFileRepository.class);
		when(importador3.getAmountUsers()).thenReturn(9l);
		when(importador3.getPageSize()).thenReturn(3);
		when(importador3.getAmountOfPages()).thenCallRealMethod();
		
		assertEquals(importador1.getAmountOfPages(),1);
		assertEquals(importador2.getAmountOfPages(),2);
		assertEquals(importador3.getAmountOfPages(),3);
		
	}
}