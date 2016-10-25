<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

// Validaciones para el modelo de usuarios (login, cambio clave, CRUD Usuario)
class Lista_CorreosLib {

	function __construct() {
		$this->CI = & get_instance(); // Esto para acceder a la instancia que carga la librería
		
		$this->CI->load->model("Model_Lista_Correos");
    }
	
	/* public function my_validation($post){
		return true;
	}
	
	public function dar_acceso($perfil_id,$menu_id){
		$registro = array();
		$registro['menu_id'] = $menu_id;
		$registro['perfil_id'] = $perfil_id;
		$registro['created'] = date("Y-m-d H:i:s");
		$registro['updated'] = date("Y-m-d H:i:s");
		
		$this->CI->Model_Menu_Perfil->insert($registro);
	}

	public function quitar_acceso($perfil_id,$menu_id){		
		$this->CI->db->where('perfil_id',$perfil_id);
		$this->CI->db->where('menu_id',$menu_id);
		$this->CI->db->delete("menu_perfil");		
	}
	
	public function findByMenuAndPerfil($menu_id,$perfil_id){
		$this->CI->db->where("menu_id",$menu_id);
		$this->CI->db->where("perfil_id",$perfil_id);
		return $this->CI->db->get("menu_perfil")->row();
	} */
}
?>