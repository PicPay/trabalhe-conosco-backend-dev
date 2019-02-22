package br.com.vtferrari.trabalheconoscobackenddev.repository.converter;


import br.com.vtferrari.trabalheconoscobackenddev.service.domain.Relevancy;
import br.com.vtferrari.trabalheconoscobackenddev.repository.model.RelevancyElasticsearch;
import org.springframework.stereotype.Component;

@Component
public class RelevancyElasticsearchConverter {

    public RelevancyElasticsearch convert(Relevancy relevancy) {
        return RelevancyElasticsearch
                .builder()
                .id(relevancy.getId())
                .priorityLevel(relevancy.getPriorityLevel().getLevel())
                .build();
    }
}
