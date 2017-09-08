package com.tmontovaneli.challenge;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.io.IOException;
import java.io.OutputStream;
import java.io.StringReader;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;
import java.util.zip.GZIPInputStream;

import org.apache.commons.io.FileUtils;
import org.apache.commons.io.IOUtils;
import org.bson.Document;

import com.fasterxml.jackson.databind.ObjectMapper;
import com.tmontovaneli.challenge.model.User;
import com.tmontovaneli.challenge.mongodb.MongoConfigurationDAO;

import net.sf.jsefa.Deserializer;
import net.sf.jsefa.csv.CsvIOFactory;
import net.sf.jsefa.csv.config.CsvConfiguration;

public class InitializerDatabase {

	private ClassLoader classLoader;
	private MongoConfigurationDAO dataBase;
	private CsvConfiguration csvConfiguration;
	private ObjectMapper mapper;

	public enum Relevancia {
		PRIMEIRA, SEGUNDA
	};

	public InitializerDatabase() {
		super();

		csvConfiguration = new CsvConfiguration();
		csvConfiguration.setFieldDelimiter(',');

		mapper = new ObjectMapper();
		classLoader = this.getClass().getClassLoader();
	}

	public void init() throws Exception {
		dataBase = new MongoConfigurationDAO();
		try {

			System.out.println("Carregando usuários...");
			loadUsers();
			System.out.println("Carregando usuários...OK");

			System.out.println("Carregando primeira lista de relevância...");
			loadRelevancia(Relevancia.PRIMEIRA);
			System.out.println("Carregando primeira lista de relevância...OK");

			System.out.println("Carregando segunda lista de relevância...");
			loadRelevancia(Relevancia.SEGUNDA);
			System.out.println("Carregando segunda lista de relevância...OK");

		} finally {
			dataBase.close();
		}
	}

	private void loadRelevancia(Relevancia relevancia) throws Exception {
		String nmFile = "relevancia_1.txt";
		if (relevancia == Relevancia.SEGUNDA)
			nmFile = "relevancia_2.txt";

		File file = new File(classLoader.getResource(nmFile).getFile());
		BufferedReader br = null;
		try {

			br = getBufferedReader(file);

			String linha = null;

			int count = 1;

			List<Document> novos = new ArrayList<Document>();

			String json = "{ \"_id\": \"%s\" }";

			while ((linha = br.readLine()) != null) {

				novos.add(mapper.readValue(String.format(json, linha), Document.class));

				if (count++ % 1000 == 0) {
					if (relevancia == Relevancia.PRIMEIRA)
						dataBase.insertPrimeiraRelevancia(novos);
					else
						dataBase.insertSegundaRelevancia(novos);

					novos.clear();
				}

			}

			if (relevancia == Relevancia.PRIMEIRA)
				dataBase.insertPrimeiraRelevancia(novos);
			else
				dataBase.insertSegundaRelevancia(novos);

		} catch (Exception e) {
			e.printStackTrace();
			throw new Exception("Erro ao configurar primeira lista de relevância", e);
		} finally {
			if (br != null)
				try {
					br.close();
				} catch (IOException e) {
					e.printStackTrace();
				}

		}
	}

	private BufferedReader getBufferedReader(File file) throws FileNotFoundException {

		return new BufferedReader(new FileReader(file));

	}

	private void loadUsers() throws Exception {

		File compressedFile = File.createTempFile("user", "gz");
		File file = File.createTempFile("users", "csv");

		System.out.println("Baixando arquivo...");
		FileUtils.copyURLToFile(new URL("https://s3.amazonaws.com/careers-picpay/users.csv.gz"), compressedFile);
		System.out.println("Baixando arquivo...OK");

		System.out.println("Descompactando...");
		decompress(compressedFile, file);
		System.out.println("Descompactando...OK");

		BufferedReader br = null;

		try {
			br = getBufferedReader(file);

			Deserializer deserializer = CsvIOFactory.createFactory(csvConfiguration, User.class).createDeserializer();

			String linha = null;

			int count = 1;

			List<Document> novos = new ArrayList<Document>();

			while ((linha = br.readLine()) != null) {

				StringReader reader = new StringReader(linha);
				deserializer.open(reader);
				while (deserializer.hasNext()) {
					User user = deserializer.next();

					String json = mapper.writeValueAsString(user);

					novos.add(mapper.readValue(json, Document.class));

					if (count++ % 1000 == 0) {
						dataBase.insertUsers(novos);
						novos.clear();
					}
				}
			}

			if (!novos.isEmpty())
				dataBase.insertUsers(novos);

			System.out.println("Criando indexes...");
			dataBase.createIndexes();
			System.out.println("Criando indexes...OK");

			deserializer.close(true);

		} catch (Exception e) {
			e.printStackTrace();
			throw new Exception("Erro ao configurar banco de dados", e);
		} finally {
			if (br != null)
				try {
					br.close();
				} catch (IOException e) {
					e.printStackTrace();
				}

		}
	}

	private void decompress(File compressedFile, File file) throws FileNotFoundException, IOException {

		GZIPInputStream gzis = new GZIPInputStream(new BufferedInputStream(new FileInputStream(compressedFile)));
		OutputStream os = new BufferedOutputStream(new FileOutputStream(file));

		IOUtils.copy(gzis, os);

	}

}
