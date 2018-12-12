package com.picpay.user.search.api.user.repository;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.stereotype.Repository;

import com.picpay.user.search.api.user.model.User;

@Repository
public interface UserRepository extends JpaRepository<User, String> {

	@Query(name = "User.findByKeyword")
	Page<User> findByKeyword(String keyword, Pageable pageable);
}