package picpay.service;

import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Optional;
import java.util.UUID;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

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
public class UserServiceElastic {
	private final UserRepository userRepository;
	
	@Value("${usersCsvPath}")
	private String csvPath;
	
	@Value("${priorityList1Path}")
	private String priorityList1Path;
	
	@Value("${priorityList2Path}")
	private String priorityList2Path;
	
	
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
			
			System.out.println("Lendo csv de " + csvPath);
			long t1 = System.nanoTime();   
			final List<User> users = Util.readUsersCsv(csvPath, priorityMap);
			
			
			System.out.printf("Leu csv em %f s\n", (double)(System.nanoTime() - t1) / 1e+9);

			if (users == null || users.isEmpty())
			{
				System.err.println("Arquivo csv de usuários não encontrado: " + csvPath);
				System.exit(1);
			}
			
			//adicionar tudo no negocio
			{
				Client clientElasticSearch = context.getBean(Client.class);
				IndicesAdminClient indiceAdmin = clientElasticSearch.admin().indices();
				
				//muda as configuracoes para ficar mais rapido
				indiceAdmin.prepareUpdateSettings("users")   
		        .setSettings(Settings.builder()                     
		                .put("index.number_of_replicas", 0)
		                .put("index.refresh_interval", -1)
		        )
		        .get();
				
				System.out.println("Salvando lista de usuários no elasticsearch ");
				t1 = System.nanoTime();   
				final int batchSize = users.size() / 100;
				System.out.println("batchSize: " + batchSize);
				
				//ExecutorService executor = Executors.newFixedThreadPool(4);
				

				
				final int size = (int)Math.ceil(users.size() / (double)batchSize);
				for (int i = 0; i < size; i++)
				{
					
					final int fromIndex = i * batchSize;
					final int toIndex = Math.min(fromIndex + batchSize, users.size());
					
					final int iCopy = i;
//					executor.execute(() -> {
						long t = System.nanoTime();   
						System.out.println("Salvando " + iCopy + " de " + size);
						userRepository.saveAll(users.subList(fromIndex, toIndex));
						
						double timeSpend = (double)(System.nanoTime() - t) / 1e+9;
						System.out.printf("Salvou %d de %d em %f s tempo por usuário: \n", 
								iCopy, size, timeSpend, timeSpend / batchSize);
//					});
					
					if (toIndex >= users.size())
						break;

				}
				
				//executor.shutdown();
				
//				try {
//					executor.wait();
//				} catch (InterruptedException e) {
//					// TODO Auto-generated catch block
//					e.printStackTrace();
//					System.exit(1);
//				}
//				
				
				//volta as configuracoes
				indiceAdmin.prepareUpdateSettings("users")   
		        .setSettings(Settings.builder()                     
		                .put("index.number_of_replicas", 1)
		                .put("index.refresh_interval", "15s")
		        )
		        .get();
				
				
				System.out.printf("Usuários salvos em %f s\n", (double)(System.nanoTime() - t1) / 1e+9);
			}
			 long estimatedTime = System.nanoTime() - startTime;
			 System.out.printf("Tempo da inicialização %f\n", (double)estimatedTime / 1e+9);
	 }
	
	@Autowired
	public UserServiceElastic(UserRepository userRepository)
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
    	 return userRepository.findByLoginLikeOrderByPriorityAsc(login, pageable);
    }
    
    public Page<User> findAllByName(String name, Pageable pageable)
    {
    	 return userRepository.findByNameLikeOrderByPriorityAsc(name, pageable);
    }
    
    
    public Page<User> findAll(Pageable pageable)
    {
    	 return userRepository.findAll(pageable);
    }
    
    public long count() {
        return userRepository.count();
    }


}
