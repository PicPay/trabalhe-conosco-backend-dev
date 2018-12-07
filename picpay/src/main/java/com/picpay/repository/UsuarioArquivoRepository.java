package com.picpay.repository;

import static com.picpay.utils.ArquivoUtils.*;

import java.io.IOException;
import java.util.Collections;
import java.util.Comparator;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Optional;
import java.util.stream.Collectors;
import java.util.stream.Stream;

import com.picpay.model.RelevanciaBusca;
import com.picpay.model.Usuario;

public class UsuarioArquivoRepository {
	
	
	private String arquivoUsuarios;
	private String tokenSeparator;
	private List<String> arquivosRelevancias;
	private int tamanhoPagina;
	
	private Map<String, RelevanciaBusca> mapaRelevancias;
	private long quantidadeUsuarios;
	
	public UsuarioArquivoRepository(String arquivo, String tokenSeparator, List<String> arquivosRelevancias, 	int tamanhoPagina) {
		
		super();
		this.arquivoUsuarios = arquivo;
		this.tokenSeparator = tokenSeparator;
		this.arquivosRelevancias = arquivosRelevancias;
		this.tamanhoPagina = tamanhoPagina;
		this.mapaRelevancias = new HashMap<>();
		
		prepararImportacao();
	}
	
	private void prepararImportacao()  {
		
		try {
			montarMapaRelevancias(arquivosRelevancias);
			quantidadeUsuarios = qtLinhasDoArquivo(arquivoUsuarios); 
		} catch (IOException e) {
			throw new RuntimeException(" Erro ao preparar a importação dos usurários");
		}
	}
	
	private void montarMapaRelevancias(List<String> arquivosRelevancias) throws IOException {

		for(int i = 0 ; i < arquivosRelevancias.size() ; i++) {
			carregaRelevanciaArquivo(arquivosRelevancias.get(i), new RelevanciaBusca(i+1));
		}
	}

	private void carregaRelevanciaArquivo(String arquivoRelevancia,RelevanciaBusca relevancia) throws IOException {

		try (Stream<String> lines = getStreamLinesDoArquivo(arquivoRelevancia)) {
			lines.forEach(id -> mapaRelevancias.put(id, relevancia));
		} 
	}
	
	public List<Usuario> recuperaUsuariosNaPaginaNumero(long pagina , long offset) {
		
		try (Stream<String> lines = getStreamLinesDoArquivo(arquivoUsuarios)) {
			
			 List<Usuario> collect = lines
				.skip(pagina * tamanhoPagina)	
				.skip(offset)
				.limit(tamanhoPagina)
				.map(l -> l.split(tokenSeparator))
				.map(s -> new Usuario(s[0],s[1],s[2],mapaRelevancias.getOrDefault(s[0],new RelevanciaBusca(0))))
				.collect(Collectors.toList());
			 
			 return Collections.unmodifiableList(collect);
			
		} catch (IOException e) {
			throw new RuntimeException("Erro ao importar usuários");
		} 
	}
	
	public List<Usuario> buscarUusuario(long pagina , long offset) {
		
		try (Stream<String> lines = getStreamLinesDoArquivo(arquivoUsuarios)) {
			
			 List<Usuario> collect = lines
				.skip(pagina * tamanhoPagina)	
				.skip(offset)
				.limit(tamanhoPagina)
				.map(l -> l.split(tokenSeparator))
				.map(s -> new Usuario(s[0],s[1],s[2],mapaRelevancias.getOrDefault(s[0],new RelevanciaBusca(0))))
				.sorted(Comparator.comparing(Usuario::getRelevancia).reversed().thenComparing(Usuario::getNome))
				.collect(Collectors.toList());
			 
			 return Collections.unmodifiableList(collect);
			
		} catch (IOException e) {
			throw new RuntimeException("Erro ao importar usuários");
		} 
	}
	
	public Optional<Usuario> recuperaUsuario(String id) {
		
		try (Stream<String> lines = getStreamLinesDoArquivo(arquivoUsuarios)) {
			
			return lines
				.filter(l -> l.contains(id))
				.map(l -> l.split(tokenSeparator))
				.map(s -> new Usuario(s[0],s[1],s[2],mapaRelevancias.get(s[0])))
				.findFirst();
				
			
		} catch (IOException e) {
			throw new RuntimeException("Erro ao importar usuários");
		} 
	}

	public long getQuantidadeUsuarios() {
		return quantidadeUsuarios;
	}

	public int getTamanhoPagina() {
		return tamanhoPagina;
	}
	
	public long getQuantidadePaginas() {
		
		long quantidadeUsuarios = getQuantidadeUsuarios();
		int tamanhoPagina = getTamanhoPagina();
		
		long qtPaginas = quantidadeUsuarios / tamanhoPagina;
		long restouUtimaPagina = quantidadeUsuarios % tamanhoPagina;
		if(restouUtimaPagina != 0) {
			qtPaginas++;
		}
		return qtPaginas;
	}
}
