<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');

    }

    public function lista_usuario($val, $pag) {

        $scfr = (!isset($_SESSION['Total'])) ? ' SQL_CALC_FOUND_ROWS ' : NULL;

        $query = $this->db->query('
            SELECT
                ' . $scfr. ' U.ID, U.Nome, U.Username
            FROM
                users AS U,
                lista1 AS L1
            WHERE
                (U.Nome LIKE "%'.$val.'%"
                    OR U.Username LIKE "%'.$val.'%")
                    AND U.ID = L1.ID

            UNION ALL

            SELECT
                U.ID, U.Nome, U.Username
            FROM
                users AS U,
                lista2 AS L2
            WHERE
                (U.Nome LIKE "%'.$val.'%"
                    OR U.Username LIKE "%'.$val.'%")
                    AND U.ID = L2.ID

            UNION ALL

            SELECT
                U.ID, U.Nome, U.Username
            FROM
                users AS U
                    LEFT JOIN lista1 AS L1 ON U.ID = L1.ID
                    LEFT JOIN lista2 AS L2 ON U.ID = L2.ID
            WHERE
                (U.Nome LIKE "%'.$val.'%"
                    OR U.Username LIKE "%'.$val.'%")
                    AND L1.ID IS NULL
                    AND L2.ID IS NULL

            LIMIT 15 OFFSET '.(15*$pag).'
        ');

        if(!isset($_SESSION['Total'])) {
            $t = $this->db->query('
                SELECT FOUND_ROWS() AS Total
            ');
            $_SESSION['Total'] = $query->Total = $t->result()[0]->Total;
        }
        else
            $query->Total = $_SESSION['Total'];

        /*
        #echo $this->db->last_query();
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit();
        #*/

        return $query;

    }
}
