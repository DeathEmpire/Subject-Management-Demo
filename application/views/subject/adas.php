<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker();

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_adas :input").attr('readonly','readonly');
			
			$("input[name=realizado]").removeAttr('readonly');
			
			$("#guardar").removeAttr('readonly');
			

		}else{
			$("#form_adas :input").removeAttr('readonly');
			$("#puntaje_total").attr('readonly','readonly');
			
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_adas :input").attr('readonly','readonly');
		
		$("input[name=realizado]").removeAttr('readonly');
		
		$("#guardar").removeAttr('readonly');
		

	}else{
		$("#form_adas :input").removeAttr('readonly');
		$("#puntaje_total").attr('readonly','readonly');
	}

	$("select[name^=total_correctas_], input[name^=palabras_recordadas_], input[name^=total_recordadas], select[name^=puntuacion_]").change(function(){
		var total = 0;
		/*4 each*/

		$("select[name^=total_correctas_]").each(function(){
			if($('option:selected',this).text() != ''){
				total = total + parseInt($('option:selected',this).text());
			}
		});
		$("select[name^=puntuacion_]").each(function(){
			if($('option:selected',this).text() != ''){
				total = total + parseInt($('option:selected',this).text());
			}
		});
		$("input[name^=palabras_recordadas_]").each(function(){
			if($(this).val() != ''){
				total = total + parseInt($(this).val());
			}
		});
		$("input[name^=total_recordadas]").each(function(){
			if($(this).val() != ''){
				total = total + parseInt($(this).val());
			}
		});

		$("#puntaje_total").val(total);

	});
});	
	
