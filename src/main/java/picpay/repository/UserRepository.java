package picpay.repository;

import java.util.UUID;

import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Page;
import org.springframework.data.elasticsearch.repository.ElasticsearchRepository;

import picpay.model.User;

public interface UserRepository extends ElasticsearchRepository<User, UUID> {

	Page<User> findByLogin(String login, Pageable pageable);
	Page<User> findByName(String name, Pageable pageable);
	
	Page<User> findByNameLikeOrderByPriorityAsc(String name, Pageable pageable);
	Page<User> findByLoginLikeOrderByPriorityAsc(String login, Pageable pageable);
}
