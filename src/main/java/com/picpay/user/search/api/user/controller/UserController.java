package com.picpay.user.search.api.user.controller;

import java.util.List;
import java.util.stream.Collectors;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.web.PagedResourcesAssembler;
import org.springframework.hateoas.PagedResources;
import org.springframework.hateoas.Resource;
import org.springframework.http.HttpHeaders;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.picpay.user.search.api.user.model.User;
import com.picpay.user.search.api.user.service.UserService;

@RestController
@RequestMapping("/v1/api/users")
public class UserController {

	private static final String X_TOTAL_COUNT_HEADER = "X-Total-Count";

	@Autowired
	private PagedResourcesAssembler<User> assembler;

	@Autowired
	private UserService userService;

	@GetMapping("{keyword}")
	public ResponseEntity<List<User>> retrieve(@PathVariable String keyword, Pageable pageable) {
		Page<User> page = userService.findByKeyword(keyword, pageable);

		if (page == null || page.isEmpty() || page.getContent() == null || page.getContent().isEmpty()) {
			return ResponseEntity.noContent().build();
		}

		HttpHeaders headers = addPaginationHeaders(assembler.toResource(page));

		return ResponseEntity.ok().headers(headers).body(page.getContent());
	}

	private HttpHeaders addPaginationHeaders(PagedResources<Resource<User>> pr) {
		HttpHeaders headers = new HttpHeaders();
		headers.add(HttpHeaders.LINK, pr.getLinks().stream().map(Object::toString).collect(Collectors.joining(", ")));
		headers.add(X_TOTAL_COUNT_HEADER, String.valueOf(pr.getMetadata().getTotalElements()));
		return headers;
	}
}