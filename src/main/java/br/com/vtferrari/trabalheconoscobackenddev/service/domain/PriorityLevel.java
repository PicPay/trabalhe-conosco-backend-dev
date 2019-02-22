package br.com.vtferrari.trabalheconoscobackenddev.service.domain;

import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;

import java.util.stream.Stream;

@NoArgsConstructor
@AllArgsConstructor
public enum PriorityLevel {
    HIGH(0),LOW(1),ERROR(Integer.MAX_VALUE);

    @Getter
    private Integer level;

    public static PriorityLevel fromLevel(Integer level) {
        return Stream.of(PriorityLevel.values())
                .filter(priorityLevel -> priorityLevel.level == level)
                .findFirst()
                .orElse(PriorityLevel.ERROR);
    }
}
