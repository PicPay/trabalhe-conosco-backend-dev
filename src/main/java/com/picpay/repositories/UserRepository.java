package com.picpay.repositories;

import com.picpay.model.User;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.PagingAndSortingRepository;

import java.util.List;

/**
 * @author Bruno Carreira
 */
public interface UserRepository extends PagingAndSortingRepository<User, String> {

    @Query(value = "SELECT * FROM tb_user" +
            "       JOIN (VALUES ?2 as r1(id, ordering) ON tb_user.id = r1.id" +
            "       JOIN (VALUES ?3 as r2(id, ordering) ON tb_user.id = r2.id" +
            "       WHERE (tb_user.name LIKE \"%?1%\") OR (tb_user.username LIKE \"%?1%\")" +
            "       ORDER BY x.ordering;",
            nativeQuery = true)
    List<User> searchByCriteria(String criteria, String relevancia1, String relevancia2);


}