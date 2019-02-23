package br.com.vtferrari.trabalheconoscobackenddev.repository.customized;

import br.com.vtferrari.trabalheconoscobackenddev.repository.model.UserElasticsearch;
import com.github.vanroy.springdata.jest.JestElasticsearchTemplate;
import lombok.AllArgsConstructor;
import org.elasticsearch.common.lucene.search.function.CombineFunction;
import org.elasticsearch.index.query.QueryBuilder;
import org.elasticsearch.index.query.QueryBuilders;
import org.elasticsearch.index.query.functionscore.FunctionScoreQueryBuilder.FilterFunctionBuilder;
import org.elasticsearch.index.query.functionscore.WeightBuilder;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.elasticsearch.core.query.NativeSearchQueryBuilder;
import org.springframework.stereotype.Repository;

import static org.elasticsearch.index.query.QueryBuilders.boolQuery;
import static org.elasticsearch.index.query.QueryBuilders.fuzzyQuery;

@Repository
@AllArgsConstructor
public class CustomizedUserRepositoryImpl implements CustomizedUserRepository {

    private final JestElasticsearchTemplate jestElasticsearchTemplate;

    @Override
    public Page<UserElasticsearch> findDistinctByKeyword(String keyword, Integer page, Integer size) {

        final var nativeSearchQuery =
                new NativeSearchQueryBuilder()
                        .withQuery(getQueryBuilder(keyword))
                        .withPageable(PageRequest.of(page, size))
                        .build();
        return jestElasticsearchTemplate.queryForPage(nativeSearchQuery, UserElasticsearch.class);
    }

    private QueryBuilder getQueryBuilder(String keyword) {

        final var should = boolQuery()
                .should(fuzzyQuery("name", keyword))
                .should(fuzzyQuery("name", keyword));
        return getQueryWithWeight(should);
    }

    private QueryBuilder getQueryWithWeight(QueryBuilder queryBuilder) {

        return QueryBuilders.functionScoreQuery(queryBuilder, getFilterFunctionBuilders())
                .boostMode(CombineFunction.MULTIPLY);
    }

    private FilterFunctionBuilder[] getFilterFunctionBuilders() {
        return new FilterFunctionBuilder[]{
                getPriority(0, 100),
                getPriority(1, 50)
        };
    }

    private FilterFunctionBuilder getPriority(int priority, int weight) {
        return new FilterFunctionBuilder(QueryBuilders.termQuery("priority", priority), getWeightBuilder(weight));
    }

    private WeightBuilder getWeightBuilder(Integer weight) {
        final WeightBuilder weightBuilder = new WeightBuilder();
        weightBuilder.setWeight(weight);
        return weightBuilder;
    }

}
