package com.backdev.file.resources;

import org.springframework.batch.item.ItemWriter;
import org.springframework.beans.factory.InitializingBean;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

import java.util.List;

@Component
public class UuidWriter implements ItemWriter<Uuid>, InitializingBean {

    @Autowired
    private UuidRepository uuidRepository;

    @Override
    public void write(List<? extends Uuid> items) throws Exception {
        uuidRepository.saveAll(items);
    }

    @Override
    public void afterPropertiesSet() throws Exception {

    }
}