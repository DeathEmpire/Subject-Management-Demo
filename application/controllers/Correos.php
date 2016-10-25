<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Correos extends CI_Controller {



	// Constructor de la clase

	function __construct() {

		parent::__construct();



		$this->load->model('Model_Lista_correos');

		$this->load->library('Lista_CorreosLib');



		$this->form_validation->set_message('required', 'Debe ingresar campo %s');

        // $this->form_validation->set_message('valid_email', 'Campo %s no es un eMail valido');

        // $this->form_validation->set_message('my_validation', 'Existe otro registro con el mismo nombre');

    }



	public function index() {

		$data['contenido'] = 'correos/index';

		$data['titulo'] = 'Lista de Correos';

		$data['query'] = $this->Model_Lista_correos->all();

		$this->load->view('template2', $data);

	}



 	public function search() {

		$data['contenido'] = 'correos/index';
		$data['titulo'] = 'Lista de Correos';
		$value = $this->input->post('buscar');

		if(!empty($value)){
			$data['query'] = $this->Model_Lista_correos->allFiltered2('lista_correos.nombre', $value);			
		}
		

		$this->load->view('template2', $data);

	}

	public function create() {

		$data['contenido'] = 'correos/create';

		$data['titulo'] = 'Crear Lista de Correo';		

		$this->load->view('template2', $data);

	}



	public function insert() {

		$registro = $this->input->post();

		$this->form_validation->set_rules('nombre', 'Nombre', 'required');

        $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');

        $this->form_validation->set_rules('correos', 'Lista de Correos', 'required');

        if ($this->form_validation->run() == FALSE) {

            $this->create();

        }

        else {

			$registro['id'] = "NULL";		

			$registro['created'] = date('Y-m-d H:i:s');
			
			$registro['creado_por'] = $this->session->userdata('usuario');			

			$this->Model_Lista_correos->insert($registro);

			redirect('correos/index');

        }

	}



	public function edit($id) {

		$id = $this->uri->segment(3);
		
		$data['contenido'] = 'correos/edit';

		$data['titulo'] = 'Actualizar Lista de Correos';

		$data['registro'] = $this->Model_Lista_Correos->find($id);		

		$this->load->view('template2', $data);

	}



	public function update() {

		$registro = $this->input->post();



		$this->form_validation->set_rules('correos', 'Lista de Correos', 'required');
		
		if($this->form_validation->run() == FALSE) {

			$this->edit($registro['id']);

		}

		else {
			

			$this->Model_Lista_Correos->update($registro);

			redirect('correos/index');

		}

	}

/*

	public function delete($id) {

		$this->Model_Usuario->delete($id);

		redirect('usuario/index');

	} */



}

