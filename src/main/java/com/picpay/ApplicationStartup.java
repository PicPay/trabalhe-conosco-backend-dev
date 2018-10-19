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
		LOG.info("Updating priority....");
        repo.updatePriorityByIds(listRelevancia1, 1);
        repo.updatePriorityByIds(listRelevancia2, 2);
		LOG.info("Priority updated!");
	}

}
// end::code[]