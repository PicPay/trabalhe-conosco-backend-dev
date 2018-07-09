package br.com.picpay.challenge.backend.importacao;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import br.com.picpay.challenge.backend.annotation.Public;
import br.com.picpay.challenge.backend.es.support.SimpleIndexStats;
import br.com.picpay.challenge.backend.user.UserService;

@RestController
@RequestMapping(value = "/importacao", produces = MediaType.APPLICATION_JSON_VALUE)
public class ImportacaoController {

	@Autowired
	private LogImportacaoService logImportacaoService;
	@Autowired
	private UserService userService;
	
	@GetMapping("/status")
	@Public
	public RespostaStatusImportacao currentStatus() {
		LogImportacao logImportacao = logImportacaoService.findCurrentLogImportacao();
		SimpleIndexStats indexStats = userService.getIndexStats();
		return new RespostaStatusImportacao(logImportacao, indexStats);
	}
	
}
