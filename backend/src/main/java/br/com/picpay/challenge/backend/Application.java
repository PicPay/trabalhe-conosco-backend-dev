package br.com.picpay.challenge.backend;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.boot.autoconfigure.data.elasticsearch.ElasticsearchAutoConfiguration;

/**
 * Launcher da aplicação
 * 
 * @author francofabio
 *
 */
@SpringBootApplication(exclude = ElasticsearchAutoConfiguration.class)
public class Application {
    
	public static void main(String...args) {
        SpringApplication.run(Application.class, args);
    }
	
}
