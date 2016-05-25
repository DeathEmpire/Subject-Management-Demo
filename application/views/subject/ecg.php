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
			$realizado = array(
			    'name'        => 'realizado',
			    'id'          => 'realizado',
			    'value'       => '1',
			    'checked'     => set_checkbox('realizado','1')			    
		    );
		?>

		No Realizado: <?= form_checkbox($realizado);?><br />
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
				<td>Si</td>
				<td>No</td>
				<td>
					<?= form_radio('ritmo_sinusal_normal_anormal', 1); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('ritmo_sinusal_normal_anormal', 0); ?>
				</td>
			</tr>
			<tr>
				<td>FC</td>
				<td></td>
				<td>Lat/min</td>
				<td>
					<?= form_radio('fc_normal_anormal', 1); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('fc_normal_anormal', 0); ?>
				</td>
			</tr>
			<tr>
				<td>PR</td>
				<td></td>
				<td>ms</td>
				<td>
					<?= form_radio('pr_normal_anormal', 1); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('pr_normal_anormal', 0); ?>
				</td>
			</tr>
			<tr>
				<td>QRS</td>
				<td></td>
				<td>ms</td>
				<td>
					<?= form_radio('qrs_normal_anormal', 1); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('qrs_normal_anormal', 0); ?>
				</td>
			</tr>
			<tr>
				<td>QT</td>
				<td></td>
				<td>ms</td>
				<td>
					<?= form_radio('qt_normal_anormal', 1); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('qt_normal_anormal', 0); ?>
				</td>
			</tr>
			<tr>
				<td>QTc</td>
				<td></td>
				<td>ms</td>
				<td>
					<?= form_radio('qtc_normal_anormal', 1); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('qtc_normal_anormal', 0); ?>
				</td>
			</tr>
			<tr>
				<td>QRS</td>
				<td></td>
				<td>°</td>
				<td>
					<?= form_radio('qrs2_normal_anormal', 1); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= form_radio('qrs2_normal_anormal', 0); ?>
				</td>
			</tr>
			
		</table>

		INTERPRETACIÓN ECG: <?= form_radio('interpretacion_ecg', 1); ?> Normal <?= form_radio('interpretacion_ecg', 0); ?> Anormal<br />
		Comentarios: <br />
		<textarea></textarea>


	<?= form_close(); ?>
