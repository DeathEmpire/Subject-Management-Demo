<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#tomografia_fecha, #resonancia_fecha").datepicker({ dateFormat: 'dd/mm/yy' });	

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
		if($(this).val() == 1){
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
	if($("input[name=realizado]:checked").val() == 1){
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
<legend style='text-align:center;'>Resonancia Magnética o Tomografía Computarizada <?= $protocolo;?></legend>
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
<?= form_open('subject/rnm_insert', array('class'=>'form-horizontal', 'id'=>'form_rnm')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>			
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

		$no_aplica = array(
			    'name'        => 'realizado',
			    'id'          => 'realizado',
			    'value'       => '1',
			    'checked'     => set_checkbox('realizado','1')			    
		    );
	?>

	<table class='table table-striped table-bordered table-hover'>
		
		<?php 
			if($etapa != 1){
		?>
			<tr>
				<td>No aplica:</td>
				<td><?= form_checkbox($no_aplica);?></td>
			</tr>
		<?php }?>
		<thead>
			<tr>
				<th colspan='2'>Imágenes disponibles</th>
				<th>Fecha Examen</th>
				<th>Comentarios</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>¿Sujeto dispone de una Resonancia Magnética? </td>
				<td>
					<?= form_radio($data,$data['value'],set_radio($data['name'], 1)); ?> Si
					<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
				</td>
				<td><?= form_input(array('type'=>'text','name'=>'resonancia_fecha','id'=>'resonancia_fecha', 'value'=>set_value('resonancia_fecha'))); ?></td>
				<td><?= form_textarea(array('name'=>'resonancia_comentario', 'id'=>'resonancia_comentario','value'=>set_value('resonancia_comentario'),'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>¿Sujeto dispone de una Tomografía Computarizada?</td>
				<td>
					<?= form_radio($data3,$data3['value'],set_radio($data3['name'], 1)); ?> Si
					<?= form_radio($data4,$data4['value'],set_radio($data4['name'], 0)); ?> NO
				</td>
				<td><?= form_input(array('type'=>'text','name'=>'tomografia_fecha','id'=>'tomografia_fecha', 'value'=>set_value('tomografia_fecha'))); ?></td>
				<td><?= form_textarea(array('name'=>'tomografia_comentario', 'id'=>'tomografia_comentario','value'=>set_value('tomografia_comentario'),'rows'=>'5')); ?></td>
			</tr>
			<tr id='tr_repetir' style='display:none;'>
				<td colspan='4'>La fecha es superior a un año atrás, por favor recuerde repetir el examen antes de la visita basal</td>
			</tr>
			<tr id='tr_repetir_rnm' style='display:none;'>
				<td>¿Se solicita una RNM?</td>
				<td>
					<?= form_radio($data5,$data5['value'],set_radio($data5['name'], 1)); ?> Si
					<?= form_radio($data6,$data6['value'],set_radio($data6['name'], 0,true)); ?> NO
				</td>
				<td></td>
				<td></td>
			</tr>
			<tr id='tr_repetir_tc' style='display:none;'>
				<td>¿Se solicita un TC?</td>
				<td>
					<?= form_radio($data7,$data7['value'],set_radio($data7['name'], 1)); ?> Si
					<?= form_radio($data8,$data8['value'],set_radio($data8['name'], 0,true)); ?> NO
				</td>
				<td></td>
				<td></td>
			</tr>

			<?php if($etapa == 1){ ?>
				<tr>
					<td>Se solicita Tomografía computarizada para el estudio</td>
					<td>
						<?= form_radio('se_solicita_tomografia','Si', set_radio('se_solicita_tomografia','Si')); ?> Si
						<?= form_radio('se_solicita_tomografia','No',set_radio('se_solicita_tomografia','No')); ?> No	
						<?= form_radio('se_solicita_tomografia','No Aplica',set_radio('se_solicita_tomografia','No Aplica')); ?> No Aplica
					</td>
				</tr>
					
			<?php } else{ ?>
				<?= form_hidden('se_solicita_tomografia',''); ?>
			<?php }?>
			<tr>
				<td colspan='4' style='text-align:center;'>
					<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'rnm_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
		        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
				</td>
			</tr>
		</tbody>
	</table>

<?= form_close(); ?>