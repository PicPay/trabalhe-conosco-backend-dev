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

import com.picpay.model.SearchRelevance;
import com.picpay.model.User;
import com.picpay.model.UserBuilder;
import com.picpay.repository.UserMongoRepository;


@RunWith(SpringRunner.class)
@DataMongoTest
public class RepositoryMongoTest {
	
	private static User heitor;
	private static User tatiana;
	private static User rafael;
	private static User donizete;
	private static User alax;
	private static User candisse;
	
	private static UserBuilder userBuilder;
	
	@Autowired
	private UserMongoRepository repository;
	
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
	public void salvarTodos() {
		List<User> users = Arrays.asList(heitor,tatiana,rafael,donizete,alax,candisse);
		repository.saveAll(users);
	}
	
	@Test
	public void salvarTodos2() {
		repository.save(heitor);
		repository.save(heitor);
	}
	
	@Test
	public void buscarTodos() {
		
		Page<User> findAll = repository.findAllOrderByOrderByRelevanceDescNameAsc(null);
		List<User> lista = findAll.getContent();
		assertThat(lista, Matchers.contains(heitor,tatiana,donizete,rafael,alax,candisse));
	}
	
	@Test
	public void buscarPeloNome() {
		
		Page<User> findAll = repository.findByNameStartingWithIgnoreCaseOrderByRelevanceDescNameAsc("h",null);
		List<User> lista = findAll.getContent();
		assertThat(lista, Matchers.contains(heitor));
	}
	
	@Test
	public void buscarPeloUserName() {
		
		Page<User> findAll = repository.findByNameStartingWithIgnoreCaseOrderByRelevanceDescNameAsc("rafael",null);
		List<User> lista = findAll.getContent();
		assertThat(lista, Matchers.contains(rafael));
	}
	
	@Test
	public void buscarPeloNomeEUserName() {
		
		Page<User> findAll = repository.findByNameContainingAndUsernameContainingAllIgnoreCase("r","r",null);
		List<User> lista = findAll.getContent();
		assertThat(lista, Matchers.contains(rafael));
	}
	
}