<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Query extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('query.*');
        $this->db->from('query');       

        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('query.*');
        $this->db->from('query');        
        $this->db->like($field, $value);

        $query = $this->db->get();
        return $query->result();
    }   

    function find($id) {
        $this->db->select('query.*');                
    	$this->db->where('query.id', $id);
		return $this->db->get('query')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('query');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('query');
    }

}