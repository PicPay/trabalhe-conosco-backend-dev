package br.com.picpay.populador.relevance;

import br.com.picpay.populador.api.RelevanceList;

public class RelevanceFromLists implements br.com.picpay.populador.api.Relevance {
	private final String id;
	private final RelevanceList[] lists;

	public RelevanceFromLists(String id, RelevanceList... lists) {
		this.id = id;
		this.lists = lists;
	}

	public int value() {
		for (int i = 0; i < this.lists.length; i++) {
			if (this.lists[i].contains(this.id)) {
				return this.lists.length - i;
			}
		}
		return 0;
	}
}
