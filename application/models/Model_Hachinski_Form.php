<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Hachinski_Form extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('hachinski_form.*');
        $this->db->from('hachinski_form');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');

        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('hachinski_form.*');
        $this->db->from('hachinski_form');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');
        $this->db->like($field, $value);

        $query = $this->db->get();
        return $query->result();
    }

    function allWhere($field, $value) {
        $this->db->select('hachinski_form.*');
        $this->db->from('hachinski_form');        
        $this->db->where($field, $value);

        $query = $this->db->get();
        return $query->result();
    }

    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('hachinski_form')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('hachinski_form');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('hachinski_form');
    }

}