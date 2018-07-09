package br.com.picpay.challenge.backend.es.support;

public class SimpleIndexStats {
	private long totalDocs;
	private long totalSize;

	public SimpleIndexStats(long totalDocs, long totalSize) {
		this.totalDocs = totalDocs;
		this.totalSize = totalSize;
	}

	public long getTotalDocs() {
		return totalDocs;
	}

	public void setTotalDocs(long totalDocs) {
		this.totalDocs = totalDocs;
	}

	public long getTotalSize() {
		return totalSize;
	}

	public void setTotalSize(long totalSize) {
		this.totalSize = totalSize;
	}

}
