<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Electrocardiograma_de_reposo extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('electrocardiograma_de_reposo.*');
        $this->db->from('electrocardiograma_de_reposo');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');

        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('electrocardiograma_de_reposo.*');
        $this->db->from('electrocardiograma_de_reposo');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');
        $this->db->like($field, $value);

        $query = $this->db->get();
        return $query->result();
    }
    
    function allWhere($field, $value) {
        $this->db->select('electrocardiograma_de_reposo.*');
        $this->db->from('electrocardiograma_de_reposo');        
        $this->db->where($field, $value);

        $query = $this->db->get();
        return $query->result();
    }
    function allWhereArray($where) {
        $this->db->select('electrocardiograma_de_reposo.*');
        $this->db->from('electrocardiograma_de_reposo');        
        $this->db->where($where);

        $query = $this->db->get();
        return $query->result();
    }

    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('electrocardiograma_de_reposo')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('electrocardiograma_de_reposo');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('electrocardiograma_de_reposo');
    }

}