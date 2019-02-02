package com.picuser.service.service

import com.picuser.service.entities.SystemUser
import org.springframework.data.domain.Page
import org.springframework.data.domain.PageRequest

interface SystemUserService {

    fun saveAll(users: List<SystemUser>): Iterable<SystemUser>

    fun findSystemUser(email: String, pageRequest: PageRequest): Page<SystemUser>
}