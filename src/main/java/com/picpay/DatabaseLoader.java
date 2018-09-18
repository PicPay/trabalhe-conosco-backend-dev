package com.picpay;

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
import java.util.List;
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

	@Autowired
	public DatabaseLoader(UserRepository repository) {
		this.repository = repository;
	}

	@Override
	public void run(String... strings) throws Exception {
		InputStream zipFileInputStream = new ClassPathResource(csvDatabaseFilename).getInputStream();
		//InputStream zipFileInputStream = new URL(csvDatabaseUrl).openStream();
		GZIPInputStream is = new GZIPInputStream(zipFileInputStream);
		List<User> users = CsvUtil.read(User.class, is);
		this.repository.save(users);
	}
}
// end::code[]