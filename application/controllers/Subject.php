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
		$this->auditlib->save_audit("Vio la lista de sujetos");
		$this->load->view('template', $data);
    }

    public function search() {
		$data['contenido'] = 'subject/index';
		$data['titulo'] = 'Subject Report';
		$value = $this->input->post('buscar');
		$data['query'] = $this->Model_Subject->allFiltered('subject.id', $value);
		$this->auditlib->save_audit("Busco a un sujeto");
		$this->load->view('template', $data);
	}

    public function my_validation() {
		#return $this->usuariolib->my_validation($this->input->post());
	}

	public function create() {
		$data['contenido'] = 'subject/create';
		$data['titulo'] = 'New Subject';		
		$this->auditlib->save_audit("Entro al formulario de ingreso de sujetos");
		$this->load->view('template', $data);
	}

	public function insert() {		

		$this->form_validation->set_rules('seguro', 'Esta seguro', 'required|xss_clean');
       

        if ($this->form_validation->run() == FALSE) {
        	$this->auditlib->save_audit("Error al tratar de crear un sujeto");
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


			$save['code'] = $center ."-". $num;
			$save['center'] = $this->session->userdata('center_id');
			$save['screening_date'] = date('Y-m-d');
			$save['created'] = date('Y/m/d H:i:s');
			$save['updated'] = date('Y/m/d H:i:s');
			
			$this->Model_Subject->insert($save);			
			$this->auditlib->save_audit("Creo un nuevo sujeto: ". $save['code']);
			redirect('subject/index');
        }
	}

	public function edit($id) {
		// $id = $this->uri->segment(3);

		$data['contenido'] = 'subject/edit';
		$data['titulo'] = 'Actualizar Sujeto';
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

		$this->auditlib->save_audit("Entro al formulario de edicion de sujetos", $id);
		$this->load->view('template', $data);
	}

	public function update() {
		$registro = $this->input->post();

		$this->form_validation->set_rules('sign_consent', 'Firma Consentimiento', 'required|xss_clean');
		if(isset($registro['sign_consent']) AND $registro['sign_consent'] == 1){
			$this->form_validation->set_rules('sign_consent_date', 'Fecha Firma Consentimiento', 'required|xss_clean');
		}
		else{
			$this->form_validation->set_rules('sign_consent_date', 'Fecha Firma Consentimiento', 'xss_clean');	
		}
		$this->form_validation->set_rules('initials', 'Iniciales', 'required|xss_clean');
        $this->form_validation->set_rules('edad', 'Edad', 'required|xss_clean');
        $this->form_validation->set_rules('gender', 'Sexo', 'required|xss_clean');
        $this->form_validation->set_rules('birth_date', 'Fecha de Nacimiento', 'required|xss_clean');
		$this->form_validation->set_rules('race', 'Etnia/Raza', 'required|xss_clean');
		$this->form_validation->set_rules('escolaridad', 'Grado de escolaridad', 'required|xss_clean');        
        $this->form_validation->set_rules('center', 'Centro', 'required|xss_clean');
        $this->form_validation->set_rules('id', 'Id', 'required|xss_clean');
        
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al editar datos demograficos del sujeto", $registro['id']);
			$this->edit($registro['id']);
		}
		else {
			$registro['updated'] = date('Y/m/d H:i');
			$this->Model_Subject->update($registro);
			$this->auditlib->save_audit("Actualizo datos de demografia del sujeto", $registro['id']);
			redirect('subject/index');
		}
	}

	public function grid($id) {
		// $id = $this->uri->segment(3);

		$data['contenido'] = 'subject/grid';
		$data['titulo'] = 'Subject Record';
		$data['subject'] = $this->Model_Subject->find($id);
		$this->auditlib->save_audit("Entro a la vista de formularios del sujeto", $id);
		$this->load->view('template', $data);
	}

	public function demography($id){
		$data['contenido'] = 'subject/demography';
		$data['titulo'] = 'Subject Demography';
		$data['subject'] = $this->Model_Subject->find($id);
		
		#querys about demography
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$id,"form"=>"Demography"));
		
		$this->auditlib->save_audit("Entro al formulario de demografia",$id);
		
		$this->load->view('template', $data);

	}
	public function demography_update(){

		$registro = $this->input->post();

		$this->form_validation->set_rules('sign_consent', 'Firmo el Concentimiento', 'required|xss_clean');

		if(isset($registro['sign_consent']) AND $registro['sign_consent'] != ''){
			$this->form_validation->set_rules('sign_consent_date', 'Fecha firma del concentimiento', 'required|xss_clean');					
		}
		else{
			$this->form_validation->set_rules('sign_consent_date', 'Fecha firma del concentimiento', 'xss_clean');
		}

		$this->form_validation->set_rules('birth_date', 'Fecha de Nacimiento', 'required|xss_clean');
        $this->form_validation->set_rules('initials', 'Iniciales', 'required|xss_clean');
        $this->form_validation->set_rules('edad', 'Edad', 'required|xss_clean');
        $this->form_validation->set_rules('gender', 'Sexo', 'required|xss_clean'); 
        $this->form_validation->set_rules('race', 'Etnia/Raza', 'required|xss_clean');
        $this->form_validation->set_rules('escolaridad', 'Grado de Escolaridad', 'required|xss_clean');	
		
        
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Tiene errores de validacion al editar la demografia",$registro['id']);
			$this->demography($registro['id']);
		}
		else {
			$registro['demography_status'] = 'Record Complete';
			$registro['updated'] = date('Y/m/d H:i');
			$this->Model_Subject->update($registro);
			$this->auditlib->save_audit("Actualizo la informacion demografica", $registro['id']);
			redirect('subject/grid/'.$registro['id']);
		}
	}
	
	public function demography_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Tuvo errores de validacion al tratar de verificar el formulario de demografia", $registro['id']);
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
			$this->auditlib->save_audit("Verifico el formulario de demografia", $registro['id']);

			redirect('subject/grid/'.$registro['id']);
		}
	}

	public function demography_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al firmar formulario de demografia", $registro['id']);
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
			$this->auditlib->save_audit("Firmo el formulario de demografia", $registro['id']);

			redirect('subject/grid/'.$registro['id']);
		}
	}

	public function demography_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al cerrar el formulario de demografia", $registro['id']);
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
			$this->auditlib->save_audit("Cerro el formulario de demografia", $registro['id']);

			redirect('subject/grid/'.$registro['id']);
		}
	}


	public function randomization($id) {
		// $id = $this->uri->segment(3);

		$data['contenido'] = 'subject/randomization';
		$data['titulo'] = 'Subject Randomization';
		$data['subject'] = $this->Model_Subject->find($id);
		$this->auditlib->save_audit("Entro al formulario de randomizacion", $id);
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
        	$this->auditlib->save_audit("Tiene errores al tratar de randomizar", $registro['id']);        	
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
			$this->auditlib->save_audit("Randomizo un sujeto", $id);
			redirect('subject/grid/'. $id);
        }
        
	}

	function stock($center){
		/*search quantity of kits in warehouse*/		
		$this->load->Model("Model_Kit");
		$qty = $this->Model_Kit->qtyByCenter($center);

		if($qty[0]->qty == 0){
			$this->form_validation->set_message('stock', 'No hay stock en el centro');
			return false;
		}
		else{
			return true;
		}
	}

