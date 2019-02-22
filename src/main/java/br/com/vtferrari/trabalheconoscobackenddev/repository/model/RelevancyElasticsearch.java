package br.com.vtferrari.trabalheconoscobackenddev.repository.model;


import lombok.Builder;
import lombok.Data;
import org.springframework.data.annotation.Id;
import org.springframework.data.elasticsearch.annotations.Document;

@Data
@Builder
@Document(indexName = "trabalhe-conosco-backend-dev.relevancy")
public class RelevancyElasticsearch {
    @Id
    private String id;
    private int priorityLevel;
}
