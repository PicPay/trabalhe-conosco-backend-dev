<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (! $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Efetue o seu Login!');
            redirect();
        }
    }

    public function index()
    {
        $this->load->view('panel/index');
    }

}

/* End of file: Panel.php */
