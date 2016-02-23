<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	// Constructor de Clase
	function __construct() {
		parent::__construct();

		$this->load->library('usuarioLib');
		$this->form_validation->set_message('required', 'Debe ingresar un valor para %s');
		$this->form_validation->set_message('loginok', 'Usuario o clave incorrectos');
		$this->form_validation->set_message('matches', '%s no coincide con %s');
		$this->form_validation->set_message('cambiook', 'No se puede realizar el cambio de clave');
		$this->form_validation->set_message('existeusuario', 'El nombre de usuario ingresado no es valido');
	}

	public function index() {
		$data['contenido'] = 'home/index';
		$data['titulo'] = 'Home';
		$this->load->view('template', $data);
	}

	public function acerca_de() {
		$data['contenido'] = 'home/acerca_de';
		$data['titulo'] = 'About';
		$this->load->view('template', $data);
	}

	public function acceso_denegado() {
		$data['contenido'] = 'home/acceso_denegado';
		$data['titulo'] = 'Access Denied';
		$this->load->view('template', $data);
	}

	public function ingreso() {
		$data['contenido'] = 'home/ingreso';
		$data['titulo'] = 'Login';
		$this->load->view('template', $data);
	}

	public function ingresar() {
		$this->form_validation->set_rules('login', 'Usuario', 'required|callback_loginok');
		$this->form_validation->set_rules('password', 'Clave', 'required');
		if($this->form_validation->run() == FALSE) {
			$this->ingreso();
		}
		else {
		
			/* Preguntar si necesita cambiar la clave deacuerdo a la fecha y obligar a cambiarla */
		
			redirect('home/index');
		}
	}

	public function loginok() {
		$login = $this->input->post('login');
		$password = $this->input->post('password');
		return $this->usuariolib->login($login, md5($password));
	}

	public function salir() {
		$this->session->sess_destroy();
		redirect('home/index');
	}

	public function cambio_clave() {
		$data['contenido'] = 'home/cambio_clave';
		$data['titulo'] = 'Change Password';
		$this->load->view('template', $data);
	}

	public function cambiar_clave() {
		$this->form_validation->set_rules('clave_act', 'Clave Actual', 'required|callback_cambiook');
		$this->form_validation->set_rules('clave_new', 'Clave Nueva', 'required|matches[clave_rep]');
		$this->form_validation->set_rules('clave_rep', 'Repita Nueva', 'required');
		if($this->form_validation->run() == FALSE) {
			$this->cambio_clave();
		}
		else {
			redirect('home/index');
		}
	}

	public function cambiook() {
		$act = $this->input->post('clave_act');
		$new = $this->input->post('clave_new');
		/* agregar para actualizar fecha de cambio nueva */		
		$actual = date("Y-m-d");
		$fecha_cambio_clave = date("Y-m-d",strtotime("$actual + 120 days"));
		
		return $this->usuariolib->cambiarPWD(md5($act), md5($new),$fecha_cambio_clave);
	}

	public function recuperarclave(){
		$data['contenido'] = 'home/recuperarclave';
		$data['titulo'] = 'Forgot Password';
		$this->load->view('template', $data);		
	}
	
	public function recuperandoclave(){
		$this->form_validation->set_rules('usuario', 'Nombde de usuario', 'required|callback_existeusuario');
		if($this->form_validation->run() == FALSE) {
			$this->recuperarclave();
		}
		else {
		
			$login = $this->input->post('usuario');
			
			$this->load->model("Model_Usuario");
			$usuario = $this->Model_Usuario->get_mail($login);
			
			for ($i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')-1, $s = $a{rand(0,$z)}, $i = 1; $i != 12; $x = rand(0,$z), $s .= $a{$x}, $s = ($s{$i} == $s{$i-1} ? substr($s,0,-1) : $s), $i=strlen($s));
			$mensaje = "Se ha generado una nueva clave automatica para su cuenta, la clave es ". $s;
			
			$this->load->helper("phpmailer");
			if(send_email($usuario->email,"x","Reestablacer Contraseña",$mensaje)){
				/* Actualizar clave en el la tabla usuario */
				$registro['login'] = $login;
				$registro['password'] = md5($s);
				$registro['updated'] = date("Y-m-d H:i:s");
				$this->Model_Usuario->updateByLogin($registro);
				redirect('home/recuperarclaveok');
			}
			else{
				$this->recuperarclave();			
			}
			
		}
	}
	
	public function recuperarclaveok(){
		$data['contenido'] = 'home/recuperarclaveok';
		$data['titulo'] = 'Forgot Password';
		$this->load->view('template', $data);		
	}
	
	public function existeusuario(){
		$usuario['login'] = $this->input->post('usuario');
		return !$this->usuariolib->my_validation($usuario);
	}
	
}
