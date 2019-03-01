package br.com.vtferrari.trabalheconoscobackenddev.listener;

import br.com.vtferrari.trabalheconoscobackenddev.listener.converter.KafkaMessageConverter;
import br.com.vtferrari.trabalheconoscobackenddev.listener.converter.RelevancyConverter;
import br.com.vtferrari.trabalheconoscobackenddev.listener.resource.KafkaMessage;
import br.com.vtferrari.trabalheconoscobackenddev.service.RelevancyService;
import br.com.vtferrari.trabalheconoscobackenddev.service.domain.Relevancy;
import org.junit.Before;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.mockito.InjectMocks;
import org.mockito.Mock;
import org.mockito.junit.MockitoJUnitRunner;

import static org.mockito.ArgumentMatchers.*;
import static org.mockito.Mockito.*;

@RunWith(MockitoJUnitRunner.class)
public class RelevancyListenerTest {

    @InjectMocks
    private RelevancyListener relevancyListener;
    @Mock
    private KafkaMessageConverter kafkaMessageConverter;
    @Mock
    private RelevancyConverter relevancyConverter;
    @Mock
    private RelevancyService relevancyService;

    @Before
    public void setup() {
    }


    @Test
    public void testShouldSaveMessageOnDatabase() throws Exception {

        when(kafkaMessageConverter.convert(anyString())).thenReturn(new KafkaMessage());
        when(relevancyConverter.convert(any(KafkaMessage.class), anyInt())).thenReturn(Relevancy.builder().build());
        doNothing().when(relevancyService).save(any(Relevancy.class));

        relevancyListener.relevantListOne("message");

        verify(kafkaMessageConverter).convert(anyString());
        verify(relevancyConverter).convert(any(KafkaMessage.class), anyInt());
        verify(relevancyService).save(any(Relevancy.class));
    }
}