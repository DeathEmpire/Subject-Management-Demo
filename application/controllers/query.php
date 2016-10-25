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
		$data['titulo'] = 'Demograf&iacute;a Query';				
		$data['subject'] = $this->Model_Subject->find($id);
		$this->auditlib->save_audit("Abrio el formulario de querys en demografia", $id);				

		$this->load->view('template', $data);
	}

	public function demography_query_insert(){
		$registro = $this->input->post();		

		$this->form_validation->set_rules('question', 'Question', 'required|xss_clean');
        
        if ($this->form_validation->run() == FALSE) {
        	$this->auditlib->save_audit("Tiene errores de validacion al crear una query", $id);
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
			elseif($registro['form'] == 'Cumplimiento'){
				redirect('subject/cumplimiento_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'Digito Directo'){
				redirect('subject/digito_directo_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'ECG'){
				redirect('subject/ecg_show/'. $registro['subject_id']);
			}
			elseif($registro['form'] == 'Examen Laboratorio'){
				redirect('subject/examen_laboratorio_show/'. $registro['subject_id']);
			}
			elseif($registro['form'] == 'Examen Neurologico'){
				redirect('subject/examen_neurologico_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'Fin Tratamiento'){
				redirect('subject/fin_tratamiento_show/'. $registro['subject_id']);
			}
			elseif($registro['form'] == 'Fin Tratamiento Temprano'){
				redirect('subject/fin_tratamiento_temprano_show/'. $registro['subject_id']);
			}
			elseif($registro['form'] == 'Historial Medico'){
				redirect('subject/historial_medico_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'MMSE'){
				redirect('subject/mmse_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'Muestra de Sangre'){
				redirect('subject/muestra_de_sangre_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'Sginos Vitales'){
				redirect('subject/signos_vitales_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'TMT A'){
				redirect('subject/tmt_a_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'TMT B'){
				redirect('subject/tmt_b_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			// elseif($registro['form'] == 'Escala de columbia'){
			// 	redirect('subject/fin_tratamiento_show/'. $registro['subject_id']);
			// }
			// elseif($registro['form'] == ''){
			// 	redirect('subject/_show/'. $registro['subject_id']);
			// }
			else{
				redirect('subject/grid/'. $registro['subject_id']);	
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
			elseif($registro['form'] == 'Cumplimiento'){
				redirect('subject/cumplimiento_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'Digito Directo'){
				redirect('subject/digito_directo_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'ECG'){
				redirect('subject/ecg_show/'. $registro['subject_id']);
			}
			elseif($registro['form'] == 'Examen Laboratorio'){
				redirect('subject/examen_laboratorio_show/'. $registro['subject_id']);
			}
			elseif($registro['form'] == 'Examen Neurologico'){
				redirect('subject/examen_neurologico_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'Fin Tratamiento'){
				redirect('subject/fin_tratamiento_show/'. $registro['subject_id']);
			}
			elseif($registro['form'] == 'Fin Tratamiento Temprano'){
				redirect('subject/fin_tratamiento_temprano_show/'. $registro['subject_id']);
			}
			elseif($registro['form'] == 'Historial Medico'){
				redirect('subject/historial_medico_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'MMSE'){
				redirect('subject/mmse_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'Muestra de Sangre'){
				redirect('subject/muestra_de_sangre_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'Sginos Vitales'){
				redirect('subject/signos_vitales_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'TMT A'){
				redirect('subject/tmt_a_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			elseif($registro['form'] == 'TMT B'){
				redirect('subject/tmt_b_show/'. $registro['subject_id'] .'/'. $registro['etapa']);
			}
			// elseif($registro['form'] == ''){
			// 	redirect('subject/_show/'. $registro['subject_id']);
			// }
			else{
				redirect('subject/grid/'. $registro['subject_id']);	
			}
			
		}

	}

	public function query(){
		$p = $this->input->post();

		if($p['tipo'] == 'new'){
			
			//mostramos el formulario para el query

			if(!isset($p['etapa'])){
				$p['etapa'] = '';
			}

			$tabla = "<form action='". base_url('query/add') ."' method='post'>
						<input type='hidden' name='SubjectManagement' value='". $this->security->get_csrf_hash() ."'>
						<input type='hidden' name='campo' value='". $p['campo'] ."'>
						<input type='hidden' name='form' value='". $p['form'] ."'>
						<input type='hidden' name='etapa' value='". $p['etapa'] ."'>
						<input type='hidden' name='subject_id' value='". $p['subject_id'] ."'>						
						<input type='hidden' name='form_nombre' value='". $p['form_nombre'] ."'>
						<input type='hidden' name='form_id' value='". $p['form_id'] ."'>	
							<table class='table table-striped table-bordered table-hover'>
								<tr>
									<td>Agregar query:</td>
									<td><textarea name='question'></textarea></td>
								</tr>
								<tr>
									<td colspan='2' style='text-align:center;'>
										<input type='submit' content='Guardar' class='btn btn-primary'>
									</td>
								</tr>
							</table>
					</form>";
			echo $tabla;

		}
		elseif($p['tipo'] == 'old'){
			//buscamos el query de ese campo especifico y lo mostramos
			if(isset($p['etapa'])){
				$antiguo = $this->Model_Query->allWhere(array("subject_id"=>$p['subject_id'], "form"=>$p['form'], "etapa"=>$p['etapa'], "campo"=>$p['campo'], "status"=>'Abierto'));
			}
			else{
				$p['etapa'] = '';
				$antiguo = $this->Model_Query->allWhere(array("subject_id"=>$p['subject_id'], "form"=>$p['form'], "form_id"=>$p['form_id'], "campo"=>$p['campo'], "status"=>'Abierto'));
			}


			$tabla = "<form action='". base_url('query/update') ."' method='post'>
						<input type='hidden' name='SubjectManagement' value='". $this->security->get_csrf_hash() ."'>
						<input type='hidden' name='campo' value='". $p['campo'] ."'>
						<input type='hidden' name='form' value='". $p['form'] ."'>
						<input type='hidden' name='etapa' value='". $p['etapa'] ."'>
						<input type='hidden' name='subject_id' value='". $p['subject_id'] ."'>
						<input type='hidden' name='id' value='". $antiguo[0]->id ."'>
						<input type='hidden' name='form_nombre' value='". $p['form_nombre'] ."'>
						<input type='hidden' name='form_id' value='". $p['form_id'] ."'>	
							<table class='table table-striped table-bordered table-hover'>
								<tr>
									<td>Query: </td>
									<td>". $antiguo[0]->question ."</td>
								</tr>
								<tr>
									<td>Iniciada por: </td>
									<td>". $antiguo[0]->question_user ."</td>
								</tr>
								<tr>
									<td>Fecha: </td>
									<td>". date("d/m/Y H:i", strtotime($antiguo[0]->created)) ."</td>
								</tr>
								<tr>
									<td>Actualizar a: </td>
									<td>
										<select name='cerrar'>
											<option value='Cerrar'>Cerrar</option>
											<option value='Mantener'>Mantener</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Reponder query:</td>
									<td><textarea name='question'></textarea></td>
								</tr>
								<tr>
									<td colspan='2' style='text-align:center;'>
										<input type='submit' content='Guardar' class='btn btn-primary'>
									</td>
								</tr>
							</table>
					</form>";
			echo $tabla;
		}
	}

	public function add(){
		$registro = $this->input->post();
		
		$registro['question_user'] = $this->session->userdata('usuario');
		$registro['created'] = date("Y-m-d H:i:s");
		$registro['status'] = 'Abierto';

		//$registro['question'] es la pregunta

		//agregamos el query
		$this->Model_Query->insert($registro);
		//enviamos un correo		
			$this->load->Model('Model_Lista_correos');
			$correos = $this->Model_Lista_correos->allFilteredWhere(array('nombre'=>'Query'));

			$this->load->helper("phpmailer");
			
			$data['contenido'] = "correos/nueva_query";
			$data['query'] = $registro;			
			
			$mensaje = $this->load->view("correo",$data,true);			
			

			$enviar_correo = send_email($correos->correos,"x","Nueva Query",$mensaje);

		//actualizamos el estado del formulario
		if($registro['form'] == 'muestra_de_sangre'){			
			
			$subject['muestra_de_sangre_'. $registro['etapa'] .'_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'tmt_a'){			
			
			$subject['tmt_a_'. $registro['etapa'] .'_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'tmt_b'){			
			
			$subject['tmt_b_'. $registro['etapa'] .'_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'signos_vitales'){			
			
			$subject['signos_vitales_'. $registro['etapa'] .'_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'rnm'){			
			if($registro['etapa'] == 1){
				$subject['rnm_status'] = "Query";
			}
			else{
				$subject['rnm_'. $registro['etapa'] .'_status'] = "Query";	
			}
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'restas'){			
			
			$subject['restas_'. $registro['etapa'] .'_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'npi'){			
			
			$subject['npi_'. $registro['etapa'] .'_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'hachinski'){			
			
			$subject['hachinski_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'cumplimiento'){			
			
			$subject['cumplimiento_'. $registro['etapa'] .'_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'ecg'){			
			
			$subject['ecg_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'fin_tratamiento'){			
			
			$subject['fin_tratamiento_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'fin_tratamiento_temprano'){			
			
			$subject['fin_tratamiento_temprano_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'digito_directo'){			
			
			$subject['digito_'. $registro['etapa'] .'_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'eq_5d_5l'){			
			
			$subject['eq_5d_5l_'. $registro['etapa'] .'_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'historial_medico'){			
			
			$subject['historial_medico_'. $registro['etapa'] .'_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'examen_neurologico'){			
			
			$subject['examen_neurologico_'. $registro['etapa'] .'_status'] = "Query";
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'examen_laboratorio'){			
			
			if($registro['etapa'] == 1){
				$subject['examen_laboratorio_status'] = "Query";
			}
			else{
				$subject['examen_laboratorio_'. $registro['etapa'] .'_status'] = "Query";
			}
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'examen_fisico'){
			
			$subject['examen_fisico_'. $registro['etapa'] .'_status'] = "Query";			
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'apatia'){
			
			$subject['apatia_'. $registro['etapa'] .'_status'] = "Query";		
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'adas'){
			
			$subject['adas_'. $registro['etapa'] .'_status'] = "Query";		
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'demography'){
			
			$subject['demography_status'] = "Query";		
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif($registro['form'] == 'mmse'){
			
			$subject['mmse_'. $registro['etapa'] .'_status'] = "Query";		
			$subject['id'] = $registro['subject_id'];
			$this->Model_Subject->update($subject);			
		}
		elseif ($registro['form'] == 'signos_vitales_adicional') {
			$this->load->model('Model_Signos_vitales_adicional');
			$this->Model_Signos_vitales_adicional->update(array('id'=>$registro['form_id'], 'status'=>'Query'));
		}
		elseif ($registro['form'] == 'ecg_adicional') {
			$this->load->model('Model_Ecg_adicional');
			$this->Model_Ecg_adicional->update(array('id'=>$registro['form_id'], 'status'=>'Query'));
		}
		elseif ($registro['form'] == 'examen_fisico_adicional') {
			$this->load->model('Model_Examen_fisico_adicional');
			$this->Model_Examen_fisico_adicional->update(array('id'=>$registro['form_id'], 'status'=>'Query'));
		}
		elseif ($registro['form'] == 'examen_laboratorio_adicional') {
			$this->load->model('Model_Examen_laboratorio_adicional');
			$this->Model_Examen_laboratorio_adicional->update(array('id'=>$registro['form_id'], 'status'=>'Query'));
		}
		elseif ($registro['form'] == 'examen_neurologico_adicional') {
			$this->load->model('Model_Examen_neurologico_adicional');
			$this->Model_Examen_neurologico_adicional->update(array('id'=>$registro['form_id'], 'status'=>'Query'));
		}
		elseif($registro['form'] == 'escala_de_columbia'){
			$this->load->model('Model_Escala_de_columbia');
			$this->Model_Escala_de_columbia->update(array('id'=>$registro['form_id'], 'status'=>'Query'));
		}

		if($registro['form'] == 'demography'){
			redirect('subject/'. $registro['form'] .'/'. $registro['subject_id']);
		}
		elseif($registro['form'] == 'escala_de_columbia'){
			redirect('subject/'. $registro['form'] .'_show/'. $registro['subject_id']);
		}
		elseif(strstr($registro['form'], 'adicional'))
		{ 
			redirect('subject/'. $registro['form'] .'_show/'. $registro['subject_id'] ."/". $registro['form_id']);
		}
		else{
			redirect('subject/'. $registro['form'] .'_show/'. $registro['subject_id'] ."/". $registro['etapa']);
		}
	}

	public function update(){
		$registro = $this->input->post();
		
		$registro['answer_user'] = $this->session->userdata('usuario');
		$registro['answer_date'] = date("Y-m-d H:i:s");	


		if($registro['cerrar'] == 'Cerrar'){
			$registro['status'] = 'cerrado';

			//actualizamos el estado del formulario
			if($registro['form'] == 'muestra_de_sangre'){			

				//buscamos que el form no tenga mas query				
				$no_tiene = 0;
				
				if($no_tiene == 0){
					$subject['muestra_de_sangre_'. $registro['etapa'] .'_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'tmt_a'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					$subject['tmt_a_'. $registro['etapa'] .'_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'tmt_b'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					$subject['tmt_b_'. $registro['etapa'] .'_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'signos_vitales'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					$subject['signos_vitales_'. $registro['etapa'] .'_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'rnm'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					if($registro['etapa'] == 1){
						$subject['rnm_status'] = "Record Complete";
					}
					else{
						$subject['rnm_'. $registro['etapa'] .'_status'] = "Record Complete";	
					}					
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'restas'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					$subject['restas_'. $registro['etapa'] .'_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'npi'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					$subject['npi_'. $registro['etapa'] .'_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'hachinski'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					$subject['hachinski_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'cumplimiento'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					$subject['cumplimiento_'. $registro['etapa'] .'_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'ecg'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					$subject['ecg_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'fin_tratamiento'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					$subject['fin_tratamiento_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'fin_tratamiento_temprano'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					$subject['fin_tratamiento_temprano_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'digito_directo'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					$subject['digito_'. $registro['etapa'] .'_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'eq_5d_5l'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					$subject['eq_5d_5l_'. $registro['etapa'] .'_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'historial_medico'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					$subject['historial_medico_'. $registro['etapa'] .'_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'examen_neurologico'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					$subject['examen_neurologico_'. $registro['etapa'] .'_status'] = "Record Complete";
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'examen_laboratorio'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){
					if($registro['etapa'] == 1){
						$subject['examen_laboratorio_status'] = "Record Complete";
					}
					else{
						$subject['examen_laboratorio_'. $registro['etapa'] .'_status'] = "Record Complete";
					}
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'examen_fisico'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){					
					
					$subject['examen_fisico_'. $registro['etapa'] .'_status'] = "Record Complete";					
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'apatia'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){					
					
					$subject['apatia_'. $registro['etapa'] .'_status'] = "Record Complete";					
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'adas'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){					
					
					$subject['adas_'. $registro['etapa'] .'_status'] = "Record Complete";					
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'demography'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){					
					
					$subject['demography_status'] = "Record Complete";					
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'mmse'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){					
					
					$subject['mmse_'. $registro['etapa'] .'_status'] = "Record Complete";					
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'escala_de_columbia'){

				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],
													'etapa'=>$registro['etapa'], 
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){					
					
					$subject['escala_de_columbia_status'] = "Record Complete";					
					$subject['id'] = $registro['subject_id'];
					$this->Model_Subject->update($subject);			
				}
			}
			elseif($registro['form'] == 'signos_vitales_adicional'){
				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],													
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){					
					
					$this->load->model('Model_Signos_vitales_adicional');
					$this->Model_Signos_vitales_adicional->update(array('id'=>$registro['form_id'], 'status'=>'Record Complete'));
				}
			}
			elseif($registro['form'] == 'ecg_adicional'){
				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],													
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){					
					
					$this->load->model('Model_Ecg_adicional');
					$this->Model_Ecg_adicional->update(array('id'=>$registro['form_id'], 'status'=>'Record Complete'));
				}
			}
			elseif($registro['form'] == 'examen_fisico_adicional'){
				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],													
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){					
					
					$this->load->model('Model_Examen_fisico_adicional');
					$this->Model_Examen_fisico_adicional->update(array('id'=>$registro['form_id'], 'status'=>'Record Complete'));
				}
			}
			elseif($registro['form'] == 'examen_laboratorio_adicional'){
				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],													
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){					
					
					$this->load->model('Model_Examen_laboratorio_adicional');
					$this->Model_Examen_laboratorio_adicional->update(array('id'=>$registro['form_id'], 'status'=>'Record Complete'));
				}
			}
			elseif($registro['form'] == 'examen_neurologico_adicional'){
				//buscamos que el form no tenga mas query								
				$cant = $this->Model_Query->allWhere(array('form'=>$registro['form'],
													'status'=>'Abierto',
													'subject_id'=>$registro['subject_id'],													
													'query.id !='=>$registro['id']));
				if(isset($cant) AND !empty($cant)){
					$no_tiene = count($cant);
				}
				else{
					$no_tiene = 0;	
				}

				if($no_tiene == 0){					
					
					$this->load->model('Model_Examen_neurologico_adicional');
					$this->Model_Examen_neurologico_adicional->update(array('id'=>$registro['form_id'], 'status'=>'Record Complete'));
				}
			}
			
				
		}		

		unset($registro['cerrar']);

		//actualizamos el query
		$this->Model_Query->update($registro);
		
		if($registro['form'] == 'demography'){
			redirect('subject/'. $registro['form'] .'/'. $registro['subject_id']);
		}
		elseif($registro['form'] == 'escala_de_columbia'){
			redirect('subject/'. $registro['form'] .'_show/'. $registro['subject_id']);
		}
		elseif(strstr($registro['form'], 'adicional'))
		{ 
			redirect('subject/'. $registro['form'] .'_show/'. $registro['subject_id'] ."/". $registro['form_id']);
		}
		else{
			redirect('subject/'. $registro['form'] .'_show/'. $registro['subject_id'] ."/". $registro['etapa']);	
		}
	}
}