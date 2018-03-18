<?php

App::uses('AppController', 'Controller');


class UsuariosController extends AppController {

	public $uses = array('Usuario');
	public $components = array('RequestHandler');

	public function listaUsuarios (	){
		
		$this->autoRender = false;
		$conditions = array();
		
		return $this->buscar($this->request['id'], $this->request['limit1'], $this->request['limit2']);
	}

	private function buscar($busca, $limite1, $limite2){
		
		$listaUsuarios = array();
		
		$arquivo = fopen ('../../banco/users.csv', 'r');
		
		while(!feof($arquivo))
		{
			$linha = fgets($arquivo, 1024);
			
			if (strpos(strtoupper($linha), strtoupper($busca))){
				
				$u = split(',', $linha);
				
				$listaUsuarios[] = array('chave'=> $u[0],'nome'=> $u[1],'login'=> $u[2]);
				
			}	
		}
		fclose($arquivo);
		
		$this->ordenaPrioridade($listaUsuarios);
		
		return json_encode($listaUsuarios);
		
		return json_encode(array_slice($listaUsuarios, $limite1-1, $limite2-1));
	}
	
	private function ordenaPrioridade(&$usuarios){
		
		$relev1 = file_get_contents ('../../banco/relevancia1.txt');
		$relev2 = file_get_contents ('../../banco/relevancia2.txt');
		
		foreach ($usuarios as &$us){
			
			if($this->containsWord($relev1, $us['chave'])){
				$us['prioridade'] = 1;
			}else if ($this->containsWord($relev2, $us['chave'])){
				$us['prioridade'] = 2;
			}else{
				$us['prioridade'] = 3;
			}
		}
		
		function cmp($a, $b){
			return $a['prioridade'] > $b['prioridade'];
		}
		
		function cmp2($a, $b){
			return strcmp($a['nome'], $b['nome'])> 0;
		}
		usort($usuarios, "cmp2");		
		usort($usuarios, "cmp");		
	}
	
	private function containsWord($str, $word){
		
		return !!preg_match('#\\b' . preg_quote($word, '#') . '\\b#i', $str);
		
	}
	
	public function index(){
		$this->layout = 'site';
	}
}

