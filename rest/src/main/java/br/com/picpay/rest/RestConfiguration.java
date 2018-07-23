package br.com.picpay.rest;

import org.apache.http.HttpHost;
import org.elasticsearch.client.RestClient;
import org.elasticsearch.client.RestHighLevelClient;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;

import br.com.picpay.elasticsearch.ElasticSearchUserIndex;
import br.com.picpay.trabalheconosco.api.UserIndex;

@Configuration
public class RestConfiguration {
	@Bean
	public UserIndex index(RestHighLevelClient client) {
		return new ElasticSearchUserIndex(client);
	}

	@Bean
	public RestHighLevelClient elasticSearchClient(@Value("${elasticsearch.host}") String elasticSearchHost,
			@Value("${elasticsearch.port}") int elasticSearchPort) {
		return new RestHighLevelClient(
				RestClient.builder(new HttpHost[] { new HttpHost(elasticSearchHost, elasticSearchPort) }).build());
	}

}
