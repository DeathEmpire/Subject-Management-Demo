<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#autoevaluacion_fecha, #version_clinica_fecha, #apatia_fecha").datepicker({ dateFormat: 'dd/mm/yy' });	

	$("input[name=apatia_realizado]").change(function(){
		if($(this).val() == 0){
			$("input[name^=apatia_]").attr('readonly','readonly');
			$("input[name^=apatia_]").attr('disabled','disabled');
			$("input[name=apatia_realizado]").removeAttr('readonly');
			$("input[name=apatia_realizado]").removeAttr('disabled');
		}else{
			$("input[name^=apatia_]").removeAttr('readonly');
			$("input[name^=apatia_]").removeAttr('disabled');
		}
	});
	if($("input[name=apatia_realizado]:checked").val() == 0){
		$("input[name^=apatia_]").attr('readonly','readonly');
		$("input[name^=apatia_]").attr('disabled','disabled');
		$("input[name=apatia_realizado]").removeAttr('readonly');
		$("input[name=apatia_realizado]").removeAttr('disabled');

	}else{
		$("input[name^=apatia_]").removeAttr('readonly');
		$("input[name^=apatia_]").removeAttr('disabled');
	}


	$("input[name*=apatia_]").change(function(){
		var total = 0;
		$("input[type='radio']:checked").each(function(){
			if($(this).attr('name') != 'apatia_realizado' && $(this).attr('name') != 'apatia_fecha'){				
				total = total + parseInt($(this).val());				
			}
		});		
		$("#apatia_resultado").html(total);
	});

	var total2 = 0;
	$("input[type='radio']:checked").each(function(){
		if($(this).attr('name') != 'apatia_realizado' && $(this).attr('name') != 'apatia_fecha'){				
			total2 = total2 + parseInt($(this).val());				
		}
	});		
	$("#apatia_resultado").html(total2);

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
<legend style='text-align:center;'>ESCALAS DE APATIA <?= $protocolo; ?></legend>
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
<?= form_open('subject/apatia_insert', array('class'=>'form-horizontal', 'id'=>'form_apatia')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('etapa', $etapa); ?>	
	<?php
		
		$data5 = array(
		    'name'        => 'apatia_realizado',			    
		    'value'       => 1,		    
		    #'checked'	  => set_radio('gender', 'male', TRUE),
	    );
	  	$data6 = array(
		    'name'        => 'apatia_realizado',			    
		    'value'       => 0,
		    #'checked'	  => set_radio('gender', 'female', TRUE),		    
		    );	  
	?>
	

	<table class="table table-bordered table-striped table-hover">
		<thead>
			<tr>
				<td colspan='5' style='font-weight:bold;'>ESCALA DE EVALUACION DE APATIA (AES)</td>
			</tr>
		</thead>
		<tbody>
			<tr>		
				<td>Realizado: </td>
				<td colspan='4'>
					<?= form_radio($data5,$data5['value'],set_radio($data5['name'], 1, true)); ?> Si
					<?= form_radio($data6,$data6['value'],set_radio($data6['name'], 0)); ?> NO
				</td>
			</tr>
			<tr>
				<td>Fecha: </td>
				<td colspan='4'><?= form_input(array('type'=>'text','name'=>'apatia_fecha', 'id'=>'apatia_fecha', 'value'=>set_value('apatia_fecha'))); ?></td>
			</tr>
			<tr>
				<td style='font-weight:bold;background-color:#ccc'></td>
				<td style='font-weight:bold;background-color:#ccc'>No es verdadero</td>
				<td style='font-weight:bold;background-color:#ccc'>Levemente verdadero</td>
				<td style='font-weight:bold;background-color:#ccc'>Parcialmente verdadero</td>
				<td style='font-weight:bold;background-color:#ccc'>Verdadero</td>
			</tr>
			<tr>
				<td>1. El/ella tiene interés en las cosas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_1','4',set_radio('apatia_1','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_1','3',set_radio('apatia_1','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_1','2',set_radio('apatia_1','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_1','1',set_radio('apatia_1','0')); ?></td>
			</tr>
			<tr>
				<td>2. Hace cosas durante el día.</td>
				<td style='text-align:center;'><?= form_radio('apatia_2','4',set_radio('apatia_2','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_2','3',set_radio('apatia_2','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_2','2',set_radio('apatia_2','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_2','1',set_radio('apatia_2','0')); ?></td>
			</tr>
			<tr>
				<td>3. Comienza a hacer cosas que son importantes para él / ella.</td>
				<td style='text-align:center;'><?= form_radio('apatia_3','4',set_radio('apatia_3','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_3','3',set_radio('apatia_3','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_3','2',set_radio('apatia_3','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_3','1',set_radio('apatia_3','0')); ?></td>
			</tr>
			<tr>
				<td>4. Está interesado en tener cosas nuevas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_4','4',set_radio('apatia_4','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_4','3',set_radio('apatia_4','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_4','2',set_radio('apatia_4','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_4','1',set_radio('apatia_4','0')); ?></td>
			</tr>
			<tr>
				<td>5. Esta interesado en aprender cosas nuevas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_5','4',set_radio('apatia_5','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_5','3',set_radio('apatia_5','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_5','2',set_radio('apatia_5','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_5','1',set_radio('apatia_5','0')); ?></td>
			</tr>
			<tr>
				<td>6. Pone poco esfuerzo en las cosas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_6','1',set_radio('apatia_6','0')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_6','2',set_radio('apatia_6','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_6','3',set_radio('apatia_6','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_6','4',set_radio('apatia_6','3')); ?></td>
			</tr>
			<tr>
				<td>7. Se enfrenta a la vida con intensidad.</td>
				<td style='text-align:center;'><?= form_radio('apatia_7','4',set_radio('apatia_7','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_7','3',set_radio('apatia_7','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_7','2',set_radio('apatia_7','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_7','1',set_radio('apatia_7','0')); ?></td>
			</tr>
			<tr>
				<td>8. Termina los trabajos que son importantes para él / ella.</td>
				<td style='text-align:center;'><?= form_radio('apatia_8','4',set_radio('apatia_8','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_8','3',set_radio('apatia_8','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_8','2',set_radio('apatia_8','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_8','1',set_radio('apatia_8','0')); ?></td>
			</tr>
			<tr>
				<td>9. Ocupa su tiempo haciendo cosas que son de su interés.</td>
				<td style='text-align:center;'><?= form_radio('apatia_9','4',set_radio('apatia_9','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_9','3',set_radio('apatia_9','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_9','2',set_radio('apatia_9','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_9','1',set_radio('apatia_9','0')); ?></td>
			</tr>
			<tr>
				<td>10. Alguien debe decirle lo que hacer cada día.</td>
				<td style='text-align:center;'><?= form_radio('apatia_10','1',set_radio('apatia_10','0')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_10','2',set_radio('apatia_10','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_10','3',set_radio('apatia_10','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_10','4',set_radio('apatia_10','3')); ?></td>
			</tr>
			<tr>
				<td>11. Esta menos preocupada de sus problemas que lo que debiera.</td>
				<td style='text-align:center;'><?= form_radio('apatia_11','1',set_radio('apatia_11','0')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_11','2',set_radio('apatia_11','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_11','3',set_radio('apatia_11','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_11','4',set_radio('apatia_11','3')); ?></td>
			</tr>
			<tr>
				<td>12. Tiene amigos.</td>
				<td style='text-align:center;'><?= form_radio('apatia_12','4',set_radio('apatia_12','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_12','3',set_radio('apatia_12','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_12','2',set_radio('apatia_12','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_12','1',set_radio('apatia_12','0')); ?></td>
			</tr>
			<tr>
				<td>13. Estar junto a sus amigos es importante para él / ella.</td>
				<td style='text-align:center;'><?= form_radio('apatia_13','4',set_radio('apatia_13','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_13','3',set_radio('apatia_13','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_13','2',set_radio('apatia_13','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_13','1',set_radio('apatia_13','0')); ?></td>
			</tr>
			<tr>
				<td>14. Cuando algo bueno pasa, él / ella se alegra.</td>
				<td style='text-align:center;'><?= form_radio('apatia_14','4',set_radio('apatia_14','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_14','3',set_radio('apatia_14','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_14','2',set_radio('apatia_14','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_14','1',set_radio('apatia_14','0')); ?></td>
			</tr>
			<tr>
				<td>15. Tiene una adecuada comprensión de sus problemas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_15','4',set_radio('apatia_15','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_15','3',set_radio('apatia_15','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_15','2',set_radio('apatia_15','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_15','1',set_radio('apatia_15','0')); ?></td>
			</tr>
			<tr>
				<td>16. Se mantiene, durante el día, haciendo cosas importantes para él / ella.</td>
				<td style='text-align:center;'><?= form_radio('apatia_16','4',set_radio('apatia_16','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_16','3',set_radio('apatia_16','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_16','2',set_radio('apatia_16','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_16','1',set_radio('apatia_16','0')); ?></td>
			</tr>
			<tr>
				<td>17. Tiene iniciativa.</td>
				<td style='text-align:center;'><?= form_radio('apatia_17','4',set_radio('apatia_17','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_17','3',set_radio('apatia_17','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_17','2',set_radio('apatia_17','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_17','1',set_radio('apatia_17','0')); ?></td>
			</tr>
			<tr>
				<td>18. Tiene motivación.</td>
				<td style='text-align:center;'><?= form_radio('apatia_18','4',set_radio('apatia_18','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_18','3',set_radio('apatia_18','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_18','2',set_radio('apatia_18','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_18','1',set_radio('apatia_18','0')); ?></td>
			</tr>
			<tr>
				<td style='font-weight:bold;'>RESULTADO: </td>
				<td id='apatia_resultado' colspan='4' style='font-weight:bold;'></td>
			</tr>
		</tbody>
	</table>

	<table class="table table-bordered table-striped table-hover">
		<tr>
			<td colspan='2' style='text-align:center;'>
				<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'apatia_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
	        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
			</td>
		</tr>
	</table>
<?= form_close(); ?>