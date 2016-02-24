<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Opciones_Perfil extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $query = $this->db->get('opciones_perfil');
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->like($field, $value);
        $query = $this->db->get('opciones_perfil');
        return $query->result();
    }

    function allWhere($where){
        $this->db->where($where);
        $query = $this->db->get('opciones_perfil');
        return $query->result();   
    }

    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('opciones_perfil')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('opciones_perfil');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('opciones_perfil');
    }

    function delete($id) {
    	$this->db->where('id', $id);
		$this->db->delete('opciones_perfil');
    }

}
