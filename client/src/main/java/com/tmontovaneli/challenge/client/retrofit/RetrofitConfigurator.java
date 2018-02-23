package com.tmontovaneli.challenge.client.retrofit;

import java.util.concurrent.TimeUnit;

import com.tmontovaneli.challenge.client.interceptor.AuthenticationInterceptor;

import okhttp3.Credentials;
import okhttp3.OkHttpClient;
import okhttp3.logging.HttpLoggingInterceptor;
import retrofit2.Retrofit;
import retrofit2.Retrofit.Builder;
import retrofit2.converter.jackson.JacksonConverterFactory;

public class RetrofitConfigurator {

	public static final String API_BASE_URL;

	private static OkHttpClient.Builder httpClient;

	static {

		String host = System.getenv("HOST");
		if (host == null)
			host = "localhost";

		String port = System.getenv("PORT");
		if (port == null)
			port = "8080";

		API_BASE_URL = "http://" + host + ":" + port;

		Builder builder = new Retrofit.Builder().baseUrl(API_BASE_URL)
				.addConverterFactory(JacksonConverterFactory.create());

		retrofit = builder.build();
		RetrofitConfigurator.builder = builder;

		HttpLoggingInterceptor interceptor = new HttpLoggingInterceptor();
		interceptor.setLevel(HttpLoggingInterceptor.Level.BODY);

		httpClient = new OkHttpClient.Builder();
		httpClient.addInterceptor(interceptor);
		httpClient.connectTimeout(1, TimeUnit.MINUTES);
		httpClient.readTimeout(1, TimeUnit.MINUTES);
		httpClient.writeTimeout(1, TimeUnit.MINUTES);

	}

	private static Retrofit.Builder builder;

	private static Retrofit retrofit;

	public static <S> S createService(Class<S> serviceClass) {
		String authToken = Credentials.basic("admin", "secret");
		return createService(serviceClass, authToken);
	}

	public static <S> S createService(Class<S> serviceClass, final String authToken) {
		AuthenticationInterceptor interceptor = new AuthenticationInterceptor(authToken);

		if (!httpClient.interceptors().contains(interceptor)) {
			httpClient.addInterceptor(interceptor);

			builder.client(httpClient.build());
			retrofit = builder.build();
		}

		return retrofit.create(serviceClass);
	}

}
