package com.backdev.file.resources;

import org.springframework.data.annotation.Id;
import org.springframework.data.elasticsearch.annotations.Document;

@Document(indexName = "pp_prior", type = "priority")
public class Uuid {

    @Id
    private String uuid;

    public Uuid(){}

    public Uuid(String uuid) {
        this.uuid = uuid;
    }

    public String getUuid() {
        return uuid;
    }

    public void setUuid(String uuid) {
        this.uuid = uuid;
    }

}
