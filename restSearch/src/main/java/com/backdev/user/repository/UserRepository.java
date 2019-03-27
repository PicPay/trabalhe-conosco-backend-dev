package com.backdev.user.repository;

import com.backdev.user.entity.User;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.elasticsearch.repository.ElasticsearchRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface UserRepository extends ElasticsearchRepository<User, String> {
    User findByUsername(String username);
    User findByUuid(String Uuid);
    Page<User> findAll(Pageable pageable);
}
