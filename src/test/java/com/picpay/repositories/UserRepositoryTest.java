package com.picpay.repositories;

import com.picpay.model.User;
import org.junit.Assert;
import org.junit.Before;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.orm.jpa.DataJpaTest;
import org.springframework.boot.test.autoconfigure.web.servlet.WebMvcTest;
import org.springframework.boot.test.mock.mockito.MockBean;
import org.springframework.data.domain.Page;
import org.springframework.http.MediaType;
import org.springframework.test.context.junit4.SpringRunner;
import org.springframework.test.web.servlet.MockMvc;
import org.springframework.test.web.servlet.MvcResult;
import org.springframework.test.web.servlet.request.MockMvcRequestBuilders;

import java.util.Arrays;
import java.util.Collections;

import static org.mockito.Mockito.verify;
import static org.mockito.Mockito.when;

@RunWith(SpringRunner.class)
@DataJpaTest
public class UserRepositoryTest {

    @Autowired
    private UserRepository userRepository;

    @Before
    public void setUp(){
        userRepository.save(new User("id", "name", "username"));
        userRepository.save(new User("id2", "name2", "username2"));
        userRepository.save(new User("id3", "trash", "trash"));
    }

    @Test
    public void shouldReturnUserWithName() throws Exception {
        Page<User> page = userRepository.findByNameContainingOrUsernameContaining("name", "name", null);
        Assert.assertTrue(page.getTotalElements() == 2);
    }

    @Test
    public void shouldUpdatePriority() throws Exception {
        int updated = userRepository.updatePriorityByIds(Arrays.asList("id", "id3"), 4);
        Assert.assertTrue(updated == 2);
    }

}