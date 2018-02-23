package com.tmontovaneli.challenge.client;

import org.springframework.boot.ApplicationArguments;
import org.springframework.boot.ApplicationRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.EnableAutoConfiguration;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.boot.autoconfigure.mongo.MongoAutoConfiguration;
import org.springframework.stereotype.Controller;

@Controller
@SpringBootApplication
@EnableAutoConfiguration(exclude = { MongoAutoConfiguration.class })
public class ApplicationClientLaunch implements ApplicationRunner {

	public static void main(String[] args) throws Exception {
		SpringApplication.run(ApplicationClientLaunch.class, args);
	}

	@Override
	public void run(ApplicationArguments applicationArguments) throws Exception {

	}

}
