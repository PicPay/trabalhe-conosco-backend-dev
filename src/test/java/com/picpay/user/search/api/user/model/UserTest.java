package com.picpay.user.search.api.user.model;

import org.junit.Assert;

public class UserTest {

	public static void assertEquals(User expected, User actual) {
		if (expected == null) {
			Assert.assertNull(actual);
			return;
		}
		Assert.assertEquals(expected.getId(), actual.getId());
		Assert.assertEquals(expected.getName(), actual.getName());
		Assert.assertEquals(expected.getUsername(), actual.getUsername());
	}
}