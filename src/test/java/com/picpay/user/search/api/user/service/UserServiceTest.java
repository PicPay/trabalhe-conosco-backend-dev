package com.picpay.user.search.api.user.service;

import static com.picpay.user.search.api.user.model.Constants.KEYWORD;
import static com.picpay.user.search.api.user.model.Constants.MAX_PAGE_SIZE_FIELD;
import static com.picpay.user.search.api.user.model.Constants.PAGEABLE;
import static org.junit.Assert.assertEquals;
import static org.mockito.Mockito.verify;
import static org.mockito.Mockito.when;

import org.junit.Before;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.mockito.InjectMocks;
import org.mockito.Mock;
import org.mockito.junit.MockitoJUnitRunner;
import org.springframework.data.domain.Page;
import org.springframework.test.util.ReflectionTestUtils;

import com.picpay.user.search.api.user.model.User;
import com.picpay.user.search.api.user.repository.UserRepository;

@RunWith(MockitoJUnitRunner.class)
public class UserServiceTest {

	@Mock
	private UserRepository mockUserRepository;

	@InjectMocks
	private UserServiceImpl service;

	@Before
	public void setUp() {
		ReflectionTestUtils.setField(service, MAX_PAGE_SIZE_FIELD, 15);
	}

	@Test
	public void findByKeywordOk() {
		Page<User> page = Page.empty();
		when(mockUserRepository.findByKeyword(KEYWORD, PAGEABLE)).thenReturn(page);

		assertEquals(page, service.findByKeyword(KEYWORD, PAGEABLE));

		verify(mockUserRepository).findByKeyword(KEYWORD, PAGEABLE);
	}
}