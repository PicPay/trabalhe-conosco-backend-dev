package com.picpay.user.search.api.user.controller;

import static com.picpay.user.search.api.user.model.Constants.ID;
import static com.picpay.user.search.api.user.model.Constants.KEYWORD;
import static com.picpay.user.search.api.user.model.Constants.NAME;
import static com.picpay.user.search.api.user.model.Constants.PAGEABLE;
import static com.picpay.user.search.api.user.model.Constants.USERNAME;
import static com.picpay.user.search.api.user.model.Constants.X_TOTAL_COUNT_HEADER;
import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertFalse;
import static org.mockito.Mockito.verify;
import static org.mockito.Mockito.verifyZeroInteractions;
import static org.mockito.Mockito.when;

import java.util.Collections;
import java.util.List;

import org.junit.Before;
import org.junit.Ignore;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.mockito.ArgumentMatchers;
import org.mockito.InjectMocks;
import org.mockito.Mock;
import org.mockito.junit.MockitoJUnitRunner;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.web.PagedResourcesAssembler;
import org.springframework.hateoas.Link;
import org.springframework.hateoas.PagedResources;
import org.springframework.hateoas.PagedResources.PageMetadata;
import org.springframework.hateoas.Resource;
import org.springframework.http.HttpHeaders;
import org.springframework.http.ResponseEntity;

import com.picpay.user.search.api.user.model.User;
import com.picpay.user.search.api.user.service.UserService;

@RunWith(MockitoJUnitRunner.class)
public class UserControllerTest {

	private User user;

	private Link link;

	private HttpHeaders headers;

	@Mock
	private PagedResourcesAssembler<User> mockAssembler;

	@Mock
	private UserService mockUserService;

	@InjectMocks
	private UserController controller;

	@Before
	public void setUp() {
		user = new User();
		user.setId(ID);
		user.setName(NAME);
		user.setUsername(USERNAME);

		link = new Link("http://localhost:8080/v1/api/users" + "/" + KEYWORD);

		Resource<User> resource = new Resource<>(user, link);
		PageMetadata metadata = new PagedResources.PageMetadata(15, 0, 1);
		PagedResources<Resource<User>> pr = new PagedResources<>(Collections.singletonList(resource), metadata,
				resource.getLinks());
		when(mockAssembler.toResource(ArgumentMatchers.<Page<User>>any())).thenReturn(pr);

		headers = new HttpHeaders();
		headers.add(HttpHeaders.LINK, link.toString());
		headers.add(X_TOTAL_COUNT_HEADER, "1");
	}

	@Test
	public void retrieveOk() throws Exception {
		Page<User> page = new PageImpl<>(Collections.singletonList(user));
		when(mockUserService.findByKeyword(KEYWORD, PAGEABLE)).thenReturn(page);

		assertEquals(ResponseEntity.ok().headers(headers).body(page.getContent()),
				controller.retrieve(KEYWORD, PAGEABLE));

		verify(mockUserService).findByKeyword(KEYWORD, PAGEABLE);
		verify(mockAssembler).toResource(page);
	}

	@Test
	public void retrieveNoContentsPageNull() throws Exception {
		retrieveNoContents(null);
	}

	@Test
	public void retrieveNoContentsPageEmpty() throws Exception {
		retrieveNoContents(Page.empty());
	}

	// This test scenario is not possible with Spring Data as Page instances does
	// not allow null contents. Anyway, the test is already implemented in case of
	// implementation changes.
	@Test
	@Ignore
	public void retrieveNoContentsPageContentNull() throws Exception {
		retrieveNoContents(new PageImpl<>(null));
	}

	@Test
	public void retrieveNoContentsPageContentEmpty() throws Exception {
		retrieveNoContents(new PageImpl<>(Collections.emptyList()));
	}

	private void retrieveNoContents(Page<User> page) {
		when(mockUserService.findByKeyword(KEYWORD, PAGEABLE)).thenReturn(page);

		ResponseEntity<List<User>> result = controller.retrieve(KEYWORD, PAGEABLE);

		assertEquals(ResponseEntity.noContent().build(), result);
		assertFalse(result.getHeaders().containsKey(HttpHeaders.LINK));
		assertFalse(result.getHeaders().containsKey(X_TOTAL_COUNT_HEADER));

		verify(mockUserService).findByKeyword(KEYWORD, PAGEABLE);
		verifyZeroInteractions(mockAssembler);
	}
}