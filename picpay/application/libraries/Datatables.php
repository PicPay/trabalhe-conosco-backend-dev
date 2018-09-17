<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datatables
{

    protected $CI;

    private $database;
    private $table;
    private $columns = [];

    public function __construct($db = null)
    {
        $this->CI = &get_instance();
    }

    public function getDatabase()
    {
        return $this->database;
    }

    public function setDatabase($database)
    {
        $this->database = $database;
    }

    public function getData($aTable = NULL, $aColumns = NULL)
    {
        // Load CI Database library
        $this->CI->load->database($this->database);

        // Read dataTables POST variables
        $iDraw = $this->CI->input->post('draw');
        $iColumns = $this->CI->input->post('columns');
        $iOrder = $this->CI->input->post('order');
        $iStart = $this->CI->input->post('start');
        $iLength = $this->CI->input->post('length');
        $iSearch = $this->CI->input->post('search');

         // Total rows in the table
        $recordsTotal = $this->CI->db->count_all($aTable);

         // Filtering
        // NOTE: This does not match the built-on DataTables filtering which does it
        // word by word on any field. It's possible to do here, but concerned about efficiency
        // on very large tables.
        $recordsFiltered = $recordsTotal;

        if (isset($iSearch) && $iSearch['value'] != '') {
            for ($i = 0; $i < count($aColumns); $i++) {
                $this->db->or_like($aColumns[$i], $iSearch['value']);
            }
            
            // Saves number of records that matches the query and filters
            $recordsFiltered = $this->db->count_all_results($aTable, false);
        }

        if (isset($iSearch) && $iSearch['value'] != '') {
            for ($i = 0; $i < count($aColumns); $i++) {
                $this->db->or_like($aColumns[$i], $iSearch['value']);
            }
        }

        // Write the SELECT portion of the query
        $this->CI->db->select(implode(',', $aColumns));
        
        // Ordering
        if (isset($iOrder)) {
            for ($i = 0; $i < count($iOrder); $i++) {
                $this->CI->db->order_by($aColumns[$iOrder[0]['column']], strtoupper($iOrder[0]['dir']));
            }
        } else {
            $this->CI->db->order_by($aColumns[0], 'ASC');
        }
        
        // Paging
        if (isset($iStart) && $iLength != '-1') {
            $this->CI->db->limit($iLength, $iStart);
        } else {
            $this->CI->db->limit(25, 1);
        }

        // Select Data
        $Data = $this->CI->db->get($aTable);

        $output = array(
            "draw" => isset($iDraw) ? $iDraw : 1,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $Data->result()
        );

        return $output;
    }

}

/* End of file: Datatables.php */
