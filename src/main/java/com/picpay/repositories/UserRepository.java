package com.picpay.repositories;

import com.picpay.model.User;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.data.repository.PagingAndSortingRepository;

/**
 * @author Bruno Carreira
 */

public interface UserRepository extends PagingAndSortingRepository<User, String> {
    Page<User> findAll(Specification<User> spec, Pageable pageable);
}