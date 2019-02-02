package com.picuser.service.configuration

import com.picuser.service.entities.SystemUser
import com.picuser.service.repository.SystemUserRepository
import org.slf4j.LoggerFactory
import org.springframework.beans.factory.annotation.Autowired
import org.springframework.data.domain.PageRequest
import org.springframework.stereotype.Component
import org.springframework.transaction.annotation.Transactional

import javax.annotation.PostConstruct

@Component
class Loader(@Autowired val esConfig: ElasticSearchConfiguration, @Autowired val sysUserRepository: SystemUserRepository? = null) {

    private val logger = LoggerFactory.getLogger(Loader::class.java)!!

    @PostConstruct
    @Transactional
    fun loadAll() {
        logger.info("Setting up system users...")

        val admins = esConfig.getAdmins().mapIndexedNotNull {index, it ->
            if(sysUserRepository!!.findSystemUser(it, PageRequest.of(0, 1)).isEmpty) {
                println(index)
                println(it)
                SystemUser((index + 1).toString(), it, "")
            } else null
        }

        if(admins.isNotEmpty()) {
            sysUserRepository!!.saveAll(admins)
        }

        logger.info("Setup complete!")
    }
}