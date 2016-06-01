<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha_visita, #fecha_ultima_dosis").datepicker();

	$("input[name=termino_el_estudio]").click(function(){
		if($(this).val() == 0){
			$("#tr_no").show();
		}
		else{
			$("#tr_no").hide();
		}
	});
});
</script>
<legend style='text-align:center;'>Fin Tratamiento</legend>
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
<?= form_open('subject/fin_tratamiento_insert', array('class'=>'form-horizontal','id'=>'form_fin_tratamiento')); ?>
	
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
			<td>No aplica, terminación temprana: </td><td><?= form_checkbox($no_aplica);?></td>
		</tr>
		<tr>
			<td>Fecha Visita:</td><td> <?= form_input(array('type'=>'text','name'=>'fecha_visita', 'id'=>'fecha_visita', 'value'=>set_value('fecha_visita'))); ?></td>
		</tr>
		<tr>
			<td>Fecha ultima dosis: </td><td><?= form_input(array('type'=>'text','name'=>'fecha_ultima_dosis', 'id'=>'fecha_ultima_dosis', 'value'=>set_value('fecha_ultima_dosis'))); ?></td>
		</tr>
		<tr>
		<?php
       		$si = array(
			    'name'        => 'termino_el_estudio',			    
			    'value'       => 1,		    			    
			    'checked'     => set_radio('termino_el_estudio', 1)
			    );
	   		$no = array(
			    'name'        => 'termino_el_estudio',			    
			    'value'       => 0,	
			    'checked'     => set_radio('termino_el_estudio', 0)
			    );
       	?>
			<td>¿Sujeto terminó el estudio? </td><td><?= form_radio($si); ?> Si <?= form_radio($no); ?> No</td>
		</tr>
		<tr id='tr_no' style='display:none;'>
			<td colspan='2' style='font-weight:bold;background-color:red;'>En este caso debe llenar el Fin de tratamiento terminación temprana, y marcar no aplica en esta página)</td>
		</tr>
		<tr>
			<td colspan='2' style='text-align:center;'>
				<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
		        <?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
	    	</td>
		</tr>
			
	</table>
<?= form_close(); ?>