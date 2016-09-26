<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Examen_fisico_adicional extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('examen_fisico_adicional.*');
        $this->db->from('examen_fisico_adicional');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');

        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('examen_fisico_adicional.*');
        $this->db->from('examen_fisico_adicional');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');
        $this->db->like($field, $value);

        $query = $this->db->get();
        return $query->result();
    }

    function allWhere($field, $value) {
        $this->db->select('examen_fisico_adicional.*');
        $this->db->from('examen_fisico_adicional');        
        $this->db->where($field, $value);

        $query = $this->db->get();
        return $query->result();
    }
    function allWhereArray($where) {
        $this->db->select('examen_fisico_adicional.*');
        $this->db->from('examen_fisico_adicional');        
        $this->db->where($where);

        $query = $this->db->get();
        return $query->result();
    }

    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('examen_fisico_adicional')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('examen_fisico_adicional');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('examen_fisico_adicional');
    }
    function allWhereArrayWithCode($where) {
        $this->db->select('examen_fisico_adicional.*,subject.code as codigo');
        $this->db->from('examen_fisico_adicional');
        $this->db->join('subject', 'examen_fisico_adicional.subject_id = subject.id', 'left');
        $this->db->where($where);
        $centro = $this->session->userdata('center_id');
        if($centro != 'Todos'){
            $this->db->where('subject.center', $centro);
        }
        $query = $this->db->get();
        return $query->result();
    }

}