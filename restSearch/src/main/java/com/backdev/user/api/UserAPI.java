package com.backdev.user.api;

import com.backdev.user.entity.User;
import com.backdev.user.exception.UserNotFoundException;
import com.backdev.user.service.UserService;
import io.swagger.annotations.Api;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.web.bind.annotation.*;

@RequestMapping(path = "user")
@RestController
@Api(value = "user")
public class UserAPI {

    @Autowired
    private UserService userService;

    @GetMapping(value = "/{username}")
    public User getUser(@PathVariable("username") String username)
            throws UserNotFoundException {
        return userService.getUserByUserName(username);
    }

    @GetMapping
    public Page<User> getAllUsers(@RequestParam(value = "page", required = false) Integer page)
            throws UserNotFoundException {
        return userService.getAllUsers(page);
    }

    @GetMapping(value = "/{uuid}/uuid")
    public User getUserByUuid(@PathVariable("uuid") String uuid)   throws UserNotFoundException {
        return userService.getUserByUuid(uuid);
    }

}
