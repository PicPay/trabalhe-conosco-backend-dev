package com.picpay.utils;

import static java.nio.file.Files.lines;
import static java.nio.file.Paths.get;

import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.URI;
import java.util.stream.Stream;

import org.springframework.core.io.ClassPathResource;
import org.springframework.core.io.Resource;
import org.springframework.util.ResourceUtils;

public class ArquivoUtils {
	
	public static File getArquivo(String arquivo) throws IOException {
		return ResourceUtils.getFile("classpath:"+arquivo );
	}
	
	public static URI getURIArquivo(String arquivo) throws IOException {
		return getArquivo(arquivo).toURI();
	}
	
	public static Stream<String> getLinesArquivo(String arquivo) throws IOException{
		return lines(get(getURIArquivo(arquivo)));
	}
	
	public static long quantidadeLinhasDoArquivo(String arquivo) throws IOException {
		
		try (Stream<String> lines = getLinesArquivo(arquivo)) {
			return lines.count();
		}
	}
	
	public static long qtLinhasDoArquivo(String arquivo) throws IOException {
		try (Stream<String> lines = getStreamLinesDoArquivo(arquivo)) {
			return lines.count();
		}
	}
	
	public static Stream<String> getStreamLinesDoArquivo(String arquivo) throws IOException{
		Resource resource = new ClassPathResource(arquivo);
		BufferedReader reader = new BufferedReader(new InputStreamReader(resource.getInputStream()));
		return reader.lines();
	}
}
