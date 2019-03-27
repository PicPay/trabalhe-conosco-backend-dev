package com.backdev.user.service;

import com.backdev.file.resources.UuidRepository;
import com.backdev.user.entity.User;
import com.backdev.user.exception.UserNotFoundException;
import com.backdev.user.repository.UserRepository;
import com.google.common.base.Splitter;
import org.elasticsearch.action.search.SearchResponse;
import org.elasticsearch.action.search.SearchType;
import org.elasticsearch.index.query.QueryBuilder;

import static org.elasticsearch.index.query.QueryBuilders.matchAllQuery;

import org.elasticsearch.search.SearchHits;
import org.elasticsearch.search.sort.SortBuilders;
import org.elasticsearch.search.sort.SortOrder;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.elasticsearch.core.ElasticsearchTemplate;
import org.springframework.stereotype.Service;

import java.util.LinkedHashMap;
import java.util.LinkedList;
import java.util.List;
import java.util.Map;

@Service
public class UserServiceImpl implements UserService {

    @Autowired
    private UserRepository userRepository;
    @Autowired
    private ElasticsearchTemplate elasticsearchTemplate;

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
        Page<User> users = userRepository.findAll(PageRequest.of(page, 20));
        if (users.isEmpty()) {
            throw new UserNotFoundException();
        }
        return users;
    }

    @Autowired
    private UuidRepository uuidRepository;

    public void getFilteredUsers() {
        Map<String, String> uuids = new LinkedHashMap<String, String>();

        uuidRepository.findAll().forEach(uuid -> {
            uuids.put(uuid.getUuid(),uuid.getUuid());
        });
//k        List<SortBuilder> sortBuilders = new ArrayList<>();
//        uuids.forEach(( k,  v) -> sortBuilders.add(SortBuilders.fieldSort(k).order(org.elasticsearch.search.sort.SortOrder.valueOf(v.toUpperCase()))));
//
//        SearchResponse response = elasticsearchTemplate
//                .getClient()
//                .prepareSearch("pp_user")
//                .setTypes("user")
//                .setSearchType(SearchType.DFS_QUERY_THEN_FETCH)
////                .setQuery(QueryBuilders.termQuery("skill_1", "Java"));
//                .setQuery(matchAllQuery())
//                .addSort(SortBuilders.fieldSort("uuid").order(SortOrder.ASC))
//                .setExplain(true).execute().actionGet();
//
//        SearchHits hits = response.getHits();
//        hits.forEach(s -> System.out.println(s.getSourceAsString()));
    }


}

