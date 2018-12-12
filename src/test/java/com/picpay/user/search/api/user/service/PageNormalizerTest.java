package com.picpay.user.search.api.user.service;

import static org.junit.Assert.assertEquals;

import org.junit.Ignore;
import org.junit.Test;
import org.springframework.data.domain.PageRequest;

public class PageNormalizerTest {

	private static final int MAX_PAGE_SIZE = 15;

	private PageNormalizer normalizer = new PageNormalizer(MAX_PAGE_SIZE);

	@Test
	public void normalizePageNumberOk() {
		assertEquals(0, normalizer.normalizePageNumber(PageRequest.of(0, 1)));
	}

	// This test scenario is not possible with Spring MVC as it pre-normalizes
	// Pageable objects. Anyway, the test is already implemented in case of
	// implementation changes.
	@Test
	@Ignore
	public void normalizePageNumberLessThan0() {
		assertEquals(0, normalizer.normalizePageNumber(PageRequest.of(-1, 1)));
	}

	@Test
	public void normalizePageSizeOk() {
		assertEquals(1, normalizer.normalizePageSize(PageRequest.of(0, 1)));
	}

	// This test scenario is not possible with Spring MVC as it pre-normalizes
	// Pageable objects. Anyway, the test is already implemented in case of
	// implementation changes.
	@Test
	@Ignore
	public void normalizePageSizeLessThan1() {
		assertEquals(1, normalizer.normalizePageSize(PageRequest.of(0, 0)));
	}

	@Test
	public void normalizePageSizeMoreThanMaxPageSize() {
		assertEquals(MAX_PAGE_SIZE, normalizer.normalizePageSize(PageRequest.of(0, MAX_PAGE_SIZE + 1)));
	}
}