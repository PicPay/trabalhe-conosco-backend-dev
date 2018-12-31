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

public class FileUtils {
	
	public static File getFile(String file) throws IOException {
		return ResourceUtils.getFile("classpath:"+file );
	}
	
	public static URI getURIFile(String file) throws IOException {
		return getFile(file).toURI();
	}
	
	public static Stream<String> getLinesFile(String file) throws IOException{
		return lines(get(getURIFile(file)));
	}
	
	
	public static long amountLinesOfFile(String file) throws IOException {
		try (Stream<String> lines = getStreamLinesOfFile(file)) {
			return lines.count();
		}
	}
	
	public static Stream<String> getStreamLinesOfFile(String file) throws IOException{
		Resource resource = new ClassPathResource(file);
		BufferedReader reader = new BufferedReader(new InputStreamReader(resource.getInputStream()));
		return reader.lines();
	}
}