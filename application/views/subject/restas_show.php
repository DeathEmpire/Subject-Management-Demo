<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha, #fecha_alt").datepicker();
	
	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").attr('readonly','readonly');			
			$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").attr('disabled','disabled');

		}else{
			$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").removeAttr('readonly');
			$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").removeAttr('disabled');
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").attr('readonly','readonly');
		$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").attr('disabled','disabled');
	}else{
		$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").removeAttr('readonly');
		$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").removeAttr('disabled');
	}

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
<legend style='text-align:center;'>Restas Seriadas</legend>
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
<?= form_open('subject/restas_update', array('class'=>'form-horizontal', 'id'=>'form_restas')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('etapa', $etapa); ?>	
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
	<table class="table table-bordered table-striped table-hover">
		<tr>
			<td colspan='2' style='background-color:#ccc;'>Resta seriada</td>
		</tr>
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
		<tr>
			<td style='background-color:#ccc;'>Resta 7 a partir de  100</td>
			<td style='background-color:#ccc;'>Indicar respuestas correctas</td>
		</tr>
	<?php 
		$resta_1 = array(
			    'name'        => 'resta_1',
			    'id'          => 'resta_1',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_1','1', (($list[0]->resta_1 == 1) ? true : false) )			    
		    );
		$resta_2 = array(
			    'name'        => 'resta_2',
			    'id'          => 'resta_2',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_2','1', (($list[0]->resta_2 == 1) ? true : false))			    
		    );
		$resta_3 = array(
			    'name'        => 'resta_3',
			    'id'          => 'resta_3',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_3','1', (($list[0]->resta_3 == 1) ? true : false))			    
		    );
		$resta_4 = array(
			    'name'        => 'resta_4',
			    'id'          => 'resta_4',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_4','1', (($list[0]->resta_4 == 1) ? true : false))			    
		    );
		$resta_5 = array(
			    'name'        => 'resta_5',
			    'id'          => 'resta_5',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_5','1', (($list[0]->resta_5 == 1) ? true : false))			    
		    );
		$resta_1_alt = array(
			    'name'        => 'resta_alt_1',
			    'id'          => 'resta_alt_1',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_alt_1','1', (($list[0]->resta_alt_1 == 1) ? true : false))			    
		    );
		$resta_2_alt = array(
			    'name'        => 'resta_alt_2',
			    'id'          => 'resta_alt_2',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_alt_2','1', (($list[0]->resta_alt_2 == 1) ? true : false))			    
		    );
		$resta_3_alt = array(
			    'name'        => 'resta_alt_3',
			    'id'          => 'resta_alt_3',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_alt_3','1', (($list[0]->resta_alt_3 == 1) ? true : false))			    
		    );
		$resta_4_alt = array(
			    'name'        => 'resta_alt_4',
			    'id'          => 'resta_alt_4',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_alt_4','1', (($list[0]->resta_alt_4 == 1) ? true : false))			    
		    );
		$resta_5_alt = array(
			    'name'        => 'resta_alt_5',
			    'id'          => 'resta_alt_5',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_alt_5','1', (($list[0]->resta_alt_5 == 1) ? true : false))			    
		    );
	?>
		<tr>
			<td>93</td>
			<td><?= form_checkbox($resta_1); ?></td>
		</tr>
		<tr>
			<td>86</td>
			<td><?= form_checkbox($resta_2); ?></td>
		</tr>
		<tr>
			<td>79</td>
			<td><?= form_checkbox($resta_3); ?></td>
		</tr>
		<tr>
			<td>72</td>
			<td><?= form_checkbox($resta_4); ?></td>
		</tr>
		<tr>
			<td>65</td>
			<td><?= form_checkbox($resta_5); ?></td>
		</tr>
	</table>
	<br />
	<table class="table table-bordered table-striped table-hover">	
		<tr>
			<td colspan='2' style='background-color:#ccc;'>Resta seriada alternativa</td>
		</tr>
		<tr>		
			<td>Realizado: </td>
			<td>
				<?= form_radio($data3,$data3['value'],set_radio($data3['name'], 1,(($list[0]->realizado_alt == 1) ? true : false))); ?> Si
				<?= form_radio($data4,$data4['value'],set_radio($data4['name'], 0,(($list[0]->realizado_alt == 0) ? true : false))); ?> NO
			</td>
		</tr>
		<tr>
			<td>Fecha: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha_alt', 'id'=>'fecha_alt', 'value'=>set_value('fecha_alt', $list[0]->fecha_alt))); ?></td>
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
				<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
	        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
			</td>
		</tr>
	</table>

<?= form_close(); ?>
