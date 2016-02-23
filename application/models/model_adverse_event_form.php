<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Adverse_event_form extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('adverse_event_form.*');
        $this->db->from('adverse_event_form');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');

        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('adverse_event_form.*');
        $this->db->from('adverse_event_form');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');
        $this->db->like($field, $value);

        $query = $this->db->get();
        return $query->result();
    }
    
    function allWhere($field, $value) {
        $this->db->select('adverse_event_form.*');
        $this->db->from('adverse_event_form');        
        $this->db->where($field, $value);

        $query = $this->db->get();
        return $query->result();
    }

    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('adverse_event_form')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('adverse_event_form');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('adverse_event_form');
    }

}