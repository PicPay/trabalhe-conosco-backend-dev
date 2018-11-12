package picpay.service;

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
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Service;

import picpay.model.User;
import picpay.util.Util;


//@Service
public class UserService {
	@Value("${usersCsvPath}")
	private String csvPath;
	
	@Value("${priorityList1Path}")
	private String priorityList1Path;
	
	@Value("${priorityList2Path}")
	private String priorityList2Path;
	
	private Map<UUID, Integer> usersUUIDMap;
	
	private List<User> users;
	
	public UserService()
	{	
	}
	
	public List<User> findAll(int offset, int limit)
	{
		return users.stream().
				skip(offset).
				limit(limit).
				collect(Collectors.toList());
	}

	public List<User> findAll(UUID startUser, int limit)
	{
		int offset = Math.max(0, findIndexByUUID(startUser));
		return findAll(offset, limit);
	}
	
	public List<User> findAllByName(String name)
	{
		final String nameLower = name.toLowerCase();
		return users.parallelStream().filter(u -> StringUtils.containsIgnoreCase(u.getName(), nameLower)).collect(Collectors.toList());
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
	
	public List<User> findAllByName(String name, UUID startUser, int limit, boolean parallel)
	{
		int offset = Math.max(0, findIndexByUUID(startUser));
		
		return findAllByName(name, offset, limit, parallel);
	}
	
	public List<User> findAllByUsername(String username)
	{
		final String usernameLower = username.toLowerCase();
		return users.parallelStream()
				.filter(u -> StringUtils.containsIgnoreCase(u.getLogin(), usernameLower))
				.collect(Collectors.toList());
	}
	
	
	public List<User> findAllByUsername(String username, int offset, int limit, boolean parallel)
	{
		final String usernameLower = username.toLowerCase();
		if (parallel)
		return users.parallelStream().
				skip(offset).
				filter(u -> StringUtils.containsIgnoreCase(u.getLogin(), usernameLower)).
				limit(limit).
				collect(Collectors.toList());
		else
			return users.stream().
					skip(offset).
					filter(u -> StringUtils.containsIgnoreCase(u.getLogin(), usernameLower)).
					limit(limit).
					collect(Collectors.toList());
	}
	
	public List<User> findAllByUsername(String username, UUID startUser, int limit, boolean parallel)
	{
		int offset = Math.max(0, findIndexByUUID(startUser));
		
		return findAllByUsername(username, offset, limit, parallel);
	}
	
	public User findByUUID(UUID uuid)
	{
		Integer index = usersUUIDMap.get(uuid);
		
		if (index == null || index < 0 || index >= users.size())
			return null;
		
		return users.get(index);
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
	
	private void generateUUIDMap() {
		usersUUIDMap = IntStream.range(0, users.size())
		        .boxed()
		        .collect(Collectors.toMap(i ->  users.get(i).getUuid(), i -> i));
	}
	
	@PostConstruct
	 public void init()
	 {
		 System.out.println("Inicializando servico");
		 long startTime = System.nanoTime();   
		 initialize();
		 long estimatedTime = System.nanoTime() - startTime;
		 System.out.printf("Tempo da inicialização %f\n", (double)estimatedTime / 1e+9);
		 
	 }
	
	public void initialize()
	{
		//lista com os uuids priorizados
		Map<UUID, Integer> priorityMap = new HashMap<>();
		
		System.out.println("Lendo lista de prioridades");
		//preencher priorityMap com os uuids que serao priorizados na pesquisa
		{
			boolean success = Util.readPriorityListToMap(priorityList1Path, 0, priorityMap);
			if (!success)
			{
				System.err.println("Lista de prioridade 1 não encontrada: " + priorityList1Path);
				System.exit(1);
			}
			
			success = Util.readPriorityListToMap(priorityList2Path, 1, priorityMap);
			if (!success)
			{
				System.err.println("Lista de prioridade 1 não encontrada: " + priorityList1Path);
				System.exit(1);
			}
		}
		
		System.out.println("Lendo csv de " + csvPath);
		users = Util.readUsersCsv(csvPath, priorityMap);
		
		if (users == null || users.isEmpty())
		{
			System.err.println("Arquivo csv de usuários não encontrado: " + csvPath);
			System.exit(1);
		}
		
		
		System.out.println("Ordenando dados por prioridade e uuid");
		
		sortUsers();

		//gera um mapa para acessar mais facilmente os usuarios pelo uuid
		generateUUIDMap();
	}
	private void sortUsers()
	{
		Comparator<User> comparator = Comparator.comparing(u -> u.getPriority());
		comparator = comparator.thenComparing(Comparator.comparing(u -> u.getUuid()));
		Collections.sort(users, comparator);
	}

}
