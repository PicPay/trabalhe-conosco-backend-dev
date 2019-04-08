package com.ppbackend.user.service;

import com.ppbackend.user.model.User;
import com.ppbackend.user.exception.UserNotFoundException;
import com.ppbackend.user.repository.UserRepository;
import org.elasticsearch.index.query.QueryBuilder;
import org.elasticsearch.search.sort.SortBuilders;
import org.elasticsearch.search.sort.SortOrder;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.elasticsearch.core.query.NativeSearchQueryBuilder;
import org.springframework.stereotype.Service;

import static org.elasticsearch.index.query.QueryBuilders.matchPhraseQuery;

@Service
public class UserServiceImpl implements UserService {

    @Autowired
    private UserRepository userRepository;

    private final Integer PAGES = 10;

    @Override
    public User getUserByUserName(String username) throws UserNotFoundException {
        User user = userRepository.findByUsername(username);
        if (user == null) {
            throw new UserNotFoundException();
        }
        return user;
    }

    @Override
    public User getUserByUuid(String uuid) throws UserNotFoundException {
        User user = userRepository.findByUuid(uuid);
        if (user == null) {
            throw new UserNotFoundException();
        }
        return user;
    }

    @Override
    public Page<User> getAllUsers(Integer page) throws UserNotFoundException {
        Page<User> users = userRepository.findAll(PageRequest.of(page, PAGES));
        if (users.isEmpty()) {
            throw new UserNotFoundException();
        }
        return users;
    }

    @Override
    public Page<User> phraseSearch(String input, Integer page) throws UserNotFoundException {
        QueryBuilder query = new  NativeSearchQueryBuilder()
                .withQuery(matchPhraseQuery("name", input).slop(1))
                .withSort(SortBuilders.fieldSort("score").order(SortOrder.DESC))
                .build().getQuery();
        Page<User> users = userRepository.search(query,PageRequest.of(page, PAGES));

        if (users.isEmpty()) {
            throw new UserNotFoundException();
        }
        return users;
    }


}

