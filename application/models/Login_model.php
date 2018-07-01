<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');

    }

    public function check_usuario($usuario) {

        $query = $this->db->query('SELECT Inativo FROM Sis_Usuario WHERE Usuario = "' . $usuario . '"');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
         */

        if ($query->num_rows() === 0)
            return FALSE;
        else {
            $query = $query->result_array();

            if ($query[0]['Inativo'] == 1)
                return 1;
            else
                return 2;
        }

    }

    public function check_senha($senha, $usuario) {

        $query = $this->db->query('SELECT idSis_Usuario, Senha FROM Sis_Usuario WHERE '
                . 'Usuario = "' . $usuario . '"');

        #echo $this->db->last_query();
        #exit();
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
         */

        if ($query->num_rows() === 0)
            return FALSE;
        else {
            $query = $query->result_array();

            if (password_verify($senha, $query[0]['Senha']))
                return TRUE;
            else
                return FALSE;
        }

    }

    public function check_ativo($usuario, $modulo = FALSE) {

        $query = $this->db->query('
            SELECT
                U.idSis_Usuario
            FROM
                Sis_Usuario AS U
            WHERE
                U.Usuario = "' . $usuario . '"
        ');

        #echo $this->db->last_query();
        #exit();
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
         */

        if ($query->num_rows() === 0)
            return FALSE;
        else
            return TRUE;

    }

    public function get_usuario($usuario, $modulo = FALSE) {

        $query = $this->db->query('
            SELECT
                U.idSis_Usuario,
                U.Usuario
            FROM
                Sis_Usuario AS U
            WHERE
                U.Usuario = "' . $usuario . '"
        ');

        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
         */

        if ($query->num_rows() === 0)
            return FALSE;
        else {
            $query = $query->result_array();
            return $query[0];
        }

    }

    public function set_acesso($usuario, $operacao) {

        $usuario = (!$usuario || !isset($usuario) || $usuario == NULL) ? 1 : $usuario;
        $modulo = $_SESSION['log']['modulo'];

        $data = array(
            'Data' => date('Y-m-d H:i:s'),
            'Operacao' => $operacao,
            'idSis_Usuario' => $usuario,
            'Ip' => $this->input->ip_address(),
            'So' => $this->agent->platform(),
            'Navegador' => $this->agent->browser(),
            'NavegadorVersao' => $this->agent->version(),
            'SessionId' => session_id(),
        );

        $query = $this->db->insert('Sis_AuditoriaAcesso', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            return TRUE;
        }

    }

}
