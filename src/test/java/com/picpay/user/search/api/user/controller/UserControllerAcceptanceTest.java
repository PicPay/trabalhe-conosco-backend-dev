package com.picpay.user.search.api.user.controller;

import static com.picpay.user.search.api.user.model.Constants.URI;
import static com.picpay.user.search.api.user.model.Constants.X_TOTAL_COUNT_HEADER;
import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertTrue;

import java.util.List;

import org.junit.Before;
import org.junit.ClassRule;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.boot.test.context.SpringBootTest.WebEnvironment;
import org.springframework.boot.test.util.TestPropertyValues;
import org.springframework.boot.test.web.client.TestRestTemplate;
import org.springframework.boot.web.server.LocalServerPort;
import org.springframework.context.ApplicationContextInitializer;
import org.springframework.context.ConfigurableApplicationContext;
import org.springframework.core.ParameterizedTypeReference;
import org.springframework.http.HttpHeaders;
import org.springframework.http.HttpMethod;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.test.context.ContextConfiguration;
import org.springframework.test.context.junit4.SpringRunner;
import org.testcontainers.containers.MySQLContainer;

import com.picpay.user.search.api.Application;
import com.picpay.user.search.api.user.model.User;

@RunWith(SpringRunner.class)
@SpringBootTest(classes = Application.class, webEnvironment = WebEnvironment.RANDOM_PORT)
@ContextConfiguration(initializers = { UserControllerAcceptanceTest.Initializer.class })
public class UserControllerAcceptanceTest {

	@ClassRule
	public static MySQLContainer mysql = new MySQLContainer();

	private static final String KEYWORD = "a";

	private String serverUrl;

	@Autowired
	private TestRestTemplate restTemplate;

	@LocalServerPort
	private int serverPort;

	@Before
	public void setUp() throws Exception {
		serverUrl = "http://localhost:" + serverPort + URI;
	}

	@Test
	public void testRetrieve() throws Exception {
		ResponseEntity<List<User>> response = restTemplate.exchange(serverUrl + "/" + KEYWORD, HttpMethod.GET, null,
				new ParameterizedTypeReference<List<User>>() {
				});
		List<User> users = response.getBody();

		assertEquals(HttpStatus.OK.value(), response.getStatusCodeValue());
		assertTrue(response.getHeaders().containsKey(HttpHeaders.LINK));
		assertEquals("5", response.getHeaders().get(X_TOTAL_COUNT_HEADER).get(0));

		// According to data.sql
		assertEquals(5, users.size());
		assertEquals("5761be9e-3e27-4be8-87bc-5455db08408", users.get(0).getId());
		assertEquals("18c369fe-2b6c-4638-9693-425b13b22948", users.get(1).getId());
		assertEquals("02b6ce38-b23d-446a-b78b-823f360a4f35", users.get(2).getId());
		assertEquals("15d3f155-6a02-4849-9af7-d2cc4148f5a2", users.get(3).getId());
		assertEquals("61423001-c484-4fbf-9ee7-9475fb93cf3c", users.get(4).getId());
	}

	static class Initializer implements ApplicationContextInitializer<ConfigurableApplicationContext> {
		public void initialize(ConfigurableApplicationContext configurableApplicationContext) {
			TestPropertyValues
					.of("spring.datasource.url=" + mysql.getJdbcUrl(),
							"spring.datasource.username=" + mysql.getUsername(),
							"spring.datasource.password=" + mysql.getPassword())
					.applyTo(configurableApplicationContext.getEnvironment());
		}
	}
}