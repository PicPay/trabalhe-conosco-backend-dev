package com.tardelli.server.model;

public enum EnumRelevancy {

    HIGH_RELEVANCE(1),
    AVERAGE_RELEVANCE(2),
    LOW_RELEVANCE(3);

    int value;

    EnumRelevancy(int i) {
        value = i;
    }

    public int getValue() {
        return value;
    }
}
