<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

// Validaciones para el modelo de usuarios (login, cambio clave, CRUD Usuario)
class KitLib {

	function __construct() {
		$this->CI = & get_instance(); // Esto para acceder a la instancia que carga la librería

		$this->CI->load->model('Model_Kit');
    } 

/*     public function norep($registro) {
        $this->CI->db->where('name', $registro['name']);
        $query = $this->CI->db->get('perfil');

        if ($query->num_rows() > 0 AND (!isset($registro['id']) OR ($registro['id'] != $query->row('id')))) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    } */

}