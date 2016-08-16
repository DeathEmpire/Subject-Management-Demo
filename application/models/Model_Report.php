<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Report extends CI_Model {

	function __construct() {
		parent::__construct();
    }



    function buscarPorTabla($tabla) {
        $this->db->select($tabla .'.*, subject.code');
        $this->db->from($tabla);
        $this->db->join('subject', $tabla .'.subject_id = subject.id', 'left');
        
        $centro = $this->session->userdata('center_id');
        if($centro != 'Todos'){
            $this->db->where('subject.center', $centro);
        }

        $this->db->order_by('subject.code ASC');

        $query = $this->db->get();
        return $query->result();
    }

    

}