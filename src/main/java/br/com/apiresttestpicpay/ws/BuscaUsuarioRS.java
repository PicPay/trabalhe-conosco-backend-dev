/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package br.com.apiresttestpicpay.ws;

import br.com.apiresttestpicpay.service.UsersSrv;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import java.math.BigDecimal;
import java.math.RoundingMode;
import javax.inject.Inject;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.UriInfo;
import javax.ws.rs.Produces;
import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.core.MediaType;

/**
 * REST Web Service
 *
 * @author rsilva
 */
@Path("buscaUsuario")
public class BuscaUsuarioRS {

    private static final int PAGE_SIZE = 15;

    @Context
    private UriInfo context;

    @Inject
    private UsersSrv service;
    
    private Gson gson = new GsonBuilder().excludeFieldsWithoutExposeAnnotation().create();

    private static final String JSON_MSG = "{\"Mensagem\": \"Nenhum registro para exibir!\" , \"uso\": \"buscaUsuario/[termo da busca]/[pagina]\" }";
    
    /**
     * Creates a new instance of BuscaUsuarioResource
     */
    public BuscaUsuarioRS() {
    }

    /**
     * Retrieves representation of an instance of
 br.com.apiresttestpicpay.ws.BuscaUsuarioRS
     *
     * @param term
     * @param page
     * @return an instance of java.lang.String
     */
    @GET
    @Path("{term}/{page}")
    @Produces(MediaType.APPLICATION_JSON)
    public String getJson1(@PathParam("term") String term,
            @PathParam("page") int page) {
        int count = service.getUsersCount(term);

        int firstAndPages[] = determineFirstByPage(count, page);

        StringBuilder json = new StringBuilder("");
        if (firstAndPages[0] + 1 > 0) {
            json.append(gson.toJson(service.findUsersEntities(PAGE_SIZE, firstAndPages[0], term)));
            insertHead(json, term, page, firstAndPages[1], count);
        } else {
            json.append(JSON_MSG);
        }

        return json.toString();
    }
    
    @GET
    @Path("{term}")
    @Produces(MediaType.APPLICATION_JSON)
    public String getJson2(@PathParam("term") String term) {
        int count = service.getUsersCount(term);

        int firstAndPages[] = determineFirstByPage(count, 1);

        StringBuilder json = new StringBuilder("");
        if (firstAndPages[0] + 1 > 0) {
            json.append(gson.toJson(service.findUsersEntities(PAGE_SIZE, firstAndPages[0], term)));
            insertHead(json, term, 1, firstAndPages[1], count);
        } else {
            json.append(JSON_MSG);
        }

        return json.toString();
    }
    
    @GET
    @Produces(MediaType.APPLICATION_JSON)
    public String getJson3() {
        int count = service.getUsersCount(null);

        int firstAndPages[] = determineFirstByPage(count, 1);

        StringBuilder json = new StringBuilder("");
        json.append(JSON_MSG);

        return json.toString();
    }

    private int[] determineFirstByPage(int count, int page) {
        BigDecimal bd1 = new BigDecimal(count).setScale(12);
        BigDecimal bd2 = new BigDecimal(PAGE_SIZE).setScale(12);
        
        
        BigDecimal tempPages = bd1.divide(bd2, 12, RoundingMode.HALF_UP);

        int intPages = tempPages.intValue();

        double restPage = tempPages.doubleValue() - intPages;
        if (restPage > 0) {
            intPages++;
        }

        if (intPages < page || page > intPages) {
            return new int[]{-1};
        }

        return new int[]{page * PAGE_SIZE - PAGE_SIZE, intPages};

    }
    
    private void insertHead(StringBuilder json, String search, int page, int numPages, int count) {
        json.insert(0, "{\"term_search\": \"" + search
                    + "\", \"page_size\": " + PAGE_SIZE
                    + ", \"page\": " + page
                    + ", \"total_pages\": " + numPages
                    + ", \"count\": " + count
                    + ", \"items\": ").append("}");
    }

}
