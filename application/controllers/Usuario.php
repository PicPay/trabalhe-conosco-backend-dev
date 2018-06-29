<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries

        $this->load->model(array('Usuario_model', 'Basico_model'));
        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library(array('basico', 'form_validation', 'user_agent'));
        $this->load->driver('session');

        #load header view
        $this->load->view('sistema/basico/header');
        $data['nav_principal'] = $this->load->view('sistema/basico/nav_principal', NULL, TRUE);
        $this->load->view('sistema/basico/nav_principal', $data);

    }

    public function pesquisar() {

        $data['titulo'] = "Pesquisar Usuario";

        $this->load->library('pagination');

        $config['per_page'] = 15;
        $config["uri_segment"] = 4;
        $config['reuse_query_string'] = TRUE;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['attributes'] = array('class' => 'page-link');

        $config['full_tag_open'] = '<nav aria-label="Paginação"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</li>';

        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';

        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tagl_close'] = '</li>';

        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</li>';

        if ($this->uri->segment(3))
            $data['Pesquisa'] = $this->uri->segment(3);
        else {
            if($this->input->post('Pesquisa')){
                $data['Pesquisa'] = $this->input->post('Pesquisa');
                unset($_SESSION['Total']);
            }
            else
                $data['Pesquisa'] = '';
        }

        $data['Pagina'] = ($this->uri->segment(4)) ? $this->uri->segment(4)-1 : 0;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        #run form validation
        if ($this->form_validation->run() === FALSE && !$this->uri->segment(3)) {
            $this->load->view('sistema/usuario/pesq_usuario', $data);
        }
        else {

            $data['query'] = $this->Usuario_model->lista_usuario($data['Pesquisa'], $data['Pagina']);

            $config['base_url'] = base_url() . 'usuario/pesquisar/' . $data['Pesquisa'] . '/';
            $config['total_rows'] = $data['query']->Total;
            $this->pagination->initialize($config);

            $data['pagination'] = $this->pagination->create_links();

            /*
            #echo $this->db->last_query();
            echo "<pre>";
            print_r($data['pagination']);
            echo "</pre>";
            #exit();
            #*/

            $data['lista'] = $this->load->view('sistema/usuario/lista_usuario', $data, TRUE);
            $this->load->view('sistema/usuario/pesq_usuario', $data);

        }

        $this->load->view('sistema/basico/footer');
    }

}
