<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subject extends CI_Controller {

	// Constructor de la clase
	function __construct() {
		parent::__construct();

		$this->load->model('Model_Subject');
		$this->load->model('Model_Query');

		#$this->load->library('usuarioLib');
		#$this->form_validation->set_message('required', 'Debe ingresar campo %s');        
    }

    function index(){

    	$data['contenido'] = 'subject/index';
		$data['titulo'] = 'Subject Report';
		$data['query'] = $this->Model_Subject->all();
		$this->auditlib->save_audit("View list of subject");
		$this->load->view('template', $data);
    }

    public function search() {
		$data['contenido'] = 'subject/index';
		$data['titulo'] = 'Subject Report';
		$value = $this->input->post('buscar');
		$data['query'] = $this->Model_Subject->allFiltered('subject.id', $value);
		$this->auditlib->save_audit("Search a Subject");
		$this->load->view('template', $data);
	}

    public function my_validation() {
		return false;
		#return $this->usuariolib->my_validation($this->input->post());
	}

	public function create() {
		$data['contenido'] = 'subject/create';
		$data['titulo'] = 'New Subject';		
		$this->auditlib->save_audit("View new subject form");
		$this->load->view('template', $data);
	}

	public function insert() {
		$registro = $this->input->post();

		$this->form_validation->set_rules('initials', 'Initials', 'required|xss_clean');
        $this->form_validation->set_rules('screening_date', 'Screening Date', 'required|xss_clean');   
        $this->form_validation->set_rules('sign_consent', 'Sign Consent', 'required|xss_clean');           
        $this->form_validation->set_rules('selection_criteria', 'Selection Criteria', 'required|xss_clean');

        if(isset($registro->selection_criteria) AND $registro->selection_criteria == 0){
        	$this->form_validation->set_rules('waiver_approving', 'Waiver Approvind Date', 'required|xss_clean');
        }
        else{
        	$this->form_validation->set_rules('waiver_approving', 'Waiver Approvind Date', 'xss_clean');
        }

        if ($this->form_validation->run() == FALSE) {
        	$this->auditlib->save_audit("Has validation error creating new subject");
            $this->create();
        }
        else {				
        	#generating de code of subject
        	$center = $this->session->userdata('center_id');

        	#Buscar la cantidad de usuarios que hay en el centro y sumarle 1
        	$count = $this->Model_Subject->countSubjectsByCenter($center);
        	
        	if($count->cant >= 0 AND $count->cant < 9){
				$num = "00". ($count->cant + 1);
			}
			elseif($count->cant >= 9 AND $count->cant < 99){
				$num = "0". ($count->cant + 1);
			}
			elseif($count->cant >= 99){
				$num = $count->cant + 1;
			}
			
			
			if($center > 0 AND $center < 10){
				$center = "0". $center;
			}		


			$registro['code'] = $center ."-". $num;
			$registro['center'] = $this->session->userdata('center_id');
			$registro['created'] = date('Y/m/d H:i:s');
			$registro['updated'] = date('Y/m/d H:i:s');
			
			$this->Model_Subject->insert($registro);			
			$this->auditlib->save_audit("Create a new subject");
			redirect('subject/index');
        }
	}

	public function edit($id) {
		// $id = $this->uri->segment(3);

		$data['contenido'] = 'subject/edit';
		$data['titulo'] = 'Update Subject';
		$data['registro'] = $this->Model_Subject->find($id);
		#centros
		$this->load->Model("Model_Center");
		
		$centers = $this->Model_Center->all();	
		
		if(isset($centers) AND !empty($centers)){
			foreach ($centers as $value) {
				$data['centers'][$value->id] = 	$value->name;	
			}	
		}
		else{
			$data['centers'] = 	array();
		}

		$this->auditlib->save_audit("View edit subject form");
		$this->load->view('template', $data);
	}

	public function update() {
		$registro = $this->input->post();

		$this->form_validation->set_rules('initials', 'Initials', 'required|xss_clean');
        $this->form_validation->set_rules('screening_date', 'Screening Date', 'required|xss_clean'); 
        $this->form_validation->set_rules('center', 'Center', 'required|xss_clean');
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Has validation errors updating a subject");
			$this->edit($registro['id']);
		}
		else {
			$registro['updated'] = date('Y/m/d H:i');
			$this->Model_Subject->update($registro);
			$this->auditlib->save_audit("Update a subject");
			redirect('subject/index');
		}
	}

	public function grid($id) {
		// $id = $this->uri->segment(3);

		$data['contenido'] = 'subject/grid';
		$data['titulo'] = 'Subject Record';
		$data['subject'] = $this->Model_Subject->find($id);
		$this->auditlib->save_audit("View a subject record");
		$this->load->view('template', $data);
	}

	public function demography($id){
		$data['contenido'] = 'subject/demography';
		$data['titulo'] = 'Subject Demography';
		$data['subject'] = $this->Model_Subject->find($id);
		
		#querys about demography
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$id,"form"=>"Demography"));
		
		$this->auditlib->save_audit("View demography info for a subject");
		
		$this->load->view('template', $data);

	}
	public function demography_update(){

		$registro = $this->input->post();

		$this->form_validation->set_rules('birth_date', 'Date of Birth', 'required|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'required|xss_clean'); 
        $this->form_validation->set_rules('is_hispanic', 'Ethnicity', 'required|xss_clean');
		$this->form_validation->set_rules('race', 'Race', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("has validation errors updating demography info for a subject");
			$this->demography($registro['id']);
		}
		else {
			$registro['demography_status'] = 'Record Complete';
			$registro['updated'] = date('Y/m/d H:i');
			$this->Model_Subject->update($registro);
			$this->auditlib->save_audit("Update demography info for a subject");
			redirect('subject/grid/'.$registro['id']);
		}
	}
	
	public function demography_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("has validation errors verifing demography form");
			$this->demography($registro['id']);
		}
		else {
			$registro['demography_last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['demography_status'] = 'Form Approved by Monitor';
			$registro['updated'] = date('Y-m-d H:i:s');
			$registro['demography_verify_user'] = $this->session->userdata('usuario');
			$registro['demography_verify_date'] = date('Y-m-d');

			$this->Model_Subject->update($registro);
			$this->auditlib->save_audit("Verified demography form");

			redirect('subject/grid/'.$registro['id']);
		}
	}

	public function demography_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("has validation errors updating demography signature");
			$this->demography($registro['id']);
		}
		else {
			$registro['demography_last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['demography_status'] = 'Document Approved and Signed by PI';
			$registro['updated'] = date('Y-m-d H:i:s');
			$registro['demography_signature_user'] = $this->session->userdata('usuario');
			$registro['demography_signature_date'] = date('Y-m-d');

			$this->Model_Subject->update($registro);
			$this->auditlib->save_audit("Sign demography form");

			redirect('subject/grid/'.$registro['id']);
		}
	}

	public function demography_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("has validation errors updating demography lock");
			$this->demography($registro['id']);
		}
		else {
			$registro['demography_last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['demography_status'] = 'Form Approved and Locked';
			$registro['updated'] = date('Y-m-d H:i:s');
			$registro['demography_lock_user'] = $this->session->userdata('usuario');
			$registro['demography_lock_date'] = date('Y-m-d');

			$this->Model_Subject->update($registro);
			$this->auditlib->save_audit("Lock demography form");

			redirect('subject/grid/'.$registro['id']);
		}
	}


	public function randomization($id) {
		// $id = $this->uri->segment(3);

		$data['contenido'] = 'subject/randomization';
		$data['titulo'] = 'Subject Randomization';
		$data['subject'] = $this->Model_Subject->find($id);
		$this->auditlib->save_audit("View randomization form");
		$this->load->view('template', $data);
	}

	public function randomization_update(){
		$registro = $this->input->post();

		$id = $registro['id'];

		$this->form_validation->set_rules('center', 'Center', 'required|xss_clean|callback_stock');
		$this->form_validation->set_rules('id', 'ID', 'required|xss_clean');
		$this->form_validation->set_rules('is_randomizable', 'Is Randomizable', 'required|xss_clean');		
        $this->form_validation->set_rules('randomization_date', 'Randomization Date', 'required|xss_clean');     

        if ($this->form_validation->run() == FALSE) {
        	$this->auditlib->save_audit("has validation errors in randomization");        	
            $this->randomization($id);
        }
        else {						
			
        	
			$registro['updated'] = date('Y/m/d H:i:s');								
			$registro['randomization_status'] = 'Record Complete';

			$this->load->Model('Model_Kit');

			#Kit Asign
			#Search the last type asigned
			//buscar el kit del ultimo paciente randomizado en el centro que se esta, y devolver el numero de kit y tipo
			$last = $this->Model_Kit->lastAssignedByCenter($registro['center']);
			if(isset($last) AND !empty($last)){
				$type = $last[0]->type;
				//Buscar cantidad asignada para ver si es par o no
				$assigned_qty = $this->Model_Kit->qtyAssignedByCenter($registro['center']);

				if($assigned_qty[0]->qty % 2 == 0 AND $$assigned_qty[0]->qty > 1){
					$arr = array("A", "P");
					$random = array_rand($arr,1);
					$new_type = $arr[$random];
				}else{
					if($type == "P"){
						$new_type = "A";
					}
					elseif($type == "A"){
						$new_type = "P";
					}
				}

				$new_kit = $this->Model_Kit->searchNewKit($new_type,$registro['center']);
				if(isset($new_kit) AND !empty($new_kit)){
					$kit_id = $new_kit[0]->id;
				}
				else{
					$data['msg'] = "No kits available in this center";
					$this->randomization($id);
				}

			}
			else{
				#first time assigment
				$arr = array("A", "P");
				$random = array_rand($arr,1);
				$new_type = $arr[$random];

				$new_kit = $this->Model_Kit->searchNewKit($new_type,$registro['center']);
				if(isset($new_kit) AND !empty($new_kit)){
					$kit_id = $new_kit[0]->id;
				}
				else{
					$data['msg'] = "No kits available in this center";
					$this->randomization($id);
				}

			}		
			

			#UPDATE Subject and Kit
			$kit_update = array();
			$kit_update['id'] = $kit_id;
			$kit_update['available'] = 0;
			$kit_update['center_id'] = $registro['center'];
			$kit_update['subject_id'] = $id;
			$kit_update['assigned_date'] = date("Y-m-d H:i:s");
			
			$this->Model_Kit->update($kit_update);

			$registro['kit1'] = $kit_id;			
			$this->Model_Subject->update($registro);			
			$this->auditlib->save_audit("Randomize a subject");
			redirect('subject/grid/'. $id);
        }
        
	}

	function stock($center){
		/*search quantity of kits in warehouse*/		
		$this->load->Model("Model_Kit");
		$qty = $this->Model_Kit->qtyByCenter($center);

		if($qty[0]->qty == 0){
			$this->form_validation->set_message('stock', 'No stock in the center');
			return false;
		}
		else{
			return true;
		}
	}

	public function adverse_event_form($id){
		$data['contenido'] = 'subject/adverse_event';
		$data['titulo'] = 'Adverse Event/Serious Adverse Event';
		$data['subject'] = $this->Model_Subject->find($id);

		#$this->load->model('Model_Adverse_event_form');		
		#$data['list'] = $this->Model_Adverse_event_form->allWhere('subject_id',$id);
		$this->auditlib->save_audit("View a Adverse Event form");
		$this->load->view('template', $data);
	}

	public function adverse_event_form_insert(){
		$registro = $this->input->post();

		$id = $registro['subject_id'];

		$this->form_validation->set_rules('stage', 'Stage', 'required|xss_clean');
        $this->form_validation->set_rules('event_category', 'Event Category', 'required|xss_clean');     
        $this->form_validation->set_rules('event_category_description', 'Description', 'required|xss_clean');
        $this->form_validation->set_rules('event_category_narrative', 'Narrative', 'required|xss_clean');
        $this->form_validation->set_rules('date_of_onset', 'Date of Onset', 'required|xss_clean');
        $this->form_validation->set_rules('continuing', 'Continuing', 'required|xss_clean');
        
        if(isset($registro['continuing']) AND $registro['continuing'] == 0){
        	$this->form_validation->set_rules('date_of_resolution', 'Date of Resolution', 'required|xss_clean');	
        }else{
        	$this->form_validation->set_rules('date_of_resolution', 'Date of Resolution', 'xss_clean');
        }
        
        $this->form_validation->set_rules('assessment_of_severity', 'Assessment of Severity', 'required|xss_clean');
        $this->form_validation->set_rules('assessment_of_casuality', 'Assessment of Casuality', 'required|xss_clean');
        $this->form_validation->set_rules('sae', 'SAE', 'required|xss_clean');

		$this->form_validation->set_rules('action_taken_none', 'action_taken_none', 'xss_clean');
		$this->form_validation->set_rules('action_taken_medication', 'action_taken_medication', 'xss_clean');
		$this->form_validation->set_rules('action_taken_hospitalization', 'action_taken_hospitalization', 'xss_clean');

        $this->form_validation->set_rules('action_taken_on_investigation_product', 'Action Taken on Investigation Product', 'required|xss_clean');
        

        if ($this->form_validation->run() == FALSE) {
        	$this->auditlib->save_audit("Has validation error in adverse event form");
            $this->adverse_event_form($id);
        }
        else {						
			
			$registro['created'] = date('Y/m/d H:i:s');			
			
			$this->load->model("Model_Adverse_event_form");
			$this->Model_Adverse_event_form->insert($registro);			
			$this->auditlib->save_audit("Insert new adverse event info");
			redirect('subject/adverse_event_show/'. $id);
        }
	}

	public function adverse_event_show($id){
		$data['contenido'] = 'subject/adverse_event_show';
		$data['titulo'] = 'Adverse Event/Serious Adverse Event';
		$data['subject'] = $this->Model_Subject->find($id);

		$this->load->model('Model_Adverse_event_form');		
		$data['list'] = $this->Model_Adverse_event_form->allWhere('subject_id',$id);

		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$id,"form"=>"Adverse Event"));

		$this->auditlib->save_audit("View list of adverse events");

		$this->load->view('template', $data);
	}

	public function protocol_deviation_form($id){
		$data['contenido'] = 'subject/protocol_deviation';
		$data['titulo'] = 'Protocol Deviation';
		$data['subject'] = $this->Model_Subject->find($id);

		$this->load->model('Model_Protocol_deviation_form');		
		$data['list'] = $this->Model_Protocol_deviation_form->allWhere('subject_id',$id);	

		$this->auditlib->save_audit("View protocol deviation form");

		$this->load->view('template', $data);
	}

	public function protocol_deviation_form_insert(){
		$registro = $this->input->post();

		$id = $registro['subject_id'];

		$this->form_validation->set_rules('date_of_deviation', 'Date of Deviation', 'required|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'required|xss_clean');     
        $this->form_validation->set_rules('pre_approved', 'Pre-Approved', 'required|xss_clean');

        

        if (isset($registro['pre_approved']) AND $registro['pre_approved'] == 1) {
        	$this->form_validation->set_rules('sponsor_name', 'Sponsor Name', 'required|xss_clean');
        }else{
        	$this->form_validation->set_rules('sponsor_name', 'Sponsor Name', 'xss_clean');
        }
     	
     	if ($this->form_validation->run() == FALSE) {
     		$this->auditlib->save_audit("Has validation errors in protocol deviation form");
            $this->protocol_deviation_form($id);
        }
        else {						
			
			$registro['created'] = date('Y/m/d H:i:s');			
			
			$this->load->model("Model_Protocol_deviation_form");
			$this->Model_Protocol_deviation_form->insert($registro);			
			$this->auditlib->save_audit("Insert new protocl deviation record");

			redirect('subject/protocol_deviation_show/'. $id);
        }   
        
	}

	public function protocol_deviation_show($id){
		$data['contenido'] = 'subject/protocol_deviation_show';
		$data['titulo'] = 'Protocol Deviation';
		$data['subject'] = $this->Model_Subject->find($id);

		$this->load->model('Model_Protocol_deviation_form');		
		$data['list'] = $this->Model_Protocol_deviation_form->allWhere('subject_id',$id);

		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$id,"form"=>"Protocol Deviation"));

		$this->auditlib->save_audit("View list of protocol deviation");

		$this->load->view('template', $data);
	}

	public function concomitant_medication_form($id){
		$data['contenido'] = 'subject/concomitant_medication';
		$data['titulo'] = 'Concomitant Medication';
		$data['subject'] = $this->Model_Subject->find($id);

		$this->load->model('Model_Concomitant_medication_form');		
		$data['list'] = $this->Model_Concomitant_medication_form->allWhere('subject_id',$id);



		$this->auditlib->save_audit("view concomitant medication form");

		$this->load->view('template', $data);
	}

	public function concomitant_medication_form_insert(){
		$registro = $this->input->post();

		$id = $registro['subject_id'];

		$this->form_validation->set_rules('brand_name', 'Brand Name', 'required|xss_clean');
        $this->form_validation->set_rules('generic_name', 'Generic Name', 'required|xss_clean');     
        $this->form_validation->set_rules('indication', 'Indications', 'required|xss_clean');
        $this->form_validation->set_rules('unit_of_measure', 'Unit of Measure', 'required|xss_clean');
        $this->form_validation->set_rules('daily_dose', 'Daily Dose', 'required|xss_clean');        
        $this->form_validation->set_rules('frequency', 'Frequency', 'required|xss_clean');
        if($registro['frequency'] == 'Other'){

        	$this->form_validation->set_rules('other', 'Other Frequency', 'required|xss_clean');
        }else{
        	$this->form_validation->set_rules('other', 'Other Frequency', 'xss_clean');
        }

        $this->form_validation->set_rules('route', 'Route', 'required|xss_clean');
        $this->form_validation->set_rules('start_date', 'Star Date', 'required|xss_clean');
        $this->form_validation->set_rules('on_going', 'On Going', 'required|xss_clean');
        if(isset($registro['on_going']) AND $registro['on_going'] == 0){
        	$this->form_validation->set_rules('end_date', 'End Date', 'required|xss_clean');
        }
        else{
        	$this->form_validation->set_rules('end_date', 'End Date', 'xss_clean');	
        }

             	
     	if ($this->form_validation->run() == FALSE) {
     		$this->auditlib->save_audit("has validation errors in concomitant medication form");
            $this->concomitant_medication_form($id);
        }
        else {						
			
        	if($registro['frequency'] == 'other'){
        		$registro['frequency'] = $registro['other'];
        	}
        	unset($registro['other']);

			$registro['created'] = date('Y/m/d H:i:s');			
			
			$this->load->model("Model_Concomitant_medication_form");
			$this->Model_Concomitant_medication_form->insert($registro);			
			$this->auditlib->save_audit("Insert new concomitant medication record for a subject");

			redirect('subject/concomitant_medication_show/'. $id);
        }   
	}	

	public function concomitant_medication_show($id){
		$data['contenido'] = 'subject/concomitant_medication_show';
		$data['titulo'] = 'Concomitant Medication';
		$data['subject'] = $this->Model_Subject->find($id);

		$this->load->model('Model_Concomitant_medication_form');		
		$data['list'] = $this->Model_Concomitant_medication_form->allWhere('subject_id',$id);

		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$id,"form"=>"Concomitant Medication"));

		$this->auditlib->save_audit("Show list for concomitant medication for a subject");
		$this->load->view('template', $data);
	}

	public function hachinski_form($id){
		$data['contenido'] = 'subject/hachinski';
		$data['titulo'] = 'Escala de Hachinski modificada';
		$data['subject'] = $this->Model_Subject->find($id);

		$this->load->view('template', $data);
	}
	public function hachinski_insert(){

		$save = $this->input->post();
		$id = $save['subject_id'];
		/*Validamos los campos solo para que existan en caso de utilizar formularios codeigniter, ya que para este form todo es opcional*/
		$this->form_validation->set_rules('comienzo_brusco', 'comienzo_brusco', 'xss_clean');
		$this->form_validation->set_rules('deterioro_escalonado', 'deterioro_escalonado', 'xss_clean');
		$this->form_validation->set_rules('curso_fluctante', 'curso_fluctante', 'xss_clean');
		$this->form_validation->set_rules('desorientacion_noctura', 'desorientacion_noctura', 'xss_clean');
		$this->form_validation->set_rules('preservacion_relativa', 'preservacion_relativa', 'xss_clean');
		$this->form_validation->set_rules('depresion', 'depresion', 'xss_clean');
		$this->form_validation->set_rules('somatizacion', 'somatizacion', 'xss_clean');
		$this->form_validation->set_rules('labilidad_emocional', 'labilidad_emocional', 'xss_clean');
		$this->form_validation->set_rules('hta', 'hta', 'xss_clean');
		$this->form_validation->set_rules('ictus_previos', 'ictus_previos', 'xss_clean');
		$this->form_validation->set_rules('evidencia_arteriosclerosis', 'evidencia_arteriosclerosis', 'xss_clean');
		$this->form_validation->set_rules('sintomas_neurologicos', 'sintomas_neurologicos', 'xss_clean');
		$this->form_validation->set_rules('signos_neurologicos', 'signos_neurologicos', 'xss_clean');
		$this->form_validation->set_rules('subject_id', 'subject_id', 'xss_clean');
		$this->form_validation->set_rules('total', 'Total', 'xss_clean');

		if ($this->form_validation->run() == TRUE) {
     		$save = $this->input->post();

     		$save['created_at'] = date('Y/m/d H:i:s');		
     		$save['updated_at'] = date('Y/m/d H:i:s');		
     		$save['created_by'] = $this->session->userdata('usuario');		
     		$save['status']  = "Record Complete";
     		$save['stage']  = "stage_1";

     		$this->load->model('Model_Hachinski_Form');
     		$this->Model_Hachinski_Form->insert($save);
     		$this->auditlib->save_audit("Escala de Hachinski ingresada");

     		$this->hachinski_show($id);

        }
        else {						
			
        	$this->hachinski_form($id);
        }

	}
	public function hachinski_update(){
		
	}
	
	public function hachinski_show($id){
		$data['contenido'] = 'subject/hachinski_show';
		$data['titulo'] = 'Escala de Hachinski modificada';
		$data['subject'] = $this->Model_Subject->find($id);

		$this->load->model('Model_Hachinski_Form');
		$data['list'] = $this->Model_Hachinski_Form->allWhere("subject_id", $id);
		#echo $this->db->last_query();
		$this->load->view('template', $data);
	}	

	public function hachinski_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("has validation errors verifing demography form");
			$this->hachinski_show($registro['id']);
		}
		else {
			$registro['hachinski_last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['hachinski_status'] = 'Form Approved by Monitor';
			$registro['updated'] = date('Y-m-d H:i:s');
			$registro['hachinski_verify_user'] = $this->session->userdata('usuario');
			$registro['hachinski_verify_date'] = date('Y-m-d');

			$this->load->model('Model_Hachinski_Form');
			$this->Model_Hachinski_Form->update($registro);
			$this->auditlib->save_audit("Verified hachinski form");

			redirect('subject/grid/'.$registro['id']);
		}
	}

	public function hachinski_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("has validation errors updating hachinski signature");
			$this->hachinski_show($registro['id']);
		}
		else {
			$registro['hachinski_last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['hachinskistatus'] = 'Document Approved and Signed by PI';
			$registro['updated'] = date('Y-m-d H:i:s');
			$registro['hachinski_signature_user'] = $this->session->userdata('usuario');
			$registro['hachinski_signature_date'] = date('Y-m-d');

			$this->load->model('Model_Hachinski_Form');
			$this->Model_Hachinski_Form->update($registro);
			$this->auditlib->save_audit("Sign hachinski form");

			redirect('subject/grid/'.$registro['id']);
		}
	}

	public function hachinski_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("has validation errors updating hachinski lock");
			$this->hachinski_show($registro['id']);
		}
		else {
			$registro['hachinski_last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['hachinski_status'] = 'Form Approved and Locked';
			$registro['updated'] = date('Y-m-d H:i:s');
			$registro['hachinski_lock_user'] = $this->session->userdata('usuario');
			$registro['hachinski_lock_date'] = date('Y-m-d');

			$this->load->model('Model_Hachinski_Form');
			$this->Model_Hachinski_Form->update($registro);
			$this->auditlib->save_audit("Lock hachinski form");

			redirect('subject/grid/'.$registro['id']);
		}
	}

	public function historial_medico($id){
		$data['contenido'] = 'subject/historial_medico';
		$data['titulo'] = 'Historia Medica';
		$data['subject'] = $this->Model_Subject->find($id);

		$this->load->view('template', $data);
	}

	public function historial_medico_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Subject ID', 'required|xss_clean');

		if(isset($registro['hallazgo']) AND $registro['hallazgo'] == 1){
			$this->form_validation->set_rules('cardiovascular', 'Cardiovascular', 'required|xss_clean');
			$this->form_validation->set_rules('periferico', 'Vascular Periferico', 'required|xss_clean');
			$this->form_validation->set_rules('oidos', 'Oidos y Garganta', 'required|xss_clean');
			$this->form_validation->set_rules('neurologico', 'Neurologico', 'required|xss_clean');
			$this->form_validation->set_rules('pulmones', 'Pulmones/Respiratorio', 'required|xss_clean');
			$this->form_validation->set_rules('renal', 'Renal/Urinario', 'required|xss_clean');
			$this->form_validation->set_rules('ginecologico', 'Ginecologico', 'required|xss_clean');
			$this->form_validation->set_rules('endocrino', 'Endocrino/Metabolico', 'required|xss_clean');
			$this->form_validation->set_rules('hepatico', 'Hepatico', 'required|xss_clean');
			$this->form_validation->set_rules('gastrointestinal', 'Gastrointestinal', 'required|xss_clean');
			$this->form_validation->set_rules('muscular', 'Muscular/Esqueletico', 'required|xss_clean');
			$this->form_validation->set_rules('cancer', 'Cancer', 'required|xss_clean');
		}
		else{
			$this->form_validation->set_rules('cardiovascular', 'Cardiovascular', 'xss_clean');
			$this->form_validation->set_rules('periferico', 'Vascular Periferico', 'xss_clean');
			$this->form_validation->set_rules('oidos', 'Oidos y Garganta', 'xss_clean');
			$this->form_validation->set_rules('neurologico', 'Neurologico', 'xss_clean');
			$this->form_validation->set_rules('pulmones', 'Pulmones/Respiratorio', 'xss_clean');
			$this->form_validation->set_rules('renal', 'Renal/Urinario', 'xss_clean');
			$this->form_validation->set_rules('ginecologico', 'Ginecologico', 'xss_clean');
			$this->form_validation->set_rules('endocrino', 'Endocrino/Metabolico', 'xss_clean');
			$this->form_validation->set_rules('hepatico', 'Hepatico', 'xss_clean');
			$this->form_validation->set_rules('gastrointestinal', 'Gastrointestinal', 'xss_clean');
			$this->form_validation->set_rules('muscular', 'Muscular/Esqueletico', 'xss_clean');
			$this->form_validation->set_rules('cancer', 'Cancer', 'xss_clean');
		}
		$this->form_validation->set_rules('id', 'Subject ID', 'required|xss_clean');


		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Tuvo errores al tratar de agregar historial medico");
			$this->historial_medico($registro['id']);
		}
		else {
			
		}
	}

}