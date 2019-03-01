package br.com.vtferrari.trabalheconoscobackenddev.listener.converter;

import br.com.vtferrari.trabalheconoscobackenddev.listener.resource.KafkaMessage;
import br.com.vtferrari.trabalheconoscobackenddev.service.domain.PriorityLevel;
import br.com.vtferrari.trabalheconoscobackenddev.service.domain.Relevancy;
import lombok.extern.slf4j.Slf4j;
import org.springframework.stereotype.Component;

@Slf4j
@Component
public class RelevancyConverter {

    public Relevancy convert(final KafkaMessage message, Integer level) {
        return Relevancy
                .builder()
                .priorityLevel(PriorityLevel.fromLevel(level))
                .id(message.getPayload())
                .build();
    }

}
