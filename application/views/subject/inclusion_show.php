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
<!-- legend -->
<?php
	if(isset($_SESSION['role_options']['query']) AND strstr($_SESSION['role_options']['query'], 'inclusion_query_new')){
		
?>
	<div id='new_query' style='text-align:right;'>
		<?= form_open('query/additional_form_query_new' , array('class'=>'form-horizontal')); ?>		
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('form', "Inclusion Exclusion"); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_button(array('type'=>'submit', 'content'=>'Nueva Consulta', 'class'=>'btn btn-primary')); ?>
		<?= form_close(); ?>
	</div>
<?php }?>

<?= form_open('subject/inclusion_update', array('class'=>'form-horizontal')); ?>    
	
	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>
	<?= form_hidden('id', $list[0]['id']); ?>

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
<!-- Querys -->
<?php
	if(isset($querys) AND !empty($querys)){ ?>
		<b>Consultas:</b>
		<table class="table table-condensed table-bordered table-stripped">
			<thead>
				<tr>
					<th>Fecha de Consulta</th>
					<th>Usuasio</th>
					<th>Consulta</th>
					<th>Fecha de Respuesta</th>
					<th>Usuario</th>
					<th>Respuesta</th>					
				</tr>
			</thead>
			<tbody>
				
			<?php
				foreach ($querys as $query) { ?>
					<tr>
						<td><?= date("d-M-Y H:i:s", strtotime($query->created)); ?></td>
						<td><?= $query->question_user; ?></td>
						<td><?= $query->question; ?></td>						
						<td><?= (($query->answer_date != "0000-00-00 00:00:00") ? date("d-M-Y H:i:s", strtotime($query->answer_date)) : ""); ?></td>
						<td><?= $query->answer_user; ?></td>
						<?php
							if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'inclusion_query_show')){
						?>
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id, 'Add',array('class'=>'btn'))); ?></td>						
						<?php }else{?>
							<td><?= $query->answer; ?></td>
						<?php }?>
					</tr>					
			<?php }?>	

			</tbody>
		</table>

<?php } ?>
<!-- Verify -->
<b>Aprobacion del Monitor:</b><br />
	<?php if(!empty($subject->inclusion_verify_user) AND !empty($subject->inclusion_verify_date)){ ?>
		
		Formulario aprobado por <?= $subject->inclusion_verify_user;?> el <?= date("d-M-Y",strtotime($subject->inclusion_verify_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'inclusion_verify') 
			AND $subject->inclusion_status == 'Record Complete'
		){
	?>
		<?= form_open('subject/inclusion_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('id', $list[0]->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $subject->inclusion_status); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Aprobar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Aprobacion";
		}
	}
?>
<br />

<!--Signature/Lock-->
<br /><b>Cierre:</b><br />
	<?php if(!empty($subject->inclusion_lock_user) AND !empty($subject->inclusion_lock_date)){ ?>
		
		Formulario cerrado por <?= $subject->inclusion_lock_user;?> el <?= date("d-M-Y",strtotime($subject->inclusion_lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'inclusion_lock')
			AND $subject->inclusion_status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/inclusion_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('id', $list[0]->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $subject->inclusion_status); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Cerrar Formulario', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Cierre";
		}
	}
?>
<br />
<!--Signature-->
	<br /><b>Firma:</b><br />
	<?php if(!empty($subject->inclusion_signature_user) AND !empty($subject->inclusion_signature_date)){ ?>
		
		Formulario Firmado por <?= $subject->inclusion_signature_user;?> on <?= date("d-M-Y",strtotime($subject->inclusion_signature_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'inclusion_signature')
			AND $subject->inclusion_status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/inclusion_signature', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('id', $list[0]->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $subject->inclusion_status); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiene de Firma";
		}
	}
?>
<br />