package com.picuser.service.repository

import com.picuser.service.entities.User
import org.springframework.data.domain.Page
import org.springframework.data.domain.Pageable
import org.springframework.data.elasticsearch.annotations.Query
import org.springframework.data.elasticsearch.repository.ElasticsearchRepository

interface UserRepository : ElasticsearchRepository<User, String> {

    @Query("{\"bool\":{\"must\":[{\"multi_match\":{\"query\":\"?0\", \"fields\": [\"name\",\"userName\"]}}]}}")
    fun findUser(text: String, pageable: Pageable): Page<User>
}