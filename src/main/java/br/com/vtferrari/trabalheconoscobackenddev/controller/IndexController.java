package br.com.vtferrari.trabalheconoscobackenddev.controller;

import br.com.vtferrari.trabalheconoscobackenddev.model.User;
import br.com.vtferrari.trabalheconoscobackenddev.repository.TestRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;


@RestController
public class IndexController {
    @Autowired
    TestRepository testRepository;

    @GetMapping("/")
    public Page<User> index() {
        return testRepository.findAll(PageRequest.of(0, 10));
    }
}