<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker();
});
</script>
<legend style='text-align:center;'>Cumplimiento</legend>
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
<?= form_open('subject/cumplimiento_insert', array('class'=>'form-horizontal')); ?>
	
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
		Fecha: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?><br />

		Numero Comprimidos Entregados: <?= form_input(array('type'=>'text','name'=>'comprimidos_entregados', 'id'=>'comprimidos_entregados', 'maxlenght'=>'3','value'=>set_value('comprimidos_entregados'))); ?><br />
		Numero Comprimidos Utilizados: <?= form_input(array('type'=>'text','name'=>'comprimidos_utilizados', 'id'=>'comprimidos_utilizados', 'maxlenght'=>'3','value'=>set_value('comprimidos_utilizados'))); ?><br />
		Numero Comprimidos Devueltos: <?= form_input(array('type'=>'text','name'=>'comprimidos_devueltos', 'id'=>'comprimidos_devueltos', 'maxlenght'=>'3','value'=>set_value('comprimidos_devueltos'))); ?><br />

		<?php
       		$si = array(
			    'name'        => 'se_perdio_algun_comprimido',			    
			    'value'       => 1,		    			    
			    'checked'     => set_radio('se_perdio_algun_comprimido', 1)
			    );
	   		$no = array(
			    'name'        => 'se_perdio_algun_comprimido',			    
			    'value'       => 0,	
			    'checked'     => set_radio('se_perdio_algun_comprimido', 0)
			    );
       	?>
		Se Perdio Algun Comprimido: <?= form_radio($si); ?> Si <?= form_radio($no); ?> No
		<br />
		Numero de Comprimido Perdidos: <?= form_input(array('type'=>'text','name'=>'comprimidos_perdidos', 'id'=>'comprimidos_perdidos', 'maxlenght'=>'3','value'=>set_value('comprimidos_perdidos'))); ?><br />
		Días (desde entrega anterior hasta Día de visita): <?= form_input(array('type'=>'text','name'=>'dias', 'id'=>'dias', 'maxlenght'=>'3','value'=>set_value('dias'))); ?><br />
		% cumplimiento (Comprimidos/2/días x 100): <?= form_input(array('type'=>'text','name'=>'porcentaje_cumplimiento', 'id'=>'porcentaje_cumplimiento', 'maxlenght'=>'3','value'=>set_value('porcentaje_cumplimiento'))); ?><br />

<?= form_close(); ?>