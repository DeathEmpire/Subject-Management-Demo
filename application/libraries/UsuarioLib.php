<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

// Validaciones para el modelo de usuarios (login, cambio clave, CRUD Usuario)
class UsuarioLib {

	function __construct() {
		$this->CI = & get_instance(); // Esto para acceder a la instancia que carga la librería

		$this->CI->load->model('Model_Usuario');
        $this->CI->load->model('Model_Perfil');
    }

    public function login($user, $pass) {
    	$query = $this->CI->Model_Usuario->get_login($user, $pass);
    	if($query->num_rows() > 0) {
    		$usuario = $query->row();
            $perfil = $this->CI->Model_Perfil->find($usuario->perfil_id);

            $this->CI->load->model('Model_Opciones_Perfil');
            $opciones = $this->CI->Model_Opciones_Perfil->allWhere(array('role'=>$usuario->perfil_id));

            if(isset($opciones) AND !empty($opciones)){
                foreach ($opciones as $v) {
                    $opcion[$v->controller] = $v->actions;
                }
            }else{
                $opcion = array();
            }

    		$datosSession = array('usuario' => $usuario->name,
    			                  'usuario_id' => $usuario->id,
    			                  'perfil_id' => $usuario->perfil_id,
                                  'perfil_name' => $perfil->name,
                                  'center_id' => $usuario->center,
                                  'role_options'=>$opcion);
    		$this->CI->session->set_userdata($datosSession);
			
			/* Actualizar ultima fecha de login */
			$registro['ultimo_login'] = date("Y-m-d H:i:s");
			$registro['id'] = $usuario->perfil_id;
			$this->CI->Model_Usuario->update($registro);

            $this->CI->auditlib->save_audit("Login");

    		return TRUE;
    	}
    	else {
    		$this->CI->session->sess_destroy();
    		return FALSE;
    	}
    }

    public function cambiarPWD($act, $new, $fecha) {
    	if($this->CI->session->userdata('usuario_id') == null) {
    		return FALSE;
    	}

    	$id = $this->CI->session->userdata('usuario_id');
    	$usuario = $this->CI->Model_Usuario->find($id);

    	if($usuario->password == $act) {
    		$data = array('id' => $id,
               			  'password' => $new,
						  'fecha_cambio_clave' => $fecha);
    		$this->CI->Model_Usuario->update($data);
    	}
    	else {
    		return FALSE;
    	}
    }

    public function my_validation($registro) {
        $this->CI->db->where('login', $registro['login']);
        $query = $this->CI->db->get('usuario');

        if ($query->num_rows() > 0 AND (!isset($registro['id']) OR ($registro['id'] != $query->row('id')))) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
	
	public function obligarcambioclave(){
		$id = $this->CI->session->userdata('usuario_id');
    	$usuario = $this->CI->Model_Usuario->find($id);
		
		if($usuario->fecha_cambio_clave == "NULL" OR $usuario->fecha_cambio_clave == NULL OR $usuario->fecha_cambio_clave == '0000-00-00'){
			/* obligar a cambiar clave */
			return true;
		}
		/* preguntar si la fecha_cambio clave es menor o igual a hoy obligar */
		elseif($usuario->fecha_cambio_clave <= date("Y-m-d")){
			return true;
		}else{
			return false;
		}
		
	}
	

}
