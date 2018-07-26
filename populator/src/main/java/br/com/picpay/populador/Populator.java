package br.com.picpay.populador;

import java.util.function.Consumer;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.boot.ApplicationArguments;
import org.springframework.boot.ApplicationRunner;
import org.springframework.stereotype.Component;

import br.com.picpay.populador.api.Relevancies;
import br.com.picpay.populador.api.UserDataSource;
import br.com.picpay.trabalheconosco.api.User;
import br.com.picpay.trabalheconosco.api.UserIndex;

@Component
public class Populator implements ApplicationRunner {

	private static final Logger LOGGER = LoggerFactory.getLogger(Populator.class);

	private final UserDataSource rawDataSource;

	private final UserIndex userIndex;

	private final Relevancies relevancies;

	public Populator(UserDataSource rawDataSource, UserIndex userIndex, Relevancies relevancies) {
		this.rawDataSource = rawDataSource;
		this.userIndex = userIndex;
		this.relevancies = relevancies;
	}

	public void run(ApplicationArguments args) throws Exception {
		Counter counter = new Counter(0);
		LOGGER.info("Começando a ler o datasource: " + this.rawDataSource  + ". Vai demorar por que estou unzipando o arquivo");

		try {
			this.rawDataSource.asStream().forEach(new PopulatorConsumer(this.userIndex, counter, this.relevancies, LOGGER));
			LOGGER.info("Foram lidos " + counter.getValue() + " registros do datasource " + this.rawDataSource);
		} catch (Exception e) {
			LOGGER.error("Erro ao popular a base de dados", e);
		} finally {
			this.rawDataSource.close();
		}

	}

	private static class PopulatorConsumer implements Consumer<User> {

		private final UserIndex userIndex;
		private final Counter counter;
		private Relevancies relevancies;
		private final Logger logger;

		public PopulatorConsumer(UserIndex userIndex, Counter counter, Relevancies relevancies, Logger logger) {
			this.userIndex = userIndex;
			this.counter = counter;
			this.relevancies = relevancies;
			this.logger = logger;
		}

		public void accept(User user) {
			try {
				this.userIndex.put(user, this.relevancies.get(user.id()).value());
				this.counter.increment();
			} catch (Exception e) {
				this.logger.error("Erro ao indexar user", e);
			}
			
		};
	}

	private static class Counter {

		private int value;

		public Counter(int value) {
			this.value = value;
		}

		public void increment() {
			this.value++;
		}

		public int getValue() {
			return this.value;
		}

	}
}
