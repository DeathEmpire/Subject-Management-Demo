<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker();

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_signos :input").attr('readonly','readonly');
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_signos :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled', 'disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_signos :input").attr('readonly','readonly');
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_signos :input").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled', 'disabled');
		});
	}

	$("#peso, #estatura").change(function(){
		if($("#peso").val() != '' && $("#estatura").val() != ''){
			var estatura2 = Math.pow($("#estatura").val(),2);
			var peso = $("#peso").val();
			var imc = (peso / estatura2) * 10000;
			$("#imc").val(imc.toFixed(2));
		}
	});
	if($("#peso").val() != '' && $("#estatura").val() != ''){
		var estatura2 = Math.pow($("#estatura").val(),2);
		var peso = $("#peso").val();
		var imc = (peso / estatura2) * 10000;
		$("#imc").val(imc.toFixed(2));
	}
});
</script>
<legend style='text-align:center;'>Signos Vitales</legend>
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
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('form', "Signos Vitales"); ?>		
		<?= form_button(array('type'=>'submit', 'content'=>'Query', 'class'=>'btn btn-primary')); ?>
		<?= form_close(); ?>
	</div>
<?php }?>
<!-- End Query-->
<?php
	if(isset($list) AND !empty($list)){
?>	
<?= form_open('subject/signos_vitales_update', array('class'=>'form-horizontal','id'=>'form_signos')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('etapa', $etapa); ?>	
	<?= form_hidden('id', $list[0]->id); ?>
	
	<?php
		$data = array(
			    'name'        => 'realizado',			    
			    'value'       => 1,		    			    
		    );
	  	$data2 = array(
		    'name'        => 'realizado',			    
		    'value'       => 0,		    
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
		<?php
			if(isset($etapa) AND $etapa == 1){
		?>
		<tr>
			<td>Estatura: </td>
			<td><?= form_input(array('type'=>'text','name'=>'estatura', 'id'=>'estatura', 'maxlenght'=>'3','value'=>set_value('estatura', $list[0]->estatura))); ?> cms</td>
		</tr>
		<?php }else{ ?>
			
				<?= form_hidden('estatura', ''); ?>

		<?php }?>
		<tr>
			<td>Presion Sistolica: </td>
			<td><?= form_input(array('type'=>'text','name'=>'presion_sistolica', 'id'=>'presion_sistolica', 'maxlenght'=>'3','value'=>set_value('presion_sistolica', $list[0]->presion_sistolica))); ?> mmHg</td>
		</tr>
		<tr>
			<td>Presion Diastolica: </td>
			<td><?= form_input(array('type'=>'text','name'=>'presion_diastolica', 'id'=>'presion_diastolica', 'maxlenght'=>'3','value'=>set_value('presion_diastolica', $list[0]->presion_diastolica))); ?> mmHg</td>
		</tr>
		<tr>	
			<td>Frecuencia Cardiaca: </td>
			<td><?= form_input(array('type'=>'text','name'=>'frecuencia_cardiaca', 'id'=>'frecuencia_cardiaca', 'maxlenght'=>'3','value'=>set_value('frecuencia_cardiaca', $list[0]->frecuencia_cardiaca))); ?> latidos/minuto</td>
		</tr>
		<tr>
			<td>Frecuencia Respiratoria: </td>
			<td><?= form_input(array('type'=>'text','name'=>'frecuencia_respiratoria', 'id'=>'frecuencia_respiratoria', 'maxlenght'=>'3','value'=>set_value('frecuencia_respiratoria', $list[0]->frecuencia_respiratoria))); ?> minuto</td>
		</tr>
		<tr>
			<td>Temperatura: </td>
			<td><?= form_input(array('type'=>'text','name'=>'temperatura', 'id'=>'temperatura', 'maxlenght'=>'3','value'=>set_value('temperatura', $list[0]->temperatura))); ?> °C</td>
		</tr>
		<tr>
			<td>Peso: </td>
			<td><?= form_input(array('type'=>'text','name'=>'peso', 'id'=>'peso', 'maxlenght'=>'3','value'=>set_value('peso', $list[0]->peso))); ?> kgs</td>
		</tr>
		<?php
			if(isset($etapa) AND $etapa == 1){
		?>
			<tr>
				<td>IMC: </td>
				<td><?= form_input(array('type'=>'text','name'=>'imc', 'id'=>'imc', 'maxlenght'=>'3','value'=>set_value('imc'))); ?></td>
			</tr>
		<?php }else{ ?>
			
				<?= form_hidden('imc', ''); ?>

		<?php }?>
		<tr>
			<td colspan='2' style='text-align:center;'>
				<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'signos_vitales_update')){
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
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id .'/Signos Vitales', 'Responder',array('class'=>'btn'))); ?></td>						
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
			AND strpos($_SESSION['role_options']['subject'], 'signos_vitales_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/signos_vitales_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('id', $list[0]->id); ?>
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
			AND strpos($_SESSION['role_options']['subject'], 'signos_vitales_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/signos_vitales_lock', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'signos_vitales_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/signos_vitales_signature', array('class'=>'form-horizontal')); ?>    	
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