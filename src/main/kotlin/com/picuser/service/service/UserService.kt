package com.picuser.service.service

import com.picuser.service.entities.User
import org.springframework.data.domain.Page
import org.springframework.data.domain.PageRequest

interface UserService {

    fun save(user: User): User
    fun saveAll(users: List<User>): Iterable<User>
    fun findOne(id: String): User

    fun findAll(pageRequest: PageRequest): Page<User>
    fun findUser(text: String, pageRequest: PageRequest): Page<User>
}