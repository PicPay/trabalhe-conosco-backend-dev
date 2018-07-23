package br.com.picpay.populador;

import java.io.File;
import java.io.FileNotFoundException;

import org.apache.http.HttpHost;
import org.elasticsearch.client.RestClient;
import org.elasticsearch.client.RestHighLevelClient;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;

import br.com.picpay.elasticsearch.ElasticSearchUserIndex;
import br.com.picpay.populador.api.Relevancies;
import br.com.picpay.populador.api.UserDataSource;
import br.com.picpay.populador.csv.CsvUserDataSource;
import br.com.picpay.populador.relevance.RelevanciesFromFiles;
import br.com.picpay.trabalheconosco.api.UserIndex;

@Configuration
public class PopulatorConfiguration {
	@Bean
	public Relevancies fromConfiguration(@Value("${relevancies}") String[] relevanceFiles) {
		return new RelevanciesFromFiles(relevanceFiles);
	}

	@Bean
	public UserDataSource userDataSource(@Value("${datafile.path}") String dataFile) throws FileNotFoundException {
		return new CsvUserDataSource(new File(dataFile));
	}

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
