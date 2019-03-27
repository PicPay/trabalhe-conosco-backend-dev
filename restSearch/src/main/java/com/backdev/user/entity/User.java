package com.backdev.user.entity;

import org.springframework.data.annotation.Id;
import org.springframework.data.annotation.PersistenceConstructor;
import org.springframework.data.elasticsearch.annotations.Document;

@Document(indexName = "pp_user", type = "user")
public class User {

    @Id
    private String uuid;
    private String name;
    private String username;

    @PersistenceConstructor
    public User(String uuid, String name, String username) {
        this.uuid = uuid;
        this.name = name;
        this.username = username;
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

    @Override
    public String toString(){
        return "Document [uuid="+getUuid()+"name="+getName()+"username="+getUsername()+"]";
    }
}
