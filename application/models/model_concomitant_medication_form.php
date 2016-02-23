<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Concomitant_medication_form extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('concomitant_medication_form.*');
        $this->db->from('concomitant_medication_form');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');

        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('concomitant_medication_form.*');
        $this->db->from('concomitant_medication_form');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');
        $this->db->like($field, $value);

        $query = $this->db->get();
        return $query->result();
    }

    function allWhere($field, $value) {
        $this->db->select('concomitant_medication_form.*');
        $this->db->from('concomitant_medication_form');        
        $this->db->where($field, $value);

        $query = $this->db->get();
        return $query->result();
    }

    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('concomitant_medication_form')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('concomitant_medication_form');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('concomitant_medication_form');
    }

}