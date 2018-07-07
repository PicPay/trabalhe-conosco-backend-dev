<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Picpay extends CI_Controller {


	function __construct(){
		parent::__construct();
		//$this->db_usuarios = ci()->db_no_index;

	}

	function get_session_login(){
		//pega os dados da sessao e guarda para usamos quando precisarmos identificar o usuario
		ci()->login_ok = $this->session->userdata('login');
	}
	public function index()
	{
		$msg = false;
		$password = $this->input->post('password');
		$username = $this->input->post('username');

		//verificar se os dados que o usuario informou sao validos
		if($username == true and $password == true){
			$password = md5($password);
			$login = $this->picpay_model->verifica_login($username,$password);
			
			// caso os dados esteja ok criamos a sessao login 
			if($login){
			
				$session_data = [
					'username' => $username,
					'id'=>$login
				];
				$this->session->set_userdata('login',$session_data);	
					
			}else{
				//Setar messagem de erro para printar na tela
				$msg = [
					'error'=>1,
					'message'=>'Login e senha não confere!'
				];
			}
		}


		//verificar se nao usuario esta logado
		if(!$this->session->userdata('login')){
			ci()->tela = 'login';//se o usuario não estiver logado setar a tela de login
		}else{
			ci()->tela = 'area-membros';
		}
		$this->get_session_login();



		$prioridade_maxima = [];
		$prioridade_minima = [];
		$outros = [];

		$busca = $this->input->get('busca');

		//Buscar usuarios
		$usuarios = $this->picpay_model->get_usuarios($busca);

		//SApenas separando os dados para melhor identificação
		foreach($usuarios as $item){

			if($item->Prioridade == 1){
				$prioridade_maxima[] = $item;
			}elseif($item->Prioridade == 0){
				$prioridade_minima[] = $item;
			}else{
				$outros[] = $item;
			}
		}
	


		$this->load->view('estrutura',[
			'list' => [
				'prioridade_maxima'=> $prioridade_maxima,
				'prioridade_minima'=> $prioridade_minima,
				'outros' => $outros
			],
			'msg'=>$msg
		]);
	}

	

	//deslogar o usuario
	function logout(){
		$this->session->unset_userdata('login');
		redirect('/home');
	}

	/*
		chama a tela de instrucões 
			pelo fato que a criação de uma tabela com indeces com
			um numero de dados tao grande criei essa dela para auxiliar
			na instalação da tabela com indices, pois ate entao a aplicação 
			deve esta funcionando com uma tabela provisoria sem indices

	*/
	function instrucoes(){
		ci()->tela = 'instrucoes';
		$this->load->view('estrutura');
	}
	/*
		chamar funcões de remove a tabela de usuario provisoria
	*/

	function remove_tabela_provisoria(){
		remove_tabela_provisoria();
	}
}
