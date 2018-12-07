package com.picpay.service;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.stereotype.Service;

import com.picpay.model.Usuario;
import com.picpay.repository.UsuarioArquivoRepository;
import com.picpay.repository.UsuarioMongoRepository;

@Service
public class ImportadorUsuarioService {

	private UsuarioMongoRepository repositorioMongo;
	private UsuarioArquivoRepository repositorioArquivo;
	
	@Autowired
	public ImportadorUsuarioService(UsuarioMongoRepository repositorioMongo, @Qualifier("import")UsuarioArquivoRepository repositorioArquivo) {
		super();
		this.repositorioMongo = repositorioMongo;
		this.repositorioArquivo = repositorioArquivo;
	}

	public void importar() {
		
		if(!isImportacaoConcluida()) {
		
			long quantidadePaginas = repositorioArquivo.getQuantidadePaginas();
			long i = getPaginalAtualImportacao();
			long offSet = getOffSetImportacao();
			
			for(;i < quantidadePaginas ; i++) {
				List<Usuario> usuarios = repositorioArquivo.recuperaUsuariosNaPaginaNumero(i,offSet);
				repositorioMongo.saveAll(usuarios);
			}
		}
	}
	
	public boolean isImportacaoConcluida() {
		
		long quantidadeJaImportada = repositorioMongo.count();
		long quantidadeUsuariosArquio = repositorioArquivo.getQuantidadeUsuarios();
		return quantidadeJaImportada == quantidadeUsuariosArquio;
	}
	
	public long getPaginalAtualImportacao() {
		
		long quantidadeJaImportada = repositorioMongo.count();
		long pagina = 0;
		
		if(quantidadeJaImportada != 0 )  {
			pagina = (quantidadeJaImportada / repositorioArquivo.getTamanhoPagina()) + 1;
		}
		
		return pagina;
	}
	
	public long getOffSetImportacao() {
		
		long quantidadeJaImportada = repositorioMongo.count();
		
		if(quantidadeJaImportada < repositorioArquivo.getTamanhoPagina())
			return quantidadeJaImportada;
		else if (quantidadeJaImportada % repositorioArquivo.getTamanhoPagina() == 0)
			return 0;
		else {
			return quantidadeJaImportada % repositorioArquivo.getTamanhoPagina();
		}
	}
	
}
