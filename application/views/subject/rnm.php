<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#tomografia_fecha, #resonancia_fecha").datepicker();	

	$("input[name=tomografia]").change(function(){
		if($(this).val() == 0){
			$("#tomografia_fecha").attr('readonly','readonly');
			$("#tomografia_fecha").attr('disabled','disabled');
			$("#tomografia_comentario").attr('readonly','readonly');			

		}else{
			$("#tomografia_fecha").removeAttr('readonly');
			$("#tomografia_fecha").removeAttr('disabled');
			$("#tomografia_comentario").removeAttr('readonly');
		}
	});
	if($("input[name=tomografia]:checked").val() == 0){
		$("#tomografia_fecha").attr('readonly','readonly');
		$("#tomografia_fecha").attr('disabled','disabled');
		$("#tomografia_comentario").attr('readonly','readonly');			

	}else{
		$("#tomografia_fecha").removeAttr('readonly');
		$("#tomografia_fecha").removeAttr('disabled');
		$("#tomografia_comentario").removeAttr('readonly');
	}

	$("input[name=resonancia]").change(function(){
		if($(this).val() == 0){
			$("#resonancia_fecha").attr('readonly','readonly');
			$("#resonancia_fecha").attr('disabled','disabled');
			$("#resonancia_comentario").attr('readonly','readonly');			

		}else{
			$("#resonancia_fecha").removeAttr('readonly');
			$("#resonancia_fecha").removeAttr('disabled');
			$("#resonancia_comentario").removeAttr('readonly');
		}
	});
	if($("input[name=resonancia]:checked").val() == 0){
		$("#resonancia_fecha").attr('readonly','readonly');
		$("#resonancia_fecha").attr('disabled','disabled');
		$("#resonancia_comentario").attr('readonly','readonly');			

	}else{
		$("#resonancia_fecha").removeAttr('readonly');
		$("#resonancia_fecha").removeAttr('disabled');
		$("#resonancia_comentario").removeAttr('readonly');
	}
	
});
</script>
<legend style='text-align:center;'>RNM o TC</legend>
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
<?= form_open('subject/rnm_insert', array('class'=>'form-horizontal', 'id'=>'form_rnm')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>			
	<?php
		$data = array(
			    'name'        => 'resonancia',			    
			    'value'       => 1,		    			    
		    );
	  	$data2 = array(
		    'name'        => 'resonancia',			    
		    'value'       => 0,		    
		    );	   
	  	$data3 = array(
			    'name'        => 'tomografia',			    
			    'value'       => 1,		    			    
		    );
	  	$data4 = array(
		    'name'        => 'tomografia',			    
		    'value'       => 0,		    
		    );
	?>

	<table class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<th colspan='2'>Imágenes disponibles</th>
				<th>Fecha Examen</th>
				<th>Comentarios</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>¿Dispone el sujeto de una Resonancia Magnética? </td>
				<td>
					<?= form_radio($data,$data['value'],set_radio($data['name'], 1, true)); ?> Si
					<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
				</td>
				<td><?= form_input(array('type'=>'text','name'=>'resonancia_fecha','id'=>'resonancia_fecha', 'value'=>set_value('resonancia_fecha'))); ?></td>
				<td><?= form_textarea(array('name'=>'resonancia_comentario', 'id'=>'resonancia_comentario','value'=>set_value('resonancia_comentario'),'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>¿Dispone el sujeto de una Tomografía Computarizada?</td>
				<td>
					<?= form_radio($data3,$data3['value'],set_radio($data3['name'], 1, true)); ?> Si
					<?= form_radio($data4,$data4['value'],set_radio($data4['name'], 0)); ?> NO
				</td>
				<td><?= form_input(array('type'=>'text','name'=>'tomografia_fecha','id'=>'tomografia_fecha', 'value'=>set_value('tomografia_fecha'))); ?></td>
				<td><?= form_textarea(array('name'=>'tomografia_comentario', 'id'=>'tomografia_comentario','value'=>set_value('tomografia_comentario'),'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td colspan='4' style='text-align:center;'>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
		        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
				</td>
			</tr>
		</tbody>
	</table>

<?= form_close(); ?>