<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
restaFechas = function(f1,f2)
 {
 var aFecha1 = f1.split('-'); 
 var aFecha2 = f2.split('-'); 
 var fFecha1 = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]); 
 var fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]); 
 var dif = fFecha2 - fFecha1;
 var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
 return dias;
 }



$(function(){
	$("#tomografia_fecha, #resonancia_fecha").datepicker({dateFormat: 'dd/mm/dd'});	

	$("input[name=tomografia]").change(function(){
		if($(this).val() == 0){
			$("#tomografia_fecha").attr('readonly','readonly');
			$("#tomografia_fecha").attr('disabled','disabled');
			$("#tomografia_comentario").attr('readonly','readonly');			

		}else{
			$("#tomografia_fecha").removeAttr('readonly');
			$("#tomografia_fecha").removeAttr('disabled');
			$("#tomografia_comentario").removeAttr('readonly');
		}
	});
	if($("input[name=tomografia]:checked").val() == 0){
		$("#tomografia_fecha").attr('readonly','readonly');
		$("#tomografia_fecha").attr('disabled','disabled');
		$("#tomografia_comentario").attr('readonly','readonly');			

	}else{
		$("#tomografia_fecha").removeAttr('readonly');
		$("#tomografia_fecha").removeAttr('disabled');
		$("#tomografia_comentario").removeAttr('readonly');
	}

	$("input[name=resonancia]").change(function(){
		if($(this).val() == 0){
			$("#resonancia_fecha").attr('readonly','readonly');
			$("#resonancia_fecha").attr('disabled','disabled');
			$("#resonancia_comentario").attr('readonly','readonly');			

		}else{
			$("#resonancia_fecha").removeAttr('readonly');
			$("#resonancia_fecha").removeAttr('disabled');
			$("#resonancia_comentario").removeAttr('readonly');
		}
	});
	if($("input[name=resonancia]:checked").val() == 0){
		$("#resonancia_fecha").attr('readonly','readonly');
		$("#resonancia_fecha").attr('disabled','disabled');
		$("#resonancia_comentario").attr('readonly','readonly');			

	}else{
		$("#resonancia_fecha").removeAttr('readonly');
		$("#resonancia_fecha").removeAttr('disabled');
		$("#resonancia_comentario").removeAttr('readonly');
	}
	
	$("#resonancia_fecha, #tomografia_fecha").change(function(){

		var dias = restaFechas($(this).val(),'<?php echo date("Y-m-d");?>');
		if(dias >= 365){
			$('#tr_repetir').show();			
			$('#tr_repetir_rnm').show();
			$('#tr_repetir_tc').show();		
		}
	});

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_rnm :input").attr('readonly','readonly');
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_rnm :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled', 'disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_rnm :input").attr('readonly','readonly');
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_rnm :input").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled', 'disabled');
		});
	}

});
</script>
<legend style='text-align:center;'>Resonancia Magnética o Tomografía Computarizada</legend>
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
<?= form_open('subject/rnm_update', array('class'=>'form-horizontal', 'id'=>'form_rnm')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('id', $list[0]->id); ?>
	<?= form_hidden('etapa', $etapa); ?>
	<?php
		$data = array(
			    'name'        => 'resonancia',			    
			    'value'       => 1,		    			    
		    );
	  	$data2 = array(
		    'name'        => 'resonancia',			    
		    'value'       => 0,		    
		    );	   
	  	$data3 = array(
			    'name'        => 'tomografia',			    
			    'value'       => 1,		    			    
		    );
	  	$data4 = array(
		    'name'        => 'tomografia',			    
		    'value'       => 0,		    
		    );
	  	$data5 = array(
			    'name'        => 'repetir_rnm',			    
			    'value'       => 1,		    			    
		    );
	  	$data6 = array(
		    'name'        => 'repetir_rnm',			    
		    'value'       => 0,		    
		    );
	  	$data7 = array(
			    'name'        => 'repetir_tc',			    
			    'value'       => 1,		    			    
		    );
	  	$data8 = array(
		    'name'        => 'repetir_tc',			    
		    'value'       => 0,		    
		    );
	  	$data9 = array(
			    'name'        => 'realizado',			    
			    'value'       => 1,		    
			    #'checked'	  => set_radio('gender', 'male', TRUE),
		    );
	  	$data10 = array(
		    'name'        => 'realizado',			    
		    'value'       => 0,
		    #'checked'	  => set_radio('gender', 'female', TRUE),		    
		    );
	?>

	<table class='table table-striped table-bordered table-hover'>
		<tr>
			<td>Realizado</td>
			<td>
				<?= form_radio($data9,$data9['value'],set_radio($data9['name'], 1, (($list[0]->realizado == 1) ? true : false))); ?> Si
				<?= form_radio($data10,$data10['value'],set_radio($data10['name'], 0, (($list[0]->realizado == 0) ? true : false))); ?> NO
			</td>
		</tr>
		<thead>
			<tr>
				<th colspan='2'>Imágenes disponibles</th>
				<th>Fecha Examen</th>
				<th>Comentarios</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>¿Se realizó una Resonancia Magnética? </td>
				<td>
					<?= form_radio($data,$data['value'],set_radio($data['name'], 1, (($list[0]->resonancia == 1) ? true : false))); ?> Si
					<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0, (($list[0]->resonancia == 0) ? true : false))); ?> NO
				</td>
				<td><?= form_input(array('type'=>'text','name'=>'resonancia_fecha','id'=>'resonancia_fecha', 'value'=>set_value('resonancia_fecha', ((!empty($list[0]->resonancia_fecha) AND $list[0]->resonancia_fecha != '0000-00-00') ? date("d/m/Y",strtotime($list[0]->resonancia_fecha)) : "")))); ?></td>
				<td><?= form_textarea(array('name'=>'resonancia_comentario', 'id'=>'resonancia_comentario','value'=>set_value('resonancia_comentario', $list[0]->resonancia_comentario),'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>¿Se realizó una Tomografía Computarizada?</td>
				<td>
					<?= form_radio($data3,$data3['value'],set_radio($data3['name'], 1, (($list[0]->tomografia == 1) ? true : false))); ?> Si
					<?= form_radio($data4,$data4['value'],set_radio($data4['name'], 0, (($list[0]->tomografia == 0) ? true : false))); ?> NO
				</td>
				<td><?= form_input(array('type'=>'text','name'=>'tomografia_fecha','id'=>'tomografia_fecha', 'value'=>set_value('tomografia_fecha', ((!empty($list[0]->tomografia_fecha) AND $list[0]->tomografia_fecha != '0000-00-00') ? date("d/m/Y",strtotime($list[0]->tomografia_fecha)) : "")))); ?></td>
				<td><?= form_textarea(array('name'=>'tomografia_comentario', 'id'=>'tomografia_comentario','value'=>set_value('tomografia_comentario', $list[0]->tomografia_comentario),'rows'=>'5')); ?></td>
			</tr>
			<tr id='tr_repetir' style='display:none;'>
				<td colspan='4'>La fecha es superior a un año atrás, por favor recuerde repetir el examen antes de la visita basal</td>
			</tr>
			<tr id='tr_repetir_rnm' style='display:none;'>
				<td>¿Se solicita una RNM?</td>
				<td>
					<?= form_radio($data5,$data5['value'],set_radio($data5['name'], 1, (($list[0]->repetir_rnm == 1) ? true : false))); ?> Si
					<?= form_radio($data6,$data6['value'],set_radio($data6['name'], 0, (($list[0]->repetir_rnm == 0) ? true : false))); ?> NO
				</td>
				<td></td>
				<td></td>
			</tr>
			<tr id='tr_repetir_tc' style='display:none;'>
				<td>¿Se solicita un TC?</td>
				<td>
					<?= form_radio($data7,$data7['value'],set_radio($data7['name'], 1, (($list[0]->repetir_tc == 1) ? true : false))); ?> Si
					<?= form_radio($data8,$data8['value'],set_radio($data8['name'], 0, (($list[0]->repetir_tc == 0) ? true : false))); ?> NO
				</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td colspan='4' style='text-align:center;'>
					<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'rnm_update')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
		        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
				</td>
			</tr>
		</tbody>
	</table>

<?= form_close(); ?>
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
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id .'/RNM', 'Responder',array('class'=>'btn'))); ?></td>						
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
			AND strpos($_SESSION['role_options']['subject'], 'rnm_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/rnm_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('id', $list[0]->id); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
		<?= form_hidden('etapa', $etapa); ?>
			
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
			AND strpos($_SESSION['role_options']['subject'], 'rnm_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/rnm_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('id', $list[0]->id); ?>	
		<?= form_hidden('current_status', $list[0]->status); ?>
		<?= form_hidden('etapa', $etapa); ?>
			
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
			AND strpos($_SESSION['role_options']['subject'], 'rnm_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/rnm_signature', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('id', $list[0]->id); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
		<?= form_hidden('etapa', $etapa); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Firma";
		}
	}
?>
<br />