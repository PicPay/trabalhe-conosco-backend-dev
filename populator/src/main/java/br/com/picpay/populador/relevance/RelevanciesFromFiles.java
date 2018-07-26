package br.com.picpay.populador.relevance;

import java.io.File;
import java.util.Arrays;

import br.com.picpay.populador.api.Relevance;
import br.com.picpay.populador.api.RelevanceDataSource;
import br.com.picpay.populador.api.RelevanceList;
import br.com.picpay.populador.api.Relevancies;

public class RelevanciesFromFiles implements Relevancies {

	private final String[] relevanceFiles;

	public RelevanciesFromFiles(String[] relevanceFiles) {
		this.relevanceFiles = relevanceFiles;
	}

	@Override
	public Relevance get(String id) {
		return new RelevanceFromLists(id, lists());
	}

	private RelevanceList[] lists() {
		return Arrays.stream(this.relevanceFiles)
				.map(f -> new RelevanceList.FromDataSource(
						new RelevanceDataSource.Cached(
								new RelevanceDataSource.FromFile(new File(f)))))
				.toArray(RelevanceList[]::new);
	}

}
