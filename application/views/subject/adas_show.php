<script src="<?= base_url('js/adas.js') ?>"></script>
<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>


		<legend style='text-align:center;'>ADAS COG</legend>
		<b>Sujeto Actual:</b>
		<table class="table table-condensed table-bordered">
			<thead>
				<tr style='background-color: #C0C0C0;'>
					<th>Centro</th>
					<th>ID del Sujeto</th>
					<th>Iniciales</th>
					<th>Fecha de Ingreso</th>
					<th>Fecha de Randomizacion</th>
					<th>Kit Asignado</th>					
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= $subject->center_name; ?></td>
					<td><?= anchor('subject/grid/'.$subject->id, $subject->code); ?></td>
					<td><?= $subject->initials; ?></td>		
					<td><?= ((isset($subject->screening_date) AND $subject->screening_date != '0000-00-00') ? date("d-M-Y",strtotime($subject->screening_date)) : ""); ?></td>
					<td><?= ((isset($subject->randomization_date) AND $subject->randomization_date != '0000-00-00') ? date("d-M-Y",strtotime($subject->randomization_date)) : ""); ?></td>
					<td><?= $subject->kit1; ?></td>					
				</tr>
			</tbody>
		</table>
		<br />

	<?= form_open('subject/adas_update', array('class'=>'form-horizontal', 'id'=>'form_adas')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>

	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>	
	<?= form_hidden('id', $list[0]->id); ?>	


	<?php
		$data = array(
			    'name'        => 'realizado',			    
			    'value'       => 1,		    
			    #'checked'	  => set_radio('gender', 'male', TRUE),
		    );
	  	$data2 = array(
		    'name'        => 'realizado',			    
		    'value'       => 0,
		    #'checked'	  => set_radio('gender', 'female', TRUE),		    
		    );	   
	?>

	<table class='table table-striped table-hover table-bordered table-condensed'>			
		<tbody>
			<tr>		
				<td>Realizado: </td>
				<td>
					<?= form_radio($data,$data['value'],set_radio($data['name'], 1, (($list[0]->realizado == 1) ? true : false))); ?> Si
					<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0, (($list[0]->realizado == 0) ? true : false))); ?> NO
				</td>
			</tr>
			<tr>
				<td>Fecha: </td>
				<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', $list[0]->fecha))); ?></td>
			</tr>
			<tr>
				<td>Puntaje Total ADAS-Cog: </td>
				<td><?= form_input(array('type'=>'text','name'=>'puntaje_total', 'id'=>'puntaje_total', 'value'=>set_value('puntaje_total', $list[0]->puntaje_total), 'readonly'=>'readonly')); ?></td>
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>1.- Tarea de recordar palabras</td>
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;'>Ensayo 1</td>
			</tr>
			<tr>
				<td>Palabras recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_recordadas_1', 'id'=>'palabras_recordadas_1', 'value'=>set_value('palabras_recordadas_1', $list[0]->palabras_recordadas_1))); ?></td>
			</tr>
			<tr>
				<td>Palabras no recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_no_recordadas_1', 'id'=>'palabras_no_recordadas_1', 'value'=>set_value('palabras_no_recordadas_1', $list[0]->palabras_no_recordadas_1))); ?></td>
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;'>Ensayo 2</td>
			</tr>
			<tr>
				<td>Palabras recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_recordadas_2', 'id'=>'palabras_recordadas_2', 'value'=>set_value('palabras_recordadas_2', $list[0]->palabras_recordadas_2))); ?></td>
			</tr>
			<tr>
				<td>Palabras no recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_no_recordadas_2', 'id'=>'palabras_no_recordadas_2', 'value'=>set_value('palabras_no_recordadas_2', $list[0]->palabras_no_recordadas_2))); ?></td>
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;'>Ensayo 3</td>
			</tr>
			<tr>
				<td>Palabras recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_recordadas_3', 'id'=>'palabras_recordadas_3', 'value'=>set_value('palabras_recordadas_3', $list[0]->palabras_recordadas_3))); ?></td>
			</tr>
			<tr>
				<td>Palabras no recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_no_recordadas_3', 'id'=>'palabras_no_recordadas_3', 'value'=>set_value('palabras_no_recordadas_3', $list[0]->palabras_no_recordadas_3))); ?></td>
			</tr>
			<tr>
				<td>Hora de finalizacion: </td>
				<td>
					<?= form_dropdown('hora_finalizacion_hora', $horas ,set_value('hora_finalizacion_hora', $list[0]->hora_finalizacion_hora)); ?>
					:
					<?= form_dropdown('hora_finalizacion_minuto', $minutos, set_value('hora_finalizacion_minuto', $list[0]->hora_finalizacion_minuto)); ?>
				</td>
			</tr>
			<tr>
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_1', $no_administro, set_value('no_administro_1', $list[0]->no_administro_1)); ?></td>
			</tr>
			<tr>
				<td>Puntuaci&oacute;n Total: </td>
				<td><?= form_input(array('type'=>'text', 'name'=>'puntaje_total_1', 'id'=>'puntaje_total_1', 'readonly'=>'readonly', 'value'=>set_value('puntaje_total_1',$list[0]->puntaje_total_1))); ?></td>
			</tr>

			
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>2.- Órdenes</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_2', $de0_a5,  set_value('total_correctas_2', $list[0]->total_correctas_2),array('id'=>'total_correctas_2')); ?></td>				
			</tr>
			<tr>
				<td>Total incorrectas</td>
				<td><?= form_dropdown('total_incorrectas_2', $de0_a5,  set_value('total_incorrectas_2', $list[0]->total_incorrectas_2),array('id'=>'total_incorrectas_2')); ?></td>								
			</tr>
			<tr>
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_2', $no_administro, set_value('no_administro_2', $list[0]->no_administro_2)); ?></td>
			</tr>
			<tr>
				<td>Puntuaci&oacute;n Total</td>
				<td><?= form_dropdown('puntuacion_2', $puntaje, set_value('puntuacion_2', $list[0]->puntuacion_2), array('id'=>'puntuacion_2')); ?></td>
			</tr>							
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>3.- Praxis Constructiva</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_3', $de0_a4,  set_value('total_correctas_3', $list[0]->total_correctas_3),array('id'=>'total_correctas_3')); ?></td>												
			</tr>
			<tr>
				<td>Total incorrectas</td>
				<td><?= form_dropdown('total_incorrectas_3', $de0_a4,  set_value('total_incorrectas_3', $list[0]->total_incorrectas_3),array('id'=>'total_incorrectas_3')); ?></td>				
			</tr>			
			<tr>
				<td>Paciente no intentó dibujar ninguna forma: </td>
				<td><?= form_checkbox('paciente_no_dibujo_3','1', (($list[0]->paciente_no_dibujo_3 == 1) ? true : false)); ?></td>
			</tr>
			<tr>
				<td>Puntuaci&oacute;n Total</td>
				<td><?= form_dropdown('puntuacion_3', $puntaje, set_value('puntuacion_3', $list[0]->puntuacion_3), array('id'=>'puntuacion_3')); ?></td>
			</tr>				
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>4.- Tarea de recordar palabras diferidas </td>
			</tr>
			<tr>
				<td>Total recordadas</td>				
				<td><?= form_dropdown('total_recordadas_4', $de0_a10,  set_value('total_recordadas_4', $list[0]->total_recordadas_4),array('id'=>'total_recordadas_4')); ?></td>				
			</tr>
			<tr>
				<td>Total no recordadas</td>				
				<td><?= form_dropdown('total_no_recordadas_4', $de0_a10,  set_value('total_no_recordadas_4', $list[0]->total_no_recordadas_4),array('id'=>'total_no_recordadas_4')); ?></td>				
			</tr>
			<tr>
				<td>Hora de inicio: </td>
				<td>
					<?= form_dropdown('hora_finalizacion_4_hora', $horas ,set_value('hora_finalizacion_4_hora', $list[0]->hora_finalizacion_4_hora)); ?>
					:
					<?= form_dropdown('hora_finalizacion_4_minuto', $minutos, set_value('hora_finalizacion_4_minuto', $list[0]->hora_finalizacion_4_minuto)); ?>
				</td>
			</tr>
			<tr>
				<td>Puntuaci&oacute;n Total</td>
				<td><?= form_dropdown('puntuacion_4', $puntaje, set_value('puntuacion_4', $list[0]->puntuacion_4), array('id'=>'puntuacion_4')); ?></td>
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>5.- Tarea de nombrar</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_5', $de0_a17,  set_value('total_correctas_5', $list[0]->total_correctas_5),array('id'=>'total_correctas_5')); ?></td>					
			</tr>
			<tr>
				<td>Total incorrectas</td>
				<td><?= form_dropdown('total_incorrectas_5', $de0_a17,  set_value('total_incorrectas_5', $list[0]->total_incorrectas_5),array('id'=>'total_incorrectas_5')); ?></td>				
			</tr>
			<tr>
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_5', $no_administro, set_value('no_administro_5', $list[0]->no_administro_5)); ?></td>
			</tr>			
			<tr>
				<td>Puntuaci&oacute;n Total</td>
				<td><?= form_dropdown('puntuacion_5', $puntaje, set_value('puntuacion_5', $list[0]->puntuacion_5), array('id'=>'puntuacion_5')); ?></td>
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>6.- Praxis Ideacional</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_6', $de0_a5,  set_value('total_correctas_6', $list[0]->total_correctas_6),array('id'=>'total_correctas_6')); ?></td>												
			</tr>
			<tr>
				<td>Total incorrectas</td>
				<td><?= form_dropdown('total_incorrectas_6', $de0_a5,  set_value('total_incorrectas_6', $list[0]->total_incorrectas_6),array('id'=>'total_incorrectas_6')); ?></td>												
			</tr>			
			<tr>
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_6', $no_administro, set_value('no_administro_6', $list[0]->no_administro_6)); ?></td>
			</tr>
			<tr>
				<td>Puntuaci&oacute;n Total</td>
				<td><?= form_dropdown('puntuacion_6', $puntaje, set_value('puntuacion_6', $list[0]->puntuacion_6), array('id'=>'puntuacion_6')); ?></td>
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>7.- Orientación</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_7', $de0_a8,  set_value('total_correctas_7', $list[0]->total_correctas_7),array('id'=>'total_correctas_7')); ?></td>
			</tr>
			<tr>
				<td>Total incorrectas</td>
				<td><?= form_dropdown('total_incorrectas_7', $de0_a8,  set_value('total_incorrectas_7', $list[0]->total_incorrectas_7),array('id'=>'total_incorrectas_7')); ?></td>																
			</tr>			
			<tr>
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_7', $no_administro, set_value('no_administro_7', $list[0]->no_administro_7)); ?></td>
			</tr>
			<tr>
				<td>Puntuaci&oacute;n Total</td>
				<td><?= form_dropdown('puntuacion_7', $puntaje, set_value('puntuacion_7', $list[0]->puntuacion_7), array('id'=>'puntuacion_7')); ?></td>
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>8.- Tarea de reconocer palabras</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_8', $de0_a24,  set_value('total_correctas_8', $list[0]->total_correctas_8),array('id'=>'total_correctas_8')); ?></td>				
			</tr>
			<tr>
				<td>Total incorrectas</td>
				<td><?= form_dropdown('total_incorrectas_8', $de0_a24,  set_value('total_incorrectas_8', $list[0]->total_incorrectas_8),array('id'=>'total_incorrectas_8')); ?></td>				
			</tr>
			<tr>
				<td>Cantidad de recordatorios</td>
				<td><?= form_dropdown('cantidad_recordadas_8', $de0_a22,  set_value('cantidad_recordadas_8', $list[0]->cantidad_recordadas_8),array('id'=>'cantidad_recordadas_8')); ?></td>				
			</tr>			
			<tr>
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_8', $no_administro, set_value('no_administro_8', $list[0]->no_administro_8)); ?></td>
			</tr>
			<tr>
				<td>Puntuaci&oacute;n Total</td>
				<td><?= form_input(array('type'=>'text', 'name'=>'puntuacion_8', 'id'=>'puntuacion_8', 'value'=>set_value('puntuacion_8', $list[0]->puntuacion_8), 'readonly'=>'readonly')); ?></td>
			</tr>			
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>9.- Recordando las instrucciones de la prueba</td>
			</tr>
			<tr>
				<td>Puntuación</td>
				<td><?= form_dropdown('puntuacion_9', $puntaje, set_value('puntuacion_9', $list[0]->puntuacion_9), array('id'=>'puntuacion_9')); ?></td>
			</tr>

			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>10.- Comprensión</td>
			</tr>
			<tr>
				<td>Puntuación</td>
				<td><?= form_dropdown('puntuacion_10', $puntaje, set_value('puntuacion_10', $list[0]->puntuacion_10), array('id'=>'puntuacion_10')); ?></td>
			</tr>

			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>11.- Dificultad en la selección de palabras</td>
			</tr>
			<tr>
				<td>Puntuación</td>
				<td><?= form_dropdown('puntuacion_11', $puntaje, set_value('puntuacion_11', $list[0]->puntuacion_11), array('id'=>'puntuacion_11')); ?></td>
			</tr>

			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>12.- Habilidad para el lenguaje hablado</td>
			</tr>
			<tr>
				<td>Puntuación</td>
				<td><?= form_dropdown('puntuacion_12', $puntaje, set_value('puntuacion_12', $list[0]->puntuacion_12), array('id'=>'puntuacion_12')); ?></td>
			</tr>

			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>13.	Eliminar números</td>
			</tr>
				<tr>
				<td>Número de objetivos tachadas</td>
				<td><?= form_input(array('type'=>'number', 'name'=>'objetivos_13', 'id'=>'objetivos_13', 'value'=>set_value('objetivos_13', $list[0]->objetivos_13))); ?></td>
			</tr>
			<tr>
				<td>Número de errores</td>
				<td><?= form_input(array('type'=>'number', 'name'=>'errores_13', 'id'=>'errores_13', 'value'=>set_value('errores_13', $list[0]->errores_13))); ?></td>
			</tr>
			<tr>
				<td>Número de veces que se recordó la tarea</td>
				<td><?= form_input(array('type'=>'number', 'name'=>'recordo_13', 'id'=>'recordo_13', 'value'=>set_value('recordo_13', $list[0]->recordo_13))); ?></td>
			</tr>
			<tr>
				<td colspan='2' style='text-align:center;'>
					<input type='submit' class='btn btn-primary' value='Guardar' id='guardar'>
					<?= anchor('subject/grid/'. $subject->id, 'Volver', array('class'=>'btn')); ?>
				</td>				
			</tr>			
		</tbody>
	</table>

	<?= form_close(); ?>
	<!-- Querys -->
