package com.example.es.repository;

import com.example.es.domain.UsrData;

import org.springframework.data.mongodb.repository.MongoRepository;;

public interface UsrDataMongoRepository extends MongoRepository<UsrData, String> {
   
}