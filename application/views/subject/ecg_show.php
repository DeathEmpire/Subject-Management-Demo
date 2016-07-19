<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_ecg :input").attr('readonly','readonly');
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});			
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_ecg :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled', 'disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_ecg :input").attr('readonly','readonly');
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_ecg :input").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled', 'disabled');
		});
	}
});
</script>
<legend style='text-align:center;'>Electrocardiograma de reposo (ECG)</legend>
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
		<?= form_hidden('form', "ECG"); ?>
		<?= form_button(array('type'=>'submit', 'content'=>'Query', 'class'=>'btn btn-primary')); ?>
		<?= form_close(); ?>
	</div>
<?php }?>
<!-- End Query-->
<?php
	if(isset($list) AND !empty($list)){
?>
<?= form_open('subject/ecg_update', array('class'=>'form-horizontal','id'=>'form_ecg')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
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
	
		Realizado:
		<?= form_radio($data,$data['value'],set_radio($data['name'], 1, (($list[0]->realizado == 1) ? true : false) )); ?> Si
		<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0, (($list[0]->realizado == 0) ? true : false) ) ) ; ?> NO
		<br />
		Fecha: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', ((!empty($list[0]->fecha) AND $list[0]->fecha !='0000-00-00') ? date("d/m/Y", strtotime($list[0]->fecha)) : "") ))); ?>


		<table class='table table-striped table-hover table-bordered table-condensed'>
			<thead>
				<tr>
					<th></th>
					<th></th>
					<th></th>
					<th>Normal - Anormal</th>				
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Ritmo Sinusal</td>
					<td><?= form_radio('ritmo_sinusal', 1, set_radio('ritmo_sinusal', 1, (($list[0]->ritmo_sinusal == 1) ? true : false))); ?> Si</td>
					<td><?= form_radio('ritmo_sinusal', 0, set_radio('ritmo_sinusal', 0, (($list[0]->ritmo_sinusal == 0) ? true : false))); ?> No</td>
					<td>
						<?= form_radio('ritmo_sinusal_normal_anormal', 1, set_radio('ritmo_sinusal_normal_anormal', 1, (($list[0]->ritmo_sinusal_normal_anormal == 1) ? true : false))); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('ritmo_sinusal_normal_anormal', 0, set_radio('ritmo_sinusal_normal_anormal', 0, (($list[0]->ritmo_sinusal_normal_anormal == 0) ? true : false))); ?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>Resultado</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>FC</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'fc', 'id'=>'fc', 'value'=>set_value('fc', $list[0]->fc))); ?></td>
					<td>Lat/min</td>
					<td>
						<?= form_radio('fc_normal_anormal', 1, set_radio('fc_normal_anormal', 1, (($list[0]->fc_normal_anormal == 1) ? true : false))); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('fc_normal_anormal', 0, set_radio('fc_normal_anormal', 0, (($list[0]->fc_normal_anormal == 0) ? true : false))); ?>
					</td>
				</tr>
				<tr>
					<td>PR</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'pr', 'id'=>'pr', 'value'=>set_value('pr', $list[0]->pr))); ?></td>
					<td>ms</td>
					<td>
						<?= form_radio('pr_normal_anormal', 1, set_radio('pr_normal_anormal', 1, (($list[0]->pr_normal_anormal == 1) ? true : false))); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('pr_normal_anormal', 0, set_radio('pr_normal_anormal', 0, (($list[0]->pr_normal_anormal == 0) ? true : false))); ?>
					</td>
				</tr>
				<tr>
					<td>QRS</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'qrs', 'id'=>'qrs', 'value'=>set_value('qrs', $list[0]->qrs))); ?></td>
					<td>ms</td>
					<td>
						<?= form_radio('qrs_normal_anormal', 1, set_radio('qrs_normal_anormal', 1, (($list[0]->qrs_normal_anormal == 1) ? true : false))); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('qrs_normal_anormal', 0, set_radio('qrs_normal_anormal', 0, (($list[0]->qrs_normal_anormal == 0) ? true : false))); ?>
					</td>
				</tr>
				<tr>
					<td>QT</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'qt', 'id'=>'qt', 'value'=>set_value('qt', $list[0]->qt))); ?></td>
					<td>ms</td>
					<td>
						<?= form_radio('qt_normal_anormal', 1, set_radio('qt_normal_anormal', 1, (($list[0]->qt_normal_anormal == 1) ? true : false))); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('qt_normal_anormal', 0, set_radio('qt_normal_anormal', 0, (($list[0]->qt_normal_anormal == 0) ? true : false))); ?>
					</td>
				</tr>
				<tr>
					<td>QTc</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'qtc', 'id'=>'qtc', 'value'=>set_value('qtc', $list[0]->qtc))); ?></td>
					<td>ms</td>
					<td>
						<?= form_radio('qtc_normal_anormal', 1, set_radio('qtc_normal_anormal', 1, (($list[0]->qtc_normal_anormal == 1) ? true : false))); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('qtc_normal_anormal', 0, set_radio('qtc_normal_anormal', 0, (($list[0]->qtc_normal_anormal == 0) ? true : false))); ?>
					</td>
				</tr>
				<tr>
					<td>Eje QRS</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'qrs2', 'id'=>'qrs2', 'value'=>set_value('qrs2', $list[0]->qrs2))); ?></td>
					<td>°</td>
					<td>
						<?= form_radio('qrs2_normal_anormal', 1, set_radio('qrs2_normal_anormal', 1, (($list[0]->qrs2_normal_anormal == 1) ? true : false))); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('qrs2_normal_anormal', 0, set_radio('qrs2_normal_anormal', 0, (($list[0]->qrs2_normal_anormal == 0) ? true : false))); ?>
					</td>
				</tr>
				<tr>
					<td colspan='3'>INTERPRETACIÓN ECG:</td>
					<td><?= form_radio('interpretacion_ecg', 1, set_radio('interpretacion_ecg', 1, (($list[0]->interpretacion_ecg == 1) ? true : false))); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('interpretacion_ecg', 0, set_radio('interpretacion_ecg', 0, (($list[0]->interpretacion_ecg == 0) ? true : false))); ?>
					</td>
				</tr>
				<tr>
					<td>Comentarios: </td>		
					<td colspan='3'>
						<?= form_textarea(array('name'=>'comentarios', 'id'=>'comentarios', 'value'=>set_value('comentarios', $list[0]->comentarios), 'rows'=>'4','cols'=>'40')); ?>
					</td>
				</tr>
			
				<tr>
					<td colspan='4' style='text-align:center;'>
						<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'ecg_update')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
	            		<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
	            	</td>
				</tr>
			</tbody>
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
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id .'/ECG', 'Responder',array('class'=>'btn'))); ?></td>						
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
			AND strpos($_SESSION['role_options']['subject'], 'ecg_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/ecg_verify', array('class'=>'form-horizontal')); ?>    	
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
		
		Formulario cerrado por <?= $list[0]->lock_user;?> el <?= date("d-M-Y",strtotime($list[0]->lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'ecg_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/ecg_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>		
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
			AND strpos($_SESSION['role_options']['subject'], 'ecg_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/ecg_signature', array('class'=>'form-horizontal')); ?>    	
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