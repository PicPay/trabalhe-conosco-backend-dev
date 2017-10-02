/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package WS;

import Infra.LerArc;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.UriInfo;
import javax.ws.rs.Consumes;
import javax.ws.rs.Produces;
import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.PUT;
import javax.ws.rs.core.MediaType;
import Modelo.Usuario;
import com.google.gson.Gson;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import javax.ws.rs.PathParam;

/**
 * REST Web Service
 *
 * @author johonatan
 */
@Path("Solucao")
public class SolucaoWS {

    @Context
    private UriInfo context;

    /**
     * Creates a new instance of SolucaoWS
     */
    public SolucaoWS() {
    }

    /**
     * Retrieves representation of an instance of WS.SolucaoWS
     * @param csvArquivo
     * @param nome
     * @return an instance of java.lang.String
     * @throws java.io.IOException
     */
    //@GET
    //@Produces(MediaType.TEXT_HTML)
    //public String getJson() {
    //   return "Teste WS";
    //}
    
    //@GET
    //@Produces(MediaType.APPLICATION_JSON)
    //@Path("Usuario/get")
    //public String getUsuario(){
    //    Usuario usuario = new Usuario();
    //    Gson gson = new Gson();
    //    return gson.toJson(usuario);
   // }
    
    @GET
    @Produces(MediaType.APPLICATION_JSON)
    @Path("Usuario/list/{nome}")
    public String listUsuario(@PathParam("nome") String nome) throws IOException{
        
        LerArc lerArc = new LerArc();       
        List<Usuario> list = new ArrayList<Usuario>();
        list = lerArc.listUsuarioOrganizado(nome.replace("%20"," ").trim());
        
        Gson gson = new Gson();
        return gson.toJson(list);
    }

    /**
     * PUT method for updating or creating an instance of SolucaoWS
     * @param content representation for the resource
     */
    @PUT
    @Consumes(MediaType.APPLICATION_JSON)
    public void putJson(String content) {
    }
}
