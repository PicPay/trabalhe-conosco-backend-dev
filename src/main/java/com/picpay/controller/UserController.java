package com.picpay.controller;

import com.picpay.model.User;
import com.picpay.service.UserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.rest.webmvc.RepositoryRestController;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;

import java.util.List;

/**
 * @author Bruno Carreira
 */
// tag::code[]
//@RepositoryRestController
public class UserController {

    @Autowired
    private UserService service;
/*
    @GetMapping("/api/search")
    @ResponseStatus(HttpStatus.OK)
    @ResponseBody
    public List<User> search(@RequestParam(value = "nome") String nome) {
        return service.searchUsers(nome);
    }
    */
}
// end::code[]