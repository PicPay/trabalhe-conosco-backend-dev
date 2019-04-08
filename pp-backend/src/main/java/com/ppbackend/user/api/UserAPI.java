package com.ppbackend.user.api;

import com.ppbackend.user.model.User;
import com.ppbackend.user.exception.UserNotFoundException;
import com.ppbackend.user.service.UserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.web.bind.annotation.*;

@RequestMapping(path = "api/user")
@RestController
public class UserAPI {

    @Autowired
    private UserService userService;

    @GetMapping(value = "/{username}")
    public User getUser(@PathVariable("username") String username)
            throws UserNotFoundException {
        return userService.getUserByUserName(username);
    }

    @GetMapping(value = "/getAll")
    public Page<User> getAllUsers(@RequestParam(value = "page", required = false) Integer page)
            throws UserNotFoundException {
        return userService.getAllUsers(page);
    }

    @GetMapping(value = "/{uuid}/uuid")
    public User getUserByUuid(@PathVariable("uuid") String uuid) throws UserNotFoundException {
        return userService.getUserByUuid(uuid);
    }

    @GetMapping
    public Page<User> searchByText(@RequestParam("text") String text,@RequestParam("page") Integer page) throws UserNotFoundException {
        return userService.phraseSearch(text,page);
    }

}
