<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query extends CI_Controller {

	// Constructor de la clase
	function __construct() {
		parent::__construct();
		$this->load->model('Model_Query');
		$this->load->model('Model_Subject');
		
    }
	
	public function demography_query_new(){

		$id = $this->input->post('id');

		$data['contenido'] = 'query/demography';
		$data['titulo'] = 'Demograhpy Form Query';				
		$data['subject'] = $this->Model_Subject->find($id);
		$this->auditlib->save_audit("Open Demography query form");				

		$this->load->view('template', $data);
	}

	public function demography_query_insert(){
		$registro = $this->input->post();		

		$this->form_validation->set_rules('question', 'Question', 'required|xss_clean');
        
        if ($this->form_validation->run() == FALSE) {
        	$this->auditlib->save_audit("Has validation error creating new demography query");
            $this->demography_query_new($registro['subject_id']);
        }
        else {	
        	$registro['form'] = 'Demography';
        	$registro['question_user'] = $this->session->userdata('usuario');
			$registro['created'] = date("Y-m-d H:i:s");

			$subject['id'] = $registro['subject_id'];
			$subject['demography_status'] = "Query";
			/*Dont update last status if another query still open*/
			if($registro['demography_status'] != 'Query'){
				$subject['demography_last_status'] = $registro['demography_status'];
			}

			unset($registro['demography_status']);

			$this->Model_Query->insert($registro);
			$this->Model_Subject->update($subject);

			$this->auditlib->save_audit("Add new demography query");


			redirect('subject/demography/'. $registro['subject_id']);
		}

	}

	public function demography_query_show($subject_id,$query_id){		

		$data['contenido'] = 'query/demography_answer';
		$data['titulo'] = 'Demograhpy Form Answer';				
		$data['subject'] = $this->Model_Subject->find($subject_id);
		$data['query'] = $this->Model_Query->find($query_id);

		$this->auditlib->save_audit("Open Demography answer form");				

		$this->load->view('template', $data);
	}	

	public function demography_query_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('answer', 'Answer', 'required|xss_clean');
        
        if ($this->form_validation->run() == FALSE) {
        	$this->auditlib->save_audit("Has validation error answering demography query");
            $this->demography_query_new($registro['subject_id']);
        }
        else {	
        	
        	$registro['answer_user'] = $this->session->userdata('usuario');
			$registro['answer_date'] = date("Y-m-d H:i:s");

			$subject['id'] = $registro['subject_id'];
			
			
			/*Dont update last status if another query still open*/
			$opened = $this->Model_Query->areOpenedQuery('Demography');

			if($opened <= 1){
				/*If current opened change status, else still query status*/
				$subject['demography_status'] = $registro['demography_last_status'];				
			}
			unset($registro['demography_last_status']);
			

			$this->Model_Query->update($registro);
			$this->Model_Subject->update($subject);

			$this->auditlib->save_audit("Answered a demography query");


			redirect('subject/demography/'. $registro['subject_id']);
		}


		/*Check if another query still open*/
		$opened = $this->Model_Query->areOpenedQuery('Demography');
	}

	public function additional_form_query_new($form){

	}

	public function additional_form_query_insert(){

	}

	public function additional_form_query_show($id){

	}

	public function additional_form_query_update($id){

	}
}