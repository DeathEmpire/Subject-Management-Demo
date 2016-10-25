<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Lista_correos extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $query = $this->db->get('lista_correos');
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->like($field, $value);
        $query = $this->db->get('lista_correos');
        // return $query->result();
        return $query->row();
    }
	function allFiltered2($field, $value) {
        $this->db->like($field, $value);
        $query = $this->db->get('lista_correos');
        return $query->result();        
    }
	function allFilteredWhere($where){
		$this->db->select('*');
        $this->db->from('lista_correos');		
		$this->db->where($where);		
		$query = $this->db->get();
        return $query->row();
	}
    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('lista_correos')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('lista_correos');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('lista_correos');
    }

    function delete($id) {
    	$this->db->where('id', $id);
		$this->db->delete('lista_correos');
    }

}
