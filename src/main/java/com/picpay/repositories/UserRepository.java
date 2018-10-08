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
    String BASE_QUERY = "FROM tb_user u " +
            " LEFT OUTER JOIN (VALUES :rel1) as r1 ON u.id = r1.C1 " +
            //" LEFT OUTER JOIN (VALUES :rel2) as r2(id, ordering) ON u.id = r2.id " +
            " where (u.name like %:name%) or (u.username like %:name%) order by r1.C2 \n-- #pageable\n";
    String query = "SELECT * " + BASE_QUERY;
    String COUNT_QUERY = "SELECT count(*) " + BASE_QUERY;

    /*
    @Query(value = "Select u from User u " +
            " left outer join VALUES (1232, 1), (43321, 1) as r1(id, ordering) ON u.id = r1.id" +
            " where (u.name like %:nome%) or (u.username like %:nome%)")
    @RestResource(path = "searchNome", rel = "searchNome")
    Page<User> findByNome(@Param("nome") String nome, Pageable p);
*/
    @Query(value = query,
            countQuery = COUNT_QUERY,
            nativeQuery = true
    )
    //@RestResource(path = "searchName", rel = "searchName")
    Page<User> findByName(@Param("name") String name, @Param("rel1") String rel1,/* @Param("rel2") String rel2, */@Param("pageable") Pageable pageable);


}