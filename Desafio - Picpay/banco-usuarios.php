<?php
// Aqui estão especificadas as funções de acesso ao banco de dados.


// Função responsável pela pesquisa dos usuários no banco de dados.
function pesquisaUsuario($palavraChave, $offset) {
    
    try{
        $query = "select * from users where nome like '%{$palavraChave}%' and  login like '%{$palavraChave}%' ORDER BY `users`.`prioridade` ASC limit 15 offset {$offset}";

        $db = new db();
        $db = $db->connect();
        $resultado = $db->query($query);
       
        $usuarios = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
        return $usuarios;
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
}

// Função responsável por setar as prioridades de acordo com as listas enviadas.
function setPrioridade($listaIDS, $prioridade){
    try{        

        $db = new db();
        $db = $db->connect();
               
        foreach($listaIDS as $id){
            $size = strlen($id);
            $id = substr($id,0, $size-1);
            $query = "update users set prioridade = {$prioridade} where ID = '{$id}'";
            $db->query($query);
        }
     } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

}

// Função responsável pelo Login no sistema.
function buscaAdmin($email, $senha){
   
    try{
       
        $db = new db();
        $db = $db->connect();    
        $senhaCrip = md5($senha);
	  
	    $query = "select * from administradores where email='{$email}' and senha='{$senhaCrip}'"; 	   
	    $resultado = $db->query($query);         
        $usuario = $resultado->fetchAll(PDO::FETCH_ASSOC);

        $db = null;
        return $usuario;
        
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
}


