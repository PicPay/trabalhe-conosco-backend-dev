package br.com.picpay.buscausuario.dominio;

import java.util.List;
import java.util.UUID;

import org.springframework.data.domain.Pageable;
import org.springframework.data.repository.PagingAndSortingRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface TodosUsuarios extends PagingAndSortingRepository<Usuario, UUID>  {

	List<Usuario> findByNomeLikeIgnoreCase(String palavraChave, Pageable pageable);
	List<Usuario> findByUsernameLikeIgnoreCase(String palavraChave, Pageable pageable);
}
