<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });	
});
</script>

<legend style='text-align:center;'>Signos Vitales (Adicional)</legend>
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
<?= form_open('subject/signos_vitales_adicional_insert', array('class'=>'form-horizontal','id'=>'form_signos')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>		
	
	<?php
		$data = array(
			    'name'        => 'realizado',			    
			    'value'       => 1,		    			    
		    );
	  	$data2 = array(
		    'name'        => 'realizado',			    
		    'value'       => 0,		    
		    );

	?>

	<table class="table table-bordered table-striper table-hover">		
		<tr>		
			<td>Fecha: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?></td>
		</tr>		
		<tr>
			<td>Presion Sistolica: </td>
			<td><?= form_input(array('type'=>'text','name'=>'presion_sistolica', 'id'=>'presion_sistolica', 'maxlength'=>'3','value'=>set_value('presion_sistolica'))); ?> mmHg</td>
		</tr>
		<tr>
			<td>Presion Diastolica: </td>
			<td><?= form_input(array('type'=>'text','name'=>'presion_diastolica', 'id'=>'presion_diastolica', 'maxlength'=>'3','value'=>set_value('presion_diastolica'))); ?> mmHg</td>
		</tr>
		<tr>	
			<td>Frecuencia Cardiaca: </td>
			<td><?= form_input(array('type'=>'text','name'=>'frecuencia_cardiaca', 'id'=>'frecuencia_cardiaca', 'maxlength'=>'3','value'=>set_value('frecuencia_cardiaca'))); ?> latidos/minuto</td>
		</tr>
		<tr>
			<td>Frecuencia Respiratoria: </td>
			<td><?= form_input(array('type'=>'text','name'=>'frecuencia_respiratoria', 'id'=>'frecuencia_respiratoria', 'maxlength'=>'3','value'=>set_value('frecuencia_respiratoria'))); ?> minuto</td>
		</tr>
		<tr>
			<td>Temperatura: </td>
			<td><?= form_input(array('type'=>'text','name'=>'temperatura', 'id'=>'temperatura', 'maxlength'=>'3','value'=>set_value('temperatura'))); ?> °C</td>
		</tr>
		<tr>
			<td>Peso: </td>
			<td><?= form_input(array('type'=>'text','name'=>'peso', 'id'=>'peso', 'maxlength'=>'3','value'=>set_value('peso'))); ?> kgs</td>
		</tr>
		<tr>
			<td>Obervaciones: </td>
			<td><?= form_textarea(array('name'=>'observaciones', 'id'=>'observaciones', 'value'=>set_value('observaciones'), 'rows'=>'4','cols'=>'40')); ?></td>
		</tr>
		
		<tr>
			<td colspan='2' style='text-align:center;'>
				<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'signos_vitales_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
	        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
	        </td>
	    </tr>
	</table>
<?= form_close(); ?>