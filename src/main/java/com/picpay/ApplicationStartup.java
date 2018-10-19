package com.picpay;

import com.picpay.repositories.UserRepository;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.CommandLineRunner;
import org.springframework.stereotype.Component;

import java.util.List;


/**
 * @author Bruno Carreira
 */
// tag::code[]
@Component
public class ApplicationStartup implements CommandLineRunner {
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