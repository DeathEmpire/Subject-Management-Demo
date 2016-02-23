<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

// Validaciones para el modelo de usuarios (login, cambio clave, CRUD Usuario)
class Opciones_PerfilLib {

	function __construct() {
		$this->CI = & get_instance(); // Esto para acceder a la instancia que carga la librería

		$this->CI->load->model('Model_Opciones_Perfil');
    }

    public function permitido($perfil,$controlador,$accion) {
        
		$this->CI->db->where('role', $perfil);
		$this->CI->db->where('controller', $controlador);
		$this->CI->db->like('actions', $accion);
        $query = $this->CI->db->get('opciones_perfil');

        if ($query->num_rows() > 0 ) {
            return true;
        }
        else {
            return false;
        }
    }

}
