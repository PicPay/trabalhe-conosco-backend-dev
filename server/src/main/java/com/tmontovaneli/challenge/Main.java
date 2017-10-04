package com.tmontovaneli.challenge;

import org.springframework.boot.ApplicationArguments;
import org.springframework.boot.ApplicationRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.EnableAutoConfiguration;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.boot.autoconfigure.mongo.MongoAutoConfiguration;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;

@Controller
@SpringBootApplication
@EnableAutoConfiguration(exclude = { MongoAutoConfiguration.class })
public class Main implements ApplicationRunner {

	@RequestMapping("/init")
	@ResponseBody
	public String init() {

		InitializerDatabase initializerDatabase = new InitializerDatabase();
		try {
			initializerDatabase.init();
		} catch (Exception e) {
			return String.format("Fail: %s", e.getMessage());
		}

		return "Success";
	}

	public static void main(String[] args) throws Exception {
		SpringApplication.run(Main.class, args);
	}

	@Override
	public void run(ApplicationArguments applicationArguments) throws Exception {
		String[] args = applicationArguments.getSourceArgs();

	}

}
