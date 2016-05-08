<script type="text/javascript">
$(function(){

	$('input[type=checkbox]').click(function(){

		var total = 0;

		 $('input[type=checkbox]').each(function(){
            if (this.checked) {
                total += parseInt($(this).val());
            }
        });

		$("#td_total").text(total);
		$("#total").val(total);
	});

});	
</script>	
	<div class="row">
		<legend style='text-align:center;'>Escala de Hachinski modificada</legend>
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
					<td><?= $subject->code; ?></td>
					<td><?= $subject->initials; ?></td>		
					<td><?= ((isset($subject->screening_date) AND $subject->screening_date != '0000-00-00') ? date("d-M-Y",strtotime($subject->screening_date)) : ""); ?></td>
					<td><?= ((isset($subject->randomization_date) AND $subject->randomization_date != '0000-00-00') ? date("d-M-Y",strtotime($subject->randomization_date)) : ""); ?></td>
					<td><?= $subject->kit1; ?></td>					
				</tr>
			</tbody>
		</table>
		<br />
		<!-- legend -->
		<h3>Puntaje de isquemia de Hachinski modificada ≤4.</h3>
		<?= form_open('subject/hachinski_insert'); ?>		
			<input type='hidden' name='total' id='total' value='0' />
			<input type='hidden' name='subject_id' id='subject_id' value='<?php echo $subject->id; ?>' />
			<table class="table table-condensed table-bordered table-striped table-hover">
				<tr><td>Comienzo Brusco: </td><td><input type='checkbox' name='comienzo_brusco' id='comienzo_brusco' value='2' /></td></tr>
				<tr><td>Deterioro escalonado: </td><td><input type='checkbox' name='deterioro_escalonado' id='deterioro_escalonado' value='1' /></td></tr>
				<tr><td>Curso fluctuante: </td><td><input type='checkbox' name='curso_fluctante' id='curso_fluctante' value='2' /></td></tr>
				<tr><td>Desorientación nocturna: </td><td><input type='checkbox' name='desorientacion_noctura' id='desorientacion_noctura' value='1' /></td></tr>
				<tr><td>Preservación relativa de la personalidad: </td><td><input type='checkbox' name='preservacion_relativa' id='preservacion_relativa' value='1' /></td></tr>
				<tr><td>Depresión: </td><td><input type='checkbox' name='depresion' id='depresion' value='1' /></td></tr>
				<tr><td>Somatización: </td><td><input type='checkbox' name='somatizacion' id='somatizacion' value='1' /></td></tr>
				<tr><td>Labilidad emocional: </td><td><input type='checkbox' name='labilidad_emocional' id='labilidad_emocional' value='1' /></td></tr>
				<tr><td>Historia de HTA: </td><td><input type='checkbox' name='hta' id='hta' value='1' /></td></tr>
				<tr><td>Historia de ictus previos: </td><td><input type='checkbox' name='ictus_previos' id='ictus_previos' value='2' /></td></tr>
				<tr><td>Evidencia de arteriosclerosis asociada: </td><td><input type='checkbox' name='evidencia_arteriosclerosis' id='evidencia_arteriosclerosis' value='1' /></td></tr>
				<tr><td>Síntomas neurológicos focales: </td><td><input type='checkbox' name='sintomas_neurologicos' id='sintomas_neurologicos' value='2' /></td></tr>
				<tr><td>Signos neurológicos focales: </td><td><input type='checkbox' name='signos_neurologicos' id='signos_neurologicos' value='2' /></td></tr>
				<tr><td><b>Puntaje Total: </b></td><td style='text-align:rigth;font-weight:bold;' id='td_total'></td></tr>
				<tr><td colspan='2' style='text-align:center;'><input type='submit' class='btn btn-primary' value='Guardar' /></td></tr>
			</table>
		<?= form_close(); ?>
	</div>

