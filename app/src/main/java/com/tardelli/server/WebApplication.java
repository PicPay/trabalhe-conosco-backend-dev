package com.tardelli.server;

import com.tardelli.server.service.UserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.CommandLineRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.boot.autoconfigure.data.elasticsearch.ElasticsearchAutoConfiguration;
import org.springframework.context.annotation.Bean;
import org.springframework.web.servlet.config.annotation.CorsRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurer;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurerAdapter;

import java.util.logging.Level;
import java.util.logging.Logger;

@SpringBootApplication(exclude = ElasticsearchAutoConfiguration.class)
public class WebApplication implements CommandLineRunner {

    private final Logger logger = Logger.getLogger(this.getClass().getName());

    @Autowired
    private UserService userService;

    public static void main(String[] args) {
        SpringApplication.run(WebApplication.class, args);
    }

    @Override
    public void run(String... args) {
        logger.log(Level.INFO, "Swagger running in: http://localhost/swagger-ui.html");

        //load database in background
        new Thread(() -> userService.loadCsv()).start();
    }
}
