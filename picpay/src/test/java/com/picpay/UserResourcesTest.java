package com.picpay;


import static org.mockito.Mockito.when;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.status;

import java.util.ArrayList;

import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.web.servlet.AutoConfigureMockMvc;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.boot.test.mock.mockito.MockBean;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.security.test.context.support.WithMockUser;
import org.springframework.test.context.junit4.SpringRunner;
import org.springframework.test.web.servlet.MockMvc;
import org.springframework.test.web.servlet.RequestBuilder;
import org.springframework.test.web.servlet.request.MockMvcRequestBuilders;

import com.picpay.repository.UserFilter;
import com.picpay.service.UserMongoService;


@RunWith(SpringRunner.class)
@SpringBootTest
@AutoConfigureMockMvc
public class UserResourcesTest {

	@Autowired
	private MockMvc mvc;
	
	
	@MockBean
	private UserMongoService usuarioMongoService;
	

	@Test
	@WithMockUser("picpay")
	public void setUp() throws Exception {
		
		Pageable unpaged = Pageable.unpaged();
		
		when(usuarioMongoService.findUsers(new UserFilter(),unpaged)).thenReturn(new PageImpl<>(new ArrayList<>()));
		
		RequestBuilder requestBuilder = MockMvcRequestBuilders.get("/resources/users");
		
		mvc.perform(requestBuilder)
			.andExpect(status().isOk());
	}
}
