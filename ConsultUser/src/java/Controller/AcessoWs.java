/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controller;

import Infra.Http;
import Modelo.Usuario;
import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import java.util.ArrayList;
import java.util.List;

/**
 *
 * @author johonatan
 */
public class AcessoWs {
    
    
     public List<Usuario> retornaPesquisaUserWs(String nome) throws Exception {

        Http http = new Http();
        
        String chamadaWs = ("http://localhost:8080/SolucaoRest/webresources/Solucao/Usuario/list/" + nome);
        List<Usuario> listUser = new ArrayList<Usuario>();
        
        String json = http.sendGet(chamadaWs);
        
        Gson gson = new Gson();

        java.lang.reflect.Type listUserType = new TypeToken<List<Usuario>>() {
        }.getType();

        listUser.addAll(gson.fromJson(json, listUserType));
        
        return listUser;

    }
    
}
