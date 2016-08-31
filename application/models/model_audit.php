<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Audit extends CI_Model {

	function __construct() {
		parent::__construct();
    }

    function all() {
        $this->db->select('audit.*');
        $this->db->from('audit');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');
        $this->db->order_by("id","DESC");
        $query = $this->db->get();
        return $query->result();
    }

    function allFiltered($field, $value, $limit='',$id='') {
        $this->db->select('audit.*');
        $this->db->from('audit');
        #$this->db->join('perfil', 'usuario.perfil_id = perfil.id', 'left');
        $this->db->like($field, $value);

        if(!empty($limit) AND !empty($id)){
            $this->db->limit($limit,$id-1);    
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function fetch_data($limit, $id) {
        $this->db->limit($limit,$id-1);
        #$this->db->where('id', $id);
        #$offset = ($id-1)*$limit;
        
        $query = $this->db->get("audit");        
       
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }

            return $data;
        }   

        return false;
    }
    

    function find($id) {
    	$this->db->where('id', $id);
		return $this->db->get('audit')->row();
    }

    function insert($registro) {
    	$this->db->set($registro);
		$this->db->insert('audit');
    }

    function update($registro) {
    	$this->db->set($registro);
		$this->db->where('id', $registro['id']);
		$this->db->update('audit');
    }

    function buscarAudit($tabla, $id){
        $this->db->select($tabla .'.*');
        $this->db->from($tabla);        
        $this->db->where('form_id', $id);        

        $query = $this->db->get();
        return $query->result();    
    }
}