/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package br.com.apiresttestpicpay.model;

import com.google.gson.annotations.Expose;
import java.io.Serializable;
import java.util.Objects;
import javax.persistence.Basic;
import javax.persistence.CascadeType;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.NamedQueries;
import javax.persistence.NamedQuery;
import javax.persistence.OneToOne;
import javax.persistence.Table;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;
import javax.xml.bind.annotation.XmlRootElement;

/**
 *
 * @author rsilva
 */
@Entity
@Table(name = "users")
@XmlRootElement
@NamedQueries({
    @NamedQuery(name = "Users.findAll", query = "SELECT u FROM Users u")
    , @NamedQuery(name = "Users.findById", query = "SELECT u FROM Users u WHERE u.id = :id")
    , @NamedQuery(name = "Users.findByNome", query = "SELECT u FROM Users u WHERE u.nome = :nome")
    , @NamedQuery(name = "Users.findByUsername", query = "SELECT u FROM Users u WHERE u.username = :username")})
public class Users implements Serializable, Comparable<Users> {

    private static final long serialVersionUID = 1L;
    @Id
    @Basic(optional = false)
    @NotNull
    @Size(min = 1, max = 255)
    @Column(name = "id")
    @Expose
    private String id;
    @Size(max = 255)
    @Column(name = "nome")
    @Expose
    private String nome;
    @Size(max = 255)
    @Column(name = "username")
    @Expose
    private String username;
    @OneToOne(cascade = CascadeType.ALL, mappedBy = "users")
    private Prioridade1 prioridade1;
    @OneToOne(cascade = CascadeType.ALL, mappedBy = "users")
    private Prioridade2 prioridade2;

    public Users() {
    }

    public Users(String id) {
        this.id = id;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public Prioridade1 getPrioridade1() {
        return prioridade1;
    }

    public void setPrioridade1(Prioridade1 prioridade1) {
        this.prioridade1 = prioridade1;
    }

    public Prioridade2 getPrioridade2() {
        return prioridade2;
    }

    public void setPrioridade2(Prioridade2 prioridade2) {
        this.prioridade2 = prioridade2;
    }

    public boolean hasPrioridade1() {
        return this.prioridade1 != null;
    }

    public boolean hasPrioridade2() {
        return this.prioridade2 != null;
    }

    @Override
    public int hashCode() {
        int hash = 0;
        hash += (id != null ? id.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object obj) {
        if (this == obj) {
            return true;
        }
        if (obj == null) {
            return false;
        }
        if (getClass() != obj.getClass()) {
            return false;
        }
        final Users other = (Users) obj;
        return Objects.equals(this.id, other.id);
    }

    @Override
    public String toString() {
        return "br.com.apiresttestpicpay.model.Users[ id=" + id + " ]";
    }

    @Override
    public int compareTo(Users other) {
        if (this.hasPrioridade1()) {
            return 1;
        } else {
            if (this.hasPrioridade2()) {
                return 0;
            } else {
                return -1;
            }
        }
    }

}
