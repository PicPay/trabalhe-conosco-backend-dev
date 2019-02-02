package com.picuser.service.controller

import com.picuser.service.entities.SystemUser
import com.picuser.service.service.SystemUserService
import org.springframework.beans.factory.annotation.Autowired
import org.springframework.data.domain.Page
import org.springframework.data.domain.PageRequest
import org.springframework.web.bind.annotation.*

data class PayloadValidate(val email: String, val name: String?)

@RestController
@RequestMapping("/system/user")
class SystemUserController(@Autowired val sysUserService: SystemUserService) {

    @PostMapping("/validate")
    fun validate(@RequestBody payload: PayloadValidate): Page<SystemUser> {
        return sysUserService.findSystemUser(payload.email, PageRequest.of(0, 15))
    }
}