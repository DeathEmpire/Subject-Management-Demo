<script src="<?= base_url('js/npi.js') ?>"></script>
<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>

<legend style='text-align:center;'>NPI</legend>
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
<!-- legend -->
<?= form_open('subject/npi_insert', array('class'=>'form-horizontal', 'id'=>'form_npi')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('etapa', $etapa); ?>	
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

	  	$status = array(''=>'','1'=>'Si','0'=>'No');
	?>
	<table class="table table-bordered table-striper table-hover">
		<tr>		
			<td>Realizado: </td>
			<td>
				<?= form_radio($data,$data['value'],set_radio($data['name'], 1, true)); ?> Si
				<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
			</td>
		</tr>
		<tr>
			<td>Fecha: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?></td>
		</tr>

		<tr>
			<td>Puntaje Total de NPI: </td>
			<td><?= form_input(array('type'=>'number','name'=>'puntaje_total_npi', 'id'=>'puntaje_total_npi', 'value'=>set_value('puntaje_total_npi'), 'readonly'=>'readonly')); ?></td>
		</tr>

		<tr>
			<td>Puntaje total para Angustia de el (la) Cuidador(a): </td>
			<td><?= form_input(array('type'=>'number','name'=>'puntaje_total_para_angustia', 'id'=>'puntaje_total_para_angustia', 'value'=>set_value('puntaje_total_para_angustia'), 'readonly'=>'readonly')); ?></td>
		</tr>
	</table>
	<br>
	
	Para cada categoría se responde Sí, por favor complete Frecuencia, Severidad y Angustia:<br />	
	<table class="table table-bordered table-striper table-hover">
		<thead>
			<tr>
				<td></td>
				<td>Categoría</td>
				<td>Status (Sí / No)</td>
				<td>Frecuencia</td>
				<td>Severidad</td>
				<td>Puntaje (Frecuencia * Severidad)</td>
				<td>Angustia</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>Delirios</td>
				<td><?= form_dropdown('delirio_status', $status, set_value('delirio_status')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'delirio_frecuencia', 'value'=>set_value('delirio_frecuencia'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'delirio_severidad', 'value'=>set_value('delirio_severidad'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'delirio_puntaje', 'value'=>set_value('delirio_puntaje'), 'readonly'=>'readonly')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'delirio_angustia', 'value'=>set_value('delirio_angustia'))); ?></td>				
			</tr>
			<tr>
				<td>2</td>
				<td>Alucinaciones</td>
				<td><?= form_dropdown('alucinaciones_status', $status, set_value('alucinaciones_status')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'alucinaciones_frecuencia', 'value'=>set_value('alucinaciones_frecuencia'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'alucinaciones_severidad', 'value'=>set_value('alucinaciones_severidad'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'alucinaciones_puntaje', 'value'=>set_value('alucinaciones_puntaje'), 'readonly'=>'readonly')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'alucinaciones_angustia', 'value'=>set_value('alucinaciones_angustia'))); ?></td>				
			</tr>
			<tr>
				<td>3</td>
				<td>Agitación / Agresividad</td>
				<td><?= form_dropdown('agitacion_status', $status, set_value('agitacion_status')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'agitacion_frecuencia', 'value'=>set_value('agitacion_frecuencia'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'agitacion_severidad', 'value'=>set_value('agitacion_severidad'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'agitacion_puntaje', 'value'=>set_value('agitacion_puntaje'), 'readonly'=>'readonly')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'agitacion_angustia', 'value'=>set_value('agitacion_angustia'))); ?></td>				
			</tr>
			<tr>
				<td>4</td>
				<td>Depresión</td>				
				<td><?= form_dropdown('depresion_status', $status, set_value('depresion_status')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'depresion_frecuencia', 'value'=>set_value('depresion_frecuencia'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'depresion_severidad', 'value'=>set_value('depresion_severidad'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'depresion_puntaje', 'value'=>set_value('depresion_puntaje'), 'readonly'=>'readonly')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'depresion_angustia', 'value'=>set_value('depresion_angustia'))); ?></td>				
			</tr>
			<tr>
				<td>5</td>
				<td>Ansiedad</td>
				<td><?= form_dropdown('ansiedad_status', $status, set_value('ansiedad_status')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'ansiedad_frecuencia', 'value'=>set_value('ansiedad_frecuencia'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'ansiedad_severidad', 'value'=>set_value('ansiedad_severidad'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'ansiedad_puntaje', 'value'=>set_value('ansiedad_puntaje'), 'readonly'=>'readonly')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'ansiedad_angustia', 'value'=>set_value('ansiedad_angustia'))); ?></td>				
			</tr>
			<tr>
				<td>6</td>
				<td>Elación / Euforia</td>
				<td><?= form_dropdown('elacion_status', $status, set_value('elacion_status')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'elacion_frecuencia', 'value'=>set_value('elacion_frecuencia'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'elacion_severidad', 'value'=>set_value('elacion_severidad'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'elacion_puntaje', 'value'=>set_value('elacion_puntaje'), 'readonly'=>'readonly')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'elacion_angustia', 'value'=>set_value('elacion_angustia'))); ?></td>				
			</tr>
			<tr>
				<td>7</td>
				<td>Apatía / Indiferencia</td>
				<td><?= form_dropdown('apatia_status', $status, set_value('apatia_status')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'apatia_frecuencia', 'value'=>set_value('apatia_frecuencia'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'apatia_severidad', 'value'=>set_value('apatia_severidad'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'apatia_puntaje', 'value'=>set_value('apatia_puntaje'), 'readonly'=>'readonly')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'apatia_angustia', 'value'=>set_value('apatia_angustia'))); ?></td>				
			</tr>

			<tr>
				<td>8</td>
				<td>Deshinibición</td>
				<td><?= form_dropdown('deshinibicion_status', $status, set_value('deshinibicion_status')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'deshinibicion_frecuencia', 'value'=>set_value('deshinibicion_frecuencia'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'deshinibicion_severidad', 'value'=>set_value('deshinibicion_severidad'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'deshinibicion_puntaje', 'value'=>set_value('deshinibicion_puntaje'), 'readonly'=>'readonly')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'deshinibicion_angustia', 'value'=>set_value('deshinibicion_angustia'))); ?></td>				
			</tr>
			
			<tr>
				<td>9</td>
				<td>Irritabilidad</td>
				<td><?= form_dropdown('irritabilidad_status', $status, set_value('irritabilidad_status')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'irritabilidad_frecuencia', 'value'=>set_value('irritabilidad_frecuencia'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'irritabilidad_severidad', 'value'=>set_value('irritabilidad_severidad'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'irritabilidad_puntaje', 'value'=>set_value('irritabilidad_puntaje'), 'readonly'=>'readonly')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'irritabilidad_angustia', 'value'=>set_value('irritabilidad_angustia'))); ?></td>				
			</tr>
			<tr>
				<td>10</td>
				<td>Conducta Motora Aberrante</td>
				<td><?= form_dropdown('conducta_status', $status, set_value('conducta_status')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'conducta_frecuencia', 'value'=>set_value('conducta_frecuencia'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'conducta_severidad', 'value'=>set_value('conducta_severidad'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'conducta_puntaje', 'value'=>set_value('conducta_puntaje'), 'readonly'=>'readonly')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'conducta_angustia', 'value'=>set_value('conducta_angustia'))); ?></td>				
			</tr>
			<tr>
				<td>11</td>
				<td>Trastornos del sueño y de la Conducta</td>
				<td><?= form_dropdown('trastornos_sueno_status', $status, set_value('trastornos_sueno_status')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'trastornos_sueno_frecuencia', 'value'=>set_value('trastornos_sueno_frecuencia'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'trastornos_sueno_severidad', 'value'=>set_value('trastornos_sueno_severidad'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'trastornos_sueno_puntaje', 'value'=>set_value('trastornos_sueno_puntaje'), 'readonly'=>'readonly')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'trastornos_sueno_angustia', 'value'=>set_value('trastornos_sueno_angustia'))); ?></td>				
			</tr>
			<tr>
				<td>12</td>
				<td>Trastornos del apetito y de la alimentación</td>
				<td><?= form_dropdown('trastornos_apetito_status', $status, set_value('trastornos_apetito_status')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'trastornos_apetito_frecuencia', 'value'=>set_value('trastornos_apetito_frecuencia'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'trastornos_apetito_severidad', 'value'=>set_value('trastornos_apetito_severidad'))); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'trastornos_apetito_puntaje', 'value'=>set_value('trastornos_apetito_puntaje'), 'readonly'=>'readonly')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'trastornos_apetito_angustia', 'value'=>set_value('trastornos_apetito_angustia'))); ?></td>				
			</tr>
			<tr>
				<td colspan='5' style='text-align:center;'>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
		        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
				</td>
			</tr>
		</tbody>
	</table>
<?= form_close(); ?>