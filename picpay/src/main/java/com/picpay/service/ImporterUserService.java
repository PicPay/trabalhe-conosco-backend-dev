package com.picpay.service;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.stereotype.Service;

import com.picpay.model.User;
import com.picpay.repository.UserFileRepository;
import com.picpay.repository.UserMongoRepository;

@Service
public class ImporterUserService {

	private UserMongoRepository repositoryMongo;
	private UserFileRepository repositoryFile;
	
	@Autowired
	public ImporterUserService(UserMongoRepository repositorioMongo, @Qualifier("import")UserFileRepository repositorioArquivo) {
		super();
		this.repositoryMongo = repositorioMongo;
		this.repositoryFile = repositorioArquivo;
	}

	public void importer() {
		
		if(!isImportCompleted()) {
		
			long amountOfPages = repositoryFile.getAmountOfPages();
			long i = getPageCurrentImport();
			long offSet = getOffSetImport();
			
			for(;i < amountOfPages ; i++) {
				List<User> users = repositoryFile.getUsersOnPage(i,offSet);
				repositoryMongo.saveAll(users);
			}
		}
	}
	
	public boolean isImportCompleted() {
		
		long amountDataImported = repositoryMongo.count();
		long amountUsers = repositoryFile.getAmountUsers();
		return amountDataImported == amountUsers;
	}
	
	public long getPageCurrentImport() {
		
		long amountDataImported = repositoryMongo.count();
		long page = 0;
		
		if(amountDataImported != 0 )  {
			page = (amountDataImported / repositoryFile.getPageSize()) + 1;
		}
		
		return page;
	}
	
	public long getOffSetImport() {
		
		long amountDataImported = repositoryMongo.count();
		
		if(amountDataImported < repositoryFile.getPageSize())
			return amountDataImported;
		else if (amountDataImported % repositoryFile.getPageSize() == 0)
			return 0;
		else {
			return amountDataImported % repositoryFile.getPageSize();
		}
	}
	
}