package br.com.vtferrari.trabalheconoscobackenddev.model;

import lombok.Data;
import org.springframework.data.annotation.Id;
import org.springframework.data.elasticsearch.annotations.Document;

@Data
@Document(indexName = "trabalhe-conosco-backend-dev.users")
public class User {
    @Id
    private String id;
    private String name;
}

