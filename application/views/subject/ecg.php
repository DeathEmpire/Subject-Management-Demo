<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker();
});
</script>
<legend style='text-align:center;'>Electrocardiograma de reposo (ECG)</legend>
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

<?= form_open('subject/ecg_insert', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
		
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
	
		Realizado:
		<?= form_radio($data,$data['value'],set_radio($data['name'], 1, true)); ?> Si
		<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
		<br />
		Fecha: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?>


		<table class='table table-striped table-hover table-bordered table-condensed'>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th>Normal - Anormal</th>				
			</tr>
			<tr>
				<td>Ritmo Sinusal</td>
				<td><?= form_radio('ritmo_sinusal', 1, set_radio('ritmo_sinusal', 1)); ?> Si</td>
				<td><?= form_radio('ritmo_sinusal', 0, set_radio('ritmo_sinusal', 0)); ?> No</td>
				<td>
					<?= form_radio('ritmo_sinusal_normal_anormal', 1, set_radio('ritmo_sinusal_normal_anormal', 1)); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('ritmo_sinusal_normal_anormal', 0, set_radio('ritmo_sinusal_normal_anormal', 0)); ?>
				</td>
			</tr>
			<tr>
				<td>FC</td>
				<td></td>
				<td>Lat/min</td>
				<td>
					<?= form_radio('fc_normal_anormal', 1, set_radio('fc_normal_anormal', 1)); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('fc_normal_anormal', 0, set_radio('fc_normal_anormal', 0)); ?>
				</td>
			</tr>
			<tr>
				<td>PR</td>
				<td></td>
				<td>ms</td>
				<td>
					<?= form_radio('pr_normal_anormal', 1, set_radio('pr_normal_anormal', 1)); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('pr_normal_anormal', 0, set_radio('pr_normal_anormal', 0)); ?>
				</td>
			</tr>
			<tr>
				<td>QRS</td>
				<td></td>
				<td>ms</td>
				<td>
					<?= form_radio('qrs_normal_anormal', 1, set_radio('qrs_normal_anormal', 1)); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('qrs_normal_anormal', 0, set_radio('qrs_normal_anormal', 0)); ?>
				</td>
			</tr>
			<tr>
				<td>QT</td>
				<td></td>
				<td>ms</td>
				<td>
					<?= form_radio('qt_normal_anormal', 1, set_radio('qt_normal_anormal', 1)); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('qt_normal_anormal', 0, set_radio('qt_normal_anormal', 0)); ?>
				</td>
			</tr>
			<tr>
				<td>QTc</td>
				<td></td>
				<td>ms</td>
				<td>
					<?= form_radio('qtc_normal_anormal', 1, set_radio('qtc_normal_anormal', 1)); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('qtc_normal_anormal', 0, set_radio('qtc_normal_anormal', 0)); ?>
				</td>
			</tr>
			<tr>
				<td>QRS</td>
				<td></td>
				<td>°</td>
				<td>
					<?= form_radio('qrs2_normal_anormal', 1, set_radio('qrs2_normal_anormal', 1)); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('qrs2_normal_anormal', 0, set_radio('qrs2_normal_anormal', 0)); ?>
				</td>
			</tr>
			<tr>
				<td colspan='3'>INTERPRETACIÓN ECG:</td>
				<td><?= form_radio('interpretacion_ecg', 1, set_radio('interpretacion_ecg', 1)); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('interpretacion_ecg', 0, set_radio('interpretacion_ecg', 0)); ?>
				</td>
			</tr>
			<tr>
				<td>Comentarios: </td>		
				<td colspan='3'>
					<?= form_textarea(array('name'=>'comentarios', 'id'=>'comentarios', 'value'=>set_value('comentarios'), 'rows'=>'4','cols'=>'40')); ?>
				</td>
			</tr>
		
			<tr>
				<td colspan='4' style='text-align:center;'>
					<?= form_button(array('type'=>'submit', 'content'=>'Enviar', 'class'=>'btn btn-primary')); ?>
            		<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
            	</td>
			</tr>
		</table>
		


	<?= form_close(); ?>
