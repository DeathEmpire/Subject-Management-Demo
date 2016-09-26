<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class To_do extends CI_Controller {

	// Constructor de la clase
	function __construct() {
		parent::__construct();
		
		$this->load->library('pendingLib');		
    }

    function index(){

    	$data['contenido'] = 'to_do/index';
		$data['titulo'] = 'To Do List';

		$data['to_do'] = $this->pendinglib->pending_by_role();		

		$this->auditlib->save_audit("View to do list");
		
		$this->load->view('template', $data);
    }
}