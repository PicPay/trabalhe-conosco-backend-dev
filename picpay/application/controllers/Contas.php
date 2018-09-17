<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
    }

    public function index()
    {
        $this->load->view('contas/index');
    }

    public function entrar()
    {
        $this->form_validation->set_rules('email', 'E-mail', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() !== FALSE)
        {
            $email = $this->input->post('email');
            $password = md5($this->input->post('password'));
            
            $userdata = $this->user->login($email, $password);
            if ($userdata)
            {
                $data = array(
                    'user_id' => $userdata['id'],
                    'user_name' => $userdata['nome'],
                    'user_email' => $userdata['email']
                );
                $this->session->set_userdata($data);
                redirect('panel');
            }
            else
            {
                $this->session->set_flashdata('error', 'Usuário não encontrado!');
                redirect();
            }
        }
        else
        {
            $this->index();
        }
    }

    public function sair()
    {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('user_email');
        $this->session->sess_destroy();
        redirect();
    }

}

/* End of file: Account.php */
