<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name=hallazgo]").click(function(){
		if($(this).val() == 1){
			//todos los campos habilitados.
			$("input:radio").removeAttr("readonly");
			$("input:radio").removeAttr("disabled");
		}
		else{
			//todos los campos bloqueados.
			$("input:radio").attr("readonly","readonly");
			$("input:radio").attr("disabled","disabled");			

			$("input[name=hallazgo]").removeAttr("readonly");
			$("input[name=hallazgo]").removeAttr("disabled");

		}
	});

	$("input[name=tuvo_cambios]").change(function(){
		if($(this).val() == 1)
		{
			$("#tr_observaciones").show();
		}else{
			$("#tr_observaciones").hide();
			$("#cambios_observaciones").val('');
		}
	});
	if($("input[name=tuvo_cambios]:checked").val() == 1)
	{
		$("#tr_observaciones").show();
	}else{
		$("#tr_observaciones").hide();
		$("#cambios_observaciones").val('');
	}

	$("input[name=aspecto_general]").change(function(){		
		if($(this).val() == 1){
			// alert(122);
			$("textarea[name=aspecto_general_desc]").prop('readonly', true);			
		}
		else{
			$("textarea[name=aspecto_general_desc]").removeAttr('readonly');	
		}
	});
	
	$("input[name=piel]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=piel_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=piel_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=cabeza]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=cabeza_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=cabeza_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=ojos]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=ojos_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=ojos_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=nariz]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=nariz_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=nariz_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=boca]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=boca_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=boca_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=oidos]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=oidos_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=oidos_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=cuello]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=cuello_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=cuello_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=pulmones]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=pulmones_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=pulmones_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=cardiovascular]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=cardiovascular_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=cardiovascular_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=abdomen]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=abdomen_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=abdomen_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=muscular]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=muscular_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=muscular_desc]").removeAttr('readonly');	
		}
	});

	/*-----------------------------*/
	
	if($("input[name=aspecto_general]:checked").val() == 1){			
		$("textarea[name=aspecto_general_desc]").prop('readonly', true);			
	}
	else{
		$("textarea[name=aspecto_general_desc]").removeAttr('readonly');	
	}
	
	if($("input[name=piel]:checked").val() == 1){
		$("textarea[name=piel_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=piel_desc]").removeAttr('readonly');	
	}
	

	if($("input[name=cabeza]:checked").val() == 1){
		$("textarea[name=cabeza_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=cabeza_desc]").removeAttr('readonly');	
	}


	if($("input[name=ojos]:checked").val() == 1){
		$("textarea[name=ojos_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=ojos_desc]").removeAttr('readonly');	
	}


	if($("input[name=nariz]:checked").val() == 1){
		$("textarea[name=nariz_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=nariz_desc]").removeAttr('readonly');	
	}


	if($("input[name=boca]:checked").val() == 1){
		$("textarea[name=boca_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=boca_desc]").removeAttr('readonly');	
	}


	if($("input[name=oidos]:checked").val() == 1){
		$("textarea[name=oidos_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=oidos_desc]").removeAttr('readonly');	
	}

	
	if($("input[name=cuello]:checked").val() == 1){
		$("textarea[name=cuello_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=cuello_desc]").removeAttr('readonly');	
	}
	

	if($("input[name=pulmones]:checked").val() == 1){
		$("textarea[name=pulmones_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=pulmones_desc]").removeAttr('readonly');	
	}


	if($("input[name=cardiovascular]:checked").val() == 1){
		$("textarea[name=cardiovascular_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=cardiovascular_desc]").removeAttr('readonly');	
	}


	if($("input[name=abdomen]:checked").val() == 1){
		$("textarea[name=abdomen_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=abdomen_desc]").removeAttr('readonly');	
	}

	
	if($("input[name=muscular]:checked").val() == 1){
		$("textarea[name=muscular_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=muscular_desc]").removeAttr('readonly');	
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

		<legend style='text-align:center;'>Examen Físico <?= (($etapa != 1 AND $etapa != 5 AND $etapa != 6) ? 'Abreviado' : ''); ?><?= $protocolo;?></legend>
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
<?php
	$data = array(
        'name'        => 'hallazgo',                
        'value'       => '1',            
        'checked'     => set_radio('hallazgo', 1),
        );
    $data2 = array(
        'name'        => 'hallazgo',                
        'value'       => '0',
        'checked'     => set_radio('hallazgo', 0),           
        );
?>

	<?= form_open('subject/examen_fisico_insert', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>

	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>

		<table class='table table-striped table-hover table-bordered table-condensed'>
			<tr>
				<td>Examen f&iacute;sico realizado: </td>							
				<td><?= form_radio($data); ?> Si <?= form_radio($data2); ?> No</td>
				<td></td>
			</tr>
			<?php if($etapa == 1 OR $etapa == 5 OR $etapa == 6){ ?>			
				<tr>
					<td>La fecha del examen es la misma fecha de la visita?: </td>
					<td>
						<?= form_radio(array('name'=>'misma_fecha', 'value'=>1, 'checked'=>set_radio('misma_fecha', 1))); ?> Si
						<?= form_radio(array('name'=>'misma_fecha', 'value'=>0, 'checked'=>set_radio('misma_fecha', 0))); ?> No
					</td>
					<td></td>
				</tr>
			<?php } else { ?>
					<?= form_hidden('misma_fecha',0); ?>
			<?php } ?>
			<tr>
				<td>Fecha: </td>
				<td><?= form_input(array('type'=>'text', 'name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?></td>
				<td></td>
			</tr>
			<tr id='mensaje_desviacion' style='display:none;'>
				<td colspan='3' id='td_mensaje_desviacion' class='alert alert-danger'></td>
			</tr>
			<tr style='background-color:#ddd;'>
				<td></td>
				<td></td>
				<td style='font-weight:bold;'>Describa hallazgos</td>
			</tr>
						
			<tr>
				<td>Aspecto general: </td>
				<td>
					<?= form_radio(array('name'=>'aspecto_general','value'=>'1','checked'=>set_radio('aspecto_general', 1))); ?> Normal
					<?= form_radio(array('name'=>'aspecto_general','value'=>'0','checked'=>set_radio('aspecto_general', 0))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'aspecto_general_desc','id'=>'aspecto_general_desc', 'value'=>set_value('aspecto_general_desc'), 'rows'=>3)); ?></td>
			</tr>
			<?php if($etapa == 1 OR $etapa == 5 OR $etapa == 6){ ?>			
			
				<tr>
					<td>Piel: </td>
					<td>
						<?= form_radio(array('name'=>'piel','value'=>'1','checked'=>set_radio('piel', 1))); ?> Normal
						<?= form_radio(array('name'=>'piel','value'=>'0','checked'=>set_radio('piel', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'piel_desc','id'=>'piel_desc', 'value'=>set_value('piel_desc'), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Cabeza: </td>
					<td>
						<?= form_radio(array('name'=>'cabeza','value'=>'1','checked'=>set_radio('cabeza', 1))); ?> Normal
						<?= form_radio(array('name'=>'cabeza','value'=>'0','checked'=>set_radio('cabeza', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'cabeza_desc','id'=>'cabeza_desc', 'value'=>set_value('cabeza_desc'), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Ojos: </td>
					<td>
						<?= form_radio(array('name'=>'ojos','value'=>'1','checked'=>set_radio('ojos', 1))); ?> Normal
						<?= form_radio(array('name'=>'ojos','value'=>'0','checked'=>set_radio('ojos', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'ojos_desc','id'=>'ojos_desc', 'value'=>set_value('ojos_desc'), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Nariz: </td>
					<td>
						<?= form_radio(array('name'=>'nariz','value'=>'1','checked'=>set_radio('nariz', 1))); ?> Normal
						<?= form_radio(array('name'=>'nariz','value'=>'0','checked'=>set_radio('nariz', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'nariz_desc','id'=>'nariz_desc', 'value'=>set_value('nariz_desc'), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Oidos: </td>
					<td>
						<?= form_radio(array('name'=>'oidos','value'=>'1','checked'=>set_radio('oidos', 1))); ?> Normal
						<?= form_radio(array('name'=>'oidos','value'=>'0','checked'=>set_radio('oidos', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'oidos_desc','id'=>'oidos_desc', 'value'=>set_value('oidos_desc'), 'rows'=>3)); ?></td>
				</tr>			
				<tr>
					<td>Boca - Garganta: </td>
					<td>
						<?= form_radio(array('name'=>'boca','value'=>'1','checked'=>set_radio('boca', 1))); ?> Normal
						<?= form_radio(array('name'=>'boca','value'=>'0','checked'=>set_radio('boca', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'boca_desc','id'=>'boca_desc', 'value'=>set_value('boca_desc'), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Cuello - adenopat&iacute;as: </td>
					<td>
						<?= form_radio(array('name'=>'cuello','value'=>'1','checked'=>set_radio('cuello', 1))); ?> Normal
						<?= form_radio(array('name'=>'cuello','value'=>'0','checked'=>set_radio('cuello', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'cuello_desc','id'=>'cuello_desc', 'value'=>set_value('cuello_desc'), 'rows'=>3)); ?></td>
				</tr>
			<?php } else { ?>				
				<?= form_hidden('piel',''); ?>
				<?= form_hidden('piel_desc',''); ?>
				<?= form_hidden('cabeza',''); ?>
				<?= form_hidden('cabeza_desc',''); ?>
				<?= form_hidden('ojos',''); ?>
				<?= form_hidden('ojos_desc',''); ?>
				<?= form_hidden('nariz',''); ?>
				<?= form_hidden('nariz_desc',''); ?>
				<?= form_hidden('oidos',''); ?>
				<?= form_hidden('oidos_desc',''); ?>
				<?= form_hidden('boca',''); ?>
				<?= form_hidden('boca_desc',''); ?>
				<?= form_hidden('cuello',''); ?>
				<?= form_hidden('cuello_desc',''); ?>
			<?php }?>						
			<tr>
				<td>Pecho, pulm&oacute;n: </td>
				<td>
					<?= form_radio(array('name'=>'pulmones','value'=>'1','checked'=>set_radio('pulmones', 1))); ?> Normal
					<?= form_radio(array('name'=>'pulmones','value'=>'0','checked'=>set_radio('pulmones', 0))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'pulmones_desc','id'=>'pulmones_desc', 'value'=>set_value('pulmones_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Card&iacute;aco: </td>
				<td>
					<?= form_radio(array('name'=>'cardiovascular','value'=>'1','checked'=>set_radio('cardiovascular', 1))); ?> Normal
					<?= form_radio(array('name'=>'cardiovascular','value'=>'0','checked'=>set_radio('cardiovascular', 0))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'cardiovascular_desc', 'id'=>'cardiovascular_desc', 'value'=>set_value('cardiovascular_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Abdomen: </td>
				<td>
					<?= form_radio(array('name'=>'abdomen','value'=>'1','checked'=>set_radio('abdomen', 1))); ?> Normal
					<?= form_radio(array('name'=>'abdomen','value'=>'0','checked'=>set_radio('abdomen', 0))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'abdomen_desc','id'=>'abdomen_desc', 'value'=>set_value('abdomen_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Muscular - Esquel&eacute;tico: </td>
				<td>
					<?= form_radio(array('name'=>'muscular','value'=>'1','checked'=>set_radio('muscular', 1))); ?> Normal
					<?= form_radio(array('name'=>'muscular','value'=>'0','checked'=>set_radio('muscular', 0))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'muscular_desc','id'=>'muscular_desc', 'value'=>set_value('muscular_desc'), 'rows'=>3)); ?></td>
			</tr>

			<?php if($etapa != 1 AND $etapa != 5 AND $etapa != 6){ ?>

				<tr>
					<td>¿Tuvo el sujeto algún cambio desde la visita anterior?</td>
					<td>						
						<?= form_radio(array('name'=>'tuvo_cambios', 'value'=>1, 'checked'=>set_radio('tuvo_cambios', 1))); ?> Si
						<?= form_radio(array('name'=>'tuvo_cambios', 'value'=>0, 'checked'=>set_radio('tuvo_cambios', 0))); ?> No
					</td>
				</tr>
				<tr id='tr_observaciones' style='display:none;'>
					<td>Observaciones</td>
					<td>
						<?= form_textarea(array('name'=>'cambios_observaciones','id'=>'cambios_observaciones', 'value'=>set_value('cambios_observaciones'), 'rows'=>3, 'style'=>'width:100%;')); ?>
					</td>	
				</tr>
					
			<?php }else{ ?>
					<?= form_hidden('tuvo_cambios',''); ?>
					<?= form_hidden('cambios_observaciones',''); ?>
			<?php }?>
			
			<tr>
				<td colspan='3' style='text-align:center;'>
					<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'examen_fisico_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
					<?= anchor('subject/grid/'. $subject->id, 'Volver', array('class'=>'btn')); ?>
				</td>				
			</tr>			
		</table>
	<?= form_close(); ?>
