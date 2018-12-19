package br.com.picpay.picpay_api.web.controller;

import static org.hamcrest.Matchers.hasSize;
import static org.hamcrest.Matchers.is;
import static org.hamcrest.Matchers.notNullValue;
import static org.mockito.BDDMockito.given;
import static org.mockito.Mockito.doNothing;
import static org.springframework.test.web.servlet.request.MockMvcRequestBuilders.delete;
import static org.springframework.test.web.servlet.request.MockMvcRequestBuilders.get;
import static org.springframework.test.web.servlet.request.MockMvcRequestBuilders.post;
import static org.springframework.test.web.servlet.request.MockMvcRequestBuilders.put;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.jsonPath;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.status;

import java.util.Arrays;
import java.util.Optional;

import org.junit.Before;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.web.servlet.WebMvcTest;
import org.springframework.boot.test.mock.mockito.MockBean;
import org.springframework.http.MediaType;
import org.springframework.test.context.junit4.SpringRunner;
import org.springframework.test.web.servlet.MockMvc;

import com.fasterxml.jackson.databind.ObjectMapper;

import br.com.picpay.picpay_api.entity.User;
import br.com.picpay.picpay_api.service.DataService;
import br.com.picpay.picpay_api.service.UserService;
import br.com.picpay.picpay_api.utils.TestHelper;

@RunWith(SpringRunner.class)
@WebMvcTest(controllers = UserController.class)
public class UserControllerTests {

    @MockBean
    UserService userService;

    @MockBean
    DataService dataService;
    
    @Autowired
    private MockMvc mockMvc;

    ObjectMapper objectMapper = new ObjectMapper();

    User existingUser, newUser, updateUser;

    @Before
    public void setUp() {
        newUser = TestHelper.buildUserWithId();
        existingUser = TestHelper.buildUserWithId();
        updateUser = TestHelper.buildUserWithId();
    }

    @Test
    public void should_get_all_users() throws Exception {
        given(userService.getAllUsers(1)).willReturn(Arrays.asList(existingUser, updateUser));
        
        this.mockMvc
                .perform(get("/api/users"))
                .andExpect(status().isOk())
                .andExpect(jsonPath("$", hasSize(2)));
    }

    @Test
    public void should_get_user_by_id() throws Exception {
        given(userService.getUserById(existingUser.getId())).willReturn(Optional.of(existingUser));

        this.mockMvc
                .perform(get("/api/users/"+existingUser.getId()))
                .andExpect(status().isOk())
                .andExpect(jsonPath("$.id", is(existingUser.getId())))
                .andExpect(jsonPath("$.name", is(existingUser.getName())))
                .andExpect(jsonPath("$.username", is(existingUser.getUsername())));
    }

    @Test
    public void should_create_user() throws Exception {
        given(userService.createUser(newUser)).willReturn(newUser);

        this.mockMvc
                .perform(post("/api/users/")
                        .contentType(MediaType.APPLICATION_JSON)
                        .content(objectMapper.writeValueAsString(newUser))
                )
                .andExpect(status().isCreated())
                .andExpect(jsonPath("$.id", notNullValue()))
                .andExpect(jsonPath("$.name", is(newUser.getName())))
                .andExpect(jsonPath("$.username", is(newUser.getUsername())));
    }

    @Test
    public void should_update_user() throws Exception {
        given(userService.updateUser(existingUser)).willReturn(existingUser);

        this.mockMvc
                .perform(put("/api/users/"+existingUser.getId())
                        .contentType(MediaType.APPLICATION_JSON)
                        .content(objectMapper.writeValueAsString(existingUser))
                )
                .andExpect(status().isOk())
                .andExpect(jsonPath("$.id", is(existingUser.getId())))
                .andExpect(jsonPath("$.name", is(existingUser.getName())))
                .andExpect(jsonPath("$.username", is( existingUser.getUsername())));
    }

    @Test
    public void should_delete_user() throws Exception {
        doNothing().when(userService).deleteUser(existingUser.getId());

        this.mockMvc
                .perform(delete("/api/users/"+existingUser.getId()))
                .andExpect(status().isOk());
    }

}
