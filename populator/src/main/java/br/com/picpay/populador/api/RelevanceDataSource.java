package br.com.picpay.populador.api;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.util.Set;
import java.util.stream.Collectors;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public interface RelevanceDataSource {

	Set<String> asSet();

	public final class Cached implements RelevanceDataSource {

		private final Set<String> cache;

		public Cached(RelevanceDataSource origin) {
			this.cache = origin.asSet();
		}

		@Override
		public Set<String> asSet() {
			return this.cache;
		}
	}

	public final class FromFile implements RelevanceDataSource {

		private static final Logger LOGGER = LoggerFactory.getLogger(FromFile.class);

		private final File file;

		public FromFile(File file) {
			this.file = file;
		}

		@Override
		public Set<String> asSet() {
			BufferedReader bufferedReader = null;
			try {
				bufferedReader = new BufferedReader(new FileReader(this.file));
				return bufferedReader.lines().collect(Collectors.toSet());
			} catch (Exception e) {
				throw new RuntimeException("Erro ao ler o arquivo de relevancia: " + this.file.getName(), e);
			} finally {
				if (bufferedReader != null) {
					try {
						bufferedReader.close();
					} catch (IOException e) {
						LOGGER.warn("Erro ao frchar arquivo: " + this.file.getName(), e);
					}
				}
			}

		}
	}
}
