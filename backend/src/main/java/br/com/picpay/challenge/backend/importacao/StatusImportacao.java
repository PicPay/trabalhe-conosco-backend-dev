package br.com.picpay.challenge.backend.importacao;

/**
 * Representa o status da importação de dados para índice de usuários
 * 
 * @author francofabio
 *
 */
public enum StatusImportacao {
	/**
	 * Importação em andatamento
	 */
	EM_ANDAMENTO,
	/**
	 * Importação concluída com sucesso
	 */
	CONCLUIDO,
	/**
	 * Importação encerrada com erro
	 */
	ERRO;
}
