package br.com.vtferrari.trabalheconoscobackenddev.repository.customized;

import br.com.vtferrari.trabalheconoscobackenddev.repository.model.UserElasticsearch;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

public interface CustomizedUserRepository {

    Page<UserElasticsearch> findDistinctByKeyword(String keyword, Pageable pageable);

}
