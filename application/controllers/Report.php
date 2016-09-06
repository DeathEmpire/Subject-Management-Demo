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

	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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

	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
	    						<thead>
	    							<tr>
	    								<th rowspan="2">Sujeto</th>
	    								<th rowspan="2">Visita</th>
	    								<th rowspan="2">Realizado</th>
	    								<th rowspan="2">Fecha</th>
	    								<th colspan="10">Hematológico</th>
	    								<th colspan="14">Bioquímico</th>
	    								<th colspan="6">Análisis de Orina</th>
	    								<th colspan="6">Otros</th>
	    							</tr>
	    							<tr>
	    								<th>Hematocrito</th>
	    								<th>Hemoglobina</th>
	    								<th>Recuento eritrocitos (RBC)</th>
	    								<th>Recuento leucocitos (WBC)</th>
	    								<th>Neutrófilos</th>
	    								<th>Linfocitos</th>
	    								<th>Monocitos</th>
	    								<th>Eosinófilos</th>
	    								<th>Basófilos</th>
	    								<th>Recuento plaquetas</th>	    								
	    								<th>Glucosa (ayunas)</th>
	    								<th>BUN</th>
	    								<th>Creatinina</th>
	    								<th>Bilirrubina total</th>
	    								<th>Proteínas totales</th>
	    								<th>Fosfatasas alcalinas</th>
	    								<th>AST</th>
	    								<th>ALT</th>
	    								<th>Calcio (Ca)</th>
	    								<th>Sodio (Na)</th>
	    								<th>Potasio (K)</th>
	    								<th>Cloro (Cl)</th>
	    								<th>Ácido úrico</th>
	    								<th>Albúmina</th>
	    								<th>pH</th>
	    								<th>Glucosa (qual)</th>
	    								<th>Proteína (qual)</th>
	    								<th>Sangre (qual)</th>
	    								<th>Cetonas</th>
	    								<th>Microscopía </th>    								
	    								<th>Homocisteina</th>
	    								<th>Perfil Tiroideo</th>
	    								<th>Nivel plasmático de V B12</th>
	    								<th>Nivel plasmático de ácido fólico</th>
	    								<th>HbA1C</th>
	    								<th>Sífilis (VDRL)</th>	    								
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
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>';
	    				if($r->realizado == 1){

	    					$tabla .= '<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>	    								
	    								
	    							<td>'. (($r->hecho_1 == 1) ? $r->hematocrito .' % '. (($r->hematocrito_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->hematocrito_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->hematocrito_nom_anom) : 'No realizado' ).'</td>	    							
	    							<td>'. (($r->hecho_2 == 1) ? $r->hemoglobina .' g/dl '. (($r->hemoglobina_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->hemoglobina_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->hemoglobina_nom_anom) : 'No realizado' ).'</td>
	    							<td>'. (($r->hecho_3 == 1) ? $r->eritocritos .' M/µl '. (($r->eritocritos_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->eritocritos_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->eritocritos_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_4 == 1) ? $r->leucocitos .' /µl '. (($r->leucocitos_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->leucocitos_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->leucocitos_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_5 == 1) ? $r->neutrofilos .' /µl '. (($r->neutrofilos_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->neutrofilos_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->neutrofilos_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_6 == 1) ? $r->linfocitos .' /µl '. (($r->linfocitos_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->linfocitos_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->linfocitos_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_7 == 1) ? $r->monocitos .' /µl '. (($r->monocitos_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->monocitos_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->monocitos_nom_anom) : 'No realizado' ).'</td>
	    							<td>'. (($r->hecho_8 == 1) ? $r->eosinofilos .' /µl '. (($r->eosinofilos_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->eosinofilos_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->eosinofilos_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_9 == 1) ? $r->basofilos .' /µl '. (($r->basofilos_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->basofilos_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->basofilos_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_10 == 1) ? $r->recuento_plaquetas .' x mm<sup>3</sup> '. (($r->recuento_plaquetas_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->recuento_plaquetas_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->recuento_plaquetas_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_11 == 1) ? $r->glucosa_ayunas .' mg/dl '. (($r->glucosa_ayunas_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->glucosa_ayunas_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->glucosa_ayunas_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_12 == 1) ? $r->bun .' mg/dl '. (($r->bun_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->bun_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->bun_nom_anom) : 'No realizado' ).'</td>
	    							<td>'. (($r->hecho_13 == 1) ? $r->creatinina .' mg/dl '. (($r->creatinina_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->creatinina_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->creatinina_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_14 == 1) ? $r->bilirrubina_total .' mg/dl '. (($r->bilirrubina_total_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->bilirrubina_total_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->bilirrubina_total_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_15 == 1) ? $r->proteinas_totales .' g/dl '. (($r->proteinas_totales_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->proteinas_totales_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->proteinas_totales_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_16 == 1) ? $r->fosfatasas_alcalinas .' U/l '. (($r->fosfatasas_alcalinas_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->fosfatasas_alcalinas_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->fosfatasas_alcalinas_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_17 == 1) ? $r->ast .' U/l '. (($r->ast_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->ast_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->ast_nom_anom) : 'No realizado' ).'</td>
	    							<td>'. (($r->hecho_18 == 1) ? $r->alt .' U/l '. (($r->alt_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->alt_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->alt_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_19 == 1) ? $r->calcio .' '. $r->calcio_unidad_medida .' '. (($r->calcio_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->calcio_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->calcio_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_20 == 1) ? $r->sodio .' '. $r->sodio_unidad_medida .' '. (($r->sodio_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->sodio_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->sodio_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_21 == 1) ? $r->potasio .' '. $r->potasio_unidad_medida .' '. (($r->potasio_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->potasio_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->potasio_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_22 == 1) ? $r->cloro .' '. $r->cloro_unidad_medida .' '. (($r->cloro_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->cloro_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->cloro_nom_anom) : 'No realizado' ).'</td>
	    							<td>'. (($r->hecho_23 == 1) ? $r->acido_urico .' mg/dl '. (($r->acido_urico_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->acido_urico_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->acido_urico_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_24 == 1) ? $r->albumina .' mg/dl '. (($r->albumina_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->albumina_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->albumina_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_25 == 1) ? $r->orina_ph .' '. (($r->orina_ph_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->orina_ph_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->orina_ph_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_26 == 1) ? $r->orina_glucosa .' '. $r->glucosa_unidad_medida .' '. (($r->orina_glucosa_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->orina_glucosa_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->orina_glucosa_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_27 == 1) ? $r->orina_proteinas .' mUI/ml '. (($r->orina_proteinas_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->orina_proteinas_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->orina_proteinas_nom_anom) : 'No realizado' ).'</td>
	    							<td>'. (($r->hecho_28 == 1) ? $r->orina_sangre .' mUI/ml '. (($r->orina_sangre_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->orina_sangre_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->orina_sangre_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_29 == 1) ? $r->orina_cetonas .' mmol/l '. (($r->orina_cetonas_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->orina_cetonas_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->orina_cetonas_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_30 == 1) ? $r->orina_microscospia .' '. (($r->orina_microscospia_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->orina_microscospia_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->orina_microscospia_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_31 == 1) ? $r->otros_sangre_homocisteina .' '. (($r->otros_sangre_homocisteina_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->otros_sangre_homocisteina_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->otros_sangre_homocisteina_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_32 == 1) ? $r->otros_perfil_tiroideo .' '. (($r->otros_perfil_tiroideo_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->otros_perfil_tiroideo_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->otros_perfil_tiroideo_nom_anom) : 'No realizado' ).'</td>
	    							<td>'. (($r->hecho_33 == 1) ? $r->otros_nivel_b12 .' '. (($r->otros_nivel_b12 == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->otros_nivel_b12) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->otros_nivel_b12) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_34 == 1) ? $r->otros_acido_folico .' '. (($r->otros_acido_folico_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->otros_acido_folico_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->otros_acido_folico_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_35 == 1) ? $r->otros_hba1c .' '. (($r->otros_hba1c_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->otros_hba1c_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->otros_hba1c_nom_anom) : 'No realizado' ).'</td>
									<td>'. (($r->hecho_36 == 1) ? $r->sifilis .' '. (($r->sifilis_nom_anom == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($r->sifilis_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $r->sifilis_nom_anom) : 'No realizado' ).'</td>
    							</tr>';
	    					}
	    					else{
	    						$tabla .= '<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    									<td></td>
	    								</tr>';
	    					}
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'examen_neurologico'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    								<td>'. (($r->realizado == 1) ? 'Si' : 'No') .'</td>';
	    				if($r->realizado == 1){

	    					$tabla .= '<td>'. (($r->fecha != '0000-00-00') ?  date('d/m/Y', strtotime($r->fecha)) : '') .'</td>	    								
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
	    					else{
	    						$tabla .= '<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
	    					}
	    			}

	    			$tabla .= '</tbody>
	    					</table>';
	    		}
	    		elseif($registro['formulario'] == 'historia_medica'){
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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
	    			$tabla = '<table class="table table-striped table-bordered table-hover" id="tabla">
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

    public function mostrarPdf(){

    	$html = $this->input->post('datos');
    	$nombre_archivo = "Reporte_". date('YmdHis') .'.pdf';
    	$ruta = "./files/". $nombre_archivo;

    	$this->load->library('m_pdf');    	
    	$this->m_pdf->pdf->WriteHTML($html);
    	$this->m_pdf->pdf->Output($ruta, "D");
    	
    }
    
}