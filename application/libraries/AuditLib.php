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
                                        </tr>
                                    </thead>
                                    <tbody>";
                        $salida .= "<tr>
                                        <td>". (($value->hallazgo_old) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>
                                        
                                        <td>". (($value->aspecto_general_old == 1) ? 'Normal' : (($value->aspecto_general_old == "0") ? 'Anormal' : '')) ."</td>
                                        <td>". $value->aspecto_general_desc_old ."</td>                                        
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
                                            <th rowspan='3'>Realizado</th>
                                            <th rowspan='3'>Fecha</th>
                                            <th colspan='20'>Hematológico</th>
                                            <th colspan='28'>Bioquímico</th>
                                            <th colspan='12'>Análisis de Orina</th>
                                            <th colspan='12'>Otros</th>
                                            <th rowspan='3'>Ingresado/Modificado Por</th>
                                            <th rowspan='3'>Fecha modificacion</th>                                            
                                        </tr>

                                        <tr>
                                            <th colspan='2'>Hematocrito</th>
                                            <th colspan='2'>Hemoglobina</th>
                                            <th colspan='2'>Recuento eritrocitos (RBC)</th>
                                            <th colspan='2'>Recuento leucocitos (WBC)</th>
                                            <th colspan='2'>Neutrófilos</th>
                                            <th colspan='2'>Linfocitos</th>
                                            <th colspan='2'>Monocitos</th>
                                            <th colspan='2'>Eosinófilos</th>
                                            <th colspan='2'>Basófilos</th>
                                            <th colspan='2'>Recuento plaquetas</th>

                                            <th colspan='2'>Glucosa (ayunas)</th>
                                            <th colspan='2'>BUN</th>
                                            <th colspan='2'>Creatinina</th>
                                            <th colspan='2'>Bilirrubina total</th>
                                            <th colspan='2'>Proteínas totales</th>
                                            <th colspan='2'>Fosfatasas alcalinas</th>
                                            <th colspan='2'>AST</th>
                                            <th colspan='2'>ALT</th>
                                            <th colspan='2'>Calcio (Ca)</th>
                                            <th colspan='2'>Sodio (Na)</th>
                                            <th colspan='2'>Potasio (K)</th>
                                            <th colspan='2'>Cloro (Cl)</th>
                                            <th colspan='2'>Ácido úrico</th>
                                            <th colspan='2'>Albúmina</th>

                                            <th colspan='2'>pH</th>
                                            <th colspan='2'>Glucosa (qual)</th>
                                            <th colspan='2'>Proteína (qual)</th>
                                            <th colspan='2'>Sangre (qual)</th>
                                            <th colspan='2'>Cetonas</th>
                                            <th colspan='2'>Microscopía</th>

                                            <th colspan='2'>Homocisteina</th>
                                            <th colspan='2'>Perfil Tiroideo</th>
                                            <th colspan='2'>Nivel plasmático de V B12</th>
                                            <th colspan='2'>Nivel plasmático de ácido fólico</th>
                                            <th colspan='2'>HbA1C</th>
                                            <th colspan='2'>Sífilis (VDRL)</th>

                                        </tr>

                                        <tr>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                            <th>Realizado</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                        $salida .= '<tr>
                                        <td>'. (($value->realizado_old) ? 'Si' : 'No') .'</td>
                                        <td>'. (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') .'</td>
                                        
                                        <td>'. (($value->hecho_1_old == 1) ? 'Si' : (($value->hecho_1_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_1_old == 1) ? $value->hematocrito_old .' % '. (($value->hematocrito_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->hematocrito_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->hematocrito_nom_anom_old) : '' ).'</td>                                 
                                        
                                        <td>'. (($value->hecho_2_old == 1) ? 'Si' : (($value->hecho_2_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_2_old == 1) ? $value->hemoglobina_old .' g/dl '. (($value->hemoglobina_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->hemoglobina_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->hemoglobina_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_3_old == 1) ? 'Si' : (($value->hecho_3_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_3_old == 1) ? $value->eritocritos_old .' M/µl '. (($value->eritocritos_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->eritocritos_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->eritocritos_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_4_old == 1) ? 'Si' : (($value->hecho_4_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_4_old == 1) ? $value->leucocitos_old .' /µl '. (($value->leucocitos_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->leucocitos_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->leucocitos_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_5_old == 1) ? 'Si' : (($value->hecho_5_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_5_old == 1) ? $value->neutrofilos_old .' /µl '. (($value->neutrofilos_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->neutrofilos_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->neutrofilos_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_6_old == 1) ? 'Si' : (($value->hecho_6_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_6_old == 1) ? $value->linfocitos_old .' /µl '. (($value->linfocitos_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->linfocitos_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->linfocitos_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_7_old == 1) ? 'Si' : (($value->hecho_7_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_7_old == 1) ? $value->monocitos_old .' /µl '. (($value->monocitos_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->monocitos_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->monocitos_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_8_old == 1) ? 'Si' : (($value->hecho_8_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_8_old == 1) ? $value->eosinofilos_old .' /µl '. (($value->eosinofilos_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->eosinofilos_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->eosinofilos_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_9_old == 1) ? 'Si' : (($value->hecho_9_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_9_old == 1) ? $value->basofilos_old .' /µl '. (($value->basofilos_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->basofilos_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->basofilos_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_10_old == 1) ? 'Si' : (($value->hecho_10_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_10_old == 1) ? $value->recuento_plaquetas_old .' x mm<sup>3</sup> '. (($value->recuento_plaquetas_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->recuento_plaquetas_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->recuento_plaquetas_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_11_old == 1) ? 'Si' : (($value->hecho_11_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_11_old == 1) ? $value->glucosa_ayunas_old .' mg/dl '. (($value->glucosa_ayunas_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->glucosa_ayunas_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->glucosa_ayunas_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_12_old == 1) ? 'Si' : (($value->hecho_12_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_12_old == 1) ? $value->bun_old .' mg/dl '. (($value->bun_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->bun_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->bun_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_13_old == 1) ? 'Si' : (($value->hecho_13_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_13_old == 1) ? $value->creatinina_old .' mg/dl '. (($value->creatinina_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->creatinina_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->creatinina_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_14_old == 1) ? 'Si' : (($value->hecho_14_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_14_old == 1) ? $value->bilirrubina_total_old .' mg/dl '. (($value->bilirrubina_total_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->bilirrubina_total_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->bilirrubina_total_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_15_old == 1) ? 'Si' : (($value->hecho_15_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_15_old == 1) ? $value->proteinas_totales_old .' g/dl '. (($value->proteinas_totales_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->proteinas_totales_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->proteinas_totales_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_16_old == 1) ? 'Si' : (($value->hecho_16_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_16_old == 1) ? $value->fosfatasas_alcalinas_old .' U/l '. (($value->fosfatasas_alcalinas_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->fosfatasas_alcalinas_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->fosfatasas_alcalinas_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_17_old == 1) ? 'Si' : (($value->hecho_17_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_17_old == 1) ? $value->ast_old .' U/l '. (($value->ast_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->ast_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->ast_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_18_old == 1) ? 'Si' : (($value->hecho_18_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_18_old == 1) ? $value->alt_old .' U/l '. (($value->alt_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->alt_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->alt_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_19_old == 1) ? 'Si' : (($value->hecho_19_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_19_old == 1) ? $value->calcio_old .' '. $value->calcio_unidad_medida_old .' '. (($value->calcio_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->calcio_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->calcio_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_20_old == 1) ? 'Si' : (($value->hecho_20_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_20_old == 1) ? $value->sodio_old .' '. $value->sodio_unidad_medida_old .' '. (($value->sodio_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->sodio_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->sodio_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_21_old == 1) ? 'Si' : (($value->hecho_21_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_21_old == 1) ? $value->potasio_old .' '. $value->potasio_unidad_medida_old .' '. (($value->potasio_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->potasio_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->potasio_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_22_old == 1) ? 'Si' : (($value->hecho_22_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_22_old == 1) ? $value->cloro_old .' '. $value->cloro_unidad_medida_old .' '. (($value->cloro_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->cloro_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->cloro_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_23_old == 1) ? 'Si' : (($value->hecho_23_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_23_old == 1) ? $value->acido_urico_old .' mg/dl '. (($value->acido_urico_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->acido_urico_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->acido_urico_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_24_old == 1) ? 'Si' : (($value->hecho_24_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_24_old== 1) ? $value->albumina_old .' mg/dl '. (($value->albumina_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->albumina_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->albumina_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_25_old == 1) ? 'Si' : (($value->hecho_25_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_25_old == 1) ? $value->orina_ph_old .' '. (($value->orina_ph_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_ph_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_ph_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_26_old == 1) ? 'Si' : (($value->hecho_26_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_26_old == 1) ? $value->orina_glucosa_old .' '. $value->glucosa_unidad_medida_old .' '. (($value->orina_glucosa_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_glucosa_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_glucosa_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_27_old == 1) ? 'Si' : (($value->hecho_27_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_27_old == 1) ? $value->orina_proteinas_old .' mUI/ml '. (($value->orina_proteinas_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_proteinas_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_proteinas_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_28_old == 1) ? 'Si' : (($value->hecho_28_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_28_old == 1) ? $value->orina_sangre_old .' mUI/ml '. (($value->orina_sangre_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_sangre_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_sangre_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_29_old == 1) ? 'Si' : (($value->hecho_29_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_29_old == 1) ? $value->orina_cetonas_old .' mmol/l '. (($value->orina_cetonas_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_cetonas_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_cetonas_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_30_old == 1) ? 'Si' : (($value->hecho_30_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_30_old == 1) ? $value->orina_microscospia_old .' '. (($value->orina_microscospia_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_microscospia_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_microscospia_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_31_old == 1) ? 'Si' : (($value->hecho_31_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_31_old == 1) ? $value->otros_sangre_homocisteina_old .' '. (($value->otros_sangre_homocisteina_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_sangre_homocisteina_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_sangre_homocisteina_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_32_old == 1) ? 'Si' : (($value->hecho_32_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_32_old == 1) ? $value->otros_perfil_tiroideo_old .' '. (($value->otros_perfil_tiroideo_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_perfil_tiroideo_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_perfil_tiroideo_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_33_old == 1) ? 'Si' : (($value->hecho_33_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_33_old == 1) ? $value->otros_nivel_b12_old .' '. (($value->otros_nivel_b12_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_nivel_b12_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_nivel_b12_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_34_old == 1) ? 'Si' : (($value->hecho_34_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_34_old == 1) ? $value->otros_acido_folico_old .' '. (($value->otros_acido_folico_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_acido_folico_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_acido_folico_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_35_old == 1) ? 'Si' : (($value->hecho_35_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_35_old == 1) ? $value->otros_hba1c_old .' '. (($value->otros_hba1c_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_hba1c_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_hba1c_nom_anom_old) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_36_old == 1) ? 'Si' : (($value->hecho_36_old == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_36_old == 1) ? $value->sifilis_old .' '. (($value->sifilis_nom_anom_old == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->sifilis_nom_anom_old) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->sifilis_nom_anom_old) : '' ).'</td>                                        

                                        <td>'. $value->usuario_creacion_old .'</td>
                                        <td>'. (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->created_at_old)) : '') .'</td>
                                    </tr>';

                         $salida .= '<tr>
                                        <td>'. (($value->realizado_new) ? 'Si' : 'No') .'</td>
                                        <td>'. (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') .'</td>
                                        
                                        <td>'. (($value->hecho_1_new == 1) ? 'Si' : (($value->hecho_1_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_1_new == 1) ? $value->hematocrito_new .' % '. (($value->hematocrito_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->hematocrito_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->hematocrito_nom_anom_new) : '' ).'</td>                                 
                                        
                                        <td>'. (($value->hecho_2_new == 1) ? 'Si' : (($value->hecho_2_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_2_new == 1) ? $value->hemoglobina_new .' g/dl '. (($value->hemoglobina_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->hemoglobina_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->hemoglobina_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_3_new == 1) ? 'Si' : (($value->hecho_3_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_3_new == 1) ? $value->eritocritos_new .' M/µl '. (($value->eritocritos_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->eritocritos_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->eritocritos_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_4_new == 1) ? 'Si' : (($value->hecho_4_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_4_new == 1) ? $value->leucocitos_new .' /µl '. (($value->leucocitos_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->leucocitos_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->leucocitos_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_5_new == 1) ? 'Si' : (($value->hecho_5_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_5_new == 1) ? $value->neutrofilos_new .' /µl '. (($value->neutrofilos_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->neutrofilos_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->neutrofilos_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_6_new == 1) ? 'Si' : (($value->hecho_6_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_6_new == 1) ? $value->linfocitos_new .' /µl '. (($value->linfocitos_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->linfocitos_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->linfocitos_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_7_new == 1) ? 'Si' : (($value->hecho_7_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_7_new == 1) ? $value->monocitos_new .' /µl '. (($value->monocitos_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->monocitos_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->monocitos_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_8_new == 1) ? 'Si' : (($value->hecho_8_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_8_new == 1) ? $value->eosinofilos_new .' /µl '. (($value->eosinofilos_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->eosinofilos_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->eosinofilos_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_9_new == 1) ? 'Si' : (($value->hecho_9_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_9_new == 1) ? $value->basofilos_new .' /µl '. (($value->basofilos_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->basofilos_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->basofilos_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_10_new == 1) ? 'Si' : (($value->hecho_10_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_10_new == 1) ? $value->recuento_plaquetas_new .' x mm<sup>3</sup> '. (($value->recuento_plaquetas_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->recuento_plaquetas_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->recuento_plaquetas_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_11_new == 1) ? 'Si' : (($value->hecho_11_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_11_new == 1) ? $value->glucosa_ayunas_new .' mg/dl '. (($value->glucosa_ayunas_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->glucosa_ayunas_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->glucosa_ayunas_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_12_new == 1) ? 'Si' : (($value->hecho_12_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_12_new == 1) ? $value->bun_new .' mg/dl '. (($value->bun_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->bun_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->bun_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_13_new == 1) ? 'Si' : (($value->hecho_13_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_13_new == 1) ? $value->creatinina_new .' mg/dl '. (($value->creatinina_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->creatinina_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->creatinina_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_14_new == 1) ? 'Si' : (($value->hecho_14_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_14_new == 1) ? $value->bilirrubina_total_new .' mg/dl '. (($value->bilirrubina_total_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->bilirrubina_total_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->bilirrubina_total_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_15_new == 1) ? 'Si' : (($value->hecho_15_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_15_new == 1) ? $value->proteinas_totales_new .' g/dl '. (($value->proteinas_totales_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->proteinas_totales_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->proteinas_totales_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_16_new == 1) ? 'Si' : (($value->hecho_16_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_16_new == 1) ? $value->fosfatasas_alcalinas_new .' U/l '. (($value->fosfatasas_alcalinas_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->fosfatasas_alcalinas_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->fosfatasas_alcalinas_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_17_new == 1) ? 'Si' : (($value->hecho_17_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_17_new == 1) ? $value->ast_new .' U/l '. (($value->ast_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->ast_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->ast_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_18_new == 1) ? 'Si' : (($value->hecho_18_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_18_new == 1) ? $value->alt_new .' U/l '. (($value->alt_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->alt_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->alt_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_19_new == 1) ? 'Si' : (($value->hecho_19_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_19_new == 1) ? $value->calcio_new .' '. $value->calcio_unidad_medida_new .' '. (($value->calcio_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->calcio_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->calcio_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_20_new == 1) ? 'Si' : (($value->hecho_20_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_20_new == 1) ? $value->sodio_new .' '. $value->sodio_unidad_medida_new .' '. (($value->sodio_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->sodio_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->sodio_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_21_new == 1) ? 'Si' : (($value->hecho_21_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_21_new == 1) ? $value->potasio_new .' '. $value->potasio_unidad_medida_new .' '. (($value->potasio_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->potasio_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->potasio_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_22_new == 1) ? 'Si' : (($value->hecho_22_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_22_new == 1) ? $value->cloro_new .' '. $value->cloro_unidad_medida_new .' '. (($value->cloro_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->cloro_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->cloro_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_23_new == 1) ? 'Si' : (($value->hecho_23_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_23_new == 1) ? $value->acido_urico_new .' mg/dl '. (($value->acido_urico_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->acido_urico_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->acido_urico_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_24_new == 1) ? 'Si' : (($value->hecho_24_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_24_new== 1) ? $value->albumina_new .' mg/dl '. (($value->albumina_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->albumina_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->albumina_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_25_new == 1) ? 'Si' : (($value->hecho_25_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_25_new == 1) ? $value->orina_ph_new .' '. (($value->orina_ph_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_ph_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_ph_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_26_new == 1) ? 'Si' : (($value->hecho_26_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_26_new == 1) ? $value->orina_glucosa_new .' '. $value->glucosa_unidad_medida_new .' '. (($value->orina_glucosa_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_glucosa_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_glucosa_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_27_new == 1) ? 'Si' : (($value->hecho_27_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_27_new == 1) ? $value->orina_proteinas_new .' mUI/ml '. (($value->orina_proteinas_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_proteinas_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_proteinas_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_28_new == 1) ? 'Si' : (($value->hecho_28_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_28_new == 1) ? $value->orina_sangre_new .' mUI/ml '. (($value->orina_sangre_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_sangre_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_sangre_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_29_new == 1) ? 'Si' : (($value->hecho_29_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_29_new == 1) ? $value->orina_cetonas_new .' mmol/l '. (($value->orina_cetonas_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_cetonas_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_cetonas_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_30_new == 1) ? 'Si' : (($value->hecho_30_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_30_new == 1) ? $value->orina_microscospia_new .' '. (($value->orina_microscospia_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_microscospia_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_microscospia_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_31_new == 1) ? 'Si' : (($value->hecho_31_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_31_new == 1) ? $value->otros_sangre_homocisteina_new .' '. (($value->otros_sangre_homocisteina_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_sangre_homocisteina_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_sangre_homocisteina_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_32_new == 1) ? 'Si' : (($value->hecho_32_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_32_new == 1) ? $value->otros_perfil_tiroideo_new .' '. (($value->otros_perfil_tiroideo_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_perfil_tiroideo_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_perfil_tiroideo_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_33_new == 1) ? 'Si' : (($value->hecho_33_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_33_new == 1) ? $value->otros_nivel_b12_new .' '. (($value->otros_nivel_b12_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_nivel_b12_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_nivel_b12_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_34_new == 1) ? 'Si' : (($value->hecho_34_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_34_new == 1) ? $value->otros_acido_folico_new .' '. (($value->otros_acido_folico_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_acido_folico_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_acido_folico_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_35_new == 1) ? 'Si' : (($value->hecho_35_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_35_new == 1) ? $value->otros_hba1c_new .' '. (($value->otros_hba1c_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_hba1c_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_hba1c_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_36_new == 1) ? 'Si' : (($value->hecho_36_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_36_new == 1) ? $value->sifilis_new .' '. (($value->sifilis_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->sifilis_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->sifilis_nom_anom_new) : '' ).'</td>                                        

                                        <td>'. $value->usuario_actualizacion_new .'</td>
                                        <td>'. (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') .'</td>
                                    </tr>';
                    }
                    else{
                        $salida .= '<tr>
                                        <td>'. (($value->realizado_new) ? 'Si' : 'No') .'</td>
                                        <td>'. (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') .'</td>
                                        
                                        <td>'. (($value->hecho_1_new == 1) ? 'Si' : (($value->hecho_1_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_1_new == 1) ? $value->hematocrito_new .' % '. (($value->hematocrito_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->hematocrito_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->hematocrito_nom_anom_new) : '' ).'</td>                                 
                                        
                                        <td>'. (($value->hecho_2_new == 1) ? 'Si' : (($value->hecho_2_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_2_new == 1) ? $value->hemoglobina_new .' g/dl '. (($value->hemoglobina_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->hemoglobina_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->hemoglobina_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_3_new == 1) ? 'Si' : (($value->hecho_3_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_3_new == 1) ? $value->eritocritos_new .' M/µl '. (($value->eritocritos_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->eritocritos_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->eritocritos_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_4_new == 1) ? 'Si' : (($value->hecho_4_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_4_new == 1) ? $value->leucocitos_new .' /µl '. (($value->leucocitos_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->leucocitos_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->leucocitos_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_5_new == 1) ? 'Si' : (($value->hecho_5_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_5_new == 1) ? $value->neutrofilos_new .' /µl '. (($value->neutrofilos_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->neutrofilos_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->neutrofilos_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_6_new == 1) ? 'Si' : (($value->hecho_6_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_6_new == 1) ? $value->linfocitos_new .' /µl '. (($value->linfocitos_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->linfocitos_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->linfocitos_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_7_new == 1) ? 'Si' : (($value->hecho_7_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_7_new == 1) ? $value->monocitos_new .' /µl '. (($value->monocitos_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->monocitos_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->monocitos_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_8_new == 1) ? 'Si' : (($value->hecho_8_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_8_new == 1) ? $value->eosinofilos_new .' /µl '. (($value->eosinofilos_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->eosinofilos_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->eosinofilos_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_9_new == 1) ? 'Si' : (($value->hecho_9_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_9_new == 1) ? $value->basofilos_new .' /µl '. (($value->basofilos_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->basofilos_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->basofilos_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_10_new == 1) ? 'Si' : (($value->hecho_10_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_10_new == 1) ? $value->recuento_plaquetas_new .' x mm<sup>3</sup> '. (($value->recuento_plaquetas_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->recuento_plaquetas_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->recuento_plaquetas_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_11_new == 1) ? 'Si' : (($value->hecho_11_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_11_new == 1) ? $value->glucosa_ayunas_new .' mg/dl '. (($value->glucosa_ayunas_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->glucosa_ayunas_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->glucosa_ayunas_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_12_new == 1) ? 'Si' : (($value->hecho_12_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_12_new == 1) ? $value->bun_new .' mg/dl '. (($value->bun_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->bun_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->bun_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_13_new == 1) ? 'Si' : (($value->hecho_13_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_13_new == 1) ? $value->creatinina_new .' mg/dl '. (($value->creatinina_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->creatinina_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->creatinina_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_14_new == 1) ? 'Si' : (($value->hecho_14_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_14_new == 1) ? $value->bilirrubina_total_new .' mg/dl '. (($value->bilirrubina_total_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->bilirrubina_total_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->bilirrubina_total_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_15_new == 1) ? 'Si' : (($value->hecho_15_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_15_new == 1) ? $value->proteinas_totales_new .' g/dl '. (($value->proteinas_totales_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->proteinas_totales_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->proteinas_totales_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_16_new == 1) ? 'Si' : (($value->hecho_16_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_16_new == 1) ? $value->fosfatasas_alcalinas_new .' U/l '. (($value->fosfatasas_alcalinas_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->fosfatasas_alcalinas_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->fosfatasas_alcalinas_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_17_new == 1) ? 'Si' : (($value->hecho_17_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_17_new == 1) ? $value->ast_new .' U/l '. (($value->ast_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->ast_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->ast_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_18_new == 1) ? 'Si' : (($value->hecho_18_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_18_new == 1) ? $value->alt_new .' U/l '. (($value->alt_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->alt_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->alt_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_19_new == 1) ? 'Si' : (($value->hecho_19_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_19_new == 1) ? $value->calcio_new .' '. $value->calcio_unidad_medida_new .' '. (($value->calcio_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->calcio_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->calcio_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_20_new == 1) ? 'Si' : (($value->hecho_20_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_20_new == 1) ? $value->sodio_new .' '. $value->sodio_unidad_medida_new .' '. (($value->sodio_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->sodio_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->sodio_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_21_new == 1) ? 'Si' : (($value->hecho_21_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_21_new == 1) ? $value->potasio_new .' '. $value->potasio_unidad_medida_new .' '. (($value->potasio_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->potasio_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->potasio_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_22_new == 1) ? 'Si' : (($value->hecho_22_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_22_new == 1) ? $value->cloro_new .' '. $value->cloro_unidad_medida_new .' '. (($value->cloro_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->cloro_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->cloro_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_23_new == 1) ? 'Si' : (($value->hecho_23_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_23_new == 1) ? $value->acido_urico_new .' mg/dl '. (($value->acido_urico_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->acido_urico_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->acido_urico_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_24_new == 1) ? 'Si' : (($value->hecho_24_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_24_new== 1) ? $value->albumina_new .' mg/dl '. (($value->albumina_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->albumina_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->albumina_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_25_new == 1) ? 'Si' : (($value->hecho_25_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_25_new == 1) ? $value->orina_ph_new .' '. (($value->orina_ph_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_ph_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_ph_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_26_new == 1) ? 'Si' : (($value->hecho_26_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_26_new == 1) ? $value->orina_glucosa_new .' '. $value->glucosa_unidad_medida_new .' '. (($value->orina_glucosa_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_glucosa_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_glucosa_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_27_new == 1) ? 'Si' : (($value->hecho_27_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_27_new == 1) ? $value->orina_proteinas_new .' mUI/ml '. (($value->orina_proteinas_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_proteinas_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_proteinas_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_28_new == 1) ? 'Si' : (($value->hecho_28_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_28_new == 1) ? $value->orina_sangre_new .' mUI/ml '. (($value->orina_sangre_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_sangre_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_sangre_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_29_new == 1) ? 'Si' : (($value->hecho_29_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_29_new == 1) ? $value->orina_cetonas_new .' mmol/l '. (($value->orina_cetonas_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_cetonas_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_cetonas_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_30_new == 1) ? 'Si' : (($value->hecho_30_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_30_new == 1) ? $value->orina_microscospia_new .' '. (($value->orina_microscospia_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->orina_microscospia_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->orina_microscospia_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_31_new == 1) ? 'Si' : (($value->hecho_31_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_31_new == 1) ? $value->otros_sangre_homocisteina_new .' '. (($value->otros_sangre_homocisteina_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_sangre_homocisteina_nom_anom) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_sangre_homocisteina_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_32_new == 1) ? 'Si' : (($value->hecho_32_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_32_new == 1) ? $value->otros_perfil_tiroideo_new .' '. (($value->otros_perfil_tiroideo_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_perfil_tiroideo_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_perfil_tiroideo_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_33_new == 1) ? 'Si' : (($value->hecho_33_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_33_new == 1) ? $value->otros_nivel_b12_new .' '. (($value->otros_nivel_b12_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_nivel_b12_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_nivel_b12_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_34_new == 1) ? 'Si' : (($value->hecho_34_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_34_new == 1) ? $value->otros_acido_folico_new .' '. (($value->otros_acido_folico_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_acido_folico_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_acido_folico_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_35_new == 1) ? 'Si' : (($value->hecho_35_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_35_new == 1) ? $value->otros_hba1c_new .' '. (($value->otros_hba1c_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->otros_hba1c_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->otros_hba1c_nom_anom_new) : '' ).'</td>
                                        
                                        <td>'. (($value->hecho_36_new == 1) ? 'Si' : (($value->hecho_36_new == '0') ? 'No' : '')).'</td>
                                        <td>'. (($value->hecho_36_new == 1) ? $value->sifilis_new .' '. (($value->sifilis_nom_anom_new == 'Anormal_sin') ? 'Anormal sin significancia clinica' : (($value->sifilis_nom_anom_new) == 'Anormal_con') ? 'Anormal con significancia clinica' : $value->sifilis_nom_anom_new) : '' ).'</td>                                        

                                        <td>'. $value->usuario_actualizacion_new .'</td>
                                        <td>'. (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') .'</td>
                                    </tr>';
                    }

                    $contador++;
                }
                elseif($tabla == 'examen_neurologico_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                        $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th rowspan='2'>Realizado</th>
                                            <th rowspan='2'>Fecha</th>                                            
                                            <th colspan='2'>Nervios craneales</th>
                                            <th colspan='2'>Fuerza muscular</th>
                                            <th colspan='2'>Tono</th>
                                            <th colspan='2'>Movimientos anormales</th>
                                            <th colspan='2'>Reflejos tendinosos profundos</th>
                                            <th colspan='2'>Examen sensorial</th>
                                            <th colspan='2'>Marcha</th>
                                            <th colspan='2'>Postura</th>
                                            <th colspan='2'>Coordinación</th>
                                            <th colspan='2'>Función cortical superior</th>
                                            <th rowspan='2'>Ingresado/Modificado Por</th>
                                            <th rowspan='2'>Fecha modificacion</th>                                            
                                        </tr>
                                        <tr>
                                            <th>Normal/Anormal</th>
                                            <th>Detallar si es Anormal</th>
                                            <th>Normal/Anormal</th>
                                            <th>Detallar si es Anormal</th>
                                            <th>Normal/Anormal</th>
                                            <th>Detallar si es Anormal</th>
                                            <th>Normal/Anormal</th>
                                            <th>Detallar si es Anormal</th>
                                            <th>Normal/Anormal</th>
                                            <th>Detallar si es Anormal</th>
                                            <th>Normal/Anormal</th>
                                            <th>Detallar si es Anormal</th>
                                            <th>Normal/Anormal</th>
                                            <th>Detallar si es Anormal</th>
                                            <th>Normal/Anormal</th>
                                            <th>Detallar si es Anormal</th>
                                            <th>Normal/Anormal</th>
                                            <th>Detallar si es Anormal</th>
                                            <th>Normal/Anormal</th>
                                            <th>Detallar si es Anormal</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                        $salida .= "<tr>
                                        <td>". (($value->realizado_old) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>
                                        
                                        <td>". (($value->nervios_craneanos_normal_anormal_old == 1) ? 'Normal' : (($value->nervios_craneanos_normal_anormal_old == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->nervios_craneanos_old ."</td>

                                        <td>". (($value->fuerza_muscular_normal_anormal_old == 1) ? 'Normal' : (($value->fuerza_muscular_normal_anormal_old == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->fuerza_muscular_old ."</td>

                                        <td>". (($value->tono_normal_anormal_old == 1) ? 'Normal' : (($value->tono_normal_anormal_old == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->tono_old ."</td>

                                        <td>". (($value->mov_anormales_normal_anormal_old == 1) ? 'Normal' : (($value->mov_anormales_normal_anormal_old == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->mov_anormales_old ."</td>

                                        <td>". (($value->reflejos_normal_anormal_old == 1) ? 'Normal' : (($value->reflejos_normal_anormal_old == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->reflejos_old ."</td>

                                        <td>". (($value->examen_sensitivo_normal_anormal_old == 1) ? 'Normal' : (($value->examen_sensitivo_normal_anormal_old == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->examen_sensitivo_old ."</td>

                                        <td>". (($value->marcha_normal_anormal_old == 1) ? 'Normal' : (($value->marcha_normal_anormal_old == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->marcha_old ."</td>

                                        <td>". (($value->postura_normal_anormal_old == 1) ? 'Normal' : (($value->postura_normal_anormal_old == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->postura_old ."</td>

                                        <td>". (($value->coordinacion_normal_anormal_old == 1) ? 'Normal' : (($value->coordinacion_normal_anormal_old == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->coordinacion_old ."</td>

                                        <td>". (($value->funcion_cerebelosa_normal_anormal_old == 1) ? 'Normal' : (($value->funcion_cerebelosa_normal_anormal_old == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->funcion_cerebelosa_old ."</td>

                                        <td>". $value->usuario_creacion_old ."</td>
                                        <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->created_at_old)) : '') ."</td>
                                    </tr>";

                        $salida .= "<tr>
                                        <td>". (($value->realizado_new) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        
                                        <td>". (($value->nervios_craneanos_normal_anormal_new == 1) ? 'Normal' : (($value->nervios_craneanos_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->nervios_craneanos_new ."</td>

                                        <td>". (($value->fuerza_muscular_normal_anormal_new == 1) ? 'Normal' : (($value->fuerza_muscular_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->fuerza_muscular_new ."</td>

                                        <td>". (($value->tono_normal_anormal_new == 1) ? 'Normal' : (($value->tono_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->tono_new ."</td>

                                        <td>". (($value->mov_anormales_normal_anormal_new == 1) ? 'Normal' : (($value->mov_anormales_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->mov_anormales_new ."</td>

                                        <td>". (($value->reflejos_normal_anormal_new == 1) ? 'Normal' : (($value->reflejos_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->reflejos_new ."</td>

                                        <td>". (($value->examen_sensitivo_normal_anormal_new == 1) ? 'Normal' : (($value->examen_sensitivo_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->examen_sensitivo_new ."</td>

                                        <td>". (($value->marcha_normal_anormal_new == 1) ? 'Normal' : (($value->marcha_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->marcha_new ."</td>

                                        <td>". (($value->postura_normal_anormal_new == 1) ? 'Normal' : (($value->postura_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->postura_new ."</td>

                                        <td>". (($value->coordinacion_normal_anormal_new == 1) ? 'Normal' : (($value->coordinacion_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->coordinacion_new ."</td>

                                        <td>". (($value->funcion_cerebelosa_normal_anormal_new == 1) ? 'Normal' : (($value->funcion_cerebelosa_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->funcion_cerebelosa_new ."</td>

                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') ."</td>
                                    </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        
                                        <td>". (($value->nervios_craneanos_normal_anormal_new == 1) ? 'Normal' : (($value->nervios_craneanos_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->nervios_craneanos_new ."</td>

                                        <td>". (($value->fuerza_muscular_normal_anormal_new == 1) ? 'Normal' : (($value->fuerza_muscular_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->fuerza_muscular_new ."</td>

                                        <td>". (($value->tono_normal_anormal_new == 1) ? 'Normal' : (($value->tono_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->tono_new ."</td>

                                        <td>". (($value->mov_anormales_normal_anormal_new == 1) ? 'Normal' : (($value->mov_anormales_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->mov_anormales_new ."</td>

                                        <td>". (($value->reflejos_normal_anormal_new == 1) ? 'Normal' : (($value->reflejos_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->reflejos_new ."</td>

                                        <td>". (($value->examen_sensitivo_normal_anormal_new == 1) ? 'Normal' : (($value->examen_sensitivo_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->examen_sensitivo_new ."</td>

                                        <td>". (($value->marcha_normal_anormal_new == 1) ? 'Normal' : (($value->marcha_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->marcha_new ."</td>

                                        <td>". (($value->postura_normal_anormal_new == 1) ? 'Normal' : (($value->postura_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->postura_new ."</td>

                                        <td>". (($value->coordinacion_normal_anormal_new == 1) ? 'Normal' : (($value->coordinacion_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->coordinacion_new ."</td>

                                        <td>". (($value->funcion_cerebelosa_normal_anormal_new == 1) ? 'Normal' : (($value->funcion_cerebelosa_normal_anormal_new == '0') ? 'Anormal' : '')) ."</td>
                                        <td>". $value->funcion_cerebelosa_new ."</td>

                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') ."</td>
                                    </tr>";
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
                        $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th rowspan='2'>Realizado</th>
                                            <th rowspan='2'>Fecha</th>
                                            <th rowspan='2'>PUNTAJE TOTAL</th>
                                            <th rowspan='2'>Se consulta a sujeto...¿Tiene algún problema con su memoria?</th>
                                            <th rowspan='2'>Se consulta a sujeto...¿Le puedo hacer algunas preguntas acerca de su memoria?</th>

                                            <th colspan='2'>¿En qué año estamos?</th>
                                            <th colspan='2'>¿En qué Estación del año estamos?</th>
                                            <th colspan='2'>¿En qué Mes estamos?</th>
                                            <th colspan='2'>¿En qué Día de la semana estamos?</th>
                                            <th colspan='2'>¿En qué Fecha estamos?</th>
                                            
                                            <th colspan='2'>¿En qué Región (provincia) estamos?</th>
                                            <th colspan='2'>¿En qué Comuna (o ciudad/pueblo) estamos?</th>
                                            <th colspan='2'>¿En qué Ciudad/pueblo (o parte de la ciudad/barrio) estamos?</th>
                                            <th colspan='2'>¿En qué Edificio (nombre o tipo) estamos?</th>
                                            <th colspan='2'>¿En que Piso del Edificio (número de habitación o dirección) estamos?</th>

                                            <th colspan='2'>ÁRBOL</th>
                                            <th colspan='2'>MESA</th>
                                            <th colspan='2'>AVIÓN</th>

                                            <th colspan='2'>¿Cuánto es 100 menos 7? [93]</th>
                                            <th colspan='2'>Si es necesario diga: Continúe. [86]</th>
                                            <th colspan='2'>Si es necesario diga: Continúe. [79]</th>
                                            <th colspan='2'>Si es necesario diga: Continúa. [72]</th>
                                            <th colspan='2'>Si es necesario diga: Continúa. [65]</th>

                                            <th>Puntaje total seccion a</th>

                                            <th colspan='2'>Pídale al paciente que deletree la palabra 'MUNDO' (usted puede ayudarlo) Luego dígale. 'Ahora deletréela de atrás para adelante' (espere máximo 30 segundos)</th>
                                            
                                            <th colspan='2'>ÁRBOL</th>
                                            <th colspan='2'>MESA</th>
                                            <th colspan='2'>AVIÓN</th>

                                            <th colspan='3'>¿Qué es esto?</th>
                                            <th colspan='3'>¿Qué es esto?</th>                                            

                                            <th colspan='2'>NO SI, O CUANDO, O PORQUÉ.</th>

                                            <th colspan='2'>TOMARLO CON LA MANO DERECHA</th>
                                            <th colspan='2'>DOBLAR POR LA MITAD</th>
                                            <th colspan='2'>PONER EN EL PISO</th>
                                            <th colspan='2'>CIERRE LOS OJOS</th>
                                            
                                            <th>ESCRITURA</th>
                                            <th>DIBUJO</th>

                                            <th rowspan='2'>Ingresado/Modificado Por</th>
                                            <th rowspan='2'>Fecha Modificacion</th>
                                        </tr>
                                        <tr>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>

                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>

                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>

                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>

                                            <th>Puntaje</th>

                                            <th>Respuesta</th>
                                            <th>Puntaje</th>

                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>

                                            <th>Objeto</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Objeto</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>

                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>
                                            <th>Respuesta</th>
                                            <th>Puntaje</th>

                                            <th>Puntaje</th>
                                            <th>Puntaje</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                        $salida .= "<tr>
                                        <td>". (($value->realizado_old == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>

                                        <td>". $value->puntaje_total_old ."</td>
                                        <td>". (($value->tiene_problemas_memoria_old == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->le_puedo_hacer_preguntas_old == 1) ? 'Si' : 'No') ."</td>                                        

                                        <td>". $value->en_que_ano_estamos_old ."</td>
                                        <td>". $value->en_que_ano_estamos_puntaje_old ."</td>
                                        <td>". $value->en_que_estacion_estamos_old ."</td>
                                        <td>". $value->en_que_estacion_estamos_puntaje_old ."</td>
                                        <td>". $value->en_que_mes_estamos_old ."</td>
                                        <td>". $value->en_que_mes_estamos_puntaje_old ."</td>
                                        <td>". $value->en_que_dia_estamos_old ."</td>
                                        <td>". $value->en_que_dia_estamos_puntaje_old ."</td>
                                        <td>". $value->en_que_fecha_estamos_old ."</td>
                                        <td>". $value->en_que_fecha_estamos_puntaje_old ."</td>

                                        <td>". $value->en_que_region_estamos_old ."</td>
                                        <td>". $value->en_que_region_estamos_puntaje_old ."</td>
                                        <td>". $value->comuna_estamos_old ."</td>
                                        <td>". $value->comuna_estamos_puntaje_old ."</td>
                                        <td>". $value->barrio_estamos_old ."</td>
                                        <td>". $value->barrio_estamos_puntaje_old ."</td>
                                        <td>". $value->edificio_estamos_old ."</td>
                                        <td>". $value->edificio_estamos_puntaje_old ."</td>
                                        <td>". $value->edificio_estamos2_old ."</td>
                                        <td>". $value->edificio_estamos2_puntaje_old ."</td>                                        

                                        <td>". $value->manzana_old ."</td>
                                        <td>". $value->manzana_puntaje_old ."</td>
                                        <td>". $value->peso_old ."</td>
                                        <td>". $value->peso_puntaje_old ."</td>
                                        <td>". $value->mesa_old ."</td>
                                        <td>". $value->mesa_puntaje_old ."</td>

                                        <td>". $value->cuanto_93_old ."</td>
                                        <td>". $value->cuanto_93_puntaje_old ."</td>
                                        <td>". $value->cuanto_86_old ."</td>
                                        <td>". $value->cuanto_86_puntaje_old ."</td>
                                        <td>". $value->cuanto_79_old ."</td>
                                        <td>". $value->cuanto_79_puntaje_old ."</td>
                                        <td>". $value->cuanto_72_old ."</td>
                                        <td>". $value->cuanto_72_puntaje_old ."</td>
                                        <td>". $value->cuanto_65_old ."</td>
                                        <td>". $value->cuanto_65_puntaje_old ."</td>

                                        <td>". $value->puntaje_seccion_a_old ."</td>

                                        <td>". $value->mundo_respuesta_old ."</td>
                                        <td>". $value->mundo_puntaje_old ."</td>

                                        <td>". $value->manzana_2_old ."</td>
                                        <td>". $value->manzana_2_puntaje_old ."</td>
                                        <td>". $value->peso_2_old ."</td>
                                        <td>". $value->peso_2_puntaje_old ."</td>
                                        <td>". $value->mesa_2_old ."</td>
                                        <td>". $value->mesa_2_puntaje_old ."</td>

                                        <td>". $value->mostrado_que_es_1_old ."</td>
                                        <td>". $value->que_es_1_old ."</td>
                                        <td>". $value->que_es_1_puntaje_old ."</td>
                                        <td>". $value->mostrado_que_es_2_old ."</td>
                                        <td>". $value->que_es_2_old ."</td>
                                        <td>". $value->que_es_2_puntaje_old ."</td>

                                        <td>". $value->no_si_cuando_porque_old ."</td>
                                        <td>". $value->no_si_cuando_porque_puntaje_old ."</td>

                                        <td>". $value->tomar_con_la_mano_derecha_old ."</td>
                                        <td>". $value->tomar_con_la_mano_derecha_puntaje_old ."</td>
                                        <td>". $value->doblar_por_la_mitad_old ."</td>
                                        <td>". $value->doblar_por_la_mitad_puntaje_old ."</td>
                                        <td>". $value->poner_en_el_piso_old ."</td>
                                        <td>". $value->poner_en_el_piso_puntaje_old ."</td>
                                        <td>". $value->cierre_los_ojos_old ."</td>
                                        <td>". $value->cierre_los_ojos_puntaje_old ."</td>
                                        

                                        <td>". $value->escritura_puntaje_old ."</td>
                                        <td>". $value->dibujo_puntaje_old ."</td>

                                        <td>". $value->usuario_creacion_old ."</td>
                                        <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->created_at_old)) : '') ."</td>
                                    </tr>";

                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>

                                        <td>". $value->puntaje_total_new ."</td>
                                        <td>". (($value->tiene_problemas_memoria_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->le_puedo_hacer_preguntas_new == 1) ? 'Si' : 'No') ."</td>                                        

                                        <td>". $value->en_que_ano_estamos_new ."</td>
                                        <td>". $value->en_que_ano_estamos_puntaje_new ."</td>
                                        <td>". $value->en_que_estacion_estamos_new ."</td>
                                        <td>". $value->en_que_estacion_estamos_puntaje_new ."</td>
                                        <td>". $value->en_que_mes_estamos_new ."</td>
                                        <td>". $value->en_que_mes_estamos_puntaje_new ."</td>
                                        <td>". $value->en_que_dia_estamos_new ."</td>
                                        <td>". $value->en_que_dia_estamos_puntaje_new ."</td>
                                        <td>". $value->en_que_fecha_estamos_new ."</td>
                                        <td>". $value->en_que_fecha_estamos_puntaje_new ."</td>

                                        <td>". $value->en_que_region_estamos_new ."</td>
                                        <td>". $value->en_que_region_estamos_puntaje_new ."</td>
                                        <td>". $value->comuna_estamos_new ."</td>
                                        <td>". $value->comuna_estamos_puntaje_new ."</td>
                                        <td>". $value->barrio_estamos_new ."</td>
                                        <td>". $value->barrio_estamos_puntaje_new ."</td>
                                        <td>". $value->edificio_estamos_new ."</td>
                                        <td>". $value->edificio_estamos_puntaje_new ."</td>
                                        <td>". $value->edificio_estamos2_new ."</td>
                                        <td>". $value->edificio_estamos2_puntaje_new ."</td>                                        

                                        <td>". $value->manzana_new ."</td>
                                        <td>". $value->manzana_puntaje_new ."</td>
                                        <td>". $value->peso_new ."</td>
                                        <td>". $value->peso_puntaje_new ."</td>
                                        <td>". $value->mesa_new ."</td>
                                        <td>". $value->mesa_puntaje_new ."</td>

                                        <td>". $value->cuanto_93_new ."</td>
                                        <td>". $value->cuanto_93_puntaje_new ."</td>
                                        <td>". $value->cuanto_86_new ."</td>
                                        <td>". $value->cuanto_86_puntaje_new ."</td>
                                        <td>". $value->cuanto_79_new ."</td>
                                        <td>". $value->cuanto_79_puntaje_new ."</td>
                                        <td>". $value->cuanto_72_new ."</td>
                                        <td>". $value->cuanto_72_puntaje_new ."</td>
                                        <td>". $value->cuanto_65_new ."</td>
                                        <td>". $value->cuanto_65_puntaje_new ."</td>

                                        <td>". $value->puntaje_seccion_a_new ."</td>

                                        <td>". $value->mundo_respuesta_new ."</td>
                                        <td>". $value->mundo_puntaje_new ."</td>

                                        <td>". $value->manzana_2_new ."</td>
                                        <td>". $value->manzana_2_puntaje_new ."</td>
                                        <td>". $value->peso_2_new ."</td>
                                        <td>". $value->peso_2_puntaje_new ."</td>
                                        <td>". $value->mesa_2_new ."</td>
                                        <td>". $value->mesa_2_puntaje_new ."</td>

                                        <td>". $value->mostrado_que_es_1_new ."</td>
                                        <td>". $value->que_es_1_new ."</td>
                                        <td>". $value->que_es_1_puntaje_new ."</td>
                                        <td>". $value->mostrado_que_es_2_new ."</td>
                                        <td>". $value->que_es_2_new ."</td>
                                        <td>". $value->que_es_2_puntaje_new ."</td>

                                        <td>". $value->no_si_cuando_porque_new ."</td>
                                        <td>". $value->no_si_cuando_porque_puntaje_new ."</td>

                                        <td>". $value->tomar_con_la_mano_derecha_new ."</td>
                                        <td>". $value->tomar_con_la_mano_derecha_puntaje_new ."</td>
                                        <td>". $value->doblar_por_la_mitad_new ."</td>
                                        <td>". $value->doblar_por_la_mitad_puntaje_new ."</td>
                                        <td>". $value->poner_en_el_piso_new ."</td>
                                        <td>". $value->poner_en_el_piso_puntaje_new ."</td>
                                        <td>". $value->cierre_los_ojos_new ."</td>
                                        <td>". $value->cierre_los_ojos_puntaje_new ."</td>
                                        

                                        <td>". $value->escritura_puntaje_new ."</td>
                                        <td>". $value->dibujo_puntaje_new ."</td>

                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') ."</td>
                                    </tr>";

                    }
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>

                                        <td>". $value->puntaje_total_new ."</td>
                                        <td>". (($value->tiene_problemas_memoria_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->le_puedo_hacer_preguntas_new == 1) ? 'Si' : 'No') ."</td>                                        

                                        <td>". $value->en_que_ano_estamos_new ."</td>
                                        <td>". $value->en_que_ano_estamos_puntaje_new ."</td>
                                        <td>". $value->en_que_estacion_estamos_new ."</td>
                                        <td>". $value->en_que_estacion_estamos_puntaje_new ."</td>
                                        <td>". $value->en_que_mes_estamos_new ."</td>
                                        <td>". $value->en_que_mes_estamos_puntaje_new ."</td>
                                        <td>". $value->en_que_dia_estamos_new ."</td>
                                        <td>". $value->en_que_dia_estamos_puntaje_new ."</td>
                                        <td>". $value->en_que_fecha_estamos_new ."</td>
                                        <td>". $value->en_que_fecha_estamos_puntaje_new ."</td>

                                        <td>". $value->en_que_region_estamos_new ."</td>
                                        <td>". $value->en_que_region_estamos_puntaje_new ."</td>
                                        <td>". $value->comuna_estamos_new ."</td>
                                        <td>". $value->comuna_estamos_puntaje_new ."</td>
                                        <td>". $value->barrio_estamos_new ."</td>
                                        <td>". $value->barrio_estamos_puntaje_new ."</td>
                                        <td>". $value->edificio_estamos_new ."</td>
                                        <td>". $value->edificio_estamos_puntaje_new ."</td>
                                        <td>". $value->edificio_estamos2_new ."</td>
                                        <td>". $value->edificio_estamos2_puntaje_new ."</td>                                        

                                        <td>". $value->manzana_new ."</td>
                                        <td>". $value->manzana_puntaje_new ."</td>
                                        <td>". $value->peso_new ."</td>
                                        <td>". $value->peso_puntaje_new ."</td>
                                        <td>". $value->mesa_new ."</td>
                                        <td>". $value->mesa_puntaje_new ."</td>

                                        <td>". $value->cuanto_93_new ."</td>
                                        <td>". $value->cuanto_93_puntaje_new ."</td>
                                        <td>". $value->cuanto_86_new ."</td>
                                        <td>". $value->cuanto_86_puntaje_new ."</td>
                                        <td>". $value->cuanto_79_new ."</td>
                                        <td>". $value->cuanto_79_puntaje_new ."</td>
                                        <td>". $value->cuanto_72_new ."</td>
                                        <td>". $value->cuanto_72_puntaje_new ."</td>
                                        <td>". $value->cuanto_65_new ."</td>
                                        <td>". $value->cuanto_65_puntaje_new ."</td>

                                        <td>". $value->puntaje_seccion_a_new ."</td>

                                        <td>". $value->mundo_respuesta_new ."</td>
                                        <td>". $value->mundo_puntaje_new ."</td>

                                        <td>". $value->manzana_2_new ."</td>
                                        <td>". $value->manzana_2_puntaje_new ."</td>
                                        <td>". $value->peso_2_new ."</td>
                                        <td>". $value->peso_2_puntaje_new ."</td>
                                        <td>". $value->mesa_2_new ."</td>
                                        <td>". $value->mesa_2_puntaje_new ."</td>

                                        <td>". $value->mostrado_que_es_1_new ."</td>
                                        <td>". $value->que_es_1_new ."</td>
                                        <td>". $value->que_es_1_puntaje_new ."</td>
                                        <td>". $value->mostrado_que_es_2_new ."</td>
                                        <td>". $value->que_es_2_new ."</td>
                                        <td>". $value->que_es_2_puntaje_new ."</td>

                                        <td>". $value->no_si_cuando_porque_new ."</td>
                                        <td>". $value->no_si_cuando_porque_puntaje_new ."</td>

                                        <td>". $value->tomar_con_la_mano_derecha_new ."</td>
                                        <td>". $value->tomar_con_la_mano_derecha_puntaje_new ."</td>
                                        <td>". $value->doblar_por_la_mitad_new ."</td>
                                        <td>". $value->doblar_por_la_mitad_puntaje_new ."</td>
                                        <td>". $value->poner_en_el_piso_new ."</td>
                                        <td>". $value->poner_en_el_piso_puntaje_new ."</td>
                                        <td>". $value->cierre_los_ojos_new ."</td>
                                        <td>". $value->cierre_los_ojos_puntaje_new ."</td>
                                        

                                        <td>". $value->escritura_puntaje_new ."</td>
                                        <td>". $value->dibujo_puntaje_new ."</td>

                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($value->updated_at_new)) : '') ."</td>
                                    </tr>";
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
                                            <th>Numero de Errores</th>
                                            <th>Ingresado/Modificado Por</th>
                                            <th>Fecha Modificacion</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_old == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>
                                        <td>". $value->segundos_old ."</td>
                                        <td>". $value->num_errores_old ."</td>
                                        <td>". $value->usuario_creacion_old ."</td>
                                        <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->created_at_old)): '')."</td>
                                    </tr>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->segundos_new ."</td>
                                        <td>". $value->num_errores_new ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)): '')."</td>
                                    </tr>";
                    }
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->segundos_new ."</td>
                                        <td>". $value->num_errores_new ."</td>
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
                                            <th>Numero de Errores</th>
                                            <th>Ingresado/Modificado Por</th>
                                            <th>Fecha Modificacion</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_old == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>
                                        <td>". $value->segundos_old ."</td>
                                        <td>". $value->num_errores_old ."</td>
                                        <td>". $value->usuario_creacion_old ."</td>
                                        <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->created_at_old)): '')."</td>
                                    </tr>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->segundos_new ."</td>
                                        <td>". $value->num_errores_new ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)): '')."</td>
                                    </tr>";
                    }                    
                    else{
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>
                                        <td>". $value->segundos_new ."</td>
                                        <td>". $value->num_errores_new ."</td>
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)): '')."</td>
                                    </tr>";
                    }

                    $contador++;
                }
                elseif($tabla == 'escala_de_columbia_audit'){
                    $salida .= "<table class='table table-bordered table-striped table-hover table-condensed'>
                                    <thead>
                                        <tr>
                                            <th>Realizado</th>
                                            <th>Fecha</th>                                            
                                            <th>Ingresado/Modificado Por</th>
                                            <th>Fecha Modificacion</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_old == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_old != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_old)) : '') ."</td>                                        
                                        <td>". $value->usuario_creacion_old ."</td>
                                        <td>". (($value->created_at_old != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->created_at_old)): '')."</td>
                                    </tr>";
                        $salida .= "<tr>
                                        <td>". (($value->realizado_new == 1) ? 'Si' : 'No') ."</td>
                                        <td>". (($value->fecha_new != '0000-00-00') ? date('d/m/Y', strtotime($value->fecha_new)) : '') ."</td>                                        
                                        <td>". $value->usuario_actualizacion_new ."</td>
                                        <td>". (($value->updated_at_new != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($value->updated_at_new)): '')."</td>
                                    </tr>";
                }
                //adicionales
                elseif($tabla == 'signos_vitales_adicional_audit'){

                }
                elseif($tabla == 'ecg_adicional_audit'){

                }
                elseif($tabla == 'examen_fisico_adicional_audit'){

                }
                elseif($tabla == 'examen_neurologico_adicional_audit'){

                }
                elseif($tabla == 'examen_laboratorio_adicional_audit'){

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