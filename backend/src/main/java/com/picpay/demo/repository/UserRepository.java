/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.picpay.demo.repository;

import com.picpay.demo.core.User;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;

import org.springframework.data.repository.PagingAndSortingRepository;

/**
 *
 * @author Carlos Eduardo
 */
public interface UserRepository extends PagingAndSortingRepository<User, String> {

    @Query(value = "SELECT u.id, u.name, u.username, u.weight FROM {h-schema}user u WHERE u.tsv @@ plainto_tsquery(?1) ORDER BY u.weight, ?#{#pageable}",
            countQuery = "SELECT COUNT(*) FROM {h-schema}user WHERE tsv @@ plainto_tsquery(?1)",
            nativeQuery = true)
    Page<User> search(String keyword, Pageable pageable);

    @Modifying
    @Query(value = "UPDATE {h-schena}.user SET tsv = TO_TSVECTOR(name || ' ' || username) WHERE id = ?1", nativeQuery = true)
    void updateTsv(String id);
}
