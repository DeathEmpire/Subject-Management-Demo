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
		$all = $this->Model_Audit->all();

		#Empty search values
		$this->session->set_userdata(array('audit_search'=>''));

		$config = array();
		$config["base_url"] = base_url("audit/index");
		
		$config["total_rows"] = count($all);
		$config["per_page"] = 20;
		$config['use_page_numbers'] = FALSE;
		#$config['num_links'] = count($all)/20;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '';
		$config['prev_link'] = '';
		$config['uri_segment'] = 3;
		$config['num_links'] = 3;
		$config['first_link'] = '<<  ';
		$config['last_link'] = '  >>';

		$this->pagination->initialize($config);

		if($this->uri->segment(3)){
			$page = ($this->uri->segment(3)) ;
		}
		else{
			$page = 1;
		}

		$data['query'] = $this->Model_Audit->fetch_data($config["per_page"], $page);		
		$data["links"] = $this->pagination->create_links();



		$this->load->view('template', $data);

    }

    public function search() {
		$data['contenido'] = 'audit/index';
		$data['titulo'] = 'Audit';
		$value = $this->input->post('buscar');
		$data['query'] = $this->Model_Audit->allFiltered('audit.user_name', $value);
		

		if(isset($value) AND !empty($value)){			
			$this->session->set_userdata(array('audit_search'=>$value));
		}
		else{
			
			$value = $this->session->userdata('audit_search');
		}

		$config = array();
		$config["base_url"] = base_url("audit/search");
		
		$config["total_rows"] = count($data['query']);
		$config["per_page"] = 20;
		$config['use_page_numbers'] = FALSE;
		#$config['num_links'] = count($all)/20;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '';
		$config['prev_link'] = '';
		$config['uri_segment'] = 3;
		$config['num_links'] = 3;
		$config['first_link'] = '<<  ';
		$config['last_link'] = '  >>';

		$this->pagination->initialize($config);

		if($this->uri->segment(3)){
			$page = ($this->uri->segment(3)) ;
		}
		else{
			$page = 1;
		}

		$data['query'] = $this->Model_Audit->allFiltered('audit.user_name', $value,$config["per_page"], $page);		
		$data["links"] = $this->pagination->create_links();


		$this->load->view('template', $data);
	}

	/*
		#to save a audit record
		#$this->auditlib->save_audit("Here the Description");
		
	*/
}