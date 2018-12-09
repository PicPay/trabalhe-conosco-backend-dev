package br.com.picpay.buscausuario.infra;

import static java.util.UUID.fromString;

import java.io.File;
import java.io.FileNotFoundException;
import java.util.LinkedHashSet;
import java.util.Scanner;
import java.util.Set;
import java.util.UUID;

import br.com.picpay.buscausuario.dominio.IdentificadoresUsuariosPrioritarios;

public class IdentificadoresUsuariosPrioritariosTxt implements IdentificadoresUsuariosPrioritarios {

	private final Set<UUID> identificadores;
	
	private IdentificadoresUsuariosPrioritariosTxt() {
		this.identificadores = new LinkedHashSet<>();
	}
	
	public IdentificadoresUsuariosPrioritariosTxt(File arquivoUsuariosRelevantes) throws FileNotFoundException {
		this();
		try(Scanner scanner = new Scanner(arquivoUsuariosRelevantes)){
			while(scanner.hasNextLine()) identificadores.add(fromString(scanner.nextLine().trim()));
		}
	}

	@Override
	public Set<UUID> lerTodos() {
		return identificadores;
	}
}
