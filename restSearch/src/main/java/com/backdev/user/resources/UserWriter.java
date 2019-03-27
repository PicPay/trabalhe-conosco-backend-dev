package com.backdev.user.resources;

import com.backdev.user.entity.User;
import com.backdev.user.repository.UserRepository;
import org.springframework.batch.item.ItemWriter;
import org.springframework.beans.factory.InitializingBean;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

import java.util.List;

@Component
public class UserWriter implements ItemWriter<User>, InitializingBean {

    @Autowired
    private UserRepository userRepository;

    @Override
    public void write(List<? extends User> items) throws Exception {
        userRepository.saveAll(items);
    }

    @Override
    public void afterPropertiesSet() throws Exception {

    }
}
