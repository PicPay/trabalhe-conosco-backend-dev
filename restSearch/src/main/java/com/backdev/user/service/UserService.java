package com.backdev.user.service;

import com.backdev.user.entity.User;
import com.backdev.user.exception.UserNotFoundException;
import org.springframework.data.domain.Page;

public interface UserService {
    User getUserByUserName(String username) throws UserNotFoundException;

    User getUserByUuid(String uuid) throws UserNotFoundException;

    Page<User> getAllUsers(Integer page) throws UserNotFoundException;
}
