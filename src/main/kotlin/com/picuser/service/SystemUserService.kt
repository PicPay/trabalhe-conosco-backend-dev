package com.picuser.service

import com.picuser.entities.SystemUser
import org.springframework.data.domain.Page
import org.springframework.data.domain.PageRequest

interface SystemUserService {

    fun saveAll(users: List<SystemUser>): Iterable<SystemUser>

    fun findAll(pageRequest: PageRequest): Page<SystemUser>
    fun findSystemUser(email: String, pageRequest: PageRequest): Page<SystemUser>
}