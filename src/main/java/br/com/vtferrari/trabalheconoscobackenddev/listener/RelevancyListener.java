package br.com.vtferrari.trabalheconoscobackenddev.listener;

import br.com.vtferrari.trabalheconoscobackenddev.listener.converter.KafkaMessageConverter;
import br.com.vtferrari.trabalheconoscobackenddev.listener.converter.RelevancyConverter;
import br.com.vtferrari.trabalheconoscobackenddev.service.RelevancyService;
import lombok.AllArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.kafka.annotation.KafkaListener;
import org.springframework.messaging.handler.annotation.Payload;
import org.springframework.stereotype.Component;
import reactor.core.publisher.Mono;

import java.io.IOException;

@Slf4j
@Component
@AllArgsConstructor
public class RelevancyListener {

    private final KafkaMessageConverter kafkaMessageConverter;
    private final RelevancyConverter relevancyConverter;
    private final RelevancyService relevancyService;

    @KafkaListener(topics = "trabalhe-conosco-backend-dev.relevant.list.1")
    public void relevantListOne(@Payload String message) throws Exception {
        Mono.just(message)
                .map(kafkaMessageConverter::convert)
                .map(kafkaMessage -> relevancyConverter.convert(kafkaMessage, 0))
                .doOnNext(relevancyService::save)
                .block();
    }

    @KafkaListener(topics = "trabalhe-conosco-backend-dev.relevant.list.2")
    public void relevantListTwo(String message) throws IOException {
        Mono.just(message)
                .map(kafkaMessageConverter::convert)
                .map(kafkaMessage -> relevancyConverter.convert(kafkaMessage, 1))
                .doOnNext(relevancyService::save)
                .block();
    }

}
