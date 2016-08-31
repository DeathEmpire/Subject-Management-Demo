<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

	


	$("select[name=nervios_craneanos_normal_anormal]").change(function(){
		if($(this).val() == 1){
			$("#nervios_craneanos").attr('readonly','readonly');
		}else{
			$("#nervios_craneanos").removeAttr('readonly');
		}
	});
	$("select[name=fuerza_muscular_normal_anormal]").change(function(){
		if($(this).val() == 1){
			$("#fuerza_muscular").attr('readonly','readonly');
		}else{
			$("#fuerza_muscular").removeAttr('readonly');
		}
	});
	$("select[name=tono_normal_anormal]").change(function(){
		if($(this).val() == 1){
			$("#tono").attr('readonly','readonly');
		}else{
			$("#tono").removeAttr('readonly');
		}
	});
	$("select[name=mov_anormales_normal_anormal]").change(function(){
		if($(this).val() == 1){
			$("#mov_anormales").attr('readonly','readonly');
		}else{
			$("#mov_anormales").removeAttr('readonly');
		}
	});
	$("select[name=motora_normal_anormal]").change(function(){
		if($(this).val() == 1){
			$("#motora").attr('readonly','readonly');
		}else{
			$("#motora").removeAttr('readonly');
		}
	});
	$("select[name=reflejos_normal_anormal]").change(function(){
		if($(this).val() == 1){
			$("#reflejos").attr('readonly','readonly');
		}else{
			$("#reflejos").removeAttr('readonly');
		}
	});
	$("select[name=examen_sensitivo_normal_anormal]").change(function(){
		if($(this).val() == 1){
			$("#examen_sensitivo").attr('readonly','readonly');
		}else{
			$("#examen_sensitivo").removeAttr('readonly');
		}
	});
	$("select[name=coordinacion_normal_anormal]").change(function(){
		if($(this).val() == 1){
			$("#coordinacion").attr('readonly','readonly');
		}else{
			$("#coordinacion").removeAttr('readonly');
		}
	});
	$("select[name=marcha_normal_anormal]").change(function(){
		if($(this).val() == 1){
			$("#marcha").attr('readonly','readonly');
		}else{
			$("#marcha").removeAttr('readonly');
		}
	});
	$("select[name=postura_normal_anormal]").change(function(){
		if($(this).val() == 1){
			$("#postura").attr('readonly','readonly');
		}else{
			$("#postura").removeAttr('readonly');
		}
	});
	$("select[name=funcion_cerebelosa_normal_anormal]").change(function(){
		if($(this).val() == 1){
			$("#funcion_cerebelosa").attr('readonly','readonly');
		}else{
			$("#funcion_cerebelosa").removeAttr('readonly');
		}
	});


	if($("select[name=nervios_craneanos_normal_anormal] option:selected").text() == 'Normal'){		
		$("#nervios_craneanos").attr('readonly','readonly');
	}else{
		
		$("#nervios_craneanos").removeAttr('readonly');
	}

	if($("select[name=fuerza_muscular_normal_anormal] option:selected").text() == 'Normal'){
		$("#fuerza_muscular").attr('readonly','readonly');
	}else{
		$("#fuerza_muscular").removeAttr('readonly');
	}

	if($("select[name=tono_normal_anormal]option:selected").text() == 'Normal'){
		$("#tono").attr('readonly','readonly');
	}else{
		$("#tono").removeAttr('readonly');
	}

	if($("select[name=mov_anormales_normal_anormal] option:selected").text() == 'Normal'){
		$("#mov_anormales").attr('readonly','readonly');
	}else{
		$("#mov_anormales").removeAttr('readonly');
	}

	if($("select[name=motora_normal_anormal] option:selected").text() == 'Normal'){
		$("#motora").attr('readonly','readonly');
	}else{
		$("#motora").removeAttr('readonly');
	}

	if($("select[name=reflejos_normal_anormal] option:selected").text() == 'Normal'){
		$("#reflejos").attr('readonly','readonly');
	}else{
		$("#reflejos").removeAttr('readonly');
	}

	if($("select[name=examen_sensitivo_normal_anormal] option:selected").text() == 'Normal'){
		$("#examen_sensitivo").attr('readonly','readonly');
	}else{
		$("#examen_sensitivo").removeAttr('readonly');
	}

	if($("select[name=coordinacion_normal_anormal] option:selected").text() == 'Normal'){
		$("#coordinacion").attr('readonly','readonly');
	}else{
		$("#coordinacion").removeAttr('readonly');
	}

	if($("select[name=marcha_normal_anormal] option:selected").text() == 'Normal'){
		$("#marcha").attr('readonly','readonly');
	}else{
		$("#marcha").removeAttr('readonly');
	}

	if($("select[name=postura_normal_anormal] option:selected").text() == 'Normal'){
		$("#postura").attr('readonly','readonly');
	}else{
		$("#postura").removeAttr('readonly');
	}

	if($("select[name=funcion_cerebelosa_normal_anormal] option:selected").text() == 'Normal'){
		$("#funcion_cerebelosa").attr('readonly','readonly');
	}else{
		$("#funcion_cerebelosa").removeAttr('readonly');
	}

	$("input[name=tuvo_cambios]").change(function(){
		if($(this).val() == 1)
		{
			$("#tr_observaciones").show();
		}else{
			$("#tr_observaciones").hide();
			$("#cambios_observaciones").val('');
		}
	});

	if($("input[name=tuvo_cambios]:checked").val() == 1)
	{
		$("#tr_observaciones").show();
	}else{
		$("#tr_observaciones").hide();
		$("#cambios_observaciones").val('');
	}

});
</script>

