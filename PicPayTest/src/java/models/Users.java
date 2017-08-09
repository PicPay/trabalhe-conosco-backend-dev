/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package models;

import java.io.Serializable;
import java.util.LinkedList;
import javax.persistence.Basic;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.EntityManager;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;
import javax.persistence.Transient;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;
import javax.xml.bind.annotation.XmlRootElement;
import models.enums.Priority;

/**
 * Classe da entidade do banco de dados para a tabela users
 *
 * @author gustavo
 * @version 1.0.0
 * @since 09/08/2017
 */
@Entity
@Table(name = "users")
@XmlRootElement
public class Users implements Serializable {

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "idusers")
    private Integer idusers;

    @Basic(optional = false)
    @NotNull
    @Size(min = 1, max = 255)
    @Column(name = "id")
    private String id;

    @Basic(optional = false)
    @NotNull
    @Size(min = 1, max = 45)
    @Column(name = "name")
    private String name;

    @Basic(optional = false)
    @NotNull
    @Size(min = 1, max = 45)
    @Column(name = "userName")
    private String userName;

    @Transient
    private Priority priority;

    /**
     * Construtor da classe
     *
     * @author gustavo
     * @since 09/08/2017
     */
    public Users() {
    }

    /**
     * Construtor da classe com parametros
     *
     * @param idusers identificador da entidade no banco
     * @param id identificador do usuario
     * @param name nome
     * @param userName nome de usuario no sistema
     * @author gustavo
     * @since 09/08/2017
     */
    public Users(Integer idusers, String id, String name, String userName) {
        this.idusers = idusers;
        this.id = id;
        this.name = name;
        this.userName = userName;
    }

    /**
     * Construtor da classe com parametros para o json
     *
     * @param idusers identificador da entidade no banco
     * @param id identificador do usuario
     * @param name nome
     * @param userName nome de usuario no sistema
     * @author gustavo
     * @since 09/08/2017
     */
    public Users(String id, String name, String userName, Priority priority) {
        this.id = id;
        this.name = name;
        this.userName = userName;
        this.priority = priority;
    }
    
    public LinkedList<Users> searchUsers(String key, EntityManager em){
        
        LinkedList<Users> users= null;
        
        
        return users;
        
    }

    /**
     * Retorna o identificador gerado do banco
     *
     * @return identificador
     * @author gustavo
     * @since 09/08/2017
     */
    public Integer getIdusers() {
        return idusers;
    }

    /**
     * Retorna o id do usuario
     *
     * @return id
     * @author gustavo
     * @since 09/08/2017
     */
    public String getId() {
        return id;
    }

    /**
     * Insere o identificador do usuario
     *
     * @param id identificador
     * @author gustavo
     * @since 09/08/2017
     */
    public void setId(String id) {
        this.id = id;
    }

    /**
     * Retorna o nome do usuario
     *
     * @return nome
     * @author gustavo
     * @since 09/08/2017
     */
    public String getName() {
        return name;
    }

    /**
     * Insere o nome do usuario
     *
     * @param name nome do usuario
     * @author gustavo
     * @since 09/08/2017
     */
    public void setName(String name) {
        this.name = name;
    }

    /**
     * Retorna o nome de usuario
     *
     * @return nome
     * @author gustavo
     * @since 09/08/2017
     */
    public String getUserName() {
        return userName;
    }

    /**
     * Insere nome de usuario
     *
     * @param userName nome de usuario
     * @author gustavo
     * @since 09/08/2017
     */
    public void setUserName(String userName) {
        this.userName = userName;
    }

    /**
     * Gera o hashcode
     *
     * @return hashcode
     * @author gustavo
     * @since 09/08/2017
     */
    @Override
    public int hashCode() {
        int hash = 0;
        hash += (idusers != null ? idusers.hashCode() : 0);
        return hash;
    }

    /**
     * Metodo para comparacao de objetos
     *
     * @param object
     * @return validacao
     * @author gustavo
     * @since 09/08/2017
     */
    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof Users)) {
            return false;
        }
        Users other = (Users) object;
        if ((this.idusers == null && other.idusers != null) || (this.idusers != null && !this.idusers.equals(other.idusers))) {
            return false;
        }
        return true;
    }

}
