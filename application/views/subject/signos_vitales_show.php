<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

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

	$("#query_para_campos").dialog({
		autoOpen: false,
		height: 340,
		width: 550
	});

	$(".query").click(function(){
		var campo = $(this).attr('id').split("_query");
		$.post("<?php echo base_url('query/query'); ?>",
			{
				'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>', 
				"campo": campo[0], 
				"etapa": "<?php echo $etapa;?>",
				"subject_id": $("input[name=subject_id]").val(),
				"form": "signos_vitales",
				"tipo": $(this).attr('tipo')
			},
			function(d){
				
				$("#query_para_campos").html(d);
				$("#query_para_campos").dialog('open');
			}
		);
	});
});
</script>
<?php
	switch($etapa){
		case 1 : $protocolo = "(Selección)"; break;
		case 2 : $protocolo = "(Basal Día 1)"; break;
		case 3 : $protocolo = "(Semana 4)"; break;
		case 4 : $protocolo = "(Semana 12)"; break;
		case 5 : $protocolo = "(Término del Estudio)"; break;
		case 6 : $protocolo = "(Terminación Temprana)"; break;
		default : $protocolo = ""; break;
	}
?>
<div id='query_para_campos' style='display:none;'></div>
<legend style='text-align:center;'>Signos Vitales <?= $protocolo;?></legend>
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
			<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', ((!empty($list[0]->fecha) AND $list[0]->fecha !='0000-00-00') ? date("d/m/Y", strtotime($list[0]->fecha)) : "") ))); ?>
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("fecha", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";	
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_update')){
							echo "<img src='". base_url('img/question.png') ."' id='fecha_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
		</tr>
		<?php
			if(isset($etapa) AND $etapa == 1){
		?>
		<tr>
			<td>Estatura: </td>
			<td><?= form_input(array('type'=>'text','name'=>'estatura', 'id'=>'estatura', 'maxlength'=>'3','value'=>set_value('estatura', $list[0]->estatura))); ?> cms
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("estatura", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_verify')){
							echo "<img src='". base_url('img/icon-check.png') ."' id='estatura_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";	
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_update')){
							echo "<img src='". base_url('img/question.png') ."' id='estatura_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
		</tr>
		<?php }else{ ?>
			
				<?= form_hidden('estatura', ''); ?>

		<?php }?>
		<tr>
			<td>Presion Sistolica: </td>
			<td><?= form_input(array('type'=>'text','name'=>'presion_sistolica', 'id'=>'presion_sistolica', 'maxlength'=>'3','value'=>set_value('presion_sistolica', $list[0]->presion_sistolica))); ?> mmHg 
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("presion_sistolica", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_verify')){
							echo "<img src='". base_url('img/icon-check.png') ."' id='presion_sistolica_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";	
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_update')){
							echo "<img src='". base_url('img/question.png') ."' id='presion_sistolica_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
		</tr>
		<tr>
			<td>Presion Diastolica: </td>
			<td><?= form_input(array('type'=>'text','name'=>'presion_diastolica', 'id'=>'presion_diastolica', 'maxlength'=>'3','value'=>set_value('presion_diastolica', $list[0]->presion_diastolica))); ?> mmHg 
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("presion_diastolica", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_verify')){
							echo "<img src='". base_url('img/icon-check.png') ."' id='presion_diastolica_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";	
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_update')){
							echo "<img src='". base_url('img/question.png') ."' id='presion_diastolica_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
		</tr>
		<tr>	
			<td>Frecuencia Cardiaca: </td>
			<td><?= form_input(array('type'=>'text','name'=>'frecuencia_cardiaca', 'id'=>'frecuencia_cardiaca', 'maxlength'=>'3','value'=>set_value('frecuencia_cardiaca', $list[0]->frecuencia_cardiaca))); ?> latidos/minuto 
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("frecuencia_cardiaca", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_verify')){
							echo "<img src='". base_url('img/icon-check.png') ."' id='frecuencia_cardiaca_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";	
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_update')){
							echo "<img src='". base_url('img/question.png') ."' id='frecuencia_cardiaca_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
		</tr>
		<tr>
			<td>Frecuencia Respiratoria: </td>
			<td><?= form_input(array('type'=>'text','name'=>'frecuencia_respiratoria', 'id'=>'frecuencia_respiratoria', 'maxlength'=>'3','value'=>set_value('frecuencia_respiratoria', $list[0]->frecuencia_respiratoria))); ?> minuto 
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("frecuencia_respiratoria", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_verify')){
							echo "<img src='". base_url('img/icon-check.png') ."' id='frecuencia_respiratoria_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";	
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_update')){
							echo "<img src='". base_url('img/question.png') ."' id='frecuencia_respiratoria_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
		</tr>
		<tr>
			<td>Temperatura: </td>
			<td><?= form_input(array('type'=>'text','name'=>'temperatura', 'id'=>'temperatura', 'maxlength'=>'3','value'=>set_value('temperatura', $list[0]->temperatura))); ?> °C 
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("temperatura", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_verify')){
							echo "<img src='". base_url('img/icon-check.png') ."' id='temperatura_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";	
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_update')){
								echo "<img src='". base_url('img/question.png') ."' id='temperatura_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
		</tr>
		<tr>
			<td>Peso: </td>
			<td><?= form_input(array('type'=>'text','name'=>'peso', 'id'=>'peso', 'maxlength'=>'3','value'=>set_value('peso', $list[0]->peso))); ?> kgs 
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("peso", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_verify')){
							echo "<img src='". base_url('img/icon-check.png') ."' id='peso_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";	
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_update')){
								echo "<img src='". base_url('img/question.png') ."' id='peso_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?></td>
		</tr>
		<?php
			if(isset($etapa) AND $etapa == 1){
		?>
			<tr>
				<td>IMC: </td>
				<td><?= form_input(array('type'=>'text','name'=>'imc', 'id'=>'imc', 'maxlength'=>'3','value'=>set_value('imc'))); ?>
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("imc", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_verify')){
							echo "<img src='". base_url('img/icon-check.png') ."' id='imc_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";	
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'signos_vitales_update')){
								echo "<img src='". base_url('img/question.png') ."' id='imc_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
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