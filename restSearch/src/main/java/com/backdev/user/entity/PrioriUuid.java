package com.backdev.user.entity;

import org.springframework.data.annotation.Id;

public class PrioriUuid {

    @Id
    private String uuid;

    public PrioriUuid() {
    }

    public PrioriUuid(String uuid) {
        this.uuid = uuid;
    }

    public String getUuid() {
        return uuid;
    }

    public void setUuid(String uuid) {
        this.uuid = uuid;
    }
}
