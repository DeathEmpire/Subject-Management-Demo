<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker();

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_examen_neurologico :input").attr('readonly','readonly');
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_examen_neurologico :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled', 'disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_examen_neurologico :input").attr('readonly','readonly');
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_examen_neurologico :input").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled', 'disabled');
		});
	}
});
</script>
<legend style='text-align:center;'>Examen Neurologico</legend>
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
<?= form_open('subject/examen_neurologico_insert', array('class'=>'form-horizontal','id'=>'form_examen_neurologico')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('etapa', $etapa); ?>	
	 
	
		<?php
       		$si = array(
			    'name'        => 'realizado',			    
			    'value'       => 1,		    			    
			    'checked'     => set_radio('realizado', 1)
			    );
	   		$no = array(
			    'name'        => 'realizado',			    
			    'value'       => 0,	
			    'checked'     => set_radio('realizado', 0)
			    );
	   		$si2 = array(
			    'name'        => 'fecha_examen_misma_visita',			    
			    'value'       => 1,		    			    
			    'checked'     => set_radio('fecha_examen_misma_visita', 1)
			    );
	   		$no2 = array(
			    'name'        => 'fecha_examen_misma_visita',			    
			    'value'       => 0,	
			    'checked'     => set_radio('fecha_examen_misma_visita', 0)
			    );

	   		$normal_anormal = array(''=>'',
	   								'1'=>'Normal',
	   								'0'=>'Anormal');
       	?>	

		Examen Neurológico realizado <?= form_radio($si); ?> Si <?= form_radio($no); ?> No<br />
		La fecha del examen neurológico es la misma fecha de la visita?	 <?= form_radio($si2); ?> Si <?= form_radio($no2); ?> No<br />
 
		Si la respuesta es “NO”, por favor reporte fecha del examen: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?><br />
		<br />
		<table class='table table-bordered table-striped table-hover'>
			<tr>
				<th>Examen</th>
				<th>Normal/Anormal</th>
				<th>Detallar si es “Anormal” y clínicamente significativo</th>
			</tr>
			<tr>
				<td>Nervios craneanos</td>
				<td><?= form_dropdown("nervios_craneanos_normal_anormal",$normal_anormal,set_value('nervios_craneanos_normal_anormal')); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'nervios_craneanos', 'id'=>'nervios_craneanos', 'value'=>set_value('nervios_craneanos')));?></td>
			</tr>
			<tr>
				<td>Examen motor</td>
				<td><?= form_dropdown("examen_motor_normal_anormal",$normal_anormal,set_value('examen_motor_normal_anormal')); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'examen_motor', 'id'=>'examen_motor', 'value'=>set_value('examen_motor')));?></td>
			</tr>
			<tr>
				<td>Examen sensitivo</td>
				<td><?= form_dropdown("examen_sensitivo_normal_anormal",$normal_anormal,set_value('examen_sensitivo_normal_anormal')); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'examen_sensitivo', 'id'=>'examen_sensitivo', 'value'=>set_value('examen_sensitivo')));?></td>
			</tr>
			<tr>
				<td>Reflejos</td>
				<td><?= form_dropdown("reflejos_normal_anormal",$normal_anormal,set_value('reflejos_normal_anormal')); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'reflejos', 'id'=>'reflejos', 'value'=>set_value('reflejos')));?></td>
			</tr>
			<tr>
				<td>Función cerebelosa</td>
				<td><?= form_dropdown("funcion_cerebelosa_normal_anormal",$normal_anormal,set_value('funcion_cerebelosa_normal_anormal')); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'funcion_cerebelosa', 'id'=>'funcion_cerebelosa', 'value'=>set_value('funcion_cerebelosa')));?></td>
			</tr>
			<tr>
				<td>Marcha</td>
				<td><?= form_dropdown("marcha_normal_anormal",$normal_anormal,set_value('marcha_normal_anormal')); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'marcha', 'id'=>'marcha', 'value'=>set_value('marcha')));?></td>
			</tr>		
			<tr>
				<td style='font-weight:bold;' colspan='3'>Anormalidades de significancia clínica en la visita de screening deben reportarse como historia médica si el consentimiento informado está firmado.</td>
			</tr>
			<tr>
				<td style='font-weight:bold;' colspan='3'>Anormalidades de significancia clínica después de la visita de screening deben reportarse como eventos adversos.</td>
			</tr>
			<tr>
				<td colspan='3' style='text-align:center;'>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
            		<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
				</td>
			</tr>
		</table>

		
<?= form_close(); ?>