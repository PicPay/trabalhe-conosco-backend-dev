package com.picpay;

import static org.hamcrest.CoreMatchers.equalTo;
import static org.junit.Assert.assertThat;
import static org.mockito.Mockito.when;

import org.junit.Before;
import org.junit.Test;
import org.mockito.Mock;
import org.mockito.MockitoAnnotations;

import com.picpay.repository.UsuarioArquivoRepository;
import com.picpay.repository.UsuarioMongoRepository;
import com.picpay.service.ImportadorUsuarioService;

public class ImportacaoTest {

	@Mock
	private UsuarioMongoRepository repositorioMongo;
	
	@Mock
	private UsuarioArquivoRepository repositorioArquivo;
	
	private ImportadorUsuarioService importadorUsuarioService;
	
	@Before
	public void setUp() {
		MockitoAnnotations.initMocks(this);
		importadorUsuarioService = new ImportadorUsuarioService(repositorioMongo, repositorioArquivo);
	}
	
	@Test
	public void teste_inicio_importacao() {
		
		when(repositorioArquivo.getTamanhoPagina()).thenReturn(20);
		when(repositorioArquivo.getQuantidadeUsuarios()).thenReturn(100l);
		when(repositorioMongo.count()).thenReturn(0l);
		when(repositorioArquivo.getQuantidadePaginas()).thenCallRealMethod();
		
		assertThat(importadorUsuarioService.isImportacaoConcluida(), equalTo(false));
		assertThat(importadorUsuarioService.getOffSetImportacao(), equalTo(0l));
		assertThat(importadorUsuarioService.getPaginalAtualImportacao(), equalTo(0l));
	}
	
	@Test
	public void teste_mesmaPagina_comOffset_10() {
		
		when(repositorioArquivo.getTamanhoPagina()).thenReturn(20);
		when(repositorioArquivo.getQuantidadeUsuarios()).thenReturn(100l);
		when(repositorioMongo.count()).thenReturn(10l);
		when(repositorioArquivo.getQuantidadePaginas()).thenCallRealMethod();
		
		assertThat(importadorUsuarioService.isImportacaoConcluida(), equalTo(false));
		assertThat(importadorUsuarioService.getOffSetImportacao(), equalTo(10l));
		assertThat(importadorUsuarioService.getPaginalAtualImportacao(), equalTo(1l));
	}
	
	@Test
	public void teste_mesmaPagina_comOffset_19() {
		
		when(repositorioArquivo.getTamanhoPagina()).thenReturn(20);
		when(repositorioArquivo.getQuantidadeUsuarios()).thenReturn(100l);
		when(repositorioMongo.count()).thenReturn(19l);
		when(repositorioArquivo.getQuantidadePaginas()).thenCallRealMethod();
		
		assertThat(importadorUsuarioService.isImportacaoConcluida(), equalTo(false));
		assertThat(importadorUsuarioService.getOffSetImportacao(), equalTo(19l));
		assertThat(importadorUsuarioService.getPaginalAtualImportacao(), equalTo(1l));
	}
	
	@Test
	public void teste_proxima__pagina_semOffset() {
		
		when(repositorioArquivo.getTamanhoPagina()).thenReturn(20);
		when(repositorioArquivo.getQuantidadeUsuarios()).thenReturn(100l);
		when(repositorioMongo.count()).thenReturn(20l);
		when(repositorioArquivo.getQuantidadePaginas()).thenCallRealMethod();
		
		assertThat(importadorUsuarioService.isImportacaoConcluida(), equalTo(false));
		assertThat(importadorUsuarioService.getOffSetImportacao(), equalTo(0l));
		assertThat(importadorUsuarioService.getPaginalAtualImportacao(), equalTo(2l));
	}
	
	@Test
	public void teste_proxima__pagina_comOffset_10() {
		
		when(repositorioArquivo.getTamanhoPagina()).thenReturn(20);
		when(repositorioArquivo.getQuantidadeUsuarios()).thenReturn(100l);
		when(repositorioMongo.count()).thenReturn(30l);
		when(repositorioArquivo.getQuantidadePaginas()).thenCallRealMethod();
		
		assertThat(importadorUsuarioService.isImportacaoConcluida(), equalTo(false));
		assertThat(importadorUsuarioService.getOffSetImportacao(), equalTo(10l));
		assertThat(importadorUsuarioService.getPaginalAtualImportacao(), equalTo(2l));
	}
	
	@Test
	public void teste_importacao_finalizada() {
		
		when(repositorioArquivo.getTamanhoPagina()).thenReturn(20);
		when(repositorioArquivo.getQuantidadeUsuarios()).thenReturn(100l);
		when(repositorioMongo.count()).thenReturn(100l);
		when(repositorioArquivo.getQuantidadePaginas()).thenCallRealMethod();
		
		assertThat(importadorUsuarioService.isImportacaoConcluida(), equalTo(true));
		assertThat(importadorUsuarioService.getOffSetImportacao(), equalTo(0l));
	}
	
}
