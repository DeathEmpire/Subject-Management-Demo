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

			if(!isset($save['comienzo_brusco']) OR empty($save['comienzo_brusco'])){
				$save['comienzo_brusco'] = 0;
			}
			if(!isset($save['deterioro_escalonado']) OR empty($save['deterioro_escalonado'])){
				$save['deterioro_escalonado'] = 0;
			}
			if(!isset($save['curso_fluctante']) OR empty($save['curso_fluctante'])){
				$save['curso_fluctante'] = 0;
			}
			if(!isset($save['desorientacion_noctura']) OR empty($save['desorientacion_noctura'])){
				$save['desorientacion_noctura'] = 0;
			}
			if(!isset($save['preservacion_relativa']) OR empty($save['preservacion_relativa'])){
				$save['preservacion_relativa'] = 0;
			}
			if(!isset($save['depresion']) OR empty($save['depresion'])){
				$save['depresion'] = 0;
			}
			if(!isset($save['somatizacion']) OR empty($save['somatizacion'])){
				$save['somatizacion'] = 0;
			}
			if(!isset($save['labilidad_emocional']) OR empty($save['labilidad_emocional'])){
				$save['labilidad_emocional'] = 0;
			}
			if(!isset($save['hta']) OR empty($save['hta'])){
				$save['hta'] = 0;
			}
			if(!isset($save['ictus_previos']) OR empty($save['ictus_previos'])){
				$save['ictus_previos'] = 0;
			}
			if(!isset($save['evidencia_arteriosclerosis']) OR empty($save['evidencia_arteriosclerosis'])){
				$save['evidencia_arteriosclerosis'] = 0;
			}
			if(!isset($save['sintomas_neurologicos']) OR empty($save['sintomas_neurologicos'])){
				$save['sintomas_neurologicos'] = 0;
			}
			if(!isset($save['signos_neurologicos']) OR empty($save['signos_neurologicos'])){
				$save['signos_neurologicos'] = 0;
			}

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
			
			$this->form_validation->set_rules('cancer_desc', 'Cancer', 'xss_clean');
			$this->form_validation->set_rules('cardiovascular_desc', 'Cardiovascular', 'xss_clean');
			$this->form_validation->set_rules('periferico_desc', 'Vascular Periferico', 'xss_clean');
			$this->form_validation->set_rules('oidos_desc', 'Oidos y Garganta', 'xss_clean');
			$this->form_validation->set_rules('neurologico_desc', 'Neurologico', 'xss_clean');
			$this->form_validation->set_rules('pulmones_desc', 'Pulmones/Respiratorio', 'xss_clean');
			$this->form_validation->set_rules('renal_desc', 'Renal/Urinario', 'xss_clean');
			$this->form_validation->set_rules('ginecologico_desc', 'Ginecologico', 'xss_clean');
			$this->form_validation->set_rules('endocrino_desc', 'Endocrino/Metabolico', 'xss_clean');
			$this->form_validation->set_rules('hepatico_desc', 'Hepatico', 'xss_clean');
			$this->form_validation->set_rules('gastrointestinal_desc', 'Gastrointestinal', 'xss_clean');
			$this->form_validation->set_rules('muscular_desc', 'Muscular/Esqueletico', 'xss_clean');
			$this->form_validation->set_rules('cancer_desc', 'Cancer', 'xss_clean');
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

	public function historial_medico_show($subject_id,$etapa){
		$data['contenido'] = 'subject/historial_medico_show';
		$data['titulo'] = 'Historia Medica';
		$data['subject'] = $this->Model_Subject->find($subject_id);
		$data['etapa'] = $etapa;

		$this->load->model("Model_Historial_medico");
		$data['list'] = $this->Model_Historial_medico->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"Historial Medico", "etapa"=>$etapa));

		$this->load->view('template', $data);
	}

	public function historial_medico_update(){

		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');
		$this->form_validation->set_rules('hallazgo', 'Hallazgo', 'required|xss_clean');

		/*Si se tiene algun hallazgo todo es obligatorio*/
		if(isset($registro['hallazgo']) AND $registro['hallazgo'] == 1){
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
			$this->form_validation->set_rules('cancer_desc', 'Cancer', 'xss_clean');
			$this->form_validation->set_rules('cardiovascular_desc', 'Cardiovascular', 'xss_clean');
			$this->form_validation->set_rules('periferico_desc', 'Vascular Periferico', 'xss_clean');
			$this->form_validation->set_rules('oidos_desc', 'Oidos y Garganta', 'xss_clean');
			$this->form_validation->set_rules('neurologico_desc', 'Neurologico', 'xss_clean');
			$this->form_validation->set_rules('pulmones_desc', 'Pulmones/Respiratorio', 'xss_clean');
			$this->form_validation->set_rules('renal_desc', 'Renal/Urinario', 'xss_clean');
			$this->form_validation->set_rules('ginecologico_desc', 'Ginecologico', 'xss_clean');
			$this->form_validation->set_rules('endocrino_desc', 'Endocrino/Metabolico', 'xss_clean');
			$this->form_validation->set_rules('hepatico_desc', 'Hepatico', 'xss_clean');
			$this->form_validation->set_rules('gastrointestinal_desc', 'Gastrointestinal', 'xss_clean');
			$this->form_validation->set_rules('muscular_desc', 'Muscular/Esqueletico', 'xss_clean');
			$this->form_validation->set_rules('cancer_desc', 'Cancer', 'xss_clean');
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
		$data['titulo'] = 'Criterios de Inclusión/Exclusión';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;
		

		$this->load->view('template', $data);			
	}

	public function inclusion_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');
		$this->form_validation->set_rules('cumple_criterios', 'Cumple Criterio', 'required|xss_clean');
		$this->form_validation->set_rules('autorizacion_patrocinador', 'Autorizacion Patrocinador', 'xss_clean');		

		/*Validar si ingresa un numero o un comentario este tenga su par ya sea numero o comentario*/

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Tuvo errores al tratar de agregar formulario de inclusión exclusión", $registro['subject_id']);
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

			$this->auditlib->save_audit("Critero de inclusión exclusión agregado", $registro['subject_id']);     		
     		redirect('subject/inclusion_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
	}

	public function inclusion_show($subject_id, $etapa){
		$data['contenido'] = 'subject/inclusion_show';
		$data['titulo'] = 'Criterios de Inclusión/Exclusión';
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
		$this->form_validation->set_rules('autorizacion_patrocinador', 'Autorizacion Patrocinador', 'xss_clean');	

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Tuvo errores al tratar de actualizar el formulario de inclusión exclusión", $registro['subject_id']);
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
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de Inclusión Exclusión", $registro['subject_id']);
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
			$this->auditlib->save_audit("Verificacion de el formulario de Inclusión Exclusión", $registro['subject_id']);

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
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Inclusión Exclusión", $registro['subject_id']);
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
			$this->auditlib->save_audit("Firmo el formulario de Inclusión Exclusión", $registro['subject_id']);
			
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
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de Inclusión Exclusión", $registro['subject_id']);
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
			$this->auditlib->save_audit("Cerro el formulario de Inclusión Exclusión", $registro['subject_id']);			
			
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
			
			/*Actualizamos Form*/
			$this->load->model('Model_Digito_directo');
			$this->Model_Digito_directo->insert($registro);

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
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"Digito Directo", "etapa"=>$etapa));
		
		$this->load->view('template', $data);					
	}

	public function digito_directo_update(){
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

			$this->auditlib->save_audit("Tuvo errores al tratar de actualizar formulario de prueba de digito directo", $registro['subject_id']);
			$this->digito_directo($registro['subject_id'], $registro['etapa']);
		}
		else {			
			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos Form*/
			$this->load->model('Model_Digito_directo');
			$this->Model_Digito_directo->update($registro);

			$this->auditlib->save_audit("Prueba de digito directo actualizada", $registro['subject_id']);     		
     		redirect('subject/digito_directo_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
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
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_ano_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_estacion_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_mes_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_dia_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_fecha_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_region_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('donde_estas_ahora', '', 'xss_clean');
		$this->form_validation->set_rules('donde_estas_ahora_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('comuna_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('comuna_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('barrio_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('barrio_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('edificio_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('edificio_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('manzana', '', 'xss_clean');
		$this->form_validation->set_rules('manzana_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('peso', '', 'xss_clean');
		$this->form_validation->set_rules('peso_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('mesa', '', 'xss_clean');
		$this->form_validation->set_rules('mesa_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_93', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_93_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_86', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_86_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_79', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_79_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_72', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_72_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_65', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_65_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('manzana_2', '', 'xss_clean');
		$this->form_validation->set_rules('manzana_2_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('peso_2', '', 'xss_clean');
		$this->form_validation->set_rules('peso_2_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('mesa_2', '', 'xss_clean');
		$this->form_validation->set_rules('mesa_2_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('que_es_1', '', 'xss_clean');
		$this->form_validation->set_rules('que_es_1_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('que_es_2', '', 'xss_clean');
		$this->form_validation->set_rules('que_es_2_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('no_si_cuando_porque', '', 'xss_clean');
		$this->form_validation->set_rules('no_si_cuando_porque_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('tomar_con_la_mano_derecha', '', 'xss_clean');
		$this->form_validation->set_rules('tomar_con_la_mano_derecha_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('doblar_por_la_mitad', '', 'xss_clean');
		$this->form_validation->set_rules('doblar_por_la_mitad_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('poner_en_el_piso', '', 'xss_clean');
		$this->form_validation->set_rules('poner_en_el_piso_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('cierre_los_ojos', '', 'xss_clean');
		$this->form_validation->set_rules('cierre_los_ojos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('dibujo_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('escritura_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('puntaje_total', '', 'xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar estudio MMSE", $registro['subject_id']);
			$this->mmse($registro['subject_id'], $registro['etapa']);

		}else{

			if($registro['etapa'] == 1){				
				$subjet_['mmse_1_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 4){
				$subjet_['mmse_4_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 5){
				$subjet_['mmse_5_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 6){
				$subjet_['mmse_6_status'] = "Record Complete";
			}

			$registro['status'] = "Record Complete";
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Mmse');
			$this->Model_Mmse->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("MMSE agregado", $registro['subject_id']);     		
     		redirect('subject/mmse_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}

	}

	public function mmse_show($subject_id, $etapa){
		$data['contenido'] = 'subject/mmse_show';
		$data['titulo'] = 'MMSE';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;
		
		$this->load->model('Model_Mmse');
		$data['list'] = $this->Model_Mmse->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		/*querys*/
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"MMSE", "etapa"=>$etapa));

		$data['puntaje'] = array(''=>'','0'=>'0','1'=>'1');

		$this->load->view('template',$data);

	}

	public function mmse_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'xss_clean');
		$this->form_validation->set_rules('tiene_problemas_memoria', '', 'xss_clean');
		$this->form_validation->set_rules('le_puedo_hacer_preguntas', '', 'xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_ano_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_estacion_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_mes_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_dia_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_fecha_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_region_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('donde_estas_ahora', '', 'xss_clean');
		$this->form_validation->set_rules('donde_estas_ahora_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('comuna_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('comuna_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('barrio_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('barrio_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('edificio_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('edificio_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('manzana', '', 'xss_clean');
		$this->form_validation->set_rules('manzana_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('peso', '', 'xss_clean');
		$this->form_validation->set_rules('peso_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('mesa', '', 'xss_clean');
		$this->form_validation->set_rules('mesa_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_93', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_93_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_86', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_86_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_79', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_79_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_72', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_72_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_65', '', 'xss_clean');
		$this->form_validation->set_rules('cuanto_65_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('manzana_2', '', 'xss_clean');
		$this->form_validation->set_rules('manzana_2_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('peso_2', '', 'xss_clean');
		$this->form_validation->set_rules('peso_2_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('mesa_2', '', 'xss_clean');
		$this->form_validation->set_rules('mesa_2_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('que_es_1', '', 'xss_clean');
		$this->form_validation->set_rules('que_es_1_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('que_es_2', '', 'xss_clean');
		$this->form_validation->set_rules('que_es_2_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('no_si_cuando_porque', '', 'xss_clean');
		$this->form_validation->set_rules('no_si_cuando_porque_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('tomar_con_la_mano_derecha', '', 'xss_clean');
		$this->form_validation->set_rules('tomar_con_la_mano_derecha_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('doblar_por_la_mitad', '', 'xss_clean');
		$this->form_validation->set_rules('doblar_por_la_mitad_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('poner_en_el_piso', '', 'xss_clean');
		$this->form_validation->set_rules('poner_en_el_piso_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('cierre_los_ojos', '', 'xss_clean');
		$this->form_validation->set_rules('cierre_los_ojos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('dibujo_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('escritura_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('puntaje_total', '', 'xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar el estudio MMSE", $registro['subject_id']);
			$this->mmse($registro['subject_id'], $registro['etapa']);

		}else{
			
			$registro['updated_at'] = date("Y-m-d H:i:s");

			if(!isset($registro['le_puedo_hacer_preguntas']) OR empty($registro['le_puedo_hacer_preguntas'])){
				$registro['le_puedo_hacer_preguntas'] = 0;
			}

			if(!isset($registro['tiene_problemas_memoria']) OR empty($registro['tiene_problemas_memoria'])){
				$registro['tiene_problemas_memoria'] = 0;
			}
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Mmse');
			$this->Model_Mmse->update($registro);			

			$this->auditlib->save_audit("MMSE actualizado", $registro['subject_id']);     		
     		redirect('subject/mmse_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
	}

	public function mmse_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de MMSE", $registro['subject_id']);
			$this->mmse_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Mmse');
			$this->Model_Mmse->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de MMSE", $registro['subject_id']);
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('mmse_1_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('mmse_4_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('mmse_5_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('mmse_6_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function mmse_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de MMSE", $registro['subject_id']);
			$this->mmse_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Mmse');
			$this->Model_Mmse->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de MMSE", $registro['subject_id']);
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('mmse_1_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('mmse_4_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('mmse_5_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('mmse_6_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function mmse_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de MMSE", $registro['subject_id']);
			$this->mmse_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Mmse');
			$this->Model_Mmse->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de MMSE", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('mmse_1_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('mmse_4_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('mmse_5_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('mmse_6_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
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

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');

		if(isset($registro['realizado']) AND !empty($registro['realizado'])){
			$this->form_validation->set_rules('fecha', '', 'required|xss_clean');
			$this->form_validation->set_rules('ritmo_sinusal', '', 'required|xss_clean');
			$this->form_validation->set_rules('ritmo_sinusal_normal_anormal', '', 'required|xss_clean');
			$this->form_validation->set_rules('fc', '', 'required|xss_clean');
			$this->form_validation->set_rules('fc_normal_anormal', '', 'required|xss_clean');
			$this->form_validation->set_rules('pr', '', 'required|xss_clean');
			$this->form_validation->set_rules('pr_normal_anormal', '', 'required|xss_clean');
			$this->form_validation->set_rules('qrs', '', 'required|xss_clean');
			$this->form_validation->set_rules('qrs_normal_anormal', '', 'required|xss_clean');
			$this->form_validation->set_rules('qt', '', 'required|xss_clean');
			$this->form_validation->set_rules('qt_normal_anormal', '', 'required|xss_clean');
			$this->form_validation->set_rules('qtc', '', 'required|xss_clean');
			$this->form_validation->set_rules('qtc_normal_anormal', '', 'required|xss_clean');
			$this->form_validation->set_rules('qrs2', '', 'required|xss_clean');
			$this->form_validation->set_rules('qrs2_normal_anormal', '', 'required|xss_clean');
			$this->form_validation->set_rules('interpretacion_ecg', '', 'required|xss_clean');
			$this->form_validation->set_rules('comentarios', '', 'required|xss_clean');
		}
		else{
			$this->form_validation->set_rules('fecha', '', 'xss_clean');
			$this->form_validation->set_rules('ritmo_sinusal', '', 'xss_clean');
			$this->form_validation->set_rules('ritmo_sinusal_normal_anormal', '', 'xss_clean');
			$this->form_validation->set_rules('fc', '', 'xss_clean');
			$this->form_validation->set_rules('fc_normal_anormal', '', 'xss_clean');
			$this->form_validation->set_rules('pr', '', 'xss_clean');
			$this->form_validation->set_rules('pr_normal_anormal', '', 'xss_clean');
			$this->form_validation->set_rules('qrs', '', 'xss_clean');
			$this->form_validation->set_rules('qrs_normal_anormal', '', 'xss_clean');
			$this->form_validation->set_rules('qt', '', 'xss_clean');
			$this->form_validation->set_rules('qt_normal_anormal', '', 'xss_clean');
			$this->form_validation->set_rules('qtc', '', 'xss_clean');
			$this->form_validation->set_rules('qtc_normal_anormal', '', 'xss_clean');
			$this->form_validation->set_rules('qrs2', '', 'xss_clean');
			$this->form_validation->set_rules('qrs2_normal_anormal', '', 'xss_clean');
			$this->form_validation->set_rules('interpretacion_ecg', '', 'xss_clean');
			$this->form_validation->set_rules('comentarios', '', 'xss_clean');	
		}

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar estudio ECG", $registro['subject_id']);
			$this->ecg($registro['subject_id']);

		}else{

			$registro['status'] = "Record Complete";
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Electrocardiograma_de_reposo');
			$this->Model_Electrocardiograma_de_reposo->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$subjet_['ecg_status'] = "Record Complete";
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("ECG agregado", $registro['subject_id']);     		
     		redirect('subject/ecg_show/'. $registro['subject_id']);

		}
	}

	public function ecg_show($subject_id){
		$data['contenido'] = 'subject/ecg_show';
		$data['titulo'] = 'ECG';
		$data['subject'] = $this->Model_Subject->find($subject_id);						
		
		$this->load->model('Model_Electrocardiograma_de_reposo');
		$data['list'] = $this->Model_Electrocardiograma_de_reposo->allWhereArray(array('subject_id'=>$subject_id));

		/*querys*/
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"ECG"));

		$this->load->view('template',$data);
	}

	public function ecg_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');

		if(isset($registro['realizado']) AND !empty($registro['realizado'])){
			$this->form_validation->set_rules('fecha', '', 'required|xss_clean');
			$this->form_validation->set_rules('ritmo_sinusal', '', 'required|xss_clean');
			$this->form_validation->set_rules('ritmo_sinusal_normal_anormal', '', 'required|xss_clean');
			$this->form_validation->set_rules('fc', '', 'required|xss_clean');
			$this->form_validation->set_rules('fc_normal_anormal', '', 'required|xss_clean');
			$this->form_validation->set_rules('pr', '', 'required|xss_clean');
			$this->form_validation->set_rules('pr_normal_anormal', '', 'required|xss_clean');
			$this->form_validation->set_rules('qrs', '', 'required|xss_clean');
			$this->form_validation->set_rules('qrs_normal_anormal', '', 'required|xss_clean');
			$this->form_validation->set_rules('qt', '', 'required|xss_clean');
			$this->form_validation->set_rules('qt_normal_anormal', '', 'required|xss_clean');
			$this->form_validation->set_rules('qtc', '', 'required|xss_clean');
			$this->form_validation->set_rules('qtc_normal_anormal', '', 'required|xss_clean');
			$this->form_validation->set_rules('qrs2', '', 'required|xss_clean');
			$this->form_validation->set_rules('qrs2_normal_anormal', '', 'required|xss_clean');
			$this->form_validation->set_rules('interpretacion_ecg', '', 'required|xss_clean');
			$this->form_validation->set_rules('comentarios', '', 'required|xss_clean');
		}
		else{
			$this->form_validation->set_rules('fecha', '', 'xss_clean');
			$this->form_validation->set_rules('ritmo_sinusal', '', 'xss_clean');
			$this->form_validation->set_rules('ritmo_sinusal_normal_anormal', '', 'xss_clean');
			$this->form_validation->set_rules('fc', '', 'xss_clean');
			$this->form_validation->set_rules('fc_normal_anormal', '', 'xss_clean');
			$this->form_validation->set_rules('pr', '', 'xss_clean');
			$this->form_validation->set_rules('pr_normal_anormal', '', 'xss_clean');
			$this->form_validation->set_rules('qrs', '', 'xss_clean');
			$this->form_validation->set_rules('qrs_normal_anormal', '', 'xss_clean');
			$this->form_validation->set_rules('qt', '', 'xss_clean');
			$this->form_validation->set_rules('qt_normal_anormal', '', 'xss_clean');
			$this->form_validation->set_rules('qtc', '', 'xss_clean');
			$this->form_validation->set_rules('qtc_normal_anormal', '', 'xss_clean');
			$this->form_validation->set_rules('qrs2', '', 'xss_clean');
			$this->form_validation->set_rules('qrs2_normal_anormal', '', 'xss_clean');
			$this->form_validation->set_rules('interpretacion_ecg', '', 'xss_clean');
			$this->form_validation->set_rules('comentarios', '', 'xss_clean');	
		}

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar estudio ECG", $registro['subject_id']);
			$this->ecg($registro['subject_id']);

		}else{
			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Electrocardiograma_de_reposo');
			$this->Model_Electrocardiograma_de_reposo->update($registro);
			
			$this->auditlib->save_audit("ECG actualizado", $registro['subject_id']);     		
     		redirect('subject/ecg_show/'. $registro['subject_id']);

		}
	}

	public function ecg_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de ECG", $registro['subject_id']);
			$this->ecg_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Electrocardiograma_de_reposo');
			$this->Model_Electrocardiograma_de_reposo->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de ECG", $registro['subject_id']);
			
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('ecg_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			
			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function ecg_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de ECG", $registro['subject_id']);
			$this->ecg_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Electrocardiograma_de_reposo');
			$this->Model_Electrocardiograma_de_reposo->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de ECG", $registro['subject_id']);
			
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('ecg_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			
			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function ecg_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de ECG", $registro['subject_id']);
			$this->ecg_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Electrocardiograma_de_reposo');
			$this->Model_Electrocardiograma_de_reposo->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de ECG", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			$this->Model_Subject->update(array('ecg_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));			

			redirect('subject/grid/'.$registro['subject_id']);
		}
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

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');		
		$this->form_validation->set_rules('estatura', '', 'xss_clean');
		
		
		$this->form_validation->set_rules('presion_sistolica', '', 'xss_clean');
		$this->form_validation->set_rules('presion_diastolica', '', 'xss_clean');
		$this->form_validation->set_rules('frecuencia_cardiaca', '', 'xss_clean');
		$this->form_validation->set_rules('frecuencia_respiratoria', '', 'xss_clean');
		$this->form_validation->set_rules('temperatura', '', 'xss_clean');
		$this->form_validation->set_rules('peso', '', 'xss_clean');
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar signos vitales", $registro['subject_id']);
			$this->signos_vitales($registro['subject_id'], $registro['etapa']);

		}else{

			if($registro['etapa'] == 1){				
				$subjet_['signos_vitales_1_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 3){
				$subjet_['signos_vitales_3_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 4){
				$subjet_['signos_vitales_4_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 5){
				$subjet_['signos_vitales_5_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 6){
				$subjet_['signos_vitales_6_status'] = "Record Complete";
			}

			$registro['status'] = "Record Complete";
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Signos_vitales');
			$this->Model_Signos_vitales->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Signos vitales agregados", $registro['subject_id']);     		
     		redirect('subject/signos_vitales_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
	}

	public function signos_vitales_show($subject_id, $etapa){
		$data['contenido'] = 'subject/signos_vitales_show';
		$data['titulo'] = 'Signos Vitales';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->model('Model_Signos_vitales');
		$data['list'] = $this->Model_Signos_vitales->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		/*querys*/
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"Signos Vitales"));

		$this->load->view('template',$data);
	}

	public function signos_vitales_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('estatura', '', 'xss_clean');
		$this->form_validation->set_rules('presion_sistolica', '', 'xss_clean');
		$this->form_validation->set_rules('presion_diastolica', '', 'xss_clean');
		$this->form_validation->set_rules('frecuencia_cardiaca', '', 'xss_clean');
		$this->form_validation->set_rules('frecuencia_respiratoria', '', 'xss_clean');
		$this->form_validation->set_rules('temperatura', '', 'xss_clean');
		$this->form_validation->set_rules('peso', '', 'xss_clean');
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar signos vitales", $registro['subject_id']);
			$this->signos_vitales($registro['subject_id'], $registro['etapa']);

		}else{

			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Signos_vitales');
			$this->Model_Signos_vitales->update($registro);		

			$this->auditlib->save_audit("Signos vitales actualizados", $registro['subject_id']);     		
     		redirect('subject/signos_vitales_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
	}

	public function signos_vitales_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de Signos Vitales", $registro['subject_id']);
			$this->signos_vitales_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Signos_vitales');
			$this->Model_Signos_vitales->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de Signos Vitales", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('signos_vitales_1_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('signos_vitales_3_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('signos_vitales_4_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('signos_vitales_5_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('signos_vitales_6_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function signos_vitales_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Signos Vitales", $registro['subject_id']);
			$this->signos_vitales_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Signos_vitales');
			$this->Model_Signos_vitales->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de Signos Vitales", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('signos_vitales_1_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('signos_vitales_3_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('signos_vitales_4_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('signos_vitales_5_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('signos_vitales_6_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function signos_vitales_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de Signos Vitales", $registro['subject_id']);
			$this->signos_vitales_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Signos_vitales');
			$this->Model_Signos_vitales->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de Signos Vitales", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('signos_vitales_1_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('signos_vitales_3_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('signos_vitales_4_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('signos_vitales_5_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('signos_vitales_6_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}

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

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');

		if(isset($registro['realizado']) AND $registro['realizado'] == 0){
			$this->form_validation->set_rules('fecha', '', 'xss_clean');
			$this->form_validation->set_rules('comprimidos_entregados', '', 'xss_clean');
			$this->form_validation->set_rules('comprimidos_utilizados', '', 'xss_clean');
			$this->form_validation->set_rules('comprimidos_devueltos', '', 'xss_clean');
			$this->form_validation->set_rules('se_perdio_algun_comprimido', '', 'xss_clean');
			$this->form_validation->set_rules('comprimidos_perdidos', '', 'xss_clean');
			$this->form_validation->set_rules('dias', '', 'xss_clean');
			$this->form_validation->set_rules('porcentaje_cumplimiento', '', 'xss_clean');		
		}
		else{
			$this->form_validation->set_rules('fecha', '', 'required|xss_clean');
			$this->form_validation->set_rules('comprimidos_entregados', '', 'required|xss_clean');
			$this->form_validation->set_rules('comprimidos_utilizados', '', 'required|xss_clean');
			$this->form_validation->set_rules('comprimidos_devueltos', '', 'required|xss_clean');
			$this->form_validation->set_rules('se_perdio_algun_comprimido', '', 'required|xss_clean');
			$this->form_validation->set_rules('comprimidos_perdidos', '', 'required|xss_clean');
			$this->form_validation->set_rules('dias', '', 'required|xss_clean');
			$this->form_validation->set_rules('porcentaje_cumplimiento', '', 'required|xss_clean');		
		}

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar cumplimiento", $registro['subject_id']);
			$this->cumplimiento($registro['subject_id'], $registro['etapa']);

		}else{

			if($registro['etapa'] == 2){				
				$subjet_['cumplimiento_2_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 3){
				$subjet_['cumplimiento_3_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 4){
				$subjet_['cumplimiento_4_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 5){
				$subjet_['cumplimiento_5_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 6){
				$subjet_['cumplimiento_6_status'] = "Record Complete";
			}

			$registro['status'] = "Record Complete";
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Cumplimiento');
			$this->Model_Cumplimiento->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Cumplimiento agregado", $registro['subject_id']);     		
     		redirect('subject/cumplimiento_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
	}

	public function cumplimiento_show($subject_id, $etapa){
		$data['contenido'] = 'subject/cumplimiento_show';
		$data['titulo'] = 'Cumplimiento';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->model('Model_Cumplimiento');
		$data['list'] = $this->Model_Cumplimiento->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		/*querys*/
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"Cumplimiento"));

		$this->load->view('template',$data);
	}

	public function cumplimiento_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');
		
		if(isset($registro['realizado']) AND $registro['realizado'] == 0){
			$this->form_validation->set_rules('fecha', '', 'xss_clean');
			$this->form_validation->set_rules('comprimidos_entregados', '', 'xss_clean');
			$this->form_validation->set_rules('comprimidos_utilizados', '', 'xss_clean');
			$this->form_validation->set_rules('comprimidos_devueltos', '', 'xss_clean');
			$this->form_validation->set_rules('se_perdio_algun_comprimido', '', 'xss_clean');
			$this->form_validation->set_rules('comprimidos_perdidos', '', 'xss_clean');
			$this->form_validation->set_rules('dias', '', 'xss_clean');
			$this->form_validation->set_rules('porcentaje_cumplimiento', '', 'xss_clean');		
		}
		else{
			$this->form_validation->set_rules('fecha', '', 'required|xss_clean');
			$this->form_validation->set_rules('comprimidos_entregados', '', 'required|xss_clean');
			$this->form_validation->set_rules('comprimidos_utilizados', '', 'required|xss_clean');
			$this->form_validation->set_rules('comprimidos_devueltos', '', 'required|xss_clean');
			$this->form_validation->set_rules('se_perdio_algun_comprimido', '', 'required|xss_clean');
			$this->form_validation->set_rules('comprimidos_perdidos', '', 'required|xss_clean');
			$this->form_validation->set_rules('dias', '', 'required|xss_clean');
			$this->form_validation->set_rules('porcentaje_cumplimiento', '', 'required|xss_clean');		
		}
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar cumplimiento", $registro['subject_id']);
			$this->cumplimiento($registro['subject_id'], $registro['etapa']);

		}else{

			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Cumplimiento');
			$this->Model_Cumplimiento->update($registro);

			$this->auditlib->save_audit("Cumplimiento actualizado", $registro['subject_id']);     		
     		redirect('subject/cumplimiento_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
	}

	public function cumplimiento_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de Cumplimiento", $registro['subject_id']);
			$this->cumplimiento_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Cumplimiento');
			$this->Model_Cumplimiento->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de Cumplimiento", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 2){
				$this->Model_Subject->update(array('cumplimiento_2_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('cumplimiento_3_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('cumplimiento_4_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('cumplimiento_5_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('cumplimiento_6_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function cumplimiento_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Cumplimiento", $registro['subject_id']);
			$this->cumplimiento_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Cumplimiento');
			$this->Model_Cumplimiento->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de Cumplimiento", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 2){
				$this->Model_Subject->update(array('cumplimiento_2_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('cumplimiento_3_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('cumplimiento_4_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('cumplimiento_5_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('cumplimiento_6_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function cumplimiento_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de Cumplimiento", $registro['subject_id']);
			$this->cumplimiento_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Cumplimiento');
			$this->Model_Cumplimiento->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de Cumplimiento", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 2){
				$this->Model_Subject->update(array('cumplimiento_2_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('cumplimiento_3_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('cumplimiento_4_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('cumplimiento_5_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('cumplimiento_6_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
	/*----------------------------------------------Fin Tratamiento------------------------------------------------------------------------------*/
	public function fin_tratamiento($subject_id){
		$data['contenido'] = 'subject/fin_tratamiento';
		$data['titulo'] = 'Fin Tratamiento';
		$data['subject'] = $this->Model_Subject->find($subject_id);				

		$this->load->view('template',$data);
	}

	public function fin_tratamiento_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');		
		$this->form_validation->set_rules('no_aplica', '', 'xss_clean');
		$this->form_validation->set_rules('fecha_visita', '', 'required|xss_clean');
		$this->form_validation->set_rules('fecha_ultima_dosis', '', 'required|xss_clean');
		$this->form_validation->set_rules('termino_el_estudio', '', 'required|xss_clean');		
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar fin de tratamiento", $registro['subject_id']);
			$this->fin_tratamiento($registro['subject_id']);

		}else{

			$registro['status'] = "Record Complete";
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Fin_de_tratamiento');
			$this->Model_Fin_de_tratamiento->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$subjet_['fin_tratamiento_status'] = "Record Complete";
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Fin tratamiento agregado", $registro['subject_id']);     		
     		redirect('subject/fin_tratamiento_show/'. $registro['subject_id']);

		}
	}

	public function fin_tratamiento_show($subject_id){
		$data['contenido'] = 'subject/fin_tratamiento_show';
		$data['titulo'] = 'Fin Tratamiento';
		$data['subject'] = $this->Model_Subject->find($subject_id);				

		$this->load->model('Model_Fin_de_tratamiento');
		$data['list'] = $this->Model_Fin_de_tratamiento->allWhereArray(array('subject_id'=>$subject_id));

		/*querys*/
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"Fin Tratamiento"));

		$this->load->view('template',$data);
	}

	public function fin_tratamiento_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');		
		$this->form_validation->set_rules('no_aplica', '', 'xss_clean');
		$this->form_validation->set_rules('fecha_visita', '', 'required|xss_clean');
		$this->form_validation->set_rules('fecha_ultima_dosis', '', 'required|xss_clean');
		$this->form_validation->set_rules('termino_el_estudio', '', 'required|xss_clean');		
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar fin de tratamiento", $registro['subject_id']);
			$this->fin_tratamiento($registro['subject_id']);

		}else{
			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Fin_de_tratamiento');
			$this->Model_Fin_de_tratamiento->update($registro);

			$this->auditlib->save_audit("Fin tratamiento actualizado", $registro['subject_id']);     		
     		redirect('subject/fin_tratamiento_show/'. $registro['subject_id']);

		}
	}

	public function fin_tratamiento_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de Fin Tratamiento", $registro['subject_id']);
			$this->fin_tratamiento_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Fin_de_tratamiento');
			$this->Model_Fin_de_tratamiento->update($registro);
			$this->auditlib->save_audit("Verifico el formulario Fin Tratamiento", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('fin_tratamiento_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function fin_tratamiento_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Fin Tratamiento", $registro['subject_id']);
			$this->fin_tratamiento_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Fin_de_tratamiento');
			$this->Model_Fin_de_tratamiento->update($registro);
			$this->auditlib->save_audit("Firmo el formulario Fin Tratamiento", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('fin_tratamiento_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function fin_tratamiento_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de Fin Tratamiento", $registro['subject_id']);
			$this->fin_tratamiento_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Fin_de_tratamiento');
			$this->Model_Fin_de_tratamiento->update($registro);
			$this->auditlib->save_audit("Cerro el formulario Fin Tratamiento", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('fin_tratamiento_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
	/*----------------------------------------------Fin Tratamiento Temprano------------------------------------------------------------------------------*/
	public function fin_tratamiento_temprano($subject_id){
		$data['contenido'] = 'subject/fin_tratamiento_temprano';
		$data['titulo'] = 'Fin Tratamiento Temprano';
		$data['subject'] = $this->Model_Subject->find($subject_id);				

		$this->load->view('template',$data);
	}

	public function fin_tratamiento_temprano_insert(){
		$registro = $this->input->post();
		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');		
		$this->form_validation->set_rules('no_aplica', '', 'xss_clean');
		$this->form_validation->set_rules('fecha_visita', '', 'required|xss_clean');
		$this->form_validation->set_rules('fecha_ultima_dosis', '', 'required|xss_clean');
		$this->form_validation->set_rules('motivo', '', 'required|xss_clean');		

		if(isset($registro['motivo']) AND $registro['motivo'] == 'Otro'){
			$this->form_validation->set_rules('otro_motivo', '', 'required|xss_clean');
		}
		else{
			$this->form_validation->set_rules('otro_motivo', '', 'xss_clean');	
		}
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar fin de tratamiento", $registro['subject_id']);
			$this->fin_tratamiento_temprano($registro['subject_id']);

		}else{

			$registro['status'] = "Record Complete";
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Fin_de_tratamiento_temprano');
			$this->Model_Fin_de_tratamiento_temprano->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$subjet_['fin_tratamiento_temprano_status'] = "Record Complete";
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Fin tratamiento temprano agregado", $registro['subject_id']);     		
     		redirect('subject/fin_tratamiento_temprano_show/'. $registro['subject_id']);

		}
	}

	public function fin_tratamiento_temprano_show($subject_id){
		$data['contenido'] = 'subject/fin_tratamiento_temprano_show';
		$data['titulo'] = 'Fin Tratamiento Temprano';
		$data['subject'] = $this->Model_Subject->find($subject_id);

		$this->load->model('Model_Fin_de_tratamiento_temprano');
		$data['list'] = $this->Model_Fin_de_tratamiento_temprano->allWhereArray(array('subject_id'=>$subject_id));

		/*querys*/
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"Fin Tratamiento Temprano"));

		$this->load->view('template',$data);
	}

	public function fin_tratamiento_temprano_update(){
		$registro = $this->input->post();
		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');		
		$this->form_validation->set_rules('no_aplica', '', 'xss_clean');
		$this->form_validation->set_rules('fecha_visita', '', 'required|xss_clean');
		$this->form_validation->set_rules('fecha_ultima_dosis', '', 'required|xss_clean');
		$this->form_validation->set_rules('motivo', '', 'required|xss_clean');		

		if(isset($registro['motivo']) AND $registro['motivo'] == 'Otro'){
			$this->form_validation->set_rules('otro_motivo', '', 'required|xss_clean');
		}
		else{
			$this->form_validation->set_rules('otro_motivo', '', 'xss_clean');	
		}
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar fin de tratamiento", $registro['subject_id']);
			$this->fin_tratamiento_temprano($registro['subject_id']);

		}else{

			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Fin_de_tratamiento_temprano');
			$this->Model_Fin_de_tratamiento_temprano->update($registro);
			
			$this->auditlib->save_audit("Fin tratamiento temprano actualizado", $registro['subject_id']);     		
     		redirect('subject/fin_tratamiento_temprano_show/'. $registro['subject_id']);

		}
	}

	public function fin_tratamiento_temprano_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de Fin Tratamiento Temprano", $registro['subject_id']);
			$this->fin_tratamiento_temprano_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Fin_de_tratamiento_temprano');
			$this->Model_Fin_de_tratamiento_temprano->update($registro);
			$this->auditlib->save_audit("Verifico el formulario Fin Tratamiento Temprano", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('fin_tratamiento_temprano_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function fin_tratamiento_temprano_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Fin Tratamiento Temprano", $registro['subject_id']);
			$this->fin_tratamiento_temprano_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Fin_de_tratamiento_temprano');
			$this->Model_Fin_de_tratamiento_temprano->update($registro);
			$this->auditlib->save_audit("Firmo el formulario Fin Tratamiento Temprano", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('fin_tratamiento_temprano_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function fin_tratamiento_temprano_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de Fin Tratamiento Temprano", $registro['subject_id']);
			$this->fin_tratamiento_temprano_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Fin_de_tratamiento_temprano');
			$this->Model_Fin_de_tratamiento_temprano->update($registro);
			$this->auditlib->save_audit("Cerro el formulario Fin Tratamiento Temprano", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('fin_tratamiento_temprano_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
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

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar muestra de sangre", $registro['subject_id']);
			$this->muestra_de_sangre($registro['subject_id'], $registro['etapa']);

		}else{

			if($registro['etapa'] == 1){				
				$subjet_['muestra_de_sangre_1_status'] = "Record Complete";
			}			
			elseif($registro['etapa'] == 5){
				$subjet_['muestra_de_sangre_5_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 6){
				$subjet_['muestra_de_sangre_6_status'] = "Record Complete";
			}

			$registro['status'] = "Record Complete";
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Muestra_de_sangre');
			$this->Model_Muestra_de_sangre->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Muestra de sangre agregada", $registro['subject_id']);     		
     		redirect('subject/muestra_de_sangre_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
	}

	public function muestra_de_sangre_show($subject_id, $etapa){
		$data['contenido'] = 'subject/muestra_de_sangre_show';
		$data['titulo'] = 'Muestra de Sangre';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;

		$this->load->model('Model_Muestra_de_sangre');
		$data['list'] = $this->Model_Muestra_de_sangre->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		/*querys*/
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"Muestra de Sangre"));

		$this->load->view('template',$data);
	}

	public function muestra_de_sangre_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar muestra de sangre", $registro['subject_id']);
			$this->muestra_de_sangre($registro['subject_id'], $registro['etapa']);

		}else{
			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Muestra_de_sangre');
			$this->Model_Muestra_de_sangre->update($registro);

			$this->auditlib->save_audit("Muestra de sangre actualizada", $registro['subject_id']);     		
     		redirect('subject/muestra_de_sangre_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
	}

	public function muestra_de_sangre_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de Muestra de Sangre", $registro['subject_id']);
			$this->muestra_de_sangre_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Muestra_de_sangre');
			$this->Model_Muestra_de_sangre->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de Muestra de Sangre", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('muestra_de_sangre_1_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('muestra_de_sangre_5_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('muestra_de_sangre_6_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function muestra_de_sangre_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Muestra de Sangre", $registro['subject_id']);
			$this->muestra_de_sangre_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Muestra_de_sangre');
			$this->Model_Muestra_de_sangre->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de Muestra de Sangre", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('muestra_de_sangre_1_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('muestra_de_sangre_5_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('muestra_de_sangre_6_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function muestra_de_sangre_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de Muestra de Sangre", $registro['subject_id']);
			$this->muestra_de_sangre_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Muestra_de_sangre');
			$this->Model_Muestra_de_sangre->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de Muestra de Sangre", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('muestra_de_sangre_1_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('muestra_de_sangre_5_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('muestra_de_sangre_6_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
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

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');
		$this->form_validation->set_rules('fecha_examen_misma_visita', '', 'xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('nervios_craneanos_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('nervios_craneanos', '', 'xss_clean');
		$this->form_validation->set_rules('examen_motor_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('examen_motor', '', 'xss_clean');
		$this->form_validation->set_rules('examen_sensitivo_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('examen_sensitivo', '', 'xss_clean');
		$this->form_validation->set_rules('reflejos_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('reflejos', '', 'xss_clean');
		$this->form_validation->set_rules('funcion_cerebelosa_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('funcion_cerebelosa', '', 'xss_clean');
		$this->form_validation->set_rules('marcha_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('marcha', '', 'xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar examen neurologico", $registro['subject_id']);
			$this->examen_neurologico($registro['subject_id'], $registro['etapa']);

		}else{

			if($registro['etapa'] == 1){				
				$subjet_['examen_neurologico_1_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 2){
				$subjet_['examen_neurologico_2_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 3){
				$subjet_['examen_neurologico_3_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 4){
				$subjet_['examen_neurologico_4_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 5){
				$subjet_['examen_neurologico_5_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 6){
				$subjet_['examen_neurologico_6_status'] = "Record Complete";
			}

			$registro['status'] = "Record Complete";
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Examen_neurologico');
			$this->Model_Examen_neurologico->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen Neurologico agregado", $registro['subject_id']);     		
     		redirect('subject/examen_neurologico_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}

	}

	public function examen_neurologico_show($subject_id, $etapa){
		$data['contenido'] = 'subject/examen_neurologico_show';
		$data['titulo'] = 'Examen Neurologico';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->model('Model_Examen_neurologico');
		$data['list'] = $this->Model_Examen_neurologico->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		/*querys*/
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"Examen Neurologico"));

		$this->load->view('template',$data);
	}

	public function examen_neurologico_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');
		$this->form_validation->set_rules('fecha_examen_misma_visita', '', 'xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('nervios_craneanos_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('nervios_craneanos', '', 'xss_clean');
		$this->form_validation->set_rules('examen_motor_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('examen_motor', '', 'xss_clean');
		$this->form_validation->set_rules('examen_sensitivo_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('examen_sensitivo', '', 'xss_clean');
		$this->form_validation->set_rules('reflejos_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('reflejos', '', 'xss_clean');
		$this->form_validation->set_rules('funcion_cerebelosa_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('funcion_cerebelosa', '', 'xss_clean');
		$this->form_validation->set_rules('marcha_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('marcha', '', 'xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar el examen neurologico", $registro['subject_id']);
			$this->examen_neurologico($registro['subject_id'], $registro['etapa']);

		}else{

			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Examen_neurologico');
			$this->Model_Examen_neurologico->update($registro);			

			$this->auditlib->save_audit("Examen Neurologico actualizado", $registro['subject_id']);     		
     		redirect('subject/examen_neurologico_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
	}

	public function examen_neurologico_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de Examen Neurologico", $registro['subject_id']);
			$this->examen_neurologico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_neurologico');
			$this->Model_Examen_neurologico->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de Examen Neurologico", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('examen_neurologico_1_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('examen_neurologico_2_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('examen_neurologico_3_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('examen_neurologico_4_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('examen_neurologico_5_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('examen_neurologico_6_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_neurologico_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Examen Neurologico", $registro['subject_id']);
			$this->examen_neurologico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_neurologico');
			$this->Model_Examen_neurologico->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de Examen Neurologico", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('examen_neurologico_1_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('examen_neurologico_2_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('examen_neurologico_3_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('examen_neurologico_4_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('examen_neurologico_5_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('examen_neurologico_6_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_neurologico_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de Examen Neurologico", $registro['subject_id']);
			$this->examen_neurologico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_neurologico');
			$this->Model_Examen_neurologico->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de Examen Neurologico", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 1){
				$this->Model_Subject->update(array('examen_neurologico_1_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('examen_neurologico_2_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('examen_neurologico_3_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('examen_neurologico_4_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('examen_neurologico_5_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('examen_neurologico_6_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
	/*----------------------------------------------Examen Laboratorio------------------------------------------------------------------------------*/
	public function examen_laboratorio($subject_id){
		$data['contenido'] = 'subject/examen_laboratorio';
		$data['titulo'] = 'Examen Laboratorio';
		$data['subject'] = $this->Model_Subject->find($subject_id);				

		$this->load->view('template',$data);
	}

	public function examen_laboratorio_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');		
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');		
		$this->form_validation->set_rules('fecha', '', 'required|xss_clean');
		$this->form_validation->set_rules('hematocrito', '', 'xss_clean');
		$this->form_validation->set_rules('hematocrito_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('hemoglobina', '', 'xss_clean');
		$this->form_validation->set_rules('hemoglobina_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('eritocritos', '', 'xss_clean');
		$this->form_validation->set_rules('eritocritos_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('leucocitos', '', 'xss_clean');
		$this->form_validation->set_rules('leucocitos_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('neutrofilos', '', 'xss_clean');
		$this->form_validation->set_rules('neutrofilos_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('linfocitos', '', 'xss_clean');
		$this->form_validation->set_rules('linfocitos_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('monocitos', '', 'xss_clean');
		$this->form_validation->set_rules('monocitos_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('eosinofilos', '', 'xss_clean');
		$this->form_validation->set_rules('eosinofilos_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('basofilos', '', 'xss_clean');
		$this->form_validation->set_rules('basofilos_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('recuento_plaquetas', '', 'xss_clean');
		$this->form_validation->set_rules('recuento_plaquetas_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('vhs', '', 'xss_clean');
		$this->form_validation->set_rules('vhs_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('glucosa_ayunas', '', 'xss_clean');
		$this->form_validation->set_rules('glucosa_ayunas_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('bun', '', 'xss_clean');
		$this->form_validation->set_rules('bun_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('creatinina', '', 'xss_clean');
		$this->form_validation->set_rules('creatinina_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('bilirrubina_total', '', 'xss_clean');
		$this->form_validation->set_rules('bilirrubina_total_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('proteinas_totales', '', 'xss_clean');
		$this->form_validation->set_rules('proteinas_totales_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('fosfatasas_alcalinas', '', 'xss_clean');
		$this->form_validation->set_rules('fosfatasas_alcalinas_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('ast', '', 'xss_clean');
		$this->form_validation->set_rules('ast_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('alt', '', 'xss_clean');
		$this->form_validation->set_rules('alt_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('calcio', '', 'xss_clean');
		$this->form_validation->set_rules('calcio_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('sodio', '', 'xss_clean');
		$this->form_validation->set_rules('sodio_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('potasio', '', 'xss_clean');
		$this->form_validation->set_rules('potasio_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('cloro', '', 'xss_clean');
		$this->form_validation->set_rules('cloro_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('acido_urico', '', 'xss_clean');
		$this->form_validation->set_rules('acido_urico_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('albumina', '', 'xss_clean');
		$this->form_validation->set_rules('albumina_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('orina_ph', '', 'xss_clean');
		$this->form_validation->set_rules('orina_ph_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('orina_glucosa', '', 'xss_clean');
		$this->form_validation->set_rules('orina_glucosa_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('orina_proteinas', '', 'xss_clean');
		$this->form_validation->set_rules('orina_proteinas_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('orina_sangre', '', 'xss_clean');
		$this->form_validation->set_rules('orina_sangre_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('orina_cetonas', '', 'xss_clean');
		$this->form_validation->set_rules('orina_cetonas_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('orina_microscospia', '', 'xss_clean');
		$this->form_validation->set_rules('orina_microscospia_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('otros_sangre_homocisteina', '', 'xss_clean');
		$this->form_validation->set_rules('otros_sangre_homocisteina_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('otros_perfil_tiroideo', '', 'xss_clean');
		$this->form_validation->set_rules('otros_perfil_tiroideo_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('otros_nivel_b12', '', 'xss_clean');
		$this->form_validation->set_rules('otros_nivel_b12_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('otros_acido_folico', '', 'xss_clean');
		$this->form_validation->set_rules('otros_acido_folico_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('otros_hba1c', '', 'xss_clean');
		$this->form_validation->set_rules('otros_hba1c_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('sifilis', '', 'xss_clean');
		$this->form_validation->set_rules('sifilis_nom_anom', '', 'xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar examen de laboratorio", $registro['subject_id']);
			$this->examen_laboratorio($registro['subject_id']);

		}else{

			$registro['status'] = "Record Complete";
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Examen_laboratorio');
			$this->Model_Examen_laboratorio->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$subjet_['examen_laboratorio_status'] = "Record Complete";
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen de Laboratorio agregado", $registro['subject_id']);     		
     		redirect('subject/examen_laboratorio_show/'. $registro['subject_id']);

		}

	}

	public function examen_laboratorio_show($subject_id){
		$data['contenido'] = 'subject/examen_laboratorio_show';
		$data['titulo'] = 'Examen Laboratorio';
		$data['subject'] = $this->Model_Subject->find($subject_id);				

		$this->load->model('Model_Examen_laboratorio');
		$data['list'] = $this->Model_Examen_laboratorio->allWhereArray(array('subject_id'=>$subject_id));

		/*querys*/
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"Examen Laboratorio"));

		$this->load->view('template',$data);
	}

	public function examen_laboratorio_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');		
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');		
		$this->form_validation->set_rules('fecha', '', 'required|xss_clean');
		$this->form_validation->set_rules('hematocrito', '', 'xss_clean');
		$this->form_validation->set_rules('hematocrito_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('hemoglobina', '', 'xss_clean');
		$this->form_validation->set_rules('hemoglobina_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('eritocritos', '', 'xss_clean');
		$this->form_validation->set_rules('eritocritos_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('leucocitos', '', 'xss_clean');
		$this->form_validation->set_rules('leucocitos_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('neutrofilos', '', 'xss_clean');
		$this->form_validation->set_rules('neutrofilos_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('linfocitos', '', 'xss_clean');
		$this->form_validation->set_rules('linfocitos_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('monocitos', '', 'xss_clean');
		$this->form_validation->set_rules('monocitos_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('eosinofilos', '', 'xss_clean');
		$this->form_validation->set_rules('eosinofilos_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('basofilos', '', 'xss_clean');
		$this->form_validation->set_rules('basofilos_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('recuento_plaquetas', '', 'xss_clean');
		$this->form_validation->set_rules('recuento_plaquetas_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('vhs', '', 'xss_clean');
		$this->form_validation->set_rules('vhs_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('glucosa_ayunas', '', 'xss_clean');
		$this->form_validation->set_rules('glucosa_ayunas_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('bun', '', 'xss_clean');
		$this->form_validation->set_rules('bun_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('creatinina', '', 'xss_clean');
		$this->form_validation->set_rules('creatinina_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('bilirrubina_total', '', 'xss_clean');
		$this->form_validation->set_rules('bilirrubina_total_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('proteinas_totales', '', 'xss_clean');
		$this->form_validation->set_rules('proteinas_totales_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('fosfatasas_alcalinas', '', 'xss_clean');
		$this->form_validation->set_rules('fosfatasas_alcalinas_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('ast', '', 'xss_clean');
		$this->form_validation->set_rules('ast_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('alt', '', 'xss_clean');
		$this->form_validation->set_rules('alt_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('calcio', '', 'xss_clean');
		$this->form_validation->set_rules('calcio_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('sodio', '', 'xss_clean');
		$this->form_validation->set_rules('sodio_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('potasio', '', 'xss_clean');
		$this->form_validation->set_rules('potasio_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('cloro', '', 'xss_clean');
		$this->form_validation->set_rules('cloro_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('acido_urico', '', 'xss_clean');
		$this->form_validation->set_rules('acido_urico_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('albumina', '', 'xss_clean');
		$this->form_validation->set_rules('albumina_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('orina_ph', '', 'xss_clean');
		$this->form_validation->set_rules('orina_ph_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('orina_glucosa', '', 'xss_clean');
		$this->form_validation->set_rules('orina_glucosa_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('orina_proteinas', '', 'xss_clean');
		$this->form_validation->set_rules('orina_proteinas_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('orina_sangre', '', 'xss_clean');
		$this->form_validation->set_rules('orina_sangre_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('orina_cetonas', '', 'xss_clean');
		$this->form_validation->set_rules('orina_cetonas_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('orina_microscospia', '', 'xss_clean');
		$this->form_validation->set_rules('orina_microscospia_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('otros_sangre_homocisteina', '', 'xss_clean');
		$this->form_validation->set_rules('otros_sangre_homocisteina_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('otros_perfil_tiroideo', '', 'xss_clean');
		$this->form_validation->set_rules('otros_perfil_tiroideo_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('otros_nivel_b12', '', 'xss_clean');
		$this->form_validation->set_rules('otros_nivel_b12_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('otros_acido_folico', '', 'xss_clean');
		$this->form_validation->set_rules('otros_acido_folico_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('otros_hba1c', '', 'xss_clean');
		$this->form_validation->set_rules('otros_hba1c_nom_anom', '', 'xss_clean');
		$this->form_validation->set_rules('sifilis', '', 'xss_clean');
		$this->form_validation->set_rules('sifilis_nom_anom', '', 'xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar examen de laboratorio", $registro['subject_id']);
			$this->examen_laboratorio($registro['subject_id']);

		}else{

			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Examen_laboratorio');
			$this->Model_Examen_laboratorio->update($registro);

			$this->auditlib->save_audit("Examen de Laboratorio actualizado", $registro['subject_id']);     		
     		redirect('subject/examen_laboratorio_show/'. $registro['subject_id']);

		}
	}

	public function examen_laboratorio_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de Examen Laboratorio", $registro['subject_id']);
			$this->examen_laboratorio_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_laboratorio');
			$this->Model_Examen_laboratorio->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de Examen Laboratorio", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('examen_laboratorio_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_laboratorio_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Examen Laboratorio", $registro['subject_id']);
			$this->examen_laboratorio_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_laboratorio');
			$this->Model_Examen_laboratorio->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de Examen Laboratorio", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('examen_laboratorio_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_laboratorio_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de Examen Laboratorio", $registro['subject_id']);
			$this->examen_laboratorio_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_laboratorio');
			$this->Model_Examen_laboratorio->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de Examen Laboratorio", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/
			$this->Model_Subject->update(array('examen_laboratorio_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

/*-----------------------------------------------------TMT A ------------------------------------------------------------------------*/

	public function tmt_a($subject_id, $etapa){
		$data['contenido'] = 'subject/tmt_a';
		$data['titulo'] = 'TMT A';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->view('template', $data);
	}

	public function tmt_a_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id','Id del Sujeto','required|xss_clean');
		$this->form_validation->set_rules('etapa','Etapa','required|xss_clean');
		$this->form_validation->set_rules('realizado','Realizado','required|xss_clean');

		
		$this->form_validation->set_rules('fecha','Fecha','xss_clean');
		$this->form_validation->set_rules('segundos','Segundos','xss_clean');	
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar TMT A", $registro['subject_id']);
			$this->tmt_a($registro['subject_id'], $registro['etapa']);

		}else{

			if($registro['etapa'] == 2){
				$subjet_['tmt_a_2_status'] = "Record Complete";
			}			
			elseif($registro['etapa'] == 4){
				$subjet_['tmt_a_4_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 5){
				$subjet_['tmt_a_5_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 6){
				$subjet_['tmt_a_6_status'] = "Record Complete";
			}

			$registro['status'] = "Record Complete";
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Tmt_a');
			$this->Model_Tmt_a->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen TMT A agregado", $registro['subject_id']);     		
     		redirect('subject/tmt_a_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
	}	

	public function tmt_a_show($subject_id, $etapa){
		$data['contenido'] = 'subject/tmt_a_show';
		$data['titulo'] = 'TMT A';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->model('Model_Tmt_a');
		$data['list'] = $this->Model_Tmt_a->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		/*querys*/
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"TMT A", 'etapa'=>$etapa));

		$this->load->view('template', $data);
	}

	public function tmt_a_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id','Id del Sujeto','required|xss_clean');
		$this->form_validation->set_rules('etapa','Etapa','required|xss_clean');
		$this->form_validation->set_rules('realizado','Realizado','required|xss_clean');

		
		$this->form_validation->set_rules('fecha','Fecha','xss_clean');
		$this->form_validation->set_rules('segundos','Segundos','xss_clean');	
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al actualizar de agregar TMT A", $registro['subject_id']);
			$this->tmt_a($registro['subject_id'], $registro['etapa']);

		}else{
			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Tmt_a');
			$this->Model_Tmt_a->update($registro);			

			$this->auditlib->save_audit("Examen TMT A actualizado", $registro['subject_id']);     		
     		redirect('subject/tmt_a_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
	}

	public function tmt_a_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de TMT A", $registro['subject_id']);
			$this->inclusion_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Tmt_a');
			$this->Model_Tmt_a->update($registro);
			$this->auditlib->save_audit("Verificacion de el formulario TMT A", $registro['subject_id']);

			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 2){
				$this->Model_Subject->update(array('tmt_a_2_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif(isset($registro['etapa']) AND $registro['etapa'] == 4){
				$this->Model_Subject->update(array('tmt_a_4_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif(isset($registro['etapa']) AND $registro['etapa'] == 5){
				$this->Model_Subject->update(array('tmt_a_5_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('tmt_a_6_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
	
	public function tmt_a_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de TMT A", $registro['subject_id']);
			$this->examen_neurologico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Tmt_a');
			$this->Model_Tmt_a->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de TMT A", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('tmt_a_2_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('tmt_a_4_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('tmt_a_5_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('tmt_a_6_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
	
	public function tmt_a_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de TMT A", $registro['subject_id']);
			$this->examen_neurologico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Tmt_a');
			$this->Model_Tmt_a->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de TMT A", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('tmt_a_2_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('tmt_a_4_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('tmt_a_5_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('tmt_a_6_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

/*-----------------------------------------------------TMT B ------------------------------------------------------------------------*/

	public function tmt_b($subject_id, $etapa){
		$data['contenido'] = 'subject/tmt_b';
		$data['titulo'] = 'TMT B';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->view('template', $data);
	}

	public function tmt_b_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id','Id del Sujeto','required|xss_clean');
		$this->form_validation->set_rules('etapa','Etapa','required|xss_clean');
		$this->form_validation->set_rules('realizado','Realizado','required|xss_clean');

		$this->form_validation->set_rules('fecha','Fecha','xss_clean');
		$this->form_validation->set_rules('segundos','Segundos','xss_clean');	
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar TMT B", $registro['subject_id']);
			$this->tmt_a($registro['subject_id'], $registro['etapa']);

		}else{

			if($registro['etapa'] == 2){
				$subjet_['tmt_b_2_status'] = "Record Complete";
			}			
			elseif($registro['etapa'] == 4){
				$subjet_['tmt_b_4_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 5){
				$subjet_['tmt_b_5_status'] = "Record Complete";
			}
			elseif($registro['etapa'] == 6){
				$subjet_['tmt_b_6_status'] = "Record Complete";
			}

			$registro['status'] = "Record Complete";
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Tmt_b');
			$this->Model_Tmt_b->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen TMT B agregado", $registro['subject_id']);     		
     		redirect('subject/tmt_b_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
	}	

	public function tmt_b_show($subject_id, $etapa){
		$data['contenido'] = 'subject/tmt_b_show';
		$data['titulo'] = 'TMT B';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->model('Model_Tmt_b');
		$data['list'] = $this->Model_Tmt_b->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		/*querys*/
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"TMT B", 'etapa'=>$etapa));

		$this->load->view('template', $data);
	}

	public function tmt_b_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id','Id del Sujeto','required|xss_clean');
		$this->form_validation->set_rules('etapa','Etapa','required|xss_clean');
		$this->form_validation->set_rules('realizado','Realizado','required|xss_clean');

		$this->form_validation->set_rules('fecha','Fecha','xss_clean');
		$this->form_validation->set_rules('segundos','Segundos','xss_clean');	
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al actualizar de agregar TMT B", $registro['subject_id']);
			$this->tmt_a($registro['subject_id'], $registro['etapa']);

		}else{
			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Tmt_b');
			$this->Model_Tmt_b->update($registro);			

			$this->auditlib->save_audit("Examen TMT B actualizado", $registro['subject_id']);     		
     		redirect('subject/tmt_b_show/'. $registro['subject_id'] ."/". $registro['etapa']);

		}
	}

	public function tmt_b_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de TMT B", $registro['subject_id']);
			$this->inclusion_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Tmt_b');
			$this->Model_Tmt_b->update($registro);
			$this->auditlib->save_audit("Verificacion de el formulario TMT B", $registro['subject_id']);

			/*Actualizar estado en el sujeto*/
			if(isset($registro['etapa']) AND $registro['etapa'] == 2){
				$this->Model_Subject->update(array('tmt_b_2_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif(isset($registro['etapa']) AND $registro['etapa'] == 4){
				$this->Model_Subject->update(array('tmt_b_4_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif(isset($registro['etapa']) AND $registro['etapa'] == 5){
				$this->Model_Subject->update(array('tmt_b_5_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('tmt_b_6_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
	
	public function tmt_b_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de TMT B", $registro['subject_id']);
			$this->examen_neurologico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Tmt_b');
			$this->Model_Tmt_b->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de TMT B", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('tmt_b_2_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('tmt_b_4_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('tmt_b_5_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('tmt_b_6_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
	
	public function tmt_b_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de TMT B", $registro['subject_id']);
			$this->examen_neurologico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Tmt_b');
			$this->Model_Tmt_b->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de TMT B", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('tmt_b_2_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('tmt_b_4_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('tmt_b_5_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('tmt_b_6_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
	
} 