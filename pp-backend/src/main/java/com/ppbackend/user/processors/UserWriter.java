package com.ppbackend.user.processors;

import com.ppbackend.user.model.User;
import com.ppbackend.user.repository.UserRepository;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.batch.item.ItemWriter;
import org.springframework.beans.factory.InitializingBean;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

import java.util.List;

@Component
public class UserWriter implements ItemWriter<User>, InitializingBean {

    private static Logger LOGGER = LoggerFactory.getLogger(UserWriter.class);

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
