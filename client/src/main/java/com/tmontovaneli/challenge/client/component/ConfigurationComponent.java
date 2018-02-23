package com.tmontovaneli.challenge.client.component;

import org.springframework.stereotype.Component;

@Component
public class ConfigurationComponent {

	private static ConfigurationComponent configurationComponent;

	private boolean cargaBancoDadosCompleta;

	private ConfigurationComponent() {
	}

	public static ConfigurationComponent getInstance() {
		if (configurationComponent == null)
			configurationComponent = new ConfigurationComponent();

		return configurationComponent;
	}

	public boolean isCargaBancoDadosCompleta() {
		return cargaBancoDadosCompleta;
	}

	public void setCargaBancoDadosCompleta(boolean cargaBancoDadosCompleta) {
		this.cargaBancoDadosCompleta = cargaBancoDadosCompleta;
	}

}
