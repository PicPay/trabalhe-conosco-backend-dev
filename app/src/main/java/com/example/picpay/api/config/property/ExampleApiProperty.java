package com.example.picpay.api.config.property;

import org.springframework.boot.context.properties.ConfigurationProperties;

@ConfigurationProperties("example.picpay.api")
public class ExampleApiProperty {

  public String getRealPath() {
    return System.getProperty("user.dir");
  }

}
