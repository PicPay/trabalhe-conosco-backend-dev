<?php

App::uses('AppController', 'Controller');


class UsuariosController extends AppController {

	public $uses = array('Usuario');
	public $components = array('RequestHandler');

	public function listaUsuarios (	){
		
		$this->autoRender = false;
		return $this->buscar($this->request['id'], intval($this->request['limit1']), intval($this->request['limit2']));
	}

	private function buscar($busca, $limite1 = null, $limite2 = null){
		
		$listaUsuarios = array();
		
		$arquivo = fopen ('../../banco/users.csv', 'r');
		
		
		while(!feof($arquivo))
		{
			$linha = fgets($arquivo, 1024);
			
			if (strpos($linha, $busca)){
				
				$u = split(',', $linha);
				$listaUsuarios[] = array('chave'=> $u[0],'nome'=> $u[1],'login'=> $u[2]);
				
			}	
		}
		fclose($arquivo);
		
		$this->ordenaPrioridade($listaUsuarios);
		
		if ($limite1 != 0 &&  $limite2 != 0 )
			return json_encode(array_slice($listaUsuarios, $limite1-1, $limite2-1));
		
		
		return json_encode($listaUsuarios);
	}
	
	private function ordenaPrioridade(&$usuarios){
		
		$relev1 = file_get_contents ('../../banco/relevancia1.txt');
		$relev2 = file_get_contents ('../../banco/relevancia2.txt');
		
		foreach ($usuarios as &$us){
			
			if($this->containsWord($relev1, $us['chave'])){
				$us['p'] = 1;
			}else if ($this->containsWord($relev2, $us['chave'])){
				$us['p'] = 2;
			}else{
				$us['p'] = 3;
			}
			
			$sort_p[] = $us['p'];
			$sort_nome[] = $us['nome'];
			
		}
		
		array_multisort($sort_p, SORT_ASC,$sort_nome, SORT_STRING, $usuarios);
	}
	
	private function containsWord($str, $word){
		
		return !!preg_match('#\\b' . preg_quote($word, '#') . '\\b#i', $str);
		
	}
	
	public function index(){
		$this->layout = 'site';
	}
}