/*-----------------------| | |---------------------------------------| | |-----------------------------------------------------------------*/
/*-----------------------| | |------------------FORMULARIOS----------| | |-----------------------------------------------------------------*/
/*-----------------------V V V---------------------------------------V V V-----------------------------------------------------------------*/



/*-------------------------------------------ADVERSE EVENT---------------------------------------------------------------------------*/
	public function adverse_event_form($id){
		$data['contenido'] = 'subject/adverse_event';
		$data['titulo'] = 'Adverse Event/Serious Adverse Event';
		$data['subject'] = $this->Model_Subject->find($id);

		#$this->load->model('Model_Adverse_event_form');		
		#$data['list'] = $this->Model_Adverse_event_form->allWhere('subject_id',$id);
		$this->auditlib->save_audit("Entro al formulario de evento adverso", $id);
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
        	$this->auditlib->save_audit("Tiene errores de validacion en el formulario de evento adverso",$id);
            $this->adverse_event_form($id);
        }
        else {						
			
			$registro['created'] = date('Y/m/d H:i:s');			
			
			$this->load->model("Model_Adverse_event_form");
			$this->Model_Adverse_event_form->insert($registro);			
			$this->auditlib->save_audit("Agrego informacion de evento adverso",$id);
			redirect('subject/adverse_event_show/'. $id);
        }
	}

	public function adverse_event_show($id){
		$data['contenido'] = 'subject/adverse_event_show';
		$data['titulo'] = 'Evento Adverso';
		$data['subject'] = $this->Model_Subject->find($id);

		$this->load->model('Model_Adverse_event_form');		
		$data['list'] = $this->Model_Adverse_event_form->allWhere('subject_id',$id);

		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$id,"form"=>"Adverse Event"));

		$this->auditlib->save_audit("Entro a lista de eventos adversos",$id);

		$this->load->view('template', $data);
	}
