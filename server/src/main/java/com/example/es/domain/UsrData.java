package com.example.es.domain;

import org.springframework.data.annotation.Id;
import org.springframework.data.elasticsearch.annotations.Document;


@Document(indexName = "usrpic", type = "users")
public class UsrData {
  
  @Id
  private String uuid; 
  private String name;  
  private String username;
  private boolean vip1;
  private boolean vip2;

  public UsrData() {

  }

  /**
   * @return the vip2
   */
  public boolean isVip2() {
    return vip2;
  }

  /**
   * @param vip2 the vip2 to set
   */
  public void setVip2(boolean vip2) {
    this.vip2 = vip2;
  }

  /**
   * @return the vip1
   */
  public boolean isVip1() {
    return vip1;
  }

  /**
   * @param vip1 the vip1 to set
   */
  public void setVip1(boolean vip1) {
    this.vip1 = vip1;
  }

  /**
   * @return the uuid
   */
  public String getUuid() {
    return uuid;
  }

  /**
   * @param uuid the uuid to set
   */
  public void setUuid(String uuid) {
    this.uuid = uuid;
  }

  /**
   * @return the name
   */
  public String getName() {
    return name;
  }

  /**
   * @param name the name to set
   */
  public void setName(String name) {
    this.name = name;
  }

  /**
   * @return the username
   */
  public String getUsername() {
    return username;
  }

  /**
   * @param username the username to set
   */
  public void setUsername(String username) {
    this.username = username;
  }

  
  public String toString(){
    return "{  uuid:"+getUuid()+" , name:"+getName()+" , username:"+getUsername()+"   }";
  }


  
}