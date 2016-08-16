<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

	// Constructor de la clase
	function __construct() {
		parent::__construct();

		$this->load->model('Model_Report');		
		
    }

    function index(){

    	$data['contenido'] = 'report/index';
		$data['titulo'] = 'Reports';
		#$data['query'] = $this->Model_Report->all();

		$data['forms'] = array(''=>'',
								'adas'=>'ADAS-cog',
								'inclusion_exclusion'=>'Criterios de Inclusión/Exclusión',
								'cumplimiento'=>'Cumplimiento',
								'electrocardiograma_de_reposo'=>'Electrocardiograma de reposo (ECG)',
								'apatia'=>'Escala de evaluación de apatía',
								'hachinski_form'=>'Escala de Hachinski',
								'eq_5d_5l'=>'EQ-5D-5L',								
								'examen_fisico'=>'Examen físico',
								'examen_laboratorio'=>'Examenes de Laboratorio',
								'examen_neurologico'=>'Examen neurológico',
								'historial_medico'=>'Historia Médica',								
								'mmse'=>'MMSE',			
								'muestra_de_sangre'=>'Muestras de sangre para estudio de biomarcadores',
								'npi'=>'NPI',
								'digito_directo'=>'Prueba de dígito directo',
								'restas'=>'Prueba de restas seriadas',								
								'rnm'=>'Resonancia Magnética o Tomografía Computarizada',
								'signos_vitales'=>'Signos vitales/peso',								
								'tmt_a'=>'TMT A',
								'tmt_b'=>'TMT B');


		$this->auditlib->save_audit("Abrio la lista de reportes");
		$this->load->view('template2', $data);
    }

    function buscar(){
    	$registro = $this->input->post();

    	$this->form_validation->set_rules('formulario', 'Formulario', 'required|xss_clean');

		if($this->form_validation->run() == true) {
    		$resultado = $this->Model_Report->buscarPorTabla($registro['formulario']);

    		if(isset($resultado) AND !empty($resultado)){

    			$tabla = '';

	    		//formater el resultado deacuerdo a la tabla y luego enviar a la vista.
	    		if($registro['formulario'] == 'adas'){

	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>
	    								<th>Puntaje Total</th>	    								
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>
	    								<td>'. $r->puntaje_total .'</td>
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';

	    		}
	    		elseif($registro['formulario'] == 'inclusion'){

	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Cumple Criterios</th>
	    								<th>Fecha</th>	    								 								
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->cumple_criterios == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->created_at != '0000-00-00 00:00:00') ?  date('d/m/Y', strtotime($r->created_at)) : '') .'</td>	    								
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';

	    		}
	    		elseif($registro['formulario'] == 'cumplimiento'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>
	    								<th>% de Cumplimiento</th>	    								
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>
	    								<td>'. $r->porcentaje_cumplimiento .'</td>
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'electrocardiograma_de_reposo'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>
	    								<th>Ritmo sinusal</th>
	    								<th>FC</th>
	    								<th>PR</th>
	    								<th>QRS</th>
	    								<th>QT</th>
	    								<th>QTc</th>
	    								<th>Eje QRS</th>
	    								<th>Interpretacion ECG</th>
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>	    								
	    								<td>'. (($r->ritmo_sinusal == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. $r->fc .'</td>
	    								<td>'. $r->pr .'</td>
	    								<td>'. $r->qrs .'</td>
	    								<td>'. $r->qt .'</td>
	    								<td>'. $r->qtc .'</td>
	    								<td>'. $r->qrs2 .'</td>
	    								<td>'. (($r->interpretacion_ecg == 1) ? 'Normal' : 'Anormal') .'</td>
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'apatia'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>	    								
	    								<th>Resultado</th>
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>	    									    								
	    								<td>'. ($r->apatia_1 + $r->apatia_2 + $r->apatia_3 + $r->apatia_4 + $r->apatia_5 + $r->apatia_6 + $r->apatia_7 + $r->apatia_8 + $r->apatia_9 + $r->apatia_10 + $r->apatia_11 + $r->apatia_12 + $r->apatia_13 + $r->apatia_14 + $r->apatia_15 + $r->apatia_16 + $r->apatia_17 + $r->apatia_18 ) .'</td>	    								
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'hachinski'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>
	    								<th>Total</th>	    								
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>
	    								<td>'. $r->total .'</td>
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'eq_5d_5l'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>
	    								<th>Su salud hoy</th>	    								
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>
	    								<td>'. $r->salud_hoy .'</td>
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'examen_fisico'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>
	    								<th>Aspecto general</th>
	    								<th>Estado nutricional</th>
	    								<th>Piel</th>
	    								<th>Cabeza</th>
	    								<th>Ojos</th>
	    								<th>Nariz</th>
	    								<th>Oidos</th>
	    								<th>Boca - Garganta</th>
	    								<th>Cuello - adenopatías</th>
	    								<th>Pecho, pulmón</th>
	    								<th>Cardíaco</th>
	    								<th>Abdomen</th>
	    								<th>Muscular - Esquelético</th>
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>	    								
	    								<td>'. (($r->aspecto_general == 1) ? 'Normal' : (($r->aspecto_general == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->estado_nutricional == 1) ? 'Normal' : (($r->estado_nutricional == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->piel == 1) ? 'Normal' : (($r->piel == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->cabeza == 1) ? 'Normal' : (($r->cabeza == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->ojos == 1) ? 'Normal' : (($r->ojos == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->nariz == 1) ? 'Normal' : (($r->nariz == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->oidos == 1) ? 'Normal' : (($r->oidos == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->boca == 1) ? 'Normal' : (($r->boca == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->cuello == 1) ? 'Normal' : (($r->cuello == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->pulmones == 1) ? 'Normal' : (($r->pulmones == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->cardiovascular == 1) ? 'Normal' : (($r->cardiovascular == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->abdomen == 1) ? 'Normal' : (($r->abdomen == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->muscular == 1) ? 'Normal' : (($r->muscular == 0) ? 'Anormal' : '' )).'</td>	    								
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'examen_laboratorio'){

	    		}
	    		elseif($registro['formulario'] == 'examen_neurologico'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>
	    								<th>Nervios craneales</th>
	    								<th>Fuerza muscular</th>
	    								<th>Tono</th>
	    								<th>Movimientos anormales</th>
	    								<th>Reflejos tendinosos profundos</th>
	    								<th>Examen sensorial</th>
	    								<th>Marcha</th>
	    								<th>Postura</th>
	    								<th>Coordinación</th>
	    								<th>Función cortical superior</th>	    								
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>	    								
	    								<td>'. (($r->nervios_craneanos_normal_anormal == 1) ? 'Normal' : (($r->nervios_craneanos_normal_anormal == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->fuerza_muscular_normal_anormal == 1) ? 'Normal' : (($r->fuerza_muscular_normal_anormal == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->tono_normal_anormal == 1) ? 'Normal' : (($r->tono_normal_anormal == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->mov_anormales_normal_anormal == 1) ? 'Normal' : (($r->mov_anormales_normal_anormal == 0) ? 'Anormal' : '' )).'</td>	    								
	    								<td>'. (($r->reflejos_normal_anormal == 1) ? 'Normal' : (($r->reflejos_normal_anormal == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->examen_sensitivo_normal_anormal == 1) ? 'Normal' : (($r->examen_sensitivo_normal_anormal == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->marcha_normal_anormal == 1) ? 'Normal' : (($r->marcha_normal_anormal == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->postura_normal_anormal == 1) ? 'Normal' : (($r->postura_normal_anormal == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->coordinacion_normal_anormal == 1) ? 'Normal' : (($r->coordinacion_normal_anormal == 0) ? 'Anormal' : '' )).'</td>
	    								<td>'. (($r->funcion_cerebelosa_normal_anormal == 1) ? 'Normal' : (($r->funcion_cerebelosa_normal_anormal == 0) ? 'Anormal' : '' )).'</td>	    								
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'historia_medica'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>
	    								<th>Hipertensión arterial</th>
	    								<th>Úlcera gastrointestinal</th>
	    								<th>Diabetes mellitus</th>
	    								<th>Hipo/Hipertiroidismo</th>
	    								<th>Hiperlipidemia</th>
	    								<th>EPOC</th>
	    								<th>Enfermedad coronaria</th>
	    								<th>Rinitis</th>
	    								<th>Accidente vascular encefálico</th>
	    								<th>Asma</th>
	    								<th>Gastritis/Reflujo GE</th>	    	
	    								<th>Cefaleas matinales</th>							
	    								<th>Alergias</th>
	    								<th>Tabaquismo </th>
	    								<th>Ingesta de Alcoho</th>
	    								<th>Consumo de Drogas de abuso</th>
	    								<th>¿Ha tenido alguna intervención quirúrgica y/o cirugía?</th>
	    								<th>¿Ha donado sangre o ha participado en algún estudio clínico farmacológico en los últimos tres meses?</th>
	    								<th>¿Está recibiendo o ha recibido en el último mes, algún tratamiento farmacológico?</th>
	    								<th>¿Está recibiendo o ha recibido en el último mes, algún suplemento dietético o vitamínico?</th>
	    								<th>ANTECEDENTES FAMILIARES DE ALZHEIMER</th>
	    								<th>FECHA EN QUE PRESENTÓ PRIMEROS SÍNTOMAS ASOCIADOS A LA EA</th>
	    								<th>ANTECEDENTES MORBIDOS FAMILIARES </th>
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>	    								
	    								<td>'. (($r->hipertension == 1) ? 'Si' : (($r->hipertension == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->ulcera == 1) ? 'Si' : (($r->ulcera == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->diabetes == 1) ? 'Si' : (($r->diabetes == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->hipo_hipertiroidismo == 1) ? 'Si' : (($r->hipo_hipertiroidismo == 0) ? 'No' : '' )).'</td>	    								
	    								<td>'. (($r->hiperlipidemia == 1) ? 'Si' : (($r->hiperlipidemia == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->epoc == 1) ? 'Si' : (($r->epoc == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->coronaria == 1) ? 'Si' : (($r->coronaria == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->rinitis == 1) ? 'Si' : (($r->rinitis == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->acc_vascular == 1) ? 'Si' : (($r->acc_vascular == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->asma == 1) ? 'Si' : (($r->asma == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->gastritis == 1) ? 'Si' : (($r->gastritis == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->cefaleas == 1) ? 'Si' : (($r->cefaleas == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->alergia == 1) ? 'Si' : (($r->alergia == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->tabaquismo == 1) ? 'Si' : (($r->tabaquismo == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->ingesta_alcohol == 1) ? 'Si' : (($r->ingesta_alcohol == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->drogas == 1) ? 'Si' : (($r->drogas == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->cirugia == 1) ? 'Si' : (($r->cirugia == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->donado_sangre == 1) ? 'Si' : (($r->donado_sangre == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->tratamiento_farma == 1) ? 'Si' : (($r->tratamiento_farma == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->suplemento_dietetico == 1) ? 'Si' : (($r->suplemento_dietetico == 0) ? 'No' : '' )).'</td>
	    								<td>'. (($r->alzheimer == 1) ? 'Si' : (($r->alzheimer == 0) ? 'No' : '' )).'</td>
	    								<td>'. $r->dia_ea .'-'.  $r->mes_ea ."-". $r->anio_ea .'</td>
	    								<td>'. (($r->morbido == 1) ? 'Si' : (($r->morbido == 0) ? 'No' : '' )).'</td>
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'mmse'){
	    			
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>
	    								<th>Puntaje Total</th>	    								
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>
	    								<td>'. $r->puntaje_total .'</td>
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';

	    		}
	    		elseif($registro['formulario'] == 'muestra_de_sangre'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>	    								
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>	    								
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'npi'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>	    								
	    								<th>Puntaje Total de NPI</th>	
	    								<th>Puntaje total para Angustia de el (la) Cuidador(a)</th>	
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>	    								
	    								<td>'. $r->puntaje_total_npi .'</td>
	    								<td>'. $r->puntaje_total_para_angustia .'</td>
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'digito_directo'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>	    								
	    								<th>MSDD</th>	
	    								<th>Digitos Orden Direto (DOD) Puntaje Bruto Total</th>	
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>	    								
	    								<td>'. $r->msdd .'</td>
	    								<td>'. $r->puntaje_bruto .'</td>
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'restas'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>	    								
	    								<th>17</th>	
	    								<th>14</th>	
	    								<th>11</th>	
	    								<th>8</th>	
	    								<th>5</th>		    								
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>	    								
	    								<td>'. (($r->resta_alt_1 == 1) ? 'Correcto' : '') .'</td>
	    								<td>'. (($r->resta_alt_2 == 1) ? 'Correcto' : '') .'</td>
	    								<td>'. (($r->resta_alt_3 == 1) ? 'Correcto' : '') .'</td>
	    								<td>'. (($r->resta_alt_4 == 1) ? 'Correcto' : '') .'</td>
	    								<td>'. (($r->resta_alt_5 == 1) ? 'Correcto' : '') .'</td>	    								
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'rnm'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>	    																
	    								<th>¿Sujeto dispone de una Resonancia Magnética?</th>	
	    								<th>¿Sujeto dispone de una Tomografía Computarizada?</th>	
	    								<th>Se solicita Tomografía computarizada para el estudio</th>		    								
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>	    								
	    								<td>'. (($r->resonancia == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->tomografia == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. $r->se_solicita_tomografia .'</td>	    								
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'signos_vitales'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>
	    								<th>Estatura</th>
	    								<th>Presion Sistolica</th>
	    								<th>Presion Diastolica</th>
	    								<th>Frecuencia Cardiaca</th>
	    								<th>Frecuencia Respiratoria</th>
	    								<th>Temperatura</th>
	    								<th>Peso QRS</th>
	    								<th>IMC</th>
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>	    								
	    								<td>'. $r->estatura .'</td>
	    								<td>'. $r->presion_sistolica .'</td>
	    								<td>'. $r->presion_diastolica .'</td>
	    								<td>'. $r->frecuencia_cardiaca .'</td>
	    								<td>'. $r->frecuencia_respiratoria .'</td>
	    								<td>'. $r->temperatura .'</td>
	    								<td>'. $r->peso .'</td>
	    								<td>'. $r->imc .'</td>
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'tmt_a'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>
	    								<th>Segundos</th>	    								
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>	    								
	    								<td>'. $r->segundos .'</td>	    								
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'tmt_b'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover">
	    						<thead>
	    							<tr>
	    								<th>Sujeto</th>
	    								<th>Visita</th>
	    								<th>Realizado</th>
	    								<th>Fecha</th>
	    								<th>Segundos</th>	    								
	    							</tr>
	    						</thead>
	    						<tbody>';

	    			foreach($resultado as $r){
	    				switch ($r->etapa) {
	    					case 1 : $visita = "Selección"; break;
							case 2 : $visita = "Basal Día 1"; break;
							case 3 : $visita = "Semana 4"; break;
							case 4 : $visita = "Semana 12"; break;
							case 5 : $visita = "Término del Estudio"; break;
							case 6 : $visita = "Terminación Temprana"; break;
							default : $visita = "Selección"; break;
	    				}

	    				$tabla .= '<tr>
	    								<td>'. $r->code .'</td>
	    								<td>'. $visita .'</td>
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>
	    								<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>	    								
	    								<td>'. $r->segundos .'</td>	    								
	    							</tr>';
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}

	    	}//fin si existe resultado
	    	else{
	    		$tabla = '<div class="text-warning">No se encontraron resultados.</div>';
	    	}
    		
	    	$data['list'] = $tabla;
	    	$data['contenido'] = 'report/index';		
		

			$data['forms'] = array(''=>'',
								'adas'=>'ADAS-cog',
								'inclusion_exclusion'=>'Criterios de Inclusión/Exclusión',
								'cumplimiento'=>'Cumplimiento',
								'electrocardiograma_de_reposo'=>'Electrocardiograma de reposo (ECG)',
								'apatia'=>'Escala de evaluación de apatía',
								'hachinski_form'=>'Escala de Hachinski',
								'eq_5d_5l'=>'EQ-5D-5L',								
								'examen_fisico'=>'Examen físico',
								'examen_laboratorio'=>'Examenes de Laboratorio',
								'examen_neurologico'=>'Examen neurológico',
								'historial_medico'=>'Historia Médica',								
								'mmse'=>'MMSE',			
								'muestra_de_sangre'=>'Muestras de sangre para estudio de biomarcadores',
								'npi'=>'NPI',
								'digito_directo'=>'Prueba de dígito directo',
								'restas'=>'Prueba de restas seriadas',								
								'rnm'=>'Resonancia Magnética o Tomografía Computarizada',
								'signos_vitales'=>'Signos vitales/peso',								
								'tmt_a'=>'TMT A',
								'tmt_b'=>'TMT B');

			$this->load->view('template2', $data);


    	}
    	else{
    		$this->index();
    	}

    }
}