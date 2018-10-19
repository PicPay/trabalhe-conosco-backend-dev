package com.picpay.repositories;

import com.picpay.model.User;
import org.junit.Assert;
import org.junit.Before;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.orm.jpa.DataJpaTest;
import org.springframework.data.domain.Page;
import org.springframework.test.context.junit4.SpringRunner;

import java.util.Arrays;
import java.util.List;

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
    public void shouldReturnUserWithName() {
        Page<User> page = userRepository.findByNameContainingOrUsernameContainingOrderByPriority("name", "name", null);
        Assert.assertTrue(page.getTotalElements() == 2);
    }

    @Test
    public void shouldUpdatePriority() {
        int updated = userRepository.updatePriorityByIds(Arrays.asList("id", "id3"), 4);
        Assert.assertTrue(updated == 2);
        int updated2 = userRepository.updatePriorityByIds(Arrays.asList("id2"), 2);
        Assert.assertTrue(updated2 == 1);
    }

    @Test
    public void shouldReturnUserWithNameOrdered() {
        userRepository.updatePriorityByIds(Arrays.asList("id", "id3"), 10);
        userRepository.updatePriorityByIds(Arrays.asList("id2"), 8);

        Page<User> page = userRepository.findByNameContainingOrUsernameContainingOrderByPriority("a", "a", null);
        Assert.assertTrue(page.getTotalElements() == 3);
        List<User> list = page.getContent();
        User user = list.get(0);
        Assert.assertTrue(user.getId().equals("id2"));
    }

}