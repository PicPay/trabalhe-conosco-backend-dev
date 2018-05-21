package picpay.repositories;

import java.util.List;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.repository.PagingAndSortingRepository;

import picpay.model.User;

public interface UserRepository extends PagingAndSortingRepository<User, Long> {
	List<User> findByNameIgnoreCaseContainingOrUsernameIgnoreCaseContaining(String name, String username);
	
	Page<User> findByNameIgnoreCaseContainingOrUsernameIgnoreCaseContainingOrderByPrior1DescPrior2DescNameAsc(String name, String username, Pageable pageable);
}
