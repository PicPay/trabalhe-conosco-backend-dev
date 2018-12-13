package br.com.picpay.buscausuario.service;

import org.springframework.data.domain.Pageable;

import br.com.picpay.buscausuario.dominio.IdentificadoresUsuariosPrioritarios;
import br.com.picpay.buscausuario.dominio.PalavraChave;
import br.com.picpay.buscausuario.dominio.TodosUsuarios;
import br.com.picpay.buscausuario.dominio.Usuarios;
import lombok.AllArgsConstructor;

@AllArgsConstructor
public class UsuariosService {
	
	private final TodosUsuarios todosUsuarios;
	private final IdentificadoresUsuariosPrioritarios idsPrioridade1;
	private final IdentificadoresUsuariosPrioritarios idsPrioridade2;
	
	public Usuarios buscarUsuariosPorPalavraChave(PalavraChave palavraChave, Pageable pageable) {
		// dessa forma, evita-se uma clausula or na consulta, que causa perda de performance
		Usuarios ret = new Usuarios(palavraChave.paraBuscarPorUsername() 
				? todosUsuarios.findByUsernameLikeIgnoreCase(palavraChave.toString(), pageable)
				: todosUsuarios.findByNomeLikeIgnoreCase(palavraChave.toString(), pageable));
		ret.priorizar(idsPrioridade2.lerTodos());
		ret.priorizar(idsPrioridade1.lerTodos());
		
		return ret;
	}	
}
