package picpay.config;

import java.net.InetAddress;
import java.net.UnknownHostException;

import org.elasticsearch.client.Client;
import org.elasticsearch.client.transport.TransportClient;
import org.elasticsearch.common.settings.Settings;
import org.elasticsearch.common.transport.TransportAddress;
import org.elasticsearch.transport.client.PreBuiltTransportClient;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.context.annotation.Configuration;
import org.springframework.data.elasticsearch.core.ElasticsearchOperations;
import org.springframework.data.elasticsearch.core.ElasticsearchTemplate;
import org.springframework.data.elasticsearch.repository.config.EnableElasticsearchRepositories;

@Configuration
@EnableElasticsearchRepositories(basePackages = "com.baeldung.spring.data.es.repository")
@ComponentScan(basePackages = { "com.baeldung.spring.data.es.service" })
public class Config {

	@Value("${elasticsearch.home:F:/elasticsearch-6.4.3}")
	private String elasticsearchHome;

	@Value("${elasticsearch.cluster.name:elasticsearch}")
	private String clusterName;

	@Bean
	public Client client() {
		System.out.println("construtor cliente");
		TransportClient client = null;
		try {
			
			final Settings elasticsearchSettings = Settings.builder()
					.put("client.transport.sniff", true)
					.put("path.home", elasticsearchHome)
					.put("cluster.name", clusterName)
					//.put("index.refresh_interval", 30)
					.build();
			client = new PreBuiltTransportClient(elasticsearchSettings);

			client.addTransportAddress(new TransportAddress(InetAddress.getByName("127.0.0.1"), 9300));

		} catch (UnknownHostException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		return client;
	}

//	@Bean
//	public ElasticsearchOperations elasticsearchTemplate2() {
//		return new ElasticsearchTemplate(client());
//	}
}