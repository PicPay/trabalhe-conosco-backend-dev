package br.com.picpay.buscausuario.infra.initbase;

import static java.util.UUID.fromString;

import java.io.File;
import java.io.FileNotFoundException;
import java.util.Scanner;
import java.util.UUID;

import br.com.picpay.buscausuario.dominio.LeitorDeUsuariosDaFonte;
import br.com.picpay.buscausuario.dominio.Usuario;
import lombok.extern.slf4j.Slf4j;

@Slf4j
public class LeitorDeUsuariosDaFonteCSV implements LeitorDeUsuariosDaFonte {

	private final Scanner scanner;
	
	public LeitorDeUsuariosDaFonteCSV(File arquivoCsv) throws FileNotFoundException {
		this.scanner = new Scanner(arquivoCsv);
	}

	@Override
	public Usuario lerUsuario() {
		String[] linha = this.scanner.nextLine().split(",");
		UUID id = fromString(linha[0].trim());
		
		Usuario ret = new Usuario(id, linha[1].trim(), linha[2].trim());
		log.info("Lendo o usuário " + ret);
		return ret;
	}

	@Override
	public boolean encontrouMaisUsuarios() {
		boolean ret = scanner.hasNextLine();
		if(!ret) scanner.close();
		return ret;
	}

}
