package com.picpay;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;
import java.util.function.Function;
import java.util.stream.Collectors;

public class UserUtil {
	
	public static Function<String, User> mapToUser = (line) -> {
		String[] p = line.split(",");
		return new User(p[0], p[1], p[2]);
	};
	  
	public ArrayList<String> loadRelevantUsers(String inputFilePath) {
    	
    	File inputF = new File(inputFilePath);
		InputStream inputFS;
		ArrayList<String> users = new ArrayList<String>();
		try 
		{
			inputFS = new FileInputStream(inputF);
			BufferedReader br = new BufferedReader(new InputStreamReader(inputFS));
			
			users = new ArrayList<String>();
			users = (ArrayList<String>) br.lines().collect(Collectors.toList());
			br.close();
		}
		catch (FileNotFoundException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
	
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

    	return  users;
	}

	public List<User> loadUserFromCsv(String inputFilePath) 
    {
    	List<User> users = new ArrayList<User>();
		
		try {
			
			File inputF = new File(inputFilePath);
			InputStream inputFS;
			inputFS = new FileInputStream(inputF);
			BufferedReader br = new BufferedReader(new InputStreamReader(inputFS)); 
			users = br.lines().map(mapToUser).collect(Collectors.toList());
			br.close();

		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
			     
   	 	return users;
	}
}
