package br.com.picpay.populador.api;

public interface RelevanceList {

	boolean contains(String id);

	public final class FromDataSource implements RelevanceList {

		private RelevanceDataSource ds;

		public FromDataSource(RelevanceDataSource ds) {
			this.ds = ds;
		}

		@Override
		public boolean contains(String id) {
			return this.ds.asSet().contains(id);
		}
	}
}
