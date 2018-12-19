package buscarUsuarios;

import com.opencsv.CSVReader;

import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;

//import static java.lang.System.nanoTime;

public class obterDados {

	private static String CSV_PATH = "C:\\PicPay\\users.csv";
	private static String Lista1_PATH = "C:\\PicPay\\lista_relevancia_1.txt";
	private static String Lista2_PATH = "C:\\PicPay\\lista_relevancia_2.txt";

	public static void lerArquivo(ArrayList<dadosUsuario> listaUsuarios, String coluna, String texto) throws IOException {

		BufferedReader banco = new BufferedReader(new FileReader(CSV_PATH));
		ArrayList<dadosUsuario> listaInicial = new ArrayList<dadosUsuario>();
		ArrayList<dadosUsuario> listaPreferencial1 = new ArrayList<dadosUsuario>();
		ArrayList<dadosUsuario> listaPreferencial2 = new ArrayList<dadosUsuario>();
		String line = null;
		int index;
		if (coluna.equals("nome")) {
			index = 1;
		} else {
			index = 2;
		}
//		long time1 = nanoTime();
		while ((line = banco.readLine()) != null) {
			String[] columns = line.split(",");
			if (columns[index].contains(texto)) {
				criaUsuario(listaInicial, columns);
			}
		}
		banco.close();
//		long time2 = nanoTime();
//		System.out.print("\nReader: " + (time2 - time1));

		BufferedReader listaRelevancia1 = new BufferedReader(new FileReader(Lista1_PATH));
		listaPreferencial1 = listar(listaInicial, listaRelevancia1);
		listaRelevancia1.close();

		BufferedReader listaRelevancia2 = new BufferedReader(new FileReader(Lista2_PATH));
		listaPreferencial2 = listar(listaInicial, listaRelevancia2);
		listaRelevancia2.close();

		listaUsuarios.addAll(listaPreferencial1);
		listaUsuarios.addAll(listaPreferencial2);
		listaUsuarios.addAll(listaInicial);
	}

	private static ArrayList<dadosUsuario> listar (ArrayList<dadosUsuario> listaInicial, BufferedReader lista) throws IOException {
		ArrayList<dadosUsuario> listaPreferencial = new ArrayList<dadosUsuario>();
		String line = null;

		while ((line = lista.readLine()) != null) {
			for (dadosUsuario temp : listaInicial) {
				if (line.contains(temp.getId())) {
					listaPreferencial.add(temp);
					listaInicial.remove(temp);
					break;
				}
			}
		}
		return listaPreferencial;
	}

	public static void lerArquivoOpenCV(ArrayList<dadosUsuario> listaUsuarios, String coluna, String texto) throws IOException {

		ArrayList<dadosUsuario> listaInicial = new ArrayList<dadosUsuario>();
		ArrayList<dadosUsuario> listaPreferencial1 = new ArrayList<dadosUsuario>();
		ArrayList<dadosUsuario> listaPreferencial2 = new ArrayList<dadosUsuario>();
		int index;
		if (coluna.equals("nome")) {
			index = 1;
		} else {
			index = 2;
		}

		try {
			FileReader csvFileReader = new FileReader(CSV_PATH);
			CSVReader csvReader = new CSVReader(csvFileReader);
			String[] nextRecord;
//			long time1 = nanoTime();
			while ((nextRecord = csvReader.readNext()) != null) {
				if (nextRecord[index].contains(texto)) {
					criaUsuario(listaInicial, nextRecord);
				}
			}
//			long time2 = nanoTime();
//			System.out.print("\nOpenCV: " + (time2 - time1));
		}
		catch (Exception e) {
			e.printStackTrace();
		}

		BufferedReader listaRelevancia1 = new BufferedReader(new FileReader(Lista1_PATH));
		listaPreferencial1 = listar(listaInicial, listaRelevancia1);
		listaRelevancia1.close();

		BufferedReader listaRelevancia2 = new BufferedReader(new FileReader(Lista2_PATH));
		listaPreferencial2 = listar(listaInicial, listaRelevancia2);
		listaRelevancia2.close();

		listaUsuarios.addAll(listaPreferencial1);
		listaUsuarios.addAll(listaPreferencial2);
		listaUsuarios.addAll(listaInicial);
	}

	private static void criaUsuario (ArrayList<dadosUsuario> lista, String[] dados) {
		dadosUsuario tempDadosUsuario = new dadosUsuario("id", "nome", "username");
		tempDadosUsuario.setId(dados[0]);
		tempDadosUsuario.setNome(dados[1]);
		tempDadosUsuario.setUsername(dados[2]);
		lista.add( tempDadosUsuario );
	}
}
