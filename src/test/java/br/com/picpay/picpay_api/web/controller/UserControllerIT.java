package br.com.picpay.picpay_api.web.controller;

import br.com.picpay.picpay_api.entity.User;
import br.com.picpay.picpay_api.repo.UserRepository;
import br.com.picpay.picpay_api.utils.BaseIntegrationTest;
import br.com.picpay.picpay_api.utils.TestHelper;
import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.web.client.TestRestTemplate;
import org.springframework.http.HttpEntity;
import org.springframework.http.ResponseEntity;

import java.util.List;

import static java.util.Arrays.asList;
import static org.assertj.core.api.Assertions.assertThat;
import static org.springframework.http.HttpStatus.NOT_FOUND;
import static org.springframework.http.HttpStatus.OK;

public class UserControllerIT extends BaseIntegrationTest {

    @Autowired
    UserRepository userRepository;

    @Autowired
    TestRestTemplate restTemplate;

    User existingUser, newUser, updateUser;

    @Before
    public void setUp() {
        newUser = TestHelper.buildUser();

        existingUser = TestHelper.buildUser();
        existingUser = userRepository.save(existingUser);

        updateUser = TestHelper.buildUser();
        updateUser = userRepository.save(updateUser);
        
        userRepository.getByNameAndUsername("name", "name");
    }

    @After
    public void tearDown() {
        if(newUser.getId() != null) {
            userRepository.deleteById(newUser.getId());
        }
        userRepository.deleteAll(userRepository.findAllById(asList(existingUser.getId(), updateUser.getId())));
    }

    @Test
    public void should_get_all_users() {
        ResponseEntity<User[]> responseEntity = restTemplate.getForEntity("/api/users", User[].class);
        List<User> users = asList(responseEntity.getBody());
        assertThat(users).isNotEmpty();
    }

    @Test
    public void should_get_user_by_id() {
        ResponseEntity<User> responseEntity = restTemplate.getForEntity("/api/users/"+existingUser.getId(), User.class);
        User user = responseEntity.getBody();
        assertThat(user).isNotNull();
    }

    @Test
    public void should_create_user() {
        HttpEntity<User> request = new HttpEntity<>(newUser);
        ResponseEntity<User> responseEntity = restTemplate.postForEntity("/api/users", request, User.class);
        User savedUser = responseEntity.getBody();
        assertThat(savedUser.getId()).isNotNull();
    }

    @Test
    public void should_update_user() {
        HttpEntity<User> request = new HttpEntity<>(updateUser);
        restTemplate.put("/api/users/"+updateUser.getId(), request, User.class);
        ResponseEntity<User> responseEntity = restTemplate.getForEntity("/api/users/"+updateUser.getId(), User.class);
        User updatedUser = responseEntity.getBody();
        assertThat(updatedUser.getId()).isEqualTo(updateUser.getId());
        assertThat(updatedUser.getUsername()).isEqualTo(updateUser.getUsername());
    }

    @Test
    public void should_delete_user() {
        ResponseEntity<User> responseEntity = restTemplate.getForEntity("/api/users/"+existingUser.getId(), User.class);
        assertThat(responseEntity.getStatusCode()).isEqualTo(OK);
        restTemplate.delete("/api/users/"+existingUser.getId());
        responseEntity = restTemplate.getForEntity("/api/users/"+existingUser.getId(), User.class);
        assertThat(responseEntity.getStatusCode()).isEqualTo(NOT_FOUND);
    }
}