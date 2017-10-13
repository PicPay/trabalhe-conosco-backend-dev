/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.picpay.demo.controller;

import com.picpay.demo.core.User;
import com.picpay.demo.service.UserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

/**
 *
 * @author Carlos Eduardo
 */
@RestController
@RequestMapping("/users")
public class UserRestController {

    @Autowired
    private UserService userService;

    @RequestMapping(path = {"/search"}, method = RequestMethod.GET, produces = "application/json")
    public Iterable<User> search(@RequestParam(name = "page", defaultValue = "0", required = false) int page,
            @RequestParam(name = "pageSize", defaultValue = "15", required = false) int pageSize,
            @RequestParam(name = "q") String q) {
        return userService.search(q, page, pageSize);
    }
}
