package br.com.vtferrari.trabalheconoscobackenddev.repository.customized;

import br.com.vtferrari.trabalheconoscobackenddev.repository.model.UserElasticsearch;
import com.github.vanroy.springdata.jest.JestElasticsearchTemplate;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.mockito.InjectMocks;
import org.mockito.Mock;
import org.mockito.junit.MockitoJUnitRunner;
import org.springframework.data.elasticsearch.core.query.NativeSearchQuery;

import static org.mockito.ArgumentMatchers.any;
import static org.mockito.ArgumentMatchers.eq;
import static org.mockito.Mockito.verify;

@RunWith(MockitoJUnitRunner.class)
public class CustomizedUserRepositoryImplTest {
    @InjectMocks
    private CustomizedUserRepositoryImpl customizedUserRepository;
    @Mock
    private JestElasticsearchTemplate jestElasticsearchTemplate;

    @Test
    public void testShouldCreateAQuery() {

        customizedUserRepository.findDistinctByKeyword("alfred", 0, 10);

        verify(jestElasticsearchTemplate).queryForPage(any(NativeSearchQuery.class), eq(UserElasticsearch.class));
    }
}