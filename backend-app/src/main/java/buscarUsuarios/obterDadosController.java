package buscarUsuarios;

import java.io.IOException;
import java.util.ArrayList;

import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

@RestController
public class obterDadosController {
    
    @RequestMapping("/buscarNome")
    public ArrayList<dadosUsuario> nomeUsuario(@RequestParam(value="nome", defaultValue="nome") String nome) throws IOException {
    	ArrayList<dadosUsuario> listaUsuarios = new ArrayList<dadosUsuario>();
    	obterDados.lerArquivo(listaUsuarios, "nome", nome);   	
        return listaUsuarios;
    }
    
    @RequestMapping("/buscarUsername")
    public ArrayList<dadosUsuario> username(@RequestParam(value="username", defaultValue="username") String username) throws IOException {
    	ArrayList<dadosUsuario> listaUsuarios = new ArrayList<dadosUsuario>();
    	obterDados.lerArquivo(listaUsuarios, "username", username);
        return listaUsuarios;
    }

}
