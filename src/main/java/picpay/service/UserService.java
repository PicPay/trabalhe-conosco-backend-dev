package picpay.service;

import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Optional;
import java.util.UUID;
import java.util.function.Consumer;

import javax.annotation.PostConstruct;

import org.elasticsearch.client.Client;
import org.elasticsearch.client.IndicesAdminClient;
import org.elasticsearch.common.settings.Settings;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.context.ApplicationContext;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import picpay.model.User;
import picpay.repository.UserRepository;
import picpay.util.Util;

@Service
public class UserService {
	private final UserRepository userRepository;
	
	@Value("${usersCsvPath}")
	private String csvPath;
	
	@Value("${priorityList1Path}")
	private String priorityList1Path;
	
	@Value("${priorityList2Path}")
	private String priorityList2Path;
	
	@Value("${batchSize}")
	private int batchSize;
	
	
	@Autowired
	private ApplicationContext context;
	
	 @PostConstruct
	 public void init()
	 {
		 
		 long startTime = System.nanoTime();   
		 System.out.println("Inicializando UserServiceElastic");
		 //dados já foram populados
		 if (count() > 0)
			 return;
		 
		 
			//lista com os uuids priorizados
			Map<UUID, Integer> priorityMap = new HashMap<>();
			
			
			{
				long t1 = System.nanoTime();   
				System.out.println("Lendo lista de prioridades");
				
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
				
				System.out.printf("Leu lista de prioridades em %f s\n", (double)(System.nanoTime() - t1) / 1e+9);
			}
			
			Client clientElasticSearch = context.getBean(Client.class);
			IndicesAdminClient indiceAdmin = clientElasticSearch.admin().indices();
			
			//muda as configuracoes para ficar mais rapido
			indiceAdmin.prepareUpdateSettings("users")   
	        .setSettings(Settings.builder()                     
	                .put("index.number_of_replicas", 0)
	                .put("index.refresh_interval", -1)
	        )
	        .get();
			
			System.out.println("Lendo csv de " + csvPath);
			long t1 = System.nanoTime();   
			
			
			Util.readUsersCsvBatch(csvPath, priorityMap, batchSize, new Consumer<List<User>>() {
				private int batchCount = 0;
				private int countSaved = 0;
				
				
				@Override
				public void accept(List<User> users) {
					// TODO Auto-generated method stub
					long t = System.nanoTime();   
					System.out.println("Salvando batch " + batchCount);
					userRepository.saveAll(users);
					
					double timeSpend = (double)(System.nanoTime() - t) / 1e+9;
					System.out.printf("Salvou %d em %f s tempo por usuário: \n", 
							users.size(), timeSpend, timeSpend / (double)users.size());
				
					countSaved += users.size();
					batchCount++;
					
					System.out.println("Usuários lidos: " + countSaved);
				}
			});

			//volta as configuracoes
			indiceAdmin.prepareUpdateSettings("users")   
	        .setSettings(Settings.builder()                     
	                .put("index.number_of_replicas", 1)
	                .put("index.refresh_interval", "15s")
	        )
	        .get();
			
			
			System.out.printf("Leu csv em %f s\n", (double)(System.nanoTime() - t1) / 1e+9);


			 long estimatedTime = System.nanoTime() - startTime;
			 System.out.printf("Tempo da inicialização %f\n", (double)estimatedTime / 1e+9);
	 }
	
	@Autowired
	public UserService(UserRepository userRepository)
	{
		this.userRepository = userRepository;
	}
	
    public User save(User user) {
        return userRepository.save(user);
    }
    
    public Iterable<User> saveAll(Iterable<User> users) {
        return userRepository.saveAll(users);
    }
    
    public Optional<User> findOne(UUID uuid) {
        return userRepository.findById(uuid);
    }
    
    public Page<User> findAllByLogin(String login, Pageable pageable)
    {
    	 return userRepository.findByLogin(login, pageable);
    }
    
    public Page<User> findAllByName(String name, Pageable pageable)
    {
    	return userRepository.findByName(name, pageable);
    }
    
    
    public Page<User> findAll(Pageable pageable)
    {
    	 return userRepository.findAll(pageable);
    }
    
    public long count() {
        return userRepository.count();
    }


}
