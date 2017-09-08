package com.tmontovaneli.challenge.client.service;

import java.util.List;

import com.tmontovaneli.challenge.client.model.User;

import retrofit2.Call;
import retrofit2.http.GET;
import retrofit2.http.Path;
import retrofit2.http.Query;

public interface UserService {

	@GET("/users/{page}")
	Call<List<User>> list(@Path("page") Integer page, @Query("query") String query);

	@GET("/users/count/{page}")
	Call<Long> count(@Path("page") Integer page, @Query("query") String query);

}
