<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Picpay_model extends CI_Model {


    function __construct(){
        $this->limit = ci()->limit;
        $this->db_usuarios = ci()->db_usuarios;

    }
    function get_data(){

    }



	function get_usuarios($busca){

		$inicio = 0;
		$pagina = 1;
		$get = $this->input->get('pg');
		if($get and $get > 0){
			$pagina = $get;
		}
		$inicio = $this->limit*($pagina-1);
		$add = [];

        //Buscar dados da tebela de releancia
		if($busca){
			$db = ci()->db;
			$lista = $db;
			$lista->join('lista_relevancia l1','l1.Id = u.Id');
			$lista->like('Nome',$busca);
			$lista->or_like('Username',$busca);
			
			$lista->order_by('relevancia desc, Nome asc');
			$lista->limit($this->limit,$inicio);
			$_lista = $lista->get($this->db_usuarios.' u');
			
			foreach($_lista->result() as $item){
                $item->Prioridade = $item->relevancia;

				$add[] = $item;
            }
            
            $count = count($add);
            $this->limit -= count($add);
         

		}

	
		if($this->limit > 0){
			
			$inicio = 0;
			$pagina = 1;
			$get = $this->input->get('pg');
			if($get and $get > 0){
				$pagina = $get;
			}
			$inicio = $this->limit*($pagina-1);

            $num_pagina_anterior = 0;
            
			if($pagina > 1 and $busca){
                
                /**/
				
				$db = ci()->db;
				$count1 = $db;
				$count1->join('lista_relevancia l1','l1.Id = u.Id');
                $count1->like('Nome',$busca);
                $lista->or_like('Username',$busca);
				$lista->order_by('Nome asc');	
				$count1->select('1');
				$_count1 = $count1->get($this->db_usuarios.' u');
				$num_pagina_anterior = $_count1 = count($_count1->result());

				
            }
            
            $limit = ci()->limit;

			$db = ci()->db;
			$lista = $db;
			if($busca){
				$lista->like('Nome',$busca);
                $lista->or_like('Username',$busca);
			}

            $inicio = 0;
			$pagina = 1;
			$get = $this->input->get('pg');
			if($get and $get > 0){
				$pagina = $get;
			}
			$inicio = $this->limit*($pagina-1);

            
            if($this->limit != $limit){
                $inicio = $num_pagina_anterior;
            }
            if($inicio == 0){
                $inicio += count($add);
            }

			$lista->order_by('Nome asc');
			$lista->limit($this->limit,0+$inicio);
			$_lista = $lista->get($this->db_usuarios.' u');
			
			foreach($_lista->result() as $item){
				$item->Prioridade = -1;
				$add[] = $item;
			}
		}
		
        ci()->pg = $pagina;

		return $add;
    }
   
    function api_code($code=null){

        if($code==null){
        
            if(!isset(ci()->login_ok) or !isset(ci()->login_ok['id'])){
                return '';
            }
        }
        $api = ci()->db;
        if($code==null){
            $api->where('id',ci()->login_ok['id']);
        }else{
            $api->where('api_code',$code);
        }
        
        $api=$api->get('acesso');

        return count($api->row())?$api->row()->api_code:false;
    }
    function verifica_login($username,$senha){
        $usuario = $this->db;
        $usuario->where('login',$username);
        $usuario->where('password',$senha);
        $usuario=$usuario->get('acesso');
        return count($usuario->row())?$usuario->row()->id:false;
    }
    
}