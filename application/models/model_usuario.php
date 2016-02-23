<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Usuario extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('usuario.* , perfil.name as perfil_name');
        $this->db->from('usuario');
        $this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');

        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value) {
        $this->db->select('usuario.* , perfil.name as perfil_name');
        $this->db->from('usuario');
        $this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');
        $this->db->like($field, $value);

        $query = $this->db->get();
        return $query->result();
    }

    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('usuario')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('usuario');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('usuario');
    }

	function updateByLogin($registro) {
    	$this->db->set($registro);
		$this->db->where('login', $registro['login']);
		$this->db->update('usuario');
    }
	
    function delete($id) {
    	$this->db->where('id', $id);
		$this->db->delete('usuario');
    }

    function get_login($user, $pass) {
        $this->db->where('login', $user);
        $this->db->where('password', $pass);
        return $this->db->get('usuario');
    }

    function get_perfiles() {
        $lista = array();
        $this->load->model('Model_Perfil');
        $registros = $this->Model_Perfil->all();
        foreach ($registros as $registro) {
            $lista[$registro->id] = $registro->name;
        }
        return $lista;
    }

	function get_mail($login){
		$this->db->where('login', $login);
		return $this->db->get('usuario')->row();
	}
	
}
