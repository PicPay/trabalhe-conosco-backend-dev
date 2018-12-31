package com.picpay.controller;

import java.util.Collections;

import javax.servlet.http.HttpServletRequest;

import org.springframework.data.domain.PageImpl;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import com.picpay.model.User;
import com.picpay.repository.PageWrapper;
import com.picpay.repository.UserFilter;

@Controller
@RequestMapping("/home")
public class HomeController {

	@GetMapping
	public ModelAndView home(HttpServletRequest httpServletRequest) {
		ModelAndView mv = new ModelAndView("home");
		mv.addObject(new UserFilter());
		PageWrapper<User> pageWrapper = new PageWrapper<>(new PageImpl<>(Collections.emptyList()), httpServletRequest);
		mv.addObject("page",pageWrapper);
		return mv;
	}
}