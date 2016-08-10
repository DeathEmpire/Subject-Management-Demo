<script type="text/javascript">
$(function(){
	$("input[name=cumple_criterios]").change(function(){
		if($(this).val() != 1){
			$("#tr_autorizacion").hide();
			$("input[name=autorizacion_patrocinador][value='No Aplica']").prop("checked",true);
			$("#tr_no_ingresa").hide();
			$("#tr_submit").show();
			$("#form_inclusion input, textarea").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
		else{
			$("#tr_autorizacion").show();
			$("#form_inclusion input, textarea").attr('readonly', 'readonly');
			$("#form_inclusion :input").each(function(){				
				if($(this).attr('name') != 'cumple_criterios' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});	
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});

		}
	});
	if($('input[name=cumple_criterios]:checked').val() != 1){
		$("#tr_autorizacion").hide();
		$("input[name=autorizacion_patrocinador][value='No Aplica']").prop("checked",true);
		$("#tr_no_ingresa").hide();
		$("#tr_submit").show();
		$("#form_inclusion input, textarea").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
	}
	else{
		$("#tr_autorizacion").show();
		$("#form_inclusion input, textarea").attr('readonly', 'readonly');
		$("#form_inclusion :input").each(function(){				
				if($(this).attr('name') != 'cumple_criterios' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
		$('select option:not(:selected)').each(function(){
			$(this).attr('disabled', 'disabled');
		});

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
<legend style='text-align:center;'>Criterios de Inclusión/Exclusión <?= $protocolo;?></legend>
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
<?= form_open('subject/inclusion_insert', array('class'=>'form-horizontal', 'id'=>'form_inclusion')); ?>    
	
	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>

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
	        	<?= form_radio($data,$data['value'],set_radio($data['name'], 1)); ?> Si <br>
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
		<tr>
			<td><?= form_dropdown("tipo[]",$tipos,set_value('tipo')); ?></td>
			<td><?= form_input(array('type'=>'number','name'=>'numero[]', 'min'=>'1')); ?></td>
			<td><?= form_textarea(array('name'=>'comentario[]','rows'=>'3')); ?></td>
		</tr>
		<tr>
			<td><?= form_dropdown("tipo[]",$tipos,set_value('tipo')); ?></td>
			<td><?= form_input(array('type'=>'number','name'=>'numero[]', 'min'=>'1')); ?></td>
			<td><?= form_textarea(array('name'=>'comentario[]','rows'=>'3')); ?></td>
		</tr>
		<tr>
			<td><?= form_dropdown("tipo[]",$tipos,set_value('tipo')); ?></td>
			<td><?= form_input(array('type'=>'number','name'=>'numero[]', 'min'=>'1')); ?></td>
			<td><?= form_textarea(array('name'=>'comentario[]','rows'=>'3')); ?></td>
		</tr>
	</table>
	<table class="table table-condensed table-bordered table-striped">
		<tr id='tr_agregar_entrada'>
			<td colspan='3' style='text-align:center;' class='btn' id='agregar_entrada'>Agregar entrada</td>
		</tr>
		<tr id='tr_autorizacion'>
			<td>Cuenta con la autorización del patrocinador para inclusión</td>
			<td>
				<?= form_radio('autorizacion_patrocinador','Si'); ?> Si <br>
				<?= form_radio('autorizacion_patrocinador', 'No'); ?> No <br>
				<?= form_radio('autorizacion_patrocinador', 'No Aplica'); ?> No Aplica 
			</td>
		</tr>	
		<tr id='tr_no_ingresa'>
			<td colspan='3' style='background-color:red;font-weight:bold;'>NO se puede ingresar ningún sujeto sin la firma del Consentimiento Informado.</td>			
		</tr>
	    <tr id='tr_submit'>
	    	<td colspan='3' style='text-align:center;'>
				<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'inclusion_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
	        	<?= anchor('subject/grid/'. $subject->id, 'Volver', array('class'=>'btn')); ?>
	    	</td>
	   	</tr>
	    
	</table>
<?= form_close(); ?>