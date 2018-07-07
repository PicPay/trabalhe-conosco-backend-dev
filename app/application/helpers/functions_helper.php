<?php 

function ci(){

    $ci = &get_instance();
    $ci->load->database();

    $ci->login_ok = false;
	$ci->limit = 8;

    get_session_login($ci);
    $ci->db_no_index = 'usuarios_sem_indice';

    if(indices($ci)){
        
        $ci->db_usuarios = 'usuarios';

    }else{
        $ci->no_index = true;
    
        $ci->db_usuarios = $ci->db_no_index;
    }

    $ci->api_code = '';
    
    return $ci;
}


function get_session_login($ci){
    $ci->login_ok = $ci->session->userdata('login');
}

function html_paginacao(){
    $busca = ci()->input->get('busca');

    $pagina = 1;
    $get = ci()->input->get('pg');
    if($get and $get > 0){
        $pagina = $get;
    }

    $get_busca = '';
    $get_pg = $busca?'&':'';
    $link = base_url().'?%s%s';

    if($pagina > 1){
        $get_pg .= 'pg='.($pagina+1);
    }elseif($pagina < 0){
        $get_pg .= 'pg='.(1);
    }else{
        $get_pg .= 'pg='.(2);
    }

    if($busca){
        $get_busca = 'busca='.$busca;
    }

    $proxima_pagina = sprintf($link,$get_busca,$get_pg);


    $get_busca = '';
    $get_pg = $busca?'&':'';
    $link = base_url().'?%s%s';
    $disable = '';

    if($pagina > 1){
        $get_pg .= 'pg='.($pagina-1);
    }else{
        $get_pg = '';
        $disable = 'disabled';
    }

    if($busca){
        $get_busca = 'busca='.$busca;
    }


    $pagina_anterior = sprintf($link,$get_busca,$get_pg);

    $html = '
    <div>
      <ul class="pagination pagination-lg pull-left">
        <li class="page-item '.$disable.'">
          <a class="page-link" href="'.$pagina_anterior.'">&laquo;</a>
        </li>
      </ul>


      <ul class="pagination pagination-lg  pull-right">
       
        <li class="page-item pull-right">
          <a class="page-link" href="'.$proxima_pagina.'">&raquo;</a>
        </li>
      </ul>
    </div>';

    return $html;
}

function indices($ci){
    
   $indices = $ci->db;
   $indices->limit(1);
   $indices=$indices->get('usuarios');
   
   $count = count($indices->row());
   
   if(!$count){file_put_contents(FCPATH.'/db/indices.txt',0);}

   return $count;
}


function remove_tabela_provisoria(){
    $indices = ci()->db;
   
    $remove = $indices->query('DROP table usuarios_sem_indice');
    if($remove){
        unlink(FCPATH.'/db/indices.txt');
    }

    redirect('/');
}
function getuniq($num){
    
    return substr(md5(uniqid()),-$num);
}
function uuid(){
    return sprintf('%s-%s-%s-%s-%s',
            getuniq(8),
            getuniq(4),
            getuniq(4),
            getuniq(4),
            getuniq(12));
}
?>