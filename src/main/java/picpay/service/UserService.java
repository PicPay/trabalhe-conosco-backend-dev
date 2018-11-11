package picpay.service;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStreamReader;
import java.nio.file.Files;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.UUID;
import java.util.stream.Collectors;
import java.util.stream.IntStream;

import javax.annotation.PostConstruct;

import org.apache.commons.lang3.StringUtils;
import org.springframework.stereotype.Service;

import picpay.model.User;

@Service
public class UserService {
	
	private static UserService instance = null;
	
	public static UserService getInstance()
	{
		if (instance == null)
			instance = new UserService();
		
		return instance;
	}
	
	public UserService()
	{	
	}
	
	 @PostConstruct
	 public void init()
	 {
		 System.out.println("Inicializando servico");
		 long startTime = System.nanoTime();   
		 initialize(
					"F:\\Downloads\\users.csv\\users.csv", 
					"C:\\Users\\Romulo\\Documents\\workspace-spring-tool-suite-4-4.0.1.RELEASE\\picpay-csv\\lista_relevancia_1.txt",
					"C:\\Users\\Romulo\\Documents\\workspace-spring-tool-suite-4-4.0.1.RELEASE\\picpay-csv\\lista_relevancia_2.txt");
		 long estimatedTime = System.nanoTime() - startTime;
		 System.out.printf("Tempo da inicialização %f\n", (double)estimatedTime / 1e+9);
		 
	 }
	
	private void sortUsers()
	{
		Comparator<User> comparator = Comparator.comparing(u -> u.getPriority());
		comparator = comparator.thenComparing(Comparator.comparing(u -> u.getUuid()));
		Collections.sort(users, comparator);
	}
	
	public void initialize(String csvPath, String priorityList1Path, String priorityList2Path)
	{
		//lista com os uuids priorizados
		Map<UUID, Integer> priorityMap = new HashMap<>();
		
		System.out.println("Lendo lista de prioridades");
		//preencher priorityMap com os uuids que serao priorizados na pesquisa
		{
			boolean success = readPriorityListToMap(priorityList1Path, 0, priorityMap);
			if (!success)
			{
				System.err.println("Lista de prioridade 1 não encontrada: " + priorityList1Path);
				System.exit(1);
			}
			
			success = readPriorityListToMap(priorityList2Path, 1, priorityMap);
			if (!success)
			{
				System.err.println("Lista de prioridade 1 não encontrada: " + priorityList1Path);
				System.exit(1);
			}
		}
		
		System.out.println("Lendo csv de " + csvPath);
		users = readUsersCsv(csvPath, priorityMap);
		
		if (users == null || users.isEmpty())
		{
			System.err.println("Arquivo csv de usuários não encontrado: " + csvPath);
		}
		
		
		System.out.println("Ordenando dados por prioridade e uuid");
		
		sortUsers();

		//gera um mapa para acessar mais facilmente os usuarios pelo uuid
		generateUUIDMap();
	}

	private boolean readPriorityListToMap(String priorityListPath, int priority, Map<UUID, Integer> priorityMap) {
		List<UUID> priorityList = readPriorityList(priorityListPath);
		if (priorityList == null)
		{
			return false;
		}
		priorityList.stream().forEach(uuid -> priorityMap.put(uuid, priority));
		
		return true;
	}

	private void generateUUIDMap() {
		usersUUIDMap = IntStream.range(0, users.size())
		        .boxed()
		        .collect(Collectors.toMap(i ->  users.get(i).getUuid(), i -> i));
	}
	
	public List<User> findAllByName(String name)
	{
		final String nameLower = name.toLowerCase();
		return users.parallelStream().filter(u -> StringUtils.containsIgnoreCase(u.getName(), nameLower)).collect(Collectors.toList());
	}
	
	public List<User> findAllByName(String name, UUID startUser, int limit, boolean parallel)
	{
		int offset = Math.max(0, findIndexByUUID(startUser));
		
		return findAllByName(name, offset, limit, parallel);
	}
	
	public List<User> findAll(UUID startUser, int limit)
	{
		int offset = Math.max(0, findIndexByUUID(startUser));
		return findAll(offset, limit);
	}
	
	public List<User> findAll(int offset, int limit)
	{
		return users.stream().
				skip(offset).
				limit(limit).
				collect(Collectors.toList());
	}
	
	
	public List<User> findAllByName(String name, int offset, int limit, boolean parallel)
	{
		//
		final String nameLower = name.toLowerCase();
		
		if (parallel)
		return users.parallelStream().
				skip(offset).
				filter(u -> StringUtils.containsIgnoreCase(u.getName(), nameLower)).
				limit(limit).
				collect(Collectors.toList());
		else
			return users.stream().
					skip(offset).
					filter(u -> StringUtils.containsIgnoreCase(u.getName(), nameLower)).
					limit(limit).
					collect(Collectors.toList());
	}
	
	public List<User> findAllByUsername(String username, UUID startUser, int limit, boolean parallel)
	{
		int offset = Math.max(0, findIndexByUUID(startUser));
		
		return findAllByUsername(username, offset, limit, parallel);
	}
	
	public List<User> findAllByUsername(String username)
	{
		final String usernameLower = username.toLowerCase();
		return users.parallelStream()
				.filter(u -> StringUtils.containsIgnoreCase(u.getUsername(), usernameLower))
				.collect(Collectors.toList());
	}
	
	public List<User> findAllByUsername(String username, int offset, int limit, boolean parallel)
	{
		final String usernameLower = username.toLowerCase();
		if (parallel)
		return users.parallelStream().
				skip(offset).
				filter(u -> StringUtils.containsIgnoreCase(u.getUsername(), usernameLower)).
				limit(limit).
				collect(Collectors.toList());
		else
			return users.stream().
					skip(offset).
					filter(u -> StringUtils.containsIgnoreCase(u.getUsername(), usernameLower)).
					limit(limit).
					collect(Collectors.toList());
	}
	
	public int findIndexByUUID(UUID uuid)
	{
		if (uuid == null)
			return -1;
		
		Integer index = usersUUIDMap.get(uuid);
		
		if (index == null)
			return -1;
		
		return index.intValue();
	}
	
	public User findByUUID(UUID uuid)
	{
		Integer index = usersUUIDMap.get(uuid);
		
		if (index == null || index < 0 || index >= users.size())
			return null;
		
		return users.get(index);
	}
	
	private static List<User> readUsersCsv(String path, Map<UUID, Integer> priorityMap)
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
				user.setUsername(line.substring(commaPositions[1] + 1).replace("\n\"", ""));
				
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
	
	private static List<UUID> readPriorityList(String path)
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
	
	private Map<UUID, Integer> usersUUIDMap;
	private List<User> users;

}
