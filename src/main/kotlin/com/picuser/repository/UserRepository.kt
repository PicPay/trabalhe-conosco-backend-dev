package com.picuser.repository

import com.picuser.entities.User
import org.springframework.data.domain.Page
import org.springframework.data.domain.Pageable
import org.springframework.data.elasticsearch.annotations.Query
import org.springframework.data.elasticsearch.repository.ElasticsearchRepository

interface UserRepository : ElasticsearchRepository<User, String> {

    @Query("{\"bool\":{\"must\":[{\"match\":{\"name\":\"?0\"}}]}}")
    fun findUser(text: String, pageable: Pageable): Page<User>
}