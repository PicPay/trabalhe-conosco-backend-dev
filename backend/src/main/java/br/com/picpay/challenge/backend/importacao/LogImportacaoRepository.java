package br.com.picpay.challenge.backend.importacao;

import java.util.Optional;

import org.springframework.data.mongodb.repository.MongoRepository;
import org.springframework.data.mongodb.repository.Query;
import org.springframework.stereotype.Repository;

@Repository
public interface LogImportacaoRepository extends MongoRepository<LogImportacao, String>, LogImportacaoRepositoryOps {

	@Query(value = "{'current': true}")
	Optional<LogImportacao> findCurrrent();
	
	LogImportacao findFirstByFileHashSha2OrderByDateDesc(String fileHash);
	
	LogImportacao findByFileUrlAndStatus(String fileUrl, StatusImportacao status);
	
}
