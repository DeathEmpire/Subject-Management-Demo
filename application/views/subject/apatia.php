<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#version_clinica_fecha, #apatia_fecha").datepicker({ dateFormat: 'dd/mm/yy' });	

	$("input[name=version_clinica_realizado]").change(function(){
		if($(this).val() == 0){
			$("input[name*=version_clinica]").each(function(){
				
				$(this).prop('readonly', true);
				$(this).prop('disabled', true);

				if($(this).attr('name') != 'version_clinica_realizado' && ($(this).attr('type') == 'text' || $(this).attr('type') == 'select')){
					$(this).val('');
				}
			});
			
			$("input[name=version_clinica_realizado]").prop('readonly', false);
			$("input[name=version_clinica_realizado]").prop('disabled', false);

		}else{
			$("input[name*=version_clinica]").each(function(){
				$(this).prop('readonly', false);
				$(this).prop('disabled', false);
			});
		}
	});
	if($("input[name=version_clinica_realizado]:checked").val() == 0){
		$("input[name*=version_clinica]").each(function(){
				
				$(this).prop('readonly', true);
				$(this).prop('disabled', true);

				if($(this).attr('name') != 'version_clinica_realizado' && ($(this).attr('type') == 'text' || $(this).attr('type') == 'select')){
					$(this).val('');
				}
			});
		$("input[name=version_clinica_realizado]").prop('readonly', false);
		$("input[name=version_clinica_realizado]").prop('disabled', false);

	}else{
		$("input[name*=version_clinica]").each(function(){
			$(this).prop('readonly', false);
			$(this).prop('disabled', false);
		});
	}

	$("input[name=apatia_realizado]").change(function(){
		if($(this).val() == 0){
			$("input[name*=apatia_]").each(function(){
				
				$(this).prop('readonly', true);
				$(this).prop('disabled', true);

				if($(this).attr('name') != 'apatia_realizado' && ($(this).attr('type') == 'text' || $(this).attr('type') == 'select')){
					$(this).val('');
				}
			});
			
			$("input[name=apatia_realizado]").prop('readonly', false);
			$("input[name=apatia_realizado]").prop('disabled', false);

		}else{
			$("input[name*=apatia_]").each(function(){
				$(this).prop('readonly', false);
				$(this).prop('disabled', false);
			});
		}
	});

	if($("input[name=apatia_realizado]:checked").val() == 0){
		$("input[name*=apatia_]").each(function(){
				
				$(this).prop('readonly', true);
				$(this).prop('disabled', true);

				if($(this).attr('name') != 'apatia_realizado' && ($(this).attr('type') == 'text' || $(this).attr('type') == 'select')){
					$(this).val('');
				}
			});
		$("input[name=apatia_realizado]").prop('readonly', false);
		$("input[name=apatia_realizado]").prop('disabled', false);

	}else{
		$("input[name*=apatia_]").each(function(){
			$(this).prop('readonly', false);
			$(this).prop('disabled', false);
		});
	}	
	
	$('input[name^=version_clinica_]').click(function(){
		var total3 = 0;
		 $('input[name^=version_clinica_]').each(function(){
            if (this.checked) {
                total3 += parseInt($(this).val());
            }
        });
		total3 -= parseInt($("input[name=version_clinica_realizado]:checked").val());
		if(!isNaN(total3) && total3 > 0){
			$("#version_clinica_resultado").text(total3);		
		}
	});
	var total4 = 0;
	 $('input[name^=version_clinica_]').each(function(){
        if (this.checked) {
            total4 += parseInt($(this).val());
        }
    });
	total4 -= parseInt($("input[name=version_clinica_realizado]:checked").val());
	if(!isNaN(total4) && total4 > 0){
		$("#version_clinica_resultado").text(total4);
	}

	$('input[name^=apatia_]').click(function(){
		var total5 = 0;
		 $('input[name^=apatia_]').each(function(){
            if (this.checked) {            	
                total5 += parseInt($(this).val());
            }
        });
		total5 -= $("input[name=apatia_realizado]:checked").val();
		
		if(!isNaN(total5) && total5 >= 0){
			$("#apatia_resultado").text(total5);		
		}
	});
	var total6 = 0;
	 $('input[name^=apatia_]').each(function(){
        if (this.checked) {
            total6 += parseInt($(this).val());
        }
    });
	total6 -= parseInt($("input[name=apatia_realizado]:checked").val());
	if(!isNaN(total6) && total6 >= 0){
		$("#apatia_resultado").text(total6);
	}	

    $("#version_clinica_fecha").change(function(){
        var datos = $("input[name=etapa]").val() || 0;
        $.post("<?php echo base_url('subject/fechaEnRango');?>",
                {                   
                    '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>', 
                    "etapa": datos,                 
                    "fecha_randomizacion": "<?php echo ((isset($subject->randomization_date)) ? $subject->randomization_date : '');?>",
                    "fecha": $(this).val()
                },
                function(d){
                    if(d != ''){
                        $("#td_mensaje_desviacion2").html(d);
                        $("#mensaje_desviacion2").show();
                    }
                    else{
                        $("#td_mensaje_desviacion2").html('');
                        $("#mensaje_desviacion2").hide();
                    }
                    
                }
        );
    });

    $("#apatia_fecha").change(function(){
        var datos = $("input[name=etapa]").val() || 0;
        $.post("<?php echo base_url('subject/fechaEnRango');?>",
                {                   
                    '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>', 
                    "etapa": datos,                 
                    "fecha_randomizacion": "<?php echo ((isset($subject->randomization_date)) ? $subject->randomization_date : '');?>",
                    "fecha": $(this).val()
                },
                function(d){
                    if(d != ''){
                        $("#td_mensaje_desviacion3").html(d);
                        $("#mensaje_desviacion3").show();
                    }
                    else{
                        $("#td_mensaje_desviacion3").html('');
                        $("#mensaje_desviacion3").hide();
                    }
                    
                }
        );
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
				<td colspan='5' style='font-weight:bold;'>Escala de Evaluación de Apatía Versión Clínica (AES-C)</td>
			</tr>
		</thead>
		<tbody>
			<tr>		
				<td>Realizado: </td>
				<td colspan='4'>
					<?= form_radio($data3,$data3['value'],set_radio($data3['name'], 1)); ?> Si
					<?= form_radio($data4,$data4['value'],set_radio($data4['name'], 0)); ?> NO
				</td>
			</tr>
			<tr>
				<td>Fecha: </td>
				<td colspan='4'><?= form_input(array('type'=>'text','name'=>'version_clinica_fecha', 'id'=>'version_clinica_fecha', 'value'=>set_value('version_clinica_fecha'))); ?></td>
			</tr>
			<tr id='mensaje_desviacion2' style='display:none;'>
				<td colspan='5' id='td_mensaje_desviacion2' class='alert alert-danger'></td>
			</tr>
			<tr>
				<td style='font-weight:bold;background-color:#ccc'></td>
				<td style='font-weight:bold;background-color:#ccc'>No Característico (1)</td>
				<td style='font-weight:bold;background-color:#ccc'>Levemente Característico (2)</td>
				<td style='font-weight:bold;background-color:#ccc'>Característico (3)</td>
				<td style='font-weight:bold;background-color:#ccc'>Muy Característico (4)</td>
			</tr>
			<tr>
				<td>1. Está Interesado en cosas.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_1','1',set_radio('version_clinica_1','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_1','2',set_radio('version_clinica_1','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_1','3',set_radio('version_clinica_1','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_1','4',set_radio('version_clinica_1','4')); ?></td>
			</tr>
			<tr>
				<td>2. El/ella logra hacer cosas durante el día. </td>
				<td style='text-align:center;'><?= form_radio('version_clinica_2','1',set_radio('version_clinica_2','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_2','2',set_radio('version_clinica_2','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_2','3',set_radio('version_clinica_2','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_2','4',set_radio('version_clinica_2','4')); ?></td>
			</tr>
			<tr>
				<td>3. Tomar iniciativas por el/ella mismo/a es importante para el/ella. </td>
				<td style='text-align:center;'><?= form_radio('version_clinica_3','1',set_radio('version_clinica_3','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_3','2',set_radio('version_clinica_3','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_3','3',set_radio('version_clinica_3','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_3','4',set_radio('version_clinica_3','4')); ?></td>
			</tr>
			<tr>
				<td>4. El/ ella tiene interés en tener nuevas experiencias. </td>
				<td style='text-align:center;'><?= form_radio('version_clinica_4','1',set_radio('version_clinica_4','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_4','2',set_radio('version_clinica_4','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_4','3',set_radio('version_clinica_4','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_4','4',set_radio('version_clinica_4','4')); ?></td>
			</tr>
			<tr>
				<td>5. El/ella tiene interés en aprender cosas nuevas.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_5','1',set_radio('version_clinica_5','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_5','2',set_radio('version_clinica_5','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_5','3',set_radio('version_clinica_5','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_5','4',set_radio('version_clinica_5','4')); ?></td>
			</tr>
			<tr>
				<td>6. El/ella pone poco empeño en cualquier cosa que hace.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_6','1',set_radio('version_clinica_6','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_6','2',set_radio('version_clinica_6','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_6','3',set_radio('version_clinica_6','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_6','4',set_radio('version_clinica_6','4')); ?></td>
			</tr>
			<tr>
				<td>7. El/ella aborda la vida con intensidad. </td>
				<td style='text-align:center;'><?= form_radio('version_clinica_7','1',set_radio('version_clinica_7','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_7','2',set_radio('version_clinica_7','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_7','3',set_radio('version_clinica_7','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_7','4',set_radio('version_clinica_7','4')); ?></td>
			</tr>
			<tr>
				<td>8. Es importante para el/ella visualizar una tarea hasta el final. </td>
				<td style='text-align:center;'><?= form_radio('version_clinica_8','1',set_radio('version_clinica_8','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_8','2',set_radio('version_clinica_8','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_8','3',set_radio('version_clinica_8','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_8','4',set_radio('version_clinica_8','4')); ?></td>
			</tr>
			<tr>
				<td>9. El/ella ocupa su tiempo haciendo cosas que le interesan. </td>
				<td style='text-align:center;'><?= form_radio('version_clinica_9','1',set_radio('version_clinica_9','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_9','2',set_radio('version_clinica_9','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_9','3',set_radio('version_clinica_9','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_9','4',set_radio('version_clinica_9','4')); ?></td>
			</tr>
			<tr>
				<td>10. Alguien le tiene que decir lo que tiene que hacer cada día.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_10','1',set_radio('version_clinica_10','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_10','2',set_radio('version_clinica_10','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_10','3',set_radio('version_clinica_10','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_10','4',set_radio('version_clinica_10','4')); ?></td>
			</tr>
			<tr>
				<td>11. El/ella está menos preocupado de sus problemas de lo que debería estar. </td>
				<td style='text-align:center;'><?= form_radio('version_clinica_11','1',set_radio('version_clinica_11','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_11','2',set_radio('version_clinica_11','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_11','3',set_radio('version_clinica_11','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_11','4',set_radio('version_clinica_11','4')); ?></td>
			</tr>
			<tr>
				<td>12. El/ella tiene amigos.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_12','1',set_radio('version_clinica_12','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_12','2',set_radio('version_clinica_12','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_12','3',set_radio('version_clinica_12','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_12','4',set_radio('version_clinica_12','4')); ?></td>
			</tr>
			<tr>
				<td>13. Juntarse con amigos es importante para él/ella.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_13','1',set_radio('version_clinica_13','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_13','2',set_radio('version_clinica_13','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_13','3',set_radio('version_clinica_13','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_13','4',set_radio('version_clinica_13','4')); ?></td>
			</tr>
			<tr>
				<td>14. Cuando algo Bueno ocurre el/ella se alegra.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_14','1',set_radio('version_clinica_14','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_14','2',set_radio('version_clinica_14','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_14','3',set_radio('version_clinica_14','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_14','4',set_radio('version_clinica_14','4')); ?></td>
			</tr>
			<tr>
				<td>15. El/ella tiene una comprensión clara de sus problemas.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_15','1',set_radio('version_clinica_15','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_15','2',set_radio('version_clinica_15','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_15','3',set_radio('version_clinica_15','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_15','4',set_radio('version_clinica_15','4')); ?></td>
			</tr>
			<tr>
				<td>16. Resolver las cosas durante el día es importante para él/ ella.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_16','1',set_radio('version_clinica_16','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_16','2',set_radio('version_clinica_16','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_16','3',set_radio('version_clinica_16','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_16','4',set_radio('version_clinica_16','4')); ?></td>
			</tr>
			<tr>
				<td>17. El/ella tiene iniciativa.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_17','1',set_radio('version_clinica_17','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_17','2',set_radio('version_clinica_17','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_17','3',set_radio('version_clinica_17','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_17','4',set_radio('version_clinica_17','4')); ?></td>
			</tr>
			<tr>
				<td>18. El/ella tiene motivación.</td>
				<td style='text-align:center;'><?= form_radio('version_clinica_18','1',set_radio('version_clinica_18','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_18','2',set_radio('version_clinica_18','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_18','3',set_radio('version_clinica_18','3')); ?></td>
				<td style='text-align:center;'><?= form_radio('version_clinica_18','4',set_radio('version_clinica_18','4')); ?></td>
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
				<td colspan='5' style='font-weight:bold;'>Escala de Evaluación de Apatía Versión Informante (AES-I)</td>
			</tr>
		</thead>
		<tbody>
			<tr>		
				<td>Realizado: </td>
				<td colspan='4'>
					<?= form_radio($data5,$data5['value'],set_radio($data5['name'], 1)); ?> Si
					<?= form_radio($data6,$data6['value'],set_radio($data6['name'], 0)); ?> NO
				</td>
			</tr>
			<tr>
				<td>Fecha: </td>
				<td colspan='4'><?= form_input(array('type'=>'text','name'=>'apatia_fecha', 'id'=>'apatia_fecha', 'value'=>set_value('apatia_fecha'))); ?></td>
			</tr>
			<tr id='mensaje_desviacion3' style='display:none;'>
				<td colspan='5' id='td_mensaje_desviacion3' class='alert alert-danger'></td>
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
				<td style='text-align:center;'><?= form_radio('apatia_6','0',set_radio('apatia_6','0')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_6','1',set_radio('apatia_6','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_6','2',set_radio('apatia_6','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_6','3',set_radio('apatia_6','3')); ?></td>
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
				<td style='text-align:center;'><?= form_radio('apatia_10','0',set_radio('apatia_10','0')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_10','1',set_radio('apatia_10','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_10','2',set_radio('apatia_10','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_10','3',set_radio('apatia_10','3')); ?></td>
			</tr>
			<tr>
				<td>11. Esta menos preocupada de sus problemas que lo que debiera.</td>
				<td style='text-align:center;'><?= form_radio('apatia_11','0',set_radio('apatia_11','0')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_11','1',set_radio('apatia_11','1')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_11','2',set_radio('apatia_11','2')); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_11','3',set_radio('apatia_11','3')); ?></td>
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