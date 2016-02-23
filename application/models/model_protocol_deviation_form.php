<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Protocol_deviation_form extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('protocol_deviation_form.*');
        $this->db->from('protocol_deviation_form');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');

        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('protocol_deviation_form.*');
        $this->db->from('protocol_deviation_form');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');
        $this->db->like($field, $value);

        $query = $this->db->get();
        return $query->result();
    }

    function allWhere($field, $value) {
        $this->db->select('protocol_deviation_form.*');
        $this->db->from('protocol_deviation_form');        
        $this->db->where($field, $value);

        $query = $this->db->get();
        return $query->result();
    }

    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('protocol_deviation_form')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('protocol_deviation_form');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('protocol_deviation_form');
    }

}