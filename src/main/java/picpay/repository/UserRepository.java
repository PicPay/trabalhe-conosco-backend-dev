package picpay.repository;

import java.util.UUID;

import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Page;
import org.springframework.data.elasticsearch.annotations.Query;
import org.springframework.data.elasticsearch.repository.ElasticsearchRepository;

import picpay.model.User;

public interface UserRepository extends ElasticsearchRepository<User, UUID> {

	Page<User> findByLogin(String login, Pageable pageable);
	Page<User> findByName(String name, Pageable pageable);
	
	Page<User> findByNameLikeOrderByPriorityAsc(String name, Pageable pageable);
	Page<User> findByLoginLikeOrderByPriorityAsc(String login, Pageable pageable);
	
	//findByNameContaining
	//findByNameLike
	//findByAvailableTrueOrderByNameDesc
	
	
//	@Query("{\"bool\": {\"must\": [{\"match\": {\"authors.name\": \"?0\"}}]}}")
//    Page<Article> findByAuthorsNameUsingCustomQuery(String name, Pageable pageable);
	
	 @Query("{\"bool\": {\"must\": {\"match_all\": {}}, \"filter\": {\"term\": {\"login\": \"?0\" }}}}")
	 Page<User> findByFilteredLoginQuery(String login, Pageable pageable);

}
