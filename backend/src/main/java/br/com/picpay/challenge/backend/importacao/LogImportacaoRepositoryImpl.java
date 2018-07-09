package br.com.picpay.challenge.backend.importacao;

import static org.springframework.data.mongodb.core.query.Criteria.where;
import static org.springframework.data.mongodb.core.query.Query.query;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.mongodb.core.MongoOperations;
import org.springframework.data.mongodb.core.query.Update;

import com.mongodb.client.result.UpdateResult;

public class LogImportacaoRepositoryImpl implements LogImportacaoRepositoryOps {

	@Autowired
	private MongoOperations mongoOps;
	
	@Override
	public int unmarkPreviousCurrent(String newCurrentId) {
		//Caso o número de importações venha a crescer, deve-se criar um índice para o campo corrent. Inicialmente não há necessidade
		UpdateResult updateResult = mongoOps.updateMulti(query(where("current").is(Boolean.TRUE).and("_id").ne(newCurrentId)), 
				new Update().set("current", Boolean.FALSE), 
				LogImportacao.class);
		return (int) updateResult.getModifiedCount();
	}

}
