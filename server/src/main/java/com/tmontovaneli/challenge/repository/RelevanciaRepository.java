package com.tmontovaneli.challenge.repository;

import org.bson.Document;

import com.mongodb.BasicDBObject;
import com.mongodb.client.MongoCollection;
import com.tmontovaneli.challenge.mongodb.MongoConnection;

public class RelevanciaRepository {


	private MongoConnection mongoConnection;

	public RelevanciaRepository(MongoConnection mongoConnection) {
		this.mongoConnection = mongoConnection;
	}

	public boolean usuarioTemPrioridade1(String id) {

		MongoCollection<Document> collections = mongoConnection.getPrimeiraRelevanciaCollections();

		return temPrioridade(id, collections);

	}

	public boolean usuarioTemPrioridade2(String id) {

		MongoCollection<Document> collections = mongoConnection.getSegundaRelevanciaCollections();

		return temPrioridade(id, collections);

	}

	private boolean temPrioridade(String id, MongoCollection<Document> collections) {

		BasicDBObject match = new BasicDBObject("_id", id);

		return collections.count(match) > 0;

	}

	public void close() {
		mongoConnection.close();
	}

}
