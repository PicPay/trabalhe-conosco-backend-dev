package br.com.vtferrari.trabalheconoscobackenddev.repository;

import br.com.vtferrari.trabalheconoscobackenddev.repository.customized.CustomizedUserRepository;
import br.com.vtferrari.trabalheconoscobackenddev.repository.model.UserElasticsearch;
import org.springframework.data.elasticsearch.repository.ElasticsearchRepository;

public interface UserRepository extends ElasticsearchRepository<UserElasticsearch, String>, CustomizedUserRepository {
}
