<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Customers extends REST_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        
        parent::__construct();
        $this->load->model('customer');
    }

    public function index_post()
    {
        $data = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customer->count_all(),
            "recordsFiltered" => $this->customer->count_filtered(),
            "data" => $this->customer->get_data()
        );

        if ($data) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Nenhum usuário foi encontrado'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

}

/* End of file: Customers.php */
