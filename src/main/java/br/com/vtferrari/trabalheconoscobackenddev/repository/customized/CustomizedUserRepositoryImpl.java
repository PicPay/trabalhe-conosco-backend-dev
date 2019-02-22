package br.com.vtferrari.trabalheconoscobackenddev.repository.customized;

import br.com.vtferrari.trabalheconoscobackenddev.repository.model.UserElasticsearch;
import com.github.vanroy.springdata.jest.JestElasticsearchTemplate;
import lombok.AllArgsConstructor;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.elasticsearch.core.query.NativeSearchQueryBuilder;
import org.springframework.stereotype.Repository;

import static org.elasticsearch.index.query.QueryBuilders.boolQuery;
import static org.elasticsearch.index.query.QueryBuilders.fuzzyQuery;

@Repository
@AllArgsConstructor
public class CustomizedUserRepositoryImpl implements CustomizedUserRepository {

    private final JestElasticsearchTemplate jestElasticsearchTemplate;

    @Override
    public Page<UserElasticsearch> findDistinctByKeyword(String keyword, Pageable pageable) {
        final var query = boolQuery()
                .should(fuzzyQuery("name", keyword))
                .should(fuzzyQuery("name", keyword));
        final var nativeSearchQuery =
                new NativeSearchQueryBuilder()
                        .withQuery(query)
                        .build();
        return jestElasticsearchTemplate.queryForPage(nativeSearchQuery, UserElasticsearch.class);
    }

}
