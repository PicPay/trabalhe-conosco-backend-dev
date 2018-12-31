package com.picpay.controller;

import javax.servlet.http.HttpServletRequest;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Pageable;
import org.springframework.data.web.PageableDefault;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import com.picpay.model.User;
import com.picpay.repository.PageWrapper;
import com.picpay.repository.UserFilter;
import com.picpay.service.UserMongoService;

@Controller
@RequestMapping("/users")
public class UserController {

	private UserMongoService serviceMongo;

	@Autowired
	public UserController(UserMongoService serviceMongo) {
		super();
		this.serviceMongo = serviceMongo;
	}
	
	@GetMapping
	public ModelAndView users( UserFilter filter ,@PageableDefault(size = 15) Pageable page,HttpServletRequest httpServletRequest) {
		ModelAndView modelAndView = new ModelAndView("home");
		PageWrapper<User> pageWrapper = new PageWrapper<>(serviceMongo.findUsers(filter,page), httpServletRequest);
		modelAndView.addObject("page",pageWrapper);
		return modelAndView;
	}
}