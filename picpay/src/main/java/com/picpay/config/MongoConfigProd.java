package com.picpay.config;

import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.context.annotation.Profile;
import org.springframework.data.mongodb.MongoDbFactory;
import org.springframework.data.mongodb.MongoTransactionManager;
import org.springframework.data.mongodb.config.AbstractMongoConfiguration;
import com.mongodb.MongoClient;

@Profile("prod")
@Configuration
public class MongoConfigProd extends AbstractMongoConfiguration {

	
    @Override
    protected String getDatabaseName() {
        return "picpay";
    }

    @Override
    public MongoClient mongoClient() {
        return new MongoClient("mongodb", 27017);
    }

    @Override
    public String getMappingBasePackage() {
        return "com.br.picapy";
    }
    
    @Bean
    MongoTransactionManager transactionManager(MongoDbFactory dbFactory) {
            return new MongoTransactionManager(dbFactory);
    }
}
