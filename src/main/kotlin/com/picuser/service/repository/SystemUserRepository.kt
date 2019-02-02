package com.picuser.service.repository

import com.picuser.service.entities.SystemUser
import com.picuser.service.entities.User
import org.springframework.data.domain.Page
import org.springframework.data.domain.Pageable
import org.springframework.data.elasticsearch.annotations.Query
import org.springframework.data.elasticsearch.repository.ElasticsearchRepository

interface SystemUserRepository : ElasticsearchRepository<SystemUser, String> {

    @Query("{\"bool\":{\"must\":[{\"match\":{\"email\":\"?0\"}}]}}")
    fun findSystemUser(email: String, pageable: Pageable): Page<SystemUser>
}