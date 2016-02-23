<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_To_do extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('to_do.*');
        $this->db->from('to_do');       

        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('to_do.*');
        $this->db->from('to_do');        
        $this->db->like($field, $value);

        $query = $this->db->get();
        return $query->result();
    }   

    function find($id) {
        $this->db->select('to_do.*');                
    	$this->db->where('to_do.id', $id);
		return $this->db->get('to_do')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('to_do');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('to_do');
    }

}