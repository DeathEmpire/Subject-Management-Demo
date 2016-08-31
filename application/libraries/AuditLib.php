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
                                            <th rowspan='2'>Realizado</th>
                                            <th rowspan='2'>Fecha</th>

                                        </tr>
                                    </thead>
                                    <tbody>";
                    }
                    else{

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
                    }
                    else{

                    }

                    $contador++;
                }
                elseif($tabla == 'examen_laboratorio_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
                    }
                    else{

                    }

                    $contador++;
                }
                elseif($tabla == 'examen_neurologico_audit'){

                    if($contador == 0){
                        //encabezado, registro original, primera modificacion
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
                                            <th rowspan='2'>Realizado</th>
                                            <th rowspan='2'>Fecha</th>

                                        </tr>
                                    </thead>
                                    <tbody>";
                    }
                    else{

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
                                            <th>Realizado</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                    }
                    else{

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