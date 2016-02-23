<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Audit extends CI_Controller {

	// Constructor de la clase
	function __construct() {
		parent::__construct();

		$this->load->model('Model_Audit');
		#$this->load->library('usuarioLib');
		#$this->form_validation->set_message('required', 'Debe ingresar campo %s');        
    }

    function index(){

    	$data['contenido'] = 'audit/index';
		$data['titulo'] = 'Audit';
		$data['query'] = $this->Model_Audit->all();
		$this->load->view('template', $data);
    }

    public function search() {
		$data['contenido'] = 'audit/index';
		$data['titulo'] = 'Audit';
		$value = $this->input->post('buscar');
		$data['query'] = $this->Model_Audit->allFiltered('audit.user_name', $value);
		$this->load->view('template', $data);
	}

	/*
		#to save a audit record
		#$this->auditlib->save_audit("Here the Description");
		
	*/
}