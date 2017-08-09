package models;

import models.enums.Priority;

/**
 * Classe responsavel por definir a estrutura  do modelo do usuario
 * 
 * @author gustavo
 * @since 08/08/2017
 */
public class User {
    private String id;
    private String name;
    private String userName;
    private Priority priority;

    /**
     * Construtor da classe
     * 
     * @param id identificador do usuario
     * @param name nome do usuario
     * @param userName nome de usuario no sistema
     * @param priority prioridade de ordenacao
     */
    public User(String id, String name, String userName, Priority priority) {
        this.id = id;
        this.name = name;
        this.userName = userName;
        this.priority = priority;
    }
    
    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getUserName() {
        return userName;
    }

    public void setUserName(String userName) {
        this.userName = userName;
    }

    public Priority getPriority() {
        return priority;
    }

    public void setPriority(Priority priority) {
        this.priority = priority;
    }
    
    

}
