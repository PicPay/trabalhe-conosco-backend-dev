package buscarUsuarios;

import java.io.IOException;
import java.util.ArrayList;

import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

//import static java.lang.System.*;

@RestController
public class obterDadosController {

    @RequestMapping("/buscarNome")
    public ArrayList<dadosUsuario> nomeUsuario(@RequestParam(value="nome", defaultValue="nome") String nome) throws IOException {
        ArrayList<dadosUsuario> listaUsuarios = new ArrayList<dadosUsuario>();
//    	long time1 = nanoTime();
//        obterDados.lerArquivoOpenCV(listaUsuarios, "nome", nome);
//        long time2 = nanoTime();
        obterDados.lerArquivo(listaUsuarios, "nome", nome);
//        long time3 = nanoTime();
//        System.out.print("\nOpenCV: " + (time2 - time1));
//        System.out.print("\nNormal: " + (time3 - time2));
        return listaUsuarios;
    }

    @RequestMapping("/buscarUsername")
    public ArrayList<dadosUsuario> username(@RequestParam(value="username", defaultValue="username") String username) throws IOException {
        ArrayList<dadosUsuario> listaUsuarios = new ArrayList<dadosUsuario>();
        obterDados.lerArquivo(listaUsuarios, "username", username);
        return listaUsuarios;
    }

}
