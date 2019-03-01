package br.com.vtferrari.trabalheconoscobackenddev.service.impl;

import br.com.vtferrari.trabalheconoscobackenddev.repository.RelevancyRepository;
import br.com.vtferrari.trabalheconoscobackenddev.repository.UserRepository;
import br.com.vtferrari.trabalheconoscobackenddev.repository.converter.RelevancyElasticsearchConverter;
import br.com.vtferrari.trabalheconoscobackenddev.repository.model.UserElasticsearch;
import br.com.vtferrari.trabalheconoscobackenddev.service.domain.PriorityLevel;
import br.com.vtferrari.trabalheconoscobackenddev.service.domain.Relevancy;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.mockito.InjectMocks;
import org.mockito.Mock;
import org.mockito.junit.MockitoJUnitRunner;

import java.util.Optional;

import static org.mockito.ArgumentMatchers.any;
import static org.mockito.Mockito.*;

@RunWith(MockitoJUnitRunner.class)
public class ElasticSearchRelevancyServiceTest {

    @InjectMocks
    private ElasticSearchRelevancyService elasticSearchRelevancyService;
    @Mock
    private RelevancyRepository relevancyRepository;
    @Mock
    private UserRepository userRepository;
    @Mock
    private RelevancyElasticsearchConverter relevancyElasticsearchConverter;

    @Test
    public void testShouldSearchByNullId() {
        final Relevancy spec = Relevancy.builder().build();

        elasticSearchRelevancyService.save(spec);
        verify(relevancyElasticsearchConverter,times(1)).convert(any());
        verify(userRepository,never()).findById(any());
        verify(relevancyRepository,never()).save(any());

    }

    @Test
    public void testShouldSearchById() {
        final Relevancy spec = Relevancy.builder().priorityLevel(PriorityLevel.ERROR).id("Test").build();
        when(relevancyElasticsearchConverter.convert(any(Relevancy.class))).thenCallRealMethod();
        when(userRepository.findById(any())).thenReturn(Optional.of(new UserElasticsearch()));


        elasticSearchRelevancyService.save(spec);

        verify(relevancyElasticsearchConverter,times(1)).convert(any());
        verify(userRepository,times(1)).findById(any());
        verify(relevancyRepository,times(1)).save(any());

    }
}