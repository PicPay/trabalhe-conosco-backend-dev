package picpay.repository;

import java.util.UUID;

import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Page;
import org.springframework.data.elasticsearch.annotations.Query;
import org.springframework.data.elasticsearch.repository.ElasticsearchRepository;

import picpay.model.User;

public interface UserRepository extends ElasticsearchRepository<User, UUID> {

	//https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-simple-query-string-query.html
	@Query(
			"{"
			+ "\"simple_query_string\" : "
			+ "{"
			+ "\"query\": \"*?0*\", "
			+ "\"fields\": [\"login\"], "
			+ "\"default_operator\": \"and\", "
			+ "\"fuzzy_transpositions\": \"false\", "
			+ "\"auto_generate_synonyms_phrase_query\": \"false\", "
			+ "\"analyze_wildcard\": \"true\""
			+ "}"
			+ "}")
	Page<User> findByLogin(String login, Pageable pageable);

	@Query(
			"{"
			+ "\"simple_query_string\" : "
			+ "{"
			+ "\"query\": \"*?0*\", "
			+ "\"fields\": [\"name\"], "
			+ "\"default_operator\": \"and\", "
			+ "\"fuzzy_transpositions\": \"false\", "
			+ "\"auto_generate_synonyms_phrase_query\": \"false\", "
			+ "\"analyze_wildcard\": \"true\""
			+ "}"
			+ "}")
	Page<User> findByName(String name, Pageable pageable);
}
