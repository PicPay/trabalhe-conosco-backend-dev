package br.com.picpay.challenge.backend.user;

import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertNotNull;
import static org.junit.Assert.assertTrue;

import java.io.IOException;
import java.io.InputStream;
import java.io.StringWriter;
import java.nio.charset.StandardCharsets;
import java.util.Arrays;
import java.util.List;
import java.util.UUID;

import org.apache.commons.io.IOUtils;
import org.elasticsearch.action.admin.indices.delete.DeleteIndexRequest;
import org.elasticsearch.client.Response;
import org.elasticsearch.client.RestHighLevelClient;
import org.junit.Before;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.http.HttpStatus;
import org.springframework.test.context.ActiveProfiles;
import org.springframework.test.context.junit4.SpringRunner;

import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;

import br.com.picpay.challenge.backend.es.support.SimpleIndexStats;
import br.com.picpay.challenge.backend.model.support.NavDirection;
import br.com.picpay.challenge.backend.model.support.Page;

@RunWith(SpringRunner.class)
@SpringBootTest
@ActiveProfiles("test")
public class UserRepositoryTest {

	private static final ObjectMapper JSON_MAPPER = new ObjectMapper();
	
	@Autowired
	private UserRepository userRepository;
	
	@Autowired
	private RestHighLevelClient esClient;
	
	@Before
	public void setUp() throws IOException {
		esClient.indices().delete(new DeleteIndexRequest(UserRepository.USER_INDEX));
		userRepository.createIndex();
	}
	
	@Test
	public void shouldCheckIfIndexExists() {
		assertTrue(userRepository.indexExists());
	}
	
	@Test
	public void shouldPrepareIndexForBulkOperations() throws IOException {
		userRepository.prepareIndexForBulkOperation();
		
		String refreshInterval = getRefreshInterval(UserRepository.USER_INDEX);
		assertEquals("-1", refreshInterval);
		
		userRepository.restoreDefaultIndexSettings();
		refreshInterval = getRefreshInterval(UserRepository.USER_INDEX);
		assertEquals(UserRepository.DEFAULT_REFRESH_INTERVAL, refreshInterval);
	}
	
	private String getRefreshInterval(String index) throws IOException {
		final String URI = String.format("/%s/_settings/index.refresh_interval", index);
		Response response = esClient.getLowLevelClient().performRequest("GET", URI);
		if (HttpStatus.valueOf(response.getStatusLine().getStatusCode()).is2xxSuccessful()) {
			String responseContent;
			try (InputStream input = response.getEntity().getContent();
					StringWriter output = new StringWriter()) {
				IOUtils.copy(input, output, StandardCharsets.UTF_8);
				responseContent = output.toString();
			}
			JsonNode rootNode = JSON_MAPPER.readTree(responseContent);
			JsonNode userNode = rootNode.get("user");
			if (userNode != null) {
				JsonNode settingsNode = userNode.get("settings");
				if (settingsNode != null) {
					JsonNode indexNode = settingsNode.get("index");
					if (indexNode != null) {
						JsonNode refreshIntervalNode = indexNode.get("refresh_interval");
						if (refreshIntervalNode != null) {
							return refreshIntervalNode.asText();
						}
					}
				}
			}
		}
		return null;
	}

	@Test
	public void shouldGetIndexStats() throws Exception {
		User user = new User(UUID.randomUUID().toString(), "James Tiberius Kirk", "kirk", 0);
		userRepository.index(user);
		
		userRepository.refreshIndex();
		
		SimpleIndexStats indexStats = userRepository.getIndexStats();
		
		assertNotNull(indexStats);
		assertEquals(1, indexStats.getTotalDocs());
		assertTrue(indexStats.getTotalSize() > 100L);
	}
	
	@Test
	public void shouldIndexUser() {
		User user = new User(UUID.randomUUID().toString(), "James Tiberius Kirk", "kirk", 0);
		userRepository.index(user);
		
		User stored = userRepository.findById(user.getId());
		assertNotNull(stored);
		assertEquals(user.getId(), stored.getId());
		assertEquals(user.getName(), stored.getName());
		assertEquals(user.getUsername(), stored.getUsername());
		assertEquals(user.getPriority(), stored.getPriority());
	}
	
	@Test
	public void shouldBulkIndexUsers() {
		List<User> users = Arrays.asList(
			new User(UUID.randomUUID().toString(), "James Tiberius Kirk", "kirk", 0),
			new User(UUID.randomUUID().toString(), "James Franco", "james", 0)
		);
		userRepository.bulkIndex(users);
		
		for (User user : users) {
			User stored = userRepository.findById(user.getId());
			assertNotNull(stored);
			assertEquals(user.getId(), stored.getId());
			assertEquals(user.getName(), stored.getName());
			assertEquals(user.getUsername(), stored.getUsername());
			assertEquals(user.getPriority(), stored.getPriority());
		}
	}
	
