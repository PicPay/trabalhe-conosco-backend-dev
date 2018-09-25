package com.picpay;

import com.fasterxml.jackson.databind.MappingIterator;
import com.fasterxml.jackson.databind.ObjectReader;
import com.fasterxml.jackson.dataformat.csv.CsvMapper;
import com.fasterxml.jackson.dataformat.csv.CsvSchema;
import com.picpay.model.User;
import com.picpay.repositories.UserRepository;
import com.picpay.util.CsvUtil;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.boot.CommandLineRunner;
import org.springframework.core.io.ClassPathResource;
import org.springframework.stereotype.Component;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.URL;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.List;
import java.util.stream.Stream;
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
		Stream<String> lines = new BufferedReader(new InputStreamReader(is)).lines();
		//repository.bulkLoad();
/*
		final CsvMapper mapper = new CsvMapper();
		CsvSchema schema = mapper.schemaFor(User.class).withColumnReordering(true);
		ObjectReader reader = mapper.readerFor(User.class).with(schema);

		for( String line : (Iterable<String>) lines::iterator )
		{
			System.out.println(line);
			User user = reader.readValue(line);
			repository.save(user);
		}
		*/
	}
}
// end::code[]