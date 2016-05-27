<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker();
});
</script>
<legend style='text-align:center;'>Prueba de Digito Directo</legend>
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

<?= form_open('subject/digito_directo_insert', array('class'=>'form-horizontal')); ?>
	
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
		Fecha: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?>


		<table class='table table-striped table-hover table-bordered table-condensed'>
			<tr>
				<th></th>
				<th>Item</th>
				<th>Intento</th>
				<th>Respuesta</th>
				<th>Puntaje Intento</th>
				<th>Puntaje Item</th>
			</tr>

			<tr>
				<td rowspan='16'>-></td>
				<td rowspan='2'>1</td>
				<td>9-7</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_1a',$valores_intento,set_radio('puntaje_intento_1a')); ?></td>
				<td><?= form_dropdown('putaje_item_1a',$valores_item, set_radio('puntaje_item_1a')); ?></td>
			</tr>
			<tr>				
				<td>6-3</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_1b',$valores_intento, set_radio('puntaje_intento_1b')); ?></td>
				<td><?= form_dropdown('putaje_item_1b',$valores_item, set_radio('puntaje_item_1b')); ?></td>
			</tr>
			<tr>				
				<td rowspan='2'>2</td>
				<td>5-8-2</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_2a',$valores_intento, set_radio('puntaje_intento_2a')); ?></td>
				<td><?= form_dropdown('putaje_item_2a',$valores_item, set_radio('puntaje_item_2a')); ?></td>
			</tr>
			<tr>
				<td>6-9-4</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_2b',$valores_intento, set_radio('puntaje_intento_2b')); ?></td>
				<td><?= form_dropdown('putaje_item_2b',$valores_item, set_radio('puntaje_item_2b')); ?></td>
			</tr>
			<tr>
				<td rowspan='2'>3</td>
				<td>7-2-8-6</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_3a',$valores_intento, set_radio('puntaje_intento_3a')); ?></td>
				<td><?= form_dropdown('putaje_item_3a',$valores_item, set_radio('puntaje_item_3a')); ?></td>
			</tr>
			<tr>
				<td>6-4-3-9</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_3b',$valores_intento, set_radio('puntaje_intento_3b')); ?></td>
				<td><?= form_dropdown('putaje_item_3b',$valores_item, set_radio('puntaje_item_3b')); ?></td>
			</tr>
			<tr>
				<td rowspan='2'>4</td>
				<td>4-2-7-3-1</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_4a',$valores_intento, set_radio('puntaje_intento_4a')); ?></td>
				<td><?= form_dropdown('putaje_item_4a',$valores_item, set_radio('puntaje_item_4a')); ?></td>
			</tr>
			<tr>
				<td>7-5-8-3-6</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_4b',$valores_intento, set_radio('puntaje_intento_4b')); ?></td>
				<td><?= form_dropdown('putaje_item_4b',$valores_item, set_radio('puntaje_item_4b')); ?></td>
			</tr>
			<tr>
				<td rowspan='2'>5</td>
				<td>3-9-2-4-8-7</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_5a',$valores_intento, set_radio('puntaje_intento_5a')); ?></td>
				<td><?= form_dropdown('putaje_item_5a',$valores_item, set_radio('puntaje_item_5a')); ?></td>
			</tr>
			<tr>
				<td>6-1-9-4-7-3</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_5b',$valores_intento, set_radio('puntaje_intento_5b')); ?></td>
				<td><?= form_dropdown('putaje_item_5b',$valores_item, set_radio('puntaje_item_5b')); ?></td>
			</tr>
			<tr>
				<td rowspan='2'>6</td>
				<td>4-1-7-9-3-8-6</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_6a',$valores_intento, set_radio('puntaje_intento_6a')); ?></td>
				<td><?= form_dropdown('putaje_item_6a',$valores_item, set_radio('puntaje_item_6a')); ?></td>
			</tr>
			<tr>
				<td>6-9-1-7-4-2-8</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_6b',$valores_intento, set_radio('puntaje_intento_6b')); ?></td>
				<td><?= form_dropdown('putaje_item_6b',$valores_item, set_radio('puntaje_item_6b')); ?></td>
			</tr>
			<tr>
				<td rowspan='2'>7</td>
				<td>3-8-2-9-6-1-7-4</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_7a',$valores_intento, set_radio('puntaje_intento_7a')); ?></td>
				<td><?= form_dropdown('putaje_item_7a',$valores_item, set_radio('puntaje_item_7a')); ?></td>
			</tr>
			<tr>
				<td>5-8-1-3-2-6-4-7</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_7b',$valores_intento, set_radio('puntaje_intento_7b')); ?></td>
				<td><?= form_dropdown('putaje_item_7b',$valores_item, set_radio('puntaje_item_7b')); ?></td>
			</tr>
			<tr>
				<td rowspan='2'>8</td>
				<td>2-7-5-8-6-3-1-9-4</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_8a',$valores_intento, set_radio('puntaje_intento_8a')); ?></td>
				<td><?= form_dropdown('putaje_item_8a',$valores_item, set_radio('puntaje_item_8a')); ?></td>
			</tr>
			<tr>
				<td>7-1-3-9-4-2-5-6-8</td>
				<td></td>
				<td><?= form_dropdown('puntaje_intento_8b',$valores_intento, set_radio('puntaje_intento_8b')); ?></td>
				<td><?= form_dropdown('putaje_item_8b',$valores_item, set_radio('puntaje_item_8b')); ?></td>
			</tr>		
			<tr>
				<td colspan='5' style='text-align:right;'>MSDD<br><small>(Maximo = 9)</small></td>
				<td colspan='3' style='text-align:right;'>Dígitos Orden Directo (DOD)<br>Puntaje Bruto Total<br><small>(Maximo = 16)</small></td>				
			</tr>
		</table>

	<?= form_close(); ?>
