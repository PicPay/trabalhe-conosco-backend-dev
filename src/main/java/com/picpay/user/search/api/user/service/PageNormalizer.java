package com.picpay.user.search.api.user.service;

import org.springframework.data.domain.Pageable;

public class PageNormalizer {

	private int maxPageSize;

	public PageNormalizer(int maxPageSize) {
		this.maxPageSize = maxPageSize;
	}

	int normalizePageNumber(Pageable pageable) {
		if (pageable.getPageNumber() < 0) {
			return 0;
		}
		return pageable.getPageNumber();
	}

	int normalizePageSize(Pageable pageable) {
		if (pageable.getPageSize() < 1) {
			return 1;
		}
		if (pageable.getPageSize() > maxPageSize) {
			return maxPageSize;
		}
		return pageable.getPageSize();
	}
}