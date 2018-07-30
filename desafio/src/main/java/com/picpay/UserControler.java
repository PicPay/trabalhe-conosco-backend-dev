package com.picpay;

import java.lang.reflect.Type;
import java.util.Comparator;
import java.util.List;
import java.util.stream.Collectors;

import javax.servlet.ServletContext;
import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;

@Path("/user")
public class UserControler {

	@Context
	private ServletContext servletContext;
	
	@SuppressWarnings("unchecked")
	@GET
	@Path("{key}{page:(/page/[^/]+?)?}")
	@Produces({ MediaType.APPLICATION_JSON })
	public Response getUser(@PathParam("key") String key, @PathParam("page") String page) {
		
		if(key.trim().equals("") || key==null)
			return Response.status(200).entity("[]").build();
		
		try {
			
			int skip =0;
			
			page = page.replace("/page/", "");
			if(!page.trim().equals("") && page != null) {
				
				skip = Integer.parseInt(page)*15;
			}
			
			Object obj = servletContext.getAttribute("users");
			if(obj == null)
				throw new InternalError("Erro ao carregar os usuários");
			
			List<User> listUser = (List<User>)obj;
			
			List<User> result = listUser.stream() 
								.filter(s -> s.getNome().contains(key) || s.getLogin().contains(key))
								.sorted(Comparator.comparing(User::getOrdem))
								.skip(skip)
								.limit(15)
								.collect(Collectors.toList());
		          
			Gson gson = new Gson();
			Type listType = new TypeToken<List<User>>() {}.getType();
			String json = gson.toJson(result, listType);
			return Response.status(200).entity(json).build();
			
		}catch (Exception e) {
			return Response.status(200).entity(e.getMessage()).build();
		}
	}
}
