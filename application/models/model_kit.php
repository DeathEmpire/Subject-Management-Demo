<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Kit extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('kit.*,center.name');
        $this->db->from('kit');        
        $this->db->join('center','kit.center_id = center.id','LEFT');        
		// $this->db->limit(1000, 0);
        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('kit.*,center.name');
        $this->db->from('kit');
		$this->db->join('center','kit.center_id = center.id','LEFT');		
        $this->db->like($field, $value);		
        $query = $this->db->get();
        return $query->result();
    }
	
	function allFilteredWhere($where){
		$this->db->select('kit.*,center.name');
        $this->db->from('kit');
		$this->db->join('center','kit.center_id = center.id','LEFT');	
		$this->db->where($where);
		$query = $this->db->get();
        return $query->result();
	}

    function lastAssignedByCenter($center){
        $this->db->select('kit.*,');
        $this->db->from('kit');
        $this->db->where("assigned_date IS NOT NULL AND center_id = '". $center ."'");
        $this->db->order_by("assigned_date","DESC");
        $query = $this->db->get();
        return $query->result();   
    }

    function qtyByCenter($center){
        $this->db->select("count(*) as qty");
        $this->db->from('kit');
        $this->db->where(array('center_id'=>$center,"available"=>"1"));
        $query = $this->db->get();
        
        return $query->result();
    }

    function searchNewKit($type,$center){
        $this->db->select('id');
        $this->db->from('kit');
        $this->db->where("available ='1' AND center_id = '". $center ."' AND type='". $type ."'");
        $this->db->order_by('id', 'RANDOM');
        $query = $this->db->get();
        return $query->result();   
    }

    function qtyAssignedByCenter($center){
        $this->db->select("count(*) as qty");
        $this->db->from('kit');
        $this->db->where(array('center_id'=>$center,"available"=>"0"));
        $query = $this->db->get();
        
        return $query->result();   
    }

    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('kit')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('kit');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('kit');
    }

    function delete($id) {
    	$this->db->where('id', $id);
		$this->db->delete('kit');
    }    

	function consulta($sql){
		$query = $this->db->query($sql);
		return $query->row();
	}

}
