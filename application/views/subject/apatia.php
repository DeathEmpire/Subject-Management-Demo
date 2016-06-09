<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#autoevaluacion_fecha, #version_clinica_fecha, #apatia_fecha").datepicker();	

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_apatia :input").attr('readonly','readonly');
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_apatia :input").removeAttr('readonly');
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_apatia :input").attr('readonly','readonly');
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_apatia :input").removeAttr('readonly');
	}


	$('input[name^=autoevaluacion_]').click(function(){
		var total = 0;
		 $('input[name^=autoevaluacion_]').each(function(){
            if (this.checked) {
                total += parseInt($(this).val());
            }
        });
		total -= $("input[name=autoevaluacion_realizado]:checked").val();
		$("#autoevaluacion_resultado").text(total);		
	});
	var total2 = 0;
	 $('input[name^=autoevaluacion_]').each(function(){
        if (this.checked) {
            total2 += parseInt($(this).val());
        }
    });
	total2 -= $("input[name=autoevaluacion_realizado]:checked").val();
	$("#autoevaluacion_resultado").text(total2);
	
	$('input[name^=version_clinica_]').click(function(){
		var total3 = 0;
		 $('input[name^=version_clinica_]').each(function(){
            if (this.checked) {
                total3 += parseInt($(this).val());
            }
        });
		total3 -= $("input[name=version_clinica_realizado]:checked").val();
		$("#version_clinica_resultado").text(total3);		
	});
	var total4 = 0;
	 $('input[name^=version_clinica_]').each(function(){
        if (this.checked) {
            total4 += parseInt($(this).val());
        }
    });
	total4 -= $("input[name=version_clinica_realizado]:checked").val();
	$("#version_clinica_resultado").text(total4);

	$('input[name^=apatia_]').click(function(){
		var total5 = 0;
		 $('input[name^=apatia_]').each(function(){
            if (this.checked) {
                total5 += parseInt($(this).val());
            }
        });
		total5 -= $("input[name=apatia_realizado]:checked").val();
		$("#apatia_resultado").text(total5);		
	});
	var total6 = 0;
	 $('input[name^=apatia_]').each(function(){
        if (this.checked) {
            total6 += parseInt($(this).val());
        }
    });
	total6 -= $("input[name=apatia_realizado]:checked").val();
	$("#apatia_resultado").text(total6);

});
</script>
<legend style='text-align:center;'>ESCALAS DE APATIA</legend>
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
		$data = array(
			    'name'        => 'autoevaluacion_realizado',			    
			    'value'       => 1,		    
			    #'checked'	  => set_radio('gender', 'male', TRUE),
		    );
	  	$data2 = array(
		    'name'        => 'autoevaluacion_realizado',			    
		    'value'       => 0,
		    #'checked'	  => set_radio('gender', 'female', TRUE),		    
		    );	 
	    $data3 = array(
		    'name'        => 'version_clinica_realizado',			    
		    'value'       => 1,		    
		    #'checked'	  => set_radio('gender', 'male', TRUE),
	    );
	  	$data4 = array(
		    'name'        => 'version_clinica_realizado',			    
		    'value'       => 0,
		    #'checked'	  => set_radio('gender', 'female', TRUE),		    
		    );	 
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
				<td colspan='5' style='font-weight:bold;'>AUTOEVALUACION</td>
			</tr>
		</thead>
		<tbody>
			<tr>		
				<td>Realizado: </td>
				<td colspan='4'>
					<?= form_radio($data,$data['value'],set_radio($data['name'], 1, true)); ?> Si
					<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
				</td>
			</tr>
			<tr>
				<td>Fecha: </td>
				<td colspan='4'><?= form_input(array('type'=>'text','name'=>'autoevaluacion_fecha', 'id'=>'autoevaluacion_fecha', 'value'=>set_value('autoevaluacion_fecha'))); ?></td>
			</tr>
			<tr>
				<td style='font-weight:bold;background-color:#ccc'></td>
				<td style='font-weight:bold;background-color:#ccc'>No, en absoluto</td>
				<td style='font-weight:bold;background-color:#ccc'>Levemente</td>
				<td style='font-weight:bold;background-color:#ccc'>Algo</td>
				<td style='font-weight:bold;background-color:#ccc'>Mucho</td>
			</tr>
			<tr>
				<td>1. Tengo interés en las cosas.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_1','3',set_radio('autoevaluacion_1','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_1','2',set_radio('autoevaluacion_1','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_1','1',set_radio('autoevaluacion_1','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_1','0',set_radio('autoevaluacion_1','0')); ?></td>
			</tr>
			<tr>
				<td>2. Logro hacer las cosas durante el día.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_2','3',set_radio('autoevaluacion_2','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_2','2',set_radio('autoevaluacion_2','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_2','1',set_radio('autoevaluacion_2','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_2','0',set_radio('autoevaluacion_2','0')); ?></td>
			</tr>
			<tr>
				<td>3. Tomar iniciativas por mi propia cuenta es importante para mí.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_3','3',set_radio('autoevaluacion_3','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_3','2',set_radio('autoevaluacion_3','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_3','1',set_radio('autoevaluacion_3','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_3','0',set_radio('autoevaluacion_3','0')); ?></td>
			</tr>
			<tr>
				<td>4. Estoy interesado en tener nuevas experiencias.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_4','3',set_radio('autoevaluacion_4','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_4','2',set_radio('autoevaluacion_4','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_4','1',set_radio('autoevaluacion_4','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_4','0',set_radio('autoevaluacion_4','0')); ?></td>
			</tr>
			<tr>
				<td>5. Tengo interés en aprender cosas nuevas.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_5','3',set_radio('autoevaluacion_5','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_5','2',set_radio('autoevaluacion_5','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_5','1',set_radio('autoevaluacion_5','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_5','0',set_radio('autoevaluacion_5','0')); ?></td>
			</tr>
			<tr>
				<td>6. Pongo poco empeño en cualquier cosa que hago.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_6','3',set_radio('autoevaluacion_6','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_6','2',set_radio('autoevaluacion_6','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_6','1',set_radio('autoevaluacion_6','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_6','0',set_radio('autoevaluacion_6','0')); ?></td>
			</tr>
			<tr>
				<td>7. Abordo la vida con intensidad.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_7','3',set_radio('autoevaluacion_7','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_7','2',set_radio('autoevaluacion_7','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_7','1',set_radio('autoevaluacion_7','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_7','0',set_radio('autoevaluacion_7','0')); ?></td>
			</tr>
			<tr>
				<td>8. Es importante para mi visualizar una tarea hasta el final.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_8','3',set_radio('autoevaluacion_8','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_8','2',set_radio('autoevaluacion_8','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_8','1',set_radio('autoevaluacion_8','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_8','0',set_radio('autoevaluacion_8','0')); ?></td>
			</tr>
			<tr>
				<td>9. Ocupo mi tiempo hacienda cosas que me interesan.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_9','3',set_radio('autoevaluacion_9','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_9','2',set_radio('autoevaluacion_9','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_9','1',set_radio('autoevaluacion_9','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_9','0',set_radio('autoevaluacion_9','0')); ?></td>
			</tr>
			<tr>
				<td>10. Alguien me tiene que decir lo que tengo que hacer cada día.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_10','3',set_radio('autoevaluacion_10','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_10','2',set_radio('autoevaluacion_10','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_10','1',set_radio('autoevaluacion_10','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_10','0',set_radio('autoevaluacion_10','0')); ?></td>
			</tr>
			<tr>
				<td>11. Estoy menos preocupado de mis problemas de lo que debiera estar.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_11','3',set_radio('autoevaluacion_11','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_11','2',set_radio('autoevaluacion_11','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_11','1',set_radio('autoevaluacion_11','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_11','0',set_radio('autoevaluacion_11','0')); ?></td>
			</tr>
			<tr>
				<td>12. Tengo amigos.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_12','3',set_radio('autoevaluacion_12','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_12','2',set_radio('autoevaluacion_12','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_12','1',set_radio('autoevaluacion_12','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_12','0',set_radio('autoevaluacion_12','0')); ?></td>
			</tr>
			<tr>
				<td>13. Juntarme con mis amigos es importante para mí.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_13','3',set_radio('autoevaluacion_13','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_13','2',set_radio('autoevaluacion_13','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_13','1',set_radio('autoevaluacion_13','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_13','0',set_radio('autoevaluacion_13','0')); ?></td>
			</tr>
			<tr>
				<td>14. Cuando algo Bueno ocurre, me alegro.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_14','3',set_radio('autoevaluacion_14','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_14','2',set_radio('autoevaluacion_14','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_14','1',set_radio('autoevaluacion_14','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_14','0',set_radio('autoevaluacion_14','0')); ?></td>
			</tr>
			<tr>
				<td>15. Tengo una comprensión clara de mis problemas.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_15','3',set_radio('autoevaluacion_15','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_15','2',set_radio('autoevaluacion_15','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_15','1',set_radio('autoevaluacion_15','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_15','0',set_radio('autoevaluacion_15','0')); ?></td>
			</tr>
			<tr>
				<td>16. Resolver las cosas durante el día es importante para mi.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_16','3',set_radio('autoevaluacion_16','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_16','2',set_radio('autoevaluacion_16','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_16','1',set_radio('autoevaluacion_16','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_16','0',set_radio('autoevaluacion_16','0')); ?></td>
			</tr>
			<tr>
				<td>17. Tengo iniciativa.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_17','3',set_radio('autoevaluacion_17','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_17','2',set_radio('autoevaluacion_17','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_17','1',set_radio('autoevaluacion_17','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_17','0',set_radio('autoevaluacion_17','0')); ?></td>
			</tr>
			<tr>
				<td>18. Tengo motivación.</td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_18','3',set_radio('autoevaluacion_18','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_18','2',set_radio('autoevaluacion_18','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_18','1',set_radio('autoevaluacion_18','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('autoevaluacion_18','0',set_radio('autoevaluacion_18','0')); ?></td>
			</tr>
			<tr>
				<td style='font-weight:bold;'>RESULTADO: </td>
				<td id='autoevaluacion_resultado' colspan='4' style='font-weight:bold;'></td>
			</tr>
		</tbody>
	</table>
	
	<table class="table table-bordered table-striped table-hover">
		<thead>
			<tr>
				<td colspan='5' style='font-weight:bold;'>VERSION CLINICA</td>
			</tr>
		</thead>
		<tbody>
			<tr>		
				<td>Realizado: </td>
				<td colspan='4'>
					<?= form_radio($data3,$data3['value'],set_radio($data3['name'], 1, true)); ?> Si
					<?= form_radio($data4,$data4['value'],set_radio($data4['name'], 0)); ?> NO
				</td>
			</tr>
			<tr>
				<td>Fecha: </td>
				<td colspan='4'><?= form_input(array('type'=>'text','name'=>'version_clinica_fecha', 'id'=>'version_clinica_fecha', 'value'=>set_value('version_clinica_fecha'))); ?></td>
			</tr>
			<tr>
				<td style='font-weight:bold;background-color:#ccc'></td>
				<td style='font-weight:bold;background-color:#ccc'>No, en absoluto</td>
				<td style='font-weight:bold;background-color:#ccc'>Levemente</td>
				<td style='font-weight:bold;background-color:#ccc'>Algo</td>
				<td style='font-weight:bold;background-color:#ccc'>Mucho</td>
			</tr>
			<tr>
				<td>1. Está Interesado en cosas.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_1','3',set_radio('version_clinica_1','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_1','2',set_radio('version_clinica_1','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_1','1',set_radio('version_clinica_1','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_1','0',set_radio('version_clinica_1','0')); ?></td>
			</tr>
			<tr>
				<td>2. El/ella logra hacer cosas durante el día. </td>
				<td style='text-align:center;'><?= form_radio('version_clinica_2','3',set_radio('version_clinica_2','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_2','2',set_radio('version_clinica_2','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_2','1',set_radio('version_clinica_2','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_2','0',set_radio('version_clinica_2','0')); ?></td>
			</tr>
			<tr>
				<td>3. Tomar iniciativas por el/ella mismo/a es importante para el/ella. </td>
				<td style='text-align:center;'><?= form_radio('version_clinica_3','3',set_radio('version_clinica_3','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_3','2',set_radio('version_clinica_3','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_3','1',set_radio('version_clinica_3','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_3','0',set_radio('version_clinica_3','0')); ?></td>
			</tr>
			<tr>
				<td>4. El/ ella tiene interés en tener nuevas experiencias. </td>
				<td style='text-align:center;'><?= form_radio('version_clinica_4','3',set_radio('version_clinica_4','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_4','2',set_radio('version_clinica_4','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_4','1',set_radio('version_clinica_4','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_4','0',set_radio('version_clinica_4','0')); ?></td>
			</tr>
			<tr>
				<td>5. El/ella tiene interés en aprender cosas nuevas.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_5','3',set_radio('version_clinica_5','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_5','2',set_radio('version_clinica_5','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_5','1',set_radio('version_clinica_5','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_5','0',set_radio('version_clinica_5','0')); ?></td>
			</tr>
			<tr>
				<td>6. El/ella pone poco empeño en cualquier cosa que hace.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_6','3',set_radio('version_clinica_6','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_6','2',set_radio('version_clinica_6','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_6','1',set_radio('version_clinica_6','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_6','0',set_radio('version_clinica_6','0')); ?></td>
			</tr>
			<tr>
				<td>7. El/ella aborda la vida con intensidad. </td>
				<td style='text-align:center;'><?= form_radio('version_clinica_7','3',set_radio('version_clinica_7','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_7','2',set_radio('version_clinica_7','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_7','1',set_radio('version_clinica_7','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_7','0',set_radio('version_clinica_7','0')); ?></td>
			</tr>
			<tr>
				<td>8. Es importante para el/ella visualizar una tarea hasta el final. </td>
				<td style='text-align:center;'><?= form_radio('version_clinica_8','3',set_radio('version_clinica_8','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_8','2',set_radio('version_clinica_8','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_8','1',set_radio('version_clinica_8','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_8','0',set_radio('version_clinica_8','0')); ?></td>
			</tr>
			<tr>
				<td>9. El/ella ocupa su tiempo haciendo cosas que le interesan. </td>
				<td style='text-align:center;'><?= form_radio('version_clinica_9','3',set_radio('version_clinica_9','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_9','2',set_radio('version_clinica_9','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_9','1',set_radio('version_clinica_9','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_9','0',set_radio('version_clinica_9','0')); ?></td>
			</tr>
			<tr>
				<td>10. Alguien le tiene que decir lo que tiene que hacer cada día.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_10','3',set_radio('version_clinica_10','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_10','2',set_radio('version_clinica_10','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_10','1',set_radio('version_clinica_10','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_10','0',set_radio('version_clinica_10','0')); ?></td>
			</tr>
			<tr>
				<td>11. El/ella está menos preocupado de sus problemas de lo que debería estar. </td>
				<td style='text-align:center;'><?= form_radio('version_clinica_11','3',set_radio('version_clinica_11','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_11','2',set_radio('version_clinica_11','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_11','1',set_radio('version_clinica_11','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_11','0',set_radio('version_clinica_11','0')); ?></td>
			</tr>
			<tr>
				<td>12. El/ella tiene amigos.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_12','3',set_radio('version_clinica_12','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_12','2',set_radio('version_clinica_12','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_12','1',set_radio('version_clinica_12','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_12','0',set_radio('version_clinica_12','0')); ?></td>
			</tr>
			<tr>
				<td>13. Juntarse con amigos es importante para él/ella.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_13','3',set_radio('version_clinica_13','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_13','2',set_radio('version_clinica_13','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_13','1',set_radio('version_clinica_13','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_13','0',set_radio('version_clinica_13','0')); ?></td>
			</tr>
			<tr>
				<td>14. Cuando algo Bueno ocurre el/ella se alegra.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_14','3',set_radio('version_clinica_14','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_14','2',set_radio('version_clinica_14','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_14','1',set_radio('version_clinica_14','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_14','0',set_radio('version_clinica_14','0')); ?></td>
			</tr>
			<tr>
				<td>15. El/ella tiene una comprensión clara de sus problemas.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_15','3',set_radio('version_clinica_15','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_15','2',set_radio('version_clinica_15','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_15','1',set_radio('version_clinica_15','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_15','0',set_radio('version_clinica_15','0')); ?></td>
			</tr>
			<tr>
				<td>16. Resolver las cosas durante el día es importante para él/ ella.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_16','3',set_radio('version_clinica_16','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_16','2',set_radio('version_clinica_16','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_16','1',set_radio('version_clinica_16','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_16','0',set_radio('version_clinica_16','0')); ?></td>
			</tr>
			<tr>
				<td>17. El/ella tiene iniciativa.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_17','3',set_radio('version_clinica_17','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_17','2',set_radio('version_clinica_17','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_17','1',set_radio('version_clinica_17','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_17','0',set_radio('version_clinica_17','0')); ?></td>
			</tr>
			<tr>
				<td>18. El/ella tiene motivación.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_18','3',set_radio('version_clinica_18','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_18','2',set_radio('version_clinica_18','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_18','1',set_radio('version_clinica_18','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_18','0',set_radio('version_clinica_18','0')); ?></td>
			</tr>
			<tr>
				<td style='font-weight:bold;'>RESULTADO: </td>
				<td id='version_clinica_resultado' colspan='4' style='font-weight:bold;'></td>
			</tr>
		</tbody>
	</table>

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
				<td style='font-weight:bold;background-color:#ccc'>No, en absoluto</td>
				<td style='font-weight:bold;background-color:#ccc'>Levemente</td>
				<td style='font-weight:bold;background-color:#ccc'>Algo</td>
				<td style='font-weight:bold;background-color:#ccc'>Mucho</td>
			</tr>
			<tr>
				<td>1. El/ella tiene interés en las cosas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_1','3',set_radio('apatia_1','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_1','2',set_radio('apatia_1','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_1','1',set_radio('apatia_1','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_1','0',set_radio('apatia_1','0')); ?></td>
			</tr>
			<tr>
				<td>2. Hace cosas durante el día.</td>
				<td style='text-align:center;'><?= form_radio('apatia_2','3',set_radio('apatia_2','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_2','2',set_radio('apatia_2','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_2','1',set_radio('apatia_2','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_2','0',set_radio('apatia_2','0')); ?></td>
			</tr>
			<tr>
				<td>3. Comienza a hacer cosas que son importantes para él / ella.</td>
				<td style='text-align:center;'><?= form_radio('apatia_3','3',set_radio('apatia_3','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_3','2',set_radio('apatia_3','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_3','1',set_radio('apatia_3','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_3','0',set_radio('apatia_3','0')); ?></td>
			</tr>
			<tr>
				<td>4. Está interesado en tener cosas nuevas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_4','3',set_radio('apatia_4','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_4','2',set_radio('apatia_4','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_4','1',set_radio('apatia_4','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_4','0',set_radio('apatia_4','0')); ?></td>
			</tr>
			<tr>
				<td>5. Esta interesado en aprender cosas nuevas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_5','3',set_radio('apatia_5','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_5','2',set_radio('apatia_5','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_5','1',set_radio('apatia_5','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_5','0',set_radio('apatia_5','0')); ?></td>
			</tr>
			<tr>
				<td>6. Pone poco esfuerzo en las cosas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_6','3',set_radio('apatia_6','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_6','2',set_radio('apatia_6','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_6','1',set_radio('apatia_6','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_6','0',set_radio('apatia_6','0')); ?></td>
			</tr>
			<tr>
				<td>7. Se enfrenta a la vida con intensidad.</td>
				<td style='text-align:center;'><?= form_radio('apatia_7','3',set_radio('apatia_7','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_7','2',set_radio('apatia_7','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_7','1',set_radio('apatia_7','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_7','0',set_radio('apatia_7','0')); ?></td>
			</tr>
			<tr>
				<td>8. Termina los trabajos que son importantes para él / ella.</td>
				<td style='text-align:center;'><?= form_radio('apatia_8','3',set_radio('apatia_8','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_8','2',set_radio('apatia_8','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_8','1',set_radio('apatia_8','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_8','0',set_radio('apatia_8','0')); ?></td>
			</tr>
			<tr>
				<td>9. Ocupa su tiempo haciendo cosas que son de su interés.</td>
				<td style='text-align:center;'><?= form_radio('apatia_9','3',set_radio('apatia_9','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_9','2',set_radio('apatia_9','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_9','1',set_radio('apatia_9','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_9','0',set_radio('apatia_9','0')); ?></td>
			</tr>
			<tr>
				<td>10. Alguien debe decirle lo que hacer cada día.</td>
				<td style='text-align:center;'><?= form_radio('apatia_10','3',set_radio('apatia_10','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_10','2',set_radio('apatia_10','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_10','1',set_radio('apatia_10','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_10','0',set_radio('apatia_10','0')); ?></td>
			</tr>
			<tr>
				<td>11. Esta menos preocupada de sus problemas que lo que debiera.</td>
				<td style='text-align:center;'><?= form_radio('apatia_11','3',set_radio('apatia_11','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_11','2',set_radio('apatia_11','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_11','1',set_radio('apatia_11','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_11','0',set_radio('apatia_11','0')); ?></td>
			</tr>
			<tr>
				<td>12. Tiene amigos.</td>
				<td style='text-align:center;'><?= form_radio('apatia_12','3',set_radio('apatia_12','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_12','2',set_radio('apatia_12','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_12','1',set_radio('apatia_12','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_12','0',set_radio('apatia_12','0')); ?></td>
			</tr>
			<tr>
				<td>13. Estar junto a sus amigos es importante para él / ella.</td>
				<td style='text-align:center;'><?= form_radio('apatia_13','3',set_radio('apatia_13','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_13','2',set_radio('apatia_13','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_13','1',set_radio('apatia_13','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_13','0',set_radio('apatia_13','0')); ?></td>
			</tr>
			<tr>
				<td>14. Cuando algo bueno pasa, él / ella se alegra.</td>
				<td style='text-align:center;'><?= form_radio('apatia_14','3',set_radio('apatia_14','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_14','2',set_radio('apatia_14','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_14','1',set_radio('apatia_14','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_14','0',set_radio('apatia_14','0')); ?></td>
			</tr>
			<tr>
				<td>15. Tiene una adecuada comprensión de sus problemas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_15','3',set_radio('apatia_15','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_15','2',set_radio('apatia_15','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_15','1',set_radio('apatia_15','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_15','0',set_radio('apatia_15','0')); ?></td>
			</tr>
			<tr>
				<td>16. Se mantiene, durante el día, haciendo cosas importantes para él / ella.</td>
				<td style='text-align:center;'><?= form_radio('apatia_16','3',set_radio('apatia_16','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_16','2',set_radio('apatia_16','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_16','1',set_radio('apatia_16','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_16','0',set_radio('apatia_16','0')); ?></td>
			</tr>
			<tr>
				<td>17. Tiene iniciativa.</td>
				<td style='text-align:center;'><?= form_radio('apatia_17','3',set_radio('apatia_17','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_17','2',set_radio('apatia_17','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_17','1',set_radio('apatia_17','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_17','0',set_radio('apatia_17','0')); ?></td>
			</tr>
			<tr>
				<td>18. Tiene motivación.</td>
				<td style='text-align:center;'><?= form_radio('apatia_18','3',set_radio('apatia_18','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_18','2',set_radio('apatia_18','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_18','1',set_radio('apatia_18','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_18','0',set_radio('apatia_18','0')); ?></td>
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
				<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
	        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
			</td>
		</tr>
	</table>
<?= form_close(); ?>