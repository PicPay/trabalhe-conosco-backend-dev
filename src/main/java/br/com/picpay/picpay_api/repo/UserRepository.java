package br.com.picpay.picpay_api.repo;

import java.util.List;
import java.util.Optional;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.stereotype.Repository;

import br.com.picpay.picpay_api.entity.User;

@Repository
public interface UserRepository extends JpaRepository<User, Long> {
	
	@Query("select u from User u left outer join Relevancia re ON re.hash = u.hash "
			+ "where u.name like %?1% "
			+ "and u.username like %?2% "
			+ "order by re.precedencia, u.id ")
	List<User> getByNameAndUsername(String name, String username);

	@Query("select u from User u left outer join Relevancia re ON re.hash = u.hash "
			+ "where u.hash like %?1% "
			+ "order by re.precedencia, u.id ")
	Optional<User> getByHash(String hash);
}