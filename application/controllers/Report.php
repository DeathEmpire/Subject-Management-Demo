<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

	// Constructor de la clase
	function __construct() {
		parent::__construct();

		#$this->load->model('Model_Report');		
		
    }

    function index(){

    	$data['contenido'] = 'report/index';
		$data['titulo'] = 'Reports';
		#$data['query'] = $this->Model_Report->all();
		$this->auditlib->save_audit("View Report Menu");
		$this->load->view('template', $data);
    }
}