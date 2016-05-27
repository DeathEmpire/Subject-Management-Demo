<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker();
});
</script>
<legend style='text-align:center;'>Signos Vitales</legend>
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
<?= form_open('subject/signos_vitales_insert', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('etapa', $etapa); ?>	
	<?php
			$realizado = array(
			    'name'        => 'realizado',
			    'id'          => 'realizado',
			    'value'       => '1',
			    'checked'     => set_checkbox('realizado','1')			    
		    );
		?>

		No Realizado: <?= form_checkbox($realizado);?><br />
		Fecha: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?><br />

		Estatura: <?= form_input(array('type'=>'text','name'=>'estatura', 'id'=>'estatura', 'maxlenght'=>'3','value'=>set_value('estatura'))); ?> cms<br />

		Presion Sistolica: <?= form_input(array('type'=>'text','name'=>'presion_sistolica', 'id'=>'presion_sistolica', 'maxlenght'=>'3','value'=>set_value('presion_sistolica'))); ?> mmHg<br />
		Presion Diastolica: <?= form_input(array('type'=>'text','name'=>'presion_diastolica', 'id'=>'presion_diastolica', 'maxlenght'=>'3','value'=>set_value('presion_diastolica'))); ?> mmHg<br />
		Frecuencia Cardiaca: <?= form_input(array('type'=>'text','name'=>'frecuencia_cardiaca', 'id'=>'frecuencia_cardiaca', 'maxlenght'=>'3','value'=>set_value('frecuencia_cardiaca'))); ?> latidos/minuto<br />
		Frecuencia Respiratoria: <?= form_input(array('type'=>'text','name'=>'frecuencia_respiratoria', 'id'=>'frecuencia_respiratoria', 'maxlenght'=>'3','value'=>set_value('frecuencia_respiratoria'))); ?> minuto<br />
		Temperatura: <?= form_input(array('type'=>'text','name'=>'temperatura', 'id'=>'temperatura', 'maxlenght'=>'3','value'=>set_value('temperatura'))); ?> °C<br />
		Peso: <?= form_input(array('type'=>'text','name'=>'peso', 'id'=>'peso', 'maxlenght'=>'3','value'=>set_value('peso'))); ?> kgs<br />



<?= form_close(); ?>