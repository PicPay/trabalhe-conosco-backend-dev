package br.com.vtferrari.trabalheconoscobackenddev.service.domain;

import lombok.Builder;
import lombok.Data;
import org.springframework.data.annotation.Id;

@Data
@Builder
public class User {
    @Id
    private String id;
    private String name;
    private String username;
}