</script>
<div class="row">
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

	<?= form_open('subject/adas_insert', array('class'=>'form-horizontal', 'id'=>'form_adas')); ?>
	
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
	?>

	<table class='table table-striped table-hover table-bordered table-condensed'>			
		<tbody>
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
				<td>Puntaje Total ADAS-Cog: </td>
				<td><?= form_input(array('type'=>'text','name'=>'puntaje_total', 'id'=>'puntaje_total', 'value'=>set_value('puntaje_total'), 'readonly'=>'readonly')); ?></td>
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>1.- Tarea de recordar palabras</td>
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;'>Ensayo 1</td>
			</tr>
			<tr>
				<td>Palabras recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_recordadas_1', 'id'=>'palabras_recordadas_1', 'value'=>set_value('palabras_recordadas_1'))); ?></td>
			</tr>
			<tr>
				<td>Palabras no recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_no_recordadas_1', 'id'=>'palabras_no_recordadas_1', 'value'=>set_value('palabras_no_recordadas_1'))); ?></td>
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;'>Ensayo 2</td>
			</tr>
			<tr>
				<td>Palabras recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_recordadas_2', 'id'=>'palabras_recordadas_2', 'value'=>set_value('palabras_recordadas_2'))); ?></td>
			</tr>
			<tr>
				<td>Palabras no recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_no_recordadas_2', 'id'=>'palabras_no_recordadas_2', 'value'=>set_value('palabras_no_recordadas_2'))); ?></td>
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;'>Ensayo 3</td>
			</tr>
			<tr>
				<td>Palabras recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_recordadas_3', 'id'=>'palabras_recordadas_3', 'value'=>set_value('palabras_recordadas_3'))); ?></td>
			</tr>
			<tr>
				<td>Palabras no recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_no_recordadas_3', 'id'=>'palabras_no_recordadas_3', 'value'=>set_value('palabras_no_recordadas_3'))); ?></td>
			</tr>
			<tr>
				<td>Hora de finalizacion: </td>
				<td><?= form_input(array('type'=>'text', 'name'=>'hora_finalizacion', 'id'=>'hora_finalizacion', 'value'=>set_value('hora_finalizacion'))); ?></td>
			</tr>
			<tr>
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_1', $no_administro, set_value('no_administro_1')); ?></td>
			</tr>

			
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>2.- Órdenes</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_2', $de0_a5, set_value('total_correctas_2'),array('id'=>'total_correctas_2')); ?></td>
			</tr>
			<tr>
				<td>Total incorrectas</td>
				<td><?= form_dropdown('total_incorrectas_2', $de0_a5,  set_value('total_incorrectas_2'),array('id'=>'total_incorrectas_2')); ?></td>				
			</tr>						
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>3.- Praxis Constructiva</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_3', $de0_a4,  set_value('total_correctas_3'),array('id'=>'total_correctas_3')); ?></td>								
			</tr>
			<tr>
				<td>Total incorrectas</td>
				<td><?= form_dropdown('total_incorrectas_3', $de0_a4,  set_value('total_incorrectas_3'),array('id'=>'total_incorrectas_3')); ?></td>				
			</tr>			
			<tr>
				<td>Paciente no intentó dibujar ninguna forma: </td>
				<td><?= form_checkbox('paciente_no_dibujo_3','1'); ?></td>
			</tr>			
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>4.- Tarea de recordar palabras diferidas </td>
			</tr>
			<tr>
				<td>Total recordadas</td>
				<td><?= form_input(array('type'=>'number', 'name'=>'total_recordadas_4', 'id'=>'total_recordadas_4', 'value'=>set_value('total_recordadas_4'))); ?></td>
			</tr>
			<tr>
				<td>Total no recordadas</td>
				<td><?= form_input(array('type'=>'number', 'name'=>'total_no_recordadas_4', 'id'=>'total_no_recordadas_4', 'value'=>set_value('total_no_recordadas_4'))); ?></td>
			</tr>

			
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>5.- Tarea de nombrar</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_5', $de0_a5,  set_value('total_correctas_5'),array('id'=>'total_correctas_5')); ?></td>								
			</tr>
			<tr>
				<td>Total incorrectas</td>				
				<td><?= form_dropdown('total_incorrectas_5', $de0_a5,  set_value('total_incorrectas_5'),array('id'=>'total_incorrectas_5')); ?></td>								
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>6.- Praxis Ideacional</td>
			</tr>
			<tr>
				<td>Total correctas</td>				
				<td><?= form_dropdown('total_correctas_6', $de0_a5,  set_value('total_correctas_6'),array('id'=>'total_correctas_6')); ?></td>								
			</tr>
			<tr>
				<td>Total incorrectas</td>				
				<td><?= form_dropdown('total_incorrectas_6', $de0_a5,  set_value('total_incorrectas_6'),array('id'=>'total_incorrectas_6')); ?></td>								
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>7.- Orientación</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_input(array('type'=>'number', 'name'=>'total_correctas_7', 'id'=>'total_correctas_7', 'value'=>set_value('total_correctas_7'))); ?></td>
			</tr>
			<tr>
				<td>Total incorrectas</td>
				<td><?= form_input(array('type'=>'number', 'name'=>'total_incorrectas_7', 'id'=>'total_incorrectas_7', 'value'=>set_value('total_incorrectas_7'))); ?></td>
			</tr>			
			<tr>
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_7', $no_administro, set_value('no_administro_7')); ?></td>
			</tr>

			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>8.- Tarea de reconocer palabras</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_input(array('type'=>'number', 'name'=>'total_correctas_8', 'id'=>'total_correctas_8', 'value'=>set_value('total_correctas_8'))); ?></td>
			</tr>
			<tr>
				<td>Total incorrectas</td>
				<td><?= form_input(array('type'=>'number', 'name'=>'total_incorrectas_8', 'id'=>'total_incorrectas_8', 'value'=>set_value('total_incorrectas_8'))); ?></td>
			</tr>
			<tr>
				<td>Cantidad de recordatorios</td>
				<td><?= form_input(array('type'=>'number', 'name'=>'cantidad_recordadas_8', 'id'=>'cantidad_recordadas_8', 'value'=>set_value('cantidad_recordadas_8'))); ?></td>
			</tr>			
			<tr>
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_8', $no_administro, set_value('no_administro_8')); ?></td>
			</tr>

			
			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>9.- Recordando las instrucciones de la prueba</td>
			</tr>
			<tr>
				<td>Puntuación</td>
				<td><?= form_dropdown('puntuacion_9', $puntaje, set_value('puntuacion_9')); ?></td>
			</tr>

			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>10.- Comprensión</td>
			</tr>
			<tr>
				<td>Puntuación</td>
				<td><?= form_dropdown('puntuacion_10', $puntaje, set_value('puntuacion_10')); ?></td>
			</tr>

			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>11.- Dificultad en la selección de palabras</td>
			</tr>
			<tr>
				<td>Puntuación</td>
				<td><?= form_dropdown('puntuacion_11', $puntaje, set_value('puntuacion_11')); ?></td>
			</tr>

			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>12.- Habilidad para el lenguaje hablado</td>
			</tr>
			<tr>
				<td>Puntuación</td>
				<td><?= form_dropdown('puntuacion_12', $puntaje, set_value('puntuacion_12')); ?></td>
			</tr>

			<tr>
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>13.	Eliminar números</td>
			</tr>
				<tr>
				<td>Número de objetivos tachadas</td>
				<td><?= form_input(array('type'=>'number', 'name'=>'objetivos_13', 'id'=>'objetivos_13', 'value'=>set_value('objetivos_13'))); ?></td>
			</tr>
			<tr>
				<td>Número de errores</td>
				<td><?= form_input(array('type'=>'number', 'name'=>'errores_13', 'id'=>'errores_13', 'value'=>set_value('errores_13'))); ?></td>
			</tr>
			<tr>
				<td>Número de veces que se recordó la tarea</td>
				<td><?= form_input(array('type'=>'number', 'name'=>'recordo_13', 'id'=>'recordo_13', 'value'=>set_value('recordo_13'))); ?></td>
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