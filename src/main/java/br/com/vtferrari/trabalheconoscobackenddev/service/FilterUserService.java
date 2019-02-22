package br.com.vtferrari.trabalheconoscobackenddev.service;

import br.com.vtferrari.trabalheconoscobackenddev.service.domain.User;
import org.springframework.data.domain.Page;

public interface FilterUserService {
    Page<User> findUserByKeyword(String keyword, Integer page, Integer size);
}
