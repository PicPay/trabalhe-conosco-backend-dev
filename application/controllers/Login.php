<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Login_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('basico', 'form_validation', 'user_agent'));
        $this->load->driver('session');

        if ($this->agent->is_browser()) {

            if (
                    (preg_match("/(chrome|Firefox)/i", $this->agent->browser()) && $this->agent->version() < 30) ||
                    (preg_match("/(safari)/i", $this->agent->browser()) && $this->agent->version() < 6) ||
                    (preg_match("/(opera)/i", $this->agent->browser()) && $this->agent->version() < 12) ||
                    (preg_match("/(internet explorer)/i", $this->agent->browser()) && $this->agent->version() < 9 )
            ) {
                $msg = '<h2><strong>Navegador não suportado.</strong></h2>';

                echo $this->basico->erro($msg);
                exit();
            }
        }

    }

    public function index() {

        $_SESSION['log']['modulo'] = 'Picpay';

        ###################################################
        #só pra eu saber quando estou no banco de testes ou de produção
        $CI = & get_instance();
        $CI->load->database();
        ###################################################
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #Get GET or POST data
        $usuario = $this->input->get_post('usuario');
        #$senha = md5($this->input->get_post('senha'));
        $senha = password_hash($this->input->get_post('senha'), PASSWORD_DEFAULT, ['cost' => 11]);

        #set validation rules
        $this->form_validation->set_rules('usuario', 'Usuário', 'required|trim|callback_valid_usuario');
        $this->form_validation->set_rules('senha', 'Senha', 'required|trim|callback_valid_senha[' . $usuario . ']');

        #load header view
        $this->load->view('sistema/basico/headerlogin');

        if ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Sua sessão expirou. Faça o login novamente.</strong>', 'erro', FALSE, FALSE, FALSE);
        else
            $data['msg'] = '';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('form_login', $data);
        }
        else {

            session_regenerate_id(true);

            #if ($this->Login_model->check_ativo($usuario, $data['modulo']) === FALSE) {
            if ($this->Login_model->check_ativo($usuario) === FALSE) {
                #$msg = "<strong>Senha</strong> incorreta ou <strong>usuário</strong> inexistente.";
                #$this->basico->erro($msg);
                $data['msg'] = $this->basico->msg('<strong>Usuário não possui autorização para acessar este módulo.</strong>', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('form_login', $data);
            }
            else {
                #initialize session
                $this->load->driver('session');

                #$query = $this->Login_model->get_usuario($usuario, $data['modulo']);
                $query = $this->Login_model->get_usuario($usuario);

                $_SESSION['log']['usuario'] = $query['Usuario'];
                #$_SESSION['log']['nivel'] = $query['Nivel'];
                $_SESSION['log']['id'] = $query['idSis_Usuario'];
                #$_SESSION['log']['modulo'] = $data['modulo'];
                #$_SESSION['log']['idmodulo'] = $query['Modulo'];

                $this->load->database();
                $_SESSION['db']['hostname'] = $this->db->hostname;
                $_SESSION['db']['username'] = $this->db->username;
                $_SESSION['db']['password'] = $this->db->password;
                $_SESSION['db']['database'] = $this->db->database;

                if ($this->Login_model->set_acesso($_SESSION['log']['id'], 'LOGIN') === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('form_login');
                }
                else {
                    redirect($data['modulo'] . '/usuario/pesquisar');
                }
            }
        }

        #load footer view
        $this->load->view('sistema/basico/footerlogin');
        #$this->load->view('sistema/basico/footer');

    }

    public function sair($m = TRUE) {
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #set logout in database
        if ($_SESSION['log'] && $m === TRUE) {
            $this->Login_model->set_acesso($_SESSION['log']['id'], 'LOGOUT');
        }
        else {
            if (!isset($_SESSION['log']['id'])) {
                $_SESSION['log']['id'] = 1;
            }
            $this->Login_model->set_acesso($_SESSION['log']['id'], 'TIMEOUT');
            $data['msg'] = '?m=2';
        }

        #clear de session data
        $this->session->unset_userdata('log');
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage

        /*
          #load header view
          $this->load->view('basico/headerlogin');

          $msg = "<strong>Você saiu do sistema.</strong>";

          $this->basico->alerta($msg);
          $this->load->view('login');
          $this->load->view('basico/footer');
         *
         */

        redirect(base_url() . $data['msg']);
        #redirect('login');

    }

    function valid_usuario($data) {

        if ($this->Login_model->check_usuario($data) == FALSE) {
            $this->form_validation->set_message('valid_usuario', '<strong>%s</strong> não existe.');
            return FALSE;
        }
        else if ($this->Login_model->check_usuario($data) == 1) {
            $this->form_validation->set_message('valid_usuario', '<strong>%s</strong> inativo.');
            return FALSE;
        }
        else {
            return TRUE;
        }

    }

    function valid_senha($senha, $usuario) {

        if ($this->Login_model->check_senha($senha, $usuario) == FALSE) {
            $this->form_validation->set_message('valid_senha', '<strong>%s</strong> senha incorreta.');
            return FALSE;
        }
        else {
            return TRUE;
        }

    }

}
