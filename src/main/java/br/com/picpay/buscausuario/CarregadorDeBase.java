package br.com.picpay.buscausuario;

import java.io.File;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.List;

import org.springframework.boot.SpringApplication;
import org.springframework.context.ApplicationContext;

import br.com.picpay.buscausuario.dominio.LeitorDeUsuariosDaFonte;
import br.com.picpay.buscausuario.dominio.TodosUsuarios;
import br.com.picpay.buscausuario.dominio.Usuario;
import br.com.picpay.buscausuario.infra.initbase.LeitorDeUsuariosDaFonteCSV;

public class CarregadorDeBase {

	private final LeitorDeUsuariosDaFonte leitor;
	private final TodosUsuarios todosUsuarios;
	private final int batchSize;
	
	public CarregadorDeBase(LeitorDeUsuariosDaFonte leitor, TodosUsuarios todosUsuarios, int batchSize) {
		this.leitor = leitor;
		this.todosUsuarios = todosUsuarios;
		this.batchSize = batchSize;
	}

	public void carregarUsuarios() {
		List<Usuario> usuariosEncontrados = new ArrayList<>();
		while(leitor.encontrouMaisUsuarios()) {
			Usuario novoUsuario = leitor.lerUsuario();
			usuariosEncontrados.add(novoUsuario);
			if(usuariosEncontrados.size() == batchSize) {
				todosUsuarios.saveAll(usuariosEncontrados);
				usuariosEncontrados.clear();
			}
			
		}
	}
	
	// TODO: o arquivo está hardcoded. Deixar como argumento do método main
	public static void main(String[] args) throws FileNotFoundException {
		ApplicationContext appContext = SpringApplication.run(BuscausuarioApplication.class, args);
		TodosUsuarios todosUsuarios = appContext.getBean(TodosUsuarios.class);
		LeitorDeUsuariosDaFonte leitor = new LeitorDeUsuariosDaFonteCSV(new File("/Users/rodrigovieirapinto/Downloads/users.csv"));
		
		CarregadorDeBase carregador = new CarregadorDeBase(leitor, todosUsuarios, 200000);
		carregador.carregarUsuarios();
	}
}
