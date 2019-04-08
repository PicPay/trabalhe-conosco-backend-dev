package com.ppbackend.file.processors;

import com.ppbackend.user.model.User;
import com.ppbackend.user.repository.UserRepository;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.batch.item.ItemProcessor;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

import java.util.concurrent.atomic.AtomicInteger;

@Component
public class UuidProcessor implements ItemProcessor<Uuid, Uuid> {

    private static Logger LOGGER = LoggerFactory.getLogger(UuidProcessor.class);

    @Autowired
    private UserRepository userRepository;

    private static AtomicInteger counter = new AtomicInteger(Integer.MAX_VALUE);

    @Override
    public Uuid process(Uuid uuid) throws Exception {
        String _uuid = uuid.getUuid();
        Uuid transformed = new Uuid(_uuid);

        User user = userRepository.findByUuid(_uuid);
        LOGGER.info("User score : {}",user.toString());
        synchronized (counter) {
            user.setScore(counter.getAndDecrement());
            userRepository.save(user);
        }
        LOGGER.info("Processed user : {}",user.toString());
        return transformed;
    }
}