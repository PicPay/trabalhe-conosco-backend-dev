package com.picpay;

import com.fasterxml.jackson.databind.MappingIterator;
import com.picpay.model.User;
import com.picpay.repositories.UserRepository;
import com.picpay.util.CsvUtil;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.boot.CommandLineRunner;
import org.springframework.core.io.ClassPathResource;
import org.springframework.stereotype.Component;

import java.io.InputStream;
import java.net.URL;
import java.util.logging.Logger;
import java.util.zip.GZIPInputStream;

/**
 * @author Bruno Carreira
 */
// tag::code[]
@Component
public class DatabaseLoader implements CommandLineRunner {

	@Value("${com.picpay.csv.database.url}")
	private final String csvDatabaseUrl = null;

	@Value("${com.picpay.csv.database.filename}")
	private final String csvDatabaseFilename = null;

	private final UserRepository repository;

	private static final Logger logger = Logger.getLogger(DatabaseLoader.class.getName());

	@Autowired
	public DatabaseLoader(UserRepository repository) {
		this.repository = repository;
	}

	@Override
	public void run(String... strings) throws Exception {
		InputStream zipFileInputStream = new ClassPathResource(csvDatabaseFilename).getInputStream();
		//InputStream zipFileInputStream = new URL(csvDatabaseUrl).openStream();
		GZIPInputStream is = new GZIPInputStream(zipFileInputStream);
		MappingIterator<User> it = CsvUtil.read(User.class, is);
		while (it.hasNext()) {
			this.repository.save(it.next());
		}
		logger.info("...........>>>>>>>>>>LOAD COMPLETE<<<<<<<<<<<...........");
	}
}
// end::code[]