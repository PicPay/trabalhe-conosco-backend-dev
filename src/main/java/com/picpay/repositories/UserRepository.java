package com.picpay.repositories;

import com.picpay.model.User;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.PagingAndSortingRepository;
import org.springframework.data.repository.query.Param;
import org.springframework.data.rest.core.annotation.RestResource;

import javax.transaction.Transactional;
import java.util.List;

/**
 * @author Bruno Carreira
 */

@Transactional
public interface UserRepository extends PagingAndSortingRepository<User, String> {
    @RestResource(path = "usersbyname", rel = "usersbyname")
    Page<User> findByNameContainingOrUsernameContainingOrderByPriority(@Param("name") String nameText, @Param("username") String usernameText, Pageable pageable);

    @Modifying
    @Query(value = "update User u set u.priority=:priority where u.id in (:ids)")
    int updatePriorityByIds(@Param("ids") List<String> id, @Param("priority") int priority);
}