package br.com.picpay.picpay_api.service;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.InputStreamReader;
import java.net.URL;
import java.util.zip.GZIPInputStream;

import javax.transaction.Transactional;

import org.apache.commons.io.FileUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import br.com.picpay.picpay_api.entity.User;
import lombok.extern.slf4j.Slf4j;

@Service
@Transactional
@Slf4j
public class DataService {

	private static final String USERS_CSV = "https://s3.amazonaws.com/careers-picpay/users.csv.gz";

    private final UserService userService;

    @Autowired
    public DataService(UserService userService) {
        this.userService = userService;
    }

	public void loadAllData() {
		try {		
			int tam = 0;
			File csv = new File("users.csv");
			if(!csv.exists())
				FileUtils.copyURLToFile(new URL(USERS_CSV), csv);
			User user = null;
			try (BufferedReader br = new BufferedReader(new InputStreamReader(new GZIPInputStream(new FileInputStream(csv))))) {
				String line;
				while ((line = br.readLine()) != null) {
					tam += 1; 
					if( tam > 1000) { 
						log.info("Fim");
						return;
					}
					String[] vetor = line.split("\\,");
					user = User.builder().hash(vetor[0]).name(vetor[1]).username(vetor[2]).build();
					user = userService.createUser(user);
				}
			}
		} catch (Exception e) {
			log.error("Erro ao baixar conteudo", e);
		}
    }
}
