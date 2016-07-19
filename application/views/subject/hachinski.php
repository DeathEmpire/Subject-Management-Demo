<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){

	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });	

	$('input[type=checkbox]').click(function(){

		var total = 0;

		 $('input[type=checkbox]').each(function(){
            if (this.checked) {
                total += parseInt($(this).val());
            }
        });

		$("#td_total").text(total);
		$("#total").val(total);
	});

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_hach :input").attr('readonly','readonly');			
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_hach :input").removeAttr('readonly');			
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_hach :input").attr('readonly','readonly');		
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_hach :input").removeAttr('readonly');		
	}
});	
</script>	
	
		<legend style='text-align:center;'>Escala de Hachinski</legend>
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
		<?= form_open('subject/hachinski_insert', array('id'=>'form_hach')); ?>		
			<input type='hidden' name='total' id='total' value='0' />
			<input type='hidden' name='subject_id' id='subject_id' value='<?php echo $subject->id; ?>' />
			<table class="table table-condensed table-bordered table-striped table-hover">
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
			
				<tr>
					<td>Realizado:</td>
					<td>
						<?= form_radio($data,$data['value'],set_radio($data['name'], 1)); ?> Si
						<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
					</td>
				</tr>
				<tr>
					<td>Fecha: </td>
					<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?></td>
				</tr>
				<tr><td>Comienzo Brusco: </td><td><input type='checkbox' name='comienzo_brusco' id='comienzo_brusco' value='2' /></td></tr>
				<tr><td>Deterioro escalonado: </td><td><input type='checkbox' name='deterioro_escalonado' id='deterioro_escalonado' value='1' /></td></tr>
				<tr><td>Curso fluctuante: </td><td><input type='checkbox' name='curso_fluctante' id='curso_fluctante' value='2' /></td></tr>
				<tr><td>Desorientación nocturna: </td><td><input type='checkbox' name='desorientacion_noctura' id='desorientacion_noctura' value='1' /></td></tr>
				<tr><td>Preservación relativa de la personalidad: </td><td><input type='checkbox' name='preservacion_relativa' id='preservacion_relativa' value='1' /></td></tr>
				<tr><td>Depresión: </td><td><input type='checkbox' name='depresion' id='depresion' value='1' /></td></tr>
				<tr><td>Somatización: </td><td><input type='checkbox' name='somatizacion' id='somatizacion' value='1' /></td></tr>
				<tr><td>Labilidad emocional: </td><td><input type='checkbox' name='labilidad_emocional' id='labilidad_emocional' value='1' /></td></tr>
				<tr><td>Historia de HTA: </td><td><input type='checkbox' name='hta' id='hta' value='1' /></td></tr>
				<tr><td>Historia de ictus previos: </td><td><input type='checkbox' name='ictus_previos' id='ictus_previos' value='2' /></td></tr>
				<tr><td>Evidencia de arteriosclerosis asociada: </td><td><input type='checkbox' name='evidencia_arteriosclerosis' id='evidencia_arteriosclerosis' value='1' /></td></tr>
				<tr><td>Síntomas neurológicos focales: </td><td><input type='checkbox' name='sintomas_neurologicos' id='sintomas_neurologicos' value='2' /></td></tr>
				<tr><td>Signos neurológicos focales: </td><td><input type='checkbox' name='signos_neurologicos' id='signos_neurologicos' value='2' /></td></tr>
				<tr><td><b>Puntaje Total: </b></td><td style='text-align:rigth;font-weight:bold;' id='td_total'></td></tr>
				<tr>
					<td colspan='2' style='text-align:right;font-weight:bold;font-style:italic;'>Puntaje de isquemia de Hachinski modificada ≤ 4, según criterios de inclusión.</td>
				</tr>
				<tr>
					<td colspan='2' style='text-align:center;'>
						<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'hachinski_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
						<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
					</td>
				</tr>
			</table>
		<?= form_close(); ?>
	

