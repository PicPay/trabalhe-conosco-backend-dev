package picpay;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.boot.context.event.ApplicationReadyEvent;
import org.springframework.context.event.EventListener;

import picpay.service.UserService;

@SpringBootApplication
public class PicpayUsersApplication {

	public static void main(String[] args) {
		SpringApplication.run(PicpayUsersApplication.class, args);
		
		
	}
}
