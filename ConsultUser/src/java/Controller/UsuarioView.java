/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controller;

import Controller.AcessoWs;
import Modelo.Usuario;
import java.util.ArrayList;
import java.util.List;
import javax.faces.bean.ManagedBean;
import javax.faces.bean.SessionScoped;

/**
 *
 * @author johonatan
 */
@ManagedBean(name = "usuarioView")
@SessionScoped
public class UsuarioView {

    private String nome;
    private List<Usuario> listUser;
    private Usuario usuario = new Usuario();
    

    public Usuario getUsuario() {
        return usuario;
    }

    public void setUsuario(Usuario usuario) {
        this.usuario = usuario;
    }

    
    public List<Usuario> getListUser(){        
        return listUser;
    }

    
    public void setListUser(List<Usuario> listUser) {
        this.listUser = listUser;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public void forcarLista() throws Exception{
        AcessoWs acessoWs = new AcessoWs();
        List<Usuario> list = new ArrayList<Usuario>();
        
        list.addAll(acessoWs.retornaPesquisaUserWs(nome.replace( " ", "%20")));
        this.listUser = list;
    }

}
