package br.com.picpay.buscausuario.dominio;

import static java.util.stream.Collectors.toSet;

import java.util.Iterator;
import java.util.LinkedHashSet;
import java.util.List;
import java.util.Set;
import java.util.UUID;

public class Usuarios implements Iterable<Usuario> {

	private final Set<Usuario> usuarios;
	
	public Usuarios(List<Usuario> lista) {
		this.usuarios = new LinkedHashSet<>(lista);
	}

	public void priorizar(Set<UUID> uuidsPrioritarios) {
		Set<Usuario> copia = new LinkedHashSet<>(usuarios);
		Set<Usuario> usuariosPrioritarios = usuarios
				.stream()
				.filter(usuario -> usuario.possuiUmDessesIds(uuidsPrioritarios))
				.collect(toSet());
		usuarios.retainAll(usuariosPrioritarios);
		usuarios.addAll(copia);
	}

	@Override
	public Iterator<Usuario> iterator() {
		return usuarios.iterator();
	}
}
