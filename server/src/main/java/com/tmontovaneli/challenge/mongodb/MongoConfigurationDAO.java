package com.tmontovaneli.challenge.mongodb;

import java.util.List;

import org.bson.Document;

import com.mongodb.BasicDBObject;
import com.mongodb.client.MongoCollection;

public class MongoConfigurationDAO {

	private MongoConnection mongoConnection;
	private MongoCollection<Document> usersCollections;

	public MongoConfigurationDAO() {

		mongoConnection = new MongoConnection();
	}

	public void insertPrimeiraRelevancia(List<Document> novos) {

		MongoCollection<Document> relevancia = mongoConnection.getPrimeiraRelevanciaCollections();
		relevancia.insertMany(novos);

	}

	public void insertSegundaRelevancia(List<Document> novos) {

		MongoCollection<Document> relevancia = mongoConnection.getSegundaRelevanciaCollections();
		relevancia.insertMany(novos);

	}

	public void insertUsers(List<Document> novos) {

		usersCollections = mongoConnection.getUsersCollections();

		usersCollections.insertMany(novos);

	}

	public void createIndexes() {
		// usersCollections.createIndex(new BasicDBObject("nome", "text"));
		// usersCollections.createIndex(new BasicDBObject("apelido", 1));
		// { nome: "text", apelido: "text"}

		BasicDBObject basicDBObject = new BasicDBObject();
		basicDBObject.put("nome", "text");
		basicDBObject.put("apelido", "text");

		usersCollections.createIndex(basicDBObject);

	}

	public void close() {
		mongoConnection.close();
	}

}
