package com.picpay.user.search.api.user.model;

import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;

public final class Constants {

	public static final String X_TOTAL_COUNT_HEADER = "X-Total-Count";

	public static final String ID = "id";

	public static final String NAME = "name";

	public static final String USERNAME = "username";

	public static final String KEYWORD = "keyword";

	public static final String MAX_PAGE_SIZE_FIELD = "maxPageSize";

	public static final Pageable PAGEABLE = PageRequest.of(0, 15);

	public static final String URI = "/v1/api/users";
}