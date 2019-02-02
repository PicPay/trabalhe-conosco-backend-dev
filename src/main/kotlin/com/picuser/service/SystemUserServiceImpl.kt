package com.picuser.service

import com.picuser.entities.SystemUser
import com.picuser.repository.SystemUserRepository
import org.springframework.beans.factory.annotation.Autowired
import org.springframework.data.domain.Page
import org.springframework.data.domain.PageRequest
import org.springframework.stereotype.Service

@Service
class SystemUserServiceImpl(@Autowired val sysUserRepository: SystemUserRepository): SystemUserService {

    override fun saveAll(users: List<SystemUser>): List<SystemUser> {
        sysUserRepository.saveAll(users)
        return users
    }

    override fun findAll(pageRequest: PageRequest): Page<SystemUser> {
        return sysUserRepository.findAll(pageRequest)
    }

    override fun findSystemUser(email: String, pageRequest: PageRequest): Page<SystemUser> {
        return sysUserRepository.findSystemUser(email, pageRequest)
    }
}
