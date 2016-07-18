<script type="text/javascript">
$(function(){
		$("input[name=cumple_criterios]").change(function(){
		if($(this).val() == 1){
			$("#tr_autorizacion").hide();
			$("input[name=autorizacion_patrocinador][value='No Aplica']").prop("checked",true);
			$("#tr_no_ingresa").hide();
			$("#tr_submit").show();
		}
		else{
			$("#tr_autorizacion").show();
		}
	});
	if($('input[name=cumple_criterios]:checked').val() == 1){
		$("#tr_autorizacion").hide();
		$("input[name=autorizacion_patrocinador][value='No Aplica']").prop("checked",true);
		$("#tr_no_ingresa").hide();
		$("#tr_submit").show();
	}
	else{
		$("#tr_autorizacion").show();
	}

	$("input[name=autorizacion_patrocinador]").change(function(){
		if($(this).val() == 'No'){
			$("#tr_submit").hide();
			$("#tr_no_ingresa").show();			
		}
		else{
			$("#tr_submit").show();
			$("#tr_no_ingresa").hide();
		}
	});
	if($("input[name=autorizacion_patrocinador]:checked").val() == 'No'){
		$("#tr_submit").hide();
		$("#tr_no_ingresa").show();			
	}
	else{
		$("#tr_submit").show();
		$("#tr_no_ingresa").hide();
	}

	$("#agregar_entrada").click(function(){
		$("#tabla").append("<tr><td><select name='tipo[]''><option value='' selected='selected'></option><option value='Inclusion'>Inclusión</option><option value='Exclusion'>Exclusión</option></select></td><td><input type='number' name='numero[]'  min='1'></td><td><textarea name='comentario[]' rows='3'></textarea></td></tr>");
	});
});
</script>
<legend style='text-align:center;'>Criterios de Inclusión/Exclusión</legend>
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
	if(isset($_SESSION['role_options']['query']) AND strstr($_SESSION['role_options']['query'], 'additional_form_query_new')){
		
?>
	<div id='new_query' style='text-align:right;'>
		<?= form_open('query/additional_form_query_new' , array('class'=>'form-horizontal')); ?>		
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('form', "Inclusion Exclusion"); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_button(array('type'=>'submit', 'content'=>'Query', 'class'=>'btn btn-primary')); ?>
		<?= form_close(); ?>
	</div>
<?php }?>

<?= form_open('subject/inclusion_update', array('class'=>'form-horizontal')); ?>    
	
	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>
	<?= form_hidden('id', $list[0]->id); ?>

    <?= my_validation_errors(validation_errors()); ?>

    <table class="table table-condensed table-bordered table-striped" id='tabla'>
           
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
		       $tipos = array(''=>'','Inclusion'=>'Inclusión','Exclusion'=>'Exclusión');  
	    ?>
	    <tr>
	        <td>El paciente cumple con los criterios de inclusión/exclusión: </td>
	        <td>
	        	<?= form_radio($data,$data['value'],set_radio($data['name'], 1, true)); ?> Si <br>
	        	<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO - Por favor reporte detalles más abajo
	        </td>
	    </tr>        

		<tr>
			<td colspan='3' style='font-weight:bold;'>Criterios de inclusión/ exclusión no respetados</td>			
		</tr>
		<tr>
			<td>Tipo de Criterio</td>
			<td># Numero de Criterio</td>
			<td>Comentarios</td>
		</tr>
		<?php if(isset($no_respetados) AND !empty($no_respetados)){ 
			foreach ($no_respetados as $v) { ?>
				
				<tr>
					<td>
						<?= form_hiden('inclusion_ids[]', $v->id); ?>
						<?= form_dropdown("tipo[]",$tipos,set_value('tipo', $v->tipo)); ?>
					</td>
					<td><?= form_input(array('type'=>'number','name'=>'numero[]', 'min'=>'1', 'value'=>set_value('numero', $v->numero))); ?></td>
					<td><?= form_textarea(array('name'=>'comentario[]','rows'=>'3', 'value'=>set_value('comentario', $v->comentario))); ?></td>
				</tr>
	<?php 	}
			
		

		}
		?>

	</table>
	<table class="table table-condensed table-bordered table-striped">
		<tr id='tr_agregar_entrada'>
			<td colspan='3' style='text-align:center;' class='btn' id='agregar_entrada'>Agregar entrada</td>
		</tr>
		<tr id='tr_autorizacion'>
			<td>Cuenta con la autorización del patrocinador para inclusión</td>
			<td>
				<?= form_radio('autorizacion_patrocinador','Si', set_radio('autorizacion_patrocinador', 'Si', (($list[0]->autorizacion_patrocinador == 'Si') ? true : false) )); ?> Si <br>
				<?= form_radio('autorizacion_patrocinador', 'No', set_radio('autorizacion_patrocinador', 'No', (($list[0]->autorizacion_patrocinador == 'No') ? true : false) )); ?> No <br>
				<?= form_radio('autorizacion_patrocinador', 'No Aplica', set_radio('autorizacion_patrocinador', 'No Aplica', (($list[0]->autorizacion_patrocinador == 'No Aplica') ? true : false) )); ?> No Aplica 
			</td>
		</tr>	
		
		<tr id='tr_no_ingresa'>
			<td colspan='2' style='background-color:red;font-weight:bold;'>NO se puede ingresar ningún sujeto sin la firma del Consentimiento Informado.</td>			
		</tr>

	    <tr id='tr_submit'>
	    	<td colspan='2' style='text-align:center;'>
				<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'inclusion_update')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
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
							if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'additional_form_query_show')){
						?>
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id, 'Responder',array('class'=>'btn'))); ?></td>						
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
	<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
		
		Formulario aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y",strtotime($list[0]->verify_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'inclusion_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/inclusion_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('id', $list[0]->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
			
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
	<?php if(!empty($list[0]->lock_user) AND !empty($list[0]->lock_date)){ ?>
		
		Formulario cerrado por <?= $subject->inclusion_lock_user;?> el <?= date("d-M-Y",strtotime($subject->inclusion_lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'inclusion_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/inclusion_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('id', $list[0]->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
			
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
	<?php if(!empty($list[0]->signature_user) AND !empty($list[0]->signature_date)){ ?>
		
		Formulario Firmado por <?= $list[0]->signature_user;?> on <?= date("d-M-Y",strtotime($list[0]->signature_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'inclusion_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/inclusion_signature', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('id', $list[0]->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Firma";
		}
	}
?>
<br />