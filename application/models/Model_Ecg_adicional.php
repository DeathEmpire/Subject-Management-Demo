<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Ecg_adicional extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('ecg_adicional.*');
        $this->db->from('ecg_adicional');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');

        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('ecg_adicional.*');
        $this->db->from('ecg_adicional');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');
        $this->db->like($field, $value);

        $query = $this->db->get();
        return $query->result();
    }
    
    function allWhere($field, $value) {
        $this->db->select('ecg_adicional.*');
        $this->db->from('ecg_adicional');        
        $this->db->where($field, $value);

        $query = $this->db->get();
        return $query->result();
    }
    function allWhereArray($where) {
        $this->db->select('ecg_adicional.*');
        $this->db->from('ecg_adicional');        
        $this->db->where($where);

        $query = $this->db->get();
        return $query->result();
    }

    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('ecg_adicional')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('ecg_adicional');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('ecg_adicional');
    }

}