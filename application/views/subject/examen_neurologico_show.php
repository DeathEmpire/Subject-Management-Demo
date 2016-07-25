<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_examen_neurologico :input").attr('readonly','readonly');
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_examen_neurologico :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled', 'disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_examen_neurologico :input").attr('readonly','readonly');
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_examen_neurologico :input").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled', 'disabled');
		});
	}

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
				"form": "examen_neurologico",
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
<legend style='text-align:center;'>Examen Neurológico <?= (($etapa != 1 AND $etapa != 5 AND $etapa != 6) ? 'Abreviado' : ''); ?><?= $protocolo;?></legend>
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

<?php
	if(isset($list) AND !empty($list)){
?>	
<?= form_open('subject/examen_neurologico_update', array('class'=>'form-horizontal','id'=>'form_examen_neurologico')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('etapa', $etapa); ?>	
	<?= form_hidden('id', $list[0]->id); ?>
	 
	
		<?php
       		$si = array(
			    'name'        => 'realizado',			    
			    'value'       => 1,		    			    
			    'checked'     => set_radio('realizado', 1, (($list[0]->realizado == 1) ? true : false))
			    );
	   		$no = array(
			    'name'        => 'realizado',			    
			    'value'       => 0,	
			    'checked'     => set_radio('realizado', 0, (($list[0]->realizado == 0) ? true : false))
			    );
	   		$si2 = array(
			    'name'        => 'fecha_examen_misma_visita',			    
			    'value'       => 1,		    			    
			    'checked'     => set_radio('fecha_examen_misma_visita', 1, (($list[0]->fecha_examen_misma_visita == 1) ? true : false))
			    );
	   		$no2 = array(
			    'name'        => 'fecha_examen_misma_visita',			    
			    'value'       => 0,	
			    'checked'     => set_radio('fecha_examen_misma_visita', 0, (($list[0]->fecha_examen_misma_visita == 0) ? true : false))
			    );

	   		$normal_anormal = array(''=>'',
	   								'1'=>'Normal',
	   								'0'=>'Anormal');
       	?>	

		Examen Neurológico realizado <?= form_radio($si); ?> Si <?= form_radio($no); ?> No<br />
		La fecha del examen neurológico es la misma fecha de la visita?	 <?= form_radio($si2); ?> Si <?= form_radio($no2); ?> No<br />
 
		Si la respuesta es “NO”, por favor reporte fecha del examen: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', ((!empty($list[0]->fecha) AND $list[0]->fecha !='0000-00-00') ? date("d/m/Y", strtotime($list[0]->fecha)) : "") ))); ?>
		<?php
			if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
			{
				
				if(!in_array("fecha", $campos_query))  
				{
					if(strpos($_SESSION['role_options']['subject'], 'examen_neurologico_verify')){
						echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_query' tipo='new' class='query'>";	
					}
					else{
						echo "<img src='". base_url('img/icon-check.png') ."'>";		
					}
					
				}
				else 
				{	
					if (strpos($_SESSION['role_options']['subject'], 'examen_neurologico_update')){					
						echo "<img src='". base_url('img/question.png') ."' id='fecha_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
					}
					else{
						echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
					}
				}						
				
			}
		?>
		<br />
		<table class='table table-bordered table-striped table-hover'>
			<tr>
				<th>Examen</th>
				<th>Normal/Anormal</th>
				<th>Detallar si es “Anormal” y clínicamente significativo</th>
			</tr>
			<tr>
				<td>Nervios craneales</td>
				<td><?= form_dropdown("nervios_craneanos_normal_anormal",$normal_anormal,set_value('nervios_craneanos_normal_anormal',$list[0]->nervios_craneanos_normal_anormal)); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'nervios_craneanos', 'id'=>'nervios_craneanos', 'value'=>set_value('nervios_craneanos',$list[0]->nervios_craneanos)));?>
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("nervios_craneanos", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'examen_neurologico_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='nervios_craneanos_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'examen_neurologico_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='nervios_craneanos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
			</tr>
			<?php if($etapa == 1 OR $etapa == 5 OR $etapa == 6){ ?>
				<tr>
					<td>Fuerza muscular</td>
					<td><?= form_dropdown("fuerza_muscular_normal_anormal",$normal_anormal,set_value('fuerza_muscular_normal_anormal',$list[0]->fuerza_muscular_normal_anormal)); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'fuerza_muscular', 'id'=>'fuerza_muscular', 'value'=>set_value('fuerza_muscular',$list[0]->fuerza_muscular)));?>
					<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("fuerza_muscular", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'examen_neurologico_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='fuerza_muscular_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'examen_neurologico_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='fuerza_muscular_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Tono</td>
					<td><?= form_dropdown("tono_normal_anormal",$normal_anormal,set_value('tono_normal_anormal',$list[0]->tono_normal_anormal)); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'tono', 'id'=>'tono', 'value'=>set_value('tono',$list[0]->tono)));?>
					<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("tono", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'examen_neurologico_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='tono_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'examen_neurologico_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='tono_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Movimientos anormales</td>
					<td><?= form_dropdown("mov_anormales_normal_anormal",$normal_anormal,set_value('mov_anormales_normal_anormal',$list[0]->mov_anormales_normal_anormal)); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'mov_anormales', 'id'=>'mov_anormales', 'value'=>set_value('mov_anormales',$list[0]->mov_anormales)));?>
					<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("mov_anormales", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'examen_neurologico_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='mov_anormales_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'examen_neurologico_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='mov_anormales_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
				</tr>
			<?php } else { ?>
					<?= form_hidden('fuerza_muscular_normal_anormal','0'); ?>
					<?= form_hidden('fuerza_muscular',''); ?>
					<?= form_hidden('tono_normal_anormal','0'); ?>
					<?= form_hidden('tono',''); ?>
					<?= form_hidden('mov_anormales_normal_anormal','0'); ?>
					<?= form_hidden('mov_anormales',''); ?>
			<?php } 
			if($etapa > 1 OR $etapa == 5 OR $etapa == 6){ ?>
				<tr>
					<td>Función motora</td>
					<td><?= form_dropdown("motora_normal_anormal",$normal_anormal,set_value('motora_normal_anormal',$list[0]->motora_normal_anormal)); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'motora', 'id'=>'motora', 'value'=>set_value('motora',$list[0]->motora)));?>
					<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("motora", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'examen_neurologico_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='motora_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'examen_neurologico_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='motora_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
				</tr>
			<?php }else{ ?>
				<?= form_hidden('motora_normal_anormal','0'); ?>
				<?= form_hidden('motora',''); ?>
			<?php } ?>
			<tr>
				<td>Reflejos tendinosos profundos</td>
				<td><?= form_dropdown("reflejos_normal_anormal",$normal_anormal,set_value('reflejos_normal_anormal',$list[0]->reflejos_normal_anormal)); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'reflejos', 'id'=>'reflejos', 'value'=>set_value('reflejos',$list[0]->reflejos)));?>
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("reflejos", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'examen_neurologico_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='reflejos_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'examen_neurologico_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='reflejos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Examen sensorial</td>
				<td><?= form_dropdown("examen_sensitivo_normal_anormal",$normal_anormal,set_value('examen_sensitivo_normal_anormal',$list[0]->examen_sensitivo_normal_anormal)); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'examen_sensitivo', 'id'=>'examen_sensitivo', 'value'=>set_value('examen_sensitivo',$list[0]->examen_sensitivo)));?>
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("examen_sensitivo", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'examen_neurologico_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='examen_sensitivo_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'examen_neurologico_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='examen_sensitivo_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
			</tr>
			<?php if($etapa == 1 OR $etapa == 5 OR $etapa == 6){ ?>
				<tr>
					<td>Coordinación</td>
					<td><?= form_dropdown("coordinacion_normal_anormal",$normal_anormal,set_value('coordinacion_normal_anormal',$list[0]->coordinacion_normal_anormal)); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'coordinacion', 'id'=>'coordinacion', 'value'=>set_value('coordinacion',$list[0]->coordinacion)));?>
					<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("coordinacion", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'examen_neurologico_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='coordinacion_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'examen_neurologico_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='coordinacion_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Marcha</td>
					<td><?= form_dropdown("marcha_normal_anormal",$normal_anormal,set_value('marcha_normal_anormal',$list[0]->marcha_normal_anormal)); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'marcha', 'id'=>'marcha', 'value'=>set_value('marcha',$list[0]->marcha)));?>
					<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("marcha", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'examen_neurologico_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='marcha_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'examen_neurologico_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='marcha_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Postura</td>
					<td><?= form_dropdown("postura_normal_anormal",$normal_anormal,set_value('postura_normal_anormal',$list[0]->postura_normal_anormal)); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'postura', 'id'=>'postura', 'value'=>set_value('postura',$list[0]->postura)));?>
					<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("postura", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'examen_neurologico_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='postura_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'examen_neurologico_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='postura_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Función cortical superior</td>
					<td><?= form_dropdown("funcion_cerebelosa_normal_anormal",$normal_anormal,set_value('funcion_cerebelosa_normal_anormal',$list[0]->funcion_cerebelosa_normal_anormal)); ?></td>
					<td><?= form_input(array('type'=>'text','name'=>'funcion_cerebelosa', 'id'=>'funcion_cerebelosa', 'value'=>set_value('funcion_cerebelosa',$list[0]->funcion_cerebelosa)));?>
					<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("funcion_cerebelosa", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'examen_neurologico_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='funcion_cerebelosa_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'examen_neurologico_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='funcion_cerebelosa_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
				</tr>
			<?php } else { ?>
					<?= form_hidden('coordinacion_normal_anormal','0'); ?>
					<?= form_hidden('coordinacion',''); ?>
					<?= form_hidden('marcha_normal_anormal','0'); ?>
					<?= form_hidden('marcha',''); ?>
					<?= form_hidden('postura_normal_anormal','0'); ?>
					<?= form_hidden('postura',''); ?>
					<?= form_hidden('funcion_cerebelosa_normal_anormal','0'); ?>
					<?= form_hidden('funcion_cerebelosa',''); ?>
			<?php } ?>	
			<tr>
				<td style='font-weight:bold;' colspan='3'>Anormalidades de significancia clínica en la visita de screening deben reportarse como historia médica si el consentimiento informado está firmado.</td>
			</tr>
			<tr>
				<td style='font-weight:bold;' colspan='3'>Anormalidades de significancia clínica después de la visita de screening deben reportarse como eventos adversos.</td>
			</tr>
			<tr>
				<td colspan='3' style='text-align:center;'>
					<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'examen_neurologico_update')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
            		<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
				</td>
			</tr>
		</table>

		
<?= form_close(); ?>
<?php }?>


<!-- Verify -->
<b>Aprobacion del Monitor:</b><br />
	<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
		
		Formulario aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y",strtotime($list[0]->verify_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'examen_neurologico_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/examen_neurologico_verify', array('class'=>'form-horizontal')); ?>    	
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
		
		Formulario cerrado por <?= $list[0]->lock_user;?> el <?= date("d-M-Y",strtotime($list[0]->lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'examen_neurologico_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/examen_neurologico_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
		<?= form_hidden('id', $list[0]->id); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Cerrar Formulario', 'class'=>'btn btn-primary')); ?>

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
		
		Formulario Firmado por <?= $list[0]->signature_user;?> on <?= date("d-M-Y",strtotime($list[0]->signature_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'examen_neurologico_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/examen_neurologico_signature', array('class'=>'form-horizontal')); ?>
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