	@Test
	public void shouldFindIndexedData() {
		User james = new User("1", "James T. Kirk", "james", 0);
		User chris = new User("2", "Chris Kirk", "chris", 0);
		User willian = new User("3", "Willian Kirk", "willian", 0);
		User jamesFranco = new User("4", "James Franco", "james.franco", 0);
		List<User> users = Arrays.asList(
			james,
			chris,
			willian,
			jamesFranco
		);
		userRepository.bulkIndex(users);
		
		//Força atualização do índice
		userRepository.refreshIndex();
			
		Page<User> page = userRepository.findByNameOrUsername("kirk", null, NavDirection.NEXT, 2);
		assertEquals(1, page.getSearchMetadata().getPage());
		assertEquals(2, page.getSearchMetadata().getTotalPages());
		assertEquals(2, page.getSearchMetadata().getPageSize());
		assertEquals(3, page.getSearchMetadata().getTotalElements());
		
		assertEquals(2, page.getContent().size());
		
		assertEquals(willian.getId(), page.getContent().get(0).getId());
		assertEquals(willian.getName(), page.getContent().get(0).getName());
		assertEquals(willian.getUsername(), page.getContent().get(0).getUsername());
		assertEquals(willian.getPriority(), page.getContent().get(0).getPriority());
		
		assertEquals(chris.getId(), page.getContent().get(1).getId());
		assertEquals(chris.getName(), page.getContent().get(1).getName());
		assertEquals(chris.getUsername(), page.getContent().get(1).getUsername());
		assertEquals(chris.getPriority(), page.getContent().get(1).getPriority());
	}

	@Test
	public void shouldFindIndexedDataSorting() {
		User james = new User(UUID.randomUUID().toString(), "James T. Kirk", "james", 0);
		User chris = new User(UUID.randomUUID().toString(), "Chris Kirk", "chris", 2);
		User willian = new User(UUID.randomUUID().toString(), "Willian Kirk", "willian", 1);
		User jamesFranco = new User(UUID.randomUUID().toString(), "James Franco", "james.franco", 0);
		List<User> users = Arrays.asList(
			james,
			chris,
			willian,
			jamesFranco
		);
		userRepository.bulkIndex(users);
		
		//Força atualização do índice
		userRepository.refreshIndex();
			
		Page<User> page = userRepository.findByNameOrUsername("kirk", null, NavDirection.NEXT, 3);
		assertEquals(1, page.getSearchMetadata().getPage());
		assertEquals(1, page.getSearchMetadata().getTotalPages());
		assertEquals(3, page.getSearchMetadata().getPageSize());
		assertEquals(3, page.getSearchMetadata().getTotalElements());
		
		assertEquals(3, page.getContent().size());
		
		assertEquals(james.getId(), page.getContent().get(0).getId());
		assertEquals(james.getName(), page.getContent().get(0).getName());
		assertEquals(james.getUsername(), page.getContent().get(0).getUsername());
		assertEquals(james.getPriority(), page.getContent().get(0).getPriority());
		
		assertEquals(willian.getId(), page.getContent().get(1).getId());
		assertEquals(willian.getName(), page.getContent().get(1).getName());
		assertEquals(willian.getUsername(), page.getContent().get(1).getUsername());
		assertEquals(willian.getPriority(), page.getContent().get(1).getPriority());
		
		assertEquals(chris.getId(), page.getContent().get(2).getId());
		assertEquals(chris.getName(), page.getContent().get(2).getName());
		assertEquals(chris.getUsername(), page.getContent().get(2).getUsername());
		assertEquals(chris.getPriority(), page.getContent().get(2).getPriority());
	}
	
	@Test
	public void shouldFindIndexedDataAndPaginateResult() {
		User james = new User(UUID.randomUUID().toString(), "James T. Kirk", "james", 0);
		User chris = new User(UUID.randomUUID().toString(), "Chris Kirk", "chris", 2);
		User willian = new User(UUID.randomUUID().toString(), "Willian Kirk", "willian", 1);
		User jamesFranco = new User(UUID.randomUUID().toString(), "James Franco", "james.franco", 0);
		List<User> users = Arrays.asList(
			james,
			chris,
			willian,
			jamesFranco
		);
		userRepository.bulkIndex(users);
		
		//Força atualização do índice
		userRepository.refreshIndex();
		
		Page<User> page1 = userRepository.findByNameOrUsername("kirk", null, NavDirection.NEXT, 2);
			
		Page<User> page2 = userRepository.findByNameOrUsername("kirk", page1.getSearchMetadata().getNavRef(), NavDirection.NEXT, 2);
		assertEquals(2, page2.getSearchMetadata().getPage());
		assertEquals(2, page2.getSearchMetadata().getTotalPages());
		assertEquals(2, page2.getSearchMetadata().getPageSize());
		assertEquals(3, page2.getSearchMetadata().getTotalElements());
		
		assertEquals(1, page2.getContent().size());
		
		assertEquals(chris.getId(), page2.getContent().get(0).getId());
		assertEquals(chris.getName(), page2.getContent().get(0).getName());
		assertEquals(chris.getUsername(), page2.getContent().get(0).getUsername());
		assertEquals(chris.getPriority(), page2.getContent().get(0).getPriority());
	}
	
