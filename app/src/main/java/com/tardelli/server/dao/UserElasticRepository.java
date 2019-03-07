package com.tardelli.server.dao;

import com.tardelli.server.model.User;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.elasticsearch.repository.ElasticsearchRepository;

import java.util.List;

public interface UserElasticRepository extends ElasticsearchRepository<User, String> {

    Page<User> findByUserNameOrNameContaining(String userName, String name, Pageable pageable);

}