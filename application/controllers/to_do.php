<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class To_do extends CI_Controller {

	// Constructor de la clase
	function __construct() {
		parent::__construct();

		$this->load->model('Model_To_do');
		
    }

    function index(){

    	$data['contenido'] = 'to_do/index';
		$data['titulo'] = 'To Do List';
		#$data['query'] = $this->Model_To_do->all();
		$this->load->view('template', $data);
    }
}