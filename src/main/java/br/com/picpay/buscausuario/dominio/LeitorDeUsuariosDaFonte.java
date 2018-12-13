package br.com.picpay.buscausuario.dominio;

public interface LeitorDeUsuariosDaFonte {
	
	Usuario lerUsuario();
	
	boolean encontrouMaisUsuarios();
}
