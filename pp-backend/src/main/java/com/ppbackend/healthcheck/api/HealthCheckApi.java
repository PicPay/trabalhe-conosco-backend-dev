package com.ppbackend.healthcheck.api;

import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping(path = "api/health")
public class HealthCheckApi {

    @GetMapping
    public HttpStatus healthCheck()  {
        return HttpStatus.OK;
    }
}
