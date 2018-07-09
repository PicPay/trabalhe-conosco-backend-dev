package br.com.picpay.challenge.backend.es.support;

import java.util.List;

import org.springframework.boot.context.properties.ConfigurationProperties;
import org.springframework.context.annotation.Configuration;

/**
 * Configurações para conexão com elastic search
 * 
 * @author francofabio
 *
 */
@Configuration
@ConfigurationProperties(prefix = "elasticsearch")
public class ElasticsearchProperties {

	private List<HostInfo> hosts;

	public List<HostInfo> getHosts() {
		return hosts;
	}
	
	public void setHosts(List<HostInfo> hosts) {
		this.hosts = hosts;
	}
	
	public static class HostInfo {
		private String host;
		private int port;
		private String schema;

		public String getHost() {
			return host;
		}

		public void setHost(String host) {
			this.host = host;
		}

		public int getPort() {
			return port;
		}

		public void setPort(int port) {
			this.port = port;
		}

		public String getSchema() {
			return schema;
		}

		public void setSchema(String schema) {
			this.schema = schema;
		}

	}

}
