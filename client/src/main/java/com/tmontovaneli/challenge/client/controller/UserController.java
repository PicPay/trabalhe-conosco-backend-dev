package com.tmontovaneli.challenge.client.controller;

import java.io.IOException;
import java.util.List;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;

import com.tmontovaneli.challenge.client.model.User;
import com.tmontovaneli.challenge.client.retrofit.RetrofitConfigurator;
import com.tmontovaneli.challenge.client.service.UserService;

import retrofit2.Call;
import retrofit2.Response;

@Controller
public class UserController {

	@RequestMapping(value = "/users/{page}/{total}", method = RequestMethod.GET)
	public String buscar(@PathVariable("page") int page, @PathVariable("total") int totalPage,
			@ModelAttribute("query") String query, Model model) {

		UserService service = RetrofitConfigurator.createService(UserService.class);
		Call<List<User>> list = service.list(page, query);
		try {
			Response<List<User>> response = list.execute();
			List<User> users = response.body();

			if (page == 1 || page % 10 == 0) {

				Call<Long> callTotal = service.count(page, query);
				Response<Long> respTotal = callTotal.execute();
				Long total = respTotal.body();

				total = ((long) total / 15);

				if (page % 10 == 0)
					total += page;

				model.addAttribute("total", total);

			} else {
				model.addAttribute("total", totalPage);
			}

			model.addAttribute("users", users);
			model.addAttribute("query", query);
			model.addAttribute("page", page);

		} catch (IOException e) {
			e.printStackTrace();
		}

		return "list";

	}

	@RequestMapping("/users/list")
	public String list(Model model) {
		return "list";
	}

}
