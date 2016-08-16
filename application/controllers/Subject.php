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

		$this->load->model('Model_Center');		
		$centros = $this->Model_Center->all();
		$data['centros'] = array(""=>"");
		foreach ($centros as $centro) {
			$data['centros'][$centro->id] = $centro->name;
		}

		$this->load->view('template', $data);
	}

	public function insert() {		

		$registro = $this->input->post();

		$this->form_validation->set_rules('seguro', 'Esta seguro', 'required|xss_clean');
		$this->form_validation->set_rules('center', 'Centro', 'required|xss_clean');
       

        if ($this->form_validation->run() == FALSE) {
        	$this->auditlib->save_audit("Error al tratar de crear un sujeto");
            $this->create();
        }
        else {				
        	#generating de code of subject

        	// $center = $this->session->userdata('center_id');
        	$center = $registro['center'];

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
			if($this->session->userdata('center_id') != 'Todos'){
				$save['center'] = $this->session->userdata('center_id');
			}
			else{
				$save['center'] = $registro['center'];
			}
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

		$this->form_validation->set_rules('sign_consent', 'Firma Consentimiento', 'xss_clean');
		if(isset($registro['sign_consent']) AND $registro['sign_consent'] == 1){
			$this->form_validation->set_rules('sign_consent_date', 'Fecha Firma Consentimiento', 'xss_clean');
		}
		else{
			$this->form_validation->set_rules('sign_consent_date', 'Fecha Firma Consentimiento', 'xss_clean');	
		}
		$this->form_validation->set_rules('initials', 'Iniciales', 'xss_clean');
        $this->form_validation->set_rules('edad', 'Edad', 'xss_clean');
        $this->form_validation->set_rules('gender', 'Sexo', 'xss_clean');
        $this->form_validation->set_rules('birth_date', 'Fecha de Nacimiento', 'xss_clean');
		$this->form_validation->set_rules('race', 'Etnia/Raza', 'xss_clean');
		$this->form_validation->set_rules('race_especificacion', 'Etnia/Raza Especificacion', 'xss_clean');  
		$this->form_validation->set_rules('escolaridad', 'Grado de escolaridad', 'xss_clean');        
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

		$data['etnias'] = array(''=>'',
								'Caucasica - blanca'=>'Caucásica - blanca',
								'Indigena - Mapuche'=>'Indígena - Mapuche',
								'Asiatica - Mongoloide'=>'Asiatica - Mongoloíde',
								'Africana - Negroide'=>'Africana - Negroide',
								'Otro'=>'Otro'
								);
		
		
		$data['escolaridad'] = array(''=>'',
							'Basica Incompleta'=>'Básica Incompleta',
							'Basica Completa'=>'Básica Completa',
							'Ed. Media Incompleta'=>'Ed. Media Incompleta',
							'Cuarto Medio Completo'=>'Cuarto Medio Completo',
							'Tecnica Incompleta'=>'Técnica Incompleta',
							'Tecnica Completa'=>'Técnica Completa',
							'Universitaria Incompleta'=>'Universitaria Incompleta',
							'Universitaria Completa'=>'Universitaria Completa',
							'Postgrado'=>'Postgrado');
		
		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$id,"form"=>"demography", "etapa"=>0, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->auditlib->save_audit("Entro al formulario de demografia",$id);
		
		$this->load->view('template', $data);

	}
	public function demography_update(){

		$registro = $this->input->post();

		$this->form_validation->set_rules('sign_consent', 'Firmo el Concentimiento', 'xss_clean');

		
		$this->form_validation->set_rules('sign_consent_date', 'Fecha firma del concentimiento', 'xss_clean');
		$this->form_validation->set_rules('birth_date', 'Fecha de Nacimiento', 'xss_clean');
        $this->form_validation->set_rules('initials', 'Iniciales', 'xss_clean');
        $this->form_validation->set_rules('edad', 'Edad', 'xss_clean');
        $this->form_validation->set_rules('gender', 'Sexo', 'xss_clean'); 
        $this->form_validation->set_rules('race', 'Etnia/Raza', 'xss_clean');
        $this->form_validation->set_rules('race_especificacion', 'Etnia/Raza Especificacion', 'xss_clean');        
        $this->form_validation->set_rules('escolaridad', 'Grado de Escolaridad', 'xss_clean');			        
        

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Tiene errores de validacion al editar la demografia",$registro['id']);
			$this->demography($registro['id']);
		}
		else {

			if(
				$registro['sign_consent'] == 1
				AND (
					empty($registro['birth_date']) OR empty($registro['initials']) OR empty($registro['edad'])
					OR empty($registro['gender']) OR empty($registro['race']) 
					OR empty($registro['escolaridad']) OR empty($registro['sign_consent_date'])
					OR (empty($registro['race_especificacion']) AND $registro['race'] == 'Otro')
				)
			){
				$estado = 'Error';
			}else{
				$estado = 'Record Complete';
			}
			if(!empty($registro['sign_consent_date'])){
				$registro['sign_consent_date'] = $this->convertirFecha($registro['sign_consent_date']);
			}

			if(!empty($registro['birth_date'])){
				$registro['birth_date'] = $this->convertirFecha($registro['birth_date']);
			}

			$registro['demography_status'] = $estado;
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
			
        	
        	if(!empty($registro['randomization_date'])){
				$registro['randomization_date'] = $this->convertirFecha($registro['randomization_date']);
			}

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

	public function adverse_event_lista($subject_id){
		$data['contenido'] = 'subject/adverse_event_list';
		$data['titulo'] = 'Adverse Event/Serious Adverse Event';
		$data['subject'] = $this->Model_Subject->find($subject_id);

		$this->load->model('Model_Adverse_event_form');		
		$data['lista'] = $this->Model_Adverse_event_form->allWhere('subject_id',$subject_id);
		
		// $this->auditlib->save_audit("Entro al formulario de evento adverso", $id);
		$this->load->view('template', $data);
	}

	public function adverse_event_form_insert(){
		$registro = $this->input->post();

		$id = $registro['subject_id'];

		$this->form_validation->set_rules('subject_id', 'Stage', 'required|xss_clean');
		$this->form_validation->set_rules('stage', 'Stage', 'xss_clean');
        $this->form_validation->set_rules('event_category', 'Event Category', 'xss_clean');     
        $this->form_validation->set_rules('event_category_description', 'Description', 'xss_clean');
        $this->form_validation->set_rules('event_category_narrative', 'Narrative', 'xss_clean');
        $this->form_validation->set_rules('date_of_onset', 'Date of Onset', 'xss_clean');
        $this->form_validation->set_rules('continuing', 'Continuing', 'xss_clean');
        
        if(isset($registro['continuing']) AND $registro['continuing'] == 0){
        	$this->form_validation->set_rules('date_of_resolution', 'Date of Resolution', 'xss_clean');	
        }else{
        	$this->form_validation->set_rules('date_of_resolution', 'Date of Resolution', 'xss_clean');
        }
        
        $this->form_validation->set_rules('assessment_of_severity', 'Assessment of Severity', 'xss_clean');
        $this->form_validation->set_rules('assessment_of_casuality', 'Assessment of Casuality', 'xss_clean');
        $this->form_validation->set_rules('sae', 'SAE', 'xss_clean');

		$this->form_validation->set_rules('action_taken_none', 'action_taken_none', 'xss_clean');
		$this->form_validation->set_rules('action_taken_medication', 'action_taken_medication', 'xss_clean');
		$this->form_validation->set_rules('action_taken_hospitalization', 'action_taken_hospitalization', 'xss_clean');

        $this->form_validation->set_rules('action_taken_on_investigation_product', 'Action Taken on Investigation Product', 'xss_clean');
        

        if ($this->form_validation->run() == FALSE) {
        	$this->auditlib->save_audit("Tiene errores de validacion en el formulario de evento adverso",$id);
            $this->adverse_event_form($id);
        }
        else {				

        	if(
        		!isset($registro['stage']) OR $registro['stage'] == ''
        		OR !isset($registro['event_category']) OR $registro['event_category'] == ''
        		OR !isset($registro['event_category_description']) OR $registro['event_category_description'] == ''
        		OR !isset($registro['event_category_narrative']) OR $registro['event_category_narrative'] == ''
        		OR !isset($registro['date_of_onset']) OR $registro['date_of_onset'] == ''
        		OR !isset($registro['continuing']) OR $registro['continuing'] == ''        		
        		OR ($registro['continuing'] == 0 AND $registro['date_of_resolution'] == '')
        		OR !isset($registro['assessment_of_severity']) OR $registro['assessment_of_severity'] == ''
        		OR !isset($registro['assessment_of_casuality']) OR $registro['assessment_of_casuality'] == ''
        		OR !isset($registro['sae']) OR $registro['sae'] == ''
        		OR (!isset($registro['action_taken_none']) AND !isset($registro['action_taken_medication'])  AND !isset($registro['action_taken_hospitalization']))
        		OR !isset($registro['action_taken_on_investigation_product']) OR $registro['action_taken_on_investigation_product'] == ''
        	)
        	{
        		$estado = 'Error';
        	}
        	else{
        		$estado = 'Record Complete';
        	}		
			
        	if(!empty($registro['date_of_resolution'])){
				$registro['date_of_resolution'] = $this->convertirFecha($registro['date_of_resolution']);
			}
			if(!empty($registro['date_of_onset'])){
				$registro['date_of_onset'] = $this->convertirFecha($registro['date_of_onset']);
			}

			$registro['status'] = $estado;	
			$registro['created'] = date('Y/m/d H:i:s');			
			
			$this->load->model("Model_Adverse_event_form");
			$this->Model_Adverse_event_form->insert($registro);			
			$this->auditlib->save_audit("Agrego informacion de evento adverso",$id);
			redirect('subject/grid/'. $registro['subject_id']);
        }
	}

	public function adverse_event_show($subject_id, $id){
		$data['contenido'] = 'subject/adverse_event_show';
		$data['titulo'] = 'Evento Adverso';
		$data['subject'] = $this->Model_Subject->find($subject_id);

		$this->load->model('Model_Adverse_event_form');		
		$data['list'] = $this->Model_Adverse_event_form->allWhere('id',$id);

		// $data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$id,"form"=>"Adverse Event"));

		$this->auditlib->save_audit("Entro al formulario de eventos adversos",$id);

		$this->load->view('template', $data);
	}

	public function adverse_event_form_update(){
		$registro = $this->input->post();

		$id = $registro['subject_id'];
		$this->form_validation->set_rules('subject_id', 'Stage', 'required|xss_clean');
		$this->form_validation->set_rules('stage', 'Stage', 'xss_clean');
        $this->form_validation->set_rules('event_category', 'Event Category', 'xss_clean');     
        $this->form_validation->set_rules('event_category_description', 'Description', 'xss_clean');
        $this->form_validation->set_rules('event_category_narrative', 'Narrative', 'xss_clean');
        $this->form_validation->set_rules('date_of_onset', 'Date of Onset', 'xss_clean');
        $this->form_validation->set_rules('continuing', 'Continuing', 'xss_clean');
        
        if(isset($registro['continuing']) AND $registro['continuing'] == 0){
        	$this->form_validation->set_rules('date_of_resolution', 'Date of Resolution', 'xss_clean');	
        }else{
        	$this->form_validation->set_rules('date_of_resolution', 'Date of Resolution', 'xss_clean');
        }
        
        $this->form_validation->set_rules('assessment_of_severity', 'Assessment of Severity', 'xss_clean');
        $this->form_validation->set_rules('assessment_of_casuality', 'Assessment of Casuality', 'xss_clean');
        $this->form_validation->set_rules('sae', 'SAE', 'xss_clean');

		$this->form_validation->set_rules('action_taken_none', 'action_taken_none', 'xss_clean');
		$this->form_validation->set_rules('action_taken_medication', 'action_taken_medication', 'xss_clean');
		$this->form_validation->set_rules('action_taken_hospitalization', 'action_taken_hospitalization', 'xss_clean');

        $this->form_validation->set_rules('action_taken_on_investigation_product', 'Action Taken on Investigation Product', 'xss_clean');
        

        if ($this->form_validation->run() == FALSE) {
        	$this->auditlib->save_audit("Tiene errores de validacion en el formulario de evento adverso",$id);
            $this->adverse_event_form($id);
        }
        else {		

        	if(
        		!isset($registro['stage']) OR $registro['stage'] == ''
        		OR !isset($registro['event_category']) OR $registro['event_category'] == ''
        		OR !isset($registro['event_category_description']) OR $registro['event_category_description'] == ''
        		OR !isset($registro['event_category_narrative']) OR $registro['event_category_narrative'] == ''
        		OR !isset($registro['date_of_onset']) OR $registro['date_of_onset'] == ''
        		OR !isset($registro['continuing']) OR $registro['continuing'] == ''        		
        		OR ($registro['continuing'] == 0 AND $registro['date_of_resolution'] == '')
        		OR !isset($registro['assessment_of_severity']) OR $registro['assessment_of_severity'] == ''
        		OR !isset($registro['assessment_of_casuality']) OR $registro['assessment_of_casuality'] == ''
        		OR !isset($registro['sae']) OR $registro['sae'] == ''
        		OR (!isset($registro['action_taken_none']) AND !isset($registro['action_taken_medication'])  AND !isset($registro['action_taken_hospitalization']))
        		OR !isset($registro['action_taken_on_investigation_product']) OR $registro['action_taken_on_investigation_product'] == ''
        	)
        	{
        		$estado = 'Error';
        	}
        	else{
        		$estado = 'Record Complete';
        	}


			
        	if(!empty($registro['date_of_resolution'])){
				$registro['date_of_resolution'] = $this->convertirFecha($registro['date_of_resolution']);
			}
			if(!empty($registro['date_of_onset'])){
				$registro['date_of_onset'] = $this->convertirFecha($registro['date_of_onset']);
			}

			$registro['status'] = $estado;	
			$registro['updated_at'] = date('Y/m/d H:i:s');	
     		$registro['usuario_actualizacion'] = $this->session->userdata('usuario');		
			
			$this->load->model("Model_Adverse_event_form");
			$this->Model_Adverse_event_form->update($registro);			
			$this->auditlib->save_audit("Agrego informacion de evento adverso",$id);
			redirect('subject/grid/'. $registro['subject_id']);
        }
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

	public function protocol_deviation_lista($subject_id){
		$data['contenido'] = 'subject/protocol_deviation_list';
		$data['titulo'] = 'Adverse Event/Serious Adverse Event';
		$data['subject'] = $this->Model_Subject->find($subject_id);

		$this->load->model('Model_Protocol_deviation_form');		
		$data['lista'] = $this->Model_Protocol_deviation_form->allWhere('subject_id',$subject_id);
		
		// $this->auditlib->save_audit("Entro al formulario de evento adverso", $id);
		$this->load->view('template', $data);
	}

	public function protocol_deviation_form_insert(){
		$registro = $this->input->post();

		$id = $registro['subject_id'];

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('date_of_deviation', 'Date of Deviation', 'xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'xss_clean');     
        $this->form_validation->set_rules('pre_approved', 'Pre-Approved', 'xss_clean');

        

        if (isset($registro['pre_approved']) AND $registro['pre_approved'] == 1) {
        	$this->form_validation->set_rules('sponsor_name', 'Sponsor Name', 'xss_clean');
        }else{
        	$this->form_validation->set_rules('sponsor_name', 'Sponsor Name', 'xss_clean');
        }
     	
     	if ($this->form_validation->run() == FALSE) {
     		$this->auditlib->save_audit("Has validation errors in protocol deviation form");
            $this->protocol_deviation_form($id);
        }
        else {						

        	if(
        		!isset($registro['date_of_deviation']) OR $registro['date_of_deviation'] == ''
        		OR !isset($registro['description']) OR $registro['description'] == ''
        		OR !isset($registro['pre_approved']) OR $registro['pre_approved'] == ''
        		OR ($registro['pre_approved'] == 1 AND $registro['sponsor_name'] == '')
        	)
        	{
        		$estado = 'Error';
        	}
        	else{
        		$estado = 'Record Complete';
        	}


			if(!empty($registro['date_of_deviation'])){
				$registro['date_of_deviation'] = $this->convertirFecha($registro['date_of_deviation']);
			}
			$registro['created'] = date('Y/m/d H:i:s');	
			$registro['status'] = $estado;		
			
			$this->load->model("Model_Protocol_deviation_form");
			$this->Model_Protocol_deviation_form->insert($registro);			
			$this->auditlib->save_audit("Insert new protocl deviation record");

			redirect('subject/grid/'. $id);
        }   
        
	}

	public function protocol_deviation_show($subject_id, $id){
		$data['contenido'] = 'subject/protocol_deviation_show';
		$data['titulo'] = 'Protocol Deviation';
		$data['subject'] = $this->Model_Subject->find($subject_id);

		$this->load->model('Model_Protocol_deviation_form');		
		$data['list'] = $this->Model_Protocol_deviation_form->allWhere('id',$id);

		// $data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$id,"form"=>"Protocol Deviation"));

		$this->auditlib->save_audit("View list of protocol deviation");

		$this->load->view('template', $data);
	}

	public function protocol_deviation_form_update(){
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

        	if(
        		!isset($registro['date_of_deviation']) OR $registro['date_of_deviation'] == ''
        		OR !isset($registro['description']) OR $registro['description'] == ''
        		OR !isset($registro['pre_approved']) OR $registro['pre_approved'] == ''
        		OR ($registro['pre_approved'] == 1 AND $registro['sponsor_name'] == '')
        	)
        	{
        		$estado = 'Error';
        	}
        	else{
        		$estado = 'Record Complete';
        	}

			if(!empty($registro['date_of_deviation'])){
				$registro['date_of_deviation'] = $this->convertirFecha($registro['date_of_deviation']);
			}
			$registro['updated_at'] = date('Y/m/d H:i:s');	
     		$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
     		$registro['status'] = $estado;		
			
			$this->load->model("Model_Protocol_deviation_form");
			$this->Model_Protocol_deviation_form->update($registro);			
			$this->auditlib->save_audit("Insert new protocl deviation record");

			redirect('subject/grid/'. $id);
        }   
        
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

	public function concomitant_medication_lista($subject_id){
		$data['contenido'] = 'subject/concomitant_medication_list';
		$data['titulo'] = 'Adverse Event/Serious Adverse Event';
		$data['subject'] = $this->Model_Subject->find($subject_id);

		$this->load->model('Model_Concomitant_medication_form');		
		$data['lista'] = $this->Model_Concomitant_medication_form->allWhere('subject_id',$subject_id);
		
		// $this->auditlib->save_audit("Entro al formulario de evento adverso", $id);
		$this->load->view('template', $data);
	}

	public function concomitant_medication_form_insert(){
		$registro = $this->input->post();

		$id = $registro['subject_id'];

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('brand_name', 'Brand Name', 'xss_clean');
        $this->form_validation->set_rules('generic_name', 'Generic Name', 'xss_clean');     
        $this->form_validation->set_rules('indication', 'Indications', 'xss_clean');
        $this->form_validation->set_rules('unit_of_measure', 'Unit of Measure', 'xss_clean');
        $this->form_validation->set_rules('daily_dose', 'Daily Dose', 'xss_clean');        
        $this->form_validation->set_rules('frequency', 'Frequency', 'xss_clean');
        if($registro['frequency'] == 'Other'){

        	$this->form_validation->set_rules('other', 'Other Frequency', 'xss_clean');
        }else{
        	$this->form_validation->set_rules('other', 'Other Frequency', 'xss_clean');
        }

        $this->form_validation->set_rules('route', 'Route', 'xss_clean');
        $this->form_validation->set_rules('start_date', 'Star Date', 'xss_clean');
        $this->form_validation->set_rules('on_going', 'On Going', 'xss_clean');
        if(isset($registro['on_going']) AND $registro['on_going'] == 0){
        	$this->form_validation->set_rules('end_date', 'End Date', 'xss_clean');
        }
        else{
        	$this->form_validation->set_rules('end_date', 'End Date', 'xss_clean');	
        }

             	
     	if ($this->form_validation->run() == FALSE) {
     		$this->auditlib->save_audit("has validation errors in concomitant medication form");
            $this->concomitant_medication_form($id);
        }
        else {						

        	if(
        		!isset($registro['brand_name']) OR $registro['brand_name'] == ''
        		OR !isset($registro['generic_name']) OR $registro['generic_name'] == ''
        		OR !isset($registro['indication']) OR $registro['indication'] == ''
        		OR !isset($registro['unit_of_measure']) OR $registro['unit_of_measure'] == ''
        		OR !isset($registro['daily_dose']) OR $registro['daily_dose'] == ''
        		OR !isset($registro['frequency']) OR $registro['frequency'] == ''
        		OR ($registro['frequency'] == 'Other' AND $registro['other'] == '')
        		OR !isset($registro['route']) OR $registro['route'] == ''
        		OR !isset($registro['start_date']) OR $registro['start_date'] == ''
        		OR !isset($registro['on_going']) OR $registro['on_going'] == ''
        		OR ($registro['on_going'] == 0 AND $registro['end_date'] == '')
        		
        	){
        		$estado = 'Error';
        	}
        	else{
        		$estado = 'Record Complete';
        	}
			
        	if($registro['frequency'] == 'other'){
        		$registro['frequency'] = $registro['other'];
        	}
        	unset($registro['other']);

        	if(isset($registro['start_date']) AND !empty($registro['start_date'])){
        		$registro['start_date'] = $this->convertirFecha($registro['start_date']);
        	}
        	if(isset($registro['end_date']) AND !empty($registro['end_date'])){
        		$registro['end_date'] = $this->convertirFecha($registro['end_date']);
        	}

			$registro['created'] = date('Y/m/d H:i:s');	
			$registro['status']	= $estado;
			
			$this->load->model("Model_Concomitant_medication_form");
			$this->Model_Concomitant_medication_form->insert($registro);			
			$this->auditlib->save_audit("Insert new concomitant medication record for a subject");

			redirect('subject/grid/'. $registro['subject_id']);
        }   
	}	

	public function concomitant_medication_show($subject_id, $id){
		$data['contenido'] = 'subject/concomitant_medication_show';
		$data['titulo'] = 'Concomitant Medication';
		$data['subject'] = $this->Model_Subject->find($subject_id);

		$this->load->model('Model_Concomitant_medication_form');		
		$data['list'] = $this->Model_Concomitant_medication_form->allWhere('id',$id);

		// $data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$id,"form"=>"Concomitant Medication"));

		$this->auditlib->save_audit("Show list for concomitant medication for a subject");
		$this->load->view('template', $data);
	}

	public function concomitant_medication_form_update(){
		$registro = $this->input->post();

		$id = $registro['subject_id'];

		$this->form_validation->set_rules('subject_id', '', 'xss_clean');
		$this->form_validation->set_rules('brand_name', 'Brand Name', 'xss_clean');
        $this->form_validation->set_rules('generic_name', 'Generic Name', 'xss_clean');     
        $this->form_validation->set_rules('indication', 'Indications', 'xss_clean');
        $this->form_validation->set_rules('unit_of_measure', 'Unit of Measure', 'xss_clean');
        $this->form_validation->set_rules('daily_dose', 'Daily Dose', 'xss_clean');        
        $this->form_validation->set_rules('frequency', 'Frequency', 'xss_clean');
        if($registro['frequency'] == 'Other'){

        	$this->form_validation->set_rules('other', 'Other Frequency', 'xss_clean');
        }else{
        	$this->form_validation->set_rules('other', 'Other Frequency', 'xss_clean');
        }

        $this->form_validation->set_rules('route', 'Route', 'xss_clean');
        $this->form_validation->set_rules('start_date', 'Star Date', 'xss_clean');
        $this->form_validation->set_rules('on_going', 'On Going', 'xss_clean');
        if(isset($registro['on_going']) AND $registro['on_going'] == 0){
        	$this->form_validation->set_rules('end_date', 'End Date', 'xss_clean');
        }
        else{
        	$this->form_validation->set_rules('end_date', 'End Date', 'xss_clean');	
        }

             	
     	if ($this->form_validation->run() == FALSE) {
     		$this->auditlib->save_audit("has validation errors in concomitant medication form");
            $this->concomitant_medication_form($id);
        }
        else {						
			
        	if(
        		!isset($registro['brand_name']) OR $registro['brand_name'] == ''
        		OR !isset($registro['generic_name']) OR $registro['generic_name'] == ''
        		OR !isset($registro['indication']) OR $registro['indication'] == ''
        		OR !isset($registro['unit_of_measure']) OR $registro['unit_of_measure'] == ''
        		OR !isset($registro['daily_dose']) OR $registro['daily_dose'] == ''
        		OR !isset($registro['frequency']) OR $registro['frequency'] == ''
        		OR ($registro['frequency'] == 'Other' AND $registro['other'] == '')
        		OR !isset($registro['route']) OR $registro['route'] == ''
        		OR !isset($registro['start_date']) OR $registro['start_date'] == ''
        		OR !isset($registro['on_going']) OR $registro['on_going'] == ''
        		OR ($registro['on_going'] == 0 AND $registro['end_date'] == '')
        		
        	){
        		$estado = 'Error';
        	}
        	else{
        		$estado = 'Record Complete';
        	}

        	if($registro['frequency'] == 'other'){
        		$registro['frequency'] = $registro['other'];
        	}
        	unset($registro['other']);

        	if(isset($registro['start_date']) AND !empty($registro['start_date'])){
        		$registro['start_date'] = $this->convertirFecha($registro['start_date']);
        	}
        	if(isset($registro['end_date']) AND !empty($registro['end_date'])){
        		$registro['end_date'] = $this->convertirFecha($registro['end_date']);
        	}

        	$registro['status'] = $estado;

			$registro['updated_at'] = date('Y/m/d H:i:s');	
     		$registro['usuario_actualizacion'] = $this->session->userdata('usuario');		
			
			$this->load->model("Model_Concomitant_medication_form");
			$this->Model_Concomitant_medication_form->update($registro);			
			$this->auditlib->save_audit("Insert new concomitant medication record for a subject");

			redirect('subject/grid/'. $registro['subject_id']);
        }   
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
     		$save['usuario_actualizacion'] = $this->session->userdata('usuario');	
     		$save['created_by'] = $this->session->userdata('usuario');		
     		$save['status']  = "Record Complete";
     		$save['stage']  = "stage_1";

     		if(!empty($save['fecha'])){
				$save['fecha'] = $this->convertirFecha($save['fecha']);
			}

     		$this->load->model('Model_Hachinski_Form');
     		$this->Model_Hachinski_Form->insert($save);
     		$this->auditlib->save_audit("Escala de Hachinski ingresada",$id);
     		
     		

     		/*Actualizar estado de hachinski en el sujeto*/
     		$actualizar['hachinski_status'] = 'Record Complete';
     		$actualizar['id'] = $id;
     		$this->Model_Subject->update($actualizar);

     		redirect('subject/grid/'. $id);

        }
        else {						
			
        	$this->hachinski_form($id);
        }

	}

	public function hachinski_update(){
		
		$save = $this->input->post();
		$save['updated_at'] = date('Y/m/d H:i:s');
		$save['usuario_actualizacion'] = $this->session->userdata('usuario');

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

			if(!empty($save['fecha'])){
				$save['fecha'] = $this->convertirFecha($save['fecha']);
			}

			$this->load->model('Model_Hachinski_Form');
	 		$this->Model_Hachinski_Form->update($save);
	 		$this->auditlib->save_audit("Escala de Hachinski Actualizada",$id);

	 		redirect('subject/grid/'. $id);
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
		
		/*querys abiertos para el formulario*/
		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$id,"form"=>"hachinski", "etapa"=>0, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}


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
/*-------------------------------------------EXAMEN FISICO (Antes HISTORIAL MEDICO)---------------------------------------------------------------------------*/
	public function examen_fisico($id,$etapa){
		$data['contenido'] = 'subject/examen_fisico';
		$data['titulo'] = 'Examen Fisico';
		$data['subject'] = $this->Model_Subject->find($id);
		$data['etapa'] = $etapa;

		$this->load->view('template', $data);
	}

	public function examen_fisico_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');
		$this->form_validation->set_rules('hallazgo', 'Realizado', 'required|xss_clean');
		$this->form_validation->set_rules('misma_fecha', '', 'xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		
		/*Si se tiene algun hallazgo todo es obligatorio*/
	
		$this->form_validation->set_rules('aspecto_general', '', 'xss_clean');
		$this->form_validation->set_rules('aspecto_general_desc', '', 'xss_clean');
		$this->form_validation->set_rules('estado_nutricional', '', 'xss_clean');
		$this->form_validation->set_rules('estado_nutricional_desc', '', 'xss_clean');
		$this->form_validation->set_rules('piel', '', 'xss_clean');
		$this->form_validation->set_rules('piel_desc', '', 'xss_clean');
		$this->form_validation->set_rules('cabeza', '', 'xss_clean');
		$this->form_validation->set_rules('cabeza_desc', '', 'xss_clean');
		$this->form_validation->set_rules('ojos', '', 'xss_clean');
		$this->form_validation->set_rules('ojos_desc', '', 'xss_clean');
		$this->form_validation->set_rules('nariz', '', 'xss_clean');			
		$this->form_validation->set_rules('nariz_desc', '', 'xss_clean');
		$this->form_validation->set_rules('oidos', '', 'xss_clean');
		$this->form_validation->set_rules('oidos_desc', '', 'xss_clean');
		$this->form_validation->set_rules('boca', '', 'xss_clean');
		$this->form_validation->set_rules('boca_desc', '', 'xss_clean');
		$this->form_validation->set_rules('cuello', '', 'xss_clean');
		$this->form_validation->set_rules('cuello_desc', '', 'xss_clean');
		$this->form_validation->set_rules('pulmones', '', 'xss_clean');
		$this->form_validation->set_rules('pulmones_desc', '', 'xss_clean');
		$this->form_validation->set_rules('cardiovascular', '', 'xss_clean');
		$this->form_validation->set_rules('cardiovascular_desc', '', 'xss_clean');
		$this->form_validation->set_rules('abdomen', '', 'xss_clean');
		$this->form_validation->set_rules('abdomen_desc', '', 'xss_clean');
		$this->form_validation->set_rules('muscular', '', 'xss_clean');
		$this->form_validation->set_rules('muscular_desc', '', 'xss_clean');
		$this->form_validation->set_rules('tuvo_cambios', '', 'xss_clean');
		$this->form_validation->set_rules('cambios_observaciones', '', 'xss_clean');	
		
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');


		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Tuvo errores al tratar de agregar Examen Fisico", $registro['subject_id']);
			$this->examen_fisico($registro['subject_id'],$registro['etapa']);
		}
		else {
			

			if(isset($registro['hallazgo']) AND $registro['hallazgo'] == 1
				AND
				(
					$registro['etapa'] == 1 AND
					(
						(isset($registro['aspecto_general']) AND $registro['aspecto_general'] == '0' AND empty($registro['aspecto_general_desc']))
						OR
						(isset($registro['estado_nutricional']) AND $registro['estado_nutricional'] == '0' AND empty($registro['estado_nutricional_desc']))
						OR
						(isset($registro['piel']) AND $registro['piel'] == '0' AND empty($registro['piel_desc']))
						OR
						(isset($registro['cabeza']) AND $registro['cabeza'] == '0' AND empty($registro['cabeza_desc']))
						OR
						(isset($registro['ojos']) AND $registro['ojos'] == '0' AND empty($registro['ojos_desc']))
						OR
						(isset($registro['nariz']) AND $registro['nariz'] == '0' AND empty($registro['nariz_desc']))
						OR
						(isset($registro['oidos']) AND $registro['oidos'] == '0' AND empty($registro['oidos_desc']))
						OR
						(isset($registro['boca']) AND $registro['boca'] == '0' AND empty($registro['boca_desc']))
						OR
						(isset($registro['cuello']) AND $registro['cuello'] == '0' AND empty($registro['cuello_desc']))
						OR
						(isset($registro['pulmones']) AND $registro['pulmones'] == '0' AND empty($registro['pulmones_desc']))
						OR
						(isset($registro['cardiovascular']) AND $registro['cardiovascular'] == '0' AND empty($registro['cardiovascular_desc']))
						OR
						(isset($registro['abdomen']) AND $registro['abdomen'] == '0' AND empty($registro['abdomen_desc']))
						OR
						(isset($registro['muscular']) AND $registro['muscular'] == '0' AND empty($registro['muscular_desc']))										

						OR !isset($registro['aspecto_general']) OR !isset($registro['estado_nutricional']) OR !isset($registro['piel']) OR !isset($registro['cabeza'])
						OR !isset($registro['ojos']) OR !isset($registro['nariz']) OR !isset($registro['oidos']) OR !isset($registro['boca'])
						OR !isset($registro['cuello']) OR !isset($registro['pulmones']) OR !isset($registro['cardiovascular']) OR !isset($registro['abdomen'])
						OR !isset($registro['muscular'])
					)
					OR
					$registro['etapa'] != 1 AND
					(
						(isset($registro['aspecto_general']) AND $registro['aspecto_general'] == '0' AND empty($registro['aspecto_general_desc']))
						OR
						(isset($registro['estado_nutricional']) AND $registro['estado_nutricional'] == '0' AND empty($registro['estado_nutricional_desc']))
						OR
						(isset($registro['pulmones']) AND $registro['pulmones'] == '0' AND empty($registro['pulmones_desc']))
						OR
						(isset($registro['cardiovascular']) AND $registro['cardiovascular'] == '0' AND empty($registro['cardiovascular_desc']))
						OR
						(isset($registro['abdomen']) AND $registro['abdomen'] == '0' AND empty($registro['abdomen_desc']))
						OR
						(isset($registro['muscular']) AND $registro['muscular'] == '0' AND empty($registro['muscular_desc']))					

						OR !isset($registro['aspecto_general']) OR !isset($registro['estado_nutricional']) OR !isset($registro['pulmones']) 
						OR !isset($registro['cardiovascular']) OR !isset($registro['abdomen']) OR !isset($registro['muscular'])
					)
					OR empty($registro['fecha'])
					
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}

			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');

			$this->load->model("Model_Examen_fisico");
			$this->Model_Examen_fisico->insert($registro);

			$this->auditlib->save_audit("Examen Fisico Ingresado", $registro['subject_id']);


			/*Actualizar estado en el sujeto*/
			if($registro['etapa'] == 1){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_1_status'=>$estado));
			}
			elseif($registro['etapa'] == 2){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_2_status'=>$estado));
			}
			elseif($registro['etapa'] == 3){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_3_status'=>$estado));
			}
			elseif($registro['etapa'] == 4){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_4_status'=>$estado));
			}
			elseif($registro['etapa'] == 5){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_5_status'=>$estado));
			}
			elseif($registro['etapa'] == 6){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_6_status'=>$estado));
			}

     		redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_fisico_show($subject_id,$etapa){
		$data['contenido'] = 'subject/examen_fisico_show';
		$data['titulo'] = 'Examen Fisico';
		$data['subject'] = $this->Model_Subject->find($subject_id);
		$data['etapa'] = $etapa;

		$this->load->model("Model_Examen_fisico");
		$data['list'] = $this->Model_Examen_fisico->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"examen_fisico", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->view('template', $data);
	}

	public function examen_fisico_update(){

		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');
		$this->form_validation->set_rules('hallazgo', 'Realizado', 'required|xss_clean');
		$this->form_validation->set_rules('misma_fecha', '', 'xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		
		$this->form_validation->set_rules('aspecto_general', '', 'xss_clean');
		$this->form_validation->set_rules('aspecto_general_desc', '', 'xss_clean');
		$this->form_validation->set_rules('estado_nutricional', '', 'xss_clean');
		$this->form_validation->set_rules('estado_nutricional_desc', '', 'xss_clean');
		$this->form_validation->set_rules('piel', '', 'xss_clean');
		$this->form_validation->set_rules('piel_desc', '', 'xss_clean');
		$this->form_validation->set_rules('cabeza', '', 'xss_clean');
		$this->form_validation->set_rules('cabeza_desc', '', 'xss_clean');
		$this->form_validation->set_rules('ojos', '', 'xss_clean');
		$this->form_validation->set_rules('ojos_desc', '', 'xss_clean');
		$this->form_validation->set_rules('nariz', '', 'xss_clean');			
		$this->form_validation->set_rules('nariz_desc', '', 'xss_clean');
		$this->form_validation->set_rules('oidos', '', 'xss_clean');
		$this->form_validation->set_rules('oidos_desc', '', 'xss_clean');
		$this->form_validation->set_rules('boca', '', 'xss_clean');
		$this->form_validation->set_rules('boca_desc', '', 'xss_clean');
		$this->form_validation->set_rules('cuello', '', 'xss_clean');
		$this->form_validation->set_rules('cuello_desc', '', 'xss_clean');
		$this->form_validation->set_rules('pulmones', '', 'xss_clean');
		$this->form_validation->set_rules('pulmones_desc', '', 'xss_clean');
		$this->form_validation->set_rules('cardiovascular', '', 'xss_clean');
		$this->form_validation->set_rules('cardiovascular_desc', '', 'xss_clean');
		$this->form_validation->set_rules('abdomen', '', 'xss_clean');
		$this->form_validation->set_rules('abdomen_desc', '', 'xss_clean');
		$this->form_validation->set_rules('muscular', '', 'xss_clean');
		$this->form_validation->set_rules('muscular_desc', '', 'xss_clean');
		$this->form_validation->set_rules('tuvo_cambios', '', 'xss_clean');
		$this->form_validation->set_rules('cambios_observaciones', '', 'xss_clean');
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Tuvo errores al tratar de actualizar el examen fisico", $registro['subject_id']);
			$this->examen_fisico_show($registro['subject_id'], $registro['etapa']);
		}
		else {

			if(isset($registro['hallazgo']) AND $registro['hallazgo'] == 1
				AND
				(
					$registro['etapa'] == 1 AND
					(
						(isset($registro['aspecto_general']) AND $registro['aspecto_general'] == '0' AND empty($registro['aspecto_general_desc']))
						OR
						(isset($registro['estado_nutricional']) AND $registro['estado_nutricional'] == '0' AND empty($registro['estado_nutricional_desc']))
						OR
						(isset($registro['piel']) AND $registro['piel'] == '0' AND empty($registro['piel_desc']))
						OR
						(isset($registro['cabeza']) AND $registro['cabeza'] == '0' AND empty($registro['cabeza_desc']))
						OR
						(isset($registro['ojos']) AND $registro['ojos'] == '0' AND empty($registro['ojos_desc']))
						OR
						(isset($registro['nariz']) AND $registro['nariz'] == '0' AND empty($registro['nariz_desc']))
						OR
						(isset($registro['oidos']) AND $registro['oidos'] == '0' AND empty($registro['oidos_desc']))
						OR
						(isset($registro['boca']) AND $registro['boca'] == '0' AND empty($registro['boca_desc']))
						OR
						(isset($registro['cuello']) AND $registro['cuello'] == '0' AND empty($registro['cuello_desc']))
						OR
						(isset($registro['pulmones']) AND $registro['pulmones'] == '0' AND empty($registro['pulmones_desc']))
						OR
						(isset($registro['cardiovascular']) AND $registro['cardiovascular'] == '0' AND empty($registro['cardiovascular_desc']))
						OR
						(isset($registro['abdomen']) AND $registro['abdomen'] == '0' AND empty($registro['abdomen_desc']))
						OR
						(isset($registro['muscular']) AND $registro['muscular'] == '0' AND empty($registro['muscular_desc']))										

						OR !isset($registro['aspecto_general']) OR !isset($registro['estado_nutricional']) OR !isset($registro['piel']) OR !isset($registro['cabeza'])
						OR !isset($registro['ojos']) OR !isset($registro['nariz']) OR !isset($registro['oidos']) OR !isset($registro['boca'])
						OR !isset($registro['cuello']) OR !isset($registro['pulmones']) OR !isset($registro['cardiovascular']) OR !isset($registro['abdomen'])
						OR !isset($registro['muscular'])
					)
					OR
					$registro['etapa'] != 1 AND
					(
						(isset($registro['aspecto_general']) AND $registro['aspecto_general'] == '0' AND empty($registro['aspecto_general_desc']))
						OR
						(isset($registro['estado_nutricional']) AND $registro['estado_nutricional'] == '0' AND empty($registro['estado_nutricional_desc']))
						OR
						(isset($registro['pulmones']) AND $registro['pulmones'] == '0' AND empty($registro['pulmones_desc']))
						OR
						(isset($registro['cardiovascular']) AND $registro['cardiovascular'] == '0' AND empty($registro['cardiovascular_desc']))
						OR
						(isset($registro['abdomen']) AND $registro['abdomen'] == '0' AND empty($registro['abdomen_desc']))
						OR
						(isset($registro['muscular']) AND $registro['muscular'] == '0' AND empty($registro['muscular_desc']))					

						OR !isset($registro['aspecto_general']) OR !isset($registro['estado_nutricional']) OR !isset($registro['pulmones']) 
						OR !isset($registro['cardiovascular']) OR !isset($registro['abdomen']) OR !isset($registro['muscular'])
					)
					OR empty($registro['fecha'])
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}

			$registro['updated_at'] = date("Y-m-d H:i:s");	
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');					
			$registro['status'] = $estado;

			$this->load->model("Model_Examen_fisico");
			$this->Model_Examen_fisico->update($registro);

			$this->auditlib->save_audit("Examen Fisico Actualizado",$registro['subject_id']);

			/*Actualizar estado en el sujeto*/
			if($registro['etapa'] == 1){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_1_status'=>$estado));
			}
			elseif($registro['etapa'] == 2){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_2_status'=>$estado));
			}
			elseif($registro['etapa'] == 3){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_3_status'=>$estado));
			}
			elseif($registro['etapa'] == 4){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_4_status'=>$estado));
			}
			elseif($registro['etapa'] == 5){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_5_status'=>$estado));
			}
			elseif($registro['etapa'] == 6){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_6_status'=>$estado));
			}

     		redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_fisico_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de examen fisico", $registro['subject_id']);
			$this->examen_fisico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_fisico');
			$this->Model_Examen_fisico->update($registro);
			$this->auditlib->save_audit("Verificacion de el formulario de examen fisico", $registro['subject_id']);

						/*Actualizar estado en el sujeto*/
			if($registro['etapa'] == 1){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_1_status'=>'Form Approved by Monitor'));
			}
			elseif($registro['etapa'] == 2){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_2_status'=>'Form Approved by Monitor'));
			}
			elseif($registro['etapa'] == 3){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_3_status'=>'Form Approved by Monitor'));
			}
			elseif($registro['etapa'] == 4){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_4_status'=>'Form Approved by Monitor'));
			}
			elseif($registro['etapa'] == 5){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_5_status'=>'Form Approved by Monitor'));
			}
			elseif($registro['etapa'] == 6){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_6_status'=>'Form Approved by Monitor'));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_fisico_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de examen fisico", $registro['subject_id']);
			$this->examen_fisico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_fisico');
			$this->Model_Examen_fisico->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de examen fisico", $registro['subject_id']);
						/*Actualizar estado en el sujeto*/
			if($registro['etapa'] == 1){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_1_status'=>'Document Approved and Signed by PI'));
			}
			elseif($registro['etapa'] == 2){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_2_status'=>'Document Approved and Signed by PI'));
			}
			elseif($registro['etapa'] == 3){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_3_status'=>'Document Approved and Signed by PI'));
			}
			elseif($registro['etapa'] == 4){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_4_status'=>'Document Approved and Signed by PI'));
			}
			elseif($registro['etapa'] == 5){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_5_status'=>'Document Approved and Signed by PI'));
			}
			elseif($registro['etapa'] == 6){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_6_status'=>'Document Approved and Signed by PI'));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_fisico_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de examen fisico", $registro['subject_id']);
			$this->examen_fisico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_fisico');
			$this->Model_Examen_fisico->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de examen fisico", $registro['subject_id']);
			/*Actualizar estado en el sujeto*/
			if($registro['etapa'] == 1){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_1_status'=>'Form Approved and Locked'));
			}
			elseif($registro['etapa'] == 2){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_2_status'=>'Form Approved and Locked'));
			}
			elseif($registro['etapa'] == 3){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_3_status'=>'Form Approved and Locked'));
			}
			elseif($registro['etapa'] == 4){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_4_status'=>'Form Approved and Locked'));
			}
			elseif($registro['etapa'] == 5){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_5_status'=>'Form Approved and Locked'));
			}
			elseif($registro['etapa'] == 6){
				$this->Model_Subject->update(array('id'=>$registro['subject_id'],'examen_fisico_6_status'=>'Form Approved and Locked'));
			}

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
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');

			/*Salvamos la lista de no respetados*/
			$numeros = $registro['numero'];
			$comentarios = $registro['comentario'];
			$tipos = $registro['tipo'];

			unset($registro['numero']);
			unset($registro['comentario']);
			unset($registro['tipo']);

			$this->load->model('Model_Inclusion_exclusion');
			$this->Model_Inclusion_exclusion->insert($registro);

			$nueva_id = $this->db->insert_id();

			/*Ingresamos la lista de no respetados*/
			$cant = count($numeros);

			for($i=0; $i<$cant; $i++){

				if($numeros[$i] != '' AND $comentarios[$i] != '' AND $tipos[$i] != ''){
					$save['inclusion_exclusion_id'] = $nueva_id;
					$save['numero_criterio'] = $numeros[$i];
					$save['comentario'] = $comentarios[$i];
					$save['comentario'] = $tipos[$i];
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
     		redirect('subject/grid/'.$registro['subject_id']);

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
			$this->inclusion_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			

			/*Salvamos la lista de no respetados*/
			if(isset($registro['numero'])){
				$numeros = $registro['numero'];
				unset($registro['numero']);
			}

			if(isset($registro['comentario'])){
				$comentarios = $registro['comentario'];
				unset($registro['comentario']);
			}						

			if(isset($registro['inclusion_ids'])){
				$inclusion_ids = $registro['inclusion_ids'];
				unset($registro['inclusion_ids']);
			}

			if(isset($registro['tipo'])){
				$tipos = $registro['tipo'];
				unset($registro['tipo']);
			}

			if(
				isset($registro['realizado']) AND $registro['realizado'] == 1
				AND
				(empty($registro['fecha']) )
			){
				$estado = 'Error';
			}
			else{

				$estado = "Record Complete";
			}



			/*Separar los datos de inclusion con los de no respetados*/

			if($registro['etapa'] == 1){				
				$subjet_['inclusion_exclusion_1_status'] = $estado;
			}
			elseif($registro['etapa'] == 2){
				$subjet_['inclusion_exclusion_2_status'] = $estado;
			}

			$registro['status'] = $estado;
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');

			$this->load->model('Model_Inclusion_exclusion');
			$this->Model_Inclusion_exclusion->update($registro);

			/*Ingresamos la lista de no respetados*/
			$cant = count($numeros);

			for($i=0; $i<$cant; $i++){

				if($numeros[$i] != '' AND $comentarios[$i] != '' AND $tipos[$i] != '' AND isset($inclusion_ids[$i]) AND !empty($inclusion_ids[$i])){
					
					$save['id'] = $inclusion_ids[$i];					
					$save['inclusion_exclusion_id'] = $registro['id'];
					$save['numero_criterio'] = $numeros[$i];
					$save['comentario'] = $comentarios[$i];					
					$save['tipo'] = $tipo[$i];
					
					$save['updated_at'] = date("Y-m-d H:i:s");
					

					$this->load->model("Model_Inclusion_exclusion_no_respetados");
					$this->Model_Inclusion_exclusion_no_respetados->update($save);
				}
				elseif ($numeros[$i] != '' AND $comentarios[$i] != '' AND $tipos[$i] != '') {
					
					$save['inclusion_exclusion_id'] = $registro['id'];
					$save['numero_criterio'] = $numeros[$i];
					$save['comentario'] = $comentarios[$i];					
					$save['tipo'] = $tipos[$i];
					$save['updated_at'] = date("Y-m-d H:i:s");
					$save['created_at'] = date("Y-m-d H:i:s");
					$save['usuario_creacion'] = $this->session->userdata('usuario');
					

					$this->load->model("Model_Inclusion_exclusion_no_respetados");
					$this->Model_Inclusion_exclusion_no_respetados->insert($save);	
				}
			}

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Critero de inclusión exclusión actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);
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
		$data['de_0a9'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9');

		$this->load->view('template', $data);
	}

	public function digito_directo_insert(){
		
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');				

		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');
		$this->form_validation->set_rules('fecha', 'Fecha', 'xss_clean');
		
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
			$this->form_validation->set_rules('puntaje_item_2a', 'Puntaje Item 2', 'xss_clean');			
			$this->form_validation->set_rules('puntaje_item_3a', 'Puntaje Item 3', 'xss_clean');			
			$this->form_validation->set_rules('puntaje_item_4a', 'Puntaje Item 4', 'xss_clean');			
			$this->form_validation->set_rules('puntaje_item_5a', 'Puntaje Item 5', 'xss_clean');			
			$this->form_validation->set_rules('puntaje_item_6a', 'Puntaje Item 6', 'xss_clean');			
			$this->form_validation->set_rules('puntaje_item_7a', 'Puntaje Item 7', 'xss_clean');			
			$this->form_validation->set_rules('puntaje_item_8a', 'Puntaje Item 8', 'xss_clean');			
			$this->form_validation->set_rules('msdd', '', 'xss_clean');
			$this->form_validation->set_rules('puntaje_bruto', '', 'xss_clean');


		if($this->form_validation->run() == FALSE) {

			$this->auditlib->save_audit("Tuvo errores al tratar de agregar formulario de prueba de digito directo", $registro['subject_id']);
			$this->digito_directo($registro['subject_id'], $registro['etapa']);
		}
		else {

			if(isset($registro['realizado']) AND $registro['realizado'] == 1
				AND
				(
					empty($registro['puntaje_intento_1a']) OR empty($registro['puntaje_intento_1b']) OR empty($registro['puntaje_intento_2a']) OR empty($registro['puntaje_intento_2b'])
					OR empty($registro['puntaje_intento_3a']) OR empty($registro['puntaje_intento_3b']) OR empty($registro['puntaje_intento_4a']) OR empty($registro['puntaje_intento_4b'])
					OR empty($registro['puntaje_intento_5a']) OR empty($registro['puntaje_intento_5b']) OR empty($registro['puntaje_intento_6a']) OR empty($registro['puntaje_intento_6b'])
					OR empty($registro['puntaje_intento_7a']) OR empty($registro['puntaje_intento_7b']) OR empty($registro['puntaje_intento_8a']) OR empty($registro['puntaje_intento_8b'])
					OR empty($registro['puntaje_item_1a']) OR empty($registro['puntaje_item_2a'])
					OR empty($registro['puntaje_item_3a']) OR empty($registro['puntaje_item_4a'])
					OR empty($registro['puntaje_item_5a']) OR empty($registro['puntaje_item_6a'])
					OR empty($registro['puntaje_item_7a']) OR empty($registro['puntaje_item_8a']) OR empty($registro['msdd'])
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			if($registro['etapa'] == 2){				
				$subjet_['digito_2_status'] = $estado;
			}
			elseif($registro['etapa'] == 4){
				$subjet_['digito_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['digito_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['digito_6__status'] = $estado;
			}

			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos Form*/
			$this->load->model('Model_Digito_directo');
			$this->Model_Digito_directo->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Prueba de digito directo agregada", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
		
	}

	public function digito_directo_show($subject_id, $etapa){
		$data['contenido'] = 'subject/digito_directo_show';
		$data['titulo'] = 'Prueba de digito directo';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;
		$data['valores_intento'] = array(''=>'','0'=>'0','1'=>'1');
		$data['valores_item'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2');
		$data['de_0a9'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9');

		/*Formulario para la etapa y sujeto correspondiente*/
		$this->load->model('Model_Digito_directo');
		$data['list'] = $this->Model_Digito_directo->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));		

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"digito_directo", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}
		
		$this->load->view('template', $data);					
	}

	public function digito_directo_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');				

		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');
		$this->form_validation->set_rules('fecha', 'Fecha', 'xss_clean');

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
			$this->form_validation->set_rules('puntaje_item_2a', 'Puntaje Item 2', 'xss_clean');			
			$this->form_validation->set_rules('puntaje_item_3a', 'Puntaje Item 3', 'xss_clean');			
			$this->form_validation->set_rules('puntaje_item_4a', 'Puntaje Item 4', 'xss_clean');			
			$this->form_validation->set_rules('puntaje_item_5a', 'Puntaje Item 5', 'xss_clean');			
			$this->form_validation->set_rules('puntaje_item_6a', 'Puntaje Item 6', 'xss_clean');			
			$this->form_validation->set_rules('puntaje_item_7a', 'Puntaje Item 7', 'xss_clean');			
			$this->form_validation->set_rules('puntaje_item_8a', 'Puntaje Item 8', 'xss_clean');
			$this->form_validation->set_rules('msdd', '', 'xss_clean');
			$this->form_validation->set_rules('puntaje_bruto', '', 'xss_clean');


		if($this->form_validation->run() == FALSE) {

			$this->auditlib->save_audit("Tuvo errores al tratar de actualizar formulario de prueba de digito directo", $registro['subject_id']);
			$this->digito_directo_show($registro['subject_id'], $registro['etapa']);
		}
		else {			
			if(isset($registro['realizado']) AND $registro['realizado'] == 1
				AND
				(
					empty($registro['puntaje_intento_1a']) OR empty($registro['puntaje_intento_1b']) OR empty($registro['puntaje_intento_2a']) OR empty($registro['puntaje_intento_2b'])
					OR empty($registro['puntaje_intento_3a']) OR empty($registro['puntaje_intento_3b']) OR empty($registro['puntaje_intento_4a']) OR empty($registro['puntaje_intento_4b'])
					OR empty($registro['puntaje_intento_5a']) OR empty($registro['puntaje_intento_5b']) OR empty($registro['puntaje_intento_6a']) OR empty($registro['puntaje_intento_6b'])
					OR empty($registro['puntaje_intento_7a']) OR empty($registro['puntaje_intento_7b']) OR empty($registro['puntaje_intento_8a']) OR empty($registro['puntaje_intento_8b'])
					OR empty($registro['puntaje_item_1a']) OR empty($registro['puntaje_item_2a'])
					OR empty($registro['puntaje_item_3a']) OR empty($registro['puntaje_item_4a'])
					OR empty($registro['puntaje_item_5a']) OR empty($registro['puntaje_item_6a'])
					OR empty($registro['puntaje_item_7a']) OR empty($registro['puntaje_item_8a']) OR empty($registro['msdd'])
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){				
				$subjet_['digito_2_status'] = $estado;
			}
			elseif($registro['etapa'] == 4){
				$subjet_['digito_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['digito_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['digito_6__status'] = $estado;
			}
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			$registro['status'] = $estado;
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos Form*/
			$this->load->model('Model_Digito_directo');
			$this->Model_Digito_directo->update($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Prueba de digito directo actualizada", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

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
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');
		$this->form_validation->set_rules('tiene_problemas_memoria', '', 'xss_clean');
		$this->form_validation->set_rules('le_puedo_hacer_preguntas', '', 'xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');		
		$this->form_validation->set_rules('en_que_ano_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_estacion_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_mes_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_dia_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_fecha_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_region_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_ano_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_estacion_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_mes_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_dia_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_fecha_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_region_estamos_puntaje', '', 'xss_clean');		
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
		$this->form_validation->set_rules('mundo_respuesta', '', 'xss_clean');	
		$this->form_validation->set_rules('mundo_puntaje', '', 'xss_clean');	
		$this->form_validation->set_rules('mostrado_que_es_1', '', 'xss_clean');	
		$this->form_validation->set_rules('mostrado_que_es_2', '', 'xss_clean');	

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar estudio MMSE", $registro['subject_id']);
			$this->mmse($registro['subject_id'], $registro['etapa']);

		}else{

			if(	isset($registro['realizado']) AND $registro['realizado'] == 1 AND $registro['fecha'] == ''

				OR (isset($registro['le_puedo_hacer_preguntas']) AND $registro['le_puedo_hacer_preguntas'] == 1
					AND (
						$registro['en_que_ano_estamos_puntaje'] == '' OR $registro['en_que_estacion_estamos_puntaje'] == '' OR $registro['en_que_mes_estamos_puntaje'] == '' 
						OR $registro['en_que_dia_estamos_puntaje'] == '' OR $registro['en_que_fecha_estamos_puntaje'] == '' OR $registro['en_que_region_estamos_puntaje'] == ''
						OR $registro['en_que_ano_estamos'] == '' OR $registro['en_que_estacion_estamos'] == '' OR $registro['en_que_mes_estamos'] == ''
						OR $registro['en_que_dia_estamos'] == '' OR $registro['en_que_fecha_estamos'] == '' OR $registro['en_que_region_estamos'] == ''						
						OR $registro['comuna_estamos'] == '' OR $registro['comuna_estamos_puntaje'] == '' OR $registro['barrio_estamos'] == ''
						OR $registro['barrio_estamos_puntaje'] == '' OR $registro['edificio_estamos'] == '' OR $registro['edificio_estamos_puntaje'] == '' OR $registro['manzana'] == '' 
						OR $registro['manzana_puntaje'] == '' OR $registro['peso'] == '' OR $registro['peso_puntaje'] == '' OR $registro['mesa'] == '' 
						OR $registro['mesa_puntaje'] == '' OR $registro['cuanto_93'] == '' OR $registro['cuanto_93_puntaje'] == '' OR $registro['cuanto_86'] == ''
						OR $registro['cuanto_86_puntaje'] == '' OR $registro['cuanto_79'] == '' OR $registro['cuanto_79_puntaje'] == '' OR $registro['cuanto_72'] == ''
						OR $registro['cuanto_72_puntaje'] == '' OR $registro['cuanto_65'] == '' OR $registro['cuanto_65_puntaje'] == '' OR $registro['manzana_2'] == ''
						OR $registro['manzana_2_puntaje'] == '' OR $registro['peso_2'] == '' OR $registro['peso_2_puntaje'] == '' OR $registro['mesa_2']  == ''
						OR $registro['mesa_2_puntaje'] == ''						
						
						OR ($registro['mostrado_que_es_1'] != '' AND (empty($registro['que_es_1']) OR empty($registro['que_es_1_puntaje'])))
						OR ($registro['mostrado_que_es_2'] != '' AND (empty($registro['que_es_2']) OR empty($registro['que_es_2_puntaje'])))
						OR ( empty($registro['mostrado_que_es_1']) AND empty($registro['mostrado_que_es_2']))

						OR empty($registro['no_si_cuando_porque']) OR $registro['no_si_cuando_porque_puntaje'] == '' OR $registro['tomar_con_la_mano_derecha'] == '' 
						OR $registro['tomar_con_la_mano_derecha_puntaje'] == '' OR empty($registro['doblar_por_la_mitad']) OR $registro['doblar_por_la_mitad_puntaje'] == '' 
						OR empty($registro['poner_en_el_piso']) OR $registro['poner_en_el_piso_puntaje'] == '' OR empty($registro['cierre_los_ojos']) 
						OR $registro['cierre_los_ojos_puntaje'] == '' OR $registro['dibujo_puntaje'] == '' OR $registro['escritura_puntaje'] == '' 
						OR $registro['puntaje_total'] == ''	OR empty($registro['mundo_respuesta']) OR $registro['mundo_puntaje'] == ''
					)
				)

			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}						
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			

			if(!isset($registro['le_puedo_hacer_preguntas']) OR empty($registro['le_puedo_hacer_preguntas'])){
				$registro['le_puedo_hacer_preguntas'] = 0;
			}

			if(!isset($registro['tiene_problemas_memoria']) OR empty($registro['tiene_problemas_memoria'])){
				$registro['tiene_problemas_memoria'] = 0;
			}

			if($registro['etapa'] == 1){				
				$subjet_['mmse_1_status'] = $estado;
			}
			elseif($registro['etapa'] == 4){
				$subjet_['mmse_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['mmse_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['mmse_6_status'] = $estado;
			}

			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Mmse');
			$this->Model_Mmse->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("MMSE agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}

	}

	public function mmse_show($subject_id, $etapa){
		$data['contenido'] = 'subject/mmse_show';
		$data['titulo'] = 'MMSE';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;
		
		$this->load->model('Model_Mmse');
		$data['list'] = $this->Model_Mmse->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"mmse", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$data['puntaje'] = array(''=>'','0'=>'0','1'=>'1');

		$this->load->view('template',$data);

	}

	public function mmse_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');
		$this->form_validation->set_rules('tiene_problemas_memoria', '', 'xss_clean');
		$this->form_validation->set_rules('le_puedo_hacer_preguntas', '', 'xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_ano_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_estacion_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_mes_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_dia_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_fecha_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_region_estamos', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_ano_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_estacion_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_mes_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_dia_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_fecha_estamos_puntaje', '', 'xss_clean');
		$this->form_validation->set_rules('en_que_region_estamos_puntaje', '', 'xss_clean');		
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
		$this->form_validation->set_rules('mundo_respuesta', '', 'xss_clean');	
		$this->form_validation->set_rules('mundo_puntaje', '', 'xss_clean');	
		$this->form_validation->set_rules('mostrado_que_es_1', '', 'xss_clean');	
		$this->form_validation->set_rules('mostrado_que_es_2', '', 'xss_clean');	

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar el estudio MMSE", $registro['subject_id']);
			$this->mmse_show($registro['subject_id'], $registro['etapa']);

		}else{

			if(	isset($registro['realizado']) AND $registro['realizado'] == 1 AND $registro['fecha'] == ''

				OR (isset($registro['le_puedo_hacer_preguntas']) AND $registro['le_puedo_hacer_preguntas'] == 1
					AND (
						$registro['en_que_ano_estamos_puntaje'] == '' OR $registro['en_que_estacion_estamos_puntaje'] == '' OR $registro['en_que_mes_estamos_puntaje'] == '' 
						OR $registro['en_que_dia_estamos_puntaje'] == '' OR $registro['en_que_fecha_estamos_puntaje'] == '' OR $registro['en_que_region_estamos_puntaje'] == ''
						OR $registro['en_que_ano_estamos'] == '' OR $registro['en_que_estacion_estamos'] == '' OR $registro['en_que_mes_estamos'] == ''
						OR $registro['en_que_dia_estamos'] == '' OR $registro['en_que_fecha_estamos'] == '' OR $registro['en_que_region_estamos'] == ''						
						OR $registro['comuna_estamos'] == '' OR $registro['comuna_estamos_puntaje'] == '' OR $registro['barrio_estamos'] == ''
						OR $registro['barrio_estamos_puntaje'] == '' OR $registro['edificio_estamos'] == '' OR $registro['edificio_estamos_puntaje'] == '' OR $registro['manzana'] == '' 
						OR $registro['manzana_puntaje'] == '' OR $registro['peso'] == '' OR $registro['peso_puntaje'] == '' OR $registro['mesa'] == '' 
						OR $registro['mesa_puntaje'] == '' OR $registro['cuanto_93'] == '' OR $registro['cuanto_93_puntaje'] == '' OR $registro['cuanto_86'] == ''
						OR $registro['cuanto_86_puntaje'] == '' OR $registro['cuanto_79'] == '' OR $registro['cuanto_79_puntaje'] == '' OR $registro['cuanto_72'] == ''
						OR $registro['cuanto_72_puntaje'] == '' OR $registro['cuanto_65'] == '' OR $registro['cuanto_65_puntaje'] == '' OR $registro['manzana_2'] == ''
						OR $registro['manzana_2_puntaje'] == '' OR $registro['peso_2'] == '' OR $registro['peso_2_puntaje'] == '' OR $registro['mesa_2']  == ''
						OR $registro['mesa_2_puntaje'] == ''						
						
						OR ($registro['mostrado_que_es_1'] != '' AND (empty($registro['que_es_1']) OR empty($registro['que_es_1_puntaje'])))
						OR ($registro['mostrado_que_es_2'] != '' AND (empty($registro['que_es_2']) OR empty($registro['que_es_2_puntaje'])))
						OR ( empty($registro['mostrado_que_es_1']) AND empty($registro['mostrado_que_es_2']))

						OR empty($registro['no_si_cuando_porque']) OR $registro['no_si_cuando_porque_puntaje'] == '' OR $registro['tomar_con_la_mano_derecha'] == '' 
						OR $registro['tomar_con_la_mano_derecha_puntaje'] == '' OR empty($registro['doblar_por_la_mitad']) OR $registro['doblar_por_la_mitad_puntaje'] == '' 
						OR empty($registro['poner_en_el_piso']) OR $registro['poner_en_el_piso_puntaje'] == '' OR empty($registro['cierre_los_ojos']) 
						OR $registro['cierre_los_ojos_puntaje'] == '' OR $registro['dibujo_puntaje'] == '' OR $registro['escritura_puntaje'] == '' 
						OR $registro['puntaje_total'] == ''	OR empty($registro['mundo_respuesta']) OR $registro['mundo_puntaje'] == ''
					)
				)

			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}	
			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			$registro['status'] = $estado;

			if(!isset($registro['le_puedo_hacer_preguntas']) OR empty($registro['le_puedo_hacer_preguntas'])){
				$registro['le_puedo_hacer_preguntas'] = 0;
			}

			if(!isset($registro['tiene_problemas_memoria']) OR empty($registro['tiene_problemas_memoria'])){
				$registro['tiene_problemas_memoria'] = 0;
			}
			
			if($registro['etapa'] == 1){				
				$subjet_['mmse_1_status'] = $estado;
			}
			elseif($registro['etapa'] == 4){
				$subjet_['mmse_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['mmse_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['mmse_6_status'] = $estado;
			}
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Mmse');
			$this->Model_Mmse->update($registro);	

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);		

			$this->auditlib->save_audit("MMSE actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

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
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

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
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar estudio ECG", $registro['subject_id']);
			$this->ecg($registro['subject_id']);

		}else{

			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				(
					empty($registro['fecha']) 
					OR empty($registro['ritmo_sinusal']) OR $registro['ritmo_sinusal_normal_anormal'] == ''
					OR empty($registro['fc']) OR !isset($registro['fc_normal_anormal']) OR (isset($registro['fc_normal_anormal']) AND $registro['fc_normal_anormal']  == '')
					OR empty($registro['pr']) OR !isset($registro['pr_normal_anormal']) OR (isset($registro['pr_normal_anormal']) AND $registro['pr_normal_anormal'] == '' )
					OR empty($registro['qrs']) OR !isset($registro['qrs_normal_anormal']) OR (isset($registro['qrs_normal_anormal']) AND $registro['qrs_normal_anormal'] == '') 
					OR empty($registro['qt']) OR !isset($registro['qt_normal_anormal']) OR (isset($registro['qt_normal_anormal']) AND $registro['qt_normal_anormal'] == '') 
					OR empty($registro['qtc']) OR !isset($registro['qtc_normal_anormal']) OR (isset($registro['qtc_normal_anormal']) AND $registro['qtc_normal_anormal'] == '')
					OR empty($registro['qrs2']) OR !isset($registro['qrs2_normal_anormal']) OR (isset($registro['qrs2_normal_anormal']) AND $registro['qrs2_normal_anormal'] == '' )
					OR !isset($registro['interpretacion_ecg']) OR (isset($registro['interpretacion_ecg']) AND $registro['interpretacion_ecg'] == '')
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Electrocardiograma_de_reposo');
			$this->Model_Electrocardiograma_de_reposo->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$subjet_['ecg_status'] = $estado;
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("ECG agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function ecg_show($subject_id){
		$data['contenido'] = 'subject/ecg_show';
		$data['titulo'] = 'ECG';
		$data['subject'] = $this->Model_Subject->find($subject_id);						
		
		$this->load->model('Model_Electrocardiograma_de_reposo');
		$data['list'] = $this->Model_Electrocardiograma_de_reposo->allWhereArray(array('subject_id'=>$subject_id));

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"ecg", "etapa"=>0, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->view('template',$data);
	}

	public function ecg_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');
	
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
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar estudio ECG", $registro['subject_id']);
			$this->ecg_show($registro['subject_id']);

		}else{
			
			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				(
					empty($registro['fecha']) 
					OR empty($registro['ritmo_sinusal']) OR $registro['ritmo_sinusal_normal_anormal'] == ''
					OR empty($registro['fc']) OR !isset($registro['fc_normal_anormal']) OR (isset($registro['fc_normal_anormal']) AND $registro['fc_normal_anormal']  == '')
					OR empty($registro['pr']) OR !isset($registro['pr_normal_anormal']) OR (isset($registro['pr_normal_anormal']) AND $registro['pr_normal_anormal'] == '' )
					OR empty($registro['qrs']) OR !isset($registro['qrs_normal_anormal']) OR (isset($registro['qrs_normal_anormal']) AND $registro['qrs_normal_anormal'] == '') 
					OR empty($registro['qt']) OR !isset($registro['qt_normal_anormal']) OR (isset($registro['qt_normal_anormal']) AND $registro['qt_normal_anormal'] == '') 
					OR empty($registro['qtc']) OR !isset($registro['qtc_normal_anormal']) OR (isset($registro['qtc_normal_anormal']) AND $registro['qtc_normal_anormal'] == '')
					OR empty($registro['qrs2']) OR !isset($registro['qrs2_normal_anormal']) OR (isset($registro['qrs2_normal_anormal']) AND $registro['qrs2_normal_anormal'] == '' )
					OR !isset($registro['interpretacion_ecg']) OR (isset($registro['interpretacion_ecg']) AND $registro['interpretacion_ecg'] == '')
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			$registro['status'] = $estado;
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Electrocardiograma_de_reposo');
			$this->Model_Electrocardiograma_de_reposo->update($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$subjet_['ecg_status'] = $estado;
			$this->Model_Subject->update($subjet_);
			
			$this->auditlib->save_audit("ECG actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

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
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

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
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');
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

			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				(
					empty($registro['fecha']) OR (empty($registro['estatura']) AND $registro['etapa'] == 1) OR empty($registro['presion_sistolica']) 
					OR empty($registro['presion_diastolica']) OR empty($registro['frecuencia_cardiaca']) OR empty($registro['frecuencia_respiratoria']) 
					OR empty($registro['temperatura']) OR empty($registro['peso'])
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			if($registro['etapa'] == 1){				
				$subjet_['signos_vitales_1_status'] = $estado;
			}
			elseif($registro['etapa'] == 2){
				$subjet_['signos_vitales_2_status'] = $estado;
			}
			elseif($registro['etapa'] == 4){
				$subjet_['signos_vitales_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['signos_vitales_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['signos_vitales_6_status'] = $estado;
			}

		

			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Signos_vitales');
			$this->Model_Signos_vitales->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Signos vitales agregados", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function signos_vitales_show($subject_id, $etapa){
		$data['contenido'] = 'subject/signos_vitales_show';
		$data['titulo'] = 'Signos Vitales';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->model('Model_Signos_vitales');
		$data['list'] = $this->Model_Signos_vitales->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		/*querys abiertos para el formulario*/
		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"signos_vitales", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->view('template',$data);
	}

	public function signos_vitales_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');
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
			$this->signos_vitales_show($registro['subject_id'], $registro['etapa']);

		}else{

			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				(
					empty($registro['fecha']) OR (empty($registro['estatura']) AND $registro['etapa'] == 1) OR empty($registro['presion_sistolica']) 
					OR empty($registro['presion_diastolica']) OR empty($registro['frecuencia_cardiaca']) OR empty($registro['frecuencia_respiratoria']) 
					OR empty($registro['temperatura']) OR empty($registro['peso'])
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			$registro['status'] = $estado;

			
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Signos_vitales');
			$this->Model_Signos_vitales->update($registro);		

			if($registro['etapa'] == 1){				
				$subjet_['signos_vitales_1_status'] = $estado;
			}
			elseif($registro['etapa'] == 2){
				$subjet_['signos_vitales_2_status'] = $estado;
			}
			elseif($registro['etapa'] == 4){
				$subjet_['signos_vitales_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['signos_vitales_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['signos_vitales_6_status'] = $estado;
			}

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Signos vitales actualizados", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

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
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

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
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

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
		
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('comprimidos_entregados', '', 'xss_clean');
		$this->form_validation->set_rules('comprimidos_utilizados', '', 'xss_clean');
		$this->form_validation->set_rules('comprimidos_devueltos', '', 'xss_clean');
		$this->form_validation->set_rules('se_perdio_algun_comprimido', '', 'xss_clean');
		$this->form_validation->set_rules('comprimidos_perdidos', '', 'xss_clean');
		$this->form_validation->set_rules('dias', '', 'xss_clean');
		$this->form_validation->set_rules('porcentaje_cumplimiento', '', 'xss_clean');		
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar cumplimiento", $registro['subject_id']);
			$this->cumplimiento($registro['subject_id'], $registro['etapa']);

		}else{

			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				(
					empty($registro['fecha']) OR empty($registro['comprimidos_entregados']) OR empty($registro['comprimidos_utilizados']) OR					
					empty($registro['se_perdio_algun_comprimido']) OR empty($registro['comprimidos_perdidos']) OR empty($registro['dias']) OR
					empty($registro['porcentaje_cumplimiento'])
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			if($registro['etapa'] == 2){				
				$subjet_['cumplimiento_2_status'] = $estado;
			}
			elseif($registro['etapa'] == 3){
				$subjet_['cumplimiento_3_status'] = $estado;
			}
			elseif($registro['etapa'] == 4){
				$subjet_['cumplimiento_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['cumplimiento_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['cumplimiento_6_status'] = $estado;
			}

			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Cumplimiento');
			$this->Model_Cumplimiento->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Cumplimiento agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function cumplimiento_show($subject_id, $etapa){
		$data['contenido'] = 'subject/cumplimiento_show';
		$data['titulo'] = 'Cumplimiento';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->model('Model_Cumplimiento');
		$data['list'] = $this->Model_Cumplimiento->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"cumplimiento", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->view('template',$data);
	}

	public function cumplimiento_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');		
		
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('comprimidos_entregados', '', 'xss_clean');
		$this->form_validation->set_rules('comprimidos_utilizados', '', 'xss_clean');
		$this->form_validation->set_rules('comprimidos_devueltos', '', 'xss_clean');
		$this->form_validation->set_rules('se_perdio_algun_comprimido', '', 'xss_clean');
		$this->form_validation->set_rules('comprimidos_perdidos', '', 'xss_clean');
		$this->form_validation->set_rules('dias', '', 'xss_clean');
		$this->form_validation->set_rules('porcentaje_cumplimiento', '', 'xss_clean');		
		
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar cumplimiento", $registro['subject_id']);
			$this->cumplimiento_show($registro['subject_id'], $registro['etapa']);

		}else{

			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				(
					empty($registro['fecha']) OR empty($registro['comprimidos_entregados']) OR empty($registro['comprimidos_utilizados']) OR					
					empty($registro['se_perdio_algun_comprimido']) OR empty($registro['comprimidos_perdidos']) OR empty($registro['dias']) OR
					empty($registro['porcentaje_cumplimiento'])
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			$registro['status'] = $estado;
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Cumplimiento');
			$this->Model_Cumplimiento->update($registro);

			if($registro['etapa'] == 2){				
				$subjet_['cumplimiento_2_status'] = $estado;
			}
			elseif($registro['etapa'] == 3){
				$subjet_['cumplimiento_3_status'] = $estado;
			}
			elseif($registro['etapa'] == 4){
				$subjet_['cumplimiento_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['cumplimiento_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['cumplimiento_6_status'] = $estado;
			}

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Cumplimiento actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

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
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

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
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

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
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			if(!empty($registro['fecha_visita'])){
				$registro['fecha_visita'] = $this->convertirFecha($registro['fecha_visita']);
			}
			if(!empty($registro['fecha_ultima_dosis'])){
				$registro['fecha_ultima_dosis'] = $this->convertirFecha($registro['fecha_ultima_dosis']);
			}
			
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Fin_de_tratamiento');
			$this->Model_Fin_de_tratamiento->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$subjet_['fin_tratamiento_status'] = "Record Complete";
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Fin tratamiento agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function fin_tratamiento_show($subject_id){
		$data['contenido'] = 'subject/fin_tratamiento_show';
		$data['titulo'] = 'Fin Tratamiento';
		$data['subject'] = $this->Model_Subject->find($subject_id);				

		$this->load->model('Model_Fin_de_tratamiento');
		$data['list'] = $this->Model_Fin_de_tratamiento->allWhereArray(array('subject_id'=>$subject_id));

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"fin_tratamiento", "etapa"=>0, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

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
			$this->fin_tratamiento_show($registro['subject_id']);

		}else{
			if(!empty($registro['fecha_visita'])){
				$registro['fecha_visita'] = $this->convertirFecha($registro['fecha_visita']);
			}
			if(!empty($registro['fecha_ultima_dosis'])){
				$registro['fecha_ultima_dosis'] = $this->convertirFecha($registro['fecha_ultima_dosis']);
			}
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Fin_de_tratamiento');
			$this->Model_Fin_de_tratamiento->update($registro);

			$this->auditlib->save_audit("Fin tratamiento actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

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
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

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
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

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
			if(!empty($registro['fecha_visita'])){
				$registro['fecha_visita'] = $this->convertirFecha($registro['fecha_visita']);
			}
			if(!empty($registro['fecha_ultima_dosis'])){
				$registro['fecha_ultima_dosis'] = $this->convertirFecha($registro['fecha_ultima_dosis']);
			}
			$registro['status'] = "Record Complete";
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Fin_de_tratamiento_temprano');
			$this->Model_Fin_de_tratamiento_temprano->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$subjet_['fin_tratamiento_temprano_status'] = "Record Complete";
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Fin tratamiento temprano agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function fin_tratamiento_temprano_show($subject_id){
		$data['contenido'] = 'subject/fin_tratamiento_temprano_show';
		$data['titulo'] = 'Fin Tratamiento Temprano';
		$data['subject'] = $this->Model_Subject->find($subject_id);

		$this->load->model('Model_Fin_de_tratamiento_temprano');
		$data['list'] = $this->Model_Fin_de_tratamiento_temprano->allWhereArray(array('subject_id'=>$subject_id));

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"fin_tratamiento_temprano", "etapa"=>0, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

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
			$this->fin_tratamiento_temprano_show($registro['subject_id']);

		}else{
			if(!empty($registro['fecha_visita'])){
				$registro['fecha_visita'] = $this->convertirFecha($registro['fecha_visita']);
			}
			if(!empty($registro['fecha_ultima_dosis'])){
				$registro['fecha_ultima_dosis'] = $this->convertirFecha($registro['fecha_ultima_dosis']);
			}
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Fin_de_tratamiento_temprano');
			$this->Model_Fin_de_tratamiento_temprano->update($registro);
			
			$this->auditlib->save_audit("Fin tratamiento temprano actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

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
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

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
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

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
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar muestra de sangre", $registro['subject_id']);
			$this->muestra_de_sangre($registro['subject_id'], $registro['etapa']);

		}else{

			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				empty($registro['fecha'])
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 1){				
				$subjet_['muestra_de_sangre_1_status'] = $estado;
			}			
			elseif($registro['etapa'] == 5){
				$subjet_['muestra_de_sangre_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['muestra_de_sangre_6_status'] = $estado;
			}
			
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Muestra_de_sangre');
			$this->Model_Muestra_de_sangre->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Muestra de sangre agregada", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function muestra_de_sangre_show($subject_id, $etapa){
		$data['contenido'] = 'subject/muestra_de_sangre_show';
		$data['titulo'] = 'Muestra de Sangre';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;

		$this->load->model('Model_Muestra_de_sangre');
		$data['list'] = $this->Model_Muestra_de_sangre->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));		

		/*querys abiertos para el formulario*/
		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"muestra_de_sangre", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}
		
		$this->load->view('template',$data);
	}

	public function muestra_de_sangre_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar muestra de sangre", $registro['subject_id']);
			$this->muestra_de_sangre_show($registro['subject_id'], $registro['etapa']);

		}else{

			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				empty($registro['fecha'])
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 1){				
				$subjet_['muestra_de_sangre_1_status'] = $estado;
			}			
			elseif($registro['etapa'] == 5){
				$subjet_['muestra_de_sangre_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['muestra_de_sangre_6_status'] = $estado;
			}

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			$registro['status'] = $estado;			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Muestra_de_sangre');
			$this->Model_Muestra_de_sangre->update($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Muestra de sangre actualizada", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

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
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

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
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

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
		$this->form_validation->set_rules('examen_sensitivo_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('examen_sensitivo', '', 'xss_clean');
		$this->form_validation->set_rules('reflejos_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('reflejos', '', 'xss_clean');
		$this->form_validation->set_rules('funcion_cerebelosa_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('funcion_cerebelosa', '', 'xss_clean');
		$this->form_validation->set_rules('marcha_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('marcha', '', 'xss_clean');
		$this->form_validation->set_rules('fuerza_muscular_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('fuerza_muscular', '', 'xss_clean');
		$this->form_validation->set_rules('tono_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('tono', '', 'xss_clean');
		$this->form_validation->set_rules('mov_anormales_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('mov_anormales', '', 'xss_clean');
		$this->form_validation->set_rules('coordinacion_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('coordinacion', '', 'xss_clean');
		$this->form_validation->set_rules('postura_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('postura', '', 'xss_clean');		
		$this->form_validation->set_rules('motora_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('motora', '', 'xss_clean');
		$this->form_validation->set_rules('tuvo_cambios', '', 'xss_clean');
		$this->form_validation->set_rules('cambios_observaciones', '', 'xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar examen neurologico", $registro['subject_id']);
			$this->examen_neurologico($registro['subject_id'], $registro['etapa']);

		}else{

			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				(
					($registro['etapa'] == 1 OR $registro['etapa'] == 5 OR $registro['etapa'] == 6 )
					AND
					(
						empty($registro['fecha']) 
						OR $registro['nervios_craneanos_normal_anormal'] == ''
						OR $registro['examen_sensitivo_normal_anormal'] == ''
						OR $registro['reflejos_normal_anormal'] == ''
						OR $registro['funcion_cerebelosa_normal_anormal'] == ''
						OR $registro['marcha_normal_anormal'] == ''
						OR $registro['fuerza_muscular_normal_anormal'] == ''
						OR $registro['tono_normal_anormal'] == ''
						OR $registro['mov_anormales_normal_anormal'] == ''
						OR $registro['coordinacion_normal_anormal'] == ''
						OR $registro['postura_normal_anormal'] == ''
						OR $registro['motora_normal_anormal'] == ''
					)
					OR
					$registro['etapa'] != 1 AND  $registro['etapa'] != 5 AND $registro['etapa'] != 6 AND 
					(
						empty($registro['fecha']) 
						OR $registro['nervios_craneanos_normal_anormal']  == ''
						OR $registro['motora_normal_anormal'] == ''
						OR $registro['reflejos_normal_anormal']  == ''
						OR $registro['examen_sensitivo_normal_anormal']  == ''
						OR $registro['marcha_normal_anormal'] == ''
						OR $registro['postura_normal_anormal'] == ''
					)
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 1){				
				$subjet_['examen_neurologico_1_status'] = $estado;
			}
			elseif($registro['etapa'] == 2){
				$subjet_['examen_neurologico_2_status'] = $estado;
			}
			elseif($registro['etapa'] == 3){
				$subjet_['examen_neurologico_3_status'] = $estado;
			}
			elseif($registro['etapa'] == 4){
				$subjet_['examen_neurologico_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['examen_neurologico_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['examen_neurologico_6_status'] = $estado;
			}

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}

			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Examen_neurologico');
			$this->Model_Examen_neurologico->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen Neurologico agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}

	}

	public function examen_neurologico_show($subject_id, $etapa){
		$data['contenido'] = 'subject/examen_neurologico_show';
		$data['titulo'] = 'Examen Neurologico';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->model('Model_Examen_neurologico');
		$data['list'] = $this->Model_Examen_neurologico->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"examen_neurologico", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

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
		$this->form_validation->set_rules('examen_sensitivo_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('examen_sensitivo', '', 'xss_clean');
		$this->form_validation->set_rules('reflejos_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('reflejos', '', 'xss_clean');
		$this->form_validation->set_rules('funcion_cerebelosa_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('funcion_cerebelosa', '', 'xss_clean');
		$this->form_validation->set_rules('marcha_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('marcha', '', 'xss_clean');		
		$this->form_validation->set_rules('fuerza_muscular_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('fuerza_muscular', '', 'xss_clean');
		$this->form_validation->set_rules('tono_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('tono', '', 'xss_clean');
		$this->form_validation->set_rules('mov_anormales_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('mov_anormales', '', 'xss_clean');
		$this->form_validation->set_rules('coordinacion_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('coordinacion', '', 'xss_clean');
		$this->form_validation->set_rules('postura_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('postura', '', 'xss_clean');
		$this->form_validation->set_rules('motora_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('motora', '', 'xss_clean');
		$this->form_validation->set_rules('tuvo_cambios', '', 'xss_clean');
		$this->form_validation->set_rules('cambios_observaciones', '', 'xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar el examen neurologico", $registro['subject_id']);
			$this->examen_neurologico_show($registro['subject_id'], $registro['etapa']);

		}else{
			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				(
					($registro['etapa'] == 1 OR $registro['etapa'] == 5 OR $registro['etapa'] == 6 )
					AND
					(
						empty($registro['fecha']) 
						OR $registro['nervios_craneanos_normal_anormal'] == ''
						OR $registro['examen_sensitivo_normal_anormal'] == ''
						OR $registro['reflejos_normal_anormal'] == ''
						OR $registro['funcion_cerebelosa_normal_anormal'] == ''
						OR $registro['marcha_normal_anormal'] == ''
						OR $registro['fuerza_muscular_normal_anormal'] == ''
						OR $registro['tono_normal_anormal'] == ''
						OR $registro['mov_anormales_normal_anormal'] == ''
						OR $registro['coordinacion_normal_anormal'] == ''
						OR $registro['postura_normal_anormal'] == ''
						OR $registro['motora_normal_anormal'] == ''
					)
					OR
					$registro['etapa'] != 1 AND  $registro['etapa'] != 5 AND $registro['etapa'] != 6 AND 
					(
						empty($registro['fecha']) 
						OR $registro['nervios_craneanos_normal_anormal']  == ''
						OR $registro['motora_normal_anormal'] == ''
						OR $registro['reflejos_normal_anormal']  == ''
						OR $registro['examen_sensitivo_normal_anormal']  == ''
						OR $registro['marcha_normal_anormal'] == ''
						OR $registro['postura_normal_anormal'] == ''
					)
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}
					

			if($registro['etapa'] == 1){				
				$subjet_['examen_neurologico_1_status'] = $estado;
			}
			elseif($registro['etapa'] == 2){
				$subjet_['examen_neurologico_2_status'] = $estado;
			}
			elseif($registro['etapa'] == 3){
				$subjet_['examen_neurologico_3_status'] = $estado;
			}
			elseif($registro['etapa'] == 4){
				$subjet_['examen_neurologico_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['examen_neurologico_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['examen_neurologico_6_status'] = $estado;
			}

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}

			$registro['status'] = $estado;
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Examen_neurologico');
			$this->Model_Examen_neurologico->update($registro);	

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);		

			$this->auditlib->save_audit("Examen Neurologico actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

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
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

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
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

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
	public function examen_laboratorio($subject_id, $etapa){
		$data['contenido'] = 'subject/examen_laboratorio';
		$data['titulo'] = 'Examen Laboratorio';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;
		$data['medidas1'] = array(''=>'','meq/L'=>'meq/L','mmol/L'=>'mmol/L');
		$data['medidas2'] = array(''=>'','mmol/l'=>'mmol/l','mg/dL'=>'mg/dL');

		$this->load->view('template2',$data);
	}

	public function examen_laboratorio_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');		
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');		
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');		
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
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
		$this->form_validation->set_rules('calcio_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('sodio_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('potasio_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('cloro_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('glucosa_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_1', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_2', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_3', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_4', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_5', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_6', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_7', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_8', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_9', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_10', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_11', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_12', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_13', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_14', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_15', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_16', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_17', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_18', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_19', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_20', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_21', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_22', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_23', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_24', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_25', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_26', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_27', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_28', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_29', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_30', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_31', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_32', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_33', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_34', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_35', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_36', '', 'xss_clean');
		$this->form_validation->set_rules('observaciones', '', 'xss_clean');
		
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar examen de laboratorio", $registro['subject_id']);
			$this->examen_laboratorio($registro['subject_id'], $registro['etapa']);

		}else{

			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				(
					empty($registro['fecha']) 
					OR ($registro['hecho_1'] == 1 AND (empty($registro['hematocrito']) OR !isset($registro['hematocrito_nom_anom']) ))
					OR ($registro['hecho_2'] == 1 AND (empty($registro['hemoglobina']) OR !isset($registro['hemoglobina_nom_anom'])  ))
					OR ($registro['hecho_3'] == 1 AND (empty($registro['eritocritos']) OR !isset($registro['eritocritos_nom_anom']) ))
					OR ($registro['hecho_4'] == 1 AND (empty($registro['leucocitos']) OR !isset($registro['leucocitos_nom_anom']) ))
					OR ($registro['hecho_5'] == 1 AND (empty($registro['neutrofilos']) OR !isset($registro['neutrofilos_nom_anom'])  ))
					OR ($registro['hecho_6'] == 1 AND (empty($registro['linfocitos']) OR !isset($registro['linfocitos_nom_anom']) ))
					OR ($registro['hecho_7'] == 1 AND (empty($registro['monocitos']) OR !isset($registro['monocitos_nom_anom'])))
					OR ($registro['hecho_8'] == 1 AND (empty($registro['eosinofilos']) OR !isset($registro['eosinofilos_nom_anom'])  ))
					OR ($registro['hecho_9'] == 1 AND (empty($registro['basofilos']) OR	!isset($registro['basofilos_nom_anom']) ))
					OR ($registro['hecho_10'] == 1 AND (empty($registro['recuento_plaquetas']) OR !isset($registro['recuento_plaquetas_nom_anom'])))
					OR ($registro['hecho_11'] == 1 AND (empty($registro['glucosa_ayunas']) OR !isset($registro['glucosa_ayunas_nom_anom']) ))
					OR ($registro['hecho_12'] == 1 AND (empty($registro['bun']) OR !isset($registro['bun_nom_anom']) ))
					OR ($registro['hecho_13'] == 1 AND (empty($registro['creatinina']) OR !isset($registro['creatinina_nom_anom'])))
					OR ($registro['hecho_14'] == 1 AND (empty($registro['bilirrubina_total']) OR	!isset($registro['bilirrubina_total_nom_anom']) ))
					OR ($registro['hecho_15'] == 1 AND (empty($registro['proteinas_totales']) OR !isset($registro['proteinas_totales_nom_anom']) ))
					OR ($registro['hecho_16'] == 1 AND (empty($registro['fosfatasas_alcalinas']) OR !isset($registro['fosfatasas_alcalinas_nom_anom'])))
					OR ($registro['hecho_17'] == 1 AND (empty($registro['ast']) OR !isset($registro['ast_nom_anom'])))
					OR ($registro['hecho_18'] == 1 AND (empty($registro['alt']) OR !isset($registro['alt_nom_anom']) ))
					OR ($registro['hecho_19'] == 1 AND (empty($registro['calcio']) OR !isset($registro['calcio_nom_anom']) OR empty($registro['calcio_unidad_medida']) ))
					OR ($registro['hecho_20'] == 1 AND (empty($registro['sodio']) OR	!isset($registro['sodio_nom_anom']) OR empty($registro['sodio_unidad_medida']) ))
					OR ($registro['hecho_21'] == 1 AND (empty($registro['potasio']) OR !isset($registro['potasio_nom_anom']) OR empty($registro['potasio_unidad_medida'])))
					OR ($registro['hecho_22'] == 1 AND (empty($registro['cloro']) OR !isset($registro['cloro_nom_anom']) OR empty($registro['cloro_unidad_medida']) ))
					OR ($registro['hecho_23'] == 1 AND (empty($registro['acido_urico']) OR !isset($registro['acido_urico_nom_anom']) ))
					OR ($registro['hecho_24'] == 1 AND (empty($registro['albumina']) OR !isset($registro['albumina_nom_anom'])))
					OR ($registro['hecho_25'] == 1 AND (empty($registro['orina_ph']) OR !isset($registro['orina_ph_nom_anom'])))
					OR ($registro['hecho_26'] == 1 AND (empty($registro['orina_glucosa']) OR	!isset($registro['orina_glucosa_nom_anom']) OR empty($registro['glucosa_unidad_medida']) ))
					OR ($registro['hecho_27'] == 1 AND (empty($registro['orina_proteinas']) OR !isset($registro['orina_proteinas_nom_anom'])))
					OR ($registro['hecho_28'] == 1 AND (empty($registro['orina_sangre']) OR !isset($registro['orina_sangre_nom_anom'])))
					OR ($registro['hecho_29'] == 1 AND (empty($registro['orina_cetonas']) OR	!isset($registro['orina_cetonas_nom_anom'])))
					OR ($registro['hecho_30'] == 1 AND (empty($registro['orina_microscospia']) OR !isset($registro['orina_microscospia_nom_anom'])))
					OR ($registro['hecho_31'] == 1 AND (empty($registro['otros_sangre_homocisteina']) OR !isset($registro['otros_sangre_homocisteina_nom_anom'])))
					OR ($registro['hecho_32'] == 1 AND (empty($registro['otros_perfil_tiroideo']) OR !isset($registro['otros_perfil_tiroideo_nom_anom'])))
					OR ($registro['hecho_33'] == 1 AND (empty($registro['otros_nivel_b12']) OR !isset($registro['otros_nivel_b12_nom_anom'])))
					OR ($registro['hecho_34'] == 1 AND (empty($registro['otros_acido_folico']) OR !isset($registro['otros_acido_folico_nom_anom'])))
					OR ($registro['hecho_35'] == 1 AND (empty($registro['otros_hba1c']) OR !isset($registro['otros_hba1c_nom_anom'])))
					OR ($registro['hecho_36'] == 1 AND (empty($registro['sifilis']) OR !isset($registro['sifilis_nom_anom']) ))					

					OR $registro['hecho_1'] == '' OR $registro['hecho_2'] == '' OR $registro['hecho_3'] == '' OR $registro['hecho_4'] == ''
					OR $registro['hecho_5'] == '' OR $registro['hecho_6'] == '' OR $registro['hecho_7'] == '' OR $registro['hecho_8'] == ''
					OR $registro['hecho_9'] == '' OR $registro['hecho_10'] == '' OR $registro['hecho_11'] == '' OR $registro['hecho_12'] == ''
					OR $registro['hecho_13'] == '' OR $registro['hecho_14'] == '' OR $registro['hecho_15'] == '' OR $registro['hecho_16'] == ''
					OR $registro['hecho_17'] == '' OR $registro['hecho_18'] == '' OR $registro['hecho_19'] == '' OR $registro['hecho_20'] == ''
					OR $registro['hecho_21'] == '' OR $registro['hecho_22'] == '' OR $registro['hecho_23'] == '' OR $registro['hecho_24'] == ''
					OR $registro['hecho_25'] == '' OR $registro['hecho_26'] == '' OR $registro['hecho_27'] == '' OR $registro['hecho_28'] == ''
					OR $registro['hecho_29'] == '' OR $registro['hecho_30'] == '' OR $registro['hecho_31'] == '' OR $registro['hecho_32'] == ''
					OR $registro['hecho_33'] == '' OR $registro['hecho_34'] == '' OR $registro['hecho_35'] == '' OR $registro['hecho_36'] == ''
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Examen_laboratorio');
			$this->Model_Examen_laboratorio->insert($registro);

			if($registro['etapa'] == 1){
				$subjet_['examen_laboratorio_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['examen_laboratorio_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['examen_laboratorio_6_status'] = $estado;
			}

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];			
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen de Laboratorio agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}

	}

	public function examen_laboratorio_show($subject_id, $etapa){
		$data['contenido'] = 'subject/examen_laboratorio_show';
		$data['titulo'] = 'Examen Laboratorio';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;
		$data['medidas1'] = array(''=>'','meq/L'=>'meq/L','mmol/L'=>'mmol/L');
		$data['medidas2'] = array(''=>'','mmol/l'=>'mmol/l','mg/dL'=>'mg/dL');

		$this->load->model('Model_Examen_laboratorio');
		$data['list'] = $this->Model_Examen_laboratorio->allWhereArray(array('subject_id'=>$subject_id));

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"examen_laboratorio", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->view('template2',$data);
	}

	public function examen_laboratorio_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');				
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');		
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
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
		$this->form_validation->set_rules('calcio_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('sodio_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('potasio_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('cloro_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('glucosa_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_1', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_2', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_3', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_4', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_5', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_6', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_7', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_8', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_9', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_10', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_11', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_12', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_13', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_14', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_15', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_16', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_17', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_18', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_19', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_20', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_21', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_22', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_23', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_24', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_25', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_26', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_27', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_28', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_29', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_30', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_31', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_32', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_33', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_34', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_35', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_36', '', 'xss_clean');
		$this->form_validation->set_rules('observaciones', '', 'xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar examen de laboratorio", $registro['subject_id']);
			$this->examen_laboratorio_show($registro['subject_id'], $registro['etapa']);

		}else{

			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				(
					empty($registro['fecha']) 
					OR ($registro['hecho_1'] == 1 AND (empty($registro['hematocrito']) OR !isset($registro['hematocrito_nom_anom']) ))
					OR ($registro['hecho_2'] == 1 AND (empty($registro['hemoglobina']) OR !isset($registro['hemoglobina_nom_anom'])  ))
					OR ($registro['hecho_3'] == 1 AND (empty($registro['eritocritos']) OR !isset($registro['eritocritos_nom_anom']) ))
					OR ($registro['hecho_4'] == 1 AND (empty($registro['leucocitos']) OR !isset($registro['leucocitos_nom_anom']) ))
					OR ($registro['hecho_5'] == 1 AND (empty($registro['neutrofilos']) OR !isset($registro['neutrofilos_nom_anom'])  ))
					OR ($registro['hecho_6'] == 1 AND (empty($registro['linfocitos']) OR !isset($registro['linfocitos_nom_anom']) ))
					OR ($registro['hecho_7'] == 1 AND (empty($registro['monocitos']) OR !isset($registro['monocitos_nom_anom'])))
					OR ($registro['hecho_8'] == 1 AND (empty($registro['eosinofilos']) OR !isset($registro['eosinofilos_nom_anom'])  ))
					OR ($registro['hecho_9'] == 1 AND (empty($registro['basofilos']) OR	!isset($registro['basofilos_nom_anom']) ))
					OR ($registro['hecho_10'] == 1 AND (empty($registro['recuento_plaquetas']) OR !isset($registro['recuento_plaquetas_nom_anom'])))
					OR ($registro['hecho_11'] == 1 AND (empty($registro['glucosa_ayunas']) OR !isset($registro['glucosa_ayunas_nom_anom']) ))
					OR ($registro['hecho_12'] == 1 AND (empty($registro['bun']) OR !isset($registro['bun_nom_anom']) ))
					OR ($registro['hecho_13'] == 1 AND (empty($registro['creatinina']) OR !isset($registro['creatinina_nom_anom'])))
					OR ($registro['hecho_14'] == 1 AND (empty($registro['bilirrubina_total']) OR	!isset($registro['bilirrubina_total_nom_anom']) ))
					OR ($registro['hecho_15'] == 1 AND (empty($registro['proteinas_totales']) OR !isset($registro['proteinas_totales_nom_anom']) ))
					OR ($registro['hecho_16'] == 1 AND (empty($registro['fosfatasas_alcalinas']) OR !isset($registro['fosfatasas_alcalinas_nom_anom'])))
					OR ($registro['hecho_17'] == 1 AND (empty($registro['ast']) OR !isset($registro['ast_nom_anom'])))
					OR ($registro['hecho_18'] == 1 AND (empty($registro['alt']) OR !isset($registro['alt_nom_anom']) ))
					OR ($registro['hecho_19'] == 1 AND (empty($registro['calcio']) OR !isset($registro['calcio_nom_anom']) OR empty($registro['calcio_unidad_medida']) ))
					OR ($registro['hecho_20'] == 1 AND (empty($registro['sodio']) OR	!isset($registro['sodio_nom_anom']) OR empty($registro['sodio_unidad_medida']) ))
					OR ($registro['hecho_21'] == 1 AND (empty($registro['potasio']) OR !isset($registro['potasio_nom_anom']) OR empty($registro['potasio_unidad_medida'])))
					OR ($registro['hecho_22'] == 1 AND (empty($registro['cloro']) OR !isset($registro['cloro_nom_anom']) OR empty($registro['cloro_unidad_medida']) ))
					OR ($registro['hecho_23'] == 1 AND (empty($registro['acido_urico']) OR !isset($registro['acido_urico_nom_anom']) ))
					OR ($registro['hecho_24'] == 1 AND (empty($registro['albumina']) OR !isset($registro['albumina_nom_anom'])))
					OR ($registro['hecho_25'] == 1 AND (empty($registro['orina_ph']) OR !isset($registro['orina_ph_nom_anom'])))
					OR ($registro['hecho_26'] == 1 AND (empty($registro['orina_glucosa']) OR	!isset($registro['orina_glucosa_nom_anom']) OR empty($registro['glucosa_unidad_medida']) ))
					OR ($registro['hecho_27'] == 1 AND (empty($registro['orina_proteinas']) OR !isset($registro['orina_proteinas_nom_anom'])))
					OR ($registro['hecho_28'] == 1 AND (empty($registro['orina_sangre']) OR !isset($registro['orina_sangre_nom_anom'])))
					OR ($registro['hecho_29'] == 1 AND (empty($registro['orina_cetonas']) OR	!isset($registro['orina_cetonas_nom_anom'])))
					OR ($registro['hecho_30'] == 1 AND (empty($registro['orina_microscospia']) OR !isset($registro['orina_microscospia_nom_anom'])))
					OR ($registro['hecho_31'] == 1 AND (empty($registro['otros_sangre_homocisteina']) OR !isset($registro['otros_sangre_homocisteina_nom_anom'])))
					OR ($registro['hecho_32'] == 1 AND (empty($registro['otros_perfil_tiroideo']) OR !isset($registro['otros_perfil_tiroideo_nom_anom'])))
					OR ($registro['hecho_33'] == 1 AND (empty($registro['otros_nivel_b12']) OR !isset($registro['otros_nivel_b12_nom_anom'])))
					OR ($registro['hecho_34'] == 1 AND (empty($registro['otros_acido_folico']) OR !isset($registro['otros_acido_folico_nom_anom'])))
					OR ($registro['hecho_35'] == 1 AND (empty($registro['otros_hba1c']) OR !isset($registro['otros_hba1c_nom_anom'])))
					OR ($registro['hecho_36'] == 1 AND (empty($registro['sifilis']) OR !isset($registro['sifilis_nom_anom']) ))					

					OR $registro['hecho_1'] == '' OR $registro['hecho_2'] == '' OR $registro['hecho_3'] == '' OR $registro['hecho_4'] == ''
					OR $registro['hecho_5'] == '' OR $registro['hecho_6'] == '' OR $registro['hecho_7'] == '' OR $registro['hecho_8'] == ''
					OR $registro['hecho_9'] == '' OR $registro['hecho_10'] == '' OR $registro['hecho_11'] == '' OR $registro['hecho_12'] == ''
					OR $registro['hecho_13'] == '' OR $registro['hecho_14'] == '' OR $registro['hecho_15'] == '' OR $registro['hecho_16'] == ''
					OR $registro['hecho_17'] == '' OR $registro['hecho_18'] == '' OR $registro['hecho_19'] == '' OR $registro['hecho_20'] == ''
					OR $registro['hecho_21'] == '' OR $registro['hecho_22'] == '' OR $registro['hecho_23'] == '' OR $registro['hecho_24'] == ''
					OR $registro['hecho_25'] == '' OR $registro['hecho_26'] == '' OR $registro['hecho_27'] == '' OR $registro['hecho_28'] == ''
					OR $registro['hecho_29'] == '' OR $registro['hecho_30'] == '' OR $registro['hecho_31'] == '' OR $registro['hecho_32'] == ''
					OR $registro['hecho_33'] == '' OR $registro['hecho_34'] == '' OR $registro['hecho_35'] == '' OR $registro['hecho_36'] == ''
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			$registro['status'] = $estado;

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Examen_laboratorio');
			$this->Model_Examen_laboratorio->update($registro);

			if($registro['etapa'] == 1){
				$subjet_['examen_laboratorio_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['examen_laboratorio_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['examen_laboratorio_6_status'] = $estado;
			}

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen de Laboratorio actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

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
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

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
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

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

			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				(
					empty($registro['fecha']) OR empty($registro['segundos'])
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['tmt_a_2_status'] = $estado;
			}			
			elseif($registro['etapa'] == 4){
				$subjet_['tmt_a_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['tmt_a_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['tmt_a_6_status'] = $estado;
			}

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Tmt_a');
			$this->Model_Tmt_a->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen TMT A agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}	

	public function tmt_a_show($subject_id, $etapa){
		$data['contenido'] = 'subject/tmt_a_show';
		$data['titulo'] = 'TMT A';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->model('Model_Tmt_a');
		$data['list'] = $this->Model_Tmt_a->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		/*querys abiertos para el formulario*/
		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"tmt_a", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

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
			$this->tmt_a_show($registro['subject_id'], $registro['etapa']);

		}else{
			
			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				(
					empty($registro['fecha']) OR empty($registro['segundos'])
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['tmt_a_2_status'] = $estado;
			}			
			elseif($registro['etapa'] == 4){
				$subjet_['tmt_a_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['tmt_a_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['tmt_a_6_status'] = $estado;
			}

			$registro['status'] = $estado;
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Tmt_a');
			$this->Model_Tmt_a->update($registro);		

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);	

			$this->auditlib->save_audit("Examen TMT A actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function tmt_a_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de TMT A", $registro['subject_id']);
			$this->tmt_a_show($registro['subject_id'], $registro['etapa']);
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
			$this->tmt_a_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

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
			$this->tmt_a_show($registro['subject_id'], $registro['etapa']);
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
			$this->tmt_b($registro['subject_id'], $registro['etapa']);

		}else{

			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				(
					empty($registro['fecha']) OR empty($registro['segundos'])
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['tmt_b_2_status'] = $estado;
			}			
			elseif($registro['etapa'] == 4){
				$subjet_['tmt_b_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['tmt_b_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['tmt_b_6_status'] = $estado;
			}

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Tmt_b');
			$this->Model_Tmt_b->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen TMT B agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}	

	public function tmt_b_show($subject_id, $etapa){
		$data['contenido'] = 'subject/tmt_b_show';
		$data['titulo'] = 'TMT B';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->model('Model_Tmt_b');
		$data['list'] = $this->Model_Tmt_b->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		/*querys abiertos para el formulario*/
		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"tmt_b", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

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
			$this->tmt_b_show($registro['subject_id'], $registro['etapa']);

		}else{
			
			if(isset($registro['realizado']) AND $registro['realizado'] == 1 AND
				(
					empty($registro['fecha']) OR empty($registro['segundos'])
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['tmt_b_2_status'] = $estado;
			}			
			elseif($registro['etapa'] == 4){
				$subjet_['tmt_b_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['tmt_b_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['tmt_b_6_status'] = $estado;
			}

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			$registro['status'] = $estado;
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Tmt_b');
			$this->Model_Tmt_b->update($registro);		

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);	

			$this->auditlib->save_audit("Examen TMT B actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function tmt_b_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de TMT B", $registro['subject_id']);
			$this->tmt_b_show($registro['subject_id'], $registro['etapa']);
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
			$this->tmt_b_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

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
			$this->tmt_b_show($registro['subject_id'], $registro['etapa']);
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

/*-----------------------------------------------------EQ-5D-5L ------------------------------------------------------------------------*/

	public function eq_5d_5l($subject_id, $etapa){
		$data['contenido'] = 'subject/eq_5d_5l';
		$data['titulo'] = 'EQ-5D-5L';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->view('template', $data);
	}
	
	public function eq_5d_5l_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id','Id del Sujeto','required|xss_clean');
		$this->form_validation->set_rules('etapa','Etapa','required|xss_clean');
		$this->form_validation->set_rules('realizado','Realizado','required|xss_clean');

		$this->form_validation->set_rules('fecha','Fecha','xss_clean');
		$this->form_validation->set_rules('movilidad','Movilidad','xss_clean');	
		$this->form_validation->set_rules('autocuidado','Autocuidado','xss_clean');
		$this->form_validation->set_rules('actividades_habituales','Actividades Habituales','xss_clean');
		$this->form_validation->set_rules('dolor_malestar','Dolor Malestar','xss_clean');
		$this->form_validation->set_rules('angustia_depresion','Angustia Depresion','xss_clean');
		$this->form_validation->set_rules('salud_hoy','Salud Hoy','xss_clean');
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar EQ-5D-5L", $registro['subject_id']);
			$this->eq_5d_5l($registro['subject_id'], $registro['etapa']);

		}else{

			if($registro['realizado'] == 1 
				AND (empty($registro['fecha']) OR !isset($registro['movilidad']) OR !isset($registro['autocuidado']) OR !isset($registro['actividades_habituales']) 
					OR !isset($registro['dolor_malestar']) OR !isset($registro['angustia_depresion']) OR $registro['salud_hoy'] == '')
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['eq_5d_5l_2_status'] = $estado;
			}
			elseif($registro['etapa'] == 3){
				$subjet_['eq_5d_5l_3_status'] = $estado;
			}			
			elseif($registro['etapa'] == 4){
				$subjet_['eq_5d_5l_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['eq_5d_5l_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['eq_5d_5l_6_status'] = $estado;
			}

			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Eq_5d_5l');
			$this->Model_Eq_5d_5l->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen EQ-5D-5L agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function eq_5d_5l_show($subject_id, $etapa){
		$data['contenido'] = 'subject/eq_5d_5l_show';
		$data['titulo'] = 'EQ-5D-5L';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->model('Model_Eq_5d_5l');
		$data['list'] = $this->Model_Eq_5d_5l->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"eq_5d_5l", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->view('template', $data);
	}

	public function eq_5d_5l_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id','Id del Sujeto','required|xss_clean');
		$this->form_validation->set_rules('etapa','Etapa','required|xss_clean');
		$this->form_validation->set_rules('realizado','Realizado','required|xss_clean');

		$this->form_validation->set_rules('fecha','Fecha','xss_clean');
		$this->form_validation->set_rules('movilidad','Movilidad','xss_clean');	
		$this->form_validation->set_rules('autocuidado','Autocuidado','xss_clean');
		$this->form_validation->set_rules('actividades_habituales','Actividades Habituales','xss_clean');
		$this->form_validation->set_rules('dolor_malestar','Dolor Malestar','xss_clean');
		$this->form_validation->set_rules('angustia_depresion','Angustia Depresion','xss_clean');
		$this->form_validation->set_rules('salud_hoy','Salud Hoy','xss_clean');
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar EQ-5D-5L", $registro['subject_id']);
			$this->eq_5d_5l_show($registro['subject_id'], $registro['etapa']);

		}else{

			if($registro['realizado'] == 1 
				AND (empty($registro['fecha']) OR !isset($registro['movilidad']) OR !isset($registro['autocuidado']) OR !isset($registro['actividades_habituales']) 
					OR !isset($registro['dolor_malestar']) OR !isset($registro['angustia_depresion']) OR $registro['salud_hoy'] == '')
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['eq_5d_5l_2_status'] = $estado;
			}
			elseif($registro['etapa'] == 3){
				$subjet_['eq_5d_5l_3_status'] = $estado;
			}			
			elseif($registro['etapa'] == 4){
				$subjet_['eq_5d_5l_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['eq_5d_5l_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['eq_5d_5l_6_status'] = $estado;
			}

			$registro['status'] = $estado;			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Eq_5d_5l');
			$this->Model_Eq_5d_5l->update($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen EQ-5D-5L actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function eq_5d_5l_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de EQ-5D-5L", $registro['subject_id']);
			$this->eq_5d_5l_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Eq_5d_5l');
			$this->Model_Eq_5d_5l->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de EQ-5D-5L", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('eq_5d_5l_2_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('eq_5d_5l_3_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('eq_5d_5l_4_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('eq_5d_5l_5_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('eq_5d_5l_6_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function eq_5d_5l_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de EQ-5D-5L", $registro['subject_id']);
			$this->eq_5d_5l_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Eq_5d_5l');
			$this->Model_Eq_5d_5l->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de EQ-5D-5L", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('eq_5d_5l_2_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('eq_5d_5l_3_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('eq_5d_5l_4_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('eq_5d_5l_5_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('eq_5d_5l_6_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function eq_5d_5l_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de EQ-5D-5L", $registro['subject_id']);
			$this->eq_5d_5l_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Eq_5d_5l');
			$this->Model_Eq_5d_5l->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de EQ-5D-5L", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('eq_5d_5l_2_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('eq_5d_5l_3_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('eq_5d_5l_4_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('eq_5d_5l_5_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('eq_5d_5l_6_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	/*----------------------------------------------------- NPI ------------------------------------------------------------------------*/

	public function npi($subject_id, $etapa){
		$data['contenido'] = 'subject/npi';
		$data['titulo'] = 'NPI';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;
		$data['frecuencia'] = array(''=>'','1'=>'1','2'=>'2','3'=>'3','4'=>'4');
		$data['severidad'] = array(''=>'','1'=>'1','2'=>'2','3'=>'3');
		$data['angustia'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');

		$this->load->view('template2', $data);
	}

	public function npi_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id','Id del Sujeto','required|xss_clean');
		$this->form_validation->set_rules('etapa','Etapa','required|xss_clean');
		$this->form_validation->set_rules('realizado','Realizado','required|xss_clean');

		$this->form_validation->set_rules('fecha','Fecha','xss_clean');
		$this->form_validation->set_rules('puntaje_total_npi','','xss_clean');			
		$this->form_validation->set_rules('puntaje_total_para_angustia','','xss_clean');
		$this->form_validation->set_rules('delirio_status','','xss_clean');
		$this->form_validation->set_rules('delirio_puntaje','','xss_clean');
		$this->form_validation->set_rules('delirio_angustia','','xss_clean');
		$this->form_validation->set_rules('alucinaciones_status','','xss_clean');
		$this->form_validation->set_rules('alucinaciones_puntaje','','xss_clean');
		$this->form_validation->set_rules('alucinaciones_angustia','','xss_clean');
		$this->form_validation->set_rules('agitacion_status','','xss_clean');
		$this->form_validation->set_rules('agitacion_puntaje','','xss_clean');
		$this->form_validation->set_rules('agitacion_angustia','','xss_clean');
		$this->form_validation->set_rules('depresion_status','','xss_clean');
		$this->form_validation->set_rules('depresion_puntaje','','xss_clean');			
		$this->form_validation->set_rules('depresion_angustia','','xss_clean');
		$this->form_validation->set_rules('ansiedad_status','','xss_clean');
		$this->form_validation->set_rules('ansiedad_puntaje','','xss_clean');
		$this->form_validation->set_rules('ansiedad_angustia','','xss_clean');
		$this->form_validation->set_rules('elacion_status','','xss_clean');
		$this->form_validation->set_rules('elacion_puntaje','','xss_clean');
		$this->form_validation->set_rules('elacion_angustia','','xss_clean');
		$this->form_validation->set_rules('apatia_status','','xss_clean');
		$this->form_validation->set_rules('apatia_puntaje','','xss_clean');
		$this->form_validation->set_rules('apatia_angustia','','xss_clean');
		$this->form_validation->set_rules('deshinibicion_status','','xss_clean');
		$this->form_validation->set_rules('deshinibicion_puntaje','','xss_clean');			
		$this->form_validation->set_rules('deshinibicion_angustia','','xss_clean');
		$this->form_validation->set_rules('irritabilidad_status','','xss_clean');
		$this->form_validation->set_rules('irritabilidad_puntaje','','xss_clean');
		$this->form_validation->set_rules('irritabilidad_angustia','','xss_clean');
		$this->form_validation->set_rules('conducta_status','','xss_clean');
		$this->form_validation->set_rules('conducta_puntaje','','xss_clean');
		$this->form_validation->set_rules('conducta_angustia','','xss_clean');
		$this->form_validation->set_rules('trastornos_sueno_status','','xss_clean');
		$this->form_validation->set_rules('trastornos_sueno_puntaje','','xss_clean');
		$this->form_validation->set_rules('trastornos_sueno_angustia','','xss_clean');
		$this->form_validation->set_rules('trastornos_apetito_status','','xss_clean');
		$this->form_validation->set_rules('trastornos_apetito_puntaje','','xss_clean');			
		$this->form_validation->set_rules('trastornos_apetito_angustia','','xss_clean');
		$this->form_validation->set_rules('delirio_frecuencia','','xss_clean');
		$this->form_validation->set_rules('delirio_severidad','','xss_clean');
		$this->form_validation->set_rules('alucinaciones_frecuencia','','xss_clean');
		$this->form_validation->set_rules('alucinaciones_severidad','','xss_clean');
		$this->form_validation->set_rules('agitacion_frecuencia','','xss_clean');
		$this->form_validation->set_rules('agitacion_severidad','','xss_clean');
		$this->form_validation->set_rules('depresion_frecuencia','','xss_clean');
		$this->form_validation->set_rules('depresion_severidad','','xss_clean');
		$this->form_validation->set_rules('ansiedad_frecuencia','','xss_clean');
		$this->form_validation->set_rules('ansiedad_severidad','','xss_clean');
		$this->form_validation->set_rules('elacion_frecuencia','','xss_clean');
		$this->form_validation->set_rules('elacion_severidad','','xss_clean');
		$this->form_validation->set_rules('apatia_frecuencia','','xss_clean');
		$this->form_validation->set_rules('apatia_severidad','','xss_clean');
		$this->form_validation->set_rules('deshinibicion_frecuencia','','xss_clean');
		$this->form_validation->set_rules('deshinibicion_severidad','','xss_clean');
		$this->form_validation->set_rules('irritabilidad_frecuencia','','xss_clean');
		$this->form_validation->set_rules('irritabilidad_severidad','','xss_clean');
		$this->form_validation->set_rules('conducta_frecuencia','','xss_clean');
		$this->form_validation->set_rules('conducta_severidad','','xss_clean');
		$this->form_validation->set_rules('trastornos_sueno_frecuencia','','xss_clean');
		$this->form_validation->set_rules('trastornos_sueno_severidad','','xss_clean');
		$this->form_validation->set_rules('trastornos_apetito_frecuencia','','xss_clean');
		$this->form_validation->set_rules('trastornos_apetito_severidad','','xss_clean');


		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar NPI", $registro['subject_id']);
			$this->npi($registro['subject_id'], $registro['etapa']);

		}else{

			if($registro['realizado'] == 1 
				AND (empty($registro['fecha']) OR $registro['puntaje_total_npi'] == ''  OR $registro['puntaje_total_para_angustia'] == '' 
				 OR (isset($registro['delirio_status']) AND $registro['delirio_status'] == '' )
				 OR (isset($registro['alucinaciones_status']) AND $registro['alucinaciones_status'] == '' )
				 OR (isset($registro['agitacion_status']) AND $registro['agitacion_status'] == '' )
				 OR (isset($registro['depresion_status']) AND $registro['depresion_status'] == '' )
				 OR (isset($registro['ansiedad_status']) AND $registro['ansiedad_status'] == '' )
				 OR (isset($registro['elacion_status']) AND $registro['elacion_status'] == '' )
				 OR (isset($registro['apatia_status']) AND $registro['apatia_status'] == '' )
				 OR (isset($registro['deshinibicion_status']) AND $registro['deshinibicion_status'] == '' )
				 OR (isset($registro['irritabilidad_status']) AND $registro['irritabilidad_status'] == '' )
				 OR (isset($registro['conducta_status']) AND $registro['conducta_status'] == '' )
				 OR (isset($registro['trastornos_sueno_status']) AND $registro['trastornos_sueno_status'] == '' )
				 OR (isset($registro['trastornos_apetito_status']) AND $registro['trastornos_apetito_status'] == '')
				 OR (isset($registro['delirio_frecuencia']) AND $registro['delirio_frecuencia'] == '') 
				 OR (isset($registro['delirio_severidad']) AND $registro['delirio_severidad'] == '' )
				 OR (isset($registro['alucinaciones_frecuencia']) AND $registro['alucinaciones_frecuencia'] == '')
				 OR (isset($registro['alucinaciones_severidad']) AND $registro['alucinaciones_severidad'] == '' )
				 OR (isset($registro['agitacion_frecuencia']) AND $registro['agitacion_frecuencia'] == '' )
				 OR (isset($registro['agitacion_severidad']) AND $registro['agitacion_severidad'] == '')
				 OR (isset($registro['depresion_frecuencia']) AND $registro['depresion_frecuencia'] == '' )
				 OR (isset($registro['depresion_severidad']) AND $registro['depresion_severidad'] == '')
				 OR (isset($registro['ansiedad_frecuencia']) AND $registro['ansiedad_frecuencia'] == '')
				 OR (isset($registro['ansiedad_severidad']) AND $registro['ansiedad_severidad'] == '' )
				 OR (isset($registro['elacion_frecuencia']) AND $registro['elacion_frecuencia'] == '' )
				 OR (isset($registro['elacion_severidad']) AND $registro['elacion_severidad'] == '')
				 OR (isset($registro['apatia_frecuencia']) AND $registro['apatia_frecuencia'] == '' )
				 OR (isset($registro['apatia_severidad']) AND $registro['apatia_severidad'] == '' )
				 OR (isset($registro['deshinibicion_frecuencia']) AND $registro['deshinibicion_frecuencia'] == '')
				 OR (isset($registro['deshinibicion_severidad']) AND $registro['deshinibicion_severidad'] == '' )
				 OR (isset($registro['irritabilidad_frecuencia']) AND $registro['irritabilidad_frecuencia'] == '' )
				 OR (isset($registro['irritabilidad_severidad']) AND $registro['irritabilidad_severidad'] == '')
				 OR (isset($registro['conducta_frecuencia']) AND $registro['conducta_frecuencia'] == '' )
				 OR (isset($registro['conducta_severidad']) AND $registro['conducta_severidad'] == '' )
				 OR (isset($registro['trastornos_sueno_frecuencia']) AND $registro['trastornos_sueno_frecuencia'] == '')
				 OR (isset($registro['trastornos_sueno_severidad']) AND $registro['trastornos_sueno_severidad'] == '' )
				 OR (isset($registro['trastornos_apetito_frecuencia']) AND $registro['trastornos_apetito_frecuencia'] == '' )
				 OR (isset($registro['trastornos_apetito_severidad']) AND $registro['trastornos_apetito_severidad'] == '')
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['npi_2_status'] = $estado;
			}						
			elseif($registro['etapa'] == 4){
				$subjet_['npi_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['npi_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['npi_6_status'] = $estado;
			}

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Npi');
			$this->Model_Npi->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen NPI agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function npi_show($subject_id, $etapa){
		$data['contenido'] = 'subject/npi_show';
		$data['titulo'] = 'NPI';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;
		$data['frecuencia'] = array(''=>'','1'=>'1','2'=>'2','3'=>'3','4'=>'4');
		$data['severidad'] = array(''=>'','1'=>'1','2'=>'2','3'=>'3');
		$data['angustia'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');

		$this->load->model('Model_Npi');
		$data['list'] = $this->Model_Npi->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		/*querys abiertos para el formulario*/
		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"npi", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->view('template2', $data);
	}

	public function npi_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id','Id del Sujeto','required|xss_clean');
		$this->form_validation->set_rules('etapa','Etapa','required|xss_clean');
		$this->form_validation->set_rules('realizado','Realizado','required|xss_clean');

		$this->form_validation->set_rules('fecha','Fecha','xss_clean');
		$this->form_validation->set_rules('puntaje_total_npi','','xss_clean');			
		$this->form_validation->set_rules('puntaje_total_para_angustia','','xss_clean');
		$this->form_validation->set_rules('delirio_status','','xss_clean');
		$this->form_validation->set_rules('delirio_puntaje','','xss_clean');
		$this->form_validation->set_rules('delirio_angustia','','xss_clean');
		$this->form_validation->set_rules('alucinaciones_status','','xss_clean');
		$this->form_validation->set_rules('alucinaciones_puntaje','','xss_clean');
		$this->form_validation->set_rules('alucinaciones_angustia','','xss_clean');
		$this->form_validation->set_rules('agitacion_status','','xss_clean');
		$this->form_validation->set_rules('agitacion_puntaje','','xss_clean');
		$this->form_validation->set_rules('agitacion_angustia','','xss_clean');
		$this->form_validation->set_rules('depresion_status','','xss_clean');
		$this->form_validation->set_rules('depresion_puntaje','','xss_clean');			
		$this->form_validation->set_rules('depresion_angustia','','xss_clean');
		$this->form_validation->set_rules('ansiedad_status','','xss_clean');
		$this->form_validation->set_rules('ansiedad_puntaje','','xss_clean');
		$this->form_validation->set_rules('ansiedad_angustia','','xss_clean');
		$this->form_validation->set_rules('elacion_status','','xss_clean');
		$this->form_validation->set_rules('elacion_puntaje','','xss_clean');
		$this->form_validation->set_rules('elacion_angustia','','xss_clean');
		$this->form_validation->set_rules('apatia_status','','xss_clean');
		$this->form_validation->set_rules('apatia_puntaje','','xss_clean');
		$this->form_validation->set_rules('apatia_angustia','','xss_clean');
		$this->form_validation->set_rules('deshinibicion_status','','xss_clean');
		$this->form_validation->set_rules('deshinibicion_puntaje','','xss_clean');			
		$this->form_validation->set_rules('deshinibicion_angustia','','xss_clean');
		$this->form_validation->set_rules('irritabilidad_status','','xss_clean');
		$this->form_validation->set_rules('irritabilidad_puntaje','','xss_clean');
		$this->form_validation->set_rules('irritabilidad_angustia','','xss_clean');
		$this->form_validation->set_rules('conducta_status','','xss_clean');
		$this->form_validation->set_rules('conducta_puntaje','','xss_clean');
		$this->form_validation->set_rules('conducta_angustia','','xss_clean');
		$this->form_validation->set_rules('trastornos_sueno_status','','xss_clean');
		$this->form_validation->set_rules('trastornos_sueno_puntaje','','xss_clean');
		$this->form_validation->set_rules('trastornos_sueno_angustia','','xss_clean');
		$this->form_validation->set_rules('trastornos_apetito_status','','xss_clean');
		$this->form_validation->set_rules('trastornos_apetito_puntaje','','xss_clean');			
		$this->form_validation->set_rules('trastornos_apetito_angustia','','xss_clean');
		$this->form_validation->set_rules('delirio_frecuencia','','xss_clean');
		$this->form_validation->set_rules('delirio_severidad','','xss_clean');
		$this->form_validation->set_rules('alucinaciones_frecuencia','','xss_clean');
		$this->form_validation->set_rules('alucinaciones_severidad','','xss_clean');
		$this->form_validation->set_rules('agitacion_frecuencia','','xss_clean');
		$this->form_validation->set_rules('agitacion_severidad','','xss_clean');
		$this->form_validation->set_rules('depresion_frecuencia','','xss_clean');
		$this->form_validation->set_rules('depresion_severidad','','xss_clean');
		$this->form_validation->set_rules('ansiedad_frecuencia','','xss_clean');
		$this->form_validation->set_rules('ansiedad_severidad','','xss_clean');
		$this->form_validation->set_rules('elacion_frecuencia','','xss_clean');
		$this->form_validation->set_rules('elacion_severidad','','xss_clean');
		$this->form_validation->set_rules('apatia_frecuencia','','xss_clean');
		$this->form_validation->set_rules('apatia_severidad','','xss_clean');
		$this->form_validation->set_rules('deshinibicion_frecuencia','','xss_clean');
		$this->form_validation->set_rules('deshinibicion_severidad','','xss_clean');
		$this->form_validation->set_rules('irritabilidad_frecuencia','','xss_clean');
		$this->form_validation->set_rules('irritabilidad_severidad','','xss_clean');
		$this->form_validation->set_rules('conducta_frecuencia','','xss_clean');
		$this->form_validation->set_rules('conducta_severidad','','xss_clean');
		$this->form_validation->set_rules('trastornos_sueno_frecuencia','','xss_clean');
		$this->form_validation->set_rules('trastornos_sueno_severidad','','xss_clean');
		$this->form_validation->set_rules('trastornos_apetito_frecuencia','','xss_clean');
		$this->form_validation->set_rules('trastornos_apetito_severidad','','xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar NPI", $registro['subject_id']);
			$this->npi_show($registro['subject_id'], $registro['etapa']);

		}else{

			if($registro['realizado'] == 1 
				AND (empty($registro['fecha']) OR $registro['puntaje_total_npi'] == ''  OR $registro['puntaje_total_para_angustia'] == '' 
				 OR (isset($registro['delirio_status']) AND $registro['delirio_status'] == '' )
				 OR (isset($registro['alucinaciones_status']) AND $registro['alucinaciones_status'] == '' )
				 OR (isset($registro['agitacion_status']) AND $registro['agitacion_status'] == '' )
				 OR (isset($registro['depresion_status']) AND $registro['depresion_status'] == '' )
				 OR (isset($registro['ansiedad_status']) AND $registro['ansiedad_status'] == '' )
				 OR (isset($registro['elacion_status']) AND $registro['elacion_status'] == '' )
				 OR (isset($registro['apatia_status']) AND $registro['apatia_status'] == '' )
				 OR (isset($registro['deshinibicion_status']) AND $registro['deshinibicion_status'] == '' )
				 OR (isset($registro['irritabilidad_status']) AND $registro['irritabilidad_status'] == '' )
				 OR (isset($registro['conducta_status']) AND $registro['conducta_status'] == '' )
				 OR (isset($registro['trastornos_sueno_status']) AND $registro['trastornos_sueno_status'] == '' )
				 OR (isset($registro['trastornos_apetito_status']) AND $registro['trastornos_apetito_status'] == '')
				 OR (isset($registro['delirio_frecuencia']) AND $registro['delirio_frecuencia'] == '') 
				 OR (isset($registro['delirio_severidad']) AND $registro['delirio_severidad'] == '' )
				 OR (isset($registro['alucinaciones_frecuencia']) AND $registro['alucinaciones_frecuencia'] == '')
				 OR (isset($registro['alucinaciones_severidad']) AND $registro['alucinaciones_severidad'] == '' )
				 OR (isset($registro['agitacion_frecuencia']) AND $registro['agitacion_frecuencia'] == '' )
				 OR (isset($registro['agitacion_severidad']) AND $registro['agitacion_severidad'] == '')
				 OR (isset($registro['depresion_frecuencia']) AND $registro['depresion_frecuencia'] == '' )
				 OR (isset($registro['depresion_severidad']) AND $registro['depresion_severidad'] == '')
				 OR (isset($registro['ansiedad_frecuencia']) AND $registro['ansiedad_frecuencia'] == '')
				 OR (isset($registro['ansiedad_severidad']) AND $registro['ansiedad_severidad'] == '' )
				 OR (isset($registro['elacion_frecuencia']) AND $registro['elacion_frecuencia'] == '' )
				 OR (isset($registro['elacion_severidad']) AND $registro['elacion_severidad'] == '')
				 OR (isset($registro['apatia_frecuencia']) AND $registro['apatia_frecuencia'] == '' )
				 OR (isset($registro['apatia_severidad']) AND $registro['apatia_severidad'] == '' )
				 OR (isset($registro['deshinibicion_frecuencia']) AND $registro['deshinibicion_frecuencia'] == '')
				 OR (isset($registro['deshinibicion_severidad']) AND $registro['deshinibicion_severidad'] == '' )
				 OR (isset($registro['irritabilidad_frecuencia']) AND $registro['irritabilidad_frecuencia'] == '' )
				 OR (isset($registro['irritabilidad_severidad']) AND $registro['irritabilidad_severidad'] == '')
				 OR (isset($registro['conducta_frecuencia']) AND $registro['conducta_frecuencia'] == '' )
				 OR (isset($registro['conducta_severidad']) AND $registro['conducta_severidad'] == '' )
				 OR (isset($registro['trastornos_sueno_frecuencia']) AND $registro['trastornos_sueno_frecuencia'] == '')
				 OR (isset($registro['trastornos_sueno_severidad']) AND $registro['trastornos_sueno_severidad'] == '' )
				 OR (isset($registro['trastornos_apetito_frecuencia']) AND $registro['trastornos_apetito_frecuencia'] == '' )
				 OR (isset($registro['trastornos_apetito_severidad']) AND $registro['trastornos_apetito_severidad'] == '')
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['npi_2_status'] = $estado;
			}						
			elseif($registro['etapa'] == 4){
				$subjet_['npi_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['npi_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['npi_6_status'] = $estado;
			}

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			$registro['status'] = $estado;
			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Npi');
			$this->Model_Npi->update($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen NPI actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function npi_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de NPI", $registro['subject_id']);
			$this->npi_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Npi');
			$this->Model_Npi->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de NPI", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('npi_2_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}					
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('npi_4_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('npi_5_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('npi_6_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function npi_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de NPI", $registro['subject_id']);
			$this->npi_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Npi');
			$this->Model_Npi->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de NPI", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('npi_2_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}					
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('npi_4_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('npi_5_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('npi_6_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function npi_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de NPI", $registro['subject_id']);
			$this->npi_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Npi');
			$this->Model_Npi->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de NPI", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('npi_2_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}					
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('npi_4_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('npi_5_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('npi_6_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	/*----------------------------------------------------- APATIA ------------------------------------------------------------------------*/

	public function apatia($subject_id, $etapa){
		$data['contenido'] = 'subject/apatia';
		$data['titulo'] = 'APATIA';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		$data['etapa'] = $etapa;

		$this->load->view('template', $data);
	}

	public function apatia_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id','Id del Sujeto','required|xss_clean');
		$this->form_validation->set_rules('etapa','Etapa','required|xss_clean');

		$this->form_validation->set_rules('apatia_realizado','','xss_clean');
		$this->form_validation->set_rules('apatia_fecha','','xss_clean');
		$this->form_validation->set_rules('apatia_1','','xss_clean');
		$this->form_validation->set_rules('apatia_2','','xss_clean');
		$this->form_validation->set_rules('apatia_3','','xss_clean');
		$this->form_validation->set_rules('apatia_4','','xss_clean');
		$this->form_validation->set_rules('apatia_5','','xss_clean');
		$this->form_validation->set_rules('apatia_6','','xss_clean');
		$this->form_validation->set_rules('apatia_7','','xss_clean');
		$this->form_validation->set_rules('apatia_8','','xss_clean');
		$this->form_validation->set_rules('apatia_9','','xss_clean');
		$this->form_validation->set_rules('apatia_10','','xss_clean');
		$this->form_validation->set_rules('apatia_11','','xss_clean');
		$this->form_validation->set_rules('apatia_12','','xss_clean');
		$this->form_validation->set_rules('apatia_13','','xss_clean');
		$this->form_validation->set_rules('apatia_14','','xss_clean');
		$this->form_validation->set_rules('apatia_15','','xss_clean');
		$this->form_validation->set_rules('apatia_16','','xss_clean');
		$this->form_validation->set_rules('apatia_17','','xss_clean');
		$this->form_validation->set_rules('apatia_18','','xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar Autoevaluacion", $registro['subject_id']);
			$this->autoevaluacion($registro['subject_id'], $registro['etapa']);

		}else{

			if(
				
				$registro['apatia_realizado'] == 1 	AND 
				(
					empty($registro['apatia_fecha']) OR !isset($registro['apatia_1']) OR !isset($registro['apatia_2'])
					OR !isset($registro['apatia_3']) OR !isset($registro['apatia_4']) OR !isset($registro['apatia_5'])
					OR !isset($registro['apatia_6']) OR !isset($registro['apatia_7']) OR !isset($registro['apatia_8'])
					OR !isset($registro['apatia_9']) OR !isset($registro['apatia_10']) OR !isset($registro['apatia_11'])
					OR !isset($registro['apatia_12']) OR !isset($registro['apatia_13']) OR !isset($registro['apatia_14'])
					OR !isset($registro['apatia_15']) OR !isset($registro['apatia_16']) OR !isset($registro['apatia_17'])
					OR !isset($registro['apatia_18'])
				)
				
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['apatia_2_status'] = $estado;
			}						
			elseif($registro['etapa'] == 3){
				$subjet_['apatia_3_status'] = $estado;
			}
			elseif($registro['etapa'] == 4){
				$subjet_['apatia_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['apatia_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['apatia_6_status'] = $estado;
			}
			
			if(!empty($registro['apatia_fecha'])){
				$registro['apatia_fecha'] = $this->convertirFecha($registro['apatia_fecha']);
			}
			
			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Apatia');
			$this->Model_Apatia->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen de Apatia agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}
	
	public function apatia_show($subject_id, $etapa){
			$data['contenido'] = 'subject/apatia_show';
			$data['titulo'] = 'APATIA';
			$data['subject'] = $this->Model_Subject->find($subject_id);		
			$data['etapa'] = $etapa;

			$this->load->model('Model_Apatia');
			$data['list'] = $this->Model_Apatia->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

			$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"apatia", "etapa"=>$etapa, "status"=>'Abierto'));		
			if(isset($campos_query) AND !empty($campos_query)){
				foreach ($campos_query as $value) {
					$data['campos_query'][] = $value->campo;
				}
			}else{
				$data['campos_query'] = array();
			}

			$this->load->view('template', $data);
	}

	public function apatia_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id','Id del Sujeto','required|xss_clean');
		$this->form_validation->set_rules('etapa','Etapa','required|xss_clean');

		$this->form_validation->set_rules('apatia_realizado','','xss_clean');
		$this->form_validation->set_rules('apatia_fecha','','xss_clean');
		$this->form_validation->set_rules('apatia_1','','xss_clean');
		$this->form_validation->set_rules('apatia_2','','xss_clean');
		$this->form_validation->set_rules('apatia_3','','xss_clean');
		$this->form_validation->set_rules('apatia_4','','xss_clean');
		$this->form_validation->set_rules('apatia_5','','xss_clean');
		$this->form_validation->set_rules('apatia_6','','xss_clean');
		$this->form_validation->set_rules('apatia_7','','xss_clean');
		$this->form_validation->set_rules('apatia_8','','xss_clean');
		$this->form_validation->set_rules('apatia_9','','xss_clean');
		$this->form_validation->set_rules('apatia_10','','xss_clean');
		$this->form_validation->set_rules('apatia_11','','xss_clean');
		$this->form_validation->set_rules('apatia_12','','xss_clean');
		$this->form_validation->set_rules('apatia_13','','xss_clean');
		$this->form_validation->set_rules('apatia_14','','xss_clean');
		$this->form_validation->set_rules('apatia_15','','xss_clean');
		$this->form_validation->set_rules('apatia_16','','xss_clean');
		$this->form_validation->set_rules('apatia_17','','xss_clean');
		$this->form_validation->set_rules('apatia_18','','xss_clean');
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar Autoevaluacion", $registro['subject_id']);
			$this->autoevaluacion_show($registro['subject_id'], $registro['etapa']);

		}else{

			if(
				$registro['apatia_realizado'] == 1 	AND 
				(
					empty($registro['apatia_fecha']) OR !isset($registro['apatia_1']) OR !isset($registro['apatia_2'])
					OR !isset($registro['apatia_3']) OR !isset($registro['apatia_4']) OR !isset($registro['apatia_5'])
					OR !isset($registro['apatia_6']) OR !isset($registro['apatia_7']) OR !isset($registro['apatia_8'])
					OR !isset($registro['apatia_9']) OR !isset($registro['apatia_10']) OR !isset($registro['apatia_11'])
					OR !isset($registro['apatia_12']) OR !isset($registro['apatia_13']) OR !isset($registro['apatia_14'])
					OR !isset($registro['apatia_15']) OR !isset($registro['apatia_16']) OR !isset($registro['apatia_17'])
					OR !isset($registro['apatia_18'])
				)
				
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['apatia_2_status'] = $estado;
			}						
			elseif($registro['etapa'] == 3){
				$subjet_['apatia_3_status'] = $estado;
			}
			elseif($registro['etapa'] == 4){
				$subjet_['apatia_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['apatia_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['apatia_6_status'] = $estado;
			}

			$registro['status'] = $estado;			
			$registro['updated_at'] = date("Y-m-d H:i:s");		
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');	
		
			if(!empty($registro['apatia_fecha'])){
				$registro['apatia_fecha'] = $this->convertirFecha($registro['apatia_fecha']);
			}
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Apatia');
			$this->Model_Apatia->update($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen de Apatia actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function apatia_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de apatia", $registro['subject_id']);
			$this->apatia_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Apatia');
			$this->Model_Apatia->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de apatia", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('apatia_2_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}	
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('apatia_3_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}				
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('apatia_4_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('apatia_5_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('apatia_6_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
	
	public function apatia_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Apatia", $registro['subject_id']);
			$this->apatia_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Apatia');
			$this->Model_Apatia->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de Apatia", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('apatia_2_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('apatia_3_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('apatia_4_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('apatia_5_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('apatia_6_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
	public function apatia_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de apatia", $registro['subject_id']);
			$this->apatia_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Apatia');
			$this->Model_Apatia->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de apatia", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('apatia_2_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 3) {
				$this->Model_Subject->update(array('apatia_3_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}			
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('apatia_4_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('apatia_5_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('apatia_6_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}
/*----------------------------------------------------- RNM o TC ------------------------------------------------------------------------*/	
	
	public function rnm($subject_id, $etapa){
		$data['contenido'] = 'subject/rnm';
		$data['titulo'] = 'RNM o TC';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;

		$this->load->view('template', $data);
	}

	public function rnm_insert(){
		$registro = $this->input->post();
		
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');  
		$this->form_validation->set_rules('realizado', '', 'xss_clean');  

		$this->form_validation->set_rules('resonancia', '', 'xss_clean');
		$this->form_validation->set_rules('resonancia_fecha', '', 'xss_clean');
		$this->form_validation->set_rules('resonancia_comentario', '', 'xss_clean');
		$this->form_validation->set_rules('tomografia', '', 'xss_clean');
		$this->form_validation->set_rules('tomografia_fecha', '', 'xss_clean');
		$this->form_validation->set_rules('tomografia_comentario', '', 'xss_clean');
		$this->form_validation->set_rules('repetir_rnm', '', 'xss_clean');
		$this->form_validation->set_rules('repetir_tc', '', 'xss_clean');
		$this->form_validation->set_rules('se_solicita_tomografia', '', 'xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de agregar el formulario de RNM o TC", $registro['subject_id']);
			$this->rnm($registro['subject_id'], $registro['etapa']);
		}
		else {

			if(
				$registro['etapa'] == 1
				AND(
					(
						isset($registro['resonancia']) AND $registro['resonancia'] == 1 AND 
						(
							empty($registro['resonancia_fecha']) 
							// OR empty($registro['resonancia_comentario'])
						)
					)
					OR
					(
						isset($registro['tomografia']) AND $registro['tomografia'] == 1 AND 
						(
							empty($registro['tomografia_fecha']) 
							// OR empty($registro['tomografia_comentario'])
						)
					)
					OR !isset($registro['se_solicita_tomografia'])
				)
				OR
				$registro['etapa'] == 2
				AND(
					!isset($registro['realizado']) AND 
					(
						(
							isset($registro['resonancia']) AND $registro['resonancia'] == 1 AND 
							(
								empty($registro['resonancia_fecha']) 
								// OR empty($registro['resonancia_comentario'])
							)
						)
						OR
						(
							isset($registro['tomografia']) AND $registro['tomografia'] == 1 AND 
							(
								empty($registro['tomografia_fecha']) 
								// OR empty($registro['tomografia_comentario'])
							)
						)
					)
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 1){
				$subjet_['rnm_status'] = $estado;
			}
			if($registro['etapa'] == 2){
				$subjet_['rnm_2_status'] = $estado;	
			}


			if(!empty($registro['resonancia_fecha'])){
				$registro['resonancia_fecha'] = $this->convertirFecha($registro['resonancia_fecha']);
			}
			if(!empty($registro['version_clinica_fecha'])){
				$registro['tomografia_fecha'] = $this->convertirFecha($registro['tomografia_fecha']);
			}
			
			
			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Rnm');
			$this->Model_Rnm->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen de RNM o TC agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);
		}

	}

	public function rnm_show($subject_id, $etapa){
		$data['contenido'] = 'subject/rnm_show';
		$data['titulo'] = 'RNM o TC';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;

		$this->load->model('Model_Rnm');
		$data['list'] = $this->Model_Rnm->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		/*querys abiertos para el formulario*/
		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"rnm", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->view('template', $data);
	}

	public function rnm_update(){
		$registro = $this->input->post();
		
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');  
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');  
		$this->form_validation->set_rules('realizado', '', 'xss_clean');  

		$this->form_validation->set_rules('id', 'ID', 'required|xss_clean'); 
		$this->form_validation->set_rules('resonancia', '', 'xss_clean');
		$this->form_validation->set_rules('resonancia_fecha', '', 'xss_clean');
		$this->form_validation->set_rules('resonancia_comentario', '', 'xss_clean');
		$this->form_validation->set_rules('tomografia', '', 'xss_clean');
		$this->form_validation->set_rules('tomografia_fecha', '', 'xss_clean');
		$this->form_validation->set_rules('tomografia_comentario', '', 'xss_clean');
		$this->form_validation->set_rules('repetir_rnm', '', 'xss_clean');
		$this->form_validation->set_rules('repetir_tc', '', 'xss_clean');
		$this->form_validation->set_rules('se_solicita_tomografia', '', 'xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de actualizar el formulario de RNM o TC", $registro['subject_id']);
			$this->rnm($registro['subject_id'], $registro['etapa']);
		}
		else {

			if(
				$registro['etapa'] == 1
				AND(
					(
						isset($registro['resonancia']) AND $registro['resonancia'] == 1 AND 
						(
							empty($registro['resonancia_fecha']) 
							// OR empty($registro['resonancia_comentario'])
						)
					)
					OR
					(
						isset($registro['tomografia']) AND $registro['tomografia'] == 1 AND 
						(
							empty($registro['tomografia_fecha']) 
							// OR empty($registro['tomografia_comentario'])
						)
					)
					OR !isset($registro['se_solicita_tomografia'])
				)
				OR
				$registro['etapa'] == 2
				AND(
					!isset($registro['realizado'])  AND 
					(
						(
							isset($registro['resonancia']) AND $registro['resonancia'] == 1 AND 
							(
								empty($registro['resonancia_fecha']) 
								// OR empty($registro['resonancia_comentario'])
							)
						)
						OR
						(
							isset($registro['tomografia']) AND $registro['tomografia'] == 1 AND 
							(
								empty($registro['tomografia_fecha']) 
								// OR empty($registro['tomografia_comentario'])
							)
						)
					)
				)
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 1){
				$subjet_['rnm_status'] = $estado;
			}
			if($registro['etapa'] == 2){
				$subjet_['rnm_2_status'] = $estado;	
			}

			if(!empty($registro['resonancia_fecha'])){
				$registro['resonancia_fecha'] = $this->convertirFecha($registro['resonancia_fecha']);
			}
			if(!empty($registro['version_clinica_fecha'])){
				$registro['tomografia_fecha'] = $this->convertirFecha($registro['tomografia_fecha']);
			}
			$registro['status'] = $estado;			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Rnm');
			$this->Model_Rnm->update($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Examen de RNM o TC actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function rnm_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de RNM", $registro['subject_id']);
			$this->rnm_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Rnm');
			$this->Model_Rnm->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de RNM", $registro['subject_id']);			
			
			
			$this->Model_Subject->update(array('rnm_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			

			redirect('subject/grid/'.$registro['subject_id'] ."/". $registro['etapa']);
		}
	}
	public function rnm_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de RNM", $registro['subject_id']);
			$this->rnm_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Rnm');
			$this->Model_Rnm->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de RNM", $registro['subject_id']);			
			
			$this->Model_Subject->update(array('rnm_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			

			redirect('subject/grid/'.$registro['subject_id'] ."/". $registro['etapa']);
		}
	}
	public function rnm_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de RNM", $registro['subject_id']);
			$this->rnm_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Rnm');
			$this->Model_Rnm->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de RNM", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/						
			$this->Model_Subject->update(array('rnm_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));			

			redirect('subject/grid/'.$registro['subject_id'] ."/". $registro['etapa']);
		}
	}
	/*----------------------------------------------------- Historial Medico -----------------------------------------------------------------*/
	
	public function historial_medico($subject_id, $etapa){
		$data['contenido'] = 'subject/historial_medico';
		$data['titulo'] = 'Historia Medica';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;
		
		$data['dias_ea'] = array(""=>"", "UNK"=>"UNK");
		for($i = 1; $i < 32; $i++){
			$data['dias_ea'][$i] = $i;
		}
		$data['meses_ea'] = array(""=>"", "UNK"=>"UNK");
		for($i = 1; $i < 13; $i++){
			$data['meses_ea'][$i] = $i;
		}
		$data['anio_ea'] = array(""=>"", "UNK"=>"UNK");
		for($i = date('Y'); $i >= 1920 ; $i--){
			$data['anio_ea'][$i] = $i;
		}

		$this->load->view('template2', $data);
	}

	public function historial_medico_insert(){
		$registro = $this->input->post();
		
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('hipertension', '', 'xss_clean');		
		$this->form_validation->set_rules('ulcera', '', 'xss_clean');		
		$this->form_validation->set_rules('diabetes', '', 'xss_clean');		
		$this->form_validation->set_rules('hipo_hipertiroidismo', '', 'xss_clean');		
		$this->form_validation->set_rules('hiperlipidemia', '', 'xss_clean');		
		$this->form_validation->set_rules('epoc', '', 'xss_clean');		
		$this->form_validation->set_rules('coronaria', '', 'xss_clean');		
		$this->form_validation->set_rules('rinitis', '', 'xss_clean');		
		$this->form_validation->set_rules('acc_vascular', '', 'xss_clean');		
		$this->form_validation->set_rules('asma', '', 'xss_clean');		
		$this->form_validation->set_rules('gastritis', '', 'xss_clean');		
		$this->form_validation->set_rules('cefaleas', '', 'xss_clean');		
		$this->form_validation->set_rules('alergia', '', 'xss_clean');
		$this->form_validation->set_rules('alergia_desc', '', 'xss_clean');
		$this->form_validation->set_rules('tabaquismo', '', 'xss_clean');
		$this->form_validation->set_rules('tabaquismo_desc', '', 'xss_clean');
		$this->form_validation->set_rules('ingesta_alcohol', '', 'xss_clean');
		$this->form_validation->set_rules('ingesta_alcohol_desc', '', 'xss_clean');
		$this->form_validation->set_rules('drogas', '', 'xss_clean');
		$this->form_validation->set_rules('drogas_desc', '', 'xss_clean');
		$this->form_validation->set_rules('cirugia', '', 'xss_clean');
		$this->form_validation->set_rules('cirugia_desc', '', 'xss_clean');
		$this->form_validation->set_rules('donado_sangre', '', 'xss_clean');
		$this->form_validation->set_rules('donado_sangre_desc', '', 'xss_clean');
		$this->form_validation->set_rules('tratamiento_farma', '', 'xss_clean');
		$this->form_validation->set_rules('tratamiento_farma_desc', '', 'xss_clean');
		$this->form_validation->set_rules('suplemento_dietetico', '', 'xss_clean');
		$this->form_validation->set_rules('suplemento_dietetico_desc', '', 'xss_clean');
		$this->form_validation->set_rules('alzheimer', '', 'xss_clean');
		$this->form_validation->set_rules('alzheimer_desc', '', 'xss_clean');
		$this->form_validation->set_rules('anio_ea', '', 'xss_clean');
		$this->form_validation->set_rules('mes_ea', '', 'xss_clean');
		$this->form_validation->set_rules('dia_ea', '', 'xss_clean');
		$this->form_validation->set_rules('morbido', '', 'xss_clean');
		$this->form_validation->set_rules('morbido_desc', '', 'xss_clean');
		$this->form_validation->set_rules('hipertension_dia', '', 'xss_clean');
		$this->form_validation->set_rules('hipertension_mes', '', 'xss_clean');
		$this->form_validation->set_rules('hipertension_anio', '', 'xss_clean');
		$this->form_validation->set_rules('ulcera_dia', '', 'xss_clean');
		$this->form_validation->set_rules('ulcera_mes', '', 'xss_clean');
		$this->form_validation->set_rules('ulcera_anio', '', 'xss_clean');
		$this->form_validation->set_rules('diabetes_dia', '', 'xss_clean');
		$this->form_validation->set_rules('diabetes_mes', '', 'xss_clean');
		$this->form_validation->set_rules('diabetes_anio', '', 'xss_clean');
		$this->form_validation->set_rules('hipo_hipertiroidismo_dia', '', 'xss_clean');
		$this->form_validation->set_rules('hipo_hipertiroidismo_mes', '', 'xss_clean');
		$this->form_validation->set_rules('hipo_hipertiroidismo_anio', '', 'xss_clean');
		$this->form_validation->set_rules('hiperlipidemia_dia', '', 'xss_clean');
		$this->form_validation->set_rules('hiperlipidemia_mes', '', 'xss_clean');
		$this->form_validation->set_rules('hiperlipidemia_anio', '', 'xss_clean');
		$this->form_validation->set_rules('epoc_dia', '', 'xss_clean');
		$this->form_validation->set_rules('epoc_mes', '', 'xss_clean');
		$this->form_validation->set_rules('epoc_anio', '', 'xss_clean');
		$this->form_validation->set_rules('coronaria_dia', '', 'xss_clean');
		$this->form_validation->set_rules('coronaria_mes', '', 'xss_clean');
		$this->form_validation->set_rules('coronaria_anio', '', 'xss_clean');
		$this->form_validation->set_rules('rinitis_dia', '', 'xss_clean');
		$this->form_validation->set_rules('rinitis_mes', '', 'xss_clean');
		$this->form_validation->set_rules('rinitis_anio', '', 'xss_clean');
		$this->form_validation->set_rules('acc_vascular_dia', '', 'xss_clean');
		$this->form_validation->set_rules('acc_vascular_mes', '', 'xss_clean');
		$this->form_validation->set_rules('acc_vascular_anio', '', 'xss_clean');
		$this->form_validation->set_rules('asma_dia', '', 'xss_clean');
		$this->form_validation->set_rules('asma_mes', '', 'xss_clean');
		$this->form_validation->set_rules('asma_anio', '', 'xss_clean');
		$this->form_validation->set_rules('gastritis_dia', '', 'xss_clean');
		$this->form_validation->set_rules('gastritis_mes', '', 'xss_clean');
		$this->form_validation->set_rules('gastritis_anio', '', 'xss_clean');
		$this->form_validation->set_rules('cefaleas_dia', '', 'xss_clean');
		$this->form_validation->set_rules('cefaleas_mes', '', 'xss_clean');
		$this->form_validation->set_rules('cefaleas_anio', '', 'xss_clean');

		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de agregar el formulario de Historia Medica", $registro['subject_id']);
			$this->historial_medico($registro['subject_id'], $registro['etapa']);
		}
		else {
			
			/*estado del form segun lo que se envia*/
			if(
					(!empty($registro['hipertension']) AND (empty($registro['hipertension_dia']) OR empty($registro['hipertension_mes']) OR empty($registro['hipertension_anio'])) )
				OR	(!empty($registro['ulcera']) AND (empty($registro['ulcera_dia']) OR empty($registro['ulcera_mes']) OR empty($registro['ulcera_anio'])) )
				OR	(!empty($registro['diabetes']) AND (empty($registro['diabetes_dia']) OR empty($registro['diabetes_mes']) OR empty($registro['diabetes_anio'])) )
				OR	(!empty($registro['hipo_hipertiroidismo']) AND (empty($registro['hipo_hipertiroidismo_dia']) OR empty($registro['hipo_hipertiroidismo_mes']) OR empty($registro['hipo_hipertiroidismo_anio'])) )
				OR	(!empty($registro['hiperlipidemia']) AND (empty($registro['hiperlipidemia_dia']) OR empty($registro['hiperlipidemia_mes']) OR empty($registro['hiperlipidemia_anio'])) )
				OR	(!empty($registro['epoc']) AND (empty($registro['epoc_dia']) OR empty($registro['epoc_mes']) OR empty($registro['epoc_anio'])) )
				OR	(!empty($registro['coronaria']) AND (empty($registro['coronaria_dia']) OR empty($registro['coronaria_mes']) OR empty($registro['coronaria_anio'])) )
				OR	(!empty($registro['rinitis']) AND (empty($registro['rinitis_dia']) OR empty($registro['rinitis_mes']) OR empty($registro['rinitis_anio'])) )
				OR	(!empty($registro['acc_vascular']) AND (empty($registro['acc_vascular_dia']) OR empty($registro['acc_vascular_mes']) OR empty($registro['acc_vascular_anio'])) )
				OR	(!empty($registro['asma']) AND (empty($registro['asma_dia']) OR empty($registro['asma_mes']) OR empty($registro['asma_anio'])) )
				OR	(!empty($registro['gastritis']) AND (empty($registro['gastritis_dia']) OR empty($registro['gastritis_mes']) OR empty($registro['gastritis_anio'])) )
				OR	(!empty($registro['cefaleas']) AND (empty($registro['cefaleas_dia']) OR empty($registro['cefaleas_mes']) OR empty($registro['cefaleas_anio'])) )
				
				OR	(!empty($registro['alergia']) AND empty($registro['alergia_desc']))
				OR	(!empty($registro['tabaquismo']) AND empty($registro['tabaquismo_desc']))
				OR	(!empty($registro['ingesta_alcohol']) AND empty($registro['ingesta_alcohol_desc']))
				OR	(!empty($registro['drogas']) AND empty($registro['drogas_desc']))
				OR	(!empty($registro['cirugia']) AND empty($registro['cirugia_desc']))
				OR	(!empty($registro['donado_sangre']) AND empty($registro['donado_sangre_desc']))
				OR	(!empty($registro['tratamiento_farma']) AND empty($registro['tratamiento_farma_desc']))
				OR	(!empty($registro['suplemento_dietetico']) AND empty($registro['suplemento_dietetico_desc']))
				OR	(!empty($registro['alzheimer']) AND empty($registro['alzheimer_desc']))
				OR	empty($registro['dia_ea']) OR empty($registro['mes_ea']) OR	empty($registro['anio_ea'])
				OR	(!empty($registro['morbido']) AND empty($registro['morbido_desc']))
				OR $registro['hipertension'] == '' OR $registro['ulcera'] == '' OR $registro['diabetes'] == '' OR $registro['hipo_hipertiroidismo'] == ''
				OR $registro['hiperlipidemia'] == '' OR $registro['epoc'] == '' OR $registro['coronaria'] == '' OR $registro['rinitis'] == ''
				OR $registro['acc_vascular'] == '' OR $registro['asma'] == '' OR $registro['gastritis'] == '' OR $registro['cefaleas'] == ''
				OR $registro['alergia'] == '' OR $registro['tabaquismo'] == '' OR $registro['ingesta_alcohol'] == '' OR $registro['drogas'] == ''
				OR $registro['cirugia'] == '' OR $registro['donado_sangre'] == '' OR $registro['tratamiento_farma'] == '' OR $registro['suplemento_dietetico'] == ''
				OR $registro['alzheimer'] == '' OR $registro['morbido'] == ''
				
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['historial_medico_2_status'] = $estado;
			}						
			elseif($registro['etapa'] == 1){
				$subjet_['historial_medico_1_status'] = $estado;
			}
					

			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Historial_medico');
			$this->Model_Historial_medico->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Historia medica agregada", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function historial_medico_show($subject_id, $etapa){
		$data['contenido'] = 'subject/historial_medico_show';
		$data['titulo'] = 'Historia Medica';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;
		
		$data['dias_ea'] = array(""=>"", "UNK"=>"UNK");
		for($i = 1; $i < 32; $i++){
			$data['dias_ea'][$i] = $i;
		}
		$data['meses_ea'] = array(""=>"", "UNK"=>"UNK");
		for($i = 1; $i < 13; $i++){
			$data['meses_ea'][$i] = $i;
		}
		$data['anio_ea'] = array(""=>"", "UNK"=>"UNK");
		for($i = date('Y'); $i >= 1920 ; $i--){
			$data['anio_ea'][$i] = $i;
		}
		
		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"historial_medico", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->model('Model_Historial_medico');
		$data['list'] = $this->Model_Historial_medico->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		/*querys*/
		$data['querys'] = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"Historia Medica"));

		$this->load->view('template2', $data);
	}

	public function historial_medico_update($subject_id, $etapa){
		$registro = $this->input->post();
		
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('hipertension', '', 'xss_clean');		
		$this->form_validation->set_rules('ulcera', '', 'xss_clean');		
		$this->form_validation->set_rules('diabetes', '', 'xss_clean');		
		$this->form_validation->set_rules('hipo_hipertiroidismo', '', 'xss_clean');		
		$this->form_validation->set_rules('hiperlipidemia', '', 'xss_clean');		
		$this->form_validation->set_rules('epoc', '', 'xss_clean');		
		$this->form_validation->set_rules('coronaria', '', 'xss_clean');		
		$this->form_validation->set_rules('rinitis', '', 'xss_clean');		
		$this->form_validation->set_rules('acc_vascular', '', 'xss_clean');		
		$this->form_validation->set_rules('asma', '', 'xss_clean');		
		$this->form_validation->set_rules('gastritis', '', 'xss_clean');		
		$this->form_validation->set_rules('cefaleas', '', 'xss_clean');		
		$this->form_validation->set_rules('alergia', '', 'xss_clean');
		$this->form_validation->set_rules('alergia_desc', '', 'xss_clean');
		$this->form_validation->set_rules('tabaquismo', '', 'xss_clean');
		$this->form_validation->set_rules('tabaquismo_desc', '', 'xss_clean');
		$this->form_validation->set_rules('ingesta_alcohol', '', 'xss_clean');
		$this->form_validation->set_rules('ingesta_alcohol_desc', '', 'xss_clean');
		$this->form_validation->set_rules('drogas', '', 'xss_clean');
		$this->form_validation->set_rules('drogas_desc', '', 'xss_clean');
		$this->form_validation->set_rules('cirugia', '', 'xss_clean');
		$this->form_validation->set_rules('cirugia_desc', '', 'xss_clean');
		$this->form_validation->set_rules('donado_sangre', '', 'xss_clean');
		$this->form_validation->set_rules('donado_sangre_desc', '', 'xss_clean');
		$this->form_validation->set_rules('tratamiento_farma', '', 'xss_clean');
		$this->form_validation->set_rules('tratamiento_farma_desc', '', 'xss_clean');
		$this->form_validation->set_rules('suplemento_dietetico', '', 'xss_clean');
		$this->form_validation->set_rules('suplemento_dietetico_desc', '', 'xss_clean');
		$this->form_validation->set_rules('alzheimer', '', 'xss_clean');
		$this->form_validation->set_rules('alzheimer_desc', '', 'xss_clean');
		$this->form_validation->set_rules('anio_ea', '', 'xss_clean');
		$this->form_validation->set_rules('mes_ea', '', 'xss_clean');
		$this->form_validation->set_rules('dia_ea', '', 'xss_clean');
		$this->form_validation->set_rules('morbido', '', 'xss_clean');
		$this->form_validation->set_rules('morbido_desc', '', 'xss_clean');
		$this->form_validation->set_rules('hipertension_dia', '', 'xss_clean');
		$this->form_validation->set_rules('hipertension_mes', '', 'xss_clean');
		$this->form_validation->set_rules('hipertension_anio', '', 'xss_clean');
		$this->form_validation->set_rules('ulcera_dia', '', 'xss_clean');
		$this->form_validation->set_rules('ulcera_mes', '', 'xss_clean');
		$this->form_validation->set_rules('ulcera_anio', '', 'xss_clean');
		$this->form_validation->set_rules('diabetes_dia', '', 'xss_clean');
		$this->form_validation->set_rules('diabetes_mes', '', 'xss_clean');
		$this->form_validation->set_rules('diabetes_anio', '', 'xss_clean');
		$this->form_validation->set_rules('hipo_hipertiroidismo_dia', '', 'xss_clean');
		$this->form_validation->set_rules('hipo_hipertiroidismo_mes', '', 'xss_clean');
		$this->form_validation->set_rules('hipo_hipertiroidismo_anio', '', 'xss_clean');
		$this->form_validation->set_rules('hiperlipidemia_dia', '', 'xss_clean');
		$this->form_validation->set_rules('hiperlipidemia_mes', '', 'xss_clean');
		$this->form_validation->set_rules('hiperlipidemia_anio', '', 'xss_clean');
		$this->form_validation->set_rules('epoc_dia', '', 'xss_clean');
		$this->form_validation->set_rules('epoc_mes', '', 'xss_clean');
		$this->form_validation->set_rules('epoc_anio', '', 'xss_clean');
		$this->form_validation->set_rules('coronaria_dia', '', 'xss_clean');
		$this->form_validation->set_rules('coronaria_mes', '', 'xss_clean');
		$this->form_validation->set_rules('coronaria_anio', '', 'xss_clean');
		$this->form_validation->set_rules('rinitis_dia', '', 'xss_clean');
		$this->form_validation->set_rules('rinitis_mes', '', 'xss_clean');
		$this->form_validation->set_rules('rinitis_anio', '', 'xss_clean');
		$this->form_validation->set_rules('acc_vascular_dia', '', 'xss_clean');
		$this->form_validation->set_rules('acc_vascular_mes', '', 'xss_clean');
		$this->form_validation->set_rules('acc_vascular_anio', '', 'xss_clean');
		$this->form_validation->set_rules('asma_dia', '', 'xss_clean');
		$this->form_validation->set_rules('asma_mes', '', 'xss_clean');
		$this->form_validation->set_rules('asma_anio', '', 'xss_clean');
		$this->form_validation->set_rules('gastritis_dia', '', 'xss_clean');
		$this->form_validation->set_rules('gastritis_mes', '', 'xss_clean');
		$this->form_validation->set_rules('gastritis_anio', '', 'xss_clean');
		$this->form_validation->set_rules('cefaleas_dia', '', 'xss_clean');
		$this->form_validation->set_rules('cefaleas_mes', '', 'xss_clean');
		$this->form_validation->set_rules('cefaleas_anio', '', 'xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de actualizar el formulario de Historia Medica", $registro['subject_id']);
			$this->historial_medico($registro['subject_id'], $registro['etapa']);
		}
		else {
			
			/*estado del form segun lo que se envia*/
			if(
					(!empty($registro['hipertension']) AND (empty($registro['hipertension_dia']) OR empty($registro['hipertension_mes']) OR empty($registro['hipertension_anio'])) )
				OR	(!empty($registro['ulcera']) AND (empty($registro['ulcera_dia']) OR empty($registro['ulcera_mes']) OR empty($registro['ulcera_anio'])) )
				OR	(!empty($registro['diabetes']) AND (empty($registro['diabetes_dia']) OR empty($registro['diabetes_mes']) OR empty($registro['diabetes_anio'])) )
				OR	(!empty($registro['hipo_hipertiroidismo']) AND (empty($registro['hipo_hipertiroidismo_dia']) OR empty($registro['hipo_hipertiroidismo_mes']) OR empty($registro['hipo_hipertiroidismo_anio'])) )
				OR	(!empty($registro['hiperlipidemia']) AND (empty($registro['hiperlipidemia_dia']) OR empty($registro['hiperlipidemia_mes']) OR empty($registro['hiperlipidemia_anio'])) )
				OR	(!empty($registro['epoc']) AND (empty($registro['epoc_dia']) OR empty($registro['epoc_mes']) OR empty($registro['epoc_anio'])) )
				OR	(!empty($registro['coronaria']) AND (empty($registro['coronaria_dia']) OR empty($registro['coronaria_mes']) OR empty($registro['coronaria_anio'])) )
				OR	(!empty($registro['rinitis']) AND (empty($registro['rinitis_dia']) OR empty($registro['rinitis_mes']) OR empty($registro['rinitis_anio'])) )
				OR	(!empty($registro['acc_vascular']) AND (empty($registro['acc_vascular_dia']) OR empty($registro['acc_vascular_mes']) OR empty($registro['acc_vascular_anio'])) )
				OR	(!empty($registro['asma']) AND (empty($registro['asma_dia']) OR empty($registro['asma_mes']) OR empty($registro['asma_anio'])) )
				OR	(!empty($registro['gastritis']) AND (empty($registro['gastritis_dia']) OR empty($registro['gastritis_mes']) OR empty($registro['gastritis_anio'])) )
				OR	(!empty($registro['cefaleas']) AND (empty($registro['cefaleas_dia']) OR empty($registro['cefaleas_mes']) OR empty($registro['cefaleas_anio'])) )

				OR	(!empty($registro['alergia']) AND empty($registro['alergia_desc']))
				OR	(!empty($registro['tabaquismo']) AND empty($registro['tabaquismo_desc']))
				OR	(!empty($registro['ingesta_alcohol']) AND empty($registro['ingesta_alcohol_desc']))
				OR	(!empty($registro['drogas']) AND empty($registro['drogas_desc']))
				OR	(!empty($registro['cirugia']) AND empty($registro['cirugia_desc']))
				OR	(!empty($registro['donado_sangre']) AND empty($registro['donado_sangre_desc']))
				OR	(!empty($registro['tratamiento_farma']) AND empty($registro['tratamiento_farma_desc']))
				OR	(!empty($registro['suplemento_dietetico']) AND empty($registro['suplemento_dietetico_desc']))
				OR	(!empty($registro['alzheimer']) AND empty($registro['alzheimer_desc']))
				OR	empty($registro['dia_ea']) OR empty($registro['mes_ea']) OR	empty($registro['anio_ea'])
				OR	(!empty($registro['morbido']) AND empty($registro['morbido_desc']))
				OR $registro['hipertension'] == '' OR $registro['ulcera'] == '' OR $registro['diabetes'] == '' OR $registro['hipo_hipertiroidismo'] == ''
				OR $registro['hiperlipidemia'] == '' OR $registro['epoc'] == '' OR $registro['coronaria'] == '' OR $registro['rinitis'] == ''
				OR $registro['acc_vascular'] == '' OR $registro['asma'] == '' OR $registro['gastritis'] == '' OR $registro['cefaleas'] == ''
				OR $registro['alergia'] == '' OR $registro['tabaquismo'] == '' OR $registro['ingesta_alcohol'] == '' OR $registro['drogas'] == ''
				OR $registro['cirugia'] == '' OR $registro['donado_sangre'] == '' OR $registro['tratamiento_farma'] == '' OR $registro['suplemento_dietetico'] == ''
				OR $registro['alzheimer'] == '' OR $registro['morbido'] == ''
				
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['historial_medico_2_status'] = $estado;
			}						
			elseif($registro['etapa'] == 1){
				$subjet_['historial_medico_1_status'] = $estado;
			}
			
			
			
			$registro['status'] = $estado;			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Historial_medico');
			$this->Model_Historial_medico->update($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Historia medica actualizada", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function historial_medico_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de historial medico", $registro['subject_id']);
			$this->historial_medico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Historial_medico');
			$this->Model_Historial_medico->update($registro);
			$this->auditlib->save_audit("Veirfico el formulario de historial medico", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 1) {
				$this->Model_Subject->update(array('historial_medico_1_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('historial_medico_2_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}			
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function historial_medico_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de historial medico", $registro['subject_id']);
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
			$this->auditlib->save_audit("Firmo el formulario de historial medico", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 1) {
				$this->Model_Subject->update(array('historial_medico_1_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('historial_medico_2_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}			
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function historial_medico_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de historial medico", $registro['subject_id']);
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
			$this->auditlib->save_audit("Cerro el formulario de historial medico", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 1) {
				$this->Model_Subject->update(array('historial_medico_1_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('historial_medico_2_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}			
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	/*----------------------------------------------------- ADAS COG ------------------------------------------------------------------------*/

	public function adas($subject_id, $etapa){
		//2-4-5-6
		$data['contenido'] = 'subject/adas';
		$data['titulo'] = 'ADAS COG';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;
		$data['de0_a5'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
		$data['de0_a4'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4');
		$data['de0_a8'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8');
		$data['de0_a10'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10');
		$data['de0_a17'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10',
								'11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17');
		$data['de0_a22'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10',
								'11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20',
								'21'=>'21','22'=>'22');
		$data['de0_a24'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10',
								'11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20',
								'21'=>'21','22'=>'22','23'=>'23','24'=>'24');
		$data['horas'] = array(''=>'');
		$data['minutos'] = array(''=>'');
		for ($i = 0; $i < 24; $i ++) {
			$val = $i;
			if (strlen($i) < 2) $val = '0' . $i;
			$data['horas'][$val] = $val;
		}

		for ($i = 0; $i <= 59; $i ++) {
			$val = $i;
			if (strlen($i) < 2) $val = '0' . $i;
			$data['minutos'][$val] = $val;
		}
		
		$data['no_administro'] = array(""=>"",
			"El paciente se nego"=>"El paciente se negó",
			"El paciente no pudo hacerlo por motivos fisicos"=>"El paciente no pudo hacerlo por motivos físicos",
			"EL paciente no pudo por motivos cognitivos" => "EL paciente no pudo por motivos cognitivos",
			"No se realizo (por motivos que no son fisicos ni cognitivos)" =>"No se realizó (por motivos que no son físicos ni cognitivos)"
		);

		$data['puntaje'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');

		$this->load->view('template', $data);
	}

	public function adas_insert(){
		$registro = $this->input->post();
		
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('puntaje_total', '', 'xss_clean');
		$this->form_validation->set_rules('palabras_recordadas_1', '', 'xss_clean');
		$this->form_validation->set_rules('palabras_no_recordadas_1', '', 'xss_clean');
		$this->form_validation->set_rules('palabras_recordadas_2', '', 'xss_clean');
		$this->form_validation->set_rules('palabras_no_recordadas_2', '', 'xss_clean');
		$this->form_validation->set_rules('palabras_recordadas_3', '', 'xss_clean');
		$this->form_validation->set_rules('palabras_no_recordadas_3', '', 'xss_clean');
		$this->form_validation->set_rules('hora_finalizacion_hora', '', 'xss_clean');
		$this->form_validation->set_rules('hora_finalizacion_minuto', '', 'xss_clean');
		$this->form_validation->set_rules('no_administro_1', '', 'xss_clean');
		$this->form_validation->set_rules('puntaje_total_1', '', 'xss_clean');		
		$this->form_validation->set_rules('total_correctas_2', '', 'xss_clean');		
		$this->form_validation->set_rules('total_incorrectas_2', '', 'xss_clean');				
		$this->form_validation->set_rules('no_administro_2', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_2', '', 'xss_clean');
		$this->form_validation->set_rules('total_correctas_3', '', 'xss_clean');
		$this->form_validation->set_rules('total_incorrectas_3', '', 'xss_clean');		
		$this->form_validation->set_rules('paciente_no_dibujo_3	', '', 'xss_clean');				
		$this->form_validation->set_rules('puntuacion_3', '', 'xss_clean');
		$this->form_validation->set_rules('total_recordadas_4', '', 'xss_clean');
		$this->form_validation->set_rules('total_no_recordadas_4', '', 'xss_clean');		
		$this->form_validation->set_rules('puntuacion_4', '', 'xss_clean');
		$this->form_validation->set_rules('hora_finalizacion_4_hora', '', 'xss_clean');
		$this->form_validation->set_rules('hora_finalizacion_4_minuto', '', 'xss_clean');		
		$this->form_validation->set_rules('total_correctas_5', '', 'xss_clean');
		$this->form_validation->set_rules('total_incorrectas_5', '', 'xss_clean');
		$this->form_validation->set_rules('no_administro_5', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_5', '', 'xss_clean');				
		$this->form_validation->set_rules('total_correctas_6', '', 'xss_clean');
		$this->form_validation->set_rules('no_administro_6', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_6', '', 'xss_clean');
		$this->form_validation->set_rules('total_incorrectas_6', '', 'xss_clean');				
		$this->form_validation->set_rules('total_correctas_7', '', 'xss_clean');
		$this->form_validation->set_rules('total_incorrectas_7', '', 'xss_clean');
		$this->form_validation->set_rules('no_administro_7', '', 'xss_clean');		
		$this->form_validation->set_rules('puntuacion_7', '', 'xss_clean');
		$this->form_validation->set_rules('total_correctas_8', '', 'xss_clean');
		$this->form_validation->set_rules('total_incorrectas_8', '', 'xss_clean');
		$this->form_validation->set_rules('cantidad_recordadas_8', '', 'xss_clean');
		$this->form_validation->set_rules('no_administro_8', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_8', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_9', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_10', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_11', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_12', '', 'xss_clean');
		
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de agregar el formulario de ADAS COG", $registro['subject_id']);
			$this->adas($registro['subject_id'], $registro['etapa']);
		}
		else {
			
			/*Estado segun campos*/
			if(
				isset($registro['realizado']) AND $registro['realizado'] == 1
				AND
				(
					$registro['puntaje_total'] == '' OR $registro['palabras_recordadas_1'] == '' OR $registro['palabras_no_recordadas_1'] == ''
					OR $registro['palabras_recordadas_2'] == ''	OR $registro['palabras_no_recordadas_2'] == '' OR $registro['palabras_recordadas_3'] == ''
					OR $registro['palabras_no_recordadas_3'] == '' OR $registro['hora_finalizacion_hora'] == '' OR $registro['hora_finalizacion_minuto'] == ''
					OR $registro['puntaje_total_1'] == '' OR $registro['total_correctas_2'] == ''		
					OR $registro['total_incorrectas_2'] == '' OR $registro['puntuacion_2'] == ''
					OR $registro['total_correctas_3'] == '' OR $registro['total_incorrectas_3'] == '' OR $registro['puntuacion_3'] == ''
					OR $registro['total_recordadas_4'] == '' OR $registro['total_no_recordadas_4'] == '' OR $registro['puntuacion_4'] == ''
					OR $registro['hora_finalizacion_4_hora'] == '' OR $registro['hora_finalizacion_4_minuto'] == '' OR $registro['total_correctas_5'] == ''
					OR $registro['total_incorrectas_5'] == '' OR $registro['puntuacion_5'] == ''				
					OR $registro['total_correctas_6'] == ''	OR $registro['puntuacion_6'] == ''
					OR $registro['total_incorrectas_6'] == '' OR $registro['total_correctas_7'] == '' OR $registro['total_incorrectas_7'] == ''
					OR $registro['puntuacion_7'] == '' OR $registro['total_correctas_8'] == ''
					OR $registro['total_incorrectas_8'] == '' OR $registro['cantidad_recordadas_8'] == '' 
					OR $registro['puntuacion_8'] == '' OR $registro['puntuacion_9'] == '' OR $registro['puntuacion_10'] == ''
					OR $registro['puntuacion_11'] == '' OR $registro['puntuacion_12'] == ''	
					
				)
			){
				$estado = 'Error';
			}	
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['adas_2_status'] = $estado;
			}						
			elseif($registro['etapa'] == 4){
				$subjet_['adas_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['adas_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['adas_6_status'] = $estado;
			}
			
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}

			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Adas');
			$this->Model_Adas->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("ADAS COG agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function adas_show($subject_id, $etapa){
		$data['contenido'] = 'subject/adas_show';
		$data['titulo'] = 'ADAS COG';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;

		$data['de0_a5'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
		$data['de0_a4'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4');
		$data['de0_a8'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8');
		$data['de0_a10'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10');
		$data['de0_a17'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10',
								'11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17');
		$data['de0_a22'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10',
								'11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20',
								'21'=>'21','22'=>'22');
		$data['de0_a24'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10',
								'11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20',
								'21'=>'21','22'=>'22','23'=>'23','24'=>'24');
		
		$data['horas'] = array(''=>'');
		$data['minutos'] = array(''=>'');
		for ($i = 0; $i < 24; $i ++) {
			$val = $i;
			if (strlen($i) < 2) $val = '0' . $i;
			$data['horas'][$val] = $val;
		}

		for ($i = 0; $i <= 59; $i ++) {
			$val = $i;
			if (strlen($i) < 2) $val = '0' . $i;
			$data['minutos'][$val] = $val;
		}

		$data['no_administro'] = array(""=>"",
			"El paciente se nego"=>"El paciente se negó",
			"El paciente no pudo hacerlo por motivos fisicos"=>"El paciente no pudo hacerlo por motivos físicos",
			"EL paciente no pudo por motivos cognitivos" => "EL paciente no pudo por motivos cognitivos",
			"No se realizo (por motivos que no son fisicos ni cognitivos)" =>"No se realizó (por motivos que no son físicos ni cognitivos)"
		);

		$data['puntaje'] = array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');

		$this->load->model('Model_Adas');
		$data['list'] = $this->Model_Adas->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"adas", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->view('template', $data);
	}

	public function adas_update(){
		$registro = $this->input->post();
		
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('realizado', '', 'required|xss_clean');
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('puntaje_total', '', 'xss_clean');
		$this->form_validation->set_rules('palabras_recordadas_1', '', 'xss_clean');
		$this->form_validation->set_rules('palabras_no_recordadas_1', '', 'xss_clean');
		$this->form_validation->set_rules('palabras_recordadas_2', '', 'xss_clean');
		$this->form_validation->set_rules('palabras_no_recordadas_2', '', 'xss_clean');
		$this->form_validation->set_rules('palabras_recordadas_3', '', 'xss_clean');
		$this->form_validation->set_rules('palabras_no_recordadas_3', '', 'xss_clean');
		$this->form_validation->set_rules('hora_finalizacion_hora', '', 'xss_clean');
		$this->form_validation->set_rules('hora_finalizacion_minuto', '', 'xss_clean');
		$this->form_validation->set_rules('no_administro_1', '', 'xss_clean');
		$this->form_validation->set_rules('puntaje_total_1', '', 'xss_clean');		
		$this->form_validation->set_rules('total_correctas_2', '', 'xss_clean');		
		$this->form_validation->set_rules('total_incorrectas_2', '', 'xss_clean');				
		$this->form_validation->set_rules('no_administro_2', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_2', '', 'xss_clean');
		$this->form_validation->set_rules('total_correctas_3', '', 'xss_clean');
		$this->form_validation->set_rules('total_incorrectas_3', '', 'xss_clean');		
		$this->form_validation->set_rules('paciente_no_dibujo_3	', '', 'xss_clean');				
		$this->form_validation->set_rules('puntuacion_3', '', 'xss_clean');
		$this->form_validation->set_rules('total_recordadas_4', '', 'xss_clean');
		$this->form_validation->set_rules('total_no_recordadas_4', '', 'xss_clean');		
		$this->form_validation->set_rules('puntuacion_4', '', 'xss_clean');
		$this->form_validation->set_rules('hora_finalizacion_4_hora', '', 'xss_clean');
		$this->form_validation->set_rules('hora_finalizacion_4_minuto', '', 'xss_clean');		
		$this->form_validation->set_rules('total_correctas_5', '', 'xss_clean');
		$this->form_validation->set_rules('total_incorrectas_5', '', 'xss_clean');
		$this->form_validation->set_rules('no_administro_5', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_5', '', 'xss_clean');				
		$this->form_validation->set_rules('total_correctas_6', '', 'xss_clean');
		$this->form_validation->set_rules('no_administro_6', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_6', '', 'xss_clean');
		$this->form_validation->set_rules('total_incorrectas_6', '', 'xss_clean');				
		$this->form_validation->set_rules('total_correctas_7', '', 'xss_clean');
		$this->form_validation->set_rules('total_incorrectas_7', '', 'xss_clean');
		$this->form_validation->set_rules('no_administro_7', '', 'xss_clean');		
		$this->form_validation->set_rules('puntuacion_7', '', 'xss_clean');
		$this->form_validation->set_rules('total_correctas_8', '', 'xss_clean');
		$this->form_validation->set_rules('total_incorrectas_8', '', 'xss_clean');
		$this->form_validation->set_rules('cantidad_recordadas_8', '', 'xss_clean');
		$this->form_validation->set_rules('no_administro_8', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_8', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_9', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_10', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_11', '', 'xss_clean');
		$this->form_validation->set_rules('puntuacion_12', '', 'xss_clean');	
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de actualizar el formulario de ADAS COG", $registro['subject_id']);
			$this->adas_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			
			/*Estado segun campos*/
			if(
				isset($registro['realizado']) AND $registro['realizado'] == 1
				AND
				(
					$registro['puntaje_total'] == '' OR $registro['palabras_recordadas_1'] == '' OR $registro['palabras_no_recordadas_1'] == ''
					OR $registro['palabras_recordadas_2'] == ''	OR $registro['palabras_no_recordadas_2'] == '' OR $registro['palabras_recordadas_3'] == ''
					OR $registro['palabras_no_recordadas_3'] == '' OR $registro['hora_finalizacion_hora'] == '' OR $registro['hora_finalizacion_minuto'] == ''
					OR $registro['puntaje_total_1'] == '' OR $registro['total_correctas_2'] == ''		
					OR $registro['total_incorrectas_2'] == '' OR $registro['puntuacion_2'] == ''
					OR $registro['total_correctas_3'] == '' OR $registro['total_incorrectas_3'] == '' OR $registro['puntuacion_3'] == ''
					OR $registro['total_recordadas_4'] == '' OR $registro['total_no_recordadas_4'] == '' OR $registro['puntuacion_4'] == ''
					OR $registro['hora_finalizacion_4_hora'] == '' OR $registro['hora_finalizacion_4_minuto'] == '' OR $registro['total_correctas_5'] == ''
					OR $registro['total_incorrectas_5'] == '' OR $registro['puntuacion_5'] == ''				
					OR $registro['total_correctas_6'] == ''	OR $registro['puntuacion_6'] == ''
					OR $registro['total_incorrectas_6'] == '' OR $registro['total_correctas_7'] == '' OR $registro['total_incorrectas_7'] == ''
					OR $registro['puntuacion_7'] == '' OR $registro['total_correctas_8'] == ''
					OR $registro['total_incorrectas_8'] == '' OR $registro['cantidad_recordadas_8'] == '' 
					OR $registro['puntuacion_8'] == '' OR $registro['puntuacion_9'] == '' OR $registro['puntuacion_10'] == ''
					OR $registro['puntuacion_11'] == '' OR $registro['puntuacion_12'] == ''	
				)
			){
				$estado = 'Error';
			}	
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['adas_2_status'] = $estado;
			}						
			elseif($registro['etapa'] == 4){
				$subjet_['adas_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['adas_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['adas_6_status'] = $estado;
			}
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}

			$registro['status'] = $estado;			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Adas');
			$this->Model_Adas->update($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("ADAS COG actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function adas_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de ADAS COG", $registro['subject_id']);
			$this->adas_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Adas');
			$this->Model_Adas->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de ADAS COG", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('adas_2_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}					
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('adas_4_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('adas_5_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('adas_6_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function adas_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de ADAS COG", $registro['subject_id']);
			$this->adas_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Adas');
			$this->Model_Adas->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de ADAS COG", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('adas_2_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}						
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('adas_4_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('adas_5_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('adas_6_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function adas_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de ADAS COG", $registro['subject_id']);
			$this->adas_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Adas');
			$this->Model_Adas->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de ADAS COG", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('adas_2_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}					
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('adas_4_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('adas_5_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('adas_6_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	/*----------------------------------------------------- Prueba de restas seriadas --------------------------------------------------------*/	
	public function restas($subject_id, $etapa){
		$data['contenido'] = 'subject/restas';
		$data['titulo'] = 'Restas Seriadas';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;

		$this->load->view('template', $data);
	}

	public function restas_insert(){
		$registro = $this->input->post();
		
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');

		

		$this->form_validation->set_rules('realizado_alt', '', 'xss_clean');
		$this->form_validation->set_rules('fecha_alt', '', 'xss_clean');
		$this->form_validation->set_rules('resta_1_alt', '', 'xss_clean');
		$this->form_validation->set_rules('resta_2_alt', '', 'xss_clean');
		$this->form_validation->set_rules('resta_3_alt', '', 'xss_clean');
		$this->form_validation->set_rules('resta_4_alt', '', 'xss_clean');
		$this->form_validation->set_rules('resta_5_alt', '', 'xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de ingresar el formulario de Restas Seriadas", $registro['subject_id']);
			$this->restas($registro['subject_id'], $registro['etapa']);
		}
		else {

			if(
				
				isset($registro['realizado_alt']) AND $registro['realizado_alt'] == 1 AND 
				(
					!isset($registro['fecha_alt']) OR empty($registro['fecha_alt'])
				)
				
				OR				
				!isset($registro['realizado_alt'])
								
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['restas_2_status'] = $estado;
			}						
			elseif($registro['etapa'] == 4){
				$subjet_['restas_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['restas_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['restas_6_status'] = $estado;
			}
			

			
			if(!isset($registro['resta_alt_1'])){
				$registro['resta_alt_1'] = 0;
			}
			if(!isset($registro['resta_alt_2'])){
				$registro['resta_alt_2'] = 0;
			}
			if(!isset($registro['resta_alt_3'])){
				$registro['resta_alt_3'] = 0;
			}
			if(!isset($registro['resta_alt_4'])){
				$registro['resta_alt_4'] = 0;
			}
			if(!isset($registro['resta_alt_5'])){
				$registro['resta_alt_5'] = 0;
			}
			if(!empty($registro['fecha_alt'])){
				$registro['fecha_alt'] = $this->convertirFecha($registro['fecha_alt']);
			}
			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Restas');
			$this->Model_Restas->insert($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Restas seriadas agregadas", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);
		}

	}

	public function restas_show($subject_id, $etapa){
		$data['contenido'] = 'subject/restas_show';
		$data['titulo'] = 'Restas Seriadas';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		$data['etapa'] = $etapa;	
		

		$this->load->model('Model_Restas');
		$data['list'] = $this->Model_Restas->allWhereArray(array('subject_id'=>$subject_id, 'etapa'=>$etapa));

		/*querys abiertos para el formulario*/
		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"restas", "etapa"=>$etapa, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->view('template', $data);
	}

	public function restas_update(){
		$registro = $this->input->post();
		
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('etapa', '', 'required|xss_clean');
		$this->form_validation->set_rules('id', '', 'required|xss_clean');

		

		$this->form_validation->set_rules('realizado_alt', '', 'xss_clean');
		$this->form_validation->set_rules('fecha_alt', '', 'xss_clean');
		$this->form_validation->set_rules('resta_1_alt', '', 'xss_clean');
		$this->form_validation->set_rules('resta_2_alt', '', 'xss_clean');
		$this->form_validation->set_rules('resta_3_alt', '', 'xss_clean');
		$this->form_validation->set_rules('resta_4_alt', '', 'xss_clean');
		$this->form_validation->set_rules('resta_5_alt', '', 'xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de actualizar el formulario de Restas Seriadas", $registro['subject_id']);
			$this->restas_show($registro['subject_id'], $registro['etapa']);
		}
		else {

			if(
				
				isset($registro['realizado_alt']) AND $registro['realizado_alt'] == 1 AND 
				(
					!isset($registro['fecha_alt']) OR empty($registro['fecha_alt'])
				)
				
				OR				
				!isset($registro['realizado_alt'])
								
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if($registro['etapa'] == 2){
				$subjet_['restas_2_status'] = $estado;
			}						
			elseif($registro['etapa'] == 4){
				$subjet_['restas_4_status'] = $estado;
			}
			elseif($registro['etapa'] == 5){
				$subjet_['restas_5_status'] = $estado;
			}
			elseif($registro['etapa'] == 6){
				$subjet_['restas_6_status'] = $estado;
			}
			
			
			if(!isset($registro['resta_alt_1'])){
				$registro['resta_alt_1'] = 0;
			}
			if(!isset($registro['resta_alt_2'])){
				$registro['resta_alt_2'] = 0;
			}
			if(!isset($registro['resta_alt_3'])){
				$registro['resta_alt_3'] = 0;
			}
			if(!isset($registro['resta_alt_4'])){
				$registro['resta_alt_4'] = 0;
			}
			if(!isset($registro['resta_alt_5'])){
				$registro['resta_alt_5'] = 0;
			}
			if(!empty($registro['fecha_alt'])){
				$registro['fecha_alt'] = $this->convertirFecha($registro['fecha_alt']);
			}
			$registro['status'] = $estado;			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Restas');
			$this->Model_Restas->update($registro);

			/*Actualizamos el estado en el sujeto*/
			$subjet_['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subjet_);

			$this->auditlib->save_audit("Restas seriadas actualizada", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);
		}

	}

	public function restas_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de restas seriadas", $registro['subject_id']);
			$this->restas_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Restas');
			$this->Model_Restas->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de restas seriadas", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('restas_2_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}					
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('restas_4_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('restas_5_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('restas_6_status'=>'Form Approved by Monitor','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function restas_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de restas seriadas", $registro['subject_id']);
			$this->restas_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Restas');
			$this->Model_Restas->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de restas seriadas", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('restas_2_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}						
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('restas_4_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('restas_5_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('restas_6_status'=>'Document Approved and Signed by PI','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function restas_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');
		$this->form_validation->set_rules('etapa', 'Etapa', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de restas seriadas", $registro['subject_id']);
			$this->restas_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Restas');
			$this->Model_Restas->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de restas seriadas", $registro['subject_id']);			
			
			/*Actualizar estado en el sujeto*/			
			if (isset($registro['etapa']) AND $registro['etapa'] == 2) {
				$this->Model_Subject->update(array('restas_2_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}						
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 4) {
				$this->Model_Subject->update(array('restas_4_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 5) {
				$this->Model_Subject->update(array('restas_5_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}
			elseif (isset($registro['etapa']) AND $registro['etapa'] == 6) {
				$this->Model_Subject->update(array('restas_6_status'=>'Form Approved and Locked','id'=> $registro['subject_id']));
			}

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function convertirFecha($fecha){
		$fecha_1 = trim($fecha);
		$fecha = str_replace("/", "-", $fecha_1);
		$fecha_1 = date("Y-m-d", strtotime($fecha));

		return $fecha_1;
	}
	
	/*--------------------------------------------Signos Vitales Adicional-------------------------------------------------------*/
	public function signos_vitales_adicional($subject_id){
		$data['contenido'] = 'subject/adicional/signos_vitales';
		$data['titulo'] = 'Signos Vitales';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		
		$this->load->model('Model_Signos_vitales_adicional');
		$data['lista'] = $this->Model_Signos_vitales_adicional->allWhereArray(array('subject_id'=>$subject_id));

		$this->load->view('template',$data);
	}

	public function signos_vitales_adicional_agregar($subject_id){
		$data['contenido'] = 'subject/adicional/signos_vitales_agregar';
		$data['titulo'] = 'Signos Vitales';
		$data['subject'] = $this->Model_Subject->find($subject_id);				

		$data['etapas'] = array(""=>"",
						"Seleccion - Visita Basal"=>"Selección - Visita Basal",
						"Visita Basal - Semana 4"=>"Visita Basal - Semana 4",
						"Semana 4 - Semana 12"=>"Semana 4 – Semana 12",
						"Semana 12 - Semana 24"=>"Semana 12 - Semana 24"
						);	

		$this->load->view('template',$data);
	}

	public function signos_vitales_adicional_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');		
		$this->form_validation->set_rules('fecha', '', 'xss_clean');		
		$this->form_validation->set_rules('etapa', '', 'xss_clean');
		$this->form_validation->set_rules('presion_sistolica', '', 'xss_clean');
		$this->form_validation->set_rules('presion_diastolica', '', 'xss_clean');
		$this->form_validation->set_rules('frecuencia_cardiaca', '', 'xss_clean');
		$this->form_validation->set_rules('frecuencia_respiratoria', '', 'xss_clean');
		$this->form_validation->set_rules('temperatura', '', 'xss_clean');
		$this->form_validation->set_rules('peso', '', 'xss_clean');
		$this->form_validation->set_rules('observaciones', '', 'xss_clean');
		
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar signos vitales", $registro['subject_id']);
			$this->signos_vitales_adicional_agregar($registro['subject_id']);

		}else{			


			if(
				
				empty($registro['fecha']) OR empty($registro['presion_sistolica']) OR $registro['etapa'] == ''
				OR empty($registro['presion_diastolica']) OR empty($registro['frecuencia_cardiaca']) OR empty($registro['frecuencia_respiratoria']) 
				OR empty($registro['temperatura']) OR empty($registro['peso'])
				
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}
			
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			

			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Signos_vitales_adicional');
			$this->Model_Signos_vitales_adicional->insert($registro);			

			$this->auditlib->save_audit("Signos vitales adicional agregados", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function signos_vitales_adicional_show($subject_id, $id){
		$data['contenido'] = 'subject/adicional/signos_vitales_show';
		$data['titulo'] = 'Signos Vitales';
		$data['subject'] = $this->Model_Subject->find($subject_id);				

		$this->load->model('Model_Signos_vitales_adicional');
		$data['list'] = $this->Model_Signos_vitales_adicional->allWhereArray(array('subject_id'=>$subject_id, 'id'=>$id));	

		$data['etapas'] = array(""=>"",
						"Seleccion - Visita Basal"=>"Selección - Visita Basal",
						"Visita Basal - Semana 4"=>"Visita Basal - Semana 4",
						"Semana 4 - Semana 12"=>"Semana 4 – Semana 12",
						"Semana 12 - Semana 24"=>"Semana 12 - Semana 24"
						);	

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form_id"=>$id, "status"=>'Abierto'));
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}


		$this->load->view('template',$data);
	}

	public function signos_vitales_adicional_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');		
		$this->form_validation->set_rules('fecha', '', 'xss_clean');		
		$this->form_validation->set_rules('etapa', '', 'xss_clean');
		$this->form_validation->set_rules('presion_sistolica', '', 'xss_clean');
		$this->form_validation->set_rules('presion_diastolica', '', 'xss_clean');
		$this->form_validation->set_rules('frecuencia_cardiaca', '', 'xss_clean');
		$this->form_validation->set_rules('frecuencia_respiratoria', '', 'xss_clean');
		$this->form_validation->set_rules('temperatura', '', 'xss_clean');
		$this->form_validation->set_rules('peso', '', 'xss_clean');
		$this->form_validation->set_rules('observaciones', '', 'xss_clean');
		
		
		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar signos vitales", $registro['subject_id']);
			$this->signos_vitales_adicional_agregar($registro['subject_id']);

		}else{			


			if(
				
				empty($registro['fecha']) OR empty($registro['presion_sistolica']) OR $registro['etapa'] == ''
				OR empty($registro['presion_diastolica']) OR empty($registro['frecuencia_cardiaca']) OR empty($registro['frecuencia_respiratoria']) 
				OR empty($registro['temperatura']) OR empty($registro['peso'])
				
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}
			
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			

			$registro['status'] = $estado;			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Signos_vitales_adicional');
			$this->Model_Signos_vitales_adicional->update($registro);			

			$this->auditlib->save_audit("Signos vitales adicional agregados", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}


	public function signos_vitales_adicional_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de Signos Vitales", $registro['subject_id']);
			$this->signos_vitales_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Signos_vitales_adicional');
			$this->Model_Signos_vitales_adicional->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de Signos Vitales adicionale", $registro['subject_id']);						
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function signos_vitales_adicional_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Signos Vitales", $registro['subject_id']);
			$this->signos_vitales_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Signos_vitales_adicional');
			$this->Model_Signos_vitales_adicional->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de Signos Vitales Adicional", $registro['subject_id']);			
			
			
			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function signos_vitales_adicional_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

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

			$this->load->model('Model_Signos_vitales_adicional');
			$this->Model_Signos_vitales_adicional->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de Signos Vitales Adicional", $registro['subject_id']);						

			redirect('subject/grid/'.$registro['subject_id']);
		}

	}

	
	/*-------------------------------ECG Adicional----------------------------------------------------------------------------------*/
	public function ecg_adicional($subject_id){

		$data['contenido'] = 'subject/adicional/ecg';
		$data['titulo'] = 'ECG';
		$data['subject'] = $this->Model_Subject->find($subject_id);						

		$this->load->model('Model_Ecg_adicional');
		$data['lista'] = $this->Model_Ecg_adicional->allWhereArray(array('subject_id'=>$subject_id));


		$this->load->view('template',$data);
	}

	public function ecg_adicional_agregar($subject_id){
		$data['contenido'] = 'subject/adicional/ecg_agregar';
		$data['titulo'] = 'ECG';
		$data['subject'] = $this->Model_Subject->find($subject_id);				

		$data['etapas'] = array(""=>"",
						"Seleccion - Visita Basal"=>"Selección - Visita Basal",
						"Visita Basal - Semana 4"=>"Visita Basal - Semana 4",
						"Semana 4 - Semana 12"=>"Semana 4 – Semana 12",
						"Semana 12 - Semana 24"=>"Semana 12 - Semana 24"
						);	

		$this->load->view('template',$data);
	}

	public function ecg_adicional_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');		
	
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('etapa', '', 'xss_clean');
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
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar estudio ECG", $registro['subject_id']);
			$this->ecg($registro['subject_id']);

		}else{

			
			if(
				empty($registro['fecha'])  OR $registro['etapa'] == ''
				OR empty($registro['ritmo_sinusal']) OR $registro['ritmo_sinusal_normal_anormal'] == ''
				OR empty($registro['fc']) OR !isset($registro['fc_normal_anormal']) OR (isset($registro['fc_normal_anormal']) AND $registro['fc_normal_anormal']  == '')
				OR empty($registro['pr']) OR !isset($registro['pr_normal_anormal']) OR (isset($registro['pr_normal_anormal']) AND $registro['pr_normal_anormal'] == '' )
				OR empty($registro['qrs']) OR !isset($registro['qrs_normal_anormal']) OR (isset($registro['qrs_normal_anormal']) AND $registro['qrs_normal_anormal'] == '') 
				OR empty($registro['qt']) OR !isset($registro['qt_normal_anormal']) OR (isset($registro['qt_normal_anormal']) AND $registro['qt_normal_anormal'] == '') 
				OR empty($registro['qtc']) OR !isset($registro['qtc_normal_anormal']) OR (isset($registro['qtc_normal_anormal']) AND $registro['qtc_normal_anormal'] == '')
				OR empty($registro['qrs2']) OR !isset($registro['qrs2_normal_anormal']) OR (isset($registro['qrs2_normal_anormal']) AND $registro['qrs2_normal_anormal'] == '' )
				OR !isset($registro['interpretacion_ecg']) OR (isset($registro['interpretacion_ecg']) AND $registro['interpretacion_ecg'] == '')
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Ecg_adicional');
			$this->Model_Ecg_adicional->insert($registro);			

			$this->auditlib->save_audit("ECG adicional agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function ecg_adicional_show($subject_id, $id){
		$data['contenido'] = 'subject/adicional/ecg_show';
		$data['titulo'] = 'ECG';
		$data['subject'] = $this->Model_Subject->find($subject_id);						
		
		$this->load->model('Model_Ecg_adicional');
		$data['list'] = $this->Model_Ecg_adicional->allWhereArray(array('subject_id'=>$subject_id, 'id'=>$id));

		$data['etapas'] = array(""=>"",
						"Seleccion - Visita Basal"=>"Selección - Visita Basal",
						"Visita Basal - Semana 4"=>"Visita Basal - Semana 4",
						"Semana 4 - Semana 12"=>"Semana 4 – Semana 12",
						"Semana 12 - Semana 24"=>"Semana 12 - Semana 24"
						);	

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"ecg_adicional", 'form_id'=>$id, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->view('template',$data);
	}

	public function ecg_adicional_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');		
	
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('etapa', '', 'xss_clean');
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
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de actualizar estudio ECG adicional", $registro['subject_id']);
			$this->ecg($registro['subject_id']);

		}else{

			
			if(
				empty($registro['fecha'])  OR $registro['etapa'] == ''
				OR empty($registro['ritmo_sinusal']) OR $registro['ritmo_sinusal_normal_anormal'] == ''
				OR empty($registro['fc']) OR !isset($registro['fc_normal_anormal']) OR (isset($registro['fc_normal_anormal']) AND $registro['fc_normal_anormal']  == '')
				OR empty($registro['pr']) OR !isset($registro['pr_normal_anormal']) OR (isset($registro['pr_normal_anormal']) AND $registro['pr_normal_anormal'] == '' )
				OR empty($registro['qrs']) OR !isset($registro['qrs_normal_anormal']) OR (isset($registro['qrs_normal_anormal']) AND $registro['qrs_normal_anormal'] == '') 
				OR empty($registro['qt']) OR !isset($registro['qt_normal_anormal']) OR (isset($registro['qt_normal_anormal']) AND $registro['qt_normal_anormal'] == '') 
				OR empty($registro['qtc']) OR !isset($registro['qtc_normal_anormal']) OR (isset($registro['qtc_normal_anormal']) AND $registro['qtc_normal_anormal'] == '')
				OR empty($registro['qrs2']) OR !isset($registro['qrs2_normal_anormal']) OR (isset($registro['qrs2_normal_anormal']) AND $registro['qrs2_normal_anormal'] == '' )
				OR !isset($registro['interpretacion_ecg']) OR (isset($registro['interpretacion_ecg']) AND $registro['interpretacion_ecg'] == '')
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			$registro['status'] = $estado;			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Ecg_adicional');
			$this->Model_Ecg_adicional->update($registro);			

			$this->auditlib->save_audit("ECG adicional actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}
	}

	public function ecg_adicional_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de ECG Adicional", $registro['subject_id']);
			$this->ecg_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Ecg_adicional');
			$this->Model_Ecg_adicional->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de ECG Adicional", $registro['subject_id']);
			
			
			
			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function ecg_adicional_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de ECG Adicional", $registro['subject_id']);
			$this->ecg_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Ecg_adicional');
			$this->Model_Ecg_adicional->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de ECG Adicional", $registro['subject_id']);		
			
			
			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function ecg_adicional_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de ECG Adicional", $registro['subject_id']);
			$this->ecg_show($registro['subject_id']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Ecg_adicional');
			$this->Model_Ecg_adicional->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de ECG Adicional", $registro['subject_id']);					
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	/*-------------------------------Examen Fisico Adicional -----------------------------------------------------------------------*/
	public function examen_fisico_adicional($subject_id){
		$data['contenido'] = 'subject/adicional/examen_fisico';
		$data['titulo'] = 'Examen Fisico';
		$data['subject'] = $this->Model_Subject->find($subject_id);		


		$this->load->model('Model_Examen_fisico_adicional');
		$data['lista'] = $this->Model_Examen_fisico_adicional->allWhereArray(array('subject_id'=>$subject_id));

		$this->load->view('template', $data);
	}

	public function examen_fisico_adicional_agregar($subject_id){
		$data['contenido'] = 'subject/adicional/examen_fisico_agregar';
		$data['titulo'] = 'Examen Fisico';
		$data['subject'] = $this->Model_Subject->find($subject_id);				

		$data['etapas'] = array(""=>"",
						"Seleccion - Visita Basal"=>"Selección - Visita Basal",
						"Visita Basal - Semana 4"=>"Visita Basal - Semana 4",
						"Semana 4 - Semana 12"=>"Semana 4 – Semana 12",
						"Semana 12 - Semana 24"=>"Semana 12 - Semana 24"
						);	

		$this->load->view('template',$data);
	}

	public function examen_fisico_adicional_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');		
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('etapa', '', 'xss_clean');
		
		/*Si se tiene algun hallazgo todo es obligatorio*/
	
		$this->form_validation->set_rules('aspecto_general', '', 'xss_clean');
		$this->form_validation->set_rules('aspecto_general_desc', '', 'xss_clean');
		$this->form_validation->set_rules('estado_nutricional', '', 'xss_clean');
		$this->form_validation->set_rules('estado_nutricional_desc', '', 'xss_clean');
		$this->form_validation->set_rules('piel', '', 'xss_clean');
		$this->form_validation->set_rules('piel_desc', '', 'xss_clean');
		$this->form_validation->set_rules('cabeza', '', 'xss_clean');
		$this->form_validation->set_rules('cabeza_desc', '', 'xss_clean');
		$this->form_validation->set_rules('ojos', '', 'xss_clean');
		$this->form_validation->set_rules('ojos_desc', '', 'xss_clean');
		$this->form_validation->set_rules('nariz', '', 'xss_clean');			
		$this->form_validation->set_rules('nariz_desc', '', 'xss_clean');
		$this->form_validation->set_rules('oidos', '', 'xss_clean');
		$this->form_validation->set_rules('oidos_desc', '', 'xss_clean');
		$this->form_validation->set_rules('boca', '', 'xss_clean');
		$this->form_validation->set_rules('boca_desc', '', 'xss_clean');
		$this->form_validation->set_rules('cuello', '', 'xss_clean');
		$this->form_validation->set_rules('cuello_desc', '', 'xss_clean');
		$this->form_validation->set_rules('pulmones', '', 'xss_clean');
		$this->form_validation->set_rules('pulmones_desc', '', 'xss_clean');
		$this->form_validation->set_rules('cardiovascular', '', 'xss_clean');
		$this->form_validation->set_rules('cardiovascular_desc', '', 'xss_clean');
		$this->form_validation->set_rules('abdomen', '', 'xss_clean');
		$this->form_validation->set_rules('abdomen_desc', '', 'xss_clean');
		$this->form_validation->set_rules('muscular', '', 'xss_clean');
		$this->form_validation->set_rules('muscular_desc', '', 'xss_clean');
		$this->form_validation->set_rules('tuvo_cambios', '', 'xss_clean');
		$this->form_validation->set_rules('cambios_observaciones', '', 'xss_clean');	
		
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');


		if(
			(isset($registro['aspecto_general']) AND $registro['aspecto_general'] == '0' AND empty($registro['aspecto_general_desc']))
			OR
			(isset($registro['estado_nutricional']) AND $registro['estado_nutricional'] == '0' AND empty($registro['estado_nutricional_desc']))
			OR
			(isset($registro['piel']) AND $registro['piel'] == '0' AND empty($registro['piel_desc']))
			OR
			(isset($registro['cabeza']) AND $registro['cabeza'] == '0' AND empty($registro['cabeza_desc']))
			OR
			(isset($registro['ojos']) AND $registro['ojos'] == '0' AND empty($registro['ojos_desc']))
			OR
			(isset($registro['nariz']) AND $registro['nariz'] == '0' AND empty($registro['nariz_desc']))
			OR
			(isset($registro['oidos']) AND $registro['oidos'] == '0' AND empty($registro['oidos_desc']))
			OR
			(isset($registro['boca']) AND $registro['boca'] == '0' AND empty($registro['boca_desc']))
			OR
			(isset($registro['cuello']) AND $registro['cuello'] == '0' AND empty($registro['cuello_desc']))
			OR
			(isset($registro['pulmones']) AND $registro['pulmones'] == '0' AND empty($registro['pulmones_desc']))
			OR
			(isset($registro['cardiovascular']) AND $registro['cardiovascular'] == '0' AND empty($registro['cardiovascular_desc']))
			OR
			(isset($registro['abdomen']) AND $registro['abdomen'] == '0' AND empty($registro['abdomen_desc']))
			OR
			(isset($registro['muscular']) AND $registro['muscular'] == '0' AND empty($registro['muscular_desc']))										

			OR !isset($registro['aspecto_general']) OR !isset($registro['estado_nutricional']) OR !isset($registro['piel']) OR !isset($registro['cabeza'])
			OR !isset($registro['ojos']) OR !isset($registro['nariz']) OR !isset($registro['oidos']) OR !isset($registro['boca'])
			OR !isset($registro['cuello']) OR !isset($registro['pulmones']) OR !isset($registro['cardiovascular']) OR !isset($registro['abdomen'])
			OR !isset($registro['muscular']) OR !isset($registro['ext_superiores']) OR !isset($registro['ext_inferiores']) OR !isset($registro['periferico'])
			OR $registro['etapa'] == ''
		){
			$estado = 'Error';
		}
		else{
			$estado = 'Record Complete';
		}

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Tuvo errores al tratar de agregar Examen Fisico", $registro['subject_id']);
			$this->examen_fisico($registro['subject_id'],$registro['etapa']);
		}
		else {		

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}

			$registro['status'] = $estado;
			$registro['created_at'] = date("Y-m-d H:i:s");						
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');

			$this->load->model("Model_Examen_fisico_adicional");
			$this->Model_Examen_fisico_adicional->insert($registro);

			$this->auditlib->save_audit("Examen Fisico Adicional Ingresado", $registro['subject_id']);		

     		redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_fisico_adicional_show($subject_id,$id){
		$data['contenido'] = 'subject/adicional/examen_fisico_show';
		$data['titulo'] = 'Examen Fisico';
		$data['subject'] = $this->Model_Subject->find($subject_id);		

		$data['etapas'] = array(""=>"",
						"Seleccion - Visita Basal"=>"Selección - Visita Basal",
						"Visita Basal - Semana 4"=>"Visita Basal - Semana 4",
						"Semana 4 - Semana 12"=>"Semana 4 – Semana 12",
						"Semana 12 - Semana 24"=>"Semana 12 - Semana 24"
						);	

		$this->load->model("Model_Examen_fisico_adicional");
		$data['list'] = $this->Model_Examen_fisico_adicional->allWhereArray(array('subject_id'=>$subject_id, 'id'=>$id));

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"examen_fisico_adicional", "form_id"=>$id, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->view('template', $data);
	}

	public function examen_fisico_adicional_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');		
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('etapa', '', 'xss_clean');
		
		/*Si se tiene algun hallazgo todo es obligatorio*/
	
		$this->form_validation->set_rules('aspecto_general', '', 'xss_clean');
		$this->form_validation->set_rules('aspecto_general_desc', '', 'xss_clean');
		$this->form_validation->set_rules('estado_nutricional', '', 'xss_clean');
		$this->form_validation->set_rules('estado_nutricional_desc', '', 'xss_clean');
		$this->form_validation->set_rules('piel', '', 'xss_clean');
		$this->form_validation->set_rules('piel_desc', '', 'xss_clean');
		$this->form_validation->set_rules('cabeza', '', 'xss_clean');
		$this->form_validation->set_rules('cabeza_desc', '', 'xss_clean');
		$this->form_validation->set_rules('ojos', '', 'xss_clean');
		$this->form_validation->set_rules('ojos_desc', '', 'xss_clean');
		$this->form_validation->set_rules('nariz', '', 'xss_clean');			
		$this->form_validation->set_rules('nariz_desc', '', 'xss_clean');
		$this->form_validation->set_rules('oidos', '', 'xss_clean');
		$this->form_validation->set_rules('oidos_desc', '', 'xss_clean');
		$this->form_validation->set_rules('boca', '', 'xss_clean');
		$this->form_validation->set_rules('boca_desc', '', 'xss_clean');
		$this->form_validation->set_rules('cuello', '', 'xss_clean');
		$this->form_validation->set_rules('cuello_desc', '', 'xss_clean');
		$this->form_validation->set_rules('pulmones', '', 'xss_clean');
		$this->form_validation->set_rules('pulmones_desc', '', 'xss_clean');
		$this->form_validation->set_rules('cardiovascular', '', 'xss_clean');
		$this->form_validation->set_rules('cardiovascular_desc', '', 'xss_clean');
		$this->form_validation->set_rules('abdomen', '', 'xss_clean');
		$this->form_validation->set_rules('abdomen_desc', '', 'xss_clean');
		$this->form_validation->set_rules('muscular', '', 'xss_clean');
		$this->form_validation->set_rules('muscular_desc', '', 'xss_clean');
		$this->form_validation->set_rules('tuvo_cambios', '', 'xss_clean');
		$this->form_validation->set_rules('cambios_observaciones', '', 'xss_clean');	
		
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');


		if(
			(isset($registro['aspecto_general']) AND $registro['aspecto_general'] == '0' AND empty($registro['aspecto_general_desc']))
			OR
			(isset($registro['estado_nutricional']) AND $registro['estado_nutricional'] == '0' AND empty($registro['estado_nutricional_desc']))
			OR
			(isset($registro['piel']) AND $registro['piel'] == '0' AND empty($registro['piel_desc']))
			OR
			(isset($registro['cabeza']) AND $registro['cabeza'] == '0' AND empty($registro['cabeza_desc']))
			OR
			(isset($registro['ojos']) AND $registro['ojos'] == '0' AND empty($registro['ojos_desc']))
			OR
			(isset($registro['nariz']) AND $registro['nariz'] == '0' AND empty($registro['nariz_desc']))
			OR
			(isset($registro['oidos']) AND $registro['oidos'] == '0' AND empty($registro['oidos_desc']))
			OR
			(isset($registro['boca']) AND $registro['boca'] == '0' AND empty($registro['boca_desc']))
			OR
			(isset($registro['cuello']) AND $registro['cuello'] == '0' AND empty($registro['cuello_desc']))
			OR
			(isset($registro['pulmones']) AND $registro['pulmones'] == '0' AND empty($registro['pulmones_desc']))
			OR
			(isset($registro['cardiovascular']) AND $registro['cardiovascular'] == '0' AND empty($registro['cardiovascular_desc']))
			OR
			(isset($registro['abdomen']) AND $registro['abdomen'] == '0' AND empty($registro['abdomen_desc']))
			OR
			(isset($registro['muscular']) AND $registro['muscular'] == '0' AND empty($registro['muscular_desc']))										

			OR !isset($registro['aspecto_general']) OR !isset($registro['estado_nutricional']) OR !isset($registro['piel']) OR !isset($registro['cabeza'])
			OR !isset($registro['ojos']) OR !isset($registro['nariz']) OR !isset($registro['oidos']) OR !isset($registro['boca'])
			OR !isset($registro['cuello']) OR !isset($registro['pulmones']) OR !isset($registro['cardiovascular']) OR !isset($registro['abdomen'])
			OR !isset($registro['muscular']) OR !isset($registro['ext_superiores']) OR !isset($registro['ext_inferiores']) OR !isset($registro['periferico'])
			OR $registro['etapa'] == ''
		){
			$estado = 'Error';
		}
		else{
			$estado = 'Record Complete';
		}

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Tuvo errores al tratar de agregar Examen Fisico", $registro['subject_id']);
			$this->examen_fisico($registro['subject_id'],$registro['etapa']);
		}
		else {		

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}

			$registro['status'] = $estado;			
			$registro['updated_at'] = date("Y-m-d H:i:s");			
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');

			$this->load->model("Model_Examen_fisico_adicional");
			$this->Model_Examen_fisico_adicional->update($registro);

			$this->auditlib->save_audit("Examen Fisico Adicional Actualizado", $registro['subject_id']);		

     		redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_fisico_adicional_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de examen fisico", $registro['subject_id']);
			$this->examen_fisico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_fisico_adicional');
			$this->Model_Examen_fisico_adicional->update($registro);
			$this->auditlib->save_audit("Verificacion de el formulario de examen fisico Adicional", $registro['subject_id']);


			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_fisico_adicional_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de examen fisico", $registro['subject_id']);
			$this->examen_fisico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_fisico_adicional');
			$this->Model_Examen_fisico_adicional->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de examen fisico Adicional", $registro['subject_id']);
		

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_fisico_adicional_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de cerrar el formulario de examen fisico", $registro['subject_id']);
			$this->examen_fisico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved and Locked';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['lock_user'] = $this->session->userdata('usuario');
			$registro['lock_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_fisico_adicional');
			$this->Model_Examen_fisico_adicional->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de examen fisico Adicional", $registro['subject_id']);
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	/*-------------------------------Examen Neuroloico Adicional -------------------------------------------------------------------*/
	public function examen_neurologico_adicional($subject_id){
		$data['contenido'] = 'subject/adicional/examen_neurologico';
		$data['titulo'] = 'Examen Neurologico';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		
		$this->load->model('Model_Examen_neurologico_adicional');
		$data['lista'] = $this->Model_Examen_neurologico_adicional->allWhereArray(array('subject_id'=>$subject_id));

		$this->load->view('template',$data);
	}

	public function examen_neurologico_adicional_agregar($subject_id){
		$data['contenido'] = 'subject/adicional/examen_neurologico_agregar';
		$data['titulo'] = 'Examen Neurologico';
		$data['subject'] = $this->Model_Subject->find($subject_id);				

		$data['etapas'] = array(""=>"",
						"Seleccion - Visita Basal"=>"Selección - Visita Basal",
						"Visita Basal - Semana 4"=>"Visita Basal - Semana 4",
						"Semana 4 - Semana 12"=>"Semana 4 – Semana 12",
						"Semana 12 - Semana 24"=>"Semana 12 - Semana 24"
						);	

		$this->load->view('template',$data);
	}

	public function examen_neurologico_adicional_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');				
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('etapa', '', 'xss_clean');
		$this->form_validation->set_rules('nervios_craneanos_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('nervios_craneanos', '', 'xss_clean');		
		$this->form_validation->set_rules('examen_sensitivo_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('examen_sensitivo', '', 'xss_clean');
		$this->form_validation->set_rules('reflejos_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('reflejos', '', 'xss_clean');
		$this->form_validation->set_rules('funcion_cerebelosa_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('funcion_cerebelosa', '', 'xss_clean');
		$this->form_validation->set_rules('marcha_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('marcha', '', 'xss_clean');
		$this->form_validation->set_rules('fuerza_muscular_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('fuerza_muscular', '', 'xss_clean');
		$this->form_validation->set_rules('tono_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('tono', '', 'xss_clean');
		$this->form_validation->set_rules('mov_anormales_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('mov_anormales', '', 'xss_clean');
		$this->form_validation->set_rules('coordinacion_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('coordinacion', '', 'xss_clean');
		$this->form_validation->set_rules('postura_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('postura', '', 'xss_clean');		
		$this->form_validation->set_rules('motora_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('motora', '', 'xss_clean');
		$this->form_validation->set_rules('tuvo_cambios', '', 'xss_clean');
		$this->form_validation->set_rules('cambios_observaciones', '', 'xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar examen neurologico", $registro['subject_id']);
			$this->examen_neurologico($registro['subject_id'], $registro['etapa']);

		}else{

			if(
				empty($registro['fecha'])
				OR $registro['nervios_craneanos_normal_anormal'] == ''
				OR $registro['examen_sensitivo_normal_anormal'] == ''
				OR $registro['reflejos_normal_anormal'] == ''
				OR $registro['funcion_cerebelosa_normal_anormal'] == ''
				OR $registro['marcha_normal_anormal'] == ''
				OR $registro['fuerza_muscular_normal_anormal'] == ''
				OR $registro['tono_normal_anormal'] == ''
				OR $registro['mov_anormales_normal_anormal'] == ''
				OR $registro['coordinacion_normal_anormal'] == ''
				OR $registro['postura_normal_anormal'] == ''
				OR $registro['motora_normal_anormal'] == ''			
				OR $registro['etapa'] == ''
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}			

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}

			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');	

			
			/*Actualizamos el Form*/
			$this->load->model('Model_Examen_neurologico_adicional');
			$this->Model_Examen_neurologico_adicional->insert($registro);			

			$this->auditlib->save_audit("Examen Neurologico adicional agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}

	}

	public function examen_neurologico_adicional_show($subject_id, $id){
		$data['contenido'] = 'subject/adicional/examen_neurologico_show';
		$data['titulo'] = 'Examen Neurologico';
		$data['subject'] = $this->Model_Subject->find($subject_id);		
		
		$data['etapas'] = array(""=>"",
						"Seleccion - Visita Basal"=>"Selección - Visita Basal",
						"Visita Basal - Semana 4"=>"Visita Basal - Semana 4",
						"Semana 4 - Semana 12"=>"Semana 4 – Semana 12",
						"Semana 12 - Semana 24"=>"Semana 12 - Semana 24"
						);	

		$this->load->model('Model_Examen_neurologico_adicional');
		$data['list'] = $this->Model_Examen_neurologico_adicional->allWhereArray(array('subject_id'=>$subject_id, 'id'=>$id));

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"examen_neurologico_adicional", 'form_id'=>$id ,"status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->view('template',$data);
	}

	public function examen_neurologico_adicional_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');				
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('etapa', '', 'xss_clean');
		$this->form_validation->set_rules('nervios_craneanos_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('nervios_craneanos', '', 'xss_clean');		
		$this->form_validation->set_rules('examen_sensitivo_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('examen_sensitivo', '', 'xss_clean');
		$this->form_validation->set_rules('reflejos_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('reflejos', '', 'xss_clean');
		$this->form_validation->set_rules('funcion_cerebelosa_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('funcion_cerebelosa', '', 'xss_clean');
		$this->form_validation->set_rules('marcha_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('marcha', '', 'xss_clean');
		$this->form_validation->set_rules('fuerza_muscular_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('fuerza_muscular', '', 'xss_clean');
		$this->form_validation->set_rules('tono_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('tono', '', 'xss_clean');
		$this->form_validation->set_rules('mov_anormales_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('mov_anormales', '', 'xss_clean');
		$this->form_validation->set_rules('coordinacion_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('coordinacion', '', 'xss_clean');
		$this->form_validation->set_rules('postura_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('postura', '', 'xss_clean');		
		$this->form_validation->set_rules('motora_normal_anormal', '', 'xss_clean');
		$this->form_validation->set_rules('motora', '', 'xss_clean');
		$this->form_validation->set_rules('tuvo_cambios', '', 'xss_clean');
		$this->form_validation->set_rules('cambios_observaciones', '', 'xss_clean');

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar examen neurologico", $registro['subject_id']);
			$this->examen_neurologico($registro['subject_id'], $registro['etapa']);

		}else{

			if(
				empty($registro['fecha'])
				OR $registro['nervios_craneanos_normal_anormal'] == ''
				OR $registro['examen_sensitivo_normal_anormal'] == ''
				OR $registro['reflejos_normal_anormal'] == ''
				OR $registro['funcion_cerebelosa_normal_anormal'] == ''
				OR $registro['marcha_normal_anormal'] == ''
				OR $registro['fuerza_muscular_normal_anormal'] == ''
				OR $registro['tono_normal_anormal'] == ''
				OR $registro['mov_anormales_normal_anormal'] == ''
				OR $registro['coordinacion_normal_anormal'] == ''
				OR $registro['postura_normal_anormal'] == ''
				OR $registro['motora_normal_anormal'] == ''			
				OR $registro['etapa'] == ''
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}			

			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}

			$registro['status'] = $estado;			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');	

			
			/*Actualizamos el Form*/
			$this->load->model('Model_Examen_neurologico_adicional');
			$this->Model_Examen_neurologico_adicional->update($registro);


			$this->auditlib->save_audit("Examen Neurologico adicional actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);

		}

	}

	public function examen_neurologico_adicional_verify(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de verificar el formulario de Examen Neurologico", $registro['subject_id']);
			$this->examen_neurologico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Form Approved by Monitor';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_neurologico_adicional');
			$this->Model_Examen_neurologico_adicional->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de Examen Neurologico Adicional", $registro['subject_id']);			
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_neurologico_adicional_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Examen Neurologico", $registro['subject_id']);
			$this->examen_neurologico_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_neurologico_adicional');
			$this->Model_Examen_neurologico_adicional->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de Examen Neurologico Adicional", $registro['subject_id']);			
			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_neurologico_adicional_lock(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

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

			$this->load->model('Model_Examen_neurologico_adicional');
			$this->Model_Examen_neurologico_adicional->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de Examen Neurologico Adicional", $registro['subject_id']);						
			
			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	/*-------------------------------Examen Laboratorio Adicional-------------------------------------------------------------------*/
	public function examen_laboratorio_adicional($subject_id){
		$data['contenido'] = 'subject/adicional/examen_laboratorio';
		$data['titulo'] = 'Examen Laboratorio';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		
		$data['medidas1'] = array(''=>'','meq/L'=>'meq/L','mmol/L'=>'mmol/L');
		$data['medidas2'] = array(''=>'','mmol/l'=>'mmol/l','mg/dL'=>'mg/dL');


		$this->load->model('Model_Examen_laboratorio_adicional');
		$data['lista'] = $this->Model_Examen_laboratorio_adicional->allWhereArray(array('subject_id'=>$subject_id));

		$this->load->view('template2',$data);
	}


	public function examen_laboratorio_adicional_agregar($subject_id){
		$data['contenido'] = 'subject/adicional/examen_laboratorio_agregar';
		$data['titulo'] = 'Examen Laboratorio';
		$data['subject'] = $this->Model_Subject->find($subject_id);				

		$data['medidas1'] = array(''=>'','meq/L'=>'meq/L','mmol/L'=>'mmol/L');
		$data['medidas2'] = array(''=>'','mmol/l'=>'mmol/l','mg/dL'=>'mg/dL');

		$data['etapas'] = array(""=>"",
						"Seleccion - Visita Basal"=>"Selección - Visita Basal",
						"Visita Basal - Semana 4"=>"Visita Basal - Semana 4",
						"Semana 4 - Semana 12"=>"Semana 4 – Semana 12",
						"Semana 12 - Semana 24"=>"Semana 12 - Semana 24"
						);	

		$this->load->view('template',$data);
	}

	public function examen_laboratorio_adicional_insert(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');						
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('etapa', '', 'xss_clean');
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
		$this->form_validation->set_rules('calcio_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('sodio_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('potasio_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('cloro_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('glucosa_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_1', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_2', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_3', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_4', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_5', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_6', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_7', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_8', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_9', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_10', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_11', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_12', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_13', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_14', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_15', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_16', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_17', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_18', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_19', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_20', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_21', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_22', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_23', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_24', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_25', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_26', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_27', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_28', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_29', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_30', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_31', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_32', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_33', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_34', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_35', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_36', '', 'xss_clean');
		$this->form_validation->set_rules('observaciones', '', 'xss_clean');
		
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar examen de laboratorio", $registro['subject_id']);
			$this->examen_laboratorio($registro['subject_id'], $registro['etapa']);

		}else{

			if(
				empty($registro['fecha']) 
				OR ($registro['hecho_1'] == 1 AND (empty($registro['hematocrito']) OR !isset($registro['hematocrito_nom_anom']) ))
				OR ($registro['hecho_2'] == 1 AND (empty($registro['hemoglobina']) OR !isset($registro['hemoglobina_nom_anom'])  ))
				OR ($registro['hecho_3'] == 1 AND (empty($registro['eritocritos']) OR !isset($registro['eritocritos_nom_anom']) ))
				OR ($registro['hecho_4'] == 1 AND (empty($registro['leucocitos']) OR !isset($registro['leucocitos_nom_anom']) ))
				OR ($registro['hecho_5'] == 1 AND (empty($registro['neutrofilos']) OR !isset($registro['neutrofilos_nom_anom'])  ))
				OR ($registro['hecho_6'] == 1 AND (empty($registro['linfocitos']) OR !isset($registro['linfocitos_nom_anom']) ))
				OR ($registro['hecho_7'] == 1 AND (empty($registro['monocitos']) OR !isset($registro['monocitos_nom_anom'])))
				OR ($registro['hecho_8'] == 1 AND (empty($registro['eosinofilos']) OR !isset($registro['eosinofilos_nom_anom'])  ))
				OR ($registro['hecho_9'] == 1 AND (empty($registro['basofilos']) OR	!isset($registro['basofilos_nom_anom']) ))
				OR ($registro['hecho_10'] == 1 AND (empty($registro['recuento_plaquetas']) OR !isset($registro['recuento_plaquetas_nom_anom'])))
				OR ($registro['hecho_11'] == 1 AND (empty($registro['glucosa_ayunas']) OR !isset($registro['glucosa_ayunas_nom_anom']) ))
				OR ($registro['hecho_12'] == 1 AND (empty($registro['bun']) OR !isset($registro['bun_nom_anom']) ))
				OR ($registro['hecho_13'] == 1 AND (empty($registro['creatinina']) OR !isset($registro['creatinina_nom_anom'])))
				OR ($registro['hecho_14'] == 1 AND (empty($registro['bilirrubina_total']) OR	!isset($registro['bilirrubina_total_nom_anom']) ))
				OR ($registro['hecho_15'] == 1 AND (empty($registro['proteinas_totales']) OR !isset($registro['proteinas_totales_nom_anom']) ))
				OR ($registro['hecho_16'] == 1 AND (empty($registro['fosfatasas_alcalinas']) OR !isset($registro['fosfatasas_alcalinas_nom_anom'])))
				OR ($registro['hecho_17'] == 1 AND (empty($registro['ast']) OR !isset($registro['ast_nom_anom'])))
				OR ($registro['hecho_18'] == 1 AND (empty($registro['alt']) OR !isset($registro['alt_nom_anom']) ))
				OR ($registro['hecho_19'] == 1 AND (empty($registro['calcio']) OR !isset($registro['calcio_nom_anom']) OR empty($registro['calcio_unidad_medida']) ))
				OR ($registro['hecho_20'] == 1 AND (empty($registro['sodio']) OR	!isset($registro['sodio_nom_anom']) OR empty($registro['sodio_unidad_medida']) ))
				OR ($registro['hecho_21'] == 1 AND (empty($registro['potasio']) OR !isset($registro['potasio_nom_anom']) OR empty($registro['potasio_unidad_medida'])))
				OR ($registro['hecho_22'] == 1 AND (empty($registro['cloro']) OR !isset($registro['cloro_nom_anom']) OR empty($registro['cloro_unidad_medida']) ))
				OR ($registro['hecho_23'] == 1 AND (empty($registro['acido_urico']) OR !isset($registro['acido_urico_nom_anom']) ))
				OR ($registro['hecho_24'] == 1 AND (empty($registro['albumina']) OR !isset($registro['albumina_nom_anom'])))
				OR ($registro['hecho_25'] == 1 AND (empty($registro['orina_ph']) OR !isset($registro['orina_ph_nom_anom'])))
				OR ($registro['hecho_26'] == 1 AND (empty($registro['orina_glucosa']) OR	!isset($registro['orina_glucosa_nom_anom']) OR empty($registro['glucosa_unidad_medida']) ))
				OR ($registro['hecho_27'] == 1 AND (empty($registro['orina_proteinas']) OR !isset($registro['orina_proteinas_nom_anom'])))
				OR ($registro['hecho_28'] == 1 AND (empty($registro['orina_sangre']) OR !isset($registro['orina_sangre_nom_anom'])))
				OR ($registro['hecho_29'] == 1 AND (empty($registro['orina_cetonas']) OR	!isset($registro['orina_cetonas_nom_anom'])))
				OR ($registro['hecho_30'] == 1 AND (empty($registro['orina_microscospia']) OR !isset($registro['orina_microscospia_nom_anom'])))
				OR ($registro['hecho_31'] == 1 AND (empty($registro['otros_sangre_homocisteina']) OR !isset($registro['otros_sangre_homocisteina_nom_anom'])))
				OR ($registro['hecho_32'] == 1 AND (empty($registro['otros_perfil_tiroideo']) OR !isset($registro['otros_perfil_tiroideo_nom_anom'])))
				OR ($registro['hecho_33'] == 1 AND (empty($registro['otros_nivel_b12']) OR !isset($registro['otros_nivel_b12_nom_anom'])))
				OR ($registro['hecho_34'] == 1 AND (empty($registro['otros_acido_folico']) OR !isset($registro['otros_acido_folico_nom_anom'])))
				OR ($registro['hecho_35'] == 1 AND (empty($registro['otros_hba1c']) OR !isset($registro['otros_hba1c_nom_anom'])))
				OR ($registro['hecho_36'] == 1 AND (empty($registro['sifilis']) OR !isset($registro['sifilis_nom_anom']) ))
				OR $registro['hecho_1'] == '' OR $registro['hecho_2'] == '' OR $registro['hecho_3'] == '' OR $registro['hecho_4'] == ''
				OR $registro['hecho_5'] == '' OR $registro['hecho_6'] == '' OR $registro['hecho_7'] == '' OR $registro['hecho_8'] == ''
				OR $registro['hecho_9'] == '' OR $registro['hecho_10'] == '' OR $registro['hecho_11'] == '' OR $registro['hecho_12'] == ''
				OR $registro['hecho_13'] == '' OR $registro['hecho_14'] == '' OR $registro['hecho_15'] == '' OR $registro['hecho_16'] == ''
				OR $registro['hecho_17'] == '' OR $registro['hecho_18'] == '' OR $registro['hecho_19'] == '' OR $registro['hecho_20'] == ''
				OR $registro['hecho_21'] == '' OR $registro['hecho_22'] == '' OR $registro['hecho_23'] == '' OR $registro['hecho_24'] == ''
				OR $registro['hecho_25'] == '' OR $registro['hecho_26'] == '' OR $registro['hecho_27'] == '' OR $registro['hecho_28'] == ''
				OR $registro['hecho_29'] == '' OR $registro['hecho_30'] == '' OR $registro['hecho_31'] == '' OR $registro['hecho_32'] == ''
				OR $registro['hecho_33'] == '' OR $registro['hecho_34'] == '' OR $registro['hecho_35'] == '' OR $registro['hecho_36'] == ''
				OR $registro['etapa'] == ''
				
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			$registro['status'] = $estado;
			$registro['usuario_creacion'] = $this->session->userdata('usuario');
			$registro['created_at'] = date("Y-m-d H:i:s");
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Examen_laboratorio_adicional');
			$this->Model_Examen_laboratorio_adicional->insert($registro);			

			$this->auditlib->save_audit("Examen de Laboratorio adicional agregado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);
		}

	}

	public function examen_laboratorio_adicional_show($subject_id, $id){
		$data['contenido'] = 'subject/adicional/examen_laboratorio_show';
		$data['titulo'] = 'Examen Laboratorio';
		$data['subject'] = $this->Model_Subject->find($subject_id);				
		
		$data['medidas1'] = array(''=>'','meq/L'=>'meq/L','mmol/L'=>'mmol/L');
		$data['medidas2'] = array(''=>'','mmol/l'=>'mmol/l','mg/dL'=>'mg/dL');

		$data['etapas'] = array(""=>"",
						"Seleccion - Visita Basal"=>"Selección - Visita Basal",
						"Visita Basal - Semana 4"=>"Visita Basal - Semana 4",
						"Semana 4 - Semana 12"=>"Semana 4 – Semana 12",
						"Semana 12 - Semana 24"=>"Semana 12 - Semana 24"
						);	

		$this->load->model('Model_Examen_laboratorio_adicional');
		$data['list'] = $this->Model_Examen_laboratorio_adicional->allWhereArray(array('subject_id'=>$subject_id, 'id'=>$id));

		$campos_query = $this->Model_Query->allWhere(array("subject_id"=>$subject_id,"form"=>"examen_laboratorio", "form_id"=>$id, "status"=>'Abierto'));		
		if(isset($campos_query) AND !empty($campos_query)){
			foreach ($campos_query as $value) {
				$data['campos_query'][] = $value->campo;
			}
		}else{
			$data['campos_query'] = array();
		}

		$this->load->view('template2',$data);
	}

	public function examen_laboratorio_adicional_update(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('subject_id', '', 'required|xss_clean');						
		$this->form_validation->set_rules('fecha', '', 'xss_clean');
		$this->form_validation->set_rules('etapa', '', 'xss_clean');
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
		$this->form_validation->set_rules('calcio_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('sodio_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('potasio_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('cloro_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('glucosa_unidad_medida', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_1', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_2', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_3', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_4', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_5', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_6', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_7', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_8', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_9', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_10', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_11', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_12', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_13', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_14', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_15', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_16', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_17', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_18', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_19', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_20', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_21', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_22', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_23', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_24', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_25', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_26', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_27', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_28', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_29', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_30', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_31', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_32', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_33', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_34', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_35', '', 'xss_clean');
		$this->form_validation->set_rules('hecho_36', '', 'xss_clean');
		$this->form_validation->set_rules('observaciones', '', 'xss_clean');
		
		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Errores de validacion al tratar de agregar examen de laboratorio", $registro['subject_id']);
			$this->examen_laboratorio($registro['subject_id'], $registro['etapa']);

		}else{

			if(
				empty($registro['fecha']) 
				OR ($registro['hecho_1'] == 1 AND (empty($registro['hematocrito']) OR !isset($registro['hematocrito_nom_anom']) ))
				OR ($registro['hecho_2'] == 1 AND (empty($registro['hemoglobina']) OR !isset($registro['hemoglobina_nom_anom'])  ))
				OR ($registro['hecho_3'] == 1 AND (empty($registro['eritocritos']) OR !isset($registro['eritocritos_nom_anom']) ))
				OR ($registro['hecho_4'] == 1 AND (empty($registro['leucocitos']) OR !isset($registro['leucocitos_nom_anom']) ))
				OR ($registro['hecho_5'] == 1 AND (empty($registro['neutrofilos']) OR !isset($registro['neutrofilos_nom_anom'])  ))
				OR ($registro['hecho_6'] == 1 AND (empty($registro['linfocitos']) OR !isset($registro['linfocitos_nom_anom']) ))
				OR ($registro['hecho_7'] == 1 AND (empty($registro['monocitos']) OR !isset($registro['monocitos_nom_anom'])))
				OR ($registro['hecho_8'] == 1 AND (empty($registro['eosinofilos']) OR !isset($registro['eosinofilos_nom_anom'])  ))
				OR ($registro['hecho_9'] == 1 AND (empty($registro['basofilos']) OR	!isset($registro['basofilos_nom_anom']) ))
				OR ($registro['hecho_10'] == 1 AND (empty($registro['recuento_plaquetas']) OR !isset($registro['recuento_plaquetas_nom_anom'])))
				OR ($registro['hecho_11'] == 1 AND (empty($registro['glucosa_ayunas']) OR !isset($registro['glucosa_ayunas_nom_anom']) ))
				OR ($registro['hecho_12'] == 1 AND (empty($registro['bun']) OR !isset($registro['bun_nom_anom']) ))
				OR ($registro['hecho_13'] == 1 AND (empty($registro['creatinina']) OR !isset($registro['creatinina_nom_anom'])))
				OR ($registro['hecho_14'] == 1 AND (empty($registro['bilirrubina_total']) OR	!isset($registro['bilirrubina_total_nom_anom']) ))
				OR ($registro['hecho_15'] == 1 AND (empty($registro['proteinas_totales']) OR !isset($registro['proteinas_totales_nom_anom']) ))
				OR ($registro['hecho_16'] == 1 AND (empty($registro['fosfatasas_alcalinas']) OR !isset($registro['fosfatasas_alcalinas_nom_anom'])))
				OR ($registro['hecho_17'] == 1 AND (empty($registro['ast']) OR !isset($registro['ast_nom_anom'])))
				OR ($registro['hecho_18'] == 1 AND (empty($registro['alt']) OR !isset($registro['alt_nom_anom']) ))
				OR ($registro['hecho_19'] == 1 AND (empty($registro['calcio']) OR !isset($registro['calcio_nom_anom']) OR empty($registro['calcio_unidad_medida']) ))
				OR ($registro['hecho_20'] == 1 AND (empty($registro['sodio']) OR	!isset($registro['sodio_nom_anom']) OR empty($registro['sodio_unidad_medida']) ))
				OR ($registro['hecho_21'] == 1 AND (empty($registro['potasio']) OR !isset($registro['potasio_nom_anom']) OR empty($registro['potasio_unidad_medida'])))
				OR ($registro['hecho_22'] == 1 AND (empty($registro['cloro']) OR !isset($registro['cloro_nom_anom']) OR empty($registro['cloro_unidad_medida']) ))
				OR ($registro['hecho_23'] == 1 AND (empty($registro['acido_urico']) OR !isset($registro['acido_urico_nom_anom']) ))
				OR ($registro['hecho_24'] == 1 AND (empty($registro['albumina']) OR !isset($registro['albumina_nom_anom'])))
				OR ($registro['hecho_25'] == 1 AND (empty($registro['orina_ph']) OR !isset($registro['orina_ph_nom_anom'])))
				OR ($registro['hecho_26'] == 1 AND (empty($registro['orina_glucosa']) OR	!isset($registro['orina_glucosa_nom_anom']) OR empty($registro['glucosa_unidad_medida']) ))
				OR ($registro['hecho_27'] == 1 AND (empty($registro['orina_proteinas']) OR !isset($registro['orina_proteinas_nom_anom'])))
				OR ($registro['hecho_28'] == 1 AND (empty($registro['orina_sangre']) OR !isset($registro['orina_sangre_nom_anom'])))
				OR ($registro['hecho_29'] == 1 AND (empty($registro['orina_cetonas']) OR	!isset($registro['orina_cetonas_nom_anom'])))
				OR ($registro['hecho_30'] == 1 AND (empty($registro['orina_microscospia']) OR !isset($registro['orina_microscospia_nom_anom'])))
				OR ($registro['hecho_31'] == 1 AND (empty($registro['otros_sangre_homocisteina']) OR !isset($registro['otros_sangre_homocisteina_nom_anom'])))
				OR ($registro['hecho_32'] == 1 AND (empty($registro['otros_perfil_tiroideo']) OR !isset($registro['otros_perfil_tiroideo_nom_anom'])))
				OR ($registro['hecho_33'] == 1 AND (empty($registro['otros_nivel_b12']) OR !isset($registro['otros_nivel_b12_nom_anom'])))
				OR ($registro['hecho_34'] == 1 AND (empty($registro['otros_acido_folico']) OR !isset($registro['otros_acido_folico_nom_anom'])))
				OR ($registro['hecho_35'] == 1 AND (empty($registro['otros_hba1c']) OR !isset($registro['otros_hba1c_nom_anom'])))
				OR ($registro['hecho_36'] == 1 AND (empty($registro['sifilis']) OR !isset($registro['sifilis_nom_anom']) ))
				OR $registro['hecho_1'] == '' OR $registro['hecho_2'] == '' OR $registro['hecho_3'] == '' OR $registro['hecho_4'] == ''
				OR $registro['hecho_5'] == '' OR $registro['hecho_6'] == '' OR $registro['hecho_7'] == '' OR $registro['hecho_8'] == ''
				OR $registro['hecho_9'] == '' OR $registro['hecho_10'] == '' OR $registro['hecho_11'] == '' OR $registro['hecho_12'] == ''
				OR $registro['hecho_13'] == '' OR $registro['hecho_14'] == '' OR $registro['hecho_15'] == '' OR $registro['hecho_16'] == ''
				OR $registro['hecho_17'] == '' OR $registro['hecho_18'] == '' OR $registro['hecho_19'] == '' OR $registro['hecho_20'] == ''
				OR $registro['hecho_21'] == '' OR $registro['hecho_22'] == '' OR $registro['hecho_23'] == '' OR $registro['hecho_24'] == ''
				OR $registro['hecho_25'] == '' OR $registro['hecho_26'] == '' OR $registro['hecho_27'] == '' OR $registro['hecho_28'] == ''
				OR $registro['hecho_29'] == '' OR $registro['hecho_30'] == '' OR $registro['hecho_31'] == '' OR $registro['hecho_32'] == ''
				OR $registro['hecho_33'] == '' OR $registro['hecho_34'] == '' OR $registro['hecho_35'] == '' OR $registro['hecho_36'] == ''
				OR $registro['etapa'] == ''
				
			){
				$estado = 'Error';
			}
			else{
				$estado = 'Record Complete';
			}

			$registro['status'] = $estado;			
			$registro['updated_at'] = date("Y-m-d H:i:s");
			$registro['usuario_actualizacion'] = $this->session->userdata('usuario');
			
			if(!empty($registro['fecha'])){
				$registro['fecha'] = $this->convertirFecha($registro['fecha']);
			}
			
			/*Actualizamos el Form*/
			$this->load->model('Model_Examen_laboratorio_adicional');
			$this->Model_Examen_laboratorio_adicional->update($registro);			

			$this->auditlib->save_audit("Examen de Laboratorio adicional actualizado", $registro['subject_id']);     		
     		redirect('subject/grid/'.$registro['subject_id']);
		}

	}
	
	public function examen_laboratorio_adicional_verify(){
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
			$registro['verify_user'] = $this->session->userdata('usuario');
			$registro['verify_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_laboratorio_adicional');
			$this->Model_Examen_laboratorio_adicional->update($registro);
			$this->auditlib->save_audit("Verifico el formulario de Examen Laboratorio", $registro['subject_id']);			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_laboratorio_adicional_signature(){
		$registro = $this->input->post();

		$this->form_validation->set_rules('id', 'Id Formulario', 'required|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject ID', 'required|xss_clean');        		
		$this->form_validation->set_rules('current_status', 'Current Status', 'required|xss_clean');		

		if($this->form_validation->run() == FALSE) {
			$this->auditlib->save_audit("Error al tratar de firmar el formulario de Examen Laboratorio Adicional", $registro['subject_id']);
			$this->examen_laboratorio_show($registro['subject_id'], $registro['etapa']);
		}
		else {
			$registro['last_status'] = $registro['current_status'];
			unset($registro['current_status']);			
			$registro['status'] = 'Document Approved and Signed by PI';
			$registro['updated_at'] = date('Y-m-d H:i:s');
			$registro['signature_user'] = $this->session->userdata('usuario');
			$registro['signature_date'] = date('Y-m-d');

			$this->load->model('Model_Examen_laboratorio_adicional');
			$this->Model_Examen_laboratorio_adicional->update($registro);
			$this->auditlib->save_audit("Firmo el formulario de Examen Laboratorio Adicional", $registro['subject_id']);			

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

	public function examen_laboratorio_adicional_lock(){
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

			$this->load->model('Model_Examen_laboratorio_adicional');
			$this->Model_Examen_laboratorio_adicional->update($registro);
			$this->auditlib->save_audit("Cerro el formulario de Examen Laboratorio Adicional", $registro['subject_id']);					

			redirect('subject/grid/'.$registro['subject_id']);
		}
	}

} 	