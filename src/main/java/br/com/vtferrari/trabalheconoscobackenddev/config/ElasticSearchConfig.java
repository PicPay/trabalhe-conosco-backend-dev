package br.com.vtferrari.trabalheconoscobackenddev.config;

import com.github.vanroy.springdata.jest.JestElasticsearchTemplate;
import com.github.vanroy.springdata.jest.mapper.DefaultJestResultsMapper;
import com.github.vanroy.springdata.jest.mapper.JestResultsMapper;
import io.searchbox.client.JestClient;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.data.elasticsearch.core.DefaultEntityMapper;
import org.springframework.data.elasticsearch.core.mapping.SimpleElasticsearchMappingContext;
import org.springframework.http.converter.json.Jackson2ObjectMapperBuilder;

@Configuration
public class ElasticSearchConfig {
    @Bean
    public JestElasticsearchTemplate elasticsearchTemplate(JestClient client) {
        return new JestElasticsearchTemplate(client, defaultJestResultsMapper());
    }

    @Bean
    public DefaultJestResultsMapper defaultJestResultsMapper() {
        return new DefaultJestResultsMapper(elasticsearchMappingContext());
    }

    @Bean
    public SimpleElasticsearchMappingContext elasticsearchMappingContext() {
        return new SimpleElasticsearchMappingContext();
    }

}
