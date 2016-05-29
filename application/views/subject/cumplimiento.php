<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker();

	$('#comprimidos_utilizados, #dias').change(function(){
		if($('#comprimidos_utilizados').val() != '' && $('#dias').val() != '')
		{
			var valor = $('#comprimidos_utilizados').val() / 2 / ($('#dias').val() * 100);		
			$('#porcentaje_cumplimiento	').val(valor);
		}
	});
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
	<table class="table table-bordered table-striper table-hover">
		<tr>		
			<td>Realizado: </td>
			<td>
				<?= form_radio($data,$data['value'],set_radio($data['name'], 1, true)); ?> Si
				<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
			</td>
		</tr>
		<tr>
			<td>Fecha: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?></td>
		</tr>
		<tr>
			<td>Numero Comprimidos Entregados: </td>
			<td><?= form_input(array('type'=>'text','name'=>'comprimidos_entregados', 'id'=>'comprimidos_entregados', 'maxlenght'=>'3','value'=>set_value('comprimidos_entregados'))); ?></td>
		</tr>
		<tr>
			<td>Numero Comprimidos Utilizados: </td>
			<td><?= form_input(array('type'=>'text','name'=>'comprimidos_utilizados', 'id'=>'comprimidos_utilizados', 'maxlenght'=>'3','value'=>set_value('comprimidos_utilizados'))); ?></td>
		</tr>
		<tr>
			<td>Numero Comprimidos Devueltos: </td>
			<td><?= form_input(array('type'=>'text','name'=>'comprimidos_devueltos', 'id'=>'comprimidos_devueltos', 'maxlenght'=>'3','value'=>set_value('comprimidos_devueltos'))); ?></td>
		</tr>
		<tr>

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
			<td>Se Perdio Algun Comprimido: </td>
			<td><?= form_radio($si); ?> Si <?= form_radio($no); ?> No
		</tr>
		<tr>		
			<td>Numero de Comprimido Perdidos: </td>
			<td><?= form_input(array('type'=>'text','name'=>'comprimidos_perdidos', 'id'=>'comprimidos_perdidos', 'maxlenght'=>'3','value'=>set_value('comprimidos_perdidos'))); ?></td>
		</tr>
		<tr>
			<td>Días (desde entrega anterior hasta Día de visita): </td>
			<td><?= form_input(array('type'=>'text','name'=>'dias', 'id'=>'dias', 'maxlenght'=>'3','value'=>set_value('dias'))); ?></td>
		</tr>
		<tr>
			<td>% cumplimiento (Comprimidos/2/días x 100): </td>
			<td><?= form_input(array('type'=>'text','name'=>'porcentaje_cumplimiento', 'id'=>'porcentaje_cumplimiento', 'maxlenght'=>'3','value'=>set_value('porcentaje_cumplimiento'))); ?></td>
		</tr>
		<tr>
			<td colspan='2' style='text-align:center;'>
				<?= form_button(array('type'=>'submit', 'content'=>'Enviar', 'class'=>'btn btn-primary')); ?>
	        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
			</td>
		</tr>
	</table>
<?= form_close(); ?>