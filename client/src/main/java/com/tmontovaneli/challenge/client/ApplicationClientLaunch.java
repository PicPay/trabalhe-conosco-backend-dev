package com.tmontovaneli.challenge.client;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.stereotype.Controller;

@Controller
@SpringBootApplication
public class ApplicationClientLaunch {

	public static void main(String[] args) throws Exception {
		SpringApplication.run(ApplicationClientLaunch.class, args);
	}

}
