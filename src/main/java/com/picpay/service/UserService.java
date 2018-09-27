package com.picpay.service;

import com.picpay.model.User;
import com.picpay.repositories.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;

import java.util.List;
import java.util.stream.Collectors;

public class UserService {

    UserRepository repository;

    @Autowired
    List<String> listRelevancia1;

    @Autowired
    List<String> listRelevancia2;

    @Autowired
    public UserService(UserRepository repository){
        this.repository = repository;
    }

    public List<User> searchUsers(String criteria){
        //String rel1 = listRelevancia1.stream().map(id -> "("+id+",1),").reduce("", String::concat);
        String rel1 = listRelevancia1.stream().map(id -> "("+id+",1)").collect(Collectors.joining(","));
        String rel2 = listRelevancia1.stream().map(id -> "("+id+",2)").collect(Collectors.joining(","));
        return repository.searchByCriteria(criteria, rel1, rel2);
    }
}
