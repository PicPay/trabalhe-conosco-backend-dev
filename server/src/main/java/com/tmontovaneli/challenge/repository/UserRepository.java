package com.tmontovaneli.challenge.repository;

import java.util.ArrayList;
import java.util.List;

import org.bson.Document;

import com.fasterxml.jackson.databind.ObjectMapper;
import com.mongodb.BasicDBObject;
import com.mongodb.client.FindIterable;
import com.mongodb.client.MongoCollection;
import com.mongodb.client.MongoCursor;
import com.mongodb.client.model.CountOptions;
import com.tmontovaneli.challenge.model.User;
import com.tmontovaneli.challenge.mongodb.MongoConnection;

public class UserRepository {

	private static final int _LIMIT = 15;
	private MongoConnection mongoConnection;

	public UserRepository(MongoConnection mongoConnection) {
		this.mongoConnection = mongoConnection;
	}

	public List<User> find(String query, Integer page) throws Exception {

		try {

			List<User> result = new ArrayList<User>();

			BasicDBObject match = buildParameter(query);

			MongoCollection<Document> usersCollections = mongoConnection.getUsersCollections();

			FindIterable<Document> filter = usersCollections.find(match).limit(_LIMIT);
			if (page != null && page.compareTo(1) > 0)
				filter.skip(_LIMIT * page);

			filter.sort(new BasicDBObject("nome", 1));

			ObjectMapper mapper = new ObjectMapper();

			MongoCursor<Document> iterator = filter.iterator();
			while (iterator.hasNext()) {

				result.add(mapper.readValue(iterator.next().toJson(), User.class));
			}

			return result;

		} catch (Exception e) {
			e.printStackTrace();
			throw new Exception("Erro ao buscar usuários", e);
		} finally {
			// mongoConnection.close();
		}

	}

	private BasicDBObject buildParameter(String query) {
		// BasicDBList firstOrValues = new BasicDBList();
		// firstOrValues.add(new Document("$text", new Document("$search",
		// query)));
		// String padrao = "\\b" + query + "\\b";
		// firstOrValues.add(new Document("nome", Pattern.compile(padrao,
		// Pattern.CASE_INSENSITIVE)));
		// firstOrValues.add(new Document("apelido", Pattern.compile(padrao,
		// Pattern.CASE_INSENSITIVE)));
		// BasicDBObject match = new BasicDBObject("$or", firstOrValues);

		BasicDBObject match = new BasicDBObject("$text", new Document("$search", query));
		return match;
	}

	public Long count(String query, int page) {

		// MongoConnection mongoConnection = new MongoConnection();
		try {
			BasicDBObject parameter = buildParameter(query);

			MongoCollection<Document> usersCollections = mongoConnection.getUsersCollections();

			return usersCollections.count(parameter, new CountOptions().skip(page * _LIMIT).limit(_LIMIT * 10));
		} finally {
			// mongoConnection.close();
		}
	}

}
