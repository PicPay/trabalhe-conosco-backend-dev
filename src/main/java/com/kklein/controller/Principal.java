package com.kklein.controller;

import java.sql.SQLException;

import javax.ws.rs.DELETE;
import javax.ws.rs.GET;
import javax.ws.rs.POST;
import javax.ws.rs.PUT;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;
import javax.ws.rs.core.Response.Status;

import com.kklein.bean.Usuario;
import com.kklein.business.UsuarioBusiness;

@Path("/")
public class Principal {
	
	@GET
    @Path("/carga")
	@Produces(MediaType.TEXT_HTML)
	public String carregar(@QueryParam("arquivo") String caminho_arquivo){
		
		UsuarioBusiness usuarioBusiness = new UsuarioBusiness();
		return usuarioBusiness.carregarTabelaUsuario(caminho_arquivo);
	}
	

	
	
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	public String getUsuario(@QueryParam("palavra") String palavra, @QueryParam("pagina") int pagina) throws SQLException, InstantiationException, IllegalAccessException, ClassNotFoundException {
		UsuarioBusiness usuarioBusiness = new UsuarioBusiness();
		return usuarioBusiness.listarUsuariosPagina(palavra, pagina);
	}

	
	
	@POST    
    @Produces(MediaType.TEXT_HTML)
    public Response novoUsuario(@QueryParam("usuDsCodigo") String usuDsCodigo,
    							@QueryParam("usuDsLogin") String usuDsLogin,
    							@QueryParam("usuNmUsuario") String usuNmUsuario) throws SQLException, InstantiationException, IllegalAccessException, ClassNotFoundException {
		
		UsuarioBusiness usuarioBusiness = new UsuarioBusiness();
    	Usuario usuario = new Usuario();
    	usuario.setUsuDsCodigo(usuDsCodigo);
    	usuario.setUsuDsLogin(usuDsLogin);
    	usuario.setUsuNmUsuario(usuNmUsuario);
    	
    	usuarioBusiness.criarUsuario(usuario);          
        return Response.status(Status.OK).build();
    }


    @PUT
    public Response atualizarUsuario(Usuario usuario) throws SQLException, InstantiationException, IllegalAccessException, ClassNotFoundException {
    	UsuarioBusiness usuarioBusiness = new UsuarioBusiness();
    	usuarioBusiness.criarUsuario(usuario);
        return Response.status(Status.OK).build();
    }

    @DELETE
    public Response excluirUsuario(@QueryParam("id") int idUsuario) throws SQLException, InstantiationException, IllegalAccessException, ClassNotFoundException {
    	UsuarioBusiness usuarioBusiness = new UsuarioBusiness();
    	usuarioBusiness.excluirUsuario(idUsuario);
    	return Response.status(Status.OK).build();
    }

}
