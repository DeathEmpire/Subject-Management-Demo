<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Eq_5d_5l extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('eq_5d_5l.*');
        $this->db->from('eq_5d_5l');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');

        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('eq_5d_5l.*');
        $this->db->from('eq_5d_5l');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');
        $this->db->like($field, $value);

        $query = $this->db->get();
        return $query->result();
    }

    function allWhere($field, $value) {
        $this->db->select('eq_5d_5l.*');
        $this->db->from('eq_5d_5l');        
        $this->db->where($field, $value);

        $query = $this->db->get();
        return $query->result();
    }
    function allWhereArray($where) {
        $this->db->select('eq_5d_5l.*');
        $this->db->from('eq_5d_5l');        
        $this->db->where($where);

        $query = $this->db->get();
        return $query->result();
    }

    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('eq_5d_5l')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('eq_5d_5l');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('eq_5d_5l');
    }

}