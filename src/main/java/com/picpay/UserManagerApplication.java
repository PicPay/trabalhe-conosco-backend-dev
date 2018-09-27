package com.picpay;

import org.springframework.beans.factory.annotation.Value;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.Bean;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.List;
import java.util.stream.Collector;
import java.util.stream.Collectors;
import java.util.stream.Stream;

/**
 * @author Bruno Carreira
 */
// tag::code[]
@SpringBootApplication
public class UserManagerApplication {

	@Value("${com.picpay.relevancia1}")
	private final String relevancia1_txt = null;

	@Value("${com.picpay.relevancia2}")
	private final String relevancia2_txt = null;

	public static void main(String[] args) {
		SpringApplication.run(UserManagerApplication.class, args);
	}

	@Bean
	public List<String> listRelevancia1() throws IOException {
		return Files.lines(Paths.get(relevancia1_txt)).collect(Collectors.toList());
	}

	@Bean
	public List<String> listRelevancia2() throws IOException {
		return Files.lines(Paths.get(relevancia2_txt)).collect(Collectors.toList());
	}

}
// end::code[]