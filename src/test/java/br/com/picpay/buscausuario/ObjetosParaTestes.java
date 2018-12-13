package br.com.picpay.buscausuario;

import static java.util.UUID.fromString;
import static java.util.UUID.randomUUID;

import java.io.File;
import java.util.ArrayList;
import java.util.List;

import br.com.picpay.buscausuario.dominio.Usuario;

public class ObjetosParaTestes {
	
	public static final Usuario rodrigoVieira = 
			new Usuario(fromString("17b02298-0f31-4027-8a6f-44d47b7f3bf4"), "Rodrigo Vieira", "rodrigo.vieira");
	
	public static final Usuario alanTuring = 
			new Usuario(fromString("4181fa0d-d3d2-4611-9863-9dc2b67c573a"), "Alan Turing", "alan.turing");

	public static List<Usuario> criarUmaQuantidadeDeUsuarios(int quantidade) {
		List<Usuario> ret = new ArrayList<>();
		for(int i = 0; i < quantidade; i++) {
			ret.add(new Usuario(randomUUID(), "usuario"+i, "username"));
		}
		return ret;
	}
	
	public static final File pasta = new File("src/test/resources");
	
	public static final File pastaRelevantes = new File(pasta, "relevantes");
	public static final File usuariosRelevantes = new File(pastaRelevantes, "relevantes.txt");
	public static final File usuariosRelevantes1 = new File(pastaRelevantes, "relevantes1.txt");
	public static final File usuariosRelevantes2 = new File(pastaRelevantes, "relevantes2.txt");
	
	private static final File pastaCsvs = new File(pasta, "csvs");
	public static final File arquivoCsvComUmaLinha = new File(pastaCsvs, "csvComUmaLinha.csv");
	public static final File arquivoCsvComDuasLinhas = new File(pastaCsvs, "csvComDuasLinhas.csv");
}
