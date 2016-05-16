<script type="text/javascript">
$(function(){
	$("#birth_date").datepicker();
});
</script>
<legend style='text-align:center;'>Criterios de Inclusion/Exclusion</legend>
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
<?= form_open('subject/inclusion_insert', array('class'=>'form-horizontal')); ?>    
	
	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>

    <?= my_validation_errors(validation_errors()); ?>

    <table class="table table-condensed table-bordered table-striped">
           
	    <?php
		    $data = array(
			    'name'        => 'cumple_criterios',			    
			    'value'       => 1,		    
			    #'checked'	  => set_radio('gender', 'male', TRUE),
			    );
		  	$data2 = array(
			    'name'        => 'cumple_criterios',			    
			    'value'       => 0,
			    #'checked'	  => set_radio('gender', 'female', TRUE),		    
			    );
		      
	    ?>
	    <tr>
	        <td>El paciente cumple con los criterios de inclusión/exclusión: </td>
	        <td>
	        	<?= form_radio($data,$data['value'],set_radio($data['name'], true)); ?> Si <br>
	        	<?= form_radio($data2,$data2['value'],set_radio($data2['name'], false)); ?> NO - Por favor reporte detalles más abajo
	        </td>
	    </tr>        

		<tr>
			<td colspan='2' style='font-weight:bold;'>Criterios de inclusión/ exclusión no respetados (Agregar entrada)</td>			
		</tr>
		<tr>
			<td># Numero de Criterio</td>
			<td>Comentarios</td>
		</tr>
		<tr>
			<td><?=  form_input(array('type'=>'number','name'=>'numero[]', 'min'=>'1')); ?></td>
			<td><?=  form_input(array('type'=>'text','name'=>'comentario[]')); ?></td>
		</tr>
		<tr>
			<td><?=  form_input(array('type'=>'number','name'=>'numero[]', 'min'=>'1')); ?></td>
			<td><?=  form_input(array('type'=>'text','name'=>'comentario[]')); ?></td>
		</tr>
		<tr>
			<td><?=  form_input(array('type'=>'number','name'=>'numero[]', 'min'=>'1')); ?></td>
			<td><?=  form_input(array('type'=>'text','name'=>'comentario[]')); ?></td>
		</tr>
		<tr>
			<td>Cuenta con la autorización del patrocinador para inclusión</td>
			<td>
				<?= form_radio('autorizacion_patrocinador','Si'); ?> Si <br>
				<?= form_radio('autorizacion_patrocinador', 'No'); ?> No <br>
				<?= form_radio('autorizacion_patrocinador', 'No Aplica'); ?> No Aplica 
			</td>
		</tr>	
		
	    <tr>
	    	<td colspan='2' style='text-align:center;'>
				<?= form_button(array('type'=>'submit', 'content'=>'Enviar', 'class'=>'btn btn-primary')); ?>
	        	<?= anchor('subject/grid/'. $subject->id, 'Volver', array('class'=>'btn')); ?>
	    	</td>
	   	</tr>
	    
	</table>
<?= form_close(); ?>