package com.picpay.controller;

import javax.servlet.http.HttpServletRequest;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Pageable;
import org.springframework.data.web.PageableDefault;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import com.picpay.model.Usuario;
import com.picpay.repository.PageWrapper;
import com.picpay.repository.UsuarioFilter;
import com.picpay.service.UsuarioArquivoService;
import com.picpay.service.UsuarioMongoService;

@Controller
@RequestMapping("/usuarios")
public class UsuarioController {

	private UsuarioMongoService serviceMongo;

	@Autowired
	public UsuarioController(UsuarioMongoService serviceMongo, UsuarioArquivoService serviceArquivo) {
		super();
		this.serviceMongo = serviceMongo;
	}
	
	@GetMapping
	public ModelAndView usuarios( UsuarioFilter filter ,@PageableDefault(size = 15) Pageable page,HttpServletRequest httpServletRequest) {
		ModelAndView modelAndView = new ModelAndView("home");
		PageWrapper<Usuario> pageWrapper = new PageWrapper<>(serviceMongo.buscarUsuarios(filter,page), httpServletRequest);
		modelAndView.addObject("pagina",pageWrapper);
		return modelAndView;
	}
}
