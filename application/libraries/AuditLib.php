<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

class AuditLib {

	function __construct() {
		$this->CI = & get_instance(); // Esto para acceder a la instancia que carga la librería

		$this->CI->load->model('Model_Audit');        
		$this->CI->load->model('Model_Subject'); 
    }

    function save_audit($description, $subject_id = ''){

    	if(isset($subject_id) AND !empty($subject_id)){
    		$subject = $this->CI->Model_Subject->find($subject_id);
    		if(isset($subject) AND !empty($subject)){
    			$description .= " en el sujeto ". $subject->code;
    		}
    	}

    	$audit_record['user_id'] = $this->CI->session->userdata("usuario_id");
		$audit_record['user_name'] = $this->CI->session->userdata("usuario");
		$audit_record['date'] = date("Y-m-d H:i:s");
		$audit_record['description'] = $description;
    	
    	$this->CI->Model_Audit->insert($audit_record);
    }

    //leer tablas de auditorias sobre un form especifico
    public function audit($tabla, $id){

        $data = $this->CI->Model_Audit->buscarAudit($tabla, $id);

        if(isset($data) AND !empty($data)){

            //por cada tabla diferente formatear los campos y los cambios que ha tenido.
            $salida = '';
            
            $contador = 0; //si es el primer registro _old es el ingreso original para lo demas solo mostrar el _new
            
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            foreach ($data as $key => $value) {
                if($tabla == 'adas_audit'){
                    
                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                        $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th rowspan='3'>Realizado</th>
                                            <th rowspan='3'>Fecha</th>
                                            <th rowspan='3'>Puntaje Total</th>
                                            <th colspan='9'>1.- Tarea de Recordar palabras</th>
                                            <th colspan='4' rowspan='2'>2.- Ordenes</th>
                                            <th colspan='5' rowspan='2'>3.- Praxis Constructiva</th>
                                            <th colspan='4' rowspan='2'>4.- Tarea de recordar palabras diferidas</th>
                                            <th colspan='4' rowspan='2'>5.- Tarea de nombrar</th>
                                            <th colspan='4' rowspan='2'>6.- Praxis Ideacional</th>
                                            <th colspan='4' rowspan='2'>7.- Orientación</th>
                                            <th colspan='5' rowspan='2'>8.- Tarea de reconocer palabras</th>
                                            <th rowspan='2'>9.- Recordando las instrucciones de la prueba</th>
                                            <th rowspan='2'>10.- Comprensión</th>
                                            <th rowspan='2'>11.- Dificultad en la selección de palabras</th>
                                            <th rowspan='2'>12.- Habilidad para el lenguaje hablado</th>
                                            <th rowspan='3'>Ingresado/Modificado Por</th>
                                        </tr>
                                        <tr>
                                            <th colspan='2'>Ensayo 1</th>
                                            <th colspan='2'>Ensayo 2</th>
                                            <th colspan='5'>Ensayo 3</th>                                                
                                        </tr>        
                                        <tr>
                                            <th>Palabras recordadas</th>
                                            <th>Palabras no recordadas</th>
                                            <th>Palabras recordadas</th>
                                            <th>Palabras no recordadas</th>
                                            <th>Palabras recordadas</th>
                                            <th>Palabras no recordadas</th>
                                            <th>Hora de finalizacion</th>
                                            <th>Si alguna tarea no se administró o no se completó</th>
                                            <th>Puntuación Total</th>

                                            <th>Total correctas</th>
                                            <th>Total incorrectas</th>
                                            <th>Si alguna tarea no se administró o no se completó</th>
                                            <th>Puntuación Total</th>

                                            <th>Total correctas</th>
                                            <th>Total incorrectas</th>
                                            <th>Paciente no intentó dibujar ninguna forma</th>
                                            <th>Si alguna tarea no se administró o no se completó</th>
                                            <th>Puntuación Total</th>

                                            <th>Total recordadas</th>
                                            <th>Total no recordadas</th>
                                            <th>Hora de inicio</th>
                                            <th>Puntuación Total</th>

                                            <th>Total correctas</th>
                                            <th>Total incorrectas</th>            
                                            <th>Si alguna tarea no se administró o no se completó</th>
                                            <th>Puntuación Total</th>

                                            <th>Total correctas</th>
                                            <th>Total incorrectas</th>            
                                            <th>Si alguna tarea no se administró o no se completó</th>
                                            <th>Puntuación Total</th>

                                            <th>Total correctas</th>
                                            <th>Total incorrectas</th>            
                                            <th>Si alguna tarea no se administró o no se completó</th>
                                            <th>Puntuación Total</th>

                                            <th>Total correctas</th>
                                            <th>Total incorrectas</th>
                                            <th>Cantidad de recordatorios</th>            
                                            <th>Si alguna tarea no se administró o no se completó</th>
                                            <th>Puntuación Total</th>           

                                            <th>Puntuación Total</th>

                                            <th>Puntuación Total</th>

                                            <th>Puntuación Total</th>

                                            <th>Puntuación Total</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>";

                                    $salida .= '<tr>
                                        <td>'. (($value->realizado_old == 1) ? 'Si' : 'No') .'</td>
                                        <td>'. date('d/m/Y H:i', strtotime($value->updated_at_old)) .'</td>
                                        <td>'. $value->puntaje_total_old .'</td>
                                        
                                        <td>'. $value->palabras_recordadas_1_old .'</td>
                                        <td>'. $value->palabras_no_recordadas_1_old .'</td>
                                        <td>'. $value->palabras_recordadas_2_old .'</td>
                                        <td>'. $value->palabras_no_recordadas_2_old .'</td>
                                        <td>'. $value->palabras_recordadas_3_old .'</td>
                                        <td>'. $value->palabras_no_recordadas_3_old .'</td>
                                        <td>'. $value->hora_finalizacion_hora_old .':'. $value->hora_finalizacion_minuto_old .'</td>
                                        <td>'. $value->no_administro_1_old .'</td>
                                        <td>'. $value->puntaje_total_1_old   .'</td>

                                        <td>'. $value->total_correctas_2_old .'</td>
                                        <td>'. $value->total_incorrectas_2_old .'</td>
                                        <td>'. $value->no_administro_2_old .'</td>
                                        <td>'. $value->puntuacion_2_old .'</td>
                                        
                                        <td>'. $value->total_correctas_3_old .'</td>
                                        <td>'. $value->total_incorrectas_3_old .'</td>
                                        <td>'. $value->paciente_no_dibujo_3_old .'</td>
                                        <td>'. $value->no_administro_3_old .'</td>
                                        <td>'. $value->puntuacion_3_old .'</td>

                                        <td>'. $value->total_recordadas_4_old .'</td>
                                        <td>'. $value->total_no_recordadas_4_old .'</td>
                                        <td>'. $value->hora_finalizacion_4_hora_old .':'. $value->hora_finalizacion_4_minuto_old .'</td>
                                        <td>'. $value->puntuacion_4_old .'</td>

                                        <td>'. $value->total_correctas_5_old .'</td>
                                        <td>'. $value->total_incorrectas_5_old .'</td>
                                        <td>'. $value->no_administro_5_old .'</td>
                                        <td>'. $value->puntuacion_5_old .'</td>

                                        <td>'. $value->total_correctas_6_old .'</td>
                                        <td>'. $value->total_incorrectas_6_old .'</td>
                                        <td>'. $value->no_administro_6_old .'</td>
                                        <td>'. $value->puntuacion_6_old .'</td>

                                        <td>'. $value->total_correctas_7_old .'</td>
                                        <td>'. $value->total_incorrectas_7_old .'</td>
                                        <td>'. $value->no_administro_7_old .'</td>
                                        <td>'. $value->puntuacion_7_old .'</td>

                                        <td>'. $value->total_correctas_8_old .'</td>
                                        <td>'. $value->total_incorrectas_8_old .'</td>
                                        <td>'. $value->cantidad_recordadas_8_old .'</td>
                                        <td>'. $value->no_administro_8_old .'</td>
                                        <td>'. $value->puntuacion_8_old .'</td>

                                        <td>'. $value->puntuacion_9_old .'</td>

                                        <td>'. $value->puntuacion_10_old .'</td>

                                        <td>'. $value->puntuacion_11_old .'</td>

                                        <td>'. $value->puntuacion_12_old .'</td>
                                        <td>'. $value->usuario_creacion_old .'</td>
                                    </tr>';

                                    $salida .= '<tr>
                                        <td>'. (($value->realizado_new == 1) ? 'Si' : 'No') .'</td>
                                        <td>'. date('d/m/Y H:i', strtotime($value->updated_at_new)) .'</td>
                                        <td>'. $value->puntaje_total_new .'</td>
                                        
                                        <td>'. $value->palabras_recordadas_1_new .'</td>
                                        <td>'. $value->palabras_no_recordadas_1_new .'</td>
                                        <td>'. $value->palabras_recordadas_2_new .'</td>
                                        <td>'. $value->palabras_no_recordadas_2_new .'</td>
                                        <td>'. $value->palabras_recordadas_3_new .'</td>
                                        <td>'. $value->palabras_no_recordadas_3_new .'</td>
                                        <td>'. $value->hora_finalizacion_hora_new .':'. $value->hora_finalizacion_minuto_new .'</td>
                                        <td>'. $value->no_administro_1_new .'</td>
                                        <td>'. $value->puntaje_total_1_new   .'</td>

                                        <td>'. $value->total_correctas_2_new .'</td>
                                        <td>'. $value->total_incorrectas_2_new .'</td>
                                        <td>'. $value->no_administro_2_new .'</td>
                                        <td>'. $value->puntuacion_2_new .'</td>
                                        
                                        <td>'. $value->total_correctas_3_new .'</td>
                                        <td>'. $value->total_incorrectas_3_new .'</td>
                                        <td>'. $value->paciente_no_dibujo_3_new .'</td>
                                        <td>'. $value->no_administro_3_new .'</td>
                                        <td>'. $value->puntuacion_3_new .'</td>

                                        <td>'. $value->total_recordadas_4_new .'</td>
                                        <td>'. $value->total_no_recordadas_4_new .'</td>
                                        <td>'. $value->hora_finalizacion_4_hora_new .':'. $value->hora_finalizacion_4_minuto_new .'</td>
                                        <td>'. $value->puntuacion_4_new .'</td>

                                        <td>'. $value->total_correctas_5_new .'</td>
                                        <td>'. $value->total_incorrectas_5_new .'</td>
                                        <td>'. $value->no_administro_5_new .'</td>
                                        <td>'. $value->puntuacion_5_new .'</td>

                                        <td>'. $value->total_correctas_6_new .'</td>
                                        <td>'. $value->total_incorrectas_6_new .'</td>
                                        <td>'. $value->no_administro_6_new .'</td>
                                        <td>'. $value->puntuacion_6_new .'</td>

                                        <td>'. $value->total_correctas_7_new .'</td>
                                        <td>'. $value->total_incorrectas_7_new .'</td>
                                        <td>'. $value->no_administro_7_new .'</td>
                                        <td>'. $value->puntuacion_7_new .'</td>

                                        <td>'. $value->total_correctas_8_new .'</td>
                                        <td>'. $value->total_incorrectas_8_new .'</td>
                                        <td>'. $value->cantidad_recordadas_8_new .'</td>
                                        <td>'. $value->no_administro_8_new .'</td>
                                        <td>'. $value->puntuacion_8_new .'</td>

                                        <td>'. $value->puntuacion_9_new .'</td>

                                        <td>'. $value->puntuacion_10_new .'</td>

                                        <td>'. $value->puntuacion_11_new .'</td>

                                        <td>'. $value->puntuacion_12_new .'</td>

                                        <td>'. $value->usuario_actualizacion_new .'</td>
                                    </tr>';
                    }
                    else{
                        $salida .= '<tr>
                                        <td>'. (($value->realizado_new == 1) ? 'Si' : 'No') .'</td>
                                        <td>'. date('d/m/Y H:i', strtotime($value->updated_at_new)) .'</td>
                                        <td>'. $value->puntaje_total_new .'</td>
                                        
                                        <td>'. $value->palabras_recordadas_1_new .'</td>
                                        <td>'. $value->palabras_no_recordadas_1_new .'</td>
                                        <td>'. $value->palabras_recordadas_2_new .'</td>
                                        <td>'. $value->palabras_no_recordadas_2_new .'</td>
                                        <td>'. $value->palabras_recordadas_3_new .'</td>
                                        <td>'. $value->palabras_no_recordadas_3_new .'</td>
                                        <td>'. $value->hora_finalizacion_hora_new .':'. $value->hora_finalizacion_minuto_new .'</td>
                                        <td>'. $value->no_administro_1_new .'</td>
                                        <td>'. $value->puntaje_total_1_new   .'</td>

                                        <td>'. $value->total_correctas_2_new .'</td>
                                        <td>'. $value->total_incorrectas_2_new .'</td>
                                        <td>'. $value->no_administro_2_new .'</td>
                                        <td>'. $value->puntuacion_2_new .'</td>
                                        
                                        <td>'. $value->total_correctas_3_new .'</td>
                                        <td>'. $value->total_incorrectas_3_new .'</td>
                                        <td>'. $value->paciente_no_dibujo_3_new .'</td>
                                        <td>'. $value->no_administro_3_new .'</td>
                                        <td>'. $value->puntuacion_3_new .'</td>

                                        <td>'. $value->total_recordadas_4_new .'</td>
                                        <td>'. $value->total_no_recordadas_4_new .'</td>
                                        <td>'. $value->hora_finalizacion_4_hora_new .':'. $value->hora_finalizacion_4_minuto_new .'</td>
                                        <td>'. $value->puntuacion_4_new .'</td>

                                        <td>'. $value->total_correctas_5_new .'</td>
                                        <td>'. $value->total_incorrectas_5_new .'</td>
                                        <td>'. $value->no_administro_5_new .'</td>
                                        <td>'. $value->puntuacion_5_new .'</td>

                                        <td>'. $value->total_correctas_6_new .'</td>
                                        <td>'. $value->total_incorrectas_6_new .'</td>
                                        <td>'. $value->no_administro_6_new .'</td>
                                        <td>'. $value->puntuacion_6_new .'</td>

                                        <td>'. $value->total_correctas_7_new .'</td>
                                        <td>'. $value->total_incorrectas_7_new .'</td>
                                        <td>'. $value->no_administro_7_new .'</td>
                                        <td>'. $value->puntuacion_7_new .'</td>

                                        <td>'. $value->total_correctas_8_new .'</td>
                                        <td>'. $value->total_incorrectas_8_new .'</td>
                                        <td>'. $value->cantidad_recordadas_8_new .'</td>
                                        <td>'. $value->no_administro_8_new .'</td>
                                        <td>'. $value->puntuacion_8_new .'</td>

                                        <td>'. $value->puntuacion_9_new .'</td>

                                        <td>'. $value->puntuacion_10_new .'</td>

                                        <td>'. $value->puntuacion_11_new .'</td>

                                        <td>'. $value->puntuacion_12_new .'</td>
                                        <td>'. $value->usuario_actualizacion_new .'</td>
                                    </tr>';
                    }

                    

                    $contador++;
                }
                elseif($tabla == 'adverse_event_form_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion

                        $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Etapa</th>
                                            <th>Categoría</th>
                                            <th>Descripción</th>
                                            <th>Narrativa</th>
                                            <th>Fecha Inicio</th>
                                            <th>Continúa</th>
                                            <th>Fecha Resolución</th>
                                            <th>Evaluación de Severidad</th>
                                            <th>¿Está el Evento relacionado con el Producto de Investigación?</th>
                                            <th>¿Es un Evento Adverso Serio? (SAE)?</th>
                                            <th>Acción tomada/Tratamiento administrado</th>
                                            <th>Se toma acción con el Producto de Investigación</th>
                                            <th>Ingresado/Modificado Por</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>". (($value->created_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->created_old)) : '') ."</td>
                                            <td>". $value->stage_old ."</td>
                                            <td>". $value->event_category_old ."</td>
                                            <td>". $value->event_category_description_old ."</td>
                                            <td>". $value->event_category_narrative_old ."</td>
                                            <td>". (($value->date_of_onset_old != '0000-00-00') ? date('d/m/Y H:i',  strtotime($value->date_of_onset_old)) : '') ."</td>
                                            <td>". (($value->continuing_old == 1) ? 'Si' : 'No') ."</td>                                            
                                            <td>". (($value->date_of_resolution_old != '0000-00-00') ? date('d/m/Y H:i',  strtotime($value->date_of_resolution_old)) : '') ."</td>
                                            <td>". (($value->assessment_of_severity_old == 1) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->assessment_of_casuality_old == 1) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->sae_old == 1) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->action_taken_medication_old == 1) ? 'Medicacion' : (($value->action_taken_hospitalization_old == 1) ? 'Hospitalizacion' : (($value->action_taken_none_old == 1) ? 'Ninguna' : '' ))) ."</td>
                                            <td>". $value->action_taken_on_investigation_product_old ."</td>
                                            <td>". $value->usuario_actualizacion_old ."</td>                                            
                                        </tr>";
                                $salida .= "<tr>
                                                <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)) : '') ."</td>
                                                <td>". $value->stage_new ."</td>
                                                <td>". $value->event_category_new ."</td>
                                                <td>". $value->event_category_description_new ."</td>
                                                <td>". $value->event_category_narrative_new ."</td>
                                                <td>". (($value->date_of_onset_new != '0000-00-00') ? date('d/m/Y H:i',  strtotime($value->date_of_onset_new)) : '') ."</td>
                                                <td>". (($value->continuing_new == 1) ? 'Si' : 'No') ."</td>                                            
                                                <td>". (($value->date_of_resolution_new != '0000-00-00') ? date('d/m/Y H:i',  strtotime($value->date_of_resolution_new)) : '') ."</td>
                                                <td>". (($value->assessment_of_severity_new == 1) ? 'Si' : 'No') ."</td>
                                                <td>". (($value->assessment_of_casuality_new == 1) ? 'Si' : 'No') ."</td>
                                                <td>". (($value->sae_new == 1) ? 'Si' : 'No') ."</td>
                                                <td>". (($value->action_taken_medication_new == 1) ? 'Medicacion' : (($value->action_taken_hospitalization_new == 1) ? 'Hospitalizacion' : (($value->action_taken_none_new == 1) ? 'Ninguna' : '' ))) ."</td>
                                                <td>". $value->action_taken_on_investigation_product_new ."</td>
                                                <td>". $value->usuario_actualizacion_new ."</td>                                            
                                            </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)) : '') ."</td>
                                        <td>". $value->stage_new ."</td>
                                        <td>". $value->event_category_new ."</td>
                                        <td>". $value->event_category_description_new ."</td>
                                        <td>". $value->event_category_narrative_new ."</td>
                                        <td>". (($value->date_of_onset_new != '0000-00-00') ? date('d/m/Y H:i',  strtotime($value->date_of_onset_new)) : '') ."</td>
                                        <td>". (($value->continuing_new == 1) ? 'Si' : 'No') ."</td>                                            
                                        <td>". (($value->date_of_resolution_new != '0000-00-00') ? date('d/m/Y H:i',  strtotime($value->date_of_resolution_new)) : '') ."</td>
                                        <td>". (($value->assessment_of_severity_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->assessment_of_casuality_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->sae_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->action_taken_medication_new == 1) ? 'Medicacion' : (($value->action_taken_hospitalization_new == 1) ? 'Hospitalizacion' : (($value->action_taken_none_new == 1) ? 'Ninguna' : '' ))) ."</td>
                                        <td>". $value->action_taken_on_investigation_product_new ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>                                            
                                    </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'apatia_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                         $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Realizado</th>
                                            <th>Fecha</th>
                                            <th>El/ella tiene interés en las cosas</th>
                                            <th>Hace cosas durante el día</th>
                                            <th>Comienza a hacer cosas que son importantes para él / ella</th>
                                            <th>Está interesado en tener cosas nuevas</th>
                                            <th>Esta interesado en aprender cosas nuevas</th>
                                            <th>Pone poco esfuerzo en las cosas</th>
                                            <th>Se enfrenta a la vida con intensidad</th>
                                            <th>Termina los trabajos que son importantes para él / ella</th>
                                            <th>Ocupa su tiempo haciendo cosas que son de su interés</th>
                                            <th>Alguien debe decirle lo que hacer cada día</th>
                                            <th>Esta menos preocupada de sus problemas que lo que debiera</th>
                                            <th>Tiene amigos</th>
                                            <th>Estar junto a sus amigos es importante para él / ella</th>
                                            <th>Cuando algo bueno pasa, él / ella se alegra</th>
                                            <th>Tiene una adecuada comprensión de sus problemas</th>
                                            <th>Se mantiene, durante el día, haciendo cosas importantes para él / ella</th>
                                            <th>Tiene iniciativa</th>
                                            <th>Tiene motivación</th>
                                            <th>Ingresado/Modificado Por</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>". (($value->apatia_realizado_old == 1) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->apatia_fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->apatia_fecha_old)) : '') ."</td>
                                            <td>". (($value->apatia_1_old == 3) ? 'No es verdadero' : (($value->apatia_1_old == 2) ? 'Levemente verdadero' : (($value->apatia_1_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_1_old == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_2_old == 3) ? 'No es verdadero' : (($value->apatia_2_old == 2) ? 'Levemente verdadero' : (($value->apatia_2_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_2_old == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_3_old == 3) ? 'No es verdadero' : (($value->apatia_3_old == 2) ? 'Levemente verdadero' : (($value->apatia_3_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_3_old == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_4_old == 3) ? 'No es verdadero' : (($value->apatia_4_old == 2) ? 'Levemente verdadero' : (($value->apatia_4_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_4_old == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_5_old == 3) ? 'No es verdadero' : (($value->apatia_5_old == 2) ? 'Levemente verdadero' : (($value->apatia_5_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_5_old == '0') ? 'Verdadero' : '' )))) ."</td>                                            
                                            <td>". (($value->apatia_6_old == '0') ? 'No es verdadero' : (($value->apatia_6_old == 1) ? 'Levemente verdadero' : (($value->apatia_6_old == 2) ? 'Parcialmente verdadero' : (($value->apatia_6_old == 3) ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_7_old == 3) ? 'No es verdadero' : (($value->apatia_7_old == 2) ? 'Levemente verdadero' : (($value->apatia_7_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_7_old == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_8_old == 3) ? 'No es verdadero' : (($value->apatia_8_old == 2) ? 'Levemente verdadero' : (($value->apatia_8_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_8_old == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_9_old == 3) ? 'No es verdadero' : (($value->apatia_9_old == 2) ? 'Levemente verdadero' : (($value->apatia_9_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_9_old == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_10_old == '0') ? 'No es verdadero' : (($value->apatia_10_old == 1) ? 'Levemente verdadero' : (($value->apatia_10_old == 2) ? 'Parcialmente verdadero' : (($value->apatia_10_old == 3) ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_11_old == '0') ? 'No es verdadero' : (($value->apatia_11_old == 1) ? 'Levemente verdadero' : (($value->apatia_11_old == 2) ? 'Parcialmente verdadero' : (($value->apatia_11_old == 3) ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_12_old == 3) ? 'No es verdadero' : (($value->apatia_12_old == 2) ? 'Levemente verdadero' : (($value->apatia_12_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_12_old == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_13_old == 3) ? 'No es verdadero' : (($value->apatia_13_old == 2) ? 'Levemente verdadero' : (($value->apatia_13_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_13_old == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_14_old == 3) ? 'No es verdadero' : (($value->apatia_14_old == 2) ? 'Levemente verdadero' : (($value->apatia_14_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_14_old == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_15_old == 3) ? 'No es verdadero' : (($value->apatia_15_old == 2) ? 'Levemente verdadero' : (($value->apatia_15_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_15_old == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_16_old == 3) ? 'No es verdadero' : (($value->apatia_16_old == 2) ? 'Levemente verdadero' : (($value->apatia_16_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_16_old == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_17_old == 3) ? 'No es verdadero' : (($value->apatia_17_old == 2) ? 'Levemente verdadero' : (($value->apatia_17_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_17_old == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_18_old == 3) ? 'No es verdadero' : (($value->apatia_18_old == 2) ? 'Levemente verdadero' : (($value->apatia_18_old == 1) ? 'Parcialmente verdadero' : (($value->apatia_18_old == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". $value->usuario_creacion_old ."</td>
                                        </tr>";
                            $salida .= "<tr>
                                            <td>". (($value->apatia_realizado_new == 1) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->apatia_fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->apatia_fecha_new)) : '') ."</td>
                                            <td>". (($value->apatia_1_new == 3) ? 'No es verdadero' : (($value->apatia_1_new == 2) ? 'Levemente verdadero' : (($value->apatia_1_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_1_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_2_new == 3) ? 'No es verdadero' : (($value->apatia_2_new == 2) ? 'Levemente verdadero' : (($value->apatia_2_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_2_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_3_new == 3) ? 'No es verdadero' : (($value->apatia_3_new == 2) ? 'Levemente verdadero' : (($value->apatia_3_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_3_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_4_new == 3) ? 'No es verdadero' : (($value->apatia_4_new == 2) ? 'Levemente verdadero' : (($value->apatia_4_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_4_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_5_new == 3) ? 'No es verdadero' : (($value->apatia_5_new == 2) ? 'Levemente verdadero' : (($value->apatia_5_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_5_new == '0') ? 'Verdadero' : '' )))) ."</td>                                            
                                            <td>". (($value->apatia_6_new == '0') ? 'No es verdadero' : (($value->apatia_6_new == 1) ? 'Levemente verdadero' : (($value->apatia_6_new == 2) ? 'Parcialmente verdadero' : (($value->apatia_6_new == 3) ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_7_new == 3) ? 'No es verdadero' : (($value->apatia_7_new == 2) ? 'Levemente verdadero' : (($value->apatia_7_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_7_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_8_new == 3) ? 'No es verdadero' : (($value->apatia_8_new == 2) ? 'Levemente verdadero' : (($value->apatia_8_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_8_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_9_new == 3) ? 'No es verdadero' : (($value->apatia_9_new == 2) ? 'Levemente verdadero' : (($value->apatia_9_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_9_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_10_new == '0') ? 'No es verdadero' : (($value->apatia_10_new == 1) ? 'Levemente verdadero' : (($value->apatia_10_new == 2) ? 'Parcialmente verdadero' : (($value->apatia_10_new == 3) ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_11_new == '0') ? 'No es verdadero' : (($value->apatia_11_new == 1) ? 'Levemente verdadero' : (($value->apatia_11_new == 2) ? 'Parcialmente verdadero' : (($value->apatia_11_new == 3) ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_12_new == 3) ? 'No es verdadero' : (($value->apatia_12_new == 2) ? 'Levemente verdadero' : (($value->apatia_12_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_12_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_13_new == 3) ? 'No es verdadero' : (($value->apatia_13_new == 2) ? 'Levemente verdadero' : (($value->apatia_13_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_13_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_14_new == 3) ? 'No es verdadero' : (($value->apatia_14_new == 2) ? 'Levemente verdadero' : (($value->apatia_14_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_14_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_15_new == 3) ? 'No es verdadero' : (($value->apatia_15_new == 2) ? 'Levemente verdadero' : (($value->apatia_15_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_15_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_16_new == 3) ? 'No es verdadero' : (($value->apatia_16_new == 2) ? 'Levemente verdadero' : (($value->apatia_16_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_16_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_17_new == 3) ? 'No es verdadero' : (($value->apatia_17_new == 2) ? 'Levemente verdadero' : (($value->apatia_17_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_17_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". (($value->apatia_18_new == 3) ? 'No es verdadero' : (($value->apatia_18_new == 2) ? 'Levemente verdadero' : (($value->apatia_18_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_18_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                            <td>". $value->usuario_actualizacion_new ."</td>
                                        </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->apatia_realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->apatia_fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->apatia_fecha_new)) : '') ."</td>
                                        <td>". (($value->apatia_1_new == 3) ? 'No es verdadero' : (($value->apatia_1_new == 2) ? 'Levemente verdadero' : (($value->apatia_1_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_1_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_2_new == 3) ? 'No es verdadero' : (($value->apatia_2_new == 2) ? 'Levemente verdadero' : (($value->apatia_2_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_2_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_3_new == 3) ? 'No es verdadero' : (($value->apatia_3_new == 2) ? 'Levemente verdadero' : (($value->apatia_3_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_3_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_4_new == 3) ? 'No es verdadero' : (($value->apatia_4_new == 2) ? 'Levemente verdadero' : (($value->apatia_4_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_4_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_5_new == 3) ? 'No es verdadero' : (($value->apatia_5_new == 2) ? 'Levemente verdadero' : (($value->apatia_5_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_5_new == '0') ? 'Verdadero' : '' )))) ."</td>                                            
                                        <td>". (($value->apatia_6_new == '0') ? 'No es verdadero' : (($value->apatia_6_new == 1) ? 'Levemente verdadero' : (($value->apatia_6_new == 2) ? 'Parcialmente verdadero' : (($value->apatia_6_new == 3) ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_7_new == 3) ? 'No es verdadero' : (($value->apatia_7_new == 2) ? 'Levemente verdadero' : (($value->apatia_7_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_7_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_8_new == 3) ? 'No es verdadero' : (($value->apatia_8_new == 2) ? 'Levemente verdadero' : (($value->apatia_8_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_8_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_9_new == 3) ? 'No es verdadero' : (($value->apatia_9_new == 2) ? 'Levemente verdadero' : (($value->apatia_9_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_9_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_10_new == '0') ? 'No es verdadero' : (($value->apatia_10_new == 1) ? 'Levemente verdadero' : (($value->apatia_10_new == 2) ? 'Parcialmente verdadero' : (($value->apatia_10_new == 3) ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_11_new == '0') ? 'No es verdadero' : (($value->apatia_11_new == 1) ? 'Levemente verdadero' : (($value->apatia_11_new == 2) ? 'Parcialmente verdadero' : (($value->apatia_11_new == 3) ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_12_new == 3) ? 'No es verdadero' : (($value->apatia_12_new == 2) ? 'Levemente verdadero' : (($value->apatia_12_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_12_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_13_new == 3) ? 'No es verdadero' : (($value->apatia_13_new == 2) ? 'Levemente verdadero' : (($value->apatia_13_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_13_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_14_new == 3) ? 'No es verdadero' : (($value->apatia_14_new == 2) ? 'Levemente verdadero' : (($value->apatia_14_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_14_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_15_new == 3) ? 'No es verdadero' : (($value->apatia_15_new == 2) ? 'Levemente verdadero' : (($value->apatia_15_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_15_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_16_new == 3) ? 'No es verdadero' : (($value->apatia_16_new == 2) ? 'Levemente verdadero' : (($value->apatia_16_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_16_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_17_new == 3) ? 'No es verdadero' : (($value->apatia_17_new == 2) ? 'Levemente verdadero' : (($value->apatia_17_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_17_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                        <td>". (($value->apatia_18_new == 3) ? 'No es verdadero' : (($value->apatia_18_new == 2) ? 'Levemente verdadero' : (($value->apatia_18_new == 1) ? 'Parcialmente verdadero' : (($value->apatia_18_new == '0') ? 'Verdadero' : '' )))) ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                    </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'concomitant_medication_form_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                         $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Nombre Comercial</th>
                                            <th>Nombre Genérico</th>
                                            <th>Indicación</th>
                                            <th>Dosis total diaria</th>
                                            <th>Frecuencia</th>                                            
                                            <th>Ruta</th>
                                            <th>Fecha de inicio</th>
                                            <th>Continúa</th>
                                            <th>Fecha término</th>
                                            <th>Ingresado/Modificado Por</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>". $value->brand_name_old ."</td>
                                            <td>". $value->generic_name_old ."</td>
                                            <td>". $value->indication_old ."</td>
                                            <td>". $value->daily_dose_old ."</td>
                                            <td>". $value->frequency_old ."</td>
                                            <td>". $value->route_old ."</td>
                                            <td>". (($value->start_date_old != '0000-00-00') ? date('d/m/Y', strtotime($value->start_date_old)) : '') ."</td>
                                            <td>". (($value->on_going_old == 1) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->end_date_old != '0000-00-00') ? date('d/m/Y', strtotime($value->end_date_old)) : '') ."</td>
                                            <td>". $value->usuario_actualizacion_old ."</td>                                            
                                        </tr>";
                        $salida .= "<tr>
                                        <td>". $value->brand_name_new ."</td>
                                        <td>". $value->generic_name_new ."</td>
                                        <td>". $value->indication_new ."</td>
                                        <td>". $value->daily_dose_new ."</td>
                                        <td>". $value->frequency_new ."</td>
                                        <td>". $value->route_new ."</td>
                                        <td>". (($value->start_date_new != '0000-00-00') ? date('d/m/Y', strtotime($value->start_date_new)) : '') ."</td>
                                        <td>". (($value->on_going_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->end_date_new != '0000-00-00') ? date('d/m/Y', strtotime($value->end_date_new)) : '') ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>                                            
                                    </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                        <td>". $value->brand_name_new ."</td>
                                        <td>". $value->generic_name_new ."</td>
                                        <td>". $value->indication_new ."</td>
                                        <td>". $value->daily_dose_new ."</td>
                                        <td>". $value->frequency_new ."</td>
                                        <td>". $value->route_new ."</td>
                                        <td>". (($value->start_date_new != '0000-00-00') ? date('d/m/Y', strtotime($value->start_date_new)) : '') ."</td>
                                        <td>". (($value->on_going_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->end_date_new != '0000-00-00') ? date('d/m/Y', strtotime($value->end_date_new)) : '') ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>                                            
                                    </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'cumplimiento_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                         $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Realizado</th>
                                            <th>Fecha</th>
                                            <th>Numero cápsulas entregadas</th>
                                            <th>Numero cápsulas utilizadas</th>
                                            <th>Numero cápsulas devueltas</th>
                                            <th>Se perdio alguna cápsula</th>
                                            <th>Numero de cápsulas perdidas</th>
                                            <th>Días (desde entrega anterior hasta Día de visita)</th>
                                            <th>% cumplimiento</th>
                                            <th>Ingresado/Modificado Por</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>". (($value->realizado_old == 1) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>
                                            <td>". $value->comprimidos_entregados_old ."</td>
                                            <td>". $value->comprimidos_utilizados_old ."</td>
                                            <td>". $value->comprimidos_devueltos_old ."</td>
                                            <td>". (($value->se_perdio_algun_comprimido_old == 1) ? 'Si' : 'No') ."</td>
                                            <td>". $value->comprimidos_perdidos_old ."</td>
                                            <td>". $value->dias_old ."</td>
                                            <td>". $value->porcentaje_cumplimiento_old ."</td>
                                            <td>". $value->usuario_creacion_old ."</td>    
                                        </tr>";

                        $salida .= "<tr>
                                            <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                            <td>". $value->comprimidos_entregados_new ."</td>
                                            <td>". $value->comprimidos_utilizados_new ."</td>
                                            <td>". $value->comprimidos_devueltos_new ."</td>
                                            <td>". (($value->se_perdio_algun_comprimido_new == 1) ? 'Si' : 'No') ."</td>
                                            <td>". $value->comprimidos_perdidos_new ."</td>
                                            <td>". $value->dias_new ."</td>
                                            <td>". $value->porcentaje_cumplimiento_new ."</td>
                                            <td>". $value->usuario_actualizacion_new ."</td>    
                                        </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                            <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                            <td>". $value->comprimidos_entregados_new ."</td>
                                            <td>". $value->comprimidos_utilizados_new ."</td>
                                            <td>". $value->comprimidos_devueltos_new ."</td>
                                            <td>". (($value->se_perdio_algun_comprimido_new == 1) ? 'Si' : 'No') ."</td>
                                            <td>". $value->comprimidos_perdidos_new ."</td>
                                            <td>". $value->dias_new ."</td>
                                            <td>". $value->porcentaje_cumplimiento_new ."</td>
                                            <td>". $value->usuario_actualizacion_new ."</td>    
                                        </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'digito_directo_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                         $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th rowspan='3'>Realizado</th>
                                            <th rowspan='3'>Fecha</th>
                                            <th colspan='16'>Item - Intento</th>
                                            <th rowspan='3'>MSDD</th>
                                            <th rowspan='3'>DOD</th>
                                            <th rowspan='3'>Ingresado/Modificado Por</th>
                                            <th rowspan='3'>Fecha Modificacion</th>
                                        </tr>
                                        <tr>
                                            <th colspan='2'>1</th>
                                            <th colspan='2'>2</th>
                                            <th colspan='2'>3</th>
                                            <th colspan='2'>4</th>
                                            <th colspan='2'>5</th>
                                            <th colspan='2'>6</th>
                                            <th colspan='2'>7</th>
                                            <th colspan='2'>8</th>
                                        </tr>                                        
                                        <tr>
                                            <th>9-7</th>
                                            <th>6-3</th>
                                            <th>5-8-2</th>
                                            <th>6-9-4</th>
                                            <th>7-2-8-6</th>
                                            <th>6-4-3-9</th>
                                            <th>4-2-7-3-1</th>
                                            <th>7-5-8-3-6</th>
                                            <th>3-9-2-4-8-7</th>
                                            <th>6-1-9-4-7-3</th>
                                            <th>4-1-7-9-3-8-6</th>
                                            <th>6-9-1-7-4-2-8</th>
                                            <th>3-8-2-9-6-1-7-4</th>
                                            <th>5-8-1-3-2-6-4-7</th>
                                            <th>2-7-5-8-6-3-1-9-4</th>                                            
                                            <th>7-1-3-9-4-2-5-6-8</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_old == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>
                                        <td>". $value->puntaje_intento_1a_old ."</td>
                                        <td>". $value->puntaje_intento_1b_old ."</td>
                                        <td>". $value->puntaje_intento_2a_old ."</td>
                                        <td>". $value->puntaje_intento_2b_old ."</td>
                                        <td>". $value->puntaje_intento_3a_old ."</td>
                                        <td>". $value->puntaje_intento_3b_old ."</td>
                                        <td>". $value->puntaje_intento_4a_old ."</td>
                                        <td>". $value->puntaje_intento_4b_old ."</td>
                                        <td>". $value->puntaje_intento_5a_old ."</td>
                                        <td>". $value->puntaje_intento_5b_old ."</td>
                                        <td>". $value->puntaje_intento_6a_old ."</td>
                                        <td>". $value->puntaje_intento_6b_old ."</td>
                                        <td>". $value->puntaje_intento_7a_old ."</td>
                                        <td>". $value->puntaje_intento_7b_old ."</td>
                                        <td>". $value->puntaje_intento_8a_old ."</td>
                                        <td>". $value->puntaje_intento_8b_old ."</td> 
                                        <td>". $value->msdd_old ."</td>
                                        <td>". $value->puntaje_bruto_old ."</td>
                                        <td>". $value->usuario_creacion_old ."</td> 
                                        <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->created_at_old)) : '') ."</td>                                        
                                    </tr>";

                            $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->puntaje_intento_1a_new ."</td>
                                        <td>". $value->puntaje_intento_1b_new ."</td>
                                        <td>". $value->puntaje_intento_2a_new ."</td>
                                        <td>". $value->puntaje_intento_2b_new ."</td>
                                        <td>". $value->puntaje_intento_3a_new ."</td>
                                        <td>". $value->puntaje_intento_3b_new ."</td>
                                        <td>". $value->puntaje_intento_4a_new ."</td>
                                        <td>". $value->puntaje_intento_4b_new ."</td>
                                        <td>". $value->puntaje_intento_5a_new ."</td>
                                        <td>". $value->puntaje_intento_5b_new ."</td>
                                        <td>". $value->puntaje_intento_6a_new ."</td>
                                        <td>". $value->puntaje_intento_6b_new ."</td>
                                        <td>". $value->puntaje_intento_7a_new ."</td>
                                        <td>". $value->puntaje_intento_7b_new ."</td>
                                        <td>". $value->puntaje_intento_8a_new ."</td>
                                        <td>". $value->puntaje_intento_8b_new ."</td>
                                        <td>". $value->msdd_new ."</td>
                                        <td>". $value->puntaje_bruto_new ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td> 
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') ."</td>                                        
                                    </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->puntaje_intento_1a_new ."</td>
                                        <td>". $value->puntaje_intento_1b_new ."</td>
                                        <td>". $value->puntaje_intento_2a_new ."</td>
                                        <td>". $value->puntaje_intento_2b_new ."</td>
                                        <td>". $value->puntaje_intento_3a_new ."</td>
                                        <td>". $value->puntaje_intento_3b_new ."</td>
                                        <td>". $value->puntaje_intento_4a_new ."</td>
                                        <td>". $value->puntaje_intento_4b_new ."</td>
                                        <td>". $value->puntaje_intento_5a_new ."</td>
                                        <td>". $value->puntaje_intento_5b_new ."</td>
                                        <td>". $value->puntaje_intento_6a_new ."</td>
                                        <td>". $value->puntaje_intento_6b_new ."</td>
                                        <td>". $value->puntaje_intento_7a_new ."</td>
                                        <td>". $value->puntaje_intento_7b_new ."</td>
                                        <td>". $value->puntaje_intento_8a_new ."</td>
                                        <td>". $value->puntaje_intento_8b_new ."</td>
                                        <td>". $value->msdd_new ."</td>
                                        <td>". $value->puntaje_bruto_new ."</td> 
                                        <td>". $value->usuario_actualizacion_new ."</td> 
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') ."</td>                                        
                                    </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'electrocardiograma_de_reposo_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                         $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Realizado</th>
                                            <th>Fecha</th>
                                            <th>Ritmo Sinusal</th>                                            
                                            <th>FC</th>
                                            <th>PR</th>
                                            <th>QRS</th>
                                            <th>QT</th>
                                            <th>QTc</th>
                                            <th>Eje QRS</th>
                                            <th>Interpretacion ECG</th>
                                            <th>Comentarios</th>
                                            <th>Ingresado/Modificado Por</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>". (($value->realizado_old == 1) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>
                                            <td>". $value->ritmo_sinusal_old ."</td>
                                            <td>". $value->fc_old ."</td>
                                            <td>". $value->pr_old ."</td>
                                            <td>". $value->qrs_old ."</td>
                                            <td>". $value->qt_old ."</td>
                                            <td>". $value->qtc_old ."</td>
                                            <td>". $value->qrs2_old ."</td>
                                            <td>". $value->interpretacion_ecg_old ."</td>
                                            <td>". $value->comentarios_old ."</td>
                                            <td>". $value->usuario_creacion_old ."</td>
                                        </tr>";

                        $salida .= "<tr>
                                            <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                            <td>". $value->ritmo_sinusal_new ."</td>
                                            <td>". $value->fc_new ."</td>
                                            <td>". $value->pr_new ."</td>
                                            <td>". $value->qrs_new ."</td>
                                            <td>". $value->qt_new ."</td>
                                            <td>". $value->qtc_new ."</td>
                                            <td>". $value->qrs2_new ."</td>
                                            <td>". $value->interpretacion_ecg_new ."</td>
                                            <td>". $value->comentarios_new ."</td>
                                            <td>". $value->usuario_creacion_new ."</td>
                                        </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                            <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                            <td>". $value->ritmo_sinusal_new ."</td>
                                            <td>". $value->fc_new ."</td>
                                            <td>". $value->pr_new ."</td>
                                            <td>". $value->qrs_new ."</td>
                                            <td>". $value->qt_new ."</td>
                                            <td>". $value->qtc_new ."</td>
                                            <td>". $value->qrs2_new ."</td>
                                            <td>". $value->interpretacion_ecg_new ."</td>
                                            <td>". $value->comentarios_new ."</td>
                                            <td>". $value->usuario_creacion_new ."</td>
                                        </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'eq_5d_5l_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                        $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Realizado</th>
                                            <th>Fecha</th>
                                            <th>Movilidad</th>
                                            <th>Autocuidado</th>
                                            <th>Actividades Habituales</th>
                                            <th>Dolor / Malestar</th>
                                            <th>Angustia / Depresion</th>
                                            <th>Su Salud Hoy</th>
                                            <th>Ingresado/Modificado Por</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>". (($value->realizado_old) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>
                                            <td>". $value->movilidad_old ."</td>
                                            <td>". $value->autocuidado_old ."</td>
                                            <td>". $value->actividades_habituales_old ."</td>
                                            <td>". $value->dolor_malestar_old ."</td>
                                            <td>". $value->angustia_depresion_old ."</td>
                                            <td>". $value->salud_hoy_old ."</td>
                                            <td>". $value->usuario_creacion_old ."</td>                                            
                                        </tr>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->movilidad_new ."</td>
                                        <td>". $value->autocuidado_new ."</td>
                                        <td>". $value->actividades_habituales_new ."</td>
                                        <td>". $value->dolor_malestar_new ."</td>
                                        <td>". $value->angustia_depresion_new ."</td>
                                        <td>". $value->salud_hoy_new ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>                                            
                                    </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->movilidad_new ."</td>
                                        <td>". $value->autocuidado_new ."</td>
                                        <td>". $value->actividades_habituales_new ."</td>
                                        <td>". $value->dolor_malestar_new ."</td>
                                        <td>". $value->angustia_depresion_new ."</td>
                                        <td>". $value->salud_hoy_new ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>                                            
                                    </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'examen_fisico_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                         $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th rowspan='2'>Realizado</th>
                                            <th rowspan='2'>Fecha</th>

                                            <th colspan='2'>Aspecto general</th>
                                            <th colspan='2'>Estado nutricional</th>
                                            <th colspan='2'>Piel</th>
                                            <th colspan='2'>Cabeza</th>
                                            <th colspan='2'>Ojos</th>
                                            <th colspan='2'>Nariz</th>
                                            <th colspan='2'>Oidos</th>
                                            <th colspan='2'>Boca - Garganta</th>
                                            <th colspan='2'>Cuello - adenopatías</th>
                                            <th colspan='2'>Pecho - pulmón</th>
                                            <th colspan='2'>Cardíaco</th>
                                            <th colspan='2'>Abdomen</th>
                                            <th colspan='2'>Muscular - Esquelético</th>

                                            <th rowspan='2'>Ingresado/Modificado Por</th>
                                            <th rowspan='2'>Fecha modificacion</th>                                            
                                        </tr>
                                        <tr>
                                            <th>Nom/Anom</th>
                                            <th>Descripción</th>
                                            <th>Nom/Anom</th>
                                            <th>Descripción</th>
                                            <th>Nom/Anom</th>
                                            <th>Descripción</th>
                                            <th>Nom/Anom</th>
                                            <th>Descripción</th>
                                            <th>Nom/Anom</th>
                                            <th>Descripción</th>
                                            <th>Nom/Anom</th>
                                            <th>Descripción</th>
                                            <th>Nom/Anom</th>
                                            <th>Descripción</th>
                                            <th>Nom/Anom</th>
                                            <th>Descripción</th>
                                            <th>Nom/Anom</th>
                                            <th>Descripción</th>
                                            <th>Nom/Anom</th>
                                            <th>Descripción</th>
                                            <th>Nom/Anom</th>
                                            <th>Descripción</th>
                                            <th>Nom/Anom</th>
                                            <th>Descripción</th>
                                            <th>Nom/Anom</th>
                                            <th>Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        $salida .= "<tr>
                                        <td>". (($value->hallazgo_old) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>
                                        
                                        <td>". (($value->aspecto_general_old == 1) ? 'Normal' : (($value->aspecto_general_old == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->aspecto_general_desc_old ."</td>
                                        <td>". (($value->estado_nutricional_old == 1) ? 'Normal' : (($value->estado_nutricional_old == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->estado_nutricional_desc_old ."</td>
                                        <td>". (($value->piel_old == 1) ? 'Normal' : (($value->piel_old == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->piel_desc_old ."</td>
                                        <td>". (($value->cabeza_old == 1) ? 'Normal' : (($value->cabeza_old == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->cabeza_desc_old ."</td>
                                        <td>". (($value->ojos_old == 1) ? 'Normal' : (($value->ojos_old == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->ojos_desc_old ."</td>
                                        <td>". (($value->nariz_old == 1) ? 'Normal' : (($value->nariz_old == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->nariz_desc_old ."</td>                                        
                                        <td>". (($value->oidos_old == 1) ? 'Normal' : (($value->oidos_old == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->oidos_desc_old ."</td>
                                        <td>". (($value->boca_old == 1) ? 'Normal' : (($value->boca_old == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->boca_desc_old ."</td>
                                        <td>". (($value->cuello_old == 1) ? 'Normal' : (($value->cuello_old == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->cuello_desc_old ."</td>
                                        <td>". (($value->pulmones_old == 1) ? 'Normal' : (($value->pulmones_old == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->pulmones_desc_old ."</td>
                                        <td>". (($value->cardiovascular_old == 1) ? 'Normal' : (($value->cardiovascular_old == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->cardiovascular_desc_old ."</td>
                                        <td>". (($value->abdomen_old == 1) ? 'Normal' : (($value->abdomen_old == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->abdomen_desc_old ."</td>
                                        <td>". (($value->muscular_old == 1) ? 'Normal' : (($value->muscular_old == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->muscular_desc_old ."</td>

                                        <td>". $value->usuario_creacion_old ."</td>
                                        <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->created_at_old)) : '') ."</td>
                                    </tr>";

                        $salida .= "<tr>
                                        <td>". (($value->hallazgo_new) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        
                                        <td>". (($value->aspecto_general_new == 1) ? 'Normal' : (($value->aspecto_general_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->aspecto_general_desc_new ."</td>
                                        <td>". (($value->estado_nutricional_new == 1) ? 'Normal' : (($value->estado_nutricional_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->estado_nutricional_desc_new ."</td>
                                        <td>". (($value->piel_new == 1) ? 'Normal' : (($value->piel_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->piel_desc_new ."</td>
                                        <td>". (($value->cabeza_new == 1) ? 'Normal' : (($value->cabeza_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->cabeza_desc_new ."</td>
                                        <td>". (($value->ojos_new == 1) ? 'Normal' : (($value->ojos_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->ojos_desc_new ."</td>
                                        <td>". (($value->nariz_new == 1) ? 'Normal' : (($value->nariz_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->nariz_desc_new ."</td>                                        
                                        <td>". (($value->oidos_new == 1) ? 'Normal' : (($value->oidos_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->oidos_desc_new ."</td>
                                        <td>". (($value->boca_new == 1) ? 'Normal' : (($value->boca_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->boca_desc_new ."</td>
                                        <td>". (($value->cuello_new == 1) ? 'Normal' : (($value->cuello_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->cuello_desc_new ."</td>
                                        <td>". (($value->pulmones_new == 1) ? 'Normal' : (($value->pulmones_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->pulmones_desc_new ."</td>
                                        <td>". (($value->cardiovascular_new == 1) ? 'Normal' : (($value->cardiovascular_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->cardiovascular_desc_new ."</td>
                                        <td>". (($value->abdomen_new == 1) ? 'Normal' : (($value->abdomen_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->abdomen_desc_new ."</td>
                                        <td>". (($value->muscular_new == 1) ? 'Normal' : (($value->muscular_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->muscular_desc_new ."</td>

                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') ."</td>
                                    </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->hallazgo_new) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        
                                        <td>". (($value->aspecto_general_new == 1) ? 'Normal' : (($value->aspecto_general_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->aspecto_general_desc_new ."</td>
                                        <td>". (($value->estado_nutricional_new == 1) ? 'Normal' : (($value->estado_nutricional_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->estado_nutricional_desc_new ."</td>
                                        <td>". (($value->piel_new == 1) ? 'Normal' : (($value->piel_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->piel_desc_new ."</td>
                                        <td>". (($value->cabeza_new == 1) ? 'Normal' : (($value->cabeza_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->cabeza_desc_new ."</td>
                                        <td>". (($value->ojos_new == 1) ? 'Normal' : (($value->ojos_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->ojos_desc_new ."</td>
                                        <td>". (($value->nariz_new == 1) ? 'Normal' : (($value->nariz_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->nariz_desc_new ."</td>                                        
                                        <td>". (($value->oidos_new == 1) ? 'Normal' : (($value->oidos_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->oidos_desc_new ."</td>
                                        <td>". (($value->boca_new == 1) ? 'Normal' : (($value->boca_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->boca_desc_new ."</td>
                                        <td>". (($value->cuello_new == 1) ? 'Normal' : (($value->cuello_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->cuello_desc_new ."</td>
                                        <td>". (($value->pulmones_new == 1) ? 'Normal' : (($value->pulmones_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->pulmones_desc_new ."</td>
                                        <td>". (($value->cardiovascular_new == 1) ? 'Normal' : (($value->cardiovascular_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->cardiovascular_desc_new ."</td>
                                        <td>". (($value->abdomen_new == 1) ? 'Normal' : (($value->abdomen_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->abdomen_desc_new ."</td>
                                        <td>". (($value->muscular_new == 1) ? 'Normal' : (($value->muscular_new == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->muscular_desc_new ."</td>

                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') ."</td>
                                    </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'examen_laboratorio_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                        $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Realizado</th>
                                            <th>Fecha</th>
                                            <th>Ingresado/Modificado Por</th>
                                            <th>Fecha modificacion</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>";
                    }
                    else{

                    }

                    $contador++;
                }
                elseif($tabla == 'examen_neurologico_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                        $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Realizado</th>
                                            <th>Fecha</th>
                                            <th>Ingresado/Modificado Por</th>
                                            <th>Fecha modificacion</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>";
                    }
                    else{

                    }

                    $contador++;
                }
                elseif($tabla == 'fin_tratamiento_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                         $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>No aplica, terminación temprana</th>
                                            <th>Fecha Visita</th>
                                            <th>Fecha ultima dosis</th>
                                            <th>¿Sujeto terminó el estudio?</th>
                                            <th>Ingresado/Modificado Por</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        $salida .= "<tr>
                                        <td style='text-align:center;'>". (($value->no_aplica_old == 1 ) ? '*' : '') ."</td>
                                        <td>". (($value->fecha_visita_old) ? date('d/m/Y', strtotime($value->fecha_visita_old)) : '') ."</td>
                                        <td>". (($value->fecha_ultima_dosis_old) ? date('d/m/Y', strtotime($value->fecha_ultima_dosis_old)) : '') ."</td>
                                        <td>". (($value->termino_el_estudio_old == 1) ? 'Si' : 'No') ."</td>
                                        <td>". $value->usuario_creacion_old ."</td>
                                    </tr>";

                        $salida .= "<tr>
                                        <td style='text-align:center;'>". (($value->no_aplica_new == 1 ) ? '*' : '') ."</td>
                                        <td>". (($value->fecha_visita_new) ? date('d/m/Y', strtotime($value->fecha_visita_new)) : '') ."</td>
                                        <td>". (($value->fecha_ultima_dosis_new) ? date('d/m/Y', strtotime($value->fecha_ultima_dosis_new)) : '') ."</td>
                                        <td>". (($value->termino_el_estudio_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                    </tr>"; 
                    }
                    else{
                        $salida .= "<tr>
                                        <td style='text-align:center;'>". (($value->no_aplica_new == 1 ) ? '*' : '') ."</td>
                                        <td>". (($value->fecha_visita_new) ? date('d/m/Y', strtotime($value->fecha_visita_new)) : '') ."</td>
                                        <td>". (($value->fecha_ultima_dosis_new) ? date('d/m/Y', strtotime($value->fecha_ultima_dosis_new)) : '') ."</td>
                                        <td>". (($value->termino_el_estudio_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                    </tr>";
                    }

                    $contador++;
                }   
                elseif($tabla == 'fin_tratamiento_temprano_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                        
                         $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>No aplica, terminación temprana</th>
                                            <th>Fecha Visita</th>
                                            <th>Fecha ultima dosis</th>
                                            <th>Motivo por el cual sujeto no terminó el estudio</th>
                                            <th>Ingresado/Modificado Por</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        $salida .= "<tr>
                                        <td style='text-align:center;'>". (($value->no_aplica_old == 1 ) ? '*' : '') ."</td>
                                        <td>". (($value->fecha_visita_old) ? date('d/m/Y', strtotime($value->fecha_visita_old)) : '') ."</td>
                                        <td>". (($value->fecha_ultima_dosis_old) ? date('d/m/Y', strtotime($value->fecha_ultima_dosis_old)) : '') ."</td>
                                        <td>". $value->motivo_old ."</td>
                                        <td>". $value->usuario_creacion_old ."</td>
                                    </tr>";

                        $salida .= "<tr>
                                        <td style='text-align:center;'>". (($value->no_aplica_new == 1 ) ? '*' : '') ."</td>
                                        <td>". (($value->fecha_visita_new) ? date('d/m/Y', strtotime($value->fecha_visita_new)) : '') ."</td>
                                        <td>". (($value->fecha_ultima_dosis_new) ? date('d/m/Y', strtotime($value->fecha_ultima_dosis_new)) : '') ."</td>
                                        <td>". $value->motivo_old ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                    </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                        <td style='text-align:center;'>". (($value->no_aplica_new == 1 ) ? '*' : '') ."</td>
                                        <td>". (($value->fecha_visita_new) ? date('d/m/Y', strtotime($value->fecha_visita_new)) : '') ."</td>
                                        <td>". (($value->fecha_ultima_dosis_new) ? date('d/m/Y', strtotime($value->fecha_ultima_dosis_new)) : '') ."</td>
                                        <td>". $value->motivo_old ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                    </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'hachinski_form_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                        $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Realizado</th>
                                            <th>Fecha</th>
                                            <th>Comienzo Brusco</th>
                                            <th>Deterioro escalonado</th>
                                            <th>Curso fluctuante</th>
                                            <th>Desorientación nocturna</th>
                                            <th>Preservación relativa de la personalidad</th>
                                            <th>Depresión</th>
                                            <th>Somatización</th>
                                            <th>Labilidad emocional</th>
                                            <th>Historia de HTA</th>
                                            <th>Historia de ictus previos</th>
                                            <th>Evidencia de arteriosclerosis asociada</th>
                                            <th>Síntomas neurológicos focales</th>
                                            <th>Signos neurológicos focales</th>
                                            <th>Puntaje Total</th>
                                            <th>Ingresado/Modificado Por</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>". (($value->realizado_old) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>
                                            <td>". ((!empty($value->comienzo_brusco_old)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->deterioro_escalonado_old)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->curso_fluctante_old)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->desorientacion_noctura_old)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->preservacion_relativa_old)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->depresion_old)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->somatizacion_old)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->labilidad_emocional_old)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->hta_old)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->ictus_previos_old)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->evidencia_arteriosclerosis_old)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->sintomas_neurologicos_old)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->signos_neurologicos_old)) ? 'Si' : 'No') ."</td>
                                            <td>". $value->total_old ."</td>                                            
                                            <td>". $value->created_by_old ."</td>
                                        </tr>";

                            $salida .= "<tr>
                                            <td>". (($value->realizado_new) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                            <td>". ((!empty($value->comienzo_brusco_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->deterioro_escalonado_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->curso_fluctante_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->desorientacion_noctura_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->preservacion_relativa_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->depresion_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->somatizacion_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->labilidad_emocional_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->hta_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->ictus_previos_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->evidencia_arteriosclerosis_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->sintomas_neurologicos_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->signos_neurologicos_new)) ? 'Si' : 'No') ."</td>
                                            <td>". $value->total_new ."</td>                                            
                                            <td>". $value->usuario_actualizacion_new ."</td>
                                        </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                            <td>". (($value->realizado_new) ? 'Si' : 'No') ."</td>
                                            <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                            <td>". ((!empty($value->comienzo_brusco_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->deterioro_escalonado_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->curso_fluctante_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->desorientacion_noctura_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->preservacion_relativa_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->depresion_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->somatizacion_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->labilidad_emocional_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->hta_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->ictus_previos_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->evidencia_arteriosclerosis_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->sintomas_neurologicos_new)) ? 'Si' : 'No') ."</td>
                                            <td>". ((!empty($value->signos_neurologicos_new)) ? 'Si' : 'No') ."</td>
                                            <td>". $value->total_new ."</td>                                            
                                            <td>". $value->usuario_actualizacion_new ."</td>
                                        </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'historial_medico_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                         $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th colspan='2'>Hipertensión arterial</th>
                                            <th colspan='2'>Úlcera gastrointestinal</th>
                                            <th colspan='2'>Diabetes mellitus</th>
                                            <th colspan='2'>Hipo/Hipertiroidismo</th>
                                            <th colspan='2'>Hiperlipidemia</th>
                                            <th colspan='2'>EPOC</th>
                                            <th colspan='2'>Enfermedad coronaria</th>
                                            <th colspan='2'>Rinitis</th>
                                            <th colspan='2'>Accidente vascular encefálico</th>
                                            <th colspan='2'>Asma</th>
                                            <th colspan='2'>Gastritis/Reflujo GE</th>
                                            <th colspan='2'>Cefaleas matinales</th>

                                            <th colspan='2'>Alergias</th>
                                            <th colspan='2'>Tabaquismo</th>
                                            <th colspan='2'>Ingesta de Alcohol</th>
                                            <th colspan='2'>Consumo de Drogas de abuso</th>
                                            <th colspan='2'>¿Ha tenido alguna intervención quirúrgica y/o cirugía?</th>
                                            <th colspan='2'>¿Ha donado sangre o ha participado en algún estudio clínico farmacológico en los últimos tres meses?</th>
                                            <th colspan='2'>¿Está recibiendo o ha recibido en el último mes, algún tratamiento farmacológico?</th>
                                            <th colspan='2'>¿Está recibiendo o ha recibido en el último mes, algún suplemento dietético o vitamínico?</th>
                                            <th colspan='2'>Antecedentes familiares de alzheimer</th>
                                            <th rowspan='2'>Fecha en que presento sintomas de EA</th>
                                            <th colspan='2'>Antecedentes morbidos familiares</th>
                                            
                                            <th rowspan='2'>Ingresado/Modificado Por</th>
                                            <th rowspan='2'>Fecha modificacion</th>
                                            
                                        </tr>
                                        <tr>
                                            <th>Antecedentes</th>                                            
                                            <th>Fecha Diagnostico</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Fecha Diagnostico</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Fecha Diagnostico</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Fecha Diagnostico</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Fecha Diagnostico</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Fecha Diagnostico</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Fecha Diagnostico</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Fecha Diagnostico</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Fecha Diagnostico</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Fecha Diagnostico</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Fecha Diagnostico</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Fecha Diagnostico</th>

                                            <th>Antecedentes</th>                                            
                                            <th>Descripción</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Descripción</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Descripción</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Descripción</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Descripción</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Descripción</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Descripción</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Descripción</th>
                                            <th>Antecedentes</th>                                            
                                            <th>Descripción</th>

                                            <th>Antecedentes</th>                                            
                                            <th>Descripción</th>

                                        </tr>
                                    </thead>
                                    <tbody>";

                            $salida .= "<tr>
                                            <td>". (($value->hipertension_old == 1) ? 'Si' : (($value->hipertension_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->hipertension_dia_old ."-". $value->hipertension_mes_old ."-". $value->hipertension_anio_old ."</td>
                                            <td>". (($value->ulcera_old == 1) ? 'Si' : (($value->ulcera_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->ulcera_dia_old ."-". $value->ulcera_mes_old ."-". $value->ulcera_anio_old ."</td>
                                            <td>". (($value->diabetes_old == 1) ? 'Si' : (($value->diabetes_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->diabetes_dia_old ."-". $value->diabetes_mes_old ."-". $value->diabetes_anio_old ."</td>
                                            <td>". (($value->hipo_hipertiroidismo_old == 1) ? 'Si' : (($value->hipo_hipertiroidismo_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->hipo_hipertiroidismo_dia_old ."-". $value->hipo_hipertiroidismo_mes_old ."-". $value->hipo_hipertiroidismo_anio_old ."</td>
                                            <td>". (($value->hiperlipidemia_old == 1) ? 'Si' : (($value->hiperlipidemia_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->hiperlipidemia_dia_old ."-". $value->hiperlipidemia_mes_old ."-". $value->hiperlipidemia_anio_old ."</td>
                                            <td>". (($value->epoc_old == 1) ? 'Si' : (($value->epoc_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->epoc_dia_old ."-". $value->epoc_mes_old ."-". $value->epoc_anio_old ."</td>
                                            <td>". (($value->coronaria_old == 1) ? 'Si' : (($value->coronaria_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->coronaria_dia_old ."-". $value->coronaria_mes_old ."-". $value->coronaria_anio_old ."</td>
                                            <td>". (($value->rinitis_old == 1) ? 'Si' : (($value->rinitis_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->rinitis_dia_old ."-". $value->rinitis_mes_old ."-". $value->rinitis_anio_old ."</td>
                                            <td>". (($value->acc_vascular_old == 1) ? 'Si' : (($value->acc_vascular_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->acc_vascular_dia_old ."-". $value->acc_vascular_mes_old ."-". $value->acc_vascular_anio_old ."</td>
                                            <td>". (($value->asma_old == 1) ? 'Si' : (($value->asma_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->asma_dia_old ."-". $value->asma_mes_old ."-". $value->asma_anio_old ."</td>
                                            <td>". (($value->gastritis_old == 1) ? 'Si' : (($value->gastritis_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->gastritis_dia_old ."-". $value->gastritis_mes_old ."-". $value->gastritis_anio_old ."</td>
                                            <td>". (($value->cefaleas_old == 1) ? 'Si' : (($value->cefaleas_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->cefaleas_dia_old ."-". $value->cefaleas_mes_old ."-". $value->cefaleas_anio_old ."</td>

                                            <td>". (($value->alergia_old == 1) ? 'Si' : (($value->alergia_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->alergia_desc_old ."</td>
                                            <td>". (($value->tabaquismo_old == 1) ? 'Si' : (($value->tabaquismo_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->tabaquismo_desc_old ."</td>
                                            <td>". (($value->ingesta_alcohol_old == 1) ? 'Si' : (($value->ingesta_alcohol_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->ingesta_alcohol_desc_old ."</td>
                                            <td>". (($value->drogas_old == 1) ? 'Si' : (($value->drogas_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->drogas_desc_old ."</td>
                                            <td>". (($value->cirugia_old == 1) ? 'Si' : (($value->cirugia_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->cirugia_desc_old ."</td>
                                            <td>". (($value->donado_sangre_old == 1) ? 'Si' : (($value->donado_sangre_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->donado_sangre_desc_old ."</td>
                                            <td>". (($value->tratamiento_farma_old == 1) ? 'Si' : (($value->tratamiento_farma_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->tratamiento_farma_desc_old ."</td>
                                            <td>". (($value->suplemento_dietetico_old == 1) ? 'Si' : (($value->suplemento_dietetico_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->suplemento_dietetico_desc_old ."</td>
                                            <td>". (($value->alzheimer_old == 1) ? 'Si' : (($value->alzheimer_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->alzheimer_desc_old ."</td>
                                            <td>". $value->dia_ea_old .'-'. $value->mes_ea_old .'-'. $value->anio_ea_old ."</td>
                                            <td>". (($value->morbido_old == 1) ? 'Si' : (($value->morbido_old == "0") ? 'No' : ''))."</td>
                                            <td>". $value->morbido_desc_old ."</td>

                                            <td>". $value->usuario_creacion_old ."</td>
                                            <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->created_at_old)) : '') ."</td>
                                        </tr>";

                         $salida .= "<tr>
                                            <td>". (($value->hipertension_new == 1) ? 'Si' : (($value->hipertension_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->hipertension_dia_new ."-". $value->hipertension_mes_new ."-". $value->hipertension_anio_new ."</td>
                                            <td>". (($value->ulcera_new == 1) ? 'Si' : (($value->ulcera_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->ulcera_dia_new ."-". $value->ulcera_mes_new ."-". $value->ulcera_anio_new ."</td>
                                            <td>". (($value->diabetes_new == 1) ? 'Si' : (($value->diabetes_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->diabetes_dia_new ."-". $value->diabetes_mes_new ."-". $value->diabetes_anio_new ."</td>
                                            <td>". (($value->hipo_hipertiroidismo_new == 1) ? 'Si' : (($value->hipo_hipertiroidismo_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->hipo_hipertiroidismo_dia_new ."-". $value->hipo_hipertiroidismo_mes_new ."-". $value->hipo_hipertiroidismo_anio_new ."</td>
                                            <td>". (($value->hiperlipidemia_new == 1) ? 'Si' : (($value->hiperlipidemia_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->hiperlipidemia_dia_new ."-". $value->hiperlipidemia_mes_new ."-". $value->hiperlipidemia_anio_new ."</td>
                                            <td>". (($value->epoc_new == 1) ? 'Si' : (($value->epoc_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->epoc_dia_new ."-". $value->epoc_mes_new ."-". $value->epoc_anio_new ."</td>
                                            <td>". (($value->coronaria_new == 1) ? 'Si' : (($value->coronaria_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->coronaria_dia_new ."-". $value->coronaria_mes_new ."-". $value->coronaria_anio_new ."</td>
                                            <td>". (($value->rinitis_new == 1) ? 'Si' : (($value->rinitis_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->rinitis_dia_new ."-". $value->rinitis_mes_new ."-". $value->rinitis_anio_new ."</td>
                                            <td>". (($value->acc_vascular_new == 1) ? 'Si' : (($value->acc_vascular_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->acc_vascular_dia_new ."-". $value->acc_vascular_mes_new ."-". $value->acc_vascular_anio_new ."</td>
                                            <td>". (($value->asma_new == 1) ? 'Si' : (($value->asma_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->asma_dia_new ."-". $value->asma_mes_new ."-". $value->asma_anio_new ."</td>
                                            <td>". (($value->gastritis_new == 1) ? 'Si' : (($value->gastritis_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->gastritis_dia_new ."-". $value->gastritis_mes_new ."-". $value->gastritis_anio_new ."</td>
                                            <td>". (($value->cefaleas_new == 1) ? 'Si' : (($value->cefaleas_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->cefaleas_dia_new ."-". $value->cefaleas_mes_new ."-". $value->cefaleas_anio_new ."</td>

                                            <td>". (($value->alergia_new == 1) ? 'Si' : (($value->alergia_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->alergia_desc_new ."</td>
                                            <td>". (($value->tabaquismo_new == 1) ? 'Si' : (($value->tabaquismo_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->tabaquismo_desc_new ."</td>
                                            <td>". (($value->ingesta_alcohol_new == 1) ? 'Si' : (($value->ingesta_alcohol_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->ingesta_alcohol_desc_new ."</td>
                                            <td>". (($value->drogas_new == 1) ? 'Si' : (($value->drogas_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->drogas_desc_new ."</td>
                                            <td>". (($value->cirugia_new == 1) ? 'Si' : (($value->cirugia_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->cirugia_desc_new ."</td>
                                            <td>". (($value->donado_sangre_new == 1) ? 'Si' : (($value->donado_sangre_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->donado_sangre_desc_new ."</td>
                                            <td>". (($value->tratamiento_farma_new == 1) ? 'Si' : (($value->tratamiento_farma_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->tratamiento_farma_desc_new ."</td>
                                            <td>". (($value->suplemento_dietetico_new == 1) ? 'Si' : (($value->suplemento_dietetico_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->suplemento_dietetico_desc_new ."</td>
                                            <td>". (($value->alzheimer_new == 1) ? 'Si' : (($value->alzheimer_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->alzheimer_desc_new ."</td>
                                            <td>". $value->dia_ea_new .'-'. $value->mes_ea_new .'-'. $value->anio_ea_new ."</td>
                                            <td>". (($value->morbido_new == 1) ? 'Si' : (($value->morbido_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->morbido_desc_new ."</td>

                                            <td>". $value->usuario_actualizacion_new ."</td>
                                            <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') ."</td>
                                        </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                            <td>". (($value->hipertension_new == 1) ? 'Si' : (($value->hipertension_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->hipertension_dia_new ."-". $value->hipertension_mes_new ."-". $value->hipertension_anio_new ."</td>
                                            <td>". (($value->ulcera_new == 1) ? 'Si' : (($value->ulcera_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->ulcera_dia_new ."-". $value->ulcera_mes_new ."-". $value->ulcera_anio_new ."</td>
                                            <td>". (($value->diabetes_new == 1) ? 'Si' : (($value->diabetes_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->diabetes_dia_new ."-". $value->diabetes_mes_new ."-". $value->diabetes_anio_new ."</td>
                                            <td>". (($value->hipo_hipertiroidismo_new == 1) ? 'Si' : (($value->hipo_hipertiroidismo_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->hipo_hipertiroidismo_dia_new ."-". $value->hipo_hipertiroidismo_mes_new ."-". $value->hipo_hipertiroidismo_anio_new ."</td>
                                            <td>". (($value->hiperlipidemia_new == 1) ? 'Si' : (($value->hiperlipidemia_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->hiperlipidemia_dia_new ."-". $value->hiperlipidemia_mes_new ."-". $value->hiperlipidemia_anio_new ."</td>
                                            <td>". (($value->epoc_new == 1) ? 'Si' : (($value->epoc_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->epoc_dia_new ."-". $value->epoc_mes_new ."-". $value->epoc_anio_new ."</td>
                                            <td>". (($value->coronaria_new == 1) ? 'Si' : (($value->coronaria_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->coronaria_dia_new ."-". $value->coronaria_mes_new ."-". $value->coronaria_anio_new ."</td>
                                            <td>". (($value->rinitis_new == 1) ? 'Si' : (($value->rinitis_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->rinitis_dia_new ."-". $value->rinitis_mes_new ."-". $value->rinitis_anio_new ."</td>
                                            <td>". (($value->acc_vascular_new == 1) ? 'Si' : (($value->acc_vascular_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->acc_vascular_dia_new ."-". $value->acc_vascular_mes_new ."-". $value->acc_vascular_anio_new ."</td>
                                            <td>". (($value->asma_new == 1) ? 'Si' : (($value->asma_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->asma_dia_new ."-". $value->asma_mes_new ."-". $value->asma_anio_new ."</td>
                                            <td>". (($value->gastritis_new == 1) ? 'Si' : (($value->gastritis_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->gastritis_dia_new ."-". $value->gastritis_mes_new ."-". $value->gastritis_anio_new ."</td>
                                            <td>". (($value->cefaleas_new == 1) ? 'Si' : (($value->cefaleas_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->cefaleas_dia_new ."-". $value->cefaleas_mes_new ."-". $value->cefaleas_anio_new ."</td>

                                            <td>". (($value->alergia_new == 1) ? 'Si' : (($value->alergia_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->alergia_desc_new ."</td>
                                            <td>". (($value->tabaquismo_new == 1) ? 'Si' : (($value->tabaquismo_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->tabaquismo_desc_new ."</td>
                                            <td>". (($value->ingesta_alcohol_new == 1) ? 'Si' : (($value->ingesta_alcohol_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->ingesta_alcohol_desc_new ."</td>
                                            <td>". (($value->drogas_new == 1) ? 'Si' : (($value->drogas_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->drogas_desc_new ."</td>
                                            <td>". (($value->cirugia_new == 1) ? 'Si' : (($value->cirugia_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->cirugia_desc_new ."</td>
                                            <td>". (($value->donado_sangre_new == 1) ? 'Si' : (($value->donado_sangre_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->donado_sangre_desc_new ."</td>
                                            <td>". (($value->tratamiento_farma_new == 1) ? 'Si' : (($value->tratamiento_farma_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->tratamiento_farma_desc_new ."</td>
                                            <td>". (($value->suplemento_dietetico_new == 1) ? 'Si' : (($value->suplemento_dietetico_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->suplemento_dietetico_desc_new ."</td>
                                            <td>". (($value->alzheimer_new == 1) ? 'Si' : (($value->alzheimer_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->alzheimer_desc_new ."</td>
                                            <td>". $value->dia_ea_new .'-'. $value->mes_ea_new .'-'. $value->anio_ea_new ."</td>
                                            <td>". (($value->morbido_new == 1) ? 'Si' : (($value->morbido_new == "0") ? 'No' : ''))."</td>
                                            <td>". $value->morbido_desc_new ."</td>

                                            <td>". $value->usuario_actualizacion_new ."</td>
                                            <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') ."</td>
                                        </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'inclusion_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                    }
                    else{

                    }

                    $contador++;
                }
                elseif($tabla == 'mmse_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                    }
                    else{

                    }

                    $contador++;
                }
                elseif($tabla == 'muestra_de_sangre_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                         $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Realizado</th>
                                            <th>Fecha Toma Muestra</th>
                                            <th>Ingresado/Modificado Por</th>
                                            <th>Fecha Modificacion</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_old == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>                                        
                                        <td>". $value->usuario_creacion_old ."</td>
                                        <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->created_at_old)) : '') ."</td>
                                    </tr>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>                                        
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') ."</td>
                                    </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>                                        
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') ."</td>
                                    </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'npi_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                        $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th rowspan='2'>Realizado</th>
                                            <th rowspan='2'>Fecha</th>
                                            <th rowspan='2'>Puntaje Total de NPI</th>
                                            <th rowspan='2'>Puntaje total para Angustia de el (la) Cuidador(a)</th>
                                            <th colspan='5'>Delirios</th>
                                            <th colspan='5'>Alucinaciones</th>
                                            <th colspan='5'>Agitación / Agresividad</th>
                                            <th colspan='5'>Depresión</th>
                                            <th colspan='5'>Ansiedad</th>
                                            <th colspan='5'>Elación / Euforia</th>
                                            <th colspan='5'>Apatía / Indiferencia</th>
                                            <th colspan='5'>Deshinibición</th>
                                            <th colspan='5'>Irritabilidad</th>
                                            <th colspan='5'>Conducta Motora Aberrante</th>
                                            <th colspan='5'>Trastornos del sueño y de la Conducta</th>
                                            <th colspan='5'>Trastornos del apetito y de la alimentación</th>
                                            <th rowspan='2'>Ingresado/Modificado Por</th>
                                            <th rowspan='2'>Fecha Modificacion</th>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <th>Frecuencia</th>
                                            <th>Severidad</th>
                                            <th>Puntaje</th>
                                            <th>Angustia</th>
                                            <th>Status</th>
                                            <th>Frecuencia</th>
                                            <th>Severidad</th>
                                            <th>Puntaje</th>
                                            <th>Angustia</th>
                                            <th>Status</th>
                                            <th>Frecuencia</th>
                                            <th>Severidad</th>
                                            <th>Puntaje</th>
                                            <th>Angustia</th>
                                            <th>Status</th>
                                            <th>Frecuencia</th>
                                            <th>Severidad</th>
                                            <th>Puntaje</th>
                                            <th>Angustia</th>
                                            <th>Status</th>
                                            <th>Frecuencia</th>
                                            <th>Severidad</th>
                                            <th>Puntaje</th>
                                            <th>Angustia</th>
                                            <th>Status</th>
                                            <th>Frecuencia</th>
                                            <th>Severidad</th>
                                            <th>Puntaje</th>
                                            <th>Angustia</th>
                                            <th>Status</th>
                                            <th>Frecuencia</th>
                                            <th>Severidad</th>
                                            <th>Puntaje</th>
                                            <th>Angustia</th>
                                            <th>Status</th>
                                            <th>Frecuencia</th>
                                            <th>Severidad</th>
                                            <th>Puntaje</th>
                                            <th>Angustia</th>
                                            <th>Status</th>
                                            <th>Frecuencia</th>
                                            <th>Severidad</th>
                                            <th>Puntaje</th>
                                            <th>Angustia</th>
                                            <th>Status</th>
                                            <th>Frecuencia</th>
                                            <th>Severidad</th>
                                            <th>Puntaje</th>
                                            <th>Angustia</th>
                                            <th>Status</th>
                                            <th>Frecuencia</th>
                                            <th>Severidad</th>
                                            <th>Puntaje</th>
                                            <th>Angustia</th>
                                            <th>Status</th>
                                            <th>Frecuencia</th>
                                            <th>Severidad</th>
                                            <th>Puntaje</th>
                                            <th>Angustia</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                        $salida .= "<tr>
                                        <td>". (($value->realizado_old == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>
                                        <td>". $value->puntaje_total_npi_old ."</td>
                                        <td>". $value->puntaje_total_para_angustia_old ."</td>
                                        
                                        <td>". $value->delirio_status_old ."</td>
                                        <td>". $value->delirio_frecuencia_old ."</td>
                                        <td>". $value->delirio_severidad_old ."</td>
                                        <td>". $value->delirio_puntaje_old ."</td>
                                        <td>". $value->delirio_angustia_old ."</td>

                                        <td>". $value->alucinaciones_status_old ."</td>
                                        <td>". $value->alucinaciones_frecuencia_old ."</td>
                                        <td>". $value->alucinaciones_severidad_old ."</td>
                                        <td>". $value->alucinaciones_puntaje_old ."</td>
                                        <td>". $value->alucinaciones_angustia_old ."</td>

                                        <td>". $value->agitacion_status_old ."</td>
                                        <td>". $value->agitacion_frecuencia_old ."</td>
                                        <td>". $value->agitacion_severidad_old ."</td>
                                        <td>". $value->agitacion_puntaje_old ."</td>
                                        <td>". $value->agitacion_angustia_old ."</td>

                                        <td>". $value->depresion_status_old ."</td>
                                        <td>". $value->depresion_frecuencia_old ."</td>
                                        <td>". $value->depresion_severidad_old ."</td>
                                        <td>". $value->depresion_puntaje_old ."</td>
                                        <td>". $value->depresion_angustia_old ."</td>

                                        <td>". $value->ansiedad_status_old ."</td>
                                        <td>". $value->ansiedad_frecuencia_old ."</td>
                                        <td>". $value->ansiedad_severidad_old ."</td>
                                        <td>". $value->ansiedad_puntaje_old ."</td>
                                        <td>". $value->ansiedad_angustia_old ."</td>

                                        <td>". $value->elacion_status_old ."</td>
                                        <td>". $value->elacion_frecuencia_old ."</td>
                                        <td>". $value->elacion_severidad_old ."</td>
                                        <td>". $value->elacion_puntaje_old ."</td>
                                        <td>". $value->elacion_angustia_old ."</td>

                                        <td>". $value->apatia_status_old ."</td>
                                        <td>". $value->apatia_frecuencia_old ."</td>
                                        <td>". $value->apatia_severidad_old ."</td>
                                        <td>". $value->apatia_puntaje_old ."</td>
                                        <td>". $value->apatia_angustia_old ."</td>

                                        <td>". $value->deshinibicion_status_old ."</td>
                                        <td>". $value->deshinibicion_frecuencia_old ."</td>
                                        <td>". $value->deshinibicion_severidad_old ."</td>
                                        <td>". $value->deshinibicion_puntaje_old ."</td>
                                        <td>". $value->deshinibicion_angustia_old ."</td>

                                        <td>". $value->irritabilidad_status_old ."</td>
                                        <td>". $value->irritabilidad_frecuencia_old ."</td>
                                        <td>". $value->irritabilidad_severidad_old ."</td>
                                        <td>". $value->irritabilidad_puntaje_old ."</td>
                                        <td>". $value->irritabilidad_angustia_old ."</td>

                                        <td>". $value->conducta_status_old ."</td>
                                        <td>". $value->conducta_frecuencia_old ."</td>
                                        <td>". $value->conducta_severidad_old ."</td>
                                        <td>". $value->conducta_puntaje_old ."</td>
                                        <td>". $value->conducta_angustia_old ."</td>

                                        <td>". $value->trastornos_sueno_status_old ."</td>
                                        <td>". $value->trastornos_sueno_frecuencia_old ."</td>
                                        <td>". $value->trastornos_sueno_severidad_old ."</td>
                                        <td>". $value->trastornos_sueno_puntaje_old ."</td>
                                        <td>". $value->trastornos_sueno_angustia_old ."</td>

                                        <td>". $value->trastornos_apetito_status_old ."</td>
                                        <td>". $value->trastornos_apetito_frecuencia_old ."</td>
                                        <td>". $value->trastornos_apetito_severidad_old ."</td>
                                        <td>". $value->trastornos_apetito_puntaje_old ."</td>
                                        <td>". $value->trastornos_apetito_angustia_old ."</td>


                                        <td>". $value->usuario_creacion_old ."</td>
                                        <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->created_at_old)) : '') ."</td>
                                    </tr>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->puntaje_total_npi_new ."</td>
                                        <td>". $value->puntaje_total_para_angustia_new ."</td>
                                        
                                        <td>". $value->delirio_status_new ."</td>
                                        <td>". $value->delirio_frecuencia_new ."</td>
                                        <td>". $value->delirio_severidad_new ."</td>
                                        <td>". $value->delirio_puntaje_new ."</td>
                                        <td>". $value->delirio_angustia_new ."</td>

                                        <td>". $value->alucinaciones_status_new ."</td>
                                        <td>". $value->alucinaciones_frecuencia_new ."</td>
                                        <td>". $value->alucinaciones_severidad_new ."</td>
                                        <td>". $value->alucinaciones_puntaje_new ."</td>
                                        <td>". $value->alucinaciones_angustia_new ."</td>

                                        <td>". $value->agitacion_status_new ."</td>
                                        <td>". $value->agitacion_frecuencia_new ."</td>
                                        <td>". $value->agitacion_severidad_new ."</td>
                                        <td>". $value->agitacion_puntaje_new ."</td>
                                        <td>". $value->agitacion_angustia_new ."</td>

                                        <td>". $value->depresion_status_new ."</td>
                                        <td>". $value->depresion_frecuencia_new ."</td>
                                        <td>". $value->depresion_severidad_new ."</td>
                                        <td>". $value->depresion_puntaje_new ."</td>
                                        <td>". $value->depresion_angustia_new ."</td>

                                        <td>". $value->ansiedad_status_new ."</td>
                                        <td>". $value->ansiedad_frecuencia_new ."</td>
                                        <td>". $value->ansiedad_severidad_new ."</td>
                                        <td>". $value->ansiedad_puntaje_new ."</td>
                                        <td>". $value->ansiedad_angustia_new ."</td>

                                        <td>". $value->elacion_status_new ."</td>
                                        <td>". $value->elacion_frecuencia_new ."</td>
                                        <td>". $value->elacion_severidad_new ."</td>
                                        <td>". $value->elacion_puntaje_new ."</td>
                                        <td>". $value->elacion_angustia_new ."</td>

                                        <td>". $value->apatia_status_new ."</td>
                                        <td>". $value->apatia_frecuencia_new ."</td>
                                        <td>". $value->apatia_severidad_new ."</td>
                                        <td>". $value->apatia_puntaje_new ."</td>
                                        <td>". $value->apatia_angustia_new ."</td>

                                        <td>". $value->deshinibicion_status_new ."</td>
                                        <td>". $value->deshinibicion_frecuencia_new ."</td>
                                        <td>". $value->deshinibicion_severidad_new ."</td>
                                        <td>". $value->deshinibicion_puntaje_new ."</td>
                                        <td>". $value->deshinibicion_angustia_new ."</td>

                                        <td>". $value->irritabilidad_status_new ."</td>
                                        <td>". $value->irritabilidad_frecuencia_new ."</td>
                                        <td>". $value->irritabilidad_severidad_new ."</td>
                                        <td>". $value->irritabilidad_puntaje_new ."</td>
                                        <td>". $value->irritabilidad_angustia_new ."</td>

                                        <td>". $value->conducta_status_new ."</td>
                                        <td>". $value->conducta_frecuencia_new ."</td>
                                        <td>". $value->conducta_severidad_new ."</td>
                                        <td>". $value->conducta_puntaje_new ."</td>
                                        <td>". $value->conducta_angustia_new ."</td>

                                        <td>". $value->trastornos_sueno_status_new ."</td>
                                        <td>". $value->trastornos_sueno_frecuencia_new ."</td>
                                        <td>". $value->trastornos_sueno_severidad_new ."</td>
                                        <td>". $value->trastornos_sueno_puntaje_new ."</td>
                                        <td>". $value->trastornos_sueno_angustia_new ."</td>

                                        <td>". $value->trastornos_apetito_status_new ."</td>
                                        <td>". $value->trastornos_apetito_frecuencia_new ."</td>
                                        <td>". $value->trastornos_apetito_severidad_new ."</td>
                                        <td>". $value->trastornos_apetito_puntaje_new ."</td>
                                        <td>". $value->trastornos_apetito_angustia_new ."</td>


                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') ."</td>
                                    </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->puntaje_total_npi_new ."</td>
                                        <td>". $value->puntaje_total_para_angustia_new ."</td>
                                        
                                        <td>". $value->delirio_status_new ."</td>
                                        <td>". $value->delirio_frecuencia_new ."</td>
                                        <td>". $value->delirio_severidad_new ."</td>
                                        <td>". $value->delirio_puntaje_new ."</td>
                                        <td>". $value->delirio_angustia_new ."</td>

                                        <td>". $value->alucinaciones_status_new ."</td>
                                        <td>". $value->alucinaciones_frecuencia_new ."</td>
                                        <td>". $value->alucinaciones_severidad_new ."</td>
                                        <td>". $value->alucinaciones_puntaje_new ."</td>
                                        <td>". $value->alucinaciones_angustia_new ."</td>

                                        <td>". $value->agitacion_status_new ."</td>
                                        <td>". $value->agitacion_frecuencia_new ."</td>
                                        <td>". $value->agitacion_severidad_new ."</td>
                                        <td>". $value->agitacion_puntaje_new ."</td>
                                        <td>". $value->agitacion_angustia_new ."</td>

                                        <td>". $value->depresion_status_new ."</td>
                                        <td>". $value->depresion_frecuencia_new ."</td>
                                        <td>". $value->depresion_severidad_new ."</td>
                                        <td>". $value->depresion_puntaje_new ."</td>
                                        <td>". $value->depresion_angustia_new ."</td>

                                        <td>". $value->ansiedad_status_new ."</td>
                                        <td>". $value->ansiedad_frecuencia_new ."</td>
                                        <td>". $value->ansiedad_severidad_new ."</td>
                                        <td>". $value->ansiedad_puntaje_new ."</td>
                                        <td>". $value->ansiedad_angustia_new ."</td>

                                        <td>". $value->elacion_status_new ."</td>
                                        <td>". $value->elacion_frecuencia_new ."</td>
                                        <td>". $value->elacion_severidad_new ."</td>
                                        <td>". $value->elacion_puntaje_new ."</td>
                                        <td>". $value->elacion_angustia_new ."</td>

                                        <td>". $value->apatia_status_new ."</td>
                                        <td>". $value->apatia_frecuencia_new ."</td>
                                        <td>". $value->apatia_severidad_new ."</td>
                                        <td>". $value->apatia_puntaje_new ."</td>
                                        <td>". $value->apatia_angustia_new ."</td>

                                        <td>". $value->deshinibicion_status_new ."</td>
                                        <td>". $value->deshinibicion_frecuencia_new ."</td>
                                        <td>". $value->deshinibicion_severidad_new ."</td>
                                        <td>". $value->deshinibicion_puntaje_new ."</td>
                                        <td>". $value->deshinibicion_angustia_new ."</td>

                                        <td>". $value->irritabilidad_status_new ."</td>
                                        <td>". $value->irritabilidad_frecuencia_new ."</td>
                                        <td>". $value->irritabilidad_severidad_new ."</td>
                                        <td>". $value->irritabilidad_puntaje_new ."</td>
                                        <td>". $value->irritabilidad_angustia_new ."</td>

                                        <td>". $value->conducta_status_new ."</td>
                                        <td>". $value->conducta_frecuencia_new ."</td>
                                        <td>". $value->conducta_severidad_new ."</td>
                                        <td>". $value->conducta_puntaje_new ."</td>
                                        <td>". $value->conducta_angustia_new ."</td>

                                        <td>". $value->trastornos_sueno_status_new ."</td>
                                        <td>". $value->trastornos_sueno_frecuencia_new ."</td>
                                        <td>". $value->trastornos_sueno_severidad_new ."</td>
                                        <td>". $value->trastornos_sueno_puntaje_new ."</td>
                                        <td>". $value->trastornos_sueno_angustia_new ."</td>

                                        <td>". $value->trastornos_apetito_status_new ."</td>
                                        <td>". $value->trastornos_apetito_frecuencia_new ."</td>
                                        <td>". $value->trastornos_apetito_severidad_new ."</td>
                                        <td>". $value->trastornos_apetito_puntaje_new ."</td>
                                        <td>". $value->trastornos_apetito_angustia_new ."</td>


                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') ."</td>
                                    </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'protocol_deviation_form_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                         $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Fecha de Desviación</th>
                                            <th>Descripción de la Desviación</th>
                                            <th>¿Está la desviación aprobada por el Patrocinador?</th>
                                            <th>Ingresado/Modificado Por</th>
                                            <th>Fecha Modificacion</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        $salida .= "<tr>
                                        <td>". (($value->date_of_deviation_old != '0000-00-00') ? date('d/m/Y', strtotime($value->date_of_deviation_old)) : '') ."</td>
                                        <td>". $value->description_old ."</td>
                                        <td>". (($value->pre_approved_old == 1) ? 'Si' : 'No' )  ." ".  (($value->sponsor_name_old != '') ? 'por '. $value->sponsor_name_old : '') ."</td> 
                                        <td>". $value->usuario_actualizacion_old ."</td>
                                        <td>". (($value->updated_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_old)) : '') ."</td>
                                    </tr>";
                        $salida .= "<tr>
                                        <td>". (($value->date_of_deviation_new != '0000-00-00') ? date('d/m/Y', strtotime($value->date_of_deviation_new)) : '') ."</td>
                                        <td>". $value->description_new ."</td>
                                        <td>". (($value->pre_approved_new == 1) ? 'Si' : 'No' )  ." ".  (($value->sponsor_name_new != '') ? 'por '. $value->sponsor_name_new : '') ."</td> 
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)) : '') ."</td>
                                    </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->date_of_deviation_new != '0000-00-00') ? date('d/m/Y', strtotime($value->date_of_deviation_new)) : '') ."</td>
                                        <td>". $value->description_new ."</td>
                                        <td>". (($value->pre_approved_new == 1) ? 'Si' : 'No' )  ." ".  (($value->sponsor_name_new != '') ? 'por '. $value->sponsor_name_new : '') ."</td> 
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)) : '') ."</td>
                                    </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'restas_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                        $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th rowspan='2'>Realizado</th>
                                            <th rowspan='2'>Fecha</th>
                                            <th colspan='5'>Reste 3 a partir del 20</th>
                                            <th rowspan='2'>Ingresado/Modificado Por</th>
                                            <th rowspan='2'>Fecha Modificacion</th>
                                        </tr>
                                        <tr>
                                            <th>17</th>
                                            <th>14</th>
                                            <th>11</th>
                                            <th>8</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                        $salida .= "<tr>
                                        <td>". (($value->realizado_alt_old == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_alt_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_alt_old)) : '') ."</td>
                                        <td>". (($value->resta_alt_1_old == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". (($value->resta_alt_2_old == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". (($value->resta_alt_3_old == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". (($value->resta_alt_4_old == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". (($value->resta_alt_5_old == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". $value->usuario_creacion_old ."</td>
                                        <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->created_at_old)) : '') ."</td>
                                    </tr>";

                        $salida .= "<tr>
                                        <td>". (($value->realizado_alt_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_alt_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_alt_new)) : '') ."</td>
                                        <td>". (($value->resta_alt_1_new == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". (($value->resta_alt_2_new == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". (($value->resta_alt_3_new == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". (($value->resta_alt_4_new == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". (($value->resta_alt_5_new == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)) : '') ."</td>
                                    </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->realizado_alt_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_alt_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_alt_new)) : '') ."</td>
                                        <td>". (($value->resta_alt_1_new == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". (($value->resta_alt_2_new == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". (($value->resta_alt_3_new == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". (($value->resta_alt_4_new == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". (($value->resta_alt_5_new == 1) ? 'Correcto' : 'Incorrecto') ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)) : '') ."</td>
                                    </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'rnm_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                         $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th colspan='3'>¿Sujeto dispone de una Resonancia Magnética?</th>
                                            <th colspan='3'>¿Sujeto dispone de una Tomografía Computarizada?</th>
                                            <th rowspan='2'>Ingresado/Modificado Por</th>
                                            <th rowspan='2'>Fecha Modificacion</th>
                                        </tr>
                                        <tr>
                                            <th>Si/No</th>
                                            <th>Fecha Examen</th>
                                            <th>Comentarios</th>
                                            <th>Si/No</th>
                                            <th>Fecha Examen</th>
                                            <th>Comentarios</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                        $salida .= "<tr>
                                        <td>". (($value->resonancia_old == 1) ? 'Si' : (($value->resonancia_old == '0') ? 'No' : '')) ."</td>
                                        <td>". (($value->resonancia_fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->resonancia_fecha_old)): '')."</td>
                                        <td>". $value->resonancia_comentario_old ."</td>
                                        <td>". (($value->tomografia_old == 1) ? 'Si' : (($value->tomografia_old == '0') ? 'No' : ''))  ."</td>
                                        <td>". (($value->tomografia_fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->tomografia_fecha_old)): '')."</td>
                                        <td>". $value->tomografia_comentario_old ."</td>
                                        <td>". $value->usuario_creacion_old ."</td>
                                        <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->created_at_old)): '')."</td>
                                    </tr>";

                        $salida .= "<tr>
                                    <td>". (($value->resonancia_new == 1) ? 'Si' : (($value->resonancia_new == '0') ? 'No' : '')) ."</td>
                                    <td>". (($value->resonancia_fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->resonancia_fecha_new)): '')."</td>
                                    <td>". $value->resonancia_comentario_new ."</td>
                                    <td>". (($value->tomografia_new == 1) ? 'Si' : (($value->tomografia_new == '0') ? 'No' : ''))  ."</td>
                                    <td>". (($value->tomografia_fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->tomografia_fecha_new)): '')."</td>
                                    <td>". $value->tomografia_comentario_new ."</td>
                                    <td>". $value->usuario_actualizacion_new ."</td>
                                    <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)): '')."</td>
                                </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                    <td>". (($value->resonancia_new == 1) ? 'Si' : (($value->resonancia_new == '0') ? 'No' : '')) ."</td>
                                    <td>". (($value->resonancia_fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->resonancia_fecha_new)): '')."</td>
                                    <td>". $value->resonancia_comentario_new ."</td>
                                    <td>". (($value->tomografia_new == 1) ? 'Si' : (($value->tomografia_new == '0') ? 'No' : ''))  ."</td>
                                    <td>". (($value->tomografia_fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->tomografia_fecha_new)): '')."</td>
                                    <td>". $value->tomografia_comentario_new ."</td>
                                    <td>". $value->usuario_actualizacion_new ."</td>
                                    <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)): '')."</td>
                                </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'signos_vitales_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                        $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Realizado</th>
                                            <th>Fecha</th>
                                            <th>Estatura</th>
                                            <th>Presion Sistolica</th>
                                            <th>Presion Diastolica</th>
                                            <th>Frecuencia Cardiaca</th>
                                            <th>Frecuencia Respiratoria</th>
                                            <th>Temperatura</th>
                                            <th>Peso</th>
                                            <th>IMC</th>
                                            <th>Ingresado/Modificado Por</th>
                                            <th>Fecha Modificacion</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_old == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>
                                        <td>". $value->estatura_old ."</td>
                                        <td>". $value->presion_sistolica_old ."</td>
                                        <td>". $value->presion_diastolica_old ."</td>
                                        <td>". $value->frecuencia_cardiaca_old ."</td>
                                        <td>". $value->frecuencia_respiratoria_old ."</td>
                                        <td>". $value->temperatura_old ."</td>
                                        <td>". $value->peso_old ."</td>
                                        <td>". $value->imc_old ."</td>
                                        <td>". $value->usuario_creacion_old ."</td>
                                        <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->created_at_old)): '')."</td>
                                    </tr>";

                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->estatura_new ."</td>
                                        <td>". $value->presion_sistolica_new ."</td>
                                        <td>". $value->presion_diastolica_new ."</td>
                                        <td>". $value->frecuencia_cardiaca_new ."</td>
                                        <td>". $value->frecuencia_respiratoria_new ."</td>
                                        <td>". $value->temperatura_new ."</td>
                                        <td>". $value->peso_new ."</td>
                                        <td>". $value->imc_new ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)): '')."</td>
                                    </tr>";

                    }
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->estatura_new ."</td>
                                        <td>". $value->presion_sistolica_new ."</td>
                                        <td>". $value->presion_diastolica_new ."</td>
                                        <td>". $value->frecuencia_cardiaca_new ."</td>
                                        <td>". $value->frecuencia_respiratoria_new ."</td>
                                        <td>". $value->temperatura_new ."</td>
                                        <td>". $value->peso_new ."</td>
                                        <td>". $value->imc_new ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)): '')."</td>
                                    </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'tmt_a_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                        $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Realizado</th>
                                            <th>Fecha</th>
                                            <th>Segundos</th>
                                            <th>Ingresado/Modificado Por</th>
                                            <th>Fecha Modificacion</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_old == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>
                                        <td>". $value->segundos_old ."</td>
                                        <td>". $value->usuario_creacion_old ."</td>
                                        <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->created_at_old)): '')."</td>
                                    </tr>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->segundos_new ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)): '')."</td>
                                    </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->segundos_new ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)): '')."</td>
                                    </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'tmt_b_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                        $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Realizado</th>
                                            <th>Fecha</th>
                                            <th>Segundos</th>
                                            <th>Ingresado/Modificado Por</th>
                                            <th>Fecha Modificacion</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_old == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>
                                        <td>". $value->segundos_old ."</td>
                                        <td>". $value->usuario_creacion_old ."</td>
                                        <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->created_at_old)): '')."</td>
                                    </tr>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->segundos_new ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)): '')."</td>
                                    </tr>";
                    }                    
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->segundos_new ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)): '')."</td>
                                    </tr>";
                    }

                    $contador++;
                }
                //adicionales
                elseif($tabla == ''){

                }
                elseif($tabla == ''){

                }
            } //fin foreach

            if(!empty($salida)){
                $salida .= '</tbody>
                            </table>';
            }

            return $salida;

        }else{

            return false;

        }
    }
}