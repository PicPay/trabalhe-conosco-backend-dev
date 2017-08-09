/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package controllers;

import javax.ws.rs.GET;
import javax.ws.rs.HeaderParam;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.core.MediaType;

/**
 *
 * @author gustavo
 */
@Path("/search")
public class SearchEngine {

    /**
     * This is a sample web service operation
     */
    @GET
    @Path("/{key-word}")
    @Produces(MediaType.APPLICATION_JSON)
    public Object find(@PathParam("key-word") String keyWord, @HeaderParam("authorization") String authString)  {
        return ;
    }
}
