package br.com.vtferrari.trabalheconoscobackenddev.service.impl;

import br.com.vtferrari.trabalheconoscobackenddev.service.domain.Relevancy;
import br.com.vtferrari.trabalheconoscobackenddev.repository.RelevancyRepository;
import br.com.vtferrari.trabalheconoscobackenddev.repository.converter.RelevancyElasticsearchConverter;
import br.com.vtferrari.trabalheconoscobackenddev.service.RelevancyService;
import lombok.AllArgsConstructor;
import org.springframework.stereotype.Service;

@Service
@AllArgsConstructor
public class ElasticSearchRelevancyService implements RelevancyService {

    private final RelevancyRepository relevancyRepository;
    private final RelevancyElasticsearchConverter relevancyElasticsearchConverter;

    @Override
    public void save(Relevancy relevancy) {
        final var relevancyElasticsearch = relevancyElasticsearchConverter.convert(relevancy);
        relevancyRepository.save(relevancyElasticsearch);
    }
}
