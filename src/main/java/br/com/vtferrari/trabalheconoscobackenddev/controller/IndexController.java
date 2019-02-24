package br.com.vtferrari.trabalheconoscobackenddev.controller;

import br.com.vtferrari.trabalheconoscobackenddev.service.FilterUserService;
import br.com.vtferrari.trabalheconoscobackenddev.service.domain.User;
import lombok.AllArgsConstructor;
import org.springframework.data.domain.Page;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;


@RestController
@AllArgsConstructor
@RequestMapping("/v1/users")
public class IndexController {
    private final FilterUserService filterUserService;

    @GetMapping
    public Page<User> index(
            @RequestParam("keyword") String keyword,
            @RequestParam(value = "page", defaultValue = "10") Integer page,
            @RequestParam(value = "size", defaultValue = "10") Integer size) {
        return filterUserService.findUserByKeyword(keyword,page,size);
    }
}