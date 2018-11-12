package picpay.util;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStreamReader;
import java.nio.file.Files;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.UUID;
import java.util.stream.Collectors;

import picpay.model.User;

public class Util {
	public static boolean readPriorityListToMap(String priorityListPath, int priority, Map<UUID, Integer> priorityMap) {
		List<UUID> priorityList = readPriorityList(priorityListPath);
		if (priorityList == null)
		{
			return false;
		}
		priorityList.stream().forEach(uuid -> priorityMap.put(uuid, priority));
		
		return true;
	}
	

	public static List<User> readUsersCsv(String path, Map<UUID, Integer> priorityMap)
	{
		List<User> users = new ArrayList<>();
		try (BufferedReader inputCsv = new BufferedReader(new InputStreamReader(new FileInputStream(path), "UTF-8"), 1000000))
		{

			boolean insideString = false;
			String line;
			boolean stringSep, separator;
			int commaPositions[] = new int[2];
			int commaPosition = 0;
			while (true)
			{
				line = inputCsv.readLine();
				commaPosition = 0;
				
				if (line == null)
					break;
				
				for (int i = 0; i < line.length(); i++) {
					int c = line.codePointAt(i);
					
					stringSep = c == '\"';
					
					if (stringSep)
					{
						//finaliza a string caso encontre o segundo " ou come�a uma nova
						insideString = !insideString;
						continue;
					}
					
					separator = c == ',';
					
					if (separator)
					{
						commaPositions[commaPosition++] = i;
						
						//j� encontrei as duas , que eu precisava
						if (commaPosition >= 2)
							break;
					}				
				}
				
				
				User user = new User();
				user.setUuid(UUID.fromString(line.substring(0, commaPositions[0]).replace("\n\"", "")));
				user.setName(line.substring(commaPositions[0] + 1, commaPositions[1]).replace("\n\"", ""));
				user.setLogin(line.substring(commaPositions[1] + 1).replace("\n\"", ""));
				
				Integer priority = priorityMap.get(user.getUuid());
				user.setPriority(priority == null ? 10 : priority.intValue());

				users.add(user);
			}
			
		} catch (FileNotFoundException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		} catch (IOException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
		
		return users;
	}
	
	public static List<UUID> readPriorityList(String path)
	{
		File file = new File(path);
		
		try {
			List<String> lines = Files.readAllLines(file.toPath());
			
			return lines.parallelStream().map(e -> UUID.fromString(e)).collect(Collectors.toList());
			
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
				
		return null;
	}
	
}
