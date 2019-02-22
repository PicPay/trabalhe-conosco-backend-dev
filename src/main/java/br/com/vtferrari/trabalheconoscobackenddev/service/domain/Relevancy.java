package br.com.vtferrari.trabalheconoscobackenddev.service.domain;

import lombok.Builder;
import lombok.Getter;

@Getter
@Builder
public class Relevancy {
    private String id;
    private PriorityLevel priorityLevel;
}
