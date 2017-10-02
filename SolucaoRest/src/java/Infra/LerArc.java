/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Infra;

import Modelo.Usuario;
import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;

import java.util.List;

/**
 *
 * @author johonatan
 */
public class LerArc {
    
    public int num;
    // leitura do Arq CSV******************************************************************************************************
    public List<Usuario> listUsuarios(String csvArquivo, String nome, String userName) throws FileNotFoundException, IOException{
        
        BufferedReader conteudoCsv = null;
        String linha = "";
        String csvSeparadorCampo = ",";
        
        
        List<Usuario> list = new ArrayList<Usuario>();
      
        
        try{
            conteudoCsv = new BufferedReader(new FileReader(csvArquivo));
            
            while((linha = conteudoCsv.readLine()) != null){
                String[] dado = linha.split(csvSeparadorCampo);
               if((dado[1].toLowerCase().contains(nome.toLowerCase())) || (dado[2].toLowerCase().contains(userName.toLowerCase()))){
                Usuario usuario = new Usuario(dado[0],dado[1],dado[2]);
                
                list.add(usuario);
                num++;
               }
               
               
            }
        
        } catch (FileNotFoundException e) {
        e.printStackTrace();
        } catch (IOException e) {
        e.printStackTrace();
        } 
        
    
        return list;
    }
    
    // Leitura do Arq Txt***********************************************************************************************************************************************
    
    public List<String> listaTxt (String nomeArq) {
       
    List<String> list = new ArrayList<String>();
    
    try {
      
      BufferedReader lerArq = new BufferedReader(new FileReader("C:\\Projeto\\trabalhe-conosco-backend-dev\\SolucaoRest\\txt\\" + nomeArq));
 
      String linha = lerArq.readLine(); 
      while (linha != null) {
       
        list.add(linha);
          
        linha = lerArq.readLine(); // lê da segunda até a última linha
      }
 
      lerArq.close();
    } catch (IOException e) {
        System.err.printf("Erro na abertura do arquivo: %s.\n",
          e.getMessage());
    }
        
    return list;
   }
    
    // Gerar Lista Segundo criterios do Problema Verificar nos arquivos texto primeiro e depois o resto dos resultados ********************************************************************
    
    public List<Usuario> listUsuarioOrganizado(String nome) throws IOException{
        
        // lista de usuários retornados do CSV
        List<Usuario> listUser = new ArrayList<Usuario>();
        listUser = listUsuarios("C:\\Projeto\\trabalhe-conosco-backend-dev\\SolucaoRest\\DB\\users.csv", nome, nome);
        
        // lista de usuários osganizados
        List<Usuario> listUserOrganizados = new ArrayList<Usuario>();
        
        // lista txt-1
        List<String> listTxtUm = new ArrayList<String>();
        listTxtUm = listaTxt("lista_relevancia_1.txt");
                
        // lista txt-1
        List<String> listTxtDois = new ArrayList<String>();
        listTxtDois = listaTxt("lista_relevancia_2.txt");
        
        
        // Começa a organização da lista, primeiro verifica na lista 1
        for(int i=0;i<listUser.size();i++){
           for(int j=0;j<listTxtUm.size();j++){ 
            if(listUser.get(i).getId().toString().trim().equals(listTxtUm.get(j).trim())){
                listUserOrganizados.add(listUser.get(i));
                break;
            }
           }
        }
        
        // O que sobrou verifica na lista 2
        for(int i=0;i<listUser.size();i++){
           for(int k=0;k<listTxtDois.size();k++){ 
            if(listUser.get(i).getId().toString().trim().equals(listTxtDois.get(k).trim())){
                listUserOrganizados.add(listUser.get(i));
                break;
            }
           }
        }
       
        // O restante vai sendo inserido no que sobrou
        
        
        listUser.removeAll(listUserOrganizados);
        listUserOrganizados.addAll(listUser);
        
        return listUserOrganizados;
    }
}

