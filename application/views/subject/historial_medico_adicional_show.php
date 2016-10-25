<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("input[name=realizado]").change(function(){
		if($(this).val() == 1){
			$(".punto2").show();
		}
		else{
			$(".punto2").hide();	
			$(".punto3").hide();
		}
	});

	if($("input[name=realizado]:checked").val() == 1){
		$(".punto2").show();
		$(".punto3").show();
	}

	$("#agregar_entrada").click(function(){
		$(".punto3").show();

		$("#tabla").append("<tr class='punto3'><td><textarea name='cambio[]' style='width:300px;height:100px;'></textarea></td><td><textarea name='comentario[]' style='width:300px;height:100px;'></textarea></td></tr>");
	});

});
</script>
		<legend style='text-align:center;'>Historia Médica VISITA BASAL</legend>
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

	<?= form_open('subject/historial_medico_adicional_update', array('class'=>'form-horizontal', 'id'=>'form_historial_medico_adicional')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('id', $list[0]->id); ?>
	<?= form_hidden('subject_id', $subject->id); ?>		

	<table class='table table-striped table-hover table-bordered table-condensed' id='tabla'>	
		<tbody>
			<tr>
				<td style='background-color:#ccc;' colspan='2'>¿EXISTEN CAMBIOS EN LA HISTORIA MÉDICA DEL SUJETO DESDE LA VISITA DE SELECCIÓN?</td>
			</tr>
			<tr>
				<td colspan='2'><?= form_radio('realizado',1,set_radio('realizado', 1, (($list[0]->realizado == 1) ? true : false) ));  ?> SI - Por favor reporte detalles más abajo</td>
			</tr>
			<tr>
				<td colspan='2'><?= form_radio('realizado',0,set_radio('realizado', 0, (($list[0]->realizado == 0) ? true : false)));  ?> No</td>
			</tr>
			<tr style='display:none;' class='punto2'>
				<td colspan='2' style='background-color:#ccc;'>Cambios en la historia médica desde la visita de selección</td>
			</tr>
			<tr id='entradas' class='punto2' style='display:none;'>
				<td colspan='2'><?= form_button(array('type'=>'button', 'content'=>'Agregar Entrada', 'class'=>'btn btn-info', 'id'=>'agregar_entrada')); ?></td>
			</tr>
			<tr class='punto3' style='display:none;background-color:#ccc;'>
				<td>Cambio(s)</td>
				<td>Comentarios</td>
			</tr>
			<?php if(isset($cambios) AND !empty($cambios)){
					foreach ($cambios as $v) { ?>
						<tr>
							<td>
								<input type='hidden' name='cambio_id[]' value='<?= $v->id;?>'>
								<textarea name='cambio[]' style='width:300px;height:100px;'><?= $v->cambio;?></textarea>
							</td>
							<td><textarea name='comentario[]' style='width:300px;height:100px;'><?= $v->comentario;?></textarea></td>
						</tr>						
			<?php }
			?>

			<?php } ?>
		</tbody>
	</table>
	<div style='text-align:center;'>
		<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
	</div>

	<?= form_close();?>
	<b>Creado por:</b> <?= $list[0]->usuario_creacion;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->created_at));?><br />&nbsp;</br>
<!-- Verify -->
<b>Aprobacion del Monitor:</b><br />
	<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
		
		Formulario aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->verify_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'historial_medico_adicional_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/historial_medico_adicional_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>		
		<?= form_hidden('current_status', $list[0]->status); ?>
		<?= form_hidden('id', $list[0]->id); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Verificar', 'class'=>'btn btn-primary')); ?>

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
		
		Formulario cerrado por <?= $list[0]->lock_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'historial_medico_adicional_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/historial_medico_adicional_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>		
		<?= form_hidden('current_status', $list[0]->status); ?>
		<?= form_hidden('id', $list[0]->id); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Cerrar', 'class'=>'btn btn-primary')); ?>

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
		
		Formulario Firmado por <?= $list[0]->signature_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->signature_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'historial_medico_adicional_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/historial_medico_adicional_signature', array('class'=>'form-horizontal')); ?>
		<?= form_hidden('subject_id', $subject->id); ?>		
		<?= form_hidden('current_status', $list[0]->status); ?>
		<?= form_hidden('id', $list[0]->id); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Firma";
		}
	}
?>
<br />
		
		

