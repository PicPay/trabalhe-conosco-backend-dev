package br.com.vtferrari.trabalheconoscobackenddev.listener.converter;

import br.com.vtferrari.trabalheconoscobackenddev.listener.resource.KafkaMessage;
import com.fasterxml.jackson.databind.ObjectMapper;
import lombok.AllArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.stereotype.Component;
import reactor.core.Exceptions;

import java.io.IOException;

@Slf4j
@Component
@AllArgsConstructor
public class KafkaMessageConverter {

    private final ObjectMapper objectMapper;

    public KafkaMessage convert(final String message) {
        try {
            return objectMapper.readValue(message, KafkaMessage.class);
        } catch (IOException e) {
            throw Exceptions.propagate(e);
        }
    }

}
