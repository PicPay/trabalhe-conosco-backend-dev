package com.picpay.repository;

import static com.picpay.utils.FileUtils.getStreamLinesOfFile;
import static com.picpay.utils.FileUtils.amountLinesOfFile;

import java.io.IOException;
import java.util.Collections;
import java.util.Comparator;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Optional;
import java.util.stream.Collectors;
import java.util.stream.Stream;

import com.picpay.model.SearchRelevance;
import com.picpay.model.User;


public class UserFileRepository {
	
	
	private String fileUsers;
	private String tokenSeparator;
	private List<String> filesRelevances;
	private int pageSize;
	
	private Map<String, SearchRelevance> mapRelevances;
	private long amountUsers;
	
	public UserFileRepository(String file, String tokenSeparator, List<String> filesRelevances,	int pageSize) {
		
		super();
		this.fileUsers = file;
		this.tokenSeparator = tokenSeparator;
		this.filesRelevances = filesRelevances;
		this.pageSize = pageSize;
		this.mapRelevances = new HashMap<>();
		
		prepareImport();
	}
	
	private void prepareImport()  {
		
		try {
			mountMapRelevances(filesRelevances);
			amountUsers = amountLinesOfFile(fileUsers); 
		} catch (IOException e) {
			throw new RuntimeException(" Error preparing user import ");
		}
	}
	
	private void mountMapRelevances(List<String> filesRelevances) throws IOException {

		for(int i = 0 ; i < filesRelevances.size() ; i++) {
			loadRelevanceFile(filesRelevances.get(i), new SearchRelevance(i+1));
		}
	}

	private void loadRelevanceFile(String arquivoRelevancia,SearchRelevance relevancia) throws IOException {

		try (Stream<String> lines = getStreamLinesOfFile(arquivoRelevancia)) {
			lines.forEach(id -> mapRelevances.put(id, relevancia));
		} 
	}
	
	public List<User> getUsersOnPage(long page , long offset) {
		
		try (Stream<String> lines = getStreamLinesOfFile(fileUsers)) {
			
			 List<User> collect = lines
				.skip(page * pageSize)	
				.skip(offset)
				.limit(pageSize)
				.map(l -> l.split(tokenSeparator))
				.map(s -> new User(s[0],s[1],s[2],mapRelevances.getOrDefault(s[0],new SearchRelevance(0))))
				.collect(Collectors.toList());
			 
			 return Collections.unmodifiableList(collect);
			
		} catch (IOException e) {
			throw new RuntimeException("Error preparing user import");
		} 
	}
	
	public List<User> findUser(long pagina , long offset) {
		
		try (Stream<String> lines = getStreamLinesOfFile(fileUsers)) {
			
			 List<User> collect = lines
				.skip(pagina * pageSize)	
				.skip(offset)
				.limit(pageSize)
				.map(l -> l.split(tokenSeparator))
				.map(s -> new User(s[0],s[1],s[2],mapRelevances.getOrDefault(s[0],new SearchRelevance(0))))
				.sorted(Comparator.comparing(User::getRelevance).reversed().thenComparing(User::getName))
				.collect(Collectors.toList());
			 
			 return Collections.unmodifiableList(collect);
			
		} catch (IOException e) {
			throw new RuntimeException("Error preparing user import");
		} 
	}
	
	public Optional<User> getUser(String id) {
		
		try (Stream<String> lines = getStreamLinesOfFile(fileUsers)) {
			return lines
				.filter(l -> l.contains(id))
				.map(l -> l.split(tokenSeparator))
				.map(s -> new User(s[0],s[1],s[2],mapRelevances.get(s[0])))
				.findFirst();
				
			
		} catch (IOException e) {
			throw new RuntimeException("Erro ao importar usuários");
		} 
	}

	public long getAmountUsers() {
		return amountUsers;
	}

	public int getPageSize() {
		return pageSize;
	}
	
	public long getAmountOfPages() {
		
		long amountUser = getAmountUsers();
		int pageSize = getPageSize();
		
		long qtPages = amountUser / pageSize;
		long restLastPage = amountUser % pageSize;
		if(restLastPage != 0) {
			qtPages++;
		}
		return qtPages;
	}
}