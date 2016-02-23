<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Center extends CI_Controller {

	// Constructor de la clase
	function __construct() {
		parent::__construct();

		$this->load->model('Model_Center');		
		#$this->load->library('usuarioLib');
		#$this->form_validation->set_message('required', 'Debe ingresar campo %s');        
    }

    function index(){

    	$data['contenido'] = 'center/index';
		$data['titulo'] = 'Centers';
		$data['query'] = $this->Model_Center->all();		
		
		$this->auditlib->save_audit("View Center Index");

		$this->load->view('template', $data);


    }

     public function search() {
		$data['contenido'] = 'center/index';
		$data['titulo'] = 'Centers';
		$value = $this->input->post('buscar');
		$data['query'] = $this->Model_Center->allFiltered('center.id', $value);
		$this->auditlib->save_audit("Search a Center");
		$this->load->view('template', $data);
	}   

	public function create() {
		$data['contenido'] = 'center/create';
		$data['titulo'] = 'New Center';
		$this->auditlib->save_audit("Enter new center form");		
		$this->load->view('template', $data);
	}

	public function insert() {
		$registro = $this->input->post();

		$this->form_validation->set_rules('name', 'Center Name', 'required|xss_clean');
        
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        }
        else {						
			
			$registro['created'] = date('Y/m/d H:i:s');
			$registro['updated'] = date('Y/m/d H:i:s');
			
			$this->Model_Center->insert($registro);			
			$this->auditlib->save_audit("Create new center");
			redirect('center/index');
        }
	}

	public function edit($id) {
		// $id = $this->uri->segment(3);

		$data['contenido'] = 'center/edit';
		$data['titulo'] = 'Update Center';
		$data['registro'] = $this->Model_Center->find($id);
		#centros
		$this->auditlib->save_audit("View center edit form");
		$this->load->view('template', $data);
	}

	public function update() {
		$registro = $this->input->post();

		$this->form_validation->set_rules('name', 'Center Name', 'required|xss_clean');
		if($this->form_validation->run() == FALSE) {
			$this->edit($registro['id']);
		}
		else {
			$registro['updated'] = date('Y/m/d H:i');
			$this->Model_Center->update($registro);
			$this->auditlib->save_audit("Update a center");
			redirect('center/index');
		}
	}
}