package com.picpay.repositories;

import com.picpay.model.User;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.PagingAndSortingRepository;
import org.springframework.data.repository.query.Param;
import org.springframework.data.rest.core.annotation.RepositoryRestResource;
import org.springframework.data.rest.core.annotation.RestResource;

import java.util.List;

/**
 * @author Bruno Carreira
 */

public interface UserRepository extends PagingAndSortingRepository<User, String> {
/*
    @Query(value = "Select u from User u " +
            " left outer join VALUES (1232, 1), (43321, 1) as r1(id, ordering) ON u.id = r1.id" +
            " where (u.name like %:nome%) or (u.username like %:nome%)")
    @RestResource(path = "searchNome", rel = "searchNome")
    Page<User> findByNome(@Param("nome") String nome, Pageable p);
*/
    @Query(value = "SELECT * FROM tb_user u " +
            " left outer join (VALUES (1232, 1), (43321, 1) as r1(id, ordering)) ON u.id = r1.id" +
            " where (u.name like %:name%) or (u.username like %:name%) order by u.id \n-- #pageable\n",
            countQuery = "SELECT count(*) FROM tb_user",
            nativeQuery = true
    )
/*            "       LEFT OUTER JOIN (VALUES ?2 as r1(id, ordering) ON tb_user.id = r1.id" +
            "       LEFT OUTER JOIN (VALUES ?3 as r2(id, ordering) ON tb_user.id = r2.id" +
            " where (u.name like %:nome%) or (u.username like %:nome%)" +
            "       ORDER BY x.ordering \n#pageable\n")*/
    @RestResource(path = "searchName", rel = "searchName")
    Page<User> findByName(@Param("name") String name, Pageable pageable);


}