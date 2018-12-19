package br.com.picpay.picpay_api.web.controller;

import static org.assertj.core.api.Assertions.assertThat;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.InputStreamReader;
import java.net.URL;
import java.util.zip.GZIPInputStream;

import org.apache.commons.io.FileUtils;
import org.junit.Test;

import br.com.picpay.picpay_api.entity.User;

public class PicpayDownloadData {

	private static final String USERS_CSV = "https://s3.amazonaws.com/careers-picpay/users.csv.gz";

	@Test
	public void should_download_all_data() throws Exception {
		File csv = new File("users.csv");
		FileUtils.copyURLToFile(new URL(USERS_CSV), csv);
		assertThat(csv.length()).isNotZero();
	}
	
	@Test
	public void should_create_user() throws Exception {
		File csv = new File("users.csv");
		FileUtils.copyURLToFile(new URL(USERS_CSV), csv);
		
		try (BufferedReader br = new BufferedReader(new InputStreamReader(new GZIPInputStream(new FileInputStream(csv))))) {
			String line;
			while ((line = br.readLine()) != null) {
				String[] vetor = line.split("\\,");
				User user = User.builder().hash(vetor[0]).name(vetor[1]).username(vetor[2]).build();
				assertThat(user).isNotNull();
			}
		}
	}
}
