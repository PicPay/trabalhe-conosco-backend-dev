package com.picpay;

import java.time.Duration;
import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;

import javax.servlet.ServletContext;
import javax.servlet.ServletContextEvent;
import javax.servlet.ServletContextListener;
import javax.servlet.annotation.WebListener;

@WebListener
public class ApplicationStart implements ServletContextListener{

	public void contextInitialized(ServletContextEvent event) {
		
		System.out.println("---- Initialize servlet context -----");	
		
		ServletContext context = event.getServletContext();	
		String usersList = context.getInitParameter("users-list");
		String relevanceList1 = context.getInitParameter("relevance-list-1");
		String relevanceList2 = context.getInitParameter("relevance-list-2");

		UserUtil util = new UserUtil();
		
		System.out.println("---- Loading users in memory -----");	
		LocalDateTime ini = LocalDateTime.now();		
		List<User> listUser = util.loadUserFromCsv(usersList);
		
		LocalDateTime end = LocalDateTime.now();
		Duration dur = Duration.between(ini, end);
		System.out.println("---- Finished user load. Elapsed time " + dur.toMillis() / 1000 + " seconds -----");
		
		System.out.println("---- Loading and applying users's relevance list -----");	
		ini = LocalDateTime.now();
		ArrayList<String> list1 = util.loadRelevantUsers(relevanceList1);
		ArrayList<String> list2 = util.loadRelevantUsers(relevanceList2);
		
		listUser.stream().filter(s -> list2.contains(s.getId())).forEach(f -> f.setOrdem(2));
		listUser.stream().filter(s -> list1.contains(s.getId())).forEach(f -> f.setOrdem(1));
		end = LocalDateTime.now();
		dur = Duration.between(ini, end);
		System.out.println("---- Finished relevance list load. Elapsed time " + dur.toMillis() / 1000 + " seconds -----");
		
		context.setAttribute("users", listUser);
		
	}

	@Override
	public void contextDestroyed(ServletContextEvent sce) {
		System.out.println("---- Destroying servlet context -----");
	}

	
}
