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

<?= form_open('subject/historial_medico_insert', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>

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
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>				
				<td>6-3</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>				
				<td rowspan='2'>2</td>
				<td>5-8-2</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>
				<td>6-9-4</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>
				<td rowspan='2'>3</td>
				<td>7-2-8-6</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>
				<td>6-4-3-9</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>
				<td rowspan='2'>4</td>
				<td>4-2-7-3-1</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>
				<td>7-5-8-3-6</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>
				<td rowspan='2'>5</td>
				<td>3-9-2-4-8-7</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>
				<td>6-1-9-4-7-3</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>
				<td rowspan='2'>6</td>
				<td>4-1-7-9-3-8-6</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>
				<td>6-9-1-7-4-2-8</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>
				<td rowspan='2'>7</td>
				<td>3-8-2-9-6-1-7-4</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>
				<td>5-8-1-3-2-6-4-7</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>
				<td rowspan='2'>8</td>
				<td>2-7-5-8-6-3-1-9-4</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>
			<tr>
				<td>7-1-3-9-4-2-5-6-8</td>
				<td></td>
				<td><?= form_dropdown('',$valores_intento); ?></td>
				<td><?= form_dropdown('',$valores_item); ?></td>
			</tr>		
			<tr>
				<td colspan='5' style='text-align:right;'>MSDD<br><small>(Maximo = 9)</small></td>
				<td colspan='3' style='text-align:right;'>Dígitos Orden Directo (DOD)<br>Puntaje Bruto Total<br><small>(Maximo = 16)</small></td>				
			</tr>
		</table>

	<?= form_close(); ?>
