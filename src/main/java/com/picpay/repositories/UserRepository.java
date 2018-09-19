package com.picpay.repositories;

import com.picpay.model.User;
import org.springframework.data.repository.PagingAndSortingRepository;

/**
 * @author Bruno Carreira
 */
public interface UserRepository extends PagingAndSortingRepository<User, String> {
}