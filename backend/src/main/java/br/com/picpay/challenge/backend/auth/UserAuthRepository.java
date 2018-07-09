package br.com.picpay.challenge.backend.auth;

import org.springframework.data.mongodb.repository.MongoRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface UserAuthRepository extends MongoRepository<UserAuth, String> {

	/**
	 * Recupera um usuário pela API Key
	 * @param apiKey API Key do usuário
	 * @return
	 */
	UserAuth findByApiKey(String apiKey);
	
	/**
	 * Recupera um usuário pelo username
	 * @param username Username do usuário
	 * @return
	 */
	UserAuth findByUsername(String username);
	
}
