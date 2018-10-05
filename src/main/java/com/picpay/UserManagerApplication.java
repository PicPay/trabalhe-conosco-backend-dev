package com.picpay;

import org.springframework.beans.factory.annotation.Value;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.ConfigurableApplicationContext;
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
	private String relevancia1_txt = null;

	@Value("${com.picpay.relevancia2}")
	private String relevancia2_txt = null;

	public static void main(String[] args){
		SpringApplication.run(UserManagerApplication.class, args);
/*
		List<String> lr1 = Files.lines(Paths.get(relevancia1_txt)).collect(Collectors.toList());
		List<String> lr2 = Files.lines(Paths.get(relevancia2_txt)).collect(Collectors.toList());
		String rel1 = lr1.stream().map(id -> "("+id+",1)").collect(Collectors.joining(","));
		String rel2 = lr2.stream().map(id -> "("+id+",2)").collect(Collectors.joining(","));
		CUSTOM_QUERY = "SELECT * FROM tb_user u " +
					" LEFT OUTER JOIN (VALUES "+rel1+") as r1(id, ordering) ON u.id = r1.id" +
					" LEFT OUTER JOIN (VALUES "+rel2+") as r2(id, ordering) ON u.id = r2.id" +
					" where (u.name like %:name%) or (u.username like %:name%) order by u.id \n-- #pageable\n";
					*/
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