package com.picpay.config;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.ApplicationArguments;
import org.springframework.boot.ApplicationRunner;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Component;

import com.picpay.service.ImportadorUsuarioService;

@Component
public class DataInitializer implements ApplicationRunner {
	
	@Autowired
	private ImportadorUsuarioService importadorService;
	
	@Async
	@Override
	public void run(ApplicationArguments args) throws Exception {
		importadorService.importar();
	}
}