<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login($email, $senha)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $this->db->where('senha', $senha);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();;
    }

}

/* End of file: User.php */
