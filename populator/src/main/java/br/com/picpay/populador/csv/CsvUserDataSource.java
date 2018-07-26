package br.com.picpay.populador.csv;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.stream.Stream;
import java.util.zip.GZIPInputStream;

import br.com.picpay.populador.api.UserDataSource;
import br.com.picpay.trabalheconosco.api.User;

public class CsvUserDataSource implements UserDataSource {
	
	private final BufferedReader reader;
	

	public CsvUserDataSource(File file) throws IOException {
		FileInputStream fileIn = new FileInputStream(file);
		GZIPInputStream gzipInputStream = new GZIPInputStream(fileIn);
		this.reader= new BufferedReader(new InputStreamReader(gzipInputStream));
	}

	@Override
	public Stream<? extends UserFromCsvLine> asStream() {
		return this.reader.lines().map(l -> new UserFromCsvLine(l));
	}

	@Override
	public void close() throws IOException {
		this.reader.close();
	}

	private static class UserFromCsvLine implements User {

		private final User user;

		public UserFromCsvLine(String line) {
			String[] tokens = line.split(",");
			this.user = new User.Fixed(tokens[0], tokens[1], tokens[2]);
		}

		@Override
		public String id() {
			return this.user.id();
		}

		@Override
		public String name() {
			return this.user.name();
		}

		@Override
		public String username() {
			return this.user.username();
		}

	}
}
