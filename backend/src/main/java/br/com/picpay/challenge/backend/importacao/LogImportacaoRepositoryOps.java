package br.com.picpay.challenge.backend.importacao;

public interface LogImportacaoRepositoryOps {

	/**
	 * Desmarca os registros anteriores que estão marcados como <i>current</i>
	 * 
	 * @param newCurrentId Novo registro current
	 * @return Quantidade de registros atualizados
	 */
	int unmarkPreviousCurrent(String newCurrentId);
	
}
