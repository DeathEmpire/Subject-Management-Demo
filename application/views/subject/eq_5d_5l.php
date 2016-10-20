<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });	

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_eq :input").attr('readonly','readonly');
			$("#form_eq :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_eq :input").removeAttr('readonly');
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_eq :input").attr('readonly','readonly');
		$("#form_eq :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_eq :input").removeAttr('readonly');
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
<legend style='text-align:center;'>EQ-5D-3L <?= $protocolo;?></legend>
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
<?= form_open('subject/eq_5d_5l_insert', array('class'=>'form-horizontal', 'id'=>'form_eq')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('etapa', $etapa); ?>	
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
				<?= form_radio($data,$data['value'],set_radio($data['name'], 1)); ?> Si
				<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
			</td>
		</tr>
		<tr>
			<td>Fecha: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?></td>
		</tr>
		<tr id='mensaje_desviacion' style='display:none;'>
			<td colspan='2' id='td_mensaje_desviacion' class='alert alert-danger'></td>
		</tr>
		<tr>
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>MOVILIDAD</td>			
		</tr>
		<tr>
			<td>No tiene problemas para caminar</td>
			<td><?= form_radio('movilidad','No tiene problemas para caminar',set_radio('movilidad', 'No tiene problemas para caminar')); ?></td>
		</tr>
		<tr>
			<td>Tiene algunos problemas para caminar</td>
			<td><?= form_radio('movilidad','Tiene algunos problemas para caminar',set_radio('movilidad', 'Tiene algunos problemas para caminar')); ?></td>
		</tr>
		<tr>
			<td>Debe estar en cama</td>
			<td><?= form_radio('movilidad','Debe estar en cama',set_radio('movilidad', 'Debe estar en cama')); ?></td>
		</tr>
		
		
		<tr>
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>CUIDADO PERSONAL</td>			
		</tr>
		<tr>
			<td>No tiene problemas con su cuidado personal</td>
			<td><?= form_radio('autocuidado','No tiene problemas con su cuidado personal',set_radio('autocuidado', 'No tiene problemas con su cuidado personal')); ?></td>
		</tr>
		<tr>
			<td>Tiene algunos problemas para lavarse o vestirse solo/a</td>
			<td><?= form_radio('autocuidado','Tiene algunos problemas para lavarse o vestirse solo/a',set_radio('autocuidado', 'Tiene algunos problemas para lavarse o vestirse solo/a')); ?></td>
		</tr>		
		<tr>
			<td>Es incapas de lavarse o vestirse solo/a</td>
			<td><?= form_radio('autocuidado','Es incapas de lavarse o vestirse solo/a',set_radio('autocuidado', 'Es incapas de lavarse o vestirse solo/a')); ?></td>
		</tr>
		
		<tr>
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>ACTIVIDADES HABITUALES <small>(Ej: Trabajar, estudiar, hacer las tareas domésticas, actividades familiares o realizadas durante el tiempo libre)</small></td>			
		</tr>
		<tr>
			<td>No tiene problemas para realizar sus actividades habituales</td>
			<td><?= form_radio('actividades_habituales','No tiene problemas para realizar sus actividades habituales',set_radio('actividades_habituales', 'No tiene problemas para realizar sus actividades habituales')); ?></td>
		</tr>
		<tr>
			<td>Tiene algunos problemas para realizar sus actividades habituales</td>
			<td><?= form_radio('actividades_habituales','Tiene algunos problemas para realizar sus actividades habituales',set_radio('actividades_habituales', 'Tiene algunos problemas para realizar sus actividades habituales')); ?></td>
		</tr>		
		<tr>
			<td>Es incapaz de realizar sus actividades habituales</td>
			<td><?= form_radio('actividades_habituales','Es incapaz de realizar sus actividades habituales',set_radio('actividades_habituales', 'Es incapaz de realizar sus actividades habituales')); ?></td>
		</tr>
		<tr>
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>DOLOR MALESTAR</td>			
		</tr>
		<tr>
			<td>No tiene dolor ni malestar</td>
			<td><?= form_radio('dolor_malestar','No tiene dolor ni malestar',set_radio('dolor_malestar', 'No tiene dolor ni malestar')); ?></td>
		</tr>
		<tr>
			<td>Tiene un dolor o malestar moderado</td>
			<td><?= form_radio('dolor_malestar','Tiene un dolor o malestar moderado',set_radio('dolor_malestar', 'Tiene un dolor o malestar moderado')); ?></td>
		</tr>				
		<tr>
			<td>Tiene mucho dolor o malestar</td>
			<td><?= form_radio('dolor_malestar','Tiene mucho dolor o malestar',set_radio('dolor_malestar', 'Tiene mucho dolor o malestar')); ?></td>
		</tr>
		<tr>
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>ANGUSTIA DEPRESION</td>			
		</tr>
		<tr>
			<td>No está angustiado/a o deprimido/a</td>
			<td><?= form_radio('angustia_depresion','No está angustiado/a o deprimido/a',set_radio('angustia_depresion', 'No está angustiado/a o deprimido/a')); ?></td>
		</tr>		
		<tr>
			<td>Está moderadamente angustiado/a o deprimido/a</td>
			<td><?= form_radio('angustia_depresion','Está moderadamente angustiado/a o deprimido/a',set_radio('angustia_depresion', 'Está moderadamente angustiado/a o deprimido/a')); ?></td>
		</tr>		
		<tr>
			<td>Está muy angustiado/a o deprimido/a</td>
			<td><?= form_radio('angustia_depresion','Está muy angustiado/a o deprimido/a',set_radio('angustia_depresion', 'Está muy angustiado/a o deprimido/a')); ?></td>
		</tr>				
		<tr>
			<td style='font-weight:bold;background-color:#ddd;'>SU SALUD HOY = </td>
			<td style='font-weight:bold;background-color:#ddd;'><?= form_input(array('type'=>'number', 'name'=>'salud_hoy', 'id'=>'salud_hoy', 'value'=>set_value('salud_hoy'))); ?></td>
		</tr>
		<tr>
			<td colspan='2' style='text-align:center;'>
				<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
	        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
			</td>
		</tr>
	</table>
<?= form_close(); ?>