package br.com.vtferrari.trabalheconoscobackenddev.repository;

import br.com.vtferrari.trabalheconoscobackenddev.repository.model.RelevancyElasticsearch;
import org.springframework.data.elasticsearch.repository.ElasticsearchRepository;

public interface RelevancyRepository  extends ElasticsearchRepository<RelevancyElasticsearch, String> {
}
