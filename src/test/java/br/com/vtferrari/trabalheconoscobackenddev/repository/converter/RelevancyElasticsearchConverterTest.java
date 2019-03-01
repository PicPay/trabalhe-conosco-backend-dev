package br.com.vtferrari.trabalheconoscobackenddev.repository.converter;

import br.com.vtferrari.trabalheconoscobackenddev.repository.model.RelevancyElasticsearch;
import br.com.vtferrari.trabalheconoscobackenddev.service.domain.PriorityLevel;
import br.com.vtferrari.trabalheconoscobackenddev.service.domain.Relevancy;
import org.junit.Before;
import org.junit.Test;

import static org.junit.Assert.*;

public class RelevancyElasticsearchConverterTest {

    private RelevancyElasticsearchConverter relevancyElasticsearchConverter;

    @Before
    public void setup(){
        relevancyElasticsearchConverter=new RelevancyElasticsearchConverter();
    }

    @Test
    public void testShouldConvert(){
        final var spec = Relevancy
                .builder()
                .id("new id")
                .priorityLevel(PriorityLevel.LOW)
                .build();
        final var result = relevancyElasticsearchConverter.convert(spec);

        assertEquals(spec.getId(),result.getId());
        assertEquals(spec.getPriorityLevel().getLevel().intValue(),result.getPriorityLevel());
    }


}