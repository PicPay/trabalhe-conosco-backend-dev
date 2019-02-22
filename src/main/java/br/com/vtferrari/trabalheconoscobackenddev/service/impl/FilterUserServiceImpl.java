package br.com.vtferrari.trabalheconoscobackenddev.service.impl;

import br.com.vtferrari.trabalheconoscobackenddev.repository.UserRepository;
import br.com.vtferrari.trabalheconoscobackenddev.service.FilterUserService;
import br.com.vtferrari.trabalheconoscobackenddev.service.domain.User;
import lombok.AllArgsConstructor;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.stereotype.Service;

@Service
@AllArgsConstructor
public class FilterUserServiceImpl implements FilterUserService {

    private final UserRepository userRepository;

    @Override
    public Page<User> findUserByKeyword(String keyword, Integer page, Integer size) {

        return userRepository.findDistinctByKeyword(keyword, PageRequest.of(0, 1))

                .map(i->User
                .builder()
                .id(i.getId())
                .name(i.getName())
                .username(i.getUsername())
                .build());
   }
}
