package br.com.vtferrari.trabalheconoscobackenddev.repository.converter;

import br.com.vtferrari.trabalheconoscobackenddev.repository.model.UserElasticsearch;
import br.com.vtferrari.trabalheconoscobackenddev.service.domain.User;
import org.springframework.stereotype.Component;

@Component
public class UserConverter {

    public User convert(UserElasticsearch userElasticsearch) {

        return User
                .builder()
                .id(userElasticsearch.getId())
                .name(userElasticsearch.getName())
                .username(userElasticsearch.getUsername())
                .build();
    }
}
