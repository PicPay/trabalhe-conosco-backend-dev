package com.kklein.business;

import java.io.BufferedReader;
import java.io.FileReader;
import java.util.HashMap;
import java.util.List;

import com.kklein.bean.Relevancia;
import com.kklein.bean.Usuario;
import com.kklein.dao.RelevanciaDao;
import com.kklein.dao.UsuarioDao;

public class UsuarioBusiness extends AbstractBusiness {
    
	public String listarUsuariosPagina(String palavra, int pagina) {

		StringBuilder retorno = new StringBuilder();
		
		List<Object[]> usuarios = null;
		try {
			UsuarioDao usuarioDao = new UsuarioDao(getEntityManager());
			usuarios = usuarioDao.consultaListaUsuario(palavra, pagina);

			if(null == usuarios)
				return null;
			
			retorno.append("{\"employees\":[");
			
			for (Object[] usuario : usuarios) {
				retorno.append(("{\"employees\":[".equals(retorno.toString())?"":",") + "{\"nome\": \"" + usuario[UsuarioDao.USU_NM_USUARIO] + 
																						"\",\"login\":\"" + usuario[UsuarioDao.USU_DS_LOGIN] + 
																						"\", \"id\":\"" + usuario[UsuarioDao.USU_DS_CODIGO] +
																						"\", \"qtde_registros\":\"" +usuario[UsuarioDao.QUANTIDADE_REGISTROS] + "\"}");
			}
			
			retorno.append("]}");
			
		} catch (Exception e) {
			e.printStackTrace();
		}
			
		return retorno.toString();
	}


	public Usuario criarUsuario(Usuario usuario) {
		
		Usuario novoUsuario = null;
		
		try {
			beginTransaction();
			UsuarioDao usuarioDao = new UsuarioDao(getEntityManager());
			novoUsuario = usuarioDao.incluir(usuario);
			entityTransaction.commit();
		} catch (Exception e) {
			e.printStackTrace();
		}
		return novoUsuario;
	}

	public Usuario consultarUsuario(int idUsuario) {

		Usuario usuario = null;
		try {
			UsuarioDao usuarioDao = new UsuarioDao(getEntityManager());
			usuario = usuarioDao.read(idUsuario);

		} catch (Exception e) {
			e.printStackTrace();
		}
		return usuario;
	}

	public Usuario alterarUsuario(Usuario usuario) {

		try {		
			beginTransaction();
			UsuarioDao usuarioDao = new UsuarioDao(getEntityManager());
			usuario = usuarioDao.alterar(usuario);
			entityTransaction.commit();
		} catch (Exception e) {
			e.printStackTrace();
		}
		return usuario;
	}

	public void excluirUsuario(int idUsuario) {		
		try {
			Usuario usuario = consultarUsuario(idUsuario);
			excluirUsuario(usuario);			
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
		
	public void excluirUsuario(Usuario usuario) {
		try {
			beginTransaction();
			UsuarioDao usuarioDao = new UsuarioDao(getEntityManager());
			usuarioDao.excluir(usuario);
			entityTransaction.commit();
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
	
	
	public String carregarTabelaUsuario(String caminho_arquivo) {
		
		try {
			
			BufferedReader CSV = new BufferedReader(new FileReader(caminho_arquivo)); 
			
			RelevanciaBusiness relevanciaBusiness = new RelevanciaBusiness(); 
			RelevanciaDao relevanciaDao = new RelevanciaDao(getEntityManager()); 
			HashMap<String,Integer> lista_relevancia = relevanciaBusiness.listaRelevanciaMap((List<Relevancia>) relevanciaDao.consultaListaRelevancia(0));
			
			String linhaCsv = CSV.readLine();
			
			beginTransaction();
			UsuarioDao usuarioDao = new UsuarioDao(getEntityManager());
			int count = 0;
			while (null != linhaCsv) {
				
				String[] colunas = linhaCsv.split(",");
				
				if(colunas.length == 3)
				{
					beginTransaction();
					Usuario usuario = new Usuario();
					usuario.setUsuDsCodigo(colunas[0]);
					usuario.setUsuNmUsuario(colunas[1]);
					usuario.setUsuDsLogin(colunas[2]);
					if(lista_relevancia.containsKey(colunas[0]))					
						usuario.setUsuFlListaPrioridade(lista_relevancia.get(colunas[0]));
					else
						usuario.setUsuFlListaPrioridade(3);
									
					usuarioDao.incluir(usuario);					
					count++;
				}
				
				if(count > 25000) {
					entityTransaction.commit();
					count = 0;
				}
				
				linhaCsv = CSV.readLine();
			}
			
			entityTransaction.commit();
			
			return "Carga concluida com sucesso!";
		} catch (Exception e) {
			return e.toString();
		}
		
	}

}
