package br.com.vtferrari.trabalheconoscobackenddev;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.kafka.annotation.EnableKafka;

@EnableKafka
@SpringBootApplication
public class TrabalheConoscoBackendDevApplication {

    public static void main(String[] args) {
        SpringApplication.run(TrabalheConoscoBackendDevApplication.class, args);
    }

}
