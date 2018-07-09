package br.com.picpay.challenge.backend.model.support;

import java.util.List;

/**
 * Representa uma página do resultado da pesquisa.
 * 
 * @author francofabio
 *
 * @param <T>
 */
public class Page<T> {
	
	private List<T> content;
	private SearchMetadata searchMetadata;

	/**
	 * Cria objeto para representação de uma página do resultado da pesquisa
	 * 
	 * @param completedIn Tempo, em segundos, que durou a execução da pesquisa 
	 * @param page Número da página retornada
	 * @param totalPages Total de páginas disponíveis
	 * @param pageSize  Quantidade de elementos na página
	 * @param totalElements Total de elementos encontrados
	 * @param navRef Referência para navegação entre as páginas
	 * @param content Conteúdo da página
	 */
	public Page(double completedIn, int page, int totalPages, int pageSize, long totalElements, String navRef,
			List<T> content) {
		this.content = content;
		this.searchMetadata = new SearchMetadata(completedIn, page, totalPages, pageSize, totalElements, navRef); 
	}
	
	/**
	 * Metadados da pesquisa
	 */
	public SearchMetadata getSearchMetadata() {
		return searchMetadata;
	}

	/**
	 * Conteúdo da página
	 */
	public List<T> getContent() {
		return content;
	}

}
