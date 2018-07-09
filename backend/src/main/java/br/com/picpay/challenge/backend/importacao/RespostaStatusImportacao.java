package br.com.picpay.challenge.backend.importacao;

import br.com.picpay.challenge.backend.es.support.SimpleIndexStats;

public class RespostaStatusImportacao {

	private LogImportacao logImportacao;
	private SimpleIndexStats indexStats;

	public RespostaStatusImportacao(LogImportacao logImportacao, SimpleIndexStats indexStats) {
		this.logImportacao = logImportacao;
		this.indexStats = indexStats;
	}

	public LogImportacao getLogImportacao() {
		return logImportacao;
	}

	public void setLogImportacao(LogImportacao logImportacao) {
		this.logImportacao = logImportacao;
	}

	public SimpleIndexStats getIndexStats() {
		return indexStats;
	}

	public void setIndexStats(SimpleIndexStats indexStats) {
		this.indexStats = indexStats;
	}

}
