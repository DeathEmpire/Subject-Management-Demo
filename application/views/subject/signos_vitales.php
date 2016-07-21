<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_signos :input").attr('readonly','readonly');
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_signos :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled', 'disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_signos :input").attr('readonly','readonly');
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_signos :input").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled', 'disabled');
		});
	}


	$("#peso, #estatura").change(function(){
		if($("#peso").val() != '' && $("#estatura").val() != ''){
			var estatura2 = Math.pow($("#estatura").val(),2);
			var peso = $("#peso").val();
			var imc = (peso / estatura2) * 10000;
			$("#imc").val(imc.toFixed(2));
		}
	});

	if($("#peso").val() != '' && $("#estatura").val() != ''){
		var estatura2 = Math.pow($("#estatura").val(),2);
		var peso = $("#peso").val();
		var imc = (peso / estatura2) * 10000;
		$("#imc").val(imc.toFixed(2));
	}
});
</script>
<?php
	switch($etapa){
		case 1 : $protocolo = "(Selección)"; break;
		case 2 : $protocolo = "(Basal Día 1)"; break;
		case 3 : $protocolo = "(Semana 4)"; break;
		case 4 : $protocolo = "(Semana 12)"; break;
		case 5 : $protocolo = "(Término del Estudio)"; break;
		case 6 : $protocolo = "(Terminación Temprana)"; break;
		default : $protocolo = ""; break;
	}
?>
<legend style='text-align:center;'>Signos Vitales <?= $protocolo;?></legend>
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
<?= form_open('subject/signos_vitales_insert', array('class'=>'form-horizontal','id'=>'form_signos')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('etapa', $etapa); ?>	
	
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
			<td>Realizado: </td>
			<td>
				<?= form_radio($data,$data['value'],set_radio($data['name'], 1)); ?> Si
				<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
			</td>
		</tr>
		<tr>		
			<td>Fecha: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?></td>
		</tr>
		<?php
			if(isset($etapa) AND $etapa == 1){
		?>
		<tr>
			<td>Estatura: </td>
			<td><?= form_input(array('type'=>'text','name'=>'estatura', 'id'=>'estatura', 'maxlenght'=>'3','value'=>set_value('estatura'))); ?> cms</td>
		</tr>
		<?php }else{ ?>
			
				<?= form_hidden('estatura', ''); ?>

		<?php }?>
		<tr>
			<td>Presion Sistolica: </td>
			<td><?= form_input(array('type'=>'text','name'=>'presion_sistolica', 'id'=>'presion_sistolica', 'maxlenght'=>'3','value'=>set_value('presion_sistolica'))); ?> mmHg</td>
		</tr>
		<tr>
			<td>Presion Diastolica: </td>
			<td><?= form_input(array('type'=>'text','name'=>'presion_diastolica', 'id'=>'presion_diastolica', 'maxlenght'=>'3','value'=>set_value('presion_diastolica'))); ?> mmHg</td>
		</tr>
		<tr>	
			<td>Frecuencia Cardiaca: </td>
			<td><?= form_input(array('type'=>'text','name'=>'frecuencia_cardiaca', 'id'=>'frecuencia_cardiaca', 'maxlenght'=>'3','value'=>set_value('frecuencia_cardiaca'))); ?> latidos/minuto</td>
		</tr>
		<tr>
			<td>Frecuencia Respiratoria: </td>
			<td><?= form_input(array('type'=>'text','name'=>'frecuencia_respiratoria', 'id'=>'frecuencia_respiratoria', 'maxlenght'=>'3','value'=>set_value('frecuencia_respiratoria'))); ?> minuto</td>
		</tr>
		<tr>
			<td>Temperatura: </td>
			<td><?= form_input(array('type'=>'text','name'=>'temperatura', 'id'=>'temperatura', 'maxlenght'=>'3','value'=>set_value('temperatura'))); ?> °C</td>
		</tr>
		<tr>
			<td>Peso: </td>
			<td><?= form_input(array('type'=>'text','name'=>'peso', 'id'=>'peso', 'maxlenght'=>'3','value'=>set_value('peso'))); ?> kgs</td>
		</tr>
		<?php
			if(isset($etapa) AND $etapa == 1){
		?>
			<tr>
				<td>IMC: </td>
				<td><?= form_input(array('type'=>'text','name'=>'imc', 'id'=>'imc', 'maxlenght'=>'3','value'=>set_value('imc'))); ?></td>
			</tr>
		<?php }else{ ?>
			
				<?= form_hidden('imc', ''); ?>

		<?php }?>
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