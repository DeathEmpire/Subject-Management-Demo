<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Historial_medico extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('historial_medico.*');
        $this->db->from('historial_medico');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');

        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('historial_medico.*');
        $this->db->from('historial_medico');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');
        $this->db->like($field, $value);

        $query = $this->db->get();
        return $query->result();
    }
    
    function allWhere($field, $value) {
        $this->db->select('historial_medico.*');
        $this->db->from('historial_medico');        
        $this->db->where($field, $value);

        $query = $this->db->get();
        return $query->result();
    }

    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('historial_medico')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('historial_medico');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('historial_medico');
    }

}