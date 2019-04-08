package com.ppbackend.user.service;

import com.ppbackend.user.model.User;
import com.ppbackend.user.exception.UserNotFoundException;
import org.springframework.data.domain.Page;

public interface UserService {
    User getUserByUserName(String username) throws UserNotFoundException;

    User getUserByUuid(String uuid) throws UserNotFoundException;

    Page<User> getAllUsers(Integer page) throws UserNotFoundException;

    Page<User> phraseSearch(String input, Integer page) throws UserNotFoundException;

}
