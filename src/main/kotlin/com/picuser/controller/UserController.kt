package com.picuser.controller

import com.picuser.entities.User
import com.picuser.service.UserService
import org.springframework.beans.factory.annotation.Autowired
import org.springframework.data.domain.Page
import org.springframework.data.domain.PageRequest
import org.springframework.data.domain.Sort
import org.springframework.web.bind.annotation.*

data class PayloadGetAll(val page: Int? = 0, val size: Int? = 15)
data class PayloadSearch(val page: Int? = 0, val size: Int? = 15, val text: String? = "")

@RestController
@RequestMapping("/user")
class UserController(@Autowired val userService: UserService) {

    @PostMapping("/all")
    fun _all(@RequestBody payload: PayloadGetAll): Page<User> {
        return userService.findAll(PageRequest.of(payload.page!!, payload.size!!, Sort.Direction.DESC,"priority"))
    }

    @PostMapping("/search")
    fun search(@RequestBody payload: PayloadSearch): Page<User> {
        return userService.findUser(payload.text!!, PageRequest.of(payload.page!!, payload.size!!, Sort.Direction.DESC,"priority"))
    }
}