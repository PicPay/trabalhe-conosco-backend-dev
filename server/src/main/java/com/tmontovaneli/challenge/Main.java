package com.tmontovaneli.challenge;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;

@Controller
@SpringBootApplication
public class Main {

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

}
