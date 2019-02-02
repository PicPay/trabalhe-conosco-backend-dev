package com.picuser.service.service

import com.picuser.service.entities.User
import com.picuser.service.repository.UserRepository
import org.springframework.beans.factory.annotation.Autowired
import org.springframework.data.domain.Page
import org.springframework.data.domain.PageRequest
import org.springframework.stereotype.Service

@Service
class UserServiceImpl(@Autowired val userRepository: UserRepository):
    UserService {

    override fun save(user: User): User {
        userRepository.save(user)
        return user
    }

    override fun saveAll(users: List<User>): List<User> {
        userRepository.saveAll(users)
        return users
    }

    override fun findOne(id: String): User {
        return userRepository.findById(id).get()
    }

    override fun findAll(pageRequest: PageRequest): Page<User> {
        return userRepository.findAll(pageRequest)
    }

    override fun findUser(text: String, pageRequest: PageRequest): Page<User> {
        return userRepository.findUser(text, pageRequest)
    }
}
