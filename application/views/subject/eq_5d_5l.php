<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker();	

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_eq :input").attr('readonly','readonly');
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_eq :input").removeAttr('readonly');
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_eq :input").attr('readonly','readonly');
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_eq :input").removeAttr('readonly');
	}
});
</script>
<legend style='text-align:center;'>EQ-5D-5L</legend>
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
				<?= form_radio($data,$data['value'],set_radio($data['name'], 1, true)); ?> Si
				<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
			</td>
		</tr>
		<tr>
			<td>Fecha: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?></td>
		</tr>
		<tr>
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>MOVILIDAD</td>			
		</tr>
		<tr>
			<td>No tengo problemas para caminar</td>
			<td><?= form_radio('movilidad','No tengo problemas para caminar',set_radio('movilidad', 'No tengo problemas para caminar')); ?></td>
		</tr>
		<tr>
			<td>Tengo problemas leves para caminar</td>
			<td><?= form_radio('movilidad','Tengo problemas leves para caminar',set_radio('movilidad', 'Tengo problemas leves para caminar')); ?></td>
		</tr>
		<tr>
			<td>Tengo problemas moderados para caminar</td>
			<td><?= form_radio('movilidad','Tengo problemas moderados para caminar',set_radio('movilidad', 'Tengo problemas moderados para caminar')); ?></td>
		</tr>
		<tr>
			<td>Tengo problemas graves para caminar</td>
			<td><?= form_radio('movilidad','Tengo problemas graves para caminar',set_radio('movilidad', 'Tengo problemas graves para caminar')); ?></td>
		</tr>
		<tr>
			<td>No puedo caminar</td>
			<td><?= form_radio('movilidad','No puedo caminar',set_radio('movilidad', 'No puedo caminar')); ?></td>
		</tr>
		<tr>
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>AUTOCUIDADO</td>			
		</tr>
		<tr>
			<td>No tengo problemas para lavarme o vestirme</td>
			<td><?= form_radio('autocuidado','No tengo problemas para lavarme o vestirme',set_radio('autocuidado', 'No tengo problemas para lavarme o vestirme')); ?></td>
		</tr>
		<tr>
			<td>Tengo problemas leves para lavarme o vestirme</td>
			<td><?= form_radio('autocuidado','Tengo problemas leves para lavarme o vestirme',set_radio('autocuidado', 'Tengo problemas leves para lavarme o vestirme')); ?></td>
		</tr>
		<tr>
			<td>Tengo problemas moderados para lavarme o vestirme</td>
			<td><?= form_radio('autocuidado','Tengo problemas moderados para lavarme o vestirme',set_radio('autocuidado', 'Tengo problemas moderados para lavarme o vestirme')); ?></td>
		</tr>
		<tr>
			<td>Tengo problemas graves para lavarme o vestirme</td>
			<td><?= form_radio('autocuidado','Tengo problemas graves para lavarme o vestirme',set_radio('autocuidado', 'Tengo problemas graves para lavarme o vestirme')); ?></td>
		</tr>
		<tr>
			<td>No puedo lavarme o vestirme</td>
			<td><?= form_radio('autocuidado','No puedo lavarme o vestirme',set_radio('autocuidado', 'No puedo lavarme o vestirme')); ?></td>
		</tr>
		<tr>
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>ACTIVIDADES HABITUALES <small>(Ej: Trabajar, estudiar, hacer las tareas domésticas, actividades familiares o realizadas durante el tiempo libre)</small></td>			
		</tr>
		<tr>
			<td>No tengo problemas para realizar mis actividades habituales</td>
			<td><?= form_radio('actividades_habituales','No tengo problemas para realizar mis actividades habituales',set_radio('actividades_habituales', 'No tengo problemas para realizar mis actividades habituales')); ?></td>
		</tr>
		<tr>
			<td>Tengo problemas leves para realizar mis actividades habituales</td>
			<td><?= form_radio('actividades_habituales','Tengo problemas leves para realizar mis actividades habituales',set_radio('actividades_habituales', 'Tengo problemas leves para realizar mis actividades habituales')); ?></td>
		</tr>
		<tr>
			<td>Tengo problemas moderados para realizar mis actividades habituales</td>
			<td><?= form_radio('actividades_habituales','Tengo problemas moderados para realizar mis actividades habituales',set_radio('actividades_habituales', 'Tengo problemas moderados para realizar mis actividades habituales')); ?></td>
		</tr>
		<tr>
			<td>Tengo problemas graves para realizar mis actividades habituales</td>
			<td><?= form_radio('actividades_habituales','Tengo problemas graves para realizar mis actividades habituales',set_radio('actividades_habituales', 'Tengo problemas graves para realizar mis actividades habituales')); ?></td>
		</tr>
		<tr>
			<td>No puedo realizar mis actividades habituales</td>
			<td><?= form_radio('actividades_habituales','No puedo realizar mis actividades habituales',set_radio('actividades_habituales', 'No puedo realizar mis actividades habituales')); ?></td>
		</tr>
		<tr>
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>DOLOR MALESTAR</td>			
		</tr>
		<tr>
			<td>No tengo dolor ni malestar</td>
			<td><?= form_radio('dolor_malestar','No tengo dolor ni malestar',set_radio('dolor_malestar', 'No tengo dolor ni malestar')); ?></td>
		</tr>
		<tr>
			<td>Tengo dolor o malestar leve</td>
			<td><?= form_radio('dolor_malestar','Tengo dolor o malestar leve',set_radio('dolor_malestar', 'Tengo dolor o malestar leve')); ?></td>
		</tr>
		<tr>
			<td>Tengo dolor o malestar moderado</td>
			<td><?= form_radio('dolor_malestar','Tengo dolor o malestar moderado',set_radio('dolor_malestar', 'Tengo dolor o malestar moderado')); ?></td>
		</tr>
		<tr>
			<td>Tengo dolor o malestar fuerte</td>
			<td><?= form_radio('dolor_malestar','Tengo dolor o malestar fuerter',set_radio('dolor_malestar', 'Tengo dolor o malestar fuerte')); ?></td>
		</tr>
		<tr>
			<td>Tengo dolor o malestar extremo</td>
			<td><?= form_radio('dolor_malestar','Tengo dolor o malestar extremo',set_radio('dolor_malestar', 'Tengo dolor o malestar extremo')); ?></td>
		</tr>
		<tr>
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>ANGUSTIA DEPRESION</td>			
		</tr>
		<tr>
			<td>No estoy angustiado/a o deprimido/a</td>
			<td><?= form_radio('angustia_depresion','No estoy angustiado/a o deprimido/a',set_radio('angustia_depresion', 'No estoy angustiado/a o deprimido/a')); ?></td>
		</tr>
		<tr>
			<td>Estoy levemente angustiado/a o deprimido/a</td>
			<td><?= form_radio('angustia_depresion','Estoy levemente angustiado/a o deprimido/a',set_radio('angustia_depresion', 'Estoy levemente angustiado/a o deprimido/a')); ?></td>
		</tr>
		<tr>
			<td>Estoy moderadamente angustiado/a o deprimido/a</td>
			<td><?= form_radio('angustia_depresion','Estoy moderadamente angustiado/a o deprimido/a',set_radio('angustia_depresion', 'Estoy moderadamente angustiado/a o deprimido/a')); ?></td>
		</tr>
		<tr>
			<td>Estoy muy angustiado/a o deprimido/a</td>
			<td><?= form_radio('angustia_depresion','Estoy muy angustiado/a o deprimido/a',set_radio('angustia_depresion', 'Estoy muy angustiado/a o deprimido/a')); ?></td>
		</tr>
		<tr>
			<td>Estoy extremadamente angustiado/a o deprimido/a</td>
			<td><?= form_radio('angustia_depresion','Estoy extremadamente angustiado/a o deprimido/a',set_radio('angustia_depresion', 'Estoy extremadamente angustiado/a o deprimido/a')); ?></td>
		</tr>				
		<tr>
			<td style='font-weight:bold;background-color:#ddd;'>SU SALUD HOY = </td>
			<td style='font-weight:bold;background-color:#ddd;'><?= form_input(array('type'=>'number', 'name'=>'salud_hoy', 'id'=>'salud_hoy', 'value'=>set_value('salud_hoy'))); ?></td>
		</tr>
		<tr>
			<td colspan='2' style='text-align:center;'>
				<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
	        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
			</td>
		</tr>
	</table>
<?= form_close(); ?>