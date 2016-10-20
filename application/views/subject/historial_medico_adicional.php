<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("input[name=realizado]").change(function(){
		if($(this).val() == 1){
			$(".punto2").show();
		}
		else{
			$(".punto2").hide();	
			$(".punto3").hide();
		}
	});

	$("#agregar_entrada").click(function(){
		$(".punto3").show();

		$("#tabla").append("<tr class='punto3'><td><input type='text' name='cambio[]'></td><td><input type='text' name='comentario[]'></td></tr>");
	});

});
</script>
		<legend style='text-align:center;'>Historia Médica VISITA BASAL</legend>
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

	<?= form_open('subject/historial_medico_adicional_insert', array('class'=>'form-horizontal', 'id'=>'form_historial_medico_adicional')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	

	<table class='table table-striped table-hover table-bordered table-condensed' id='tabla'>	
		<tbody>
			<tr>
				<td style='background-color:#ccc;' colspan='2'>¿EXISTEN CAMBIOS EN LA HISTORIA MÉDICA DEL SUJETO DESDE LA VISITA DE SELECCIÓN?</td>
			</tr>
			<tr>
				<td colspan='2'><?= form_radio('realizado',1,set_radio('realizado', 1));  ?> SI - Por favor reporte detalles más abajo</td>
			</tr>
			<tr>
				<td colspan='2'><?= form_radio('realizado',0,set_radio('realizado', 0));  ?> No</td>
			</tr>
			<tr style='display:none;' class='punto2'>
				<td colspan='2' style='background-color:#ccc;'>Cambios en la historia médica desde la visita de selección</td>
			</tr>
			<tr id='entradas' class='punto2' style='display:none;'>
				<td colspan='2'><?= form_button(array('type'=>'button', 'content'=>'Agregar Entrada', 'class'=>'btn btn-info', 'id'=>'agregar_entrada')); ?></td>
			</tr>
			<tr class='punto3' style='display:none;background-color:#ccc;'>
				<td>Cambio(s)</td>
				<td>Comentarios</td>
			</tr>
		</tbody>
	</table>
	<div style='text-align:center;'>
		<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
	</div>

	<?= form_close();?>
	
		
		