<legend style='text-align:center;'>Examen Neurológico</legend>
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
<?= form_open('subject/examen_neurologico_adicional_insert', array('class'=>'form-horizontal','id'=>'form_examen_neurologico')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	
	 
	
		<?php
       		
	   		$normal_anormal = array(''=>'',
	   								'1'=>'Normal',
	   								'0'=>'Anormal');
       	?>	

		
		Fecha: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?><br />
		¿Entre que visitas se realiazó?: <?= form_dropdown('etapa',$etapas, set_value('etapa')); ?>
		<br />
		<table class='table table-bordered table-striped table-hover'>
			<tr>
				<th>Examen</th>
				<th>Normal/Anormal</th>
				<th>Detallar si es “Anormal” y clínicamente significativo</th>
			</tr>
			<tr>
				<td>Nervios craneales</td>
				<td><?= form_dropdown("nervios_craneanos_normal_anormal",$normal_anormal,set_value('nervios_craneanos_normal_anormal')); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'nervios_craneanos', 'id'=>'nervios_craneanos', 'value'=>set_value('nervios_craneanos')));?></td>
			</tr>
			
				<tr>
					<td>Fuerza muscular</td>
					<td><?= form_dropdown("fuerza_muscular_normal_anormal",$normal_anormal,set_value('fuerza_muscular_normal_anormal')); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'fuerza_muscular', 'id'=>'fuerza_muscular', 'value'=>set_value('fuerza_muscular')));?></td>
				</tr>
				<tr>
					<td>Tono</td>
					<td><?= form_dropdown("tono_normal_anormal",$normal_anormal,set_value('tono_normal_anormal')); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'tono', 'id'=>'tono', 'value'=>set_value('tono')));?></td>
				</tr>
				<tr>
					<td>Movimientos anormales</td>
					<td><?= form_dropdown("mov_anormales_normal_anormal",$normal_anormal,set_value('mov_anormales_normal_anormal')); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'mov_anormales', 'id'=>'mov_anormales', 'value'=>set_value('mov_anormales')));?></td>
				</tr>
			
			
				<tr>
					<td>Función motora</td>
					<td><?= form_dropdown("motora_normal_anormal",$normal_anormal,set_value('motora_normal_anormal')); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'motora', 'id'=>'motora', 'value'=>set_value('motora')));?></td>
				</tr>
			
			<tr>
				<td>Reflejos tendinosos profundos</td>
				<td><?= form_dropdown("reflejos_normal_anormal",$normal_anormal,set_value('reflejos_normal_anormal')); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'reflejos', 'id'=>'reflejos', 'value'=>set_value('reflejos')));?></td>
			</tr>
			<tr>
				<td>Examen sensorial</td>
				<td><?= form_dropdown("examen_sensitivo_normal_anormal",$normal_anormal,set_value('examen_sensitivo_normal_anormal')); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'examen_sensitivo', 'id'=>'examen_sensitivo', 'value'=>set_value('examen_sensitivo')));?></td>
			</tr>
				<tr>
					<td>Marcha</td>
					<td><?= form_dropdown("marcha_normal_anormal",$normal_anormal,set_value('marcha_normal_anormal')); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'marcha', 'id'=>'marcha', 'value'=>set_value('marcha')));?></td>
				</tr>
				<tr>
					<td>Postura</td>
					<td><?= form_dropdown("postura_normal_anormal",$normal_anormal,set_value('postura_normal_anormal')); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'postura', 'id'=>'postura', 'value'=>set_value('postura')));?></td>
				</tr>
			
				<tr>
					<td>Coordinación</td>
					<td><?= form_dropdown("coordinacion_normal_anormal",$normal_anormal,set_value('coordinacion_normal_anormal')); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'coordinacion', 'id'=>'coordinacion', 'value'=>set_value('coordinacion')));?></td>
				</tr>
							
				<tr>
					<td>Función cortical superior</td>
					<td><?= form_dropdown("funcion_cerebelosa_normal_anormal",$normal_anormal,set_value('funcion_cerebelosa_normal_anormal')); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'funcion_cerebelosa', 'id'=>'funcion_cerebelosa', 'value'=>set_value('funcion_cerebelosa')));?></td>
				</tr>
			
			<tr>
				<td colspan='3' style='text-align:center;'>
					<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'examen_neurologico_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
            		<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn btn-default')); ?>
				</td>
			</tr>
		</table>

		
<?= form_close(); ?>