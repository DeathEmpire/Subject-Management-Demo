<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perfil extends CI_Controller {

	// Constructor de Clase
	function __construct() {
		parent::__construct();

		$this->load->model('Model_Perfil');
		$this->load->library('perfilLib');

		$this->form_validation->set_message('required', 'Debe ingresar un valor para %s');
		$this->form_validation->set_message('norep', 'Existe otro registro con el mismo nombre');
	}

	public function index() {
		$data['contenido'] = 'perfil/index';
		$data['titulo'] = 'Roles';
		$data['query'] = $this->Model_Perfil->all();
		$this->load->view('template', $data);
	}

	public function search() {
		
		$id_buscar = $this->input->post('buscar_id');
	
		if(isset($id_buscar) AND !empty($id_buscar)){
			$data['contenido'] = 'perfil/opciones';
			$data['titulo'] = 'Role Access';
		
			$this->load->model("Model_Perfil");
			$data['perfiles'] = $this->Model_Perfil->all();
		
			$this->load->model("Model_Opciones_Perfil");
			$data['query'] = $this->Model_Opciones_Perfil->allFiltered("role",$id_buscar);
			
			$this->load->view('template', $data);
		}else{	
			$data['contenido'] = 'perfil/index';
			$data['titulo'] = 'Roles';
			$value = $this->input->post('buscar');
			$data['query'] = $this->Model_Perfil->allFiltered('name', $value);
			$this->load->view('template', $data);
		}
	}

	public function norep() {
		return $this->perfillib->norep($this->input->post());
	}

	public function create() {
		$data['contenido'] = 'perfil/create';
		$data['titulo'] = 'New Role';
		$this->load->view('template', $data);
	}

	public function ingresar(){
		$data['contenido'] = 'perfil/ingresar';
		$data['titulo'] = 'New Role';
		$this->load->view('template', $data);
	}
	
	public function insert() {
		$registro = $this->input->post();

		$this->form_validation->set_rules('name', 'Name', 'required|callback_norep');
		if($this->form_validation->run() == FALSE) {
			$this->create();
		}
		else {
			$registro['created'] = date('Y/m/d H:i');
			$registro['updated'] = date('Y/m/d H:i');
			$this->Model_Perfil->insert($registro);
			redirect('perfil/index');
		}
	}

	public function edit($id) {
		// $id = $this->uri->segment(3);

		$data['contenido'] = 'perfil/edit';
		$data['titulo'] = 'Update Role';
		$data['registro'] = $this->Model_Perfil->find($id);
		$this->load->view('template', $data);
	}

	public function update() {
		$registro = $this->input->post();

		$this->form_validation->set_rules('name', 'Name', 'required|callback_norep');
		if($this->form_validation->run() == FALSE) {
			$this->edit($registro['id']);
		}
		else {
			$registro['updated'] = date('Y/m/d H:i');
			$this->Model_Perfil->update($registro);
			redirect('perfil/index');
		}
	}

	public function delete($id) {
		$this->Model_Perfil->delete($id);
		redirect('perfil/index');
	}

	public function opciones(){
		$data['contenido'] = 'perfil/opciones';
		$data['titulo'] = 'Role Access';
		
		$this->load->model("Model_Opciones_Perfil");
		$data['query'] = $this->Model_Opciones_Perfil->all();
		
		$this->load->model("Model_Perfil");
		$data['perfiles'] = $this->Model_Perfil->all();
		
		$this->load->view('template', $data);
	}
	
}
