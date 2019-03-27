package com.backdev.file.resources;

import com.backdev.user.entity.User;
import com.backdev.user.resources.UserProcessor;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.batch.item.ItemProcessor;
import org.springframework.stereotype.Component;

@Component
public class UuidProcessor implements ItemProcessor<Uuid, Uuid> {

    private static Logger LOGGER = LoggerFactory.getLogger(UserProcessor.class);

    @Override
    public Uuid process(Uuid uuid) throws Exception {
        String _uuid = uuid.getUuid();
        Uuid transformed = new Uuid(_uuid);
        return transformed;
    }
}