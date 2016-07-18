<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha_visita, #fecha_ultima_dosis").datepicker({ dateFormat: 'dd/mm/yy' });

	$("select[name=motivo]").change(function(){
		if($(this).val() == 'Otro'){
			$("#tr_otro").show();
		}
		else{
			$("#tr_otro").hide();
		}
	});

	if($("select[name=motivo]").val() == 'Otro'){
		$("#tr_otro").show();
	}
	else{
		$("#tr_otro").hide();
	}
});
</script>
<legend style='text-align:center;'>Fin Tratamiento Temprano</legend>
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
<!-- New Query-->
<?php
	if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'additional_form_query_new')){
?>
	<div id='new_query' style='text-align:right;'>
		<?= form_open('query/additional_form_query_new', array('class'=>'form-horizontal')); ?>
		<?= form_hidden('subject_id', $subject->id); ?>		
		<?= form_hidden('form', "Fin Tratamiento Temprano"); ?>
		<?= form_button(array('type'=>'submit', 'content'=>'Query', 'class'=>'btn btn-primary')); ?>
		<?= form_close(); ?>
	</div>
<?php }?>
<!-- End Query-->
<?php
	if(isset($list) AND !empty($list)){
?>
<?= form_open('subject/fin_tratamiento_temprano_update', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>		
	<?= form_hidden('id', $list[0]->id); ?>	
	 
	<?php
			$no_aplica = array(
			    'name'        => 'no_aplica',
			    'id'          => 'no_aplica',
			    'value'       => '1',
			    'checked'     => set_checkbox('no_aplica','1', (($list[0]->no_aplica == 1) ? true : false))
		    );
		?>
	<table class="table table-bordered table-striper table-hover">
		<tr>
			<td>No aplica:</td>
			<td><?= form_checkbox($no_aplica);?></td>
		</tr>
		<tr>
			<td>Fecha Visita:</td>
			<td> <?= form_input(array('type'=>'text','name'=>'fecha_visita', 'id'=>'fecha_visita', 'value'=>set_value('fecha_visita', ((!empty($list[0]->fecha_visita) AND $list[0]->fecha_visita != '0000-00-00') ? date("d/m/Y",strtotime($list[0]->fecha_visita)) : "")))); ?></td>
		</tr>
		<tr>
			<td>Fecha ultima dosis: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha_ultima_dosis', 'id'=>'fecha_ultima_dosis', 'value'=>set_value('fecha_ultima_dosis', ((!empty($list[0]->fecha_ultima_dosis) AND $list[0]->fecha_ultima_dosis != '0000-00-00') ? date("d/m/Y",strtotime($list[0]->fecha_ultima_dosis)) : "")))); ?></td>
		</tr>
		<tr>
		<?php

			$motivo = array(''=>'',
							'Decisión del sujeto' =>'Decisión del sujeto',
							'Decisión del Investigador' =>'Decisión del Investigador',
							'Decisión del Patrocinador' =>'Decisión del Patrocinador',
							'Evento Adverso' =>'Evento Adverso',
							'Pérdida de seguimiento' =>'Pérdida de seguimiento',
							'Otro' =>'Otro'
					);

		?>

			<td>Motivo por el cual sujeto no terminó el estudio: </td>
			<td><?= form_dropdown("motivo",$motivo,set_value('motivo', $list[0]->motivo)); ?></td>
		</tr>
		<tr id='tr_otro' style='display:none;'>
			<td>Otro Motivo: </td>
			<td><?= form_input(array('type'=>'text','name'=>'otro_motivo', 'id'=>'otro_motivo', 'value'=>set_value('otro_motivo', $list[0]->otro_motivo))); ?></td>
		</tr>		
		<tr>
			<td colspan='2' style='text-align:center;'>
				<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_temprano_update')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
	        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
	        </td>
	    </tr>
	</table>
<?= form_close(); ?>
<?php }?>

<!-- Querys -->
<?php
	if(isset($querys) AND !empty($querys)){ ?>
		<b>Querys:</b>
		<table class="table table-condensed table-bordered table-stripped">
			<thead>
				<tr>
					<th>Fecha de Consulta</th>
								<th>Usuario</th>
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
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id .'/Fin Tratamiento Temprano', 'Responder',array('class'=>'btn'))); ?></td>						
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
			AND strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_temprano_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/fin_tratamiento_temprano_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
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
		
		Formulario cerrado por <?= $list[0]->lock_user;?> el <?= date("d-M-Y",strtotime($list[0]->lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_temprano_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/fin_tratamiento_temprano_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
		<?= form_hidden('id', $list[0]->id); ?>
			
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
			AND strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_temprano_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/fin_tratamiento_temprano_signature', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
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