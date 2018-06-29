<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Basico_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');

    }

    public function get_calendario($CategoriaCodigo) {

        $query = $this->db->query('SELECT * FROM Tab_Calendario WHERE CategoriaCodigo = ' . $CategoriaCodigo);
        $query = $query->result_array();
        return $query;

    }

    public function select_table_dropdown($table, $aux = FALSE, $data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_' . $table . ' ORDER BY ' . $table . ' ASC');
        }
        else {
            $query = $this->db->query('SELECT * FROM Tab_' . $table . ' ORDER BY ' . $table . ' ASC');

            $array = array();

            if($aux) {
                foreach ($query->result_array() as $row)
                    $array[$row[$table.$aux]] = $row[$table];
            }
            else {
                foreach ($query->result_array() as $row)
                    $array[$row['idTab'.$table]] = $row->Uf;
            }

        }

        return $array;

    }

    public function select_form($prefixo, $sufixo, $bool = FALSE) {

        if ($bool === TRUE) {
            $array = $this->db->query('SELECT * FROM ' . $prefixo . '_' . $sufixo . ' ORDER BY ' . $sufixo . ' ASC');
        }
        else {
            $query = $this->db->query('SELECT * FROM ' . $prefixo . '_' . $sufixo . ' ORDER BY ' . $sufixo . ' ASC');

            /*
            echo $this->db->last_query();
            print "<pre>";
            print_r($query);
            print "</pre>";
            #*/

            $id = 'id'.$prefixo.'_'.$sufixo;
            $array = array();
            foreach ($query->result() as $row)
                $array[$row->$id] = $row->$sufixo;

        }

        return $array;

    }

    public function select_item($modulo, $tabela, $campo = FALSE, $campoitem = FALSE) {

        if ($campo !== FALSE) {
            $query = $this->db->query('SELECT id' . $modulo . '_' . $tabela . ' AS Id, ' . $tabela . ' AS Item FROM '
                    . '' . $modulo . '_' . $tabela . ' '
                    . 'WHERE ' . $campo . ' = "' . $campoitem . '" ORDER BY ' . $tabela . ' ASC');
        }
        else {
            $query = $this->db->query('SELECT id' . $modulo . '_' . $tabela . ' AS Id, ' . $tabela . ' AS Item FROM '
                    . '' . $modulo . '_' . $tabela . ' ORDER BY ' . $tabela . ' ASC');
        }

        if ($query->num_rows() == 0) {
            return FALSE;
        }
        else {
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Id] = $row->Item;
            }

            /*
              echo $this->db->last_query();
              echo '<br>';
              echo "<pre>";
              print_r($array);
              echo "</pre>";
              exit();
             */

            return $array;
        }

    }

    public function select_nacionalidade() {

        $query = $this->db->query('SELECT * FROM Tabela_Nacionalidade ORDER BY Nacionalidade ASC');

        $array = array();
        $array[0] = ':: SELECIONE ::';
        foreach ($query->result() as $row) {
            $array[$row->idTabela_Nacionalidade] = $row->Nacionalidade;
        }

        return $array;

    }

    public function select_estado_civil($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tabela_EstadoCivil ORDER BY EstadoCivil ASC');
        }
        else {
            $query = $this->db->query('SELECT * FROM Tabela_EstadoCivil ORDER BY EstadoCivil ASC');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTabela_EstadoCivil] = $row->EstadoCivil;
            }
        }

        return $array;

    }

    public function select_uf($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tabela_Uf ORDER BY Uf ASC');
        }
        else {
            $query = $this->db->query('SELECT * FROM Tabela_Uf ORDER BY Uf ASC');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTabela_Uf] = $row->Uf;
            }
        }

        return $array;

    }

    public function select_municipio($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tabela_Municipio ORDER BY NomeMunicipio ASC');
        }
        else {
            $query = $this->db->query('SELECT * FROM Tabela_Municipio ORDER BY NomeMunicipio ASC');

            $array = array();
            #$array[0] = ':: SELECIONE ::';
            foreach ($query->result() as $row) {
                $array[$row->idTabela_Municipio] = $row->NomeMunicipio;
            }
        }

        return $array;

    }

    public function select_cor($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tabela_Cor ORDER BY Cor ASC');
        }
        else {
            $query = $this->db->query('SELECT * FROM Tabela_Cor ORDER BY Cor ASC');

            $array = array();
            #$array[0] = ':: SELECIONE ::';
            foreach ($query->result() as $row) {
                $array[$row->idTabela_Cor] = $row->Cor;
            }
        }

        return $array;

    }

    public function select_grau_instrucao($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tabela_GrauInstrucao ORDER BY GrauInstrucao ASC');
        }
        else {
            $query = $this->db->query('SELECT * FROM Tabela_GrauInstrucao ORDER BY GrauInstrucao ASC');

            $array = array();
            #$array[0] = ':: SELECIONE ::';
            foreach ($query->result() as $row) {
                $array[$row->idTabela_GrauInstrucao] = $row->GrauInstrucao;
            }
        }

        return $array;

    }

    function set_auditoria($auditoriaitem, $tabela, $operacao, $data, $usuario = FALSE) {

        (isset($_SESSION['log']['id'])) ? $usuario = $_SESSION['log']['id'] : $usuario = 18;

        $auditoria = array(
            'Tabela' => $tabela,
            'idSis_Usuario' => $usuario,
            'DataAuditoria' => date('Y-m-d H:i:s', time()),
            'Operacao' => $operacao,
            'Ip' => $this->input->ip_address(),
            'So' => $this->agent->platform(),
            'Navegador' => $this->agent->browser(),
            'NavegadorVersao' => $this->agent->version(),
        );

        /*
        echo "<pre>";
        print_r($auditoria);
        echo "</pre>";
        echo "<pre>";
        print_r($auditoriaitem);
        echo "</pre>";
        #exit();
        */

        if ($this->db->insert('Sis_Auditoria', $auditoria)) {
            $i = 0;

            for ($i=0; $i < count($auditoriaitem); $i++)
                $auditoriaitem[$i]['idSis_Auditoria'] = $this->db->insert_id();

            $this->db->insert_batch('Sis_AuditoriaItem', $auditoriaitem);
        }

    }

    /*
    Faz uma contagem de acordo com a tabela e campo indicados
    O parâmetro $null serve para casos em que houver possibilidade de contagem
        de campos que contenham valores do tipo NULL. Isso permite substituir o
        NULL para algum valor específico.
    */
    public function count_tratamento_group_by($table, $field, $null = NULL) {

        $query = $this->db->query(
            'SELECT
                ' . $field . ',
                COUNT(*) AS Count
            FROM
                ' . $table . '
            GROUP BY
                ' . $field
        );

        $array = array();
        foreach ($query->result() as $row) {
            $row->$field = ($row->$field) ? $row->$field : $null;
            $array[$row->$field] = $row->Count;
        }
        return $array;

    }

}
