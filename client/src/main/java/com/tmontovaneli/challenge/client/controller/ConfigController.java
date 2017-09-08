package com.tmontovaneli.challenge.client.controller;

import java.io.IOException;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;

import com.tmontovaneli.challenge.client.component.ConfigurationComponent;
import com.tmontovaneli.challenge.client.retrofit.RetrofitConfigurator;
import com.tmontovaneli.challenge.client.service.ConfigService;

import retrofit2.Response;

@Controller
public class ConfigController {

	@RequestMapping(value = "/")
	public String init(Model model) {

		System.out.println("iniciando configuracao...");

		ConfigService service = RetrofitConfigurator.createService(ConfigService.class);

		try {
			Response<String> response = service.init().execute();
			String result = response.body();
			ConfigurationComponent.getInstance().setCargaBancoDadosCompleta("Success".equals(result));
		} catch (IOException e) {
			e.printStackTrace();
		}

		System.out.println("iniciando configuracao...OK");

		return "result";
	}

}
