package br.com.vtferrari.trabalheconoscobackenddev.listener;

import br.com.vtferrari.trabalheconoscobackenddev.listener.converter.KafkaMessageConverter;
import br.com.vtferrari.trabalheconoscobackenddev.listener.converter.RelevancyConverter;
import br.com.vtferrari.trabalheconoscobackenddev.listener.exception.IdNotFoundException;
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

    private static final int HIGH = 0;
    private static final int LOW = 1;
    private final KafkaMessageConverter kafkaMessageConverter;
    private final RelevancyConverter relevancyConverter;
    private final RelevancyService relevancyService;

    @KafkaListener(topics = "trabalhe-conosco-backend-dev.relevant.list.1")
    public void relevantListOne(@Payload String message) throws Exception {
        processMessage(message, HIGH);
    }

    @KafkaListener(topics = "trabalhe-conosco-backend-dev.relevant.list.2")
    public void relevantListTwo(String message) throws IOException {
        processMessage(message, LOW);
    }


    private void processMessage(@Payload String message, int high) {
        Mono.just(message)
                .map(kafkaMessageConverter::convert)
                .map(kafkaMessage -> relevancyConverter.convert(kafkaMessage, high))
                .doOnNext(relevancyService::save)
                .retry(throwable-> IdNotFoundException.class.equals(throwable.getClass()))
                .doOnError(t-> System.out.println("error"))
                .block();
    }


}
