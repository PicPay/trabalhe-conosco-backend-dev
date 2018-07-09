package br.com.picpay.challenge.backend;

import java.util.concurrent.Executor;

import org.apache.http.HttpHost;
import org.elasticsearch.client.RestClient;
import org.elasticsearch.client.RestHighLevelClient;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.scheduling.annotation.EnableAsync;
import org.springframework.scheduling.concurrent.ThreadPoolTaskExecutor;

import br.com.picpay.challenge.backend.es.support.ElasticsearchProperties;

@Configuration
@EnableAsync
public class ApplicationConfig {

	@Autowired
	private ElasticsearchProperties elasticsearchProperties;
	
	@Autowired
	private ExecutorProperties executorProperties;
	
	@Bean(destroyMethod = "close")
	public RestHighLevelClient elasticsearchClient() {
		return new RestHighLevelClient(RestClient.builder(elasticsearchProperties.getHosts()
				.stream()
				.map(hostInfo -> new HttpHost(hostInfo.getHost(), hostInfo.getPort(), hostInfo.getSchema()))
				.toArray(HttpHost[]::new)));
	}
	
	@Bean
	public Executor asyncExecutor() {
		ThreadPoolTaskExecutor executor = new ThreadPoolTaskExecutor();
		executor.setCorePoolSize(executorProperties.getCorePoolSize());
		executor.setMaxPoolSize(executorProperties.getMaxPoolSize());
		executor.setQueueCapacity(executorProperties.getQueueSize());
		executor.setThreadNamePrefix(executorProperties.getThreadNamePrefix());
		executor.initialize();
		return executor;
	}
	
}