/*-------------------------------------------PROTOCOL DEVIATON---------------------------------------------------------------------------*/
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
/*-------------------------------------------CONCOMICANT MEDICATION--------------------------------------------------------------------------*/
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
	/*-------------------------------------------HACHINSKI---------------------------------------------------------------------------*/

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

     		$save['created_at'] = date('Y/m/d H:i:s');		
     		$save['updated_at'] = date('Y/m/d H:i:s');		
     		$save['created_by'] = $this->session->userdata('usuario');		
     		$save['status']  = "Record Complete";
     		$save['stage']  = "stage_1";

     		$this->load->model('Model_Hachinski_Form');
     		$this->Model_Hachinski_Form->insert($save);
     		$this->auditlib->save_audit("Escala de Hachinski ingresada",$id);

     		/*Actualizar estado de hachinski en el sujeto*/
     		$actualizar['hachinski_status'] = 'Record Complete';
     		$actualizar['id'] = $id;
     		$this->Model_Subject->update($actualizar);

     		redirect('subject/hachinski_show/'. $id);

        }
        else {						
			
        	$this->hachinski_form($id);
        }

	}

	public function hachinski_update(){
		
		$save = $this->input->post();
		$save['updated_at'] = date('Y/m/d H:i:s');

		$id = $save['subject_id'];

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

			$this->load->model('Model_Hachinski_Form');
	 		$this->Model_Hachinski_Form->update($save);
	 		$this->auditlib->save_audit("Escala de Hachinski Actualizada",$id);

	 		redirect('subject/hachinski_show/'. $id);
 		}
 		else{
 			$this->hachinski_form($id);
 		}

	}
	
	public function hachinski_show($id){
		$data['contenido'] = 'subject/hachinski_show';
		$data['titulo'] = 'Escala de Hachinski modificada';
		$data['subject'] = $this->Model_Subject->find($id);

		$this->load->model('Model_Hachinski_Form');
		$data['list'] = $this->Model_Hachinski_Form->allWhere("subject_id", $id);
		#echo $this->db->last_query();
		
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$id,"form"=>"Hachinski"));

		$this->load->view('template', $data);
	}	

	public function hachinski_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario hachinski", $registro['subject_id']);
			$this->hachinski_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Hachinski_Form');
			$this->Model_Hachinski_Form->update($registro);
			$this->auditlib->save_audit("Verificacion de el formulario hachinski", $registro['subject_id']);

			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('hachinski_status'=>'Form Approved by Monitor','id'=>$registro['subject_id']));

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function hachinski_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario hachinski", $registro['subject_id']);
			$this->hachinski_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Hachinski_Form');
			$this->Model_Hachinski_Form->update($registro);
			$this->auditlib->save_audit("Firmo el formulario hachinski", $registro['subject_id']);
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('hachinski_status'=>'Document Approved and Signed by PI', 'id'=>$registro['subject_id']));

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function hachinski_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario hachinski", $registro['subject_id']);
			$this->hachinski_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Hachinski_Form');
			$this->Model_Hachinski_Form->update($registro);
			$this->auditlib->save_audit("Cerro el formulario hachinski", $registro['subject_id']);
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('hachinski_status'=>'Form Approved and Locked','id'=>$registro['subject_id']));

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
/*-------------------------------------------HISTORIAL MEDICO---------------------------------------------------------------------------*/
	public function historial_medico($id,$etapa){
		$data['contenido'] = 'subject/historial_medico';
		$data['titulo'] = 'Historia Medica';
		$data['subject'] = $this->Model_Subject->find($id);
		$data['etapa'] = $etapa;

		$this->load->view('template', $data);
	}

	public function historial_medico_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');
		$this->form_validation->set_rules('hallazgo', 'Hallazgo', 'required|xss_clean');

		/*Si se tiene algun hallazgo todo es obligatorio*/
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
			/*$this->form_validation->set_rules('cardiovascular', 'Cardiovascular', 'xss_clean');
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
			$this->form_validation->set_rules('cancer', 'Cancer', 'xss_clean');*/
		}
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');


		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Tuvo errores al tratar de agregar historial medico", $registro['subject_id']);
			$this->historial_medico($registro['subject_id'],$registro['etapa']);
		}
		else {
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['status'] = "Record Complete";
			$registro['usuario_creacion'] = $this->session->userdata('usuario');

			$this->load->model("Model_Historial_medico");
			$this->Model_Historial_medico->insert($registro);

			$this->auditlib->save_audit("Historial Medico Ingresado", $registro['subject_id']);


			/*Actualizar estado en el sujeto*/
			if($registro['etapa'] == 1){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'historial_medico_1_status'=>'Record Complete'));
			}
			elseif($registro['etapa'] == 2){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'historial_medico_2_status'=>'Record Complete'));
			}

     		$this->historial_medico_show($registro['subject_id'],$registro['etapa']);
		}
	}

	public function historial_medico_show($id,$etapa){
		$data['contenido'] = 'subject/historial_medico_show';
		$data['titulo'] = 'Historia Medica';
		$data['subject'] = $this->Model_Subject->find($id);
		$data['etapa'] = $etapa;

		$this->load->model("Model_Historial_medico");
		$data['list'] = $this->Model_Historial_medico->allWhereArray(array('subject_id'=>$id, 'etapa'=>$etapa));

		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$id,"form"=>"Historial Medico", "etapa"=>$etapa));

		$this->load->view('template', $data);
	}

	public function historial_medico_update(){

		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');
		$this->form_validation->set_rules('hallazgo', 'Hallazgo', 'required|xss_clean');

		/*Si se tiene algun hallazgo todo es obligatorio*/
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

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Tuvo errores al tratar de actualizar el historial medico", $registro['subject_id']);
			$this->historial_medico_show($registro['subject_id'], $registro['etapa']);
		}
		else {			
			$registro['updated_at'] = date("Y-m-d H:i:s");						

			$this->load->model("Model_Historial_medico");
			$this->Model_Historial_medico->update($registro);

			$this->auditlib->save_audit("Historial Medico Actualizado",$registro['subject_id']);

     		$this->historial_medico_show($registro['subject_id'],$registro['etapa']);
		}
	}

	public function historial_medico_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de Historial Medico", $registro['subject_id']);
			$this->historial_medico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Historial_medico');
			$this->Model_Historial_medico->update($registro);
			$this->auditlib->save_audit("Verificacion de el formulario de Historial Medico", $registro['subject_id']);

			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('historial_medico_status'=>'Form Approved by Monitor','id'=>$registro['subject_id']));

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function historial_medico_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Historial Medico", $registro['subject_id']);
			$this->historial_medico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Historial_medico');
			$this->Model_Historial_medico->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de Historial Medico", $registro['subject_id']);
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('historial_medico_status'=>'Document Approved and Signed by PI','id'=>$registro['subject_id']));

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function historial_medico_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de Historial Medico", $registro['subject_id']);
			$this->historial_medico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Historial_medico');
			$this->Model_Historial_medico->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de Historial Medico", $registro['subject_id']);
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('historial_medico_status'=>'Form Approved and Locked','id'=>$registro['subject_id']));

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
/*-------------------------------------------INCLUSION EXCLUSION---------------------------------------------------------------------------*/
	public function inclusion($subject_id, $etapa){

		$data['contenido'] = 'subject/inclusion';
		$data['titulo'] = 'Criterios de Inclusion/Exclusion';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;
		

		$this->load->view('template', $data);			
	}

	public function inclusion_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');
		$this->form_validation->set_rules('cumple_criterios', 'Cumple Criterio', 'required|xss_clean');
		$this->form_validation->set_rules('autorizacion_patrocinador', 'Autorizacion Patrocinador', 'required|xss_clean');		

		/*Validar si ingresa un numero o un comentario este tenga su par ya sea numero o comentario*/

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Tuvo errores al tratar de agregar formulario de inclusion exclusion", $registro['subject_id']);
			$this->inclusion($registro['subject_id'], $registro['etapa']);
		}
		else {
			
			if($registro['etapa'] == 1){				
				$subjet_['inclusion_exclusion_1_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 2){
				$subjet_['inclusion_exclusion_2_status'] = "Record Complete";
			}

			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");

			/*Salvamos la lista de no respetados*/
			$numeros = $registro['numero'];
			$comentarios = $registro['comentario'];

			unset($registro['numero']);
			unset($registro['comentario']);

			$this->load->model('Model_Inclusion_exclusion');
			$this->Model_Inclusion_exclusion->insert($registro);

			$nueva_id = $this->db->insert_id();

			/*Ingresamos la lista de no respetados*/
			$cant = count($numeros);

			for($i=0; $i<$cant; $i++){

				if($numeros[$i] != '' AND $comentarios[$i] != ''){
					$save['inclusion_exclusion_id'] = $nueva_id;
					$save['numero_criterio'] = $numeros[$i];
					$save['comentario'] = $comentarios[$i];
					$save['created_at'] = date("Y-m-d H:i:s");
					$save['updated_at'] = date("Y-m-d H:i:s");
					$save['usuario_creacion'] = $this->session->userdata('usuario');

					$this->load->model("Model_Inclusion_exclusion_no_respetados");
					$this->Model_Inclusion_exclusion_no_respetados->insert($save);
				}
			}

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Critero de inclusion exclusion agregado", $registro['subject_id']);     		
     		redirect('subject/inclusion_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
	}

	public function inclusion_show($subject_id, $etapa){
		$data['contenido'] = 'subject/inclusion_show';
		$data['titulo'] = 'Criterios de Inclusion/Exclusion';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;
		
		/*Formulario para la etapa y sujeto correspondiente*/
		$this->load->model('Model_Inclusion_exclusion');
		$data['list'] = $this->Model_Inclusion_exclusion->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));
		
		/*Buscar todos los numeros y comentarios asociados a este form*/		
		$this->load->model("Model_Inclusion_exclusion_no_respetados");
		$data['no_respetados'] = $this->Model_Inclusion_exclusion_no_respetados->allWhereArray(array('inclusion_exclusion_id'=>$data['list'][0]->id));		

		/*querys*/
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"Inclusion Exclusion", "etapa"=>$etapa));
		
		$this->load->view('template', $data);					
	}


	public function inclusion_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');
		$this->form_validation->set_rules('cumple_criterios', 'Cumple Criterio', 'required|xss_clean');
		$this->form_validation->set_rules('autorizacion_patrocinador', 'Autorizacion Patrocinador', 'required|xss_clean');	

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Tuvo errores al tratar de actualizar el formulario de inclusion exclusion", $registro['subject_id']);
			$this->inclusion($registro['subject_id'], $registro['etapa']);
		}
		else {
			/*Separar los datos de inclusion con los de no respetados*/
		}
	}

	public function inclusion_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de Inclusion Exclusion", $registro['subject_id']);
			$this->inclusion_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Inclusion_exclusion');
			$this->Model_Inclusion_exclusion->update($registro);
			$this->auditlib->save_audit("Verificacion de el formulario de Inclusion Exclusion", $registro['subject_id']);

			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('inclusion_exclusion_1_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('inclusion_exclusion_2_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function inclusion_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Inclusion Exclusion", $registro['subject_id']);
			$this->inclusion_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Inclusion_exclusion');
			$this->Model_Inclusion_exclusion->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de Inclusion Exclusion", $registro['subject_id']);
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('inclusion_exclusion_1_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('inclusion_exclusion_2_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function inclusion_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de Inclusion Exclusion", $registro['subject_id']);
			$this->inclusion_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Inclusion_exclusion');
			$this->Model_Inclusion_exclusion->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de Inclusion Exclusion", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('inclusion_exclusion_1_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('inclusion_exclusion_2_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
/*-------------------------------------------DIGITO DIRECTO---------------------------------------------------------------------------*/
	public function digito_directo($subject_id, $etapa){
		$data['contenido'] = 'subject/digito_directo';
		$data['titulo'] = 'Prueba de Digito Directo';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;
		$data['valores_intento'] = array(''=>'','0'=>'0','1'=>'1');
		$data['valores_item'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2');

		$this->load->view('template', $data);
	}

	public function digito_directo_insert(){
		
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');				

		$this->form_validation->set_rules('realizado', '', 'xss_clean');
		$this->form_validation->set_rules('fecha', 'Fecha', 'required|xss_clean');

		if(isset($registro['realizado']) AND !empty($registro['realizado'])){
			$this->form_validation->set_rules('puntaje_intento_1a', 'Puntaje Intento 1', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_1b', 'Puntaje Intento 1', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_2a', 'Puntaje Intento 2', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_2b', 'Puntaje Intento 2', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_3a', 'Puntaje Intento 3', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_3b', 'Puntaje Intento 3', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_4a', 'Puntaje Intento 4', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_4b', 'Puntaje Intento 4', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_5a', 'Puntaje Intento 5', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_5b', 'Puntaje Intento 5', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_6a', 'Puntaje Intento 6', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_6b', 'Puntaje Intento 6', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_7a', 'Puntaje Intento 7', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_7b', 'Puntaje Intento 7', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_8a', 'Puntaje Intento 8', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_intento_8b', 'Puntaje Intento 8', 'required|xss_clean');

			$this->form_validation->set_rules('puntaje_item_1a', 'Puntaje Item 1', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_1b', 'Puntaje Item 1', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_2a', 'Puntaje Item 2', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_2b', 'Puntaje Item 2', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_3a', 'Puntaje Item 3', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_3b', 'Puntaje Item 3', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_4a', 'Puntaje Item 4', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_4b', 'Puntaje Item 4', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_5a', 'Puntaje Item 5', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_5b', 'Puntaje Item 5', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_6a', 'Puntaje Item 6', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_6b', 'Puntaje Item 6', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_7a', 'Puntaje Item 7', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_7b', 'Puntaje Item 7', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_8a', 'Puntaje Item 8', 'required|xss_clean');
			$this->form_validation->set_rules('puntaje_item_8b', 'Puntaje Item 8', 'required|xss_clean');
		}
		else{
			$this->form_validation->set_rules('puntaje_intento_1a', 'Puntaje Intento 1', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_1b', 'Puntaje Intento 1', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_2a', 'Puntaje Intento 2', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_2b', 'Puntaje Intento 2', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_3a', 'Puntaje Intento 3', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_3b', 'Puntaje Intento 3', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_4a', 'Puntaje Intento 4', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_4b', 'Puntaje Intento 4', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_5a', 'Puntaje Intento 5', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_5b', 'Puntaje Intento 5', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_6a', 'Puntaje Intento 6', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_6b', 'Puntaje Intento 6', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_7a', 'Puntaje Intento 7', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_7b', 'Puntaje Intento 7', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_8a', 'Puntaje Intento 8', 'xss_clean');
			$this->form_validation->set_rules('puntaje_intento_8b', 'Puntaje Intento 8', 'xss_clean');

			$this->form_validation->set_rules('puntaje_item_1a', 'Puntaje Item 1', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_1b', 'Puntaje Item 1', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_2a', 'Puntaje Item 2', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_2b', 'Puntaje Item 2', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_3a', 'Puntaje Item 3', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_3b', 'Puntaje Item 3', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_4a', 'Puntaje Item 4', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_4b', 'Puntaje Item 4', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_5a', 'Puntaje Item 5', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_5b', 'Puntaje Item 5', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_6a', 'Puntaje Item 6', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_6b', 'Puntaje Item 6', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_7a', 'Puntaje Item 7', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_7b', 'Puntaje Item 7', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_8a', 'Puntaje Item 8', 'xss_clean');
			$this->form_validation->set_rules('puntaje_item_8b', 'Puntaje Item 8', 'xss_clean');	
		}


		if($this->form_validation->run() == FALSE) {

			$this->auditlib->save_audit("Tuvo errores al tratar de agregar formulario de prueba de digito directo", $registro['subject_id']);
			$this->digito_directo($registro['subject_id'], $registro['etapa']);
		}
		else {
			
			if($registro['etapa'] == 2){				
				$subjet_['digito_2_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 4){
				$subjet_['digito_4_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 5){
				$subjet_['digito_5_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 6){
				$subjet_['digito_6__status'] = "Record Complete";
			}

			$registro['status'] = "Record Complete";
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Prueba de digito directo agregada", $registro['subject_id']);     		
     		redirect('subject/digito_directo_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
		
	}

	public function digito_directo_show($subject_id, $etapa){
		$data['contenido'] = 'subject/digito_directo_show';
		$data['titulo'] = 'Prueba de digito directo';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;
		$data['valores_intento'] = array(''=>'','0'=>'0','1'=>'1');
		$data['valores_item'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2');

		/*Formulario para la etapa y sujeto correspondiente*/
		$this->load->model('Model_Digito_directo');
		$data['list'] = $this->Model_Digito_directo->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));		

		/*querys*/
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$id,"form"=>"Digito Directo", "etapa"=>$etapa));
		
		$this->load->view('template', $data);					
	}

	public function digito_directo_update(){

	}

	public function digito_directo_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de Digiti Directo", $registro['subject_id']);
			$this->digito_directo_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Digito_directo');
			$this->Model_Digito_directo->update($registro);
			$this->auditlib->save_audit("Verificacion de el formulario de Digito Directo", $registro['subject_id']);

			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 2){
				$this->Model_Subject->update(array('digito_2_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif(isset($registro['etapa']) AND $registro['etapa'] == 4){
				$this->Model_Subject->update(array('digito_4_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif(isset($registro['etapa']) AND $registro['etapa'] == 5){
				$this->Model_Subject->update(array('digito_5_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('digito_6_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function digito_directo_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Digito Directo", $registro['subject_id']);
			$this->digito_directo_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Digito_directo');
			$this->Model_Digito_directo->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de Digito Directo", $registro['subject_id']);
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 2){
				$this->Model_Subject->update(array('digito_2_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('digito_4_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('digito_5_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('digito_6_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function digito_directo_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de Digito Directo", $registro['subject_id']);
			$this->digito_directo_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Digito_directo');
			$this->Model_Digito_directo->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de Digito Directo", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 2){
				$this->Model_Subject->update(array('digito_2_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('digito_4_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('digito_5_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('digito_6_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
/*----------------------------------------------MMSE------------------------------------------------------------------------------*/
	public function mmse($subject_id, $etapa){

		$data['contenido'] = 'subject/mmse';
		$data['titulo'] = 'MMSE';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;
		$data['puntaje'] = array(''=>'','0'=>'0','1'=>'1');

		$this->load->view('template',$data);
	}

	public function mmse_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'xss_clean');
		$this->form_validation->set_rules('tiene_problemas_memoria', '', 'xss_clean');
		$this->form_validation->set_rules('le_puedo_hacer_preguntas', '', 'xss_clean');
		$this->form_validation->set_rules('fecha', '', 'required|xss_clean');
		$this->form_validation->set_rules('en_que_ano_estamos_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('en_que_estacion_estamos_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('en_que_mes_estamos_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('en_que_dia_estamos_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('en_que_fecha_estamos_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('en_que_region_estamos_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('donde_estas_ahora', '', 'required|xss_clean');
		$this->form_validation->set_rules('donde_estas_ahora_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('comuna_estamos', '', 'required|xss_clean');
		$this->form_validation->set_rules('comuna_estamos_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('barrio_estamos', '', 'required|xss_clean');
		$this->form_validation->set_rules('barrio_estamos_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('edificio_estamos', '', 'required|xss_clean');
		$this->form_validation->set_rules('edificio_estamos_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('manzana', '', 'required|xss_clean');
		$this->form_validation->set_rules('manzana_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('peso', '', 'required|xss_clean');
		$this->form_validation->set_rules('peso_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('mesa', '', 'required|xss_clean');
		$this->form_validation->set_rules('mesa_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('cuanto_93', '', 'required|xss_clean');
		$this->form_validation->set_rules('cuanto_93_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('cuanto_86', '', 'required|xss_clean');
		$this->form_validation->set_rules('cuanto_86_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('cuanto_79', '', 'required|xss_clean');
		$this->form_validation->set_rules('cuanto_79_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('cuanto_72', '', 'required|xss_clean');
		$this->form_validation->set_rules('cuanto_72_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('cuanto_65', '', 'required|xss_clean');
		$this->form_validation->set_rules('cuanto_65_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('manzana_2', '', 'required|xss_clean');
		$this->form_validation->set_rules('manzana_2_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('peso_2', '', 'required|xss_clean');
		$this->form_validation->set_rules('peso_2_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('mesa_2', '', 'required|xss_clean');
		$this->form_validation->set_rules('mesa_2_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('que_es_1', '', 'required|xss_clean');
		$this->form_validation->set_rules('que_es_1_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('que_es_2', '', 'required|xss_clean');
		$this->form_validation->set_rules('que_es_2_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('no_si_cuando_porque', '', 'required|xss_clean');
		$this->form_validation->set_rules('no_si_cuando_porque_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('tomar_con_la_mano_derecha', '', 'required|xss_clean');
		$this->form_validation->set_rules('tomar_con_la_mano_derecha_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('doblar_por_la_mitad', '', 'required|xss_clean');
		$this->form_validation->set_rules('doblar_por_la_mitad_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('poner_en_el_piso', '', 'required|xss_clean');
		$this->form_validation->set_rules('poner_en_el_piso_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('cierre_los_ojos', '', 'required|xss_clean');
		$this->form_validation->set_rules('cierre_los_ojos_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('dibujo_puntaje', '', 'required|xss_clean');
		$this->form_validation->set_rules('', '', 'required|xss_clean');
		$this->form_validation->set_rules('', '', 'required|xss_clean');
	}

	public function mmse_show($subject_id, $etapa){

	}

	public function mmse_update(){
		$registro = $this->input->post();
	}

	public function mmse_verify(){
		$registro = $this->input->post();
	}

	public function mmse_signature(){
		$registro = $this->input->post();
	}

	public function mmse_lock(){
		$registro = $this->input->post();
	}
	/*----------------------------------------------ECG------------------------------------------------------------------------------*/

	public function ecg($subject_id){

		$data['contenido'] = 'subject/ecg';
		$data['titulo'] = 'ECG';
		$data['subject'] = $this->Model_Subject->find($subject_id);						

		$this->load->view('template',$data);
	}

	public function ecg_insert(){
		$registro = $this->input->post();
	}

	public function ecg_show($subject_id, $etapa){

	}

	public function ecg_update(){
		$registro = $this->input->post();
	}

	public function ecg_verify(){
		$registro = $this->input->post();
	}

	public function ecg_signature(){
		$registro = $this->input->post();
	}

	public function ecg_lock(){
		$registro = $this->input->post();
	}

	/*----------------------------------------------Signos Vitales------------------------------------------------------------------------------*/
	public function signos_vitales($subject_id, $etapa){
		$data['contenido'] = 'subject/signos_vitales';
		$data['titulo'] = 'Signos Vitales';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->view('template',$data);
	}

	public function signos_vitales_insert(){
		$registro = $this->input->post();
	}

	public function signos_vitales_show($subject_id, $etapa){

	}

	public function signos_vitales_update(){
		$registro = $this->input->post();
	}

	public function signos_vitales_verify(){
		$registro = $this->input->post();
	}

	public function signos_vitales_signature(){
		$registro = $this->input->post();
	}

	public function signos_vitales_lock(){
		$registro = $this->input->post();
	}

	/*----------------------------------------------Cumplimiento------------------------------------------------------------------------------*/
	public function cumplimiento($subject_id, $etapa){
		$data['contenido'] = 'subject/cumplimiento';
		$data['titulo'] = 'Cumplimiento';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->view('template',$data);
	}

	public function cumplimiento_insert(){
		$registro = $this->input->post();
	}

	public function cumplimiento_show($subject_id, $etapa){

	}

	public function cumplimiento_update(){
		$registro = $this->input->post();
	}

	public function cumplimiento_verify(){
		$registro = $this->input->post();
	}

	public function cumplimiento_signature(){
		$registro = $this->input->post();
	}

	public function cumplimiento_lock(){
		$registro = $this->input->post();
	}
	/*----------------------------------------------Fin Tratamiento------------------------------------------------------------------------------*/
	public function fin_tratamiento($subject_id, $etapa){
		$data['contenido'] = 'subject/fin_tratamiento';
		$data['titulo'] = 'Fin Tratamiento';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->view('template',$data);
	}

	public function fin_tratamiento_insert(){
		$registro = $this->input->post();
	}

	public function fin_tratamiento_show($subject_id, $etapa){

	}

	public function fin_tratamiento_update(){
		$registro = $this->input->post();
	}

	public function fin_tratamiento_verify(){
		$registro = $this->input->post();
	}

	public function fin_tratamiento_signature(){
		$registro = $this->input->post();
	}

	public function fin_tratamiento_lock(){
		$registro = $this->input->post();
	}
	/*----------------------------------------------Fin Tratamiento Temprano------------------------------------------------------------------------------*/
	public function fin_tratamiento_temprano($subject_id, $etapa){
		$data['contenido'] = 'subject/fin_tratamiento_temprano';
		$data['titulo'] = 'Fin Tratamiento Temprano';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->view('template',$data);
	}

	public function fin_tratamiento_temprano_insert(){
		$registro = $this->input->post();
	}

	public function fin_tratamiento_temprano_show($subject_id, $etapa){

	}

	public function fin_tratamiento_temprano_update(){
		$registro = $this->input->post();
	}

	public function fin_tratamiento_temprano_verify(){
		$registro = $this->input->post();
	}

	public function fin_tratamiento_temprano_signature(){
		$registro = $this->input->post();
	}

	public function fin_tratamiento_temprano_lock(){
		$registro = $this->input->post();
	}
	/*----------------------------------------------Muestra de Sangre------------------------------------------------------------------------------*/
	public function muestra_de_sangre($subject_id, $etapa){
		$data['contenido'] = 'subject/muestra_de_sangre';
		$data['titulo'] = 'Muestra de Sangre';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->view('template',$data);
	}

	public function muestra_de_sangre_insert(){
		$registro = $this->input->post();
	}

	public function muestra_de_sangre_show($subject_id, $etapa){

	}

	public function muestra_de_sangre_update(){
		$registro = $this->input->post();
	}

	public function muestra_de_sangre_verify(){
		$registro = $this->input->post();
	}

	public function muestra_de_sangre_signature(){
		$registro = $this->input->post();
	}

	public function muestra_de_sangre_lock(){
		$registro = $this->input->post();
	}
	/*----------------------------------------------Examen Neurologico------------------------------------------------------------------------------*/	
	public function examen_neurologico($subject_id, $etapa){
		$data['contenido'] = 'subject/examen_neurologico';
		$data['titulo'] = 'Examen Neurologico';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->view('template',$data);
	}

	public function examen_neurologico_insert(){
		$registro = $this->input->post();
	}

	public function examen_neurologico_show($subject_id, $etapa){

	}

	public function examen_neurologico_update(){
		$registro = $this->input->post();
	}

	public function examen_neurologico_verify(){
		$registro = $this->input->post();
	}

	public function examen_neurologico_signature(){
		$registro = $this->input->post();
	}

	public function examen_neurologico_lock(){
		$registro = $this->input->post();
	}
	/*----------------------------------------------Examen Laboratorio------------------------------------------------------------------------------*/
	public function examen_laboratorio($subject_id, $etapa){
		$data['contenido'] = 'subject/examen_laboratorio';
		$data['titulo'] = 'Examen Laboratorio';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->view('template',$data);
	}

	public function examen_laboratorio_insert(){
		$registro = $this->input->post();
	}

	public function examen_laboratorio_show($subject_id, $etapa){

	}

	public function examen_laboratorio_update(){
		$registro = $this->input->post();
	}

	public function examen_laboratorio_verify(){
		$registro = $this->input->post();
	}

	public function examen_laboratorio_signature(){
		$registro = $this->input->post();
	}

	public function examen_laboratorio_lock(){
		$registro = $this->input->post();
	}
	
} 