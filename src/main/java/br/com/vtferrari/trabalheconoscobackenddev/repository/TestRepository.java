package br.com.vtferrari.trabalheconoscobackenddev.repository;

import br.com.vtferrari.trabalheconoscobackenddev.model.User;
import org.springframework.data.elasticsearch.repository.ElasticsearchRepository;

public interface TestRepository extends ElasticsearchRepository<User, String> {
}
