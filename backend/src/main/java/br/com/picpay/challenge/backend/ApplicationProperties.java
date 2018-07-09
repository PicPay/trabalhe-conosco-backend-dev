package br.com.picpay.challenge.backend;

import org.springframework.boot.context.properties.ConfigurationProperties;
import org.springframework.context.annotation.Configuration;

@Configuration
@ConfigurationProperties("app")
public class ApplicationProperties {
	private String usersUrl;
	private String prioridade1Url;
	private String prioridade2Url;
	private boolean cargaAutomaticaInicializacao;
	private int numTasksCargaInicial;
	private int bulkSize;
	private String userAuthName;
	private String userAuthUsername;
	private String userAuthApiKey;

	public String getUserAuthName() {
		return userAuthName;
	}

	public void setUserAuthName(String userAuthName) {
		this.userAuthName = userAuthName;
	}

	public String getUserAuthUsername() {
		return userAuthUsername;
	}

	public void setUserAuthUsername(String userAuthUsername) {
		this.userAuthUsername = userAuthUsername;
	}

	public String getUserAuthApiKey() {
		return userAuthApiKey;
	}

	public void setUserAuthApiKey(String userAuthApiKey) {
		this.userAuthApiKey = userAuthApiKey;
	}

	public String getUsersUrl() {
		return usersUrl;
	}

	public void setUsersUrl(String usersUrl) {
		this.usersUrl = usersUrl;
	}

	public String getPrioridade1Url() {
		return prioridade1Url;
	}

	public void setPrioridade1Url(String prioridade1Url) {
		this.prioridade1Url = prioridade1Url;
	}

	public String getPrioridade2Url() {
		return prioridade2Url;
	}

	public void setPrioridade2Url(String prioridade2Url) {
		this.prioridade2Url = prioridade2Url;
	}

	public int getNumTasksCargaInicial() {
		return numTasksCargaInicial;
	}

	public void setNumTasksCargaInicial(int numTasksCargaInicial) {
		this.numTasksCargaInicial = numTasksCargaInicial;
	}

	public boolean isCargaAutomaticaInicializacao() {
		return cargaAutomaticaInicializacao;
	}

	public void setCargaAutomaticaInicializacao(boolean cargaAutomaticaInicializacao) {
		this.cargaAutomaticaInicializacao = cargaAutomaticaInicializacao;
	}

	public int getBulkSize() {
		return bulkSize;
	}

	public void setBulkSize(int bulkSize) {
		this.bulkSize = bulkSize;
	}

}
