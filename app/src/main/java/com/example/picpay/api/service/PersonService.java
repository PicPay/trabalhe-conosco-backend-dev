package com.example.picpay.api.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import com.example.picpay.api.repository.PersonRepository;

@Service
public class PersonService {

  @Autowired
  private PersonRepository personRepository;
  
  
}
