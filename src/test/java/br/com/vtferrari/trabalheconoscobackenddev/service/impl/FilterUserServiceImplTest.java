package br.com.vtferrari.trabalheconoscobackenddev.service.impl;

import br.com.vtferrari.trabalheconoscobackenddev.repository.UserRepository;
import br.com.vtferrari.trabalheconoscobackenddev.repository.converter.UserConverter;
import br.com.vtferrari.trabalheconoscobackenddev.repository.model.UserElasticsearch;
import br.com.vtferrari.trabalheconoscobackenddev.service.domain.Relevancy;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.mockito.InjectMocks;
import org.mockito.Mock;
import org.mockito.junit.MockitoJUnitRunner;
import org.springframework.data.domain.PageImpl;

import java.util.List;
import java.util.Optional;

import static org.mockito.ArgumentMatchers.any;
import static org.mockito.Mockito.*;

@RunWith(MockitoJUnitRunner.class)
public class FilterUserServiceImplTest {


    @InjectMocks
    private FilterUserServiceImpl elasticSearchRelevancyService;
    @Mock
    private UserRepository userRepository;
    @Mock
    private UserConverter userConverter;
    @Test
    public void testShouldSearchByNullAKeyword() {
        final Relevancy spec = Relevancy.builder().build();

        when(userRepository.findDistinctByKeyword(anyString(),anyInt(),anyInt())).thenReturn(new PageImpl<>(List.of(new UserElasticsearch())));
        when(userConverter.convert(any(UserElasticsearch.class))).thenCallRealMethod();


        elasticSearchRelevancyService.findUserByKeyword("test",0,10);

        verify(userConverter,times(1)).convert(any());
        verify(userRepository,times(1)).findDistinctByKeyword(anyString(),anyInt(),anyInt());

    }

}