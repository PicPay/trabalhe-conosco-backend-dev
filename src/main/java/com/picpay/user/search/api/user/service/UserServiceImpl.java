package com.picpay.user.search.api.user.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import com.picpay.user.search.api.user.model.User;
import com.picpay.user.search.api.user.repository.UserRepository;

@Service
public class UserServiceImpl implements UserService {

	@Value("${pagination.max-page-size:15}")
	private int maxPageSize;

	@Autowired
	private UserRepository userRepository;

	@Override
	public Page<User> findByKeyword(String keyword, Pageable pageable) {
		PageNormalizer normalizer = new PageNormalizer(maxPageSize);
		int pageNumber = normalizer.normalizePageNumber(pageable);
		int pageSize = normalizer.normalizePageSize(pageable);

		return userRepository.findByKeyword(keyword, PageRequest.of(pageNumber, pageSize));
	}
}