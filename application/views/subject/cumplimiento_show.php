<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker();

	$('#comprimidos_utilizados, #dias').change(function(){
		if($('#comprimidos_utilizados').val() != '' && $('#dias').val() != '')
		{
			var valor = ($('#comprimidos_utilizados').val() / 2 / $('#dias').val()) * 100;		
			$('#porcentaje_cumplimiento	').val(valor);
		}
	});

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_cumplimiento :input").attr('readonly','readonly');
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_cumplimiento :input").removeAttr('readonly');
		}
	});
	if($("input[name=realizado]:checked").val() == 0) {
		$("#form_cumplimiento :input").attr('readonly','readonly');
		$("input[name=realizado]").removeAttr('readonly');
	}else{
		$("#form_cumplimiento :input").removeAttr('readonly');
	}

	$("#comprimidos_entregados, #comprimidos_utilizados, #comprimidos_devueltos").change(function(){
		// if($("#comprimidos_entregados").val() != '' && $("#comprimidos_utilizados").val() != '' && $("#comprimidos_devueltos").val() != ''){
			var perdidos = 0;

			perdidos = parseInt($("#comprimidos_entregados").val()) - parseInt($("#comprimidos_utilizados").val()) - parseInt($("#comprimidos_devueltos").val());

			if(perdidos > 0){
				$("input[name=se_perdio_algun_comprimido][value=1]").prop("checked",true);
				$("#comprimidos_perdidos").val(perdidos);
			}else{
				$("input[name=se_perdio_algun_comprimido][value=0]").prop("checked",true);
				$("#comprimidos_perdidos").val(0);
			}
		// }
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
<!-- New Query-->
<?php
	if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'additional_form_query_new')){
?>
	<div id='new_query' style='text-align:right;'>
		<?= form_open('query/additional_form_query_new', array('id'=>'form_cumplimiento')); ?>
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('form', "Cumplimiento"); ?>
		<?= form_button(array('type'=>'submit', 'content'=>'Nueva Consulta', 'class'=>'btn btn-primary')); ?>
		<?= form_close(); ?>
	</div>
<?php }?>
<!-- End Query-->
<?php
	if(isset($list) AND !empty($list)){
?>	
<?= form_open('subject/cumplimiento_update', array('class'=>'form-horizontal','id'=>'form_cumplimiento')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('etapa', $etapa); ?>	
	<?= form_hidden('id', $list[0]->id); ?>
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
				<?= form_radio($data,$data['value'],set_radio($data['name'], 1, (($list[0]->realizado == 1) ? true : false))); ?> Si
				<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0, (($list[0]->realizado == 0) ? true : false))); ?> NO
			</td>
		</tr>
		<tr>
			<td>Fecha: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', $list[0]->fecha))); ?></td>
		</tr>
		<tr>
			<td>Numero cápsulas entregadas: </td>
			<td><?= form_input(array('type'=>'text','name'=>'comprimidos_entregados', 'id'=>'comprimidos_entregados', 'maxlength'=>'3','value'=>set_value('comprimidos_entregados', $list[0]->comprimidos_entregados))); ?></td>
		</tr>
		<tr>
			<td>Numero cápsulas utilizadas: </td>
			<td><?= form_input(array('type'=>'text','name'=>'comprimidos_utilizados', 'id'=>'comprimidos_utilizados', 'maxlength'=>'3','value'=>set_value('comprimidos_utilizados', $list[0]->comprimidos_utilizados))); ?></td>
		</tr>
		<tr>
			<td>Numero cápsulas devueltas: </td>
			<td><?= form_input(array('type'=>'text','name'=>'comprimidos_devueltos', 'id'=>'comprimidos_devueltos', 'maxlength'=>'3','value'=>set_value('comprimidos_devueltos', $list[0]->comprimidos_devueltos))); ?></td>
		</tr>
		<tr>

		<?php
       		$si = array(
			    'name'        => 'se_perdio_algun_comprimido',			    
			    'value'       => 1,		    			    
			    'checked'     => set_radio('se_perdio_algun_comprimido', 1, (($list[0]->se_perdio_algun_comprimido == 1) ? true : false))
			    );
	   		$no = array(
			    'name'        => 'se_perdio_algun_comprimido',			    
			    'value'       => 0,	
			    'checked'     => set_radio('se_perdio_algun_comprimido', 0, (($list[0]->se_perdio_algun_comprimido == 0) ? true : false))
			    );
       	?>
			<td>Se perdio alguna cápsula: </td>
			<td><?= form_radio($si); ?> Si <?= form_radio($no); ?> No
		</tr>
		<tr>		
			<td>Número de cápsulas perdidas: </td>
			<td><?= form_input(array('type'=>'text','name'=>'comprimidos_perdidos', 'id'=>'comprimidos_perdidos', 'maxlength'=>'3','value'=>set_value('comprimidos_perdidos', $list[0]->comprimidos_perdidos))); ?></td>
		</tr>
		<tr>
			<td>Días (desde entrega anterior hasta Día de visita): </td>
			<td><?= form_input(array('type'=>'text','name'=>'dias', 'id'=>'dias', 'maxlength'=>'3','value'=>set_value('dias', $list[0]->dias))); ?></td>
		</tr>
		<tr>
			<td>% cumplimiento: </td>
			<td><?= form_input(array('type'=>'text','name'=>'porcentaje_cumplimiento', 'id'=>'porcentaje_cumplimiento', 'maxlength'=>'3','value'=>set_value('porcentaje_cumplimiento', $list[0]->porcentaje_cumplimiento))); ?></td>
		</tr>
		<tr>
			<td colspan='2' style='text-align:center;'>
				<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'cumplimiento_update')){
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
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id .'/Cumplimiento', 'Responder',array('class'=>'btn'))); ?></td>						
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
			AND strpos($_SESSION['role_options']['subject'], 'cumplimiento_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/cumplimiento_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
			
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
			AND strpos($_SESSION['role_options']['subject'], 'cumplimiento_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/cumplimiento_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
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
			AND strpos($_SESSION['role_options']['subject'], 'cumplimiento_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/cumplimiento_signature', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiene de Firma";
		}
	}
?>
<br />