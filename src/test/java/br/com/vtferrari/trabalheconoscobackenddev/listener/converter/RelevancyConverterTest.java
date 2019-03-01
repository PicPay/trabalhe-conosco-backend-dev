package br.com.vtferrari.trabalheconoscobackenddev.listener.converter;

import br.com.vtferrari.trabalheconoscobackenddev.listener.resource.KafkaMessage;
import br.com.vtferrari.trabalheconoscobackenddev.service.domain.PriorityLevel;
import org.junit.Before;
import org.junit.Test;

import static org.junit.Assert.assertEquals;

public class RelevancyConverterTest {

    private RelevancyConverter relevancyConverter;

    @Before
    public void setup() {
        relevancyConverter = new RelevancyConverter();
    }


    @Test
    public void testShouldConvertKafkaMessageInRelevancy() {

        final var spec = new KafkaMessage();
        spec.setPayload("teste");
        final var result = relevancyConverter.convert(spec, 0);
        assertEquals(spec.getPayload(), result.getId());
        assertEquals(PriorityLevel.HIGH, result.getPriorityLevel());

    }

}