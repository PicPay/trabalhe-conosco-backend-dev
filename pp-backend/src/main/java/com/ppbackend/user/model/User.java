package com.ppbackend.user.model;

import com.fasterxml.jackson.annotation.JsonProperty;
import org.springframework.data.annotation.Id;
import org.springframework.data.annotation.PersistenceConstructor;
import org.springframework.data.elasticsearch.annotations.Document;

@Document(indexName = "pp_user", type = "user")
public class User {

    @Id
    private String uuid;
    private String name;
    private String username;
    private float score;

    @PersistenceConstructor
    public User(@JsonProperty("uuid") String uuid,
                @JsonProperty("name") String name,
                @JsonProperty("username") String username,
                @JsonProperty("score") float score) {
        this.uuid = uuid;
        this.name = name;
        this.username = username;
        this.score = score;
    }

    public User(){}

    public String getUuid() {
        return uuid;
    }

    public void setUuid(String uuid) {
        this.uuid = uuid;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public float getScore() {
        return score;
    }

    public void setScore(float score) {
        this.score = score;
    }

    @Override
    public String toString(){
        return "User::toString() { uuid='" + getUuid() + '\''
                + ", name=" + getName() + '\''
                + ", username=" + getUsername()+'\''
                + ", score= "+ getScore() + "}";
    }
}
