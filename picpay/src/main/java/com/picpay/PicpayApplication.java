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

import com.picpay.repository.UsuarioArquivoRepository;

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
	public UsuarioArquivoRepository getUsuarioArquivoRepositorioProd() {
		List<String> arquivosRelevancia = Arrays.asList("lista_relevancia_2.txt","lista_relevancia_1.txt");
		return new UsuarioArquivoRepository("users.csv",",",arquivosRelevancia,15);
	}
	
	@Bean(name="import")
	public UsuarioArquivoRepository getUsuarioArquivoRepositorioImport() {
		List<String> arquivosRelevancia = Arrays.asList("lista_relevancia_2.txt","lista_relevancia_1.txt");
		return new UsuarioArquivoRepository("users.csv",",",arquivosRelevancia,200);
	}
	
	
	@Bean(name="test")
	public UsuarioArquivoRepository getUsuarioArquivoRepositorioTest() {
		List<String> arquivosRelevancia  =  Arrays.asList("lista_relevancia_2_teste.txt","lista_relevancia_1_teste.txt");
		return new UsuarioArquivoRepository("users_test.csv",",",arquivosRelevancia,10);
	}
}
