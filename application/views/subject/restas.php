<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha_alt").datepicker({ dateFormat: 'dd/mm/yy' });
	

	$("input[name=realizado_alt]").change(function(){
		if($(this).val() == 0){
			$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").attr('readonly','readonly');
			$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").attr('disabled','disabled');

		}else{
			$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").removeAttr('readonly');
			$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").removeAttr('disabled');
		}
	});
	if($("input[name=realizado_alt]:checked").val() == 0){
		$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").attr('readonly','readonly');
		$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").attr('disabled','disabled');
	}else{
		$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha").removeAttr('readonly');
		$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").removeAttr('disabled');
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
<legend style='text-align:center;'>Restas Seriadas <?= $protocolo;?></legend>
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
<?= form_open('subject/restas_insert', array('class'=>'form-horizontal', 'id'=>'form_restas')); ?>
	
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
	  	$data3 = array(
			    'name'        => 'realizado_alt',			    
			    'value'       => 1,		    
			    #'checked'	  => set_radio('gender', 'male', TRUE),
		    );
	  	$data4 = array(
		    'name'        => 'realizado_alt',
		    'value'       => 0,
		    #'checked'	  => set_radio('gender', 'female', TRUE),		    
		    );
	?>
	
	<?php 
		
		$resta_1_alt = array(
			    'name'        => 'resta_alt_1',
			    'id'          => 'resta_alt_1',
			    'value'       => '1',
			    
		    );
		$resta_2_alt = array(
			    'name'        => 'resta_alt_2',
			    'id'          => 'resta_alt_2',
			    'value'       => '1',
			    
		    );
		$resta_3_alt = array(
			    'name'        => 'resta_alt_3',
			    'id'          => 'resta_alt_3',
			    'value'       => '1',
			    
		    );
		$resta_4_alt = array(
			    'name'        => 'resta_alt_4',
			    'id'          => 'resta_alt_4',
			    'value'       => '1',
			    
		    );
		$resta_5_alt = array(
			    'name'        => 'resta_alt_5',
			    'id'          => 'resta_alt_5',
			    'value'       => '1',
			    
		    );
	?>
		
	<br />
	<table class="table table-bordered table-striped table-hover">	
		<tr>
			<td colspan='2' style='background-color:#ccc;'>Resta seriada</td>
		</tr>
		<tr>		
			<td>Realizado: </td>
			<td>
				<?= form_radio($data3,$data3['value'],set_radio($data3['name'], 1)); ?> Si
				<?= form_radio($data4,$data4['value'],set_radio($data4['name'], 0)); ?> NO
			</td>
		</tr>
		<tr>
			<td>Fecha: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha_alt', 'id'=>'fecha_alt', 'value'=>set_value('fecha_alt'))); ?></td>
		</tr>
		<tr>
			<td style='background-color:#ccc;'>Reste 3 a partir del 20</td>
			<td style='background-color:#ccc;'>Indicar respuestas correctas</td>
		</tr>
		<tr>
			<td>17</td>
			<td><?= form_checkbox($resta_1_alt); ?></td>
		</tr>
		<tr>
			<td>14</td>			
			<td><?= form_checkbox($resta_2_alt); ?></td>
		</tr>
		<tr>
			<td>11</td>
			<td><?= form_checkbox($resta_3_alt); ?></td>
		</tr>
		<tr>
			<td>8</td>
			<td><?= form_checkbox($resta_4_alt); ?></td>
		</tr>
		<tr>
			<td>5</td>
			<td><?= form_checkbox($resta_5_alt); ?></td>
		</tr>
		<tr>
			<td colspan='2' style='text-align:center;'>
				<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'restas_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
	        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
			</td>
		</tr>
	</table>

<?= form_close(); ?>
