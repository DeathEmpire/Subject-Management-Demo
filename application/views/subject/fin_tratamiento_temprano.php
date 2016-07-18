<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha_visita, #fecha_ultima_dosis").datepicker({ dateFormat: 'dd/mm/yy' });

	$("select[name=motivo]").change(function(){
		if($(this).val() == 'Otro'){
			$("#tr_otro").show();
		}
		else{
			$("#tr_otro").hide();
		}
	});

	if($("select[name=motivo]").val() == 'Otro'){
		$("#tr_otro").show();
	}
	else{
		$("#tr_otro").hide();
	}
});
</script>
<legend style='text-align:center;'>Fin Tratamiento Temprano</legend>
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
<?= form_open('subject/fin_tratamiento_temprano_insert', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>		
	 
	<?php
			$no_aplica = array(
			    'name'        => 'no_aplica',
			    'id'          => 'no_aplica',
			    'value'       => '1',
			    'checked'     => set_checkbox('no_aplica','1')			    
		    );
		?>
	<table class="table table-bordered table-striper table-hover">
		<tr>
			<td>No aplica:</td>
			<td><?= form_checkbox($no_aplica);?></td>
		</tr>
		<tr>
			<td>Fecha Visita:</td>
			<td> <?= form_input(array('type'=>'text','name'=>'fecha_visita', 'id'=>'fecha_visita', 'value'=>set_value('fecha_visita'))); ?></td>
		</tr>
		<tr>
			<td>Fecha ultima dosis: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha_ultima_dosis', 'id'=>'fecha_ultima_dosis', 'value'=>set_value('fecha_ultima_dosis'))); ?></td>
		</tr>
		<tr>
		<?php

			$motivo = array(''=>'',
							'Decisión del sujeto' =>'Decisión del sujeto',
							'Decisión del Investigador' =>'Decisión del Investigador',
							'Decisión del Patrocinador' =>'Decisión del Patrocinador',
							'Evento Adverso' =>'Evento Adverso',
							'Pérdida de seguimiento' =>'Pérdida de seguimiento',
							'Otro' =>'Otro'
					);

		?>

			<td>Motivo por el cual sujeto no terminó el estudio: </td>
			<td><?= form_dropdown("motivo",$motivo,set_value('motivo')); ?></td>
		</tr>
		<tr id='tr_otro' style='display:none;'>
			<td>Otro Motivo: </td>
			<td><?= form_input(array('type'=>'text','name'=>'otro_motivo', 'id'=>'otro_motivo', 'value'=>set_value('otro_motivo'))); ?></td>
		</tr>		
		<tr>
			<td colspan='2' style='text-align:center;'>
				<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_temprano_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
	        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
	        </td>
	    </tr>
	</table>
<?= form_close(); ?>