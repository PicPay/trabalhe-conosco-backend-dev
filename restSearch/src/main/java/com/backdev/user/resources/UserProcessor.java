package com.backdev.user.resources;

import com.backdev.user.entity.User;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.batch.item.ItemProcessor;
import org.springframework.stereotype.Component;

@Component
public class UserProcessor implements ItemProcessor<User, User> {

    private static Logger LOGGER = LoggerFactory.getLogger(UserProcessor.class);

    @Override
    public User process(User user) throws Exception {

        final String uuid = user.getUuid();
        final String name = user.getName();
        final String username = user.getUsername();

        final User transformed = new User(uuid, name, username);

        return transformed;
    }

}
