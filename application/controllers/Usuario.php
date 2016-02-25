<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

	// Constructor de la clase
	function __construct() {
		parent::__construct();

		$this->load->model('Model_Usuario');
		$this->load->library('usuarioLib');

		$this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_message('valid_email', 'please enter a valid email address');
        $this->form_validation->set_message('my_validation', 'This username is already in use');
    }

	public function index() {
		$data['contenido'] = 'usuario/index';
		$data['titulo'] = 'Users';
		$data['query'] = $this->Model_Usuario->all();
		$this->load->view('template', $data);
	}

	public function search() {
		$data['contenido'] = 'usuario/index';
		$data['titulo'] = 'Users';
		$value = $this->input->post('buscar');
		$data['query'] = $this->Model_Usuario->allFiltered('usuario.name', $value);
		$this->load->view('template', $data);
	}

	public function my_validation() {
		return $this->usuariolib->my_validation($this->input->post());
	}

	public function create() {
		$data['contenido'] = 'usuario/create';
		$data['titulo'] = 'New User';
		$data['perfiles'] = $this->Model_Usuario->get_perfiles(); /* Lista de los Perfiles */

		$this->load->Model("Model_Center");
		$centers = $this->Model_Center->all();	
		if(isset($centers) AND !empty($centers)){
			foreach ($centers as $value) {
				$data['centers'][$value->id] = 	$value->name;	
			}	
		}
		else{
			$data['centers'] = 	array();
		}
		

		$this->load->view('template', $data);
	}

	public function insert() {
		$registro = $this->input->post();

		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
        $this->form_validation->set_rules('login', 'Username', 'required|callback_my_validation|xss_clean');
        $this->form_validation->set_rules('email', 'eMail', 'required|valid_email|xss_clean');
        $this->form_validation->set_rules('center', 'Center', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        }
        else {						
			for ($i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')-1, $s = $a{rand(0,$z)}, $i = 1; $i != 12; $x = rand(0,$z), $s .= $a{$x}, $s = ($s{$i} == $s{$i-1} ? substr($s,0,-1) : $s), $i=strlen($s)); 									
			$registro['password'] = md5($s); /* Por defecto misma login y pwd*/
			$registro['created'] = date('Y/m/d H:i');
			$registro['updated'] = date('Y/m/d H:i');
			$registro['estado'] = 'Active';
			/* No se utiliza para que sea obligatorio el cambio al loguearse por primera vez
			$actual = date("Y-m-d");
			$fecha_cambio_clave = date("Y-m-d",strtotime("$actual + 120 days"));
			$registro['fecha_cambio_clave'] = $fecha_cambio_clave; */
			
			$this->Model_Usuario->insert($registro);
			
			/* Enviar correo con pass aleatorio para que luego lo cambie */	
			$this->load->helper("phpmailer");
			
			$data['contenido'] = "usuario/nuevousuario";
			$data['usuario'] = $registro['login'];
			$data['clave'] = $s;
			$mensaje = $this->load->view("correo",$data,true);
			
			/* $mensaje = "Se ha creado un nuevo usuario en Biotechnologies Research<br />&nbsp;<br />
			Usuario: ". $registro['login'] ."<br />
			Clave: ". $s ."<br />&nbsp;<br / >
			Debe ingresar al sistema con <a href='http://www.biotechnologiesresearch.com/pruebasclinicas/home/ingreso'>este enlace</a><br />&nbsp;<br /> 
			
			
			Se recomienda cambiar su password en el <a href='http://www.biotechnologiesresearch.com/pruebasclinicas/home/cambio_clave'>siguiente enlace</a>";			
			*/
			#$enviar_correo = send_email($registro['email'],"x","New User",$mensaje);			
			redirect('usuario/index');
        }
	}

	public function edit($id) {
		// $id = $this->uri->segment(3);

		$data['contenido'] = 'usuario/edit';
		$data['titulo'] = 'Update User';
		
		$data['registro'] = $this->Model_Usuario->find($id);
		$data['perfiles'] = $this->Model_Usuario->get_perfiles(); /* Lista de los Perfiles */

		$this->load->model('Model_Center');
		$data['centers'] = $this->Model_Center->all();

		$this->load->view('template', $data);
	}

	public function update() {
		$registro = $this->input->post();

		$this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('login', 'Username', 'required|callback_my_validation');
        $this->form_validation->set_rules('email', 'eMail', 'required|valid_email');
        $this->form_validation->set_rules('center', 'Center', 'required|xss_clean');
		if($this->form_validation->run() == FALSE) {
			$this->edit($registro['id']);
		}
		else {
			$registro['updated'] = date('Y/m/d H:i');
			$this->Model_Usuario->update($registro);
			redirect('usuario/index');
		}
	}

	public function delete($id) {
		$this->Model_Usuario->delete($id);
		redirect('usuario/index');
	}

}
