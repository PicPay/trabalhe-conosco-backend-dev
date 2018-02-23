package com.tmontovaneli.challenge.mongodb;

import org.bson.Document;

import com.mongodb.MongoClient;
import com.mongodb.client.MongoCollection;
import com.mongodb.client.MongoDatabase;

public class MongoConnection {

	private MongoClient mongo;

	public MongoConnection() {
		super();

		String host = System.getenv("HOST");
		if (host == null)
			host = "localhost";

		String port = System.getenv("PORT");
		if (port == null)
			port = "27017";

		// mongo = new MongoClient("172.17.0.2", 27017);
		mongo = new MongoClient(host, Integer.valueOf(port));
	}

	private MongoDatabase getDataBase() {
		return mongo.getDatabase("picpay");
	}

	public MongoCollection<Document> getUsersCollections() {

		MongoDatabase dataBase = getDataBase();
		MongoCollection<Document> usersCollections = dataBase.getCollection("users");
		if (usersCollections == null) {
			dataBase.createCollection("users");
		}

		return usersCollections;
	}

	public void close() {
		mongo.close();
	}

	public MongoCollection<Document> getPrimeiraRelevanciaCollections() {

		MongoDatabase dataBase = getDataBase();
		MongoCollection<Document> relevancia = dataBase.getCollection("relevancia_1");
		if (relevancia == null) {
			dataBase.createCollection("relevancia_1");
		}

		return relevancia;
	}

	public MongoCollection<Document> getSegundaRelevanciaCollections() {

		MongoDatabase dataBase = getDataBase();
		MongoCollection<Document> relevancia = dataBase.getCollection("relevancia_2");
		if (relevancia == null) {
			dataBase.createCollection("relevancia_2");
		}

		return relevancia;
	}

}
