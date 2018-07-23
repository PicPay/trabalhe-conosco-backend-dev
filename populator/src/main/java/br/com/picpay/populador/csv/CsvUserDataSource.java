package br.com.picpay.populador.csv;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.util.stream.Stream;

import br.com.picpay.populador.api.UserDataSource;
import br.com.picpay.trabalheconosco.api.User;

public class CsvUserDataSource implements UserDataSource {

	private final BufferedReader reader;

	public CsvUserDataSource(File file) throws FileNotFoundException {
		this.reader = new BufferedReader(new FileReader(file));
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
