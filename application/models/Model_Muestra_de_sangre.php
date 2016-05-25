<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Muestra_de_sangre extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('muestra_de_sangre.*');
        $this->db->from('muestra_de_sangre');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');

        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('muestra_de_sangre.*');
        $this->db->from('muestra_de_sangre');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');
        $this->db->like($field, $value);

        $query = $this->db->get();
        return $query->result();
    }

    function allWhere($field, $value) {
        $this->db->select('muestra_de_sangre.*');
        $this->db->from('muestra_de_sangre');        
        $this->db->where($field, $value);

        $query = $this->db->get();
        return $query->result();
    }
    function allWhereArray($where) {
        $this->db->select('muestra_de_sangre.*');
        $this->db->from('muestra_de_sangre');        
        $this->db->where($where);

        $query = $this->db->get();
        return $query->result();
    }

    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('muestra_de_sangre')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('muestra_de_sangre');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('muestra_de_sangre');
    }

}