package com.picpay.controller;

import com.picpay.model.User;
import com.picpay.repositories.UserRepository;
import com.picpay.service.UserService;
import com.picpay.util.UserSpecifications;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.data.jpa.domain.Specifications;
import org.springframework.data.rest.webmvc.RepositoryRestController;
import org.springframework.data.web.PagedResourcesAssembler;
import org.springframework.hateoas.PagedResources;
import org.springframework.hateoas.Resource;
import org.springframework.hateoas.Resources;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;

import javax.persistence.criteria.Predicate;
import java.util.Arrays;
import java.util.Comparator;
import java.util.List;
import java.util.stream.Collectors;

/**
 * @author Bruno Carreira
 */
// tag::code[]
@RepositoryRestController
public class UserSearchController {

    @Autowired
    private UserRepository repo;

    @Autowired
    private List<String> listRelevancia1;

    @Autowired
    private List<String> listRelevancia2;

    @Autowired
    private PagedResourcesAssembler<User> pagedAssembler;

    @RequestMapping(value = "/users/search/listUsers", method = RequestMethod.GET)
    public @ResponseBody PagedResources<Resource<User>> search(@RequestParam(value = "nome") String nome, Pageable pageable) {
        String rel1 = listRelevancia1.stream().map(id -> "("+id+",1)").collect(Collectors.joining(","));
        String rel2 = listRelevancia2.stream().map(id -> "("+id+",2)").collect(Collectors.joining(","));

        //users.sort(Comparator.comparing(u->listRelevancia1.indexOf(u.getId())));

        Page<User> users = repo.findAll(Specifications.where(UserSpecifications.containsTextInName(nome)), pageable);

        return pagedAssembler.toResource(users);
    }


}
// end::code[]