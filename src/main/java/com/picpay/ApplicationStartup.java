package com.picpay;

import com.picpay.repositories.UserRepository;
import org.apache.tomcat.util.http.fileupload.IOUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.boot.CommandLineRunner;
import org.springframework.stereotype.Component;

import java.io.*;
import java.net.URL;
import java.nio.file.StandardCopyOption;
import java.util.List;
import java.util.zip.GZIPInputStream;

/**
 * @author Bruno Carreira
 */
// tag::code[]
@Component
public class ApplicationStartup implements CommandLineRunner {

	@Value("${com.picpay.csv.database.url}")
	private final String csvDatabaseUrl = null;

	@Value("${com.picpay.csv.database.filename}")
	private final String csvDatabaseFilename = null;

    @Autowired
    private List<String> listRelevancia1;

    @Autowired
    private List<String> listRelevancia2;

    @Autowired
    private UserRepository repo;

	private static final Logger LOG =
			LoggerFactory.getLogger(ApplicationStartup.class);

	@Override
	public void run(String... strings) throws Exception {
		System.out.println("Creating File.....");
		LOG.info("Creating File....");
		/*
		InputStream zipFileInputStream = new URL(csvDatabaseUrl).openStream();
		GZIPInputStream is = new GZIPInputStream(zipFileInputStream);

		File targetFile = new File("src/main/resources/userstest.csv");

		java.nio.file.Files.copy(
				is,
				targetFile.toPath(),
				StandardCopyOption.REPLACE_EXISTING);
*/
		//IOUtils.closeQuietly(is);
        repo.updatePriorityByIds(listRelevancia1, 1);
        repo.updatePriorityByIds(listRelevancia2, 2);
		System.out.println("File is created!");
		LOG.info("File is created!");
	}

}
// end::code[]