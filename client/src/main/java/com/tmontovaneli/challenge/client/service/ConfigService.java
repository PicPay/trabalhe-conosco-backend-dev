package com.tmontovaneli.challenge.client.service;

import retrofit2.Call;
import retrofit2.http.GET;

public interface ConfigService {

	@GET("/init")
	Call<String> init();

}
