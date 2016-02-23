<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Subject extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('subject.*,center.name as center_name');
        $this->db->from('subject');
        $this->db->join('center', 'subject.center = center.id', 'left');

        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('subject.*,center.name as center_name');
        $this->db->from('subject');
        $this->db->join('center', 'subject.center = center.id', 'left');
        $this->db->like($field, $value);

        $query = $this->db->get();
        return $query->result();
    }

    function allFilteredWhere($where){
        $this->db->select('subject.*,center.name');
        $this->db->from('subject');
        $this->db->join('center','subject.center = center.id','LEFT');   
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    function countSubjectsByCenter($center) {
        $this->db->select('count(*) as cant');                
        $this->db->where('subject.center', $center);
        return $this->db->get('subject')->row();
    }

    function find($id) {
        $this->db->select('subject.*,center.name as center_name');        
        $this->db->join('center', 'subject.center = center.id', 'left');
    	$this->db->where('subject.id', $id);
		return $this->db->get('subject')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('subject');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('subject');
    }

}