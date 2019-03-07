package com.tardelli.server.model;

import com.opencsv.bean.CsvBindByPosition;
import lombok.Data;
import org.springframework.data.annotation.Id;
import org.springframework.data.elasticsearch.annotations.Document;

@Data
@Document(indexName = "usuarios", type = "users")
public class User {

    @Id
    @CsvBindByPosition(position = 0)
    private String id;

    @CsvBindByPosition(position = 1)
    private String name;

    @CsvBindByPosition(position = 2)
    private String userName;

    private Integer relevancy;

    public User() {
    }

    public User(String id, String name, String userName, Integer relevancy) {
        this.id = id;
        this.name = name;
        this.userName = userName;
        this.relevancy = relevancy;
    }
}
