package buscarUsuarios;

import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;

public class obterDados {
	
	public static void lerArquivo(ArrayList<dadosUsuario> listaUsuarios, String coluna, String texto) throws IOException {
		
		BufferedReader banco = new BufferedReader(new FileReader(
				"C:\\PicPay\\users.csv"));
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
		while ((line = banco.readLine()) != null) {
	        String[] columns = line.split( "," );
	        if (columns[index].contains(texto)) {
	        	dadosUsuario tempDadosUsuario = new dadosUsuario("id", "nome", "username");
		        tempDadosUsuario.setId(columns[0]);
		        tempDadosUsuario.setNome(columns[1]);
		        tempDadosUsuario.setUsername(columns[2]);
		        listaInicial.add( tempDadosUsuario );
	        }	        
        }		
		banco.close();
		
		BufferedReader listaRelevancia1 = new BufferedReader(new FileReader(
				"C:\\PicPay\\lista_relevancia_1.txt"));
		listaPreferencial1 = listar(listaInicial, listaRelevancia1);
		listaRelevancia1.close();
		
		BufferedReader listaRelevancia2 = new BufferedReader(new FileReader(
				"C:\\PicPay\\lista_relevancia_2.txt"));		
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
}
