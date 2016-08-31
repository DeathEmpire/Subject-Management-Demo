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

	$("#query_para_campos").dialog({
		autoOpen: false,
		height: 340,
		width: 550
	});

	$(".query").click(function(){
		var campo = $(this).attr('id').split("_query");
		$.post("<?php echo base_url('query/query'); ?>",
			{
				'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>', 
				"campo": campo[0], 
				"etapa": "<?php echo $etapa;?>",
				"subject_id": $("input[name=subject_id]").val(),
				"form": "apatia",
				"form_nombre" : "Escalas de apatia",
				"form_id" : '<?php echo $list[0]->id;?>',
				"tipo": $(this).attr('tipo')
			},
			function(d){
				
				$("#query_para_campos").html(d);
				$("#query_para_campos").dialog('open');
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
<div id='query_para_campos' style='display:none;'></div>
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
<div style='display:none;'>
	<div id='dialog_auditoria'><?= ((isset($auditoria) AND !empty($auditoria)) ? $auditoria : ''); ?></div>
</div>
<?php
	if(isset($auditoria) AND !empty($auditoria)){
		echo "<div style='text-align:right;'><a id='ver_auditoria' class='btn btn-info colorbox_inline' href='#dialog_auditoria'>Ver Auditoria</a></div>";
	}
?>
<?= form_open('subject/apatia_update', array('class'=>'form-horizontal', 'id'=>'form_apatia')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('etapa', $etapa); ?>	
	<?= form_hidden('id', $list[0]->id); ?>	
	<?= form_hidden('last_status', $list[0]->status); ?>
	<?php
		
		$data5 = array(
		    'name'        => 'apatia_realizado',			    
		    'value'       => 1,		    
		    'checked'     => set_radio('apatia_realizado', 1, (($list[0]->apatia_realizado == 1) ? true : false))
	    );
	  	$data6 = array(
		    'name'        => 'apatia_realizado',			    
		    'value'       => 0,
		   	'checked'     => set_radio('apatia_realizado', 0, (($list[0]->apatia_realizado == 0) ? true : false))
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
				<td colspan='4'><?= form_input(array('type'=>'text','name'=>'apatia_fecha', 'id'=>'apatia_fecha', 'value'=>set_value('apatia_fecha', ((!empty($list[0]->apatia_fecha) AND $list[0]->apatia_fecha !='0000-00-00') ? date("d/m/Y", strtotime($list[0]->apatia_fecha)) : "") ))); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_fecha", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_fecha_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_fecha_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td style='font-weight:bold;background-color:#ccc'></td>
				<td style='font-weight:bold;background-color:#ccc'>No es verdadero</td>
				<td style='font-weight:bold;background-color:#ccc'>Levemente verdadero</td>
				<td style='font-weight:bold;background-color:#ccc'>Parcialmente verdadero</td>
				<td style='font-weight:bold;background-color:#ccc'>Verdadero</td>
				<td>&nbsp;&nbsp;&nbsp;</td>
			</tr>
			<tr>
				<td>1. El/ella tiene interés en las cosas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_1','3',set_radio('apatia_1','3', (($list[0]->apatia_1 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_1','2',set_radio('apatia_1','2', (($list[0]->apatia_1 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_1','1',set_radio('apatia_1','1', (($list[0]->apatia_1 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_1','0',set_radio('apatia_1','0', (($list[0]->apatia_1 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_1", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_1_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_1_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>2. Hace cosas durante el día.</td>
				<td style='text-align:center;'><?= form_radio('apatia_2','3',set_radio('apatia_2','3', (($list[0]->apatia_2 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_2','2',set_radio('apatia_2','2', (($list[0]->apatia_2 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_2','1',set_radio('apatia_2','1', (($list[0]->apatia_2 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_2','0',set_radio('apatia_2','0', (($list[0]->apatia_2 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_2", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_2_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_2_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>3. Comienza a hacer cosas que son importantes para él / ella.</td>
				<td style='text-align:center;'><?= form_radio('apatia_3','3',set_radio('apatia_3','3', (($list[0]->apatia_3 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_3','2',set_radio('apatia_3','2', (($list[0]->apatia_3 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_3','1',set_radio('apatia_3','1', (($list[0]->apatia_3 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_3','0',set_radio('apatia_3','0', (($list[0]->apatia_3 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_3", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_3_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_3_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>4. Está interesado en tener cosas nuevas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_4','3',set_radio('apatia_4','3', (($list[0]->apatia_4 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_4','2',set_radio('apatia_4','2', (($list[0]->apatia_4 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_4','1',set_radio('apatia_4','1', (($list[0]->apatia_4 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_4','0',set_radio('apatia_4','0', (($list[0]->apatia_4 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_4", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_4_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_4_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>5. Esta interesado en aprender cosas nuevas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_5','3',set_radio('apatia_5','3', (($list[0]->apatia_5 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_5','2',set_radio('apatia_5','2', (($list[0]->apatia_5 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_5','1',set_radio('apatia_5','1', (($list[0]->apatia_5 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_5','0',set_radio('apatia_5','0', (($list[0]->apatia_5 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_5", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_5_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_5_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>6. Pone poco esfuerzo en las cosas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_6','0',set_radio('apatia_6','0', (($list[0]->apatia_6 == 1) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_6','1',set_radio('apatia_6','1', (($list[0]->apatia_6 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_6','2',set_radio('apatia_6','2', (($list[0]->apatia_6 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_6','3',set_radio('apatia_6','3', (($list[0]->apatia_6 == 4) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_6", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_6_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_6_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>7. Se enfrenta a la vida con intensidad.</td>
				<td style='text-align:center;'><?= form_radio('apatia_7','3',set_radio('apatia_7','3', (($list[0]->apatia_7 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_7','2',set_radio('apatia_7','2', (($list[0]->apatia_7 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_7','1',set_radio('apatia_7','1', (($list[0]->apatia_7 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_7','0',set_radio('apatia_7','0', (($list[0]->apatia_7 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_7", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_7_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_7_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>8. Termina los trabajos que son importantes para él / ella.</td>
				<td style='text-align:center;'><?= form_radio('apatia_8','3',set_radio('apatia_8','3', (($list[0]->apatia_8 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_8','2',set_radio('apatia_8','2', (($list[0]->apatia_8 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_8','1',set_radio('apatia_8','1', (($list[0]->apatia_8 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_8','0',set_radio('apatia_8','0', (($list[0]->apatia_8 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_8", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_8_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_8_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>9. Ocupa su tiempo haciendo cosas que son de su interés.</td>
				<td style='text-align:center;'><?= form_radio('apatia_9','3',set_radio('apatia_9','3', (($list[0]->apatia_9 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_9','2',set_radio('apatia_9','2', (($list[0]->apatia_9 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_9','1',set_radio('apatia_9','1', (($list[0]->apatia_9 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_9','0',set_radio('apatia_9','0', (($list[0]->apatia_9 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_9", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_9_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_9_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>10. Alguien debe decirle lo que hacer cada día.</td>
				<td style='text-align:center;'><?= form_radio('apatia_10','0',set_radio('apatia_10','0', (($list[0]->apatia_10 == 1) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_10','1',set_radio('apatia_10','1', (($list[0]->apatia_10 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_10','2',set_radio('apatia_10','2', (($list[0]->apatia_10 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_10','3',set_radio('apatia_10','3', (($list[0]->apatia_10 == 4) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_10", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_10_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_10_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>11. Esta menos preocupada de sus problemas que lo que debiera.</td>
				<td style='text-align:center;'><?= form_radio('apatia_11','0',set_radio('apatia_11','0', (($list[0]->apatia_11 == 1) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_11','1',set_radio('apatia_11','1', (($list[0]->apatia_11 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_11','2',set_radio('apatia_11','2', (($list[0]->apatia_11 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_11','3',set_radio('apatia_11','3', (($list[0]->apatia_11 == 4) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_11", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_11_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_11_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>12. Tiene amigos.</td>
				<td style='text-align:center;'><?= form_radio('apatia_12','3',set_radio('apatia_12','3', (($list[0]->apatia_12 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_12','2',set_radio('apatia_12','2', (($list[0]->apatia_12 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_12','1',set_radio('apatia_12','1', (($list[0]->apatia_12 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_12','0',set_radio('apatia_12','0', (($list[0]->apatia_12 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_12", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_12_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_12_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>13. Estar junto a sus amigos es importante para él / ella.</td>
				<td style='text-align:center;'><?= form_radio('apatia_13','3',set_radio('apatia_13','3', (($list[0]->apatia_13 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_13','2',set_radio('apatia_13','2', (($list[0]->apatia_13 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_13','1',set_radio('apatia_13','1', (($list[0]->apatia_13 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_13','0',set_radio('apatia_13','0', (($list[0]->apatia_13 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_13", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_13_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_13_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>14. Cuando algo bueno pasa, él / ella se alegra.</td>
				<td style='text-align:center;'><?= form_radio('apatia_14','3',set_radio('apatia_14','3', (($list[0]->apatia_14 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_14','2',set_radio('apatia_14','2', (($list[0]->apatia_14 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_14','1',set_radio('apatia_14','1', (($list[0]->apatia_14 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_14','0',set_radio('apatia_14','0', (($list[0]->apatia_14 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_14", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_14_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_14_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>15. Tiene una adecuada comprensión de sus problemas.</td>
				<td style='text-align:center;'><?= form_radio('apatia_15','3',set_radio('apatia_15','3', (($list[0]->apatia_15 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_15','2',set_radio('apatia_15','2', (($list[0]->apatia_15 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_15','1',set_radio('apatia_15','1', (($list[0]->apatia_15 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_15','0',set_radio('apatia_15','0', (($list[0]->apatia_15 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_15", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_15_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_15_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>16. Se mantiene, durante el día, haciendo cosas importantes para él / ella.</td>
				<td style='text-align:center;'><?= form_radio('apatia_16','3',set_radio('apatia_16','3', (($list[0]->apatia_16 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_16','2',set_radio('apatia_16','2', (($list[0]->apatia_16 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_16','1',set_radio('apatia_16','1', (($list[0]->apatia_16 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_16','0',set_radio('apatia_16','0', (($list[0]->apatia_16 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_16", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_16_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_16_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>17. Tiene iniciativa.</td>
				<td style='text-align:center;'><?= form_radio('apatia_17','3',set_radio('apatia_17','3', (($list[0]->apatia_17 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_17','2',set_radio('apatia_17','2', (($list[0]->apatia_17 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_17','1',set_radio('apatia_17','1', (($list[0]->apatia_17 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_17','0',set_radio('apatia_17','0', (($list[0]->apatia_17 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_17", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_17_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_17_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>
			<tr>
				<td>18. Tiene motivación.</td>
				<td style='text-align:center;'><?= form_radio('apatia_18','3',set_radio('apatia_18','3', (($list[0]->apatia_18 == 4) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_18','2',set_radio('apatia_18','2', (($list[0]->apatia_18 == 3) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_18','1',set_radio('apatia_18','1', (($list[0]->apatia_18 == 2) ? true : false))); ?></td>
				<td style='text-align:center;'><?= form_radio('apatia_18','0',set_radio('apatia_18','0', (($list[0]->apatia_18 == 1) ? true : false))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("apatia_18", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'apatia_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='apatia_18_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if (strpos($_SESSION['role_options']['subject'], 'apatia_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='apatia_18_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
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
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'apatia_update')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>

	        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
			</td>
		</tr>
	</table>
<?= form_close(); ?>
<b>Creado por:</b> <?= $list[0]->usuario_creacion;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->created_at));?><br />&nbsp;</br>
<!-- Verify -->
<b>Aprobacion del Monitor:</b><br />
	<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
		
		Formulario aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->verify_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'apatia_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/apatia_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
		<?= form_hidden('id', $list[0]->id); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Verificar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Aprobacion";
		}
	}
?>
<br />

<!--Signature/Lock-->
<br /><b>Cierre:</b><br />
	<?php if(!empty($list[0]->lock_user) AND !empty($list[0]->lock_date)){ ?>
		
		Formulario cerrado por <?= $list[0]->lock_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'apatia_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/apatia_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
		<?= form_hidden('id', $list[0]->id); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Cerrar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Cierre";
		}
	}
?>
<br />
<!--Signature-->
	<br /><b>Firma:</b><br />
	<?php if(!empty($list[0]->signature_user) AND !empty($list[0]->signature_date)){ ?>
		
		Formulario Firmado por <?= $list[0]->signature_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->signature_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'apatia_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/apatia_signature', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
		<?= form_hidden('id', $list[0]->id); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Firma";
		}
	}
?>
<br />