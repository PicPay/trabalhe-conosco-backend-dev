package picpay.controller.rest;

import java.util.List;
import java.util.UUID;
import java.util.concurrent.Callable;
import java.util.concurrent.ExecutionException;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;
import java.util.concurrent.Future;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import picpay.model.User;
import picpay.service.UserService;


@RestController
public class UserRestController {
	
	@Autowired
	private UserService userService;
	
	@GetMapping("/users")
    public List<User> users(
    		@RequestParam(value="name", required=false, defaultValue="") String name, 
    		 @RequestParam(value="username", required=false, defaultValue="") String username,
    		 @RequestParam(value="paging", required=false, defaultValue="15") int paging,
    		 @RequestParam(value="startUUID", required=false, defaultValue="") String startUUID) {
    	
    	
    	System.out.printf("Recebeu requisicao name=%s, username=%s, paging=%d, startUUID=%s\n", name, username, paging, startUUID);
    	long startTime = System.nanoTime();   
    	
    	final UUID startUserUUID = convertToUUID(startUUID);
    	    	
    	Callable<List<User>> findUsersParallel = () -> {
    		List<User> users;
        	if (!name.isEmpty())
        		users = userService.findAllByName(name, startUserUUID, paging, true);
        	else if (!username.isEmpty())
        		users = userService.findAllByUsername(username, startUserUUID, paging, true);
        	else
        		users = userService.findAll(startUserUUID, paging);
        	
        	return users;
    	};
    	
    	Callable<List<User>> findUsers = () -> {
    		List<User> users;
        	if (!name.isEmpty())
        		users = userService.findAllByName(name, startUserUUID, paging, false);
        	else if (!username.isEmpty())
        		users = userService.findAllByUsername(username, startUserUUID, paging, false);
        	else
        		users = userService.findAll(startUserUUID, paging);
        	
        	return users;
    	};
    	
    	//estou fazendo a busca na memoria, em casos onde a busca percorre a lista toda a busca paralela tende a ser mais rapida
    	//porém no caso em que as informacoes estao no inicio, a busca sequencial tende a ser mais rápida
    	ExecutorService executor = Executors.newFixedThreadPool(2);
    	Future<List<User>> usersParallelFuture =  executor.submit(findUsersParallel);
    	Future<List<User>> usersFuture = executor.submit(findUsers);
    	
    	List<User> users = null;
    	
    	//obter de quem retornar primeiro
    	try {
    	while (true)
    	{
    		if (usersFuture.isDone())
    		{
    			users = usersFuture.get();
    			break;
    		}
    		
    		if (usersParallelFuture.isDone())
    		{
    			users = usersParallelFuture.get();
    			break;
    		}
    		
    		//dormir 50 ms para nao usar muito a cpu
    		Thread.sleep(50);
    		
    	}
		} catch (InterruptedException | ExecutionException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
    	
    	//terminar quem continuou executando
    	executor.shutdownNow();
   	
    	
		 long estimatedTime = System.nanoTime() - startTime;
		 System.out.printf("Requisição processada em %f s\n", (double)estimatedTime / 1e+9);
    	
		 if (users != null && !users.isEmpty())
		 {
			 System.out.println("" + users.get(0));
		 }
		 
    	return users;
    }

	private UUID convertToUUID(String startUUID) {
		UUID startUserUUID_ = null;
    	
    	try {
    		startUserUUID_ = UUID.fromString(startUUID);
    	} catch (IllegalArgumentException e)
    	{
    	}
		return startUserUUID_;
	}

}
