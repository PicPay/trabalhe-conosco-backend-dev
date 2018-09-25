package com.picpay.repositories;

import com.picpay.model.User;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.PagingAndSortingRepository;

/**
 * @author Bruno Carreira
 */
public interface UserRepository extends PagingAndSortingRepository<User, String> {
    @Query(value = "LOAD DATA LOCAL INFILE :filename INTO TABLE tb_user;",
            nativeQuery = true)
    void bulkLoad(String filename);


}