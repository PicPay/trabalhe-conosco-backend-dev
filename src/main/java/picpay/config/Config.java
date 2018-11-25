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
import org.springframework.context.annotation.Configuration;

@Configuration
public class Config {
	@Value("${elasticsearch.cluster.name:elasticsearch}")
	private String clusterName;
	
	@Value("${elasticsearch.address}")
	private String elasticearchAddress;
	
	@Value("${elasticsearch.port}")
	private int elasticsearchPort;

	@Bean
	public Client client() {
		System.out.println("construtor cliente");
		TransportClient client = null;
		try {
			
			final Settings elasticsearchSettings = Settings.builder()
					//.put("client.transport.sniff", true)
					.put("cluster.name", clusterName)
					//.put("index.refresh_interval", 30)
					.build();
			client = new PreBuiltTransportClient(elasticsearchSettings);

			client.addTransportAddress(new TransportAddress(InetAddress.getByName(elasticearchAddress), elasticsearchPort));

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