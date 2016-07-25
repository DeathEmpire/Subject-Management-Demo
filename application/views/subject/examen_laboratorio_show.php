<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_examen_laboratorio :input").attr('readonly','readonly');
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_examen_laboratorio :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled', 'disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_examen_laboratorio :input").attr('readonly','readonly');
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_examen_laboratorio :input").removeAttr('readonly');
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
				"form": "examen_laboratorio",
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
<legend style='text-align:center;'>Examen Laboratorio <?= $protocolo;?></legend>
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
<?= form_open('subject/examen_laboratorio_update', array('class'=>'form-horizontal','id'=>'form_examen_laboratorio')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('id', $list[0]->id); ?>
	<?= form_hidden('etapa', $etapa); ?>

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

	   		$normal_anormal = array(''=>'',
	   								'1'=>'Normal',
	   								'0'=>'Anormal');
       	?>	

		Realizado <?= form_radio($si); ?> Si <?= form_radio($no); ?> No<br />
		Fecha: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', ((!empty($list[0]->fecha) AND $list[0]->fecha !='0000-00-00') ? date("d/m/Y", strtotime($list[0]->fecha)) : "") ))); ?>
		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("fecha", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='fecha_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
		<br />&nbsp;<br />
		<table class='table table-bordered table-striped table-hover'>
			<thead>
				<tr>
					<th>Hematológico (valor normal)</th>
					<th>Valor</th>
					<th>Unidad</th>
					<th>Normal</th>
					<th>Anormal sin significancia clinica </th>
					<th>Anormal con significancia clinica</th>					
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Hematocrito</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'hematocrito', 'id'=>'hematocrito', 'value'=>set_value('hematocrito', $list[0]->hematocrito)));?></td>
					<td>%</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'hematocrito_nom_anom','value'=>'Normal','checked'=>set_radio('hematocrito_nom_anom', 'Normal', (($list[0]->hematocrito_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'hematocrito_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('hematocrito_nom_anom', 'Anormal_sin', (($list[0]->hematocrito_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'hematocrito_nom_anom','value'=>'Anormal_con','checked'=>set_radio('hematocrito_nom_anom', 'Anormal_con', (($list[0]->hematocrito_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("hematocrito", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='hematocrito_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='hematocrito_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Hemoglobina</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'hemoglobina', 'id'=>'hemoglobina', 'value'=>set_value('hemoglobina', $list[0]->hemoglobina)));?></td>
					<td>g/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'hemoglobina_nom_anom','value'=>'Normal','checked'=>set_radio('hemoglobina_nom_anom', 'Normal', (($list[0]->hemoglobina_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'hemoglobina_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('hemoglobina_nom_anom', 'Anormal_sin', (($list[0]->hemoglobina_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'hemoglobina_nom_anom','value'=>'Anormal_con','checked'=>set_radio('hemoglobina_nom_anom', 'Anormal_con', (($list[0]->hemoglobina_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("hemoglobina", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='hemoglobina_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='hemoglobina_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Recuento eritrocitos (RBC)</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'eritocritos', 'id'=>'eritocritos', 'value'=>set_value('eritocritos', $list[0]->eritocritos)));?></td>
					<td>M/µl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'eritocritos_nom_anom','value'=>'Normal','checked'=>set_radio('eritocritos_nom_anom', 'Normal', (($list[0]->eritocritos_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'eritocritos_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('eritocritos_nom_anom', 'Anormal_sin', (($list[0]->eritocritos_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'eritocritos_nom_anom','value'=>'Anormal_con','checked'=>set_radio('eritocritos_nom_anom', 'Anormal_con', (($list[0]->eritocritos_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("eritocritos", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='eritocritos_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='eritocritos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Recuento leucocitos (WBC)</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'leucocitos', 'id'=>'leucocitos', 'value'=>set_value('leucocitos', $list[0]->leucocitos)));?></td>
					<td>/µl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'leucocitos_nom_anom','value'=>'Normal','checked'=>set_radio('leucocitos_nom_anom', 'Normal', (($list[0]->leucocitos_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'leucocitos_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('leucocitos_nom_anom', 'Anormal_sin', (($list[0]->leucocitos_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'leucocitos_nom_anom','value'=>'Anormal_con','checked'=>set_radio('leucocitos_nom_anom', 'Anormal_con', (($list[0]->leucocitos_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("leucocitos", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='leucocitos_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='leucocitos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Neutrófilos</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'neutrofilos', 'id'=>'neutrofilos', 'value'=>set_value('neutrofilos', $list[0]->neutrofilos)));?></td>
					<td>/µl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'neutrofilos_nom_anom','value'=>'Normal','checked'=>set_radio('neutrofilos_nom_anom', 'Normal', (($list[0]->neutrofilos_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'neutrofilos_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('neutrofilos_nom_anom', 'Anormal_sin', (($list[0]->neutrofilos_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'neutrofilos_nom_anom','value'=>'Anormal_con','checked'=>set_radio('neutrofilos_nom_anom', 'Anormal_con', (($list[0]->neutrofilos_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("neutrofilos", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='neutrofilos_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='neutrofilos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Linfocitos</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'linfocitos', 'id'=>'linfocitos', 'value'=>set_value('linfocitos', $list[0]->linfocitos)));?></td>
					<td>/µl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'linfocitos_nom_anom','value'=>'Normal','checked'=>set_radio('linfocitos_nom_anom', 'Normal', (($list[0]->linfocitos_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'linfocitos_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('linfocitos_nom_anom', 'Anormal_sin', (($list[0]->linfocitos_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'linfocitos_nom_anom','value'=>'Anormal_con','checked'=>set_radio('linfocitos_nom_anom', 'Anormal_con', (($list[0]->linfocitos_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("linfocitos", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='linfocitos_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='linfocitos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Monocitos</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'monocitos', 'id'=>'monocitos', 'value'=>set_value('monocitos', $list[0]->monocitos)));?></td>
					<td>/µl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'monocitos_nom_anom','value'=>'Normal','checked'=>set_radio('monocitos_nom_anom', 'Normal', (($list[0]->monocitos_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'monocitos_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('monocitos_nom_anom', 'Anormal_sin', (($list[0]->monocitos_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'monocitos_nom_anom','value'=>'Anormal_con','checked'=>set_radio('monocitos_nom_anom', 'Anormal_con', (($list[0]->monocitos_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("monocitos", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='monocitos_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='monocitos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Eosinófilos</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'eosinofilos', 'id'=>'eosinofilos', 'value'=>set_value('eosinofilos', $list[0]->eosinofilos)));?></td>
					<td>/µl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'eosinofilos_nom_anom','value'=>'Normal','checked'=>set_radio('eosinofilos_nom_anom', 'Normal', (($list[0]->eosinofilos_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'eosinofilos_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('eosinofilos_nom_anom', 'Anormal_sin', (($list[0]->eosinofilos_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'eosinofilos_nom_anom','value'=>'Anormal_con','checked'=>set_radio('eosinofilos_nom_anom', 'Anormal_con', (($list[0]->eosinofilos_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("eosinofilos", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='eosinofilos_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='eosinofilos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Basófilos</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'basofilos', 'id'=>'basofilos', 'value'=>set_value('basofilos', $list[0]->basofilos)));?></td>
					<td>/µl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'basofilos_nom_anom','value'=>'Normal','checked'=>set_radio('basofilos_nom_anom', 'Normal', (($list[0]->basofilos_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'basofilos_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('basofilos_nom_anom', 'Anormal_sin', (($list[0]->basofilos_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'basofilos_nom_anom','value'=>'Anormal_con','checked'=>set_radio('basofilos_nom_anom', 'Anormal_con', (($list[0]->basofilos_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("basofilos", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='basofilos_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='basofilos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Recuento plaquetas</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'recuento_plaquetas', 'id'=>'recuento_plaquetas', 'value'=>set_value('recuento_plaquetas', $list[0]->recuento_plaquetas)));?></td>
					<td>x mm<sup>3</sup></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'recuento_plaquetas_nom_anom','value'=>'Normal','checked'=>set_radio('recuento_plaquetas_nom_anom', 'Normal', (($list[0]->recuento_plaquetas_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'recuento_plaquetas_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('recuento_plaquetas_nom_anom', 'Anormal_sin', (($list[0]->recuento_plaquetas_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'recuento_plaquetas_nom_anom','value'=>'Anormal_con','checked'=>set_radio('recuento_plaquetas_nom_anom', 'Anormal_con', (($list[0]->recuento_plaquetas_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("recuento_plaquetas", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='recuento_plaquetas_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='recuento_plaquetas_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
									}
								}						
								
							}
						?>
					</td>
				</tr>				
			</tbody>
		</table>
		<br />&nbsp;<br />
		<table class='table table-bordered table-striped table-hover'>
			<thead>
				<tr>
					<th>Bioquímico (valor normal)</th>
					<th>Valor</th>
					<th>Unidad</th>
					<th>Normal</th>					
					<th>Anormal sin significancia clinica </th>
					<th>Anormal con significancia clinica</th>
					<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Glucosa (ayunas)</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'glucosa_ayunas', 'id'=>'glucosa_ayunas', 'value'=>set_value('glucosa_ayunas', $list[0]->glucosa_ayunas)));?></td>
					<td>mg/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'glucosa_ayunas_nom_anom','value'=>'Normal','checked'=>set_radio('glucosa_ayunas_nom_anom', 'Normal', (($list[0]->glucosa_ayunas_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'glucosa_ayunas_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('glucosa_ayunas_nom_anom', 'Anormal_sin', (($list[0]->glucosa_ayunas_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'glucosa_ayunas_nom_anom','value'=>'Anormal_con','checked'=>set_radio('glucosa_ayunas_nom_anom', 'Anormal_con', (($list[0]->glucosa_ayunas_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("glucosa_ayunas", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='glucosa_ayunas_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='glucosa_ayunas_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>BUN</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'bun', 'id'=>'bun', 'value'=>set_value('bun', $list[0]->bun)));?></td>
					<td>mg/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'bun_nom_anom','value'=>'Normal','checked'=>set_radio('bun_nom_anom', 'Normal', (($list[0]->bun_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'bun_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('bun_nom_anom', 'Anormal_sin', (($list[0]->bun_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'bun_nom_anom','value'=>'Anormal_con','checked'=>set_radio('bun_nom_anom', 'Anormal_con', (($list[0]->bun_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("bun", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='bun_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='bun_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Creatinina</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'creatinina', 'id'=>'creatinina', 'value'=>set_value('creatinina', $list[0]->creatinina)));?></td>
					<td>mg/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'creatinina_nom_anom','value'=>'Normal','checked'=>set_radio('creatinina_nom_anom', 'Normal', (($list[0]->creatinina_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'creatinina_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('creatinina_nom_anom', 'Anormal_sin', (($list[0]->creatinina_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'creatinina_nom_anom','value'=>'Anormal_con','checked'=>set_radio('creatinina_nom_anom', 'Anormal_con', (($list[0]->creatinina_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("creatinina", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='creatinina_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='creatinina_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Bilirrubina total</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'bilirrubina_total', 'id'=>'bilirrubina_total', 'value'=>set_value('bilirrubina_total', $list[0]->bilirrubina_total)));?></td>
					<td>mg/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'bilirrubina_total_nom_anom','value'=>'Normal','checked'=>set_radio('bilirrubina_total_nom_anom', 'Normal', (($list[0]->bilirrubina_total_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'bilirrubina_total_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('bilirrubina_total_nom_anom', 'Anormal_sin', (($list[0]->bilirrubina_total_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'bilirrubina_total_nom_anom','value'=>'Anormal_con','checked'=>set_radio('bilirrubina_total_nom_anom', 'Anormal_con', (($list[0]->bilirrubina_total_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("bilirrubina_total", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='bilirrubina_total_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='bilirrubina_total_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Proteínas totales</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'proteinas_totales', 'id'=>'proteinas_totales', 'value'=>set_value('proteinas_totales', $list[0]->proteinas_totales)));?></td>
					<td>g/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'proteinas_totales_nom_anom','value'=>'Normal','checked'=>set_radio('proteinas_totales_nom_anom', 'Normal', (($list[0]->proteinas_totales_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'proteinas_totales_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('proteinas_totales_nom_anom', 'Anormal_sin', (($list[0]->proteinas_totales_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'proteinas_totales_nom_anom','value'=>'Anormal_con','checked'=>set_radio('proteinas_totales_nom_anom', 'Anormal_con', (($list[0]->proteinas_totales_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("proteinas_totales", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='proteinas_totales_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='proteinas_totales_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Fosfatasas alcalinas</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'fosfatasas_alcalinas', 'id'=>'fosfatasas_alcalinas', 'value'=>set_value('fosfatasas_alcalinas', $list[0]->fosfatasas_alcalinas)));?></td>
					<td>U/l</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'fosfatasas_alcalinas_nom_anom','value'=>'Normal','checked'=>set_radio('fosfatasas_alcalinas_nom_anom', 'Normal', (($list[0]->fosfatasas_alcalinas_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'fosfatasas_alcalinas_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('fosfatasas_alcalinas_nom_anom', 'Anormal_sin', (($list[0]->fosfatasas_alcalinas_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'fosfatasas_alcalinas_nom_anom','value'=>'Anormal_con','checked'=>set_radio('fosfatasas_alcalinas_nom_anom', 'Anormal_con', (($list[0]->fosfatasas_alcalinas_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("fosfatasas_alcalinas", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='fosfatasas_alcalinas_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='fosfatasas_alcalinas_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>AST</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'ast', 'id'=>'ast', 'value'=>set_value('ast', $list[0]->ast)));?></td>
					<td>U/l</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'ast_nom_anom','value'=>'Normal','checked'=>set_radio('ast_nom_anom', 'Normal', (($list[0]->ast_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'ast_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('ast_nom_anom', 'Anormal_sin', (($list[0]->ast_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'ast_nom_anom','value'=>'Anormal_con','checked'=>set_radio('ast_nom_anom', 'Anormal_con', (($list[0]->ast_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("ast", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='ast_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='ast_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>ALT</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'alt', 'id'=>'alt', 'value'=>set_value('alt', $list[0]->alt)));?></td>
					<td>U/l</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'alt_nom_anom','value'=>'Normal','checked'=>set_radio('alt_nom_anom', 'Normal', (($list[0]->alt_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'alt_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('alt_nom_anom', 'Anormal_sin', (($list[0]->alt_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'alt_nom_anom','value'=>'Anormal_con','checked'=>set_radio('alt_nom_anom', 'Anormal_con', (($list[0]->alt_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("alt", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='alt_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='alt_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Calcio (Ca)</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'calcio', 'id'=>'calcio', 'value'=>set_value('calcio', $list[0]->calcio)));?></td>
					<td><?= form_dropdown('calcio_unidad_medida',$medidas1,set_value('calcio_unidad_medida', $list[0]->calcio_unidad_medida)); ?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'calcio_nom_anom','value'=>'Normal','checked'=>set_radio('calcio_nom_anom', 'Normal', (($list[0]->calcio_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'calcio_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('calcio_nom_anom', 'Anormal_sin', (($list[0]->calcio_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'calcio_nom_anom','value'=>'Anormal_con','checked'=>set_radio('calcio_nom_anom', 'Anormal_con', (($list[0]->calcio_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("calcio", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='calcio_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='calcio_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Sodio (Na)</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'sodio', 'id'=>'sodio', 'value'=>set_value('sodio', $list[0]->sodio)));?></td>
					<td><?= form_dropdown('sodio_unidad_medida',$medidas1,set_value('sodio_unidad_medida', $list[0]->sodio_unidad_medida)); ?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'sodio_nom_anom','value'=>'Normal','checked'=>set_radio('sodio_nom_anom', 'Normal', (($list[0]->sodio_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'sodio_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('sodio_nom_anom', 'Anormal_sin', (($list[0]->sodio_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'sodio_nom_anom','value'=>'Anormal_con','checked'=>set_radio('sodio_nom_anom', 'Anormal_con', (($list[0]->sodio_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("sodio", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='sodio_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='sodio_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Potasio (K)</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'potasio', 'id'=>'potasio', 'value'=>set_value('potasio', $list[0]->potasio)));?></td>
					<td><?= form_dropdown('potasio_unidad_medida',$medidas1,set_value('potasio_unidad_medida', $list[0]->potasio_unidad_medida)); ?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'potasio_nom_anom','value'=>'Normal','checked'=>set_radio('potasio_nom_anom', 'Normal', (($list[0]->potasio_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'potasio_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('potasio_nom_anom', 'Anormal_sin', (($list[0]->potasio_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'potasio_nom_anom','value'=>'Anormal_con','checked'=>set_radio('potasio_nom_anom', 'Anormal_con', (($list[0]->potasio_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("potasio", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='potasio_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='potasio_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Cloro (Cl)</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'cloro', 'id'=>'cloro', 'value'=>set_value('cloro', $list[0]->cloro)));?></td>
					<td><?= form_dropdown('cloro_unidad_medida',$medidas1,set_value('cloro_unidad_medida', $list[0]->cloro_unidad_medida)); ?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'cloro_nom_anom','value'=>'Normal','checked'=>set_radio('cloro_nom_anom', 'Normal', (($list[0]->cloro_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'cloro_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('cloro_nom_anom', 'Anormal_sin', (($list[0]->cloro_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'cloro_nom_anom','value'=>'Anormal_con','checked'=>set_radio('cloro_nom_anom', 'Anormal_con', (($list[0]->cloro_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("cloro", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='cloro_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='cloro_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Ácido úrico</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'acido_urico', 'id'=>'acido_urico', 'value'=>set_value('acido_urico', $list[0]->acido_urico)));?></td>
					<td>mg/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'acido_urico_nom_anom','value'=>'Normal','checked'=>set_radio('acido_urico_nom_anom', 'Normal', (($list[0]->acido_urico_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'acido_urico_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('acido_urico_nom_anom', 'Anormal_sin', (($list[0]->acido_urico_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'acido_urico_nom_anom','value'=>'Anormal_con','checked'=>set_radio('acido_urico_nom_anom', 'Anormal_con', (($list[0]->acido_urico_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("acido_urico", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='acido_urico_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='acido_urico_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Albúmina</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'albumina', 'id'=>'albumina', 'value'=>set_value('albumina', $list[0]->albumina)));?></td>
					<td>mg/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'albumina_nom_anom','value'=>'Normal','checked'=>set_radio('albumina_nom_anom', 'Normal', (($list[0]->albumina_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'albumina_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('albumina_nom_anom', 'Anormal_sin', (($list[0]->albumina_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'albumina_nom_anom','value'=>'Anormal_con','checked'=>set_radio('albumina_nom_anom', 'Anormal_con', (($list[0]->albumina_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("albumina", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='albumina_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='albumina_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<th colspan='7'>Análisis de Orina</th>					
				</tr>
				<tr>
					<td>pH</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'orina_ph', 'id'=>'orina_ph', 'value'=>set_value('orina_ph', $list[0]->orina_ph)));?></td>
					<td></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_ph_nom_anom','value'=>'Normal','checked'=>set_radio('orina_ph_nom_anom', 'Normal', (($list[0]->orina_ph_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_ph_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('orina_ph_nom_anom', 'Anormal_sin', (($list[0]->orina_ph_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_ph_nom_anom','value'=>'Anormal_con','checked'=>set_radio('orina_ph_nom_anom', 'Anormal_con', (($list[0]->orina_ph_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("orina_ph", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='orina_ph_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='orina_ph_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Glucosa (qual)</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'orina_glucosa', 'id'=>'orina_glucosa', 'value'=>set_value('orina_glucosa', $list[0]->orina_glucosa)));?></td>
					<td><?= form_dropdown('glucosa_unidad_medida',$medidas2,set_value('glucosa_unidad_medida', $list[0]->glucosa_unidad_medida)); ?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_glucosa_nom_anom','value'=>'Normal','checked'=>set_radio('orina_glucosa_nom_anom', 'Normal', (($list[0]->orina_glucosa_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_glucosa_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('orina_glucosa_nom_anom', 'Anormal_sin', (($list[0]->orina_glucosa_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_glucosa_nom_anom','value'=>'Anormal_con','checked'=>set_radio('orina_glucosa_nom_anom', 'Anormal_con', (($list[0]->orina_glucosa_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("orina_glucosa", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='orina_glucosa_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='orina_glucosa_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Proteína (qual)</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'orina_proteinas', 'id'=>'orina_proteinas', 'value'=>set_value('orina_proteinas', $list[0]->orina_proteinas)));?></td>
					<td>mUI/ml</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_proteinas_nom_anom','value'=>'Normal','checked'=>set_radio('orina_proteinas_nom_anom', 'Normal', (($list[0]->orina_proteinas_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_proteinas_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('orina_proteinas_nom_anom', 'Anormal_sin', (($list[0]->orina_proteinas_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_proteinas_nom_anom','value'=>'Anormal_con','checked'=>set_radio('orina_proteinas_nom_anom', 'Anormal_con', (($list[0]->orina_proteinas_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("orina_proteinas", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='orina_proteinas_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='orina_proteinas_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Sangre (qual)</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'orina_sangre', 'id'=>'orina_sangre', 'value'=>set_value('orina_sangre', $list[0]->orina_sangre)));?></td>
					<td>mUI/ml</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_sangre_nom_anom','value'=>'Normal','checked'=>set_radio('orina_sangre_nom_anom', 'Normal', (($list[0]->orina_sangre_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_sangre_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('orina_sangre_nom_anom', 'Anormal_sin', (($list[0]->orina_sangre_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_sangre_nom_anom','value'=>'Anormal_con','checked'=>set_radio('orina_sangre_nom_anom', 'Anormal_con', (($list[0]->orina_sangre_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("orina_sangre", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='orina_sangre_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='orina_sangre_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Cetonas</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'orina_cetonas', 'id'=>'orina_cetonas', 'value'=>set_value('orina_cetonas', $list[0]->orina_cetonas)));?></td>
					<td>mmol/l</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_cetonas_nom_anom','value'=>'Normal','checked'=>set_radio('orina_cetonas_nom_anom', 'Normal', (($list[0]->orina_cetonas_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_cetonas_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('orina_cetonas_nom_anom', 'Anormal_sin', (($list[0]->orina_cetonas_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_cetonas_nom_anom','value'=>'Anormal_con','checked'=>set_radio('orina_cetonas_nom_anom', 'Anormal_con', (($list[0]->orina_cetonas_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("orina_cetonas", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='orina_cetonas_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='orina_cetonas_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Microscopía (Solamente si la tira reactiva es positiva para sangre o proteína.)</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'orina_microscospia', 'id'=>'orina_microscospia', 'value'=>set_value('orina_microscospia', $list[0]->orina_microscospia)));?></td>
					<td></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_microscospia_nom_anom','value'=>'Normal','checked'=>set_radio('orina_microscospia_nom_anom', 'Normal', (($list[0]->orina_microscospia_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_microscospia_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('orina_microscospia_nom_anom', 'Anormal_sin', (($list[0]->orina_microscospia_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_microscospia_nom_anom','value'=>'Anormal_con','checked'=>set_radio('orina_microscospia_nom_anom', 'Anormal_con', (($list[0]->orina_microscospia_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("orina_microscospia", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='orina_microscospia_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='orina_microscospia_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
									}
								}						
								
							}
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		&nbsp;				
		<br />
		Otros:
		<br />
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>Sangre</th>
					<th>Valor</th>
					<th>Normal</th>					
					<th>Anormal sin significancia clinica </th>				
					<th>Anormal con significancia clinica</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Homocisteina</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'otros_sangre_homocisteina', 'id'=>'otros_sangre_homocisteina', 'value'=>set_value('otros_sangre_homocisteina', $list[0]->otros_sangre_homocisteina)));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_sangre_homocisteina_nom_anom','value'=>'Normal','checked'=>set_radio('otros_sangre_homocisteina_nom_anom', 'Normal', (($list[0]->otros_sangre_homocisteina_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_sangre_homocisteina_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('otros_sangre_homocisteina_nom_anom', 'Anormal_sin', (($list[0]->otros_sangre_homocisteina_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_sangre_homocisteina_nom_anom','value'=>'Anormal_con','checked'=>set_radio('otros_sangre_homocisteina_nom_anom', 'Anormal_con', (($list[0]->otros_sangre_homocisteina_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("otros_sangre_homocisteina", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='otros_sangre_homocisteina_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='otros_sangre_homocisteina_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
									}
								}						
								
							}
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>Otros</th>
					<th>Valor</th>
					<th>Normal</th>					
					<th>Anormal sin significancia clinica </th>				
					<th>Anormal con significancia clinica</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php if($etapa == 1){ ?>
					<tr>
						<td>Perfil Tiroideo</td>
						<td><?= form_input(array('type'=>'text', 'name'=>'otros_perfil_tiroideo', 'id'=>'otros_perfil_tiroideo', 'value'=>set_value('otros_perfil_tiroideo', $list[0]->otros_perfil_tiroideo)));?></td>
						<td style='text-align:center;'><?= form_radio(array('name'=>'otros_perfil_tiroideo_nom_anom','value'=>'Normal','checked'=>set_radio('otros_perfil_tiroideo_nom_anom', 'Normal', (($list[0]->otros_perfil_tiroideo_nom_anom == 'Normal') ? true : false))));?></td>					
						<td style='text-align:center;'><?= form_radio(array('name'=>'otros_perfil_tiroideo_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('otros_perfil_tiroideo_nom_anom', 'Anormal_sin', (($list[0]->otros_perfil_tiroideo_nom_anom == 'Anormal_sin') ? true : false))));?></td>
						<td style='text-align:center;'><?= form_radio(array('name'=>'otros_perfil_tiroideo_nom_anom','value'=>'Anormal_con','checked'=>set_radio('otros_perfil_tiroideo_nom_anom', 'Anormal_con', (($list[0]->otros_perfil_tiroideo_nom_anom == 'Anormal_con') ? true : false))));?></td>
						<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("otros_perfil_tiroideo", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='otros_perfil_tiroideo_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='otros_perfil_tiroideo_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
									}
								}						
								
							}
						?>
					</td>
					</tr>
				<?php } else{ ?>
					<?= form_hidden('otros_perfil_tiroideo','No Aplica');?>
					<?= form_hidden('otros_perfil_tiroideo_nom_anom','No Aplica');?>					
				<?php } ?>
				<tr>
					<td>Nivel plasmático de V B12</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'otros_nivel_b12', 'id'=>'otros_nivel_b12', 'value'=>set_value('otros_nivel_b12', $list[0]->otros_nivel_b12)));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_nivel_b12_nom_anom','value'=>'Normal','checked'=>set_radio('otros_nivel_b12_nom_anom', 'Normal', (($list[0]->otros_nivel_b12_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_nivel_b12_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('otros_nivel_b12_nom_anom', 'Anormal_sin', (($list[0]->otros_nivel_b12_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_nivel_b12_nom_anom','value'=>'Anormal_con','checked'=>set_radio('otros_nivel_b12_nom_anom', 'Anormal_con', (($list[0]->otros_nivel_b12_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("otros_nivel_b12", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='otros_nivel_b12_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='otros_nivel_b12_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Nivel plasmático de ácido fólico</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'otros_acido_folico', 'id'=>'otros_acido_folico', 'value'=>set_value('otros_acido_folico', $list[0]->otros_acido_folico)));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_acido_folico_nom_anom','value'=>'Normal','checked'=>set_radio('otros_acido_folico_nom_anom', 'Normal', (($list[0]->otros_acido_folico_nom_anom == 'Normal') ? true : false))));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_acido_folico_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('otros_acido_folico_nom_anom', 'Anormal_sin', (($list[0]->otros_acido_folico_nom_anom == 'Anormal_sin') ? true : false))));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_acido_folico_nom_anom','value'=>'Anormal_con','checked'=>set_radio('otros_acido_folico_nom_anom', 'Anormal_con', (($list[0]->otros_acido_folico_nom_anom == 'Anormal_con') ? true : false))));?></td>
					<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("otros_acido_folico", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='otros_acido_folico_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='otros_acido_folico_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
									}
								}						
								
							}
						?>
					</td>
				</tr>
				<?php if($etapa == 1){ ?>
					<tr>
						<td>HbA1C</td>
						<td><?= form_input(array('type'=>'text', 'name'=>'otros_hba1c', 'id'=>'otros_hba1c', 'value'=>set_value('otros_hba1c', $list[0]->otros_hba1c)));?></td>
						<td style='text-align:center;'><?= form_radio(array('name'=>'otros_hba1c_nom_anom','value'=>'Normal','checked'=>set_radio('otros_hba1c_nom_anom', 'Normal', (($list[0]->otros_hba1c_nom_anom == 'Normal') ? true : false))));?></td>					
						<td style='text-align:center;'><?= form_radio(array('name'=>'otros_hba1c_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('otros_hba1c_nom_anom', 'Anormal_sin', (($list[0]->otros_hba1c_nom_anom == 'Anormal_sin') ? true : false))));?></td>
						<td style='text-align:center;'><?= form_radio(array('name'=>'otros_hba1c_nom_anom','value'=>'Anormal_con','checked'=>set_radio('otros_hba1c_nom_anom', 'Anormal_con', (($list[0]->otros_hba1c_nom_anom == 'Anormal_con') ? true : false))));?></td>
						<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("otros_hba1c", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='otros_hba1c_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='otros_hba1c_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
						<td>Sífilis (VDRL)</td>
						<td><?= form_input(array('type'=>'text', 'name'=>'sifilis', 'id'=>'sifilis', 'value'=>set_value('sifilis', $list[0]->sifilis)));?></td>
						<td style='text-align:center;'><?= form_radio(array('name'=>'sifilis_nom_anom','value'=>'Normal','checked'=>set_radio('sifilis_nom_anom', 'Normal', (($list[0]->sifilis_nom_anom == 'Normal') ? true : false))));?></td>					
						<td style='text-align:center;'><?= form_radio(array('name'=>'sifilis_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('sifilis_nom_anom', 'Anormal_sin', (($list[0]->sifilis_nom_anom == 'Anormal_sin') ? true : false))));?></td>
						<td style='text-align:center;'><?= form_radio(array('name'=>'sifilis_nom_anom','value'=>'Anormal_con','checked'=>set_radio('sifilis_nom_anom', 'Anormal_con', (($list[0]->sifilis_nom_anom == 'Anormal_con') ? true : false))));?></td>
						<td>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("sifilis", $campos_query))  
								{
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='sifilis_query' tipo='new' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";		
									}
									
								}
								else 
								{	
									if(strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){					
										echo "<img src='". base_url('img/question.png') ."' id='sifilis_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
									}
									else{
										echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
									}
								}						
								
							}
						?>
					</td>
					</tr>
				<?php } else{ ?>
					<?= form_hidden('sifilis','No Aplica');?>
					<?= form_hidden('sifilis_nom_anom','No Aplica');?>
					<?= form_hidden('otros_hba1c','No Aplica');?>
					<?= form_hidden('otros_hba1c_nom_anom','No Aplica');?>
				<?php } ?>
			</tbody>
		</table>
		<hr />
		<div style="text-align:center;">
			<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_update')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
            <?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
		</div>

<?= form_close(); ?>
<?php }?>

<!-- Querys -->
<?php
	if(isset($querys) AND !empty($querys)){ ?>
		<b>Querys:</b>
		<table class="table table-condensed table-bordered table-stripped">
			<thead>
				<tr>
					<th>Fecha de Consulta</th>
								<th>Usuario</th>
								<th>Consulta</th>
								<th>Fecha de Respuesta</th>
								<th>Usuario</th>
								<th>Respuesta</th>				
				</tr>
			</thead>
			<tbody>
				
			<?php
				foreach ($querys as $query) { ?>
					<tr>
						<td><?= date("d-M-Y H:i:s", strtotime($query->created)); ?></td>
						<td><?= $query->question_user; ?></td>
						<td><?= $query->question; ?></td>						
						<td><?= (($query->answer_date != "0000-00-00 00:00:00") ? date("d-M-Y H:i:s", strtotime($query->answer_date)) : ""); ?></td>
						<td><?= $query->answer_user; ?></td>
						<?php
							if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'additional_form_query_show')){
						?>
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id .'/Examen Laboratorio', 'Responder',array('class'=>'btn'))); ?></td>						
						<?php }else{?>
							<td><?= $query->answer; ?></td>
						<?php }?>
					</tr>					
			<?php }?>	

			</tbody>
		</table>

<?php } ?>
<!-- Verify -->
<b>Aprobacion del Monitor:</b><br />
	<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
		
		Formulario aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y",strtotime($list[0]->verify_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/examen_laboratorio_verify', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/examen_laboratorio_lock', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/examen_laboratorio_signature', array('class'=>'form-horizontal')); ?>    	
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