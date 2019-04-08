package com.ppbackend.file.api;

import com.ppbackend.file.processors.Uuid;
import com.ppbackend.file.processors.UuidRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.Optional;


@RestController
@RequestMapping(path = "uuid")
public class UuidApi {

    @Autowired
    private UuidRepository uuidRepository;

    @GetMapping(path = "/{uuid}")
    public Optional<Uuid> getUuidList(@PathVariable("uuid") String uuid) {
        return uuidRepository.findById(uuid);
    }

    @GetMapping
    public Page<Uuid> getAll() {
        return uuidRepository.findAll(PageRequest.of(1, 20));
    }

}
