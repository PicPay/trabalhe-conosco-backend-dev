package com.picuser.configuration

import com.picuser.entities.SystemUser
import com.picuser.repository.SystemUserRepository
import org.slf4j.LoggerFactory
import org.springframework.beans.factory.annotation.Autowired
import org.springframework.stereotype.Component
import org.springframework.transaction.annotation.Transactional

import javax.annotation.PostConstruct

@Component
class Loader(@Autowired val sysUserRepository: SystemUserRepository? = null) {

    private val logger = LoggerFactory.getLogger(Loader::class.java)!!

    @PostConstruct
    @Transactional
    fun loadAll() {
        logger.info("Setting up system users...")

        val admin1 = SystemUser("1", "johnguerson@gmailcom", "John Guerson")

        if(!sysUserRepository!!.existsById(admin1.id)) {
            sysUserRepository!!.saveAll(listOf(admin1))
        }

        logger.info("Setup complete!")
    }
}