<?php
	if(isset($querys) AND !empty($querys)){ ?>
		<b>Querys:</b>
		<table class="table table-condensed table-bordered table-stripped">
			<thead>
				<tr>
					<th>Fecha de Consulta</th>
					<th>Usuario</th>
					<th>Consulta</th>
					<th>Fecha de Respuesta</th>
					<th>Usuario</th>
					<th>Respuesta</th>				
				</tr>
			</thead>
			<tbody>
				
			<?php
				foreach ($querys as $query) { ?>
					<tr>
						<td><?= date("d-M-Y H:i:s", strtotime($query->created)); ?></td>
						<td><?= $query->question_user; ?></td>
						<td><?= $query->question; ?></td>						
						<td><?= (($query->answer_date != "0000-00-00 00:00:00") ? date("d-M-Y H:i:s", strtotime($query->answer_date)) : ""); ?></td>
						<td><?= $query->answer_user; ?></td>
						<?php
							if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'additional_form_query_show')){
						?>
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id .'/Adas Cog', 'Responder',array('class'=>'btn'))); ?></td>						
						<?php }else{?>
							<td><?= $query->answer; ?></td>
						<?php }?>
					</tr>					
			<?php }?>	

			</tbody>
		</table>

<?php } ?>
<!-- Verify -->
<b>Aprobacion del Monitor:</b><br />
	<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
		
		Formulario aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y",strtotime($list[0]->verify_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'adas_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/adas_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('id', $list[0]->id); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Verificar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Aprobacion";
		}
	}
?>
<br />

<!--Signature/Lock-->
<br /><b>Cierre:</b><br />
	<?php if(!empty($list[0]->lock_user) AND !empty($list[0]->lock_date)){ ?>
		
		Formulario cerrado por <?= $list[0]->lock_user;?> el <?= date("d-M-Y",strtotime($list[0]->lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'adas_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/adas_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('id', $list[0]->id); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Cerrar Formulario', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Cierre";
		}
	}
?>
<br />
<!--Signature-->
	<br /><b>Firma:</b><br />
	<?php if(!empty($list[0]->signature_user) AND !empty($list[0]->signature_date)){ ?>
		
		Formulario Firmado por <?= $list[0]->signature_user;?> on <?= date("d-M-Y",strtotime($list[0]->signature_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'adas_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/adas_signature', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
		<?= form_hidden('id', $list[0]->id); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Firma";
		}
	}
?>
<br />