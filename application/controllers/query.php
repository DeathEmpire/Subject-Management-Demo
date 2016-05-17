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

	public function additional_form_query_new($subject_id = '', $form = '', $etapa = ''){
		
		$registro = $this->input->post();

		if(isset($registro['subject_id']) AND !empty($registro['subject_id']) AND isset($registro['form']) AND !empty($registro['form'])){
			$subject_id = $this->input->post('subject_id');
			$form = $this->input->post('form');
			if(isset($registro['etapa']) AND !empty($registro['etapa'])){
				$etapa = $this->input->post('etapa');
			}			
		}

		$data['contenido'] = 'query/aditional';
		$data['titulo'] = 'Consulta para el formulario de '. $form;
		$data['subject'] = $this->Model_Subject->find($subject_id);
		$data['form'] = $form;
		$data['etapa'] = $etapa;

		$this->auditlib->save_audit("Abrio Formulario para nueva consulta de ". $form);

		$this->load->view('template', $data);
	}

	public function additional_form_query_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('question', 'Consulta', 'required|xss_clean');
        
        if ($this->form_validation->run() == FALSE) {
        	$this->auditlib->save_audit("Tiene errores agregando una consulta en el formulario de ". $registro['form']);
            $this->additional_form_query_new($registro['subject_id'],$registro['form']);
        }
        else {	
        	
        	$registro['question_user'] = $this->session->userdata('usuario');
			$registro['created'] = date("Y-m-d H:i:s");		
			
			$this->Model_Query->insert($registro);

			$this->auditlib->save_audit("Agrego una nueva consula al formulario de ". $registro['form']);

			if($registro['form'] == 'Adverse Event'){
				redirect('subject/adverse_event_show/'. $registro['subject_id']);
			}
			elseif ($registro['form'] == 'Protocol Deviation') {
				redirect('subject/protocol_deviation_show/'. $registro['subject_id']);
			}
			elseif ($registro['form'] == 'Concomitant Medication') {
				redirect('subject/concomitant_medication_show/'. $registro['subject_id']);
			}
			elseif($registro['form'] == 'Historial Medico'){
				redirect('subject/historial_medico_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'Inclusion Exclusion'){
				redirect('subject/inclusion_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'Hachinski'){
				redirect('subject/hachinski_show/'. $registro['subject_id']);
			}
			
		}

	}

	public function additional_form_query_show($subject_id,$query_id,$form){
		
		$form = urldecode($form);

		$data['contenido'] = 'query/aditional_answer';
		$data['titulo'] = 'Respuesta para el formulario '. $form;				
		$data['subject'] = $this->Model_Subject->find($subject_id);
		
		$data['query'] = $this->Model_Query->find($query_id);
		$data['form'] = $form;

		$this->auditlib->save_audit("Abrio el formulario para agregar una respuesta en el formulario ". $form);				

		$this->load->view('template', $data);
	}

	public function additional_form_query_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('answer', 'Respuesta', 'required|xss_clean');
        
        if ($this->form_validation->run() == FALSE) {
        	$this->auditlib->save_audit("Tiene errores de validacion agregando una respuesta en el formulario de ". $registro['form']);
            $this->additional_form_query_show($registro['subject_id'],$registro['id'],$registro['form']);
        }
        else {	
        	
        	$registro['answer_user'] = $this->session->userdata('usuario');
			$registro['answer_date'] = date("Y-m-d H:i:s");			
			
			$this->Model_Query->update($registro);			

			$this->auditlib->save_audit("Respondia en el formulario de ". $registro['form']);

			if($registro['form'] == 'Adverse Event'){
				redirect('subject/adverse_event_show/'. $registro['subject_id']);
			}
			elseif ($registro['form'] == 'Protocol Deviation') {
				redirect('subject/protocol_deviation_show/'. $registro['subject_id']);
			}
			elseif ($registro['form'] == 'Concomitant Medication') {
				redirect('subject/concomitant_medication_show/'. $registro['subject_id']);
			}
			elseif($registro['form'] == 'Historial Medico'){
				redirect('subject/historial_medico_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'Inclusion Exclusion'){
				redirect('subject/inclusion_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'Hachinski'){
				redirect('subject/hachinski_show/'. $registro['subject_id']);
			}
			
		}

	}
}