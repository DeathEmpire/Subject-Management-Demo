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
		$data['titulo'] = 'Opciones de Roles';
		$data['query'] = $this->Model_Perfil->all();
		$this->load->view('template2', $data);
	}

	public function search() {
		
		$id_buscar = $this->input->post('buscar_id');
	
		if(isset($id_buscar) AND !empty($id_buscar)){
			$data['contenido'] = 'perfil/opciones';
			$data['titulo'] = 'Opciones de Roles';
		
			$this->load->model("Model_Perfil");
			$data['perfiles'] = $this->Model_Perfil->all();
		
			$this->load->model("Model_Opciones_Perfil");
			$data['opciones'] = $this->Model_Opciones_Perfil->allFiltered("role",$id_buscar);
			
			$this->load->view('template2', $data);
		}else{	
			$data['contenido'] = 'perfil/index';
			$data['titulo'] = 'Roles';
			$value = $this->input->post('buscar');
			$data['query'] = $this->Model_Perfil->allFiltered('name', $value);
			$this->load->view('template2', $data);
		}
	}

	public function norep() {
		return $this->perfillib->norep($this->input->post());
	}

	public function create() {
		$data['contenido'] = 'perfil/create';
		$data['titulo'] = 'New Role';
		$this->load->view('template2', $data);
	}

	public function ingresar(){
		$data['contenido'] = 'perfil/ingresar';
		$data['titulo'] = 'New Role';
		$this->load->view('template2', $data);
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
		$this->load->view('template2', $data);
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
		$data['titulo'] = 'Opciones de Roles';
		
		$this->load->model("Model_Opciones_Perfil");
		$data['opciones'] = $this->Model_Opciones_Perfil->todo();
		
		/*Perfiles para filtrar*/
		$this->load->model("Model_Perfil");
		$data['perfiles'] = $this->Model_Perfil->all();
		
		$this->load->view('template2', $data);
	}
	
	public function actualizarOpciones(){
		//tomar cada una de las variables y agregarlas a un arreglo separado por categoria y perfil, luego actualizar cada registro.
		//validar que si no tenia permiso anteriormente este se inserte sino solo se actualice.

		$v = $this->input->post();

		

		//agregamos opciones al perfil
		if($v['metodo'] == 'agregar'){

			//primero ver si existe el permiso en ese controlador para el perfil.
			$this->load->model("Model_Opciones_Perfil");
			$opciones = $this->Model_Opciones_Perfil->allWhere(array('controller'=>$v['controller'], 'role'=>$v['perfil']));

			if(isset($opciones) AND !empty($opciones)){
				//ya existe el permiso para ese controlador y perfil por lo que se debe actualizar
				$permisos = $opciones[0]->actions;
				$permisos .= ",". $v['actions'];

				$registro = array();

				$registro['actions'] = $permisos;
				$registro['id'] = $opciones[0]->id;
				$registro['updated'] = date('Y-m-d H:i:s');

				$this->Model_Opciones_Perfil->update($registro);
			}		
			else{
				//permiso nuevo se debe crear
				$registro = array();

				$registro['controller'] = $v['controller'];
				$registro['actions'] = $v['actions'];
				$registro['role'] = $v['perfil'];
				$registro['created'] = date('Y-m-d H:i:s');
				$registro['updated'] = date('Y-m-d H:i:s');

				$this->Model_Opciones_Perfil->insert($registro);
			}
		}
		//eliminamos opciones del perfil
		else{
			$this->load->model("Model_Opciones_Perfil");
			$opciones = $this->Model_Opciones_Perfil->allWhere(array('controller'=>$v['controller'], 'role'=>$v['perfil']));

			if(isset($opciones) AND !empty($opciones)){
				$permisos = explode(",", $opciones[0]->actions);
				$sacar = explode(",", $v['actions']);

				for($i=0;$i<count($permisos);$i++){

					if(in_array($permisos[$i], $sacar))
					{
						unset($permisos[$i]);
					}
				}

				$registro = array();

				$registro['actions'] = implode(",", $permisos);
				$registro['id'] = $opciones[0]->id;
				$registro['updated'] = date('Y-m-d H:i:s');

				$this->Model_Opciones_Perfil->update($registro);
			}
			else{
				//error no se encontro el permiso para ese perfil
			}
		}
	}
}
