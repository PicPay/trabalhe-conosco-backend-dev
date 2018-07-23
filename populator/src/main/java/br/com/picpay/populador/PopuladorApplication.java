package br.com.picpay.populador;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.ComponentScan;

@SpringBootApplication
@ComponentScan(basePackages = { "br.com.picpay" })
public class PopuladorApplication {

	public static void main(String[] args) {
		SpringApplication.run(PopuladorApplication.class, args).close();
		//System.exit(0);
	}
}
