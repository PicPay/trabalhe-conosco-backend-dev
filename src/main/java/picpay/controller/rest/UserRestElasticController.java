package picpay.controller.rest;

import java.util.UUID;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.ApplicationContext;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Sort;
import org.springframework.data.domain.Sort.Order;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import picpay.model.User;
import picpay.service.UserServiceElastic;

@RestController
public class UserRestElasticController {

	@Autowired
	private UserServiceElastic userService;
	
	@GetMapping("/elastic/users")
    public Page<User> users(
    		@RequestParam(value="name", required=false, defaultValue="") String name, 
    		 @RequestParam(value="username", required=false, defaultValue="") String username,
    		 @RequestParam(value="paging", required=false, defaultValue="15") int usersPerPage,
    		 @RequestParam(value="page", required=false, defaultValue="0") int page) {
    	
    	
    	System.out.printf("Recebeu requisicao name=%s, username=%s, paging=%d, page=%d\n", name, username, usersPerPage, page);
    	long startTime = System.nanoTime();   
    	
    	Page<User> users = null;
    	
    	if (!username.isEmpty())
    	users =  userService.findAllByLogin(username, PageRequest.of(page, usersPerPage));
    	else if (!name.isEmpty())
    		users =  userService.findAllByName(name, PageRequest.of(page, usersPerPage));
    	else
    		users = userService.findAll(PageRequest.of(page, usersPerPage, Sort.by(Order.desc("priority"))));
    	
    	long estimatedTime = System.nanoTime() - startTime;   
    	System.out.printf("Requisição processada em %f s\n", (double)estimatedTime / 1e+9);
    	
    	return users;
    }

}
