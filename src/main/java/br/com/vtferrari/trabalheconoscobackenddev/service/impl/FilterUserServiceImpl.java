package br.com.vtferrari.trabalheconoscobackenddev.service.impl;

import br.com.vtferrari.trabalheconoscobackenddev.repository.UserRepository;
import br.com.vtferrari.trabalheconoscobackenddev.repository.converter.UserConverter;
import br.com.vtferrari.trabalheconoscobackenddev.service.FilterUserService;
import br.com.vtferrari.trabalheconoscobackenddev.service.domain.User;
import lombok.AllArgsConstructor;
import org.springframework.data.domain.Page;
import org.springframework.stereotype.Service;

@Service
@AllArgsConstructor
public class FilterUserServiceImpl implements FilterUserService {

    private final UserRepository userRepository;
    private final UserConverter userConverter;

    @Override
    public Page<User> findUserByKeyword(String keyword, Integer page, Integer size) {

        return userRepository.findDistinctByKeyword(keyword, page, size)
                .map(userConverter::convert);
    }
}
