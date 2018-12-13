package br.com.picpay.buscausuario.dominio;

import lombok.AllArgsConstructor;

@AllArgsConstructor
public class PalavraChave {
	
	private final String palavra;

	public boolean paraBuscarPorUsername() {
		return !palavra.contains(" ");
	}
	
	@Override
	public String toString() {
		return palavra;
	}
}
