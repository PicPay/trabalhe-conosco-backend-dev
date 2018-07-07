<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {


	function __construct(){
		parent::__construct();

	}


    function index(){

        //tela com exemplo de uso da api
        ci()->tela = 'api';
		$this->load->view('estrutura',[
			
		]);
    }


    function usuarios($api_code=false){
        header("Content-Type: application/json");

        $api_code = ci()->picpay_model->api_code($api_code);

        if(!$api_code){
            echo json_encode([
                'erro'=>'Token informado não possui acesso ou esta incorreto!'
            ]);
           return;
        }
		$prioridade_maxima = [];
		$prioridade_minima = [];
		$outros = [];



        $busca = ci()->input->get('busca');
        $usuarios = $this->picpay_model->get_usuarios($busca);

        $rest = [];

        //Apenas separando os dados para melhor identificação 
        foreach($usuarios as $item){
	
            if($item->Prioridade == 1){
                $prioridade_maxima[] = $item;
            }elseif($item->Prioridade == 0){
                $prioridade_minima[] = $item;
            }else{
                unset($item->Prioridade);
                $outros[] = $item;
            }
        }

        $resultado = [
            'prioridade_maxima'=> $prioridade_maxima,
            'prioridade_minima'=> $prioridade_minima,
            'outros' => $outros,
            'pagina'=>ci()->pg
        ];


        echo json_encode($resultado);
    }
    function check_api_code(){

    }
}