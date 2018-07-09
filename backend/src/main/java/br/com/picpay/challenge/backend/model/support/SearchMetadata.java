package br.com.picpay.challenge.backend.model.support;

/**
 * Representa os metadados de uma pesquisa.
 * 
 * @author francofabio
 *
 */
public class SearchMetadata {

	private double completedIn;
	private int page;
	private int totalPages;
	private int pageSize;
	private long totalElements;
	private String navRef;

	/**
	 * Cria uma instância para representar os metadados de uma pesquisa
	 * 
	 * @param completedIn Tempo, em segundos, que durou a execução da pesquisa
	 * @param page Número da página retornada
	 * @param totalPages Total de páginas disponíveis
	 * @param pageSize Quantidade de elementos na página
	 * @param totalElements Total de elementos encontrados
	 * @param navRef Referência para navegação entre as páginas
	 */
	public SearchMetadata(double completedIn, int page, int totalPages, int pageSize, long totalElements, String navRef) {
		this.completedIn = completedIn;
		this.page = page;
		this.totalPages = totalPages;
		this.pageSize = pageSize;
		this.totalElements = totalElements;
		this.navRef = navRef;
	}
	
	/**
	 * Tempo, em segundos, que durou a execução da pesquisa
	 */
	public double getCompletedIn() {
		return completedIn;
	}

	/**
	 * Número da página retornada
	 */
	public int getPage() {
		return page;
	}

	/**
	 * Total de páginas disponíveis
	 */
	public int getTotalPages() {
		return totalPages;
	}

	/**
	 * Quantidade de elementos na página
	 */
	public int getPageSize() {
		return pageSize;
	}

	/**
	 * Total de elementos encontrados
	 */
	public long getTotalElements() {
		return totalElements;
	}
	
	/**
	 * Referência para navegação entre as páginas.<br>
	 * Deve ser utilizado para navegação entre os resultados
	 */
	public String getNavRef() {
		return navRef;
	}
	
}
