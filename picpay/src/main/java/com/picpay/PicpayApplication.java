package com.picpay;

import java.util.Arrays;
import java.util.List;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.Bean;
import org.springframework.data.mongodb.repository.config.EnableMongoRepositories;
import org.springframework.data.web.config.EnableSpringDataWebSupport;
import org.springframework.scheduling.annotation.EnableAsync;
import org.springframework.security.config.annotation.web.configuration.EnableWebSecurity;

import com.picpay.repository.UserFileRepository;

@SpringBootApplication
@EnableAsync
@EnableSpringDataWebSupport
@EnableMongoRepositories(basePackages = "com.picpay.repository")
@EnableWebSecurity
public class PicpayApplication {

	public static void main(String[] args) {
		SpringApplication.run(PicpayApplication.class, args);
	}
	
	@Bean(name="prod")
	public UserFileRepository getUserFileRepositoryProd() {
		List<String> filesRelevance = Arrays.asList("lista_relevancia_2.txt","lista_relevancia_1.txt");
		return new UserFileRepository("users.csv",",",filesRelevance,15);
	}
	
	@Bean(name="import")
	public UserFileRepository getUserFileRepositoryImport() {
		List<String> filesRelevance = Arrays.asList("lista_relevancia_2.txt","lista_relevancia_1.txt");
		return new UserFileRepository("users.csv",",",filesRelevance,200);
	}
	
	
	@Bean(name="test")
	public UserFileRepository getUserFileRepositoryTest() {
		List<String> filesRelevance  =  Arrays.asList("lista_relevancia_2_teste.txt","lista_relevancia_1_teste.txt");
		return new UserFileRepository("users_test.csv",",",filesRelevance,10);
	}
}