	@Test
	public void shouldNavigateInPaginationResult() {
		User james = new User(UUID.randomUUID().toString(), "James T. Kirk", "james", 1);
		User chris = new User(UUID.randomUUID().toString(), "Chris Kirk", "chris", 2);
		User willian = new User(UUID.randomUUID().toString(), "Willian Kirk", "willian", 3);
		User jamesFranco = new User(UUID.randomUUID().toString(), "James Franco Kirk", "james.franco", 4);
		List<User> users = Arrays.asList(
			james,
			chris,
			willian,
			jamesFranco
		);
		userRepository.bulkIndex(users);
		
		//Força atualização do índice
		userRepository.refreshIndex();
		
		Page<User> page1 = userRepository.findByNameOrUsername("kirk", null, NavDirection.NEXT, 1);
		assertEquals(1, page1.getSearchMetadata().getPage());
		assertEquals(4, page1.getSearchMetadata().getTotalPages());
		assertEquals(1, page1.getSearchMetadata().getPageSize());
		assertEquals(4, page1.getSearchMetadata().getTotalElements());
		
		assertEquals(1, page1.getContent().size());
		
		assertEquals(james.getId(), page1.getContent().get(0).getId());
		assertEquals(james.getName(), page1.getContent().get(0).getName());
		assertEquals(james.getUsername(), page1.getContent().get(0).getUsername());
		assertEquals(james.getPriority(), page1.getContent().get(0).getPriority());
		
		Page<User> page2 = userRepository.findByNameOrUsername("kirk", page1.getSearchMetadata().getNavRef(), NavDirection.NEXT, 1);
		assertEquals(2, page2.getSearchMetadata().getPage());
		assertEquals(4, page2.getSearchMetadata().getTotalPages());
		assertEquals(1, page2.getSearchMetadata().getPageSize());
		assertEquals(4, page2.getSearchMetadata().getTotalElements());
		
		assertEquals(1, page2.getContent().size());
		
		assertEquals(chris.getId(), page2.getContent().get(0).getId());
		assertEquals(chris.getName(), page2.getContent().get(0).getName());
		assertEquals(chris.getUsername(), page2.getContent().get(0).getUsername());
		assertEquals(chris.getPriority(), page2.getContent().get(0).getPriority());
		
		Page<User> page3 = userRepository.findByNameOrUsername("kirk", page2.getSearchMetadata().getNavRef(), NavDirection.NEXT, 1);
		assertEquals(3, page3.getSearchMetadata().getPage());
		assertEquals(4, page3.getSearchMetadata().getTotalPages());
		assertEquals(1, page3.getSearchMetadata().getPageSize());
		assertEquals(4, page3.getSearchMetadata().getTotalElements());
		
		assertEquals(1, page3.getContent().size());
		
		assertEquals(willian.getId(), page3.getContent().get(0).getId());
		assertEquals(willian.getName(), page3.getContent().get(0).getName());
		assertEquals(willian.getUsername(), page3.getContent().get(0).getUsername());
		assertEquals(willian.getPriority(), page3.getContent().get(0).getPriority());
		
		page2 = userRepository.findByNameOrUsername("kirk", page3.getSearchMetadata().getNavRef(), NavDirection.PREV, 1);
		assertEquals(2, page2.getSearchMetadata().getPage());
		assertEquals(4, page2.getSearchMetadata().getTotalPages());
		assertEquals(1, page2.getSearchMetadata().getPageSize());
		assertEquals(4, page2.getSearchMetadata().getTotalElements());
		
		assertEquals(1, page2.getContent().size());
		
		assertEquals(chris.getId(), page2.getContent().get(0).getId());
		assertEquals(chris.getName(), page2.getContent().get(0).getName());
		assertEquals(chris.getUsername(), page2.getContent().get(0).getUsername());
		assertEquals(chris.getPriority(), page2.getContent().get(0).getPriority());
	}
	
	@Test
	public void shouldReturnEmptyPageWhenNoDataFound() {
		User james = new User(UUID.randomUUID().toString(), "James T. Kirk", "james", 0);
		User chris = new User(UUID.randomUUID().toString(), "Chris Kirk", "chris", 2);
		User willian = new User(UUID.randomUUID().toString(), "Willian Kirk", "willian", 1);
		User jamesFranco = new User(UUID.randomUUID().toString(), "James Franco", "james.franco", 0);
		List<User> users = Arrays.asList(
			james,
			chris,
			willian,
			jamesFranco
		);
		userRepository.bulkIndex(users);
		
		//Força atualização do índice
		userRepository.refreshIndex();
			
		Page<User> page = userRepository.findByNameOrUsername("data", null, NavDirection.NEXT, 3);
		assertEquals(1, page.getSearchMetadata().getPage());
		assertEquals(0, page.getSearchMetadata().getTotalPages());
		assertEquals(3, page.getSearchMetadata().getPageSize());
		assertEquals(0, page.getSearchMetadata().getTotalElements());
		
		assertEquals(0, page.getContent().size());
	}
	
}
