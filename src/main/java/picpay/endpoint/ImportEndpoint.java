package picpay.endpoint;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.URL;
import java.util.zip.GZIPInputStream;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import picpay.model.Prior1;
import picpay.model.Prior2;
import picpay.model.User;
import picpay.repositories.Prior1Repository;
import picpay.repositories.Prior2Repository;
import picpay.repositories.UserRepository;

@RestController
@RequestMapping("import")
public class ImportEndpoint {
	private final UserRepository userRepository;
	private final Prior1Repository prior1Repository;
	private final Prior2Repository prior2Repositiry;

	private static boolean importing;
	
	@Autowired
	public ImportEndpoint(UserRepository userRepository, Prior1Repository prior1Repository, Prior2Repository prior2Repositiry) {
		this.userRepository = userRepository;
		this.prior1Repository = prior1Repository;
		this.prior2Repositiry = prior2Repositiry;
	}

	//Este método pode ser muito melhorado, mas como é apenas para algo simples. Deixarei assim por enquanto.
	@PostMapping
	public ResponseEntity<?> importFile() {
		String msg = null;

		if (importing) {
			msg = "Uma importação já foi iniciada com sucesso. Aguarde um momento para que os dados estejam disponíveis.";
		} else {
			importing = true;

			if (userRepository.count() > 0) {
				msg = "O banco precisa estar vazio para a realização da importação.";
			} else {
				this.importPrior1FromFile();
				System.out.println("Importou lista relevância 1.");
				this.importPrior2FromFile();
				System.out.println("Importou lista relevância 2.");
				this.importUserFromFile();
				System.out.println("Importou lista de usuários.");
			}

			importing = false;
		}

		return new ResponseEntity<>(msg, HttpStatus.OK);
	}

	//Transformar os 3 imports para um método genérico.
	private void importUserFromFile() {
		BufferedReader reader = null;
		GZIPInputStream gzip = null;
		String line = null;

		try {
			URL url = new URL("https://s3.amazonaws.com/careers-picpay/users.csv.gz");
			
			gzip = new GZIPInputStream(url.openStream());
			reader = new BufferedReader(new InputStreamReader(gzip));
			
			while ((line = reader.readLine()) != null) {
				System.out.println("---->" + line);
				
				User user = new User();

				String[] vet = line.split(",");
				user.setId(vet[0]);
				if (vet.length > 1) {
					user.setName(vet[1]);
				}
				if (vet.length > 2) {
					user.setUsername(vet[2]);
				}

				userRepository.save(user);
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			if (reader != null) {
				try {
					reader.close();
				} catch (IOException e) {
					e.printStackTrace();
				}
			}
		}
	}

	private void importPrior1FromFile() {
		BufferedReader reader = null;

		try {
			URL url = new URL("https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_1.txt");
	
			reader = new BufferedReader(new InputStreamReader(url.openStream()));
	
			String line;
			while ((line = reader.readLine()) != null) {
				Prior1 p1 = new Prior1();
				p1.setId(line);

				prior1Repository.save(p1);
			}
		} catch (IOException e) {
			e.printStackTrace();
		} finally {
			if (reader != null) {
				try {
					reader.close();
				} catch (IOException e) {
					e.printStackTrace();
				}
			}
		}
	}

	private void importPrior2FromFile() {
		BufferedReader reader = null;

		try {
			URL url = new URL("https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_2.txt");
	
			reader = new BufferedReader(new InputStreamReader(url.openStream()));
	
			String line;
			while ((line = reader.readLine()) != null) {
				Prior2 p2 = new Prior2();
				p2.setId(line);

				prior2Repositiry.save(p2);
			}
		} catch (IOException e) {
			e.printStackTrace();
		} finally {
			if (reader != null) {
				try {
					reader.close();
				} catch (IOException e) {
					e.printStackTrace();
				}
			}
		}
	}
}
