package br.com.vtferrari.trabalheconoscobackenddev.repository.model;

import lombok.Data;
import org.springframework.data.annotation.Id;
import org.springframework.data.elasticsearch.annotations.Document;

@Data
@Document(indexName = "trabalhe-conosco-backend-dev.users", type = "user")
public class UserElasticsearch {
    @Id
    private String id;
    private String name;
    private String username;
}

