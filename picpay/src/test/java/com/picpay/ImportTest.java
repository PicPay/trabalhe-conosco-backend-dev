package com.picpay;

import static org.hamcrest.CoreMatchers.equalTo;
import static org.junit.Assert.assertThat;
import static org.mockito.Mockito.when;

import org.junit.Before;
import org.junit.Test;
import org.mockito.Mock;
import org.mockito.MockitoAnnotations;

import com.picpay.repository.UserFileRepository;
import com.picpay.repository.UserMongoRepository;
import com.picpay.service.ImporterUserService;

public class ImportTest {

	@Mock
	private UserMongoRepository repositorioMongo;
	
	@Mock
	private UserFileRepository repositorioArquivo;
	
	private ImporterUserService importadorUsuarioService;
	
	@Before
	public void setUp() {
		MockitoAnnotations.initMocks(this);
		importadorUsuarioService = new ImporterUserService(repositorioMongo, repositorioArquivo);
	}
	
	@Test
	public void teste_inicio_importacao() {
		
		when(repositorioArquivo.getPageSize()).thenReturn(20);
		when(repositorioArquivo.getAmountUsers()).thenReturn(100l);
		when(repositorioMongo.count()).thenReturn(0l);
		when(repositorioArquivo.getAmountOfPages()).thenCallRealMethod();
		
		assertThat(importadorUsuarioService.isImportCompleted(), equalTo(false));
		assertThat(importadorUsuarioService.getOffSetImport(), equalTo(0l));
		assertThat(importadorUsuarioService.getPageCurrentImport(), equalTo(0l));
	}
	
	@Test
	public void teste_mesmaPagina_comOffset_10() {
		
		when(repositorioArquivo.getPageSize()).thenReturn(20);
		when(repositorioArquivo.getAmountUsers()).thenReturn(100l);
		when(repositorioMongo.count()).thenReturn(10l);
		when(repositorioArquivo.getAmountOfPages()).thenCallRealMethod();
		
		assertThat(importadorUsuarioService.isImportCompleted(), equalTo(false));
		assertThat(importadorUsuarioService.getOffSetImport(), equalTo(10l));
		assertThat(importadorUsuarioService.getPageCurrentImport(), equalTo(1l));
	}
	
	@Test
	public void teste_mesmaPagina_comOffset_19() {
		
		when(repositorioArquivo.getPageSize()).thenReturn(20);
		when(repositorioArquivo.getAmountUsers()).thenReturn(100l);
		when(repositorioMongo.count()).thenReturn(19l);
		when(repositorioArquivo.getAmountOfPages()).thenCallRealMethod();
		
		assertThat(importadorUsuarioService.isImportCompleted(), equalTo(false));
		assertThat(importadorUsuarioService.getOffSetImport(), equalTo(19l));
		assertThat(importadorUsuarioService.getPageCurrentImport(), equalTo(1l));
	}
	
	@Test
	public void teste_proxima__pagina_semOffset() {
		
		when(repositorioArquivo.getPageSize()).thenReturn(20);
		when(repositorioArquivo.getAmountUsers()).thenReturn(100l);
		when(repositorioMongo.count()).thenReturn(20l);
		when(repositorioArquivo.getAmountOfPages()).thenCallRealMethod();
		
		assertThat(importadorUsuarioService.isImportCompleted(), equalTo(false));
		assertThat(importadorUsuarioService.getOffSetImport(), equalTo(0l));
		assertThat(importadorUsuarioService.getPageCurrentImport(), equalTo(2l));
	}
	
	@Test
	public void teste_proxima__pagina_comOffset_10() {
		
		when(repositorioArquivo.getPageSize()).thenReturn(20);
		when(repositorioArquivo.getAmountUsers()).thenReturn(100l);
		when(repositorioMongo.count()).thenReturn(30l);
		when(repositorioArquivo.getAmountOfPages()).thenCallRealMethod();
		
		assertThat(importadorUsuarioService.isImportCompleted(), equalTo(false));
		assertThat(importadorUsuarioService.getOffSetImport(), equalTo(10l));
		assertThat(importadorUsuarioService.getPageCurrentImport(), equalTo(2l));
	}
	
	@Test
	public void teste_importacao_finalizada() {
		
		when(repositorioArquivo.getPageSize()).thenReturn(20);
		when(repositorioArquivo.getAmountUsers()).thenReturn(100l);
		when(repositorioMongo.count()).thenReturn(100l);
		when(repositorioArquivo.getAmountOfPages()).thenCallRealMethod();
		
		assertThat(importadorUsuarioService.isImportCompleted(), equalTo(true));
		assertThat(importadorUsuarioService.getOffSetImport(), equalTo(0l));
	}
	
}