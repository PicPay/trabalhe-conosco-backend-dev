package br.com.vtferrari.trabalheconoscobackenddev.listener.converter;

import br.com.vtferrari.trabalheconoscobackenddev.listener.resource.KafkaMessage;
import com.fasterxml.jackson.databind.ObjectMapper;
import org.junit.Before;
import org.junit.Test;

import static org.junit.Assert.assertEquals;

public class KafkaMessageConverterTest {
    private KafkaMessageConverter kafkaMessageConverter;

    @Before
    public void setup() {
        kafkaMessageConverter = new KafkaMessageConverter(new ObjectMapper());
    }

    @Test
    public void testShouldConvert() {

        final KafkaMessage result = kafkaMessageConverter.convert("{\"payload\":\"new message\"}");
        assertEquals("new message", result.getPayload());
    }

}