<script src="<?= base_url('js/adas.js') ?>"></script>
<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script>
$(function(){
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
				"form": "adas",
				"form_nombre" : "Adas Cog",
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
<div style='display:none;'>
	<div id='dialog_auditoria'><?= ((isset($auditoria) AND !empty($auditoria)) ? $auditoria : ''); ?></div>
</div>

<div id='query_para_campos' style='display:none;'></div>
		<legend style='text-align:center;'>ADAS COG <?= $protocolo;?></legend>
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
	<?php
		if(isset($auditoria) AND !empty($auditoria)){
			echo "<div style='text-align:right;'><a id='ver_auditoria' class='btn btn-info colorbox_inline' href='#dialog_auditoria'>Ver Auditoria</a></div>";

		}

	?>
	<?= form_open('subject/adas_update', array('class'=>'form-horizontal', 'id'=>'form_adas')); ?>
	
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
	?>

	<table class='table table-striped table-hover table-bordered table-condensed'>			
		<tbody>
			<tr>		
				<td>Realizado: </td>
				<td>
					<?= form_radio($data,$data['value'],set_radio($data['name'], 1, (($list[0]->realizado == 1) ? true : false))); ?> Si
					<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0, (($list[0]->realizado == 0) ? true : false))); ?> NO
				</td>
			</tr>
			<tr>
				<td>Fecha: </td>
				<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', ((!empty($list[0]->fecha) AND $list[0]->fecha !='0000-00-00') ? date("d/m/Y", strtotime($list[0]->fecha)) : "") ))); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("fecha", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='fecha_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Puntaje Total ADAS-Cog: </td>
				<td><?= form_input(array('type'=>'text','name'=>'puntaje_total', 'id'=>'puntaje_total', 'value'=>set_value('puntaje_total', $list[0]->puntaje_total), 'readonly'=>'readonly')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_total", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_total_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_total_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>1.- Tarea de recordar palabras</td>
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;'>Ensayo 1</td>
			</tr>
			<tr>
				<td>Palabras recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_recordadas_1', 'id'=>'palabras_recordadas_1', 'value'=>set_value('palabras_recordadas_1', $list[0]->palabras_recordadas_1))); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("palabras_recordadas_1", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='palabras_recordadas_1_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='palabras_recordadas_1_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Palabras no recordadas: </td>
				<td><?= form_dropdown('palabras_no_recordadas_1', $de0_a10,  set_value('palabras_no_recordadas_1', $list[0]->palabras_no_recordadas_1),array('id'=>'palabras_no_recordadas_1')); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("palabras_no_recordadas_1", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='palabras_no_recordadas_1_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='palabras_no_recordadas_1_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='background-color:#ccc;'>Ensayo 2</td>
			</tr>
			<tr>
				<td>Palabras recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_recordadas_2', 'id'=>'palabras_recordadas_2', 'value'=>set_value('palabras_recordadas_2', $list[0]->palabras_recordadas_2))); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("palabras_recordadas_2", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='palabras_recordadas_2_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='palabras_recordadas_2_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Palabras no recordadas: </td>
				<td>
					<?= form_dropdown('palabras_no_recordadas_2', $de0_a10,  set_value('palabras_no_recordadas_2', $list[0]->palabras_no_recordadas_2),array('id'=>'palabras_no_recordadas_2')); ?>
					
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("palabras_no_recordadas_2", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='palabras_no_recordadas_2_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='palabras_no_recordadas_2_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='background-color:#ccc;'>Ensayo 3</td>
			</tr>
			<tr>
				<td>Palabras recordadas: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'palabras_recordadas_3', 'id'=>'palabras_recordadas_3', 'value'=>set_value('palabras_recordadas_3', $list[0]->palabras_recordadas_3))); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("palabras_recordadas_3", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='palabras_recordadas_3_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='palabras_recordadas_3_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Palabras no recordadas: </td>
				<td>
					<?= form_dropdown('palabras_no_recordadas_3', $de0_a10,  set_value('palabras_no_recordadas_3', $list[0]->palabras_no_recordadas_3),array('id'=>'palabras_no_recordadas_3')); ?>					
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("palabras_no_recordadas_3", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='palabras_no_recordadas_3_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='palabras_no_recordadas_3_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Hora de finalizacion: </td>
				<td>
					<?= form_dropdown('hora_finalizacion_hora', $horas ,set_value('hora_finalizacion_hora', $list[0]->hora_finalizacion_hora)); ?>
					:
					<?= form_dropdown('hora_finalizacion_minuto', $minutos, set_value('hora_finalizacion_minuto', $list[0]->hora_finalizacion_minuto)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("hora_finalizacion_hora", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='hora_finalizacion_hora_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='hora_finalizacion_hora_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_1', $no_administro, set_value('no_administro_1', $list[0]->no_administro_1)); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("no_administro_1", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='no_administro_1_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='no_administro_1_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Puntuaci&oacute;n Total: </td>
				<td><?= form_input(array('type'=>'text', 'name'=>'puntaje_total_1', 'id'=>'puntaje_total_1', 'readonly'=>'readonly', 'value'=>set_value('puntaje_total_1',$list[0]->puntaje_total_1))); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_total_1", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_total_1_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_total_1_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>2.- Órdenes</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_2', $de0_a5,  set_value('total_correctas_2', $list[0]->total_correctas_2),array('id'=>'total_correctas_2')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("total_correctas_2", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='total_correctas_2_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='total_correctas_2_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Total incorrectas</td>
				<td><?= form_dropdown('total_incorrectas_2', $de0_a5,  set_value('total_incorrectas_2', $list[0]->total_incorrectas_2),array('id'=>'total_incorrectas_2')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("total_incorrectas_2", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='total_incorrectas_2_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='total_incorrectas_2_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_2', $no_administro, set_value('no_administro_2', $list[0]->no_administro_2)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("no_administro_2", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='no_administro_2_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='no_administro_2_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Puntuaci&oacute;n Total</td>
				<td><?= form_dropdown('puntuacion_2', $puntaje, set_value('puntuacion_2', $list[0]->puntuacion_2), array('id'=>'puntuacion_2')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntuacion_2", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntuacion_2_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='puntuacion_2_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>3.- Praxis Constructiva</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_3', $de0_a4,  set_value('total_correctas_3', $list[0]->total_correctas_3),array('id'=>'total_correctas_3')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("total_correctas_3", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='total_correctas_3_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='total_correctas_3_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Total incorrectas</td>
				<td><?= form_dropdown('total_incorrectas_3', $de0_a4,  set_value('total_incorrectas_3', $list[0]->total_incorrectas_3),array('id'=>'total_incorrectas_3')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='total_incorrectas_3_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='total_incorrectas_3_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Paciente no intentó dibujar ninguna forma: </td>
				<td><?= form_checkbox('paciente_no_dibujo_3','1', (($list[0]->paciente_no_dibujo_3 == 1) ? true : false), array('id'=>'paciente_no_dibujo_3')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='paciente_no_dibujo_3_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='paciente_no_dibujo_3_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_3', $no_administro, set_value('no_administro_3', $list[0]->no_administro_3)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("no_administro_3", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='no_administro_3_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='no_administro_3_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Puntuaci&oacute;n Total</td>
				<td><?= form_dropdown('puntuacion_3', $puntaje, set_value('puntuacion_3', $list[0]->puntuacion_3), array('id'=>'puntuacion_3')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntuacion_3", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntuacion_3_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='puntuacion_3_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>4.- Tarea de recordar palabras diferidas </td>
			</tr>
			<tr>
				<td>Total recordadas</td>				
				<td><?= form_dropdown('total_recordadas_4', $de0_a10,  set_value('total_recordadas_4', $list[0]->total_recordadas_4),array('id'=>'total_recordadas_4')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("total_recordadas_4", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='total_recordadas_4_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='total_recordadas_4_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Total no recordadas</td>				
				<td><?= form_dropdown('total_no_recordadas_4', $de0_a10,  set_value('total_no_recordadas_4', $list[0]->total_no_recordadas_4),array('id'=>'total_no_recordadas_4')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("total_no_recordadas_4", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='total_no_recordadas_4_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='total_no_recordadas_4_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Hora de inicio: </td>
				<td>
					<?= form_dropdown('hora_finalizacion_4_hora', $horas ,set_value('hora_finalizacion_4_hora', $list[0]->hora_finalizacion_4_hora)); ?>
					:
					<?= form_dropdown('hora_finalizacion_4_minuto', $minutos, set_value('hora_finalizacion_4_minuto', $list[0]->hora_finalizacion_4_minuto)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("hora_finalizacion_4_hora", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='hora_finalizacion_4_hora_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='hora_finalizacion_4_hora_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Puntuaci&oacute;n Total</td>
				<td><?= form_dropdown('puntuacion_4', $de0_a10, set_value('puntuacion_4', $list[0]->puntuacion_4), array('id'=>'puntuacion_4')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntuacion_4", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntuacion_4_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='puntuacion_4_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>5.- Tarea de nombrar</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_5', $de0_a17,  set_value('total_correctas_5', $list[0]->total_correctas_5),array('id'=>'total_correctas_5')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("total_correctas_5", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='total_correctas_5_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='total_correctas_5_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Total incorrectas</td>
				<td><?= form_dropdown('total_incorrectas_5', $de0_a17,  set_value('total_incorrectas_5', $list[0]->total_incorrectas_5),array('id'=>'total_incorrectas_5')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("total_incorrectas_5", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='total_incorrectas_5_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='total_incorrectas_5_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_5', $no_administro, set_value('no_administro_5', $list[0]->no_administro_5)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("no_administro_5", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='no_administro_5_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='no_administro_5_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Puntuaci&oacute;n Total</td>
				<td><?= form_dropdown('puntuacion_5', $puntaje, set_value('puntuacion_5', $list[0]->puntuacion_5), array('id'=>'puntuacion_5')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntuacion_5", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntuacion_5_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='puntuacion_5_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>6.- Praxis Ideacional</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_6', $de0_a5,  set_value('total_correctas_6', $list[0]->total_correctas_6),array('id'=>'total_correctas_6')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("total_correctas_6", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='total_correctas_6_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='total_correctas_6_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Total incorrectas</td>
				<td><?= form_dropdown('total_incorrectas_6', $de0_a5,  set_value('total_incorrectas_6', $list[0]->total_incorrectas_6),array('id'=>'total_incorrectas_6')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("total_incorrectas_6", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='total_incorrectas_6_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='total_incorrectas_6_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_6', $no_administro, set_value('no_administro_6', $list[0]->no_administro_6)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("no_administro_6", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='no_administro_6_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='no_administro_6_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Puntuaci&oacute;n Total</td>
				<td><?= form_dropdown('puntuacion_6', $puntaje, set_value('puntuacion_6', $list[0]->puntuacion_6), array('id'=>'puntuacion_6')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntuacion_6", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntuacion_6_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='puntuacion_6_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>7.- Orientación</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_7', $de0_a8,  set_value('total_correctas_7', $list[0]->total_correctas_7),array('id'=>'total_correctas_7')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("total_correctas_7", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='total_correctas_7_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='total_correctas_7_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Total incorrectas</td>
				<td><?= form_dropdown('total_incorrectas_7', $de0_a8,  set_value('total_incorrectas_7', $list[0]->total_incorrectas_7),array('id'=>'total_incorrectas_7')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("total_incorrectas_7", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='total_incorrectas_7_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='total_incorrectas_7_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_7', $no_administro, set_value('no_administro_7', $list[0]->no_administro_7)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("no_administro_7", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='no_administro_7_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='no_administro_7_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Puntuaci&oacute;n Total</td>
				<td><?= form_dropdown('puntuacion_7', $de0_a8, set_value('puntuacion_7', $list[0]->puntuacion_7), array('id'=>'puntuacion_7')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntuacion_7", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntuacion_7_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='puntuacion_7_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>8.- Tarea de reconocer palabras</td>
			</tr>
			<tr>
				<td>Total correctas</td>
				<td><?= form_dropdown('total_correctas_8', $de0_a24,  set_value('total_correctas_8', $list[0]->total_correctas_8),array('id'=>'total_correctas_8')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("total_correctas_8", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='total_correctas_8_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='total_correctas_8_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Total incorrectas</td>
				<td><?= form_dropdown('total_incorrectas_8', $de0_a24,  set_value('total_incorrectas_8', $list[0]->total_incorrectas_8),array('id'=>'total_incorrectas_8')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("total_incorrectas_8", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='total_incorrectas_8_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='total_incorrectas_8_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Cantidad de recordatorios</td>
				<td><?= form_dropdown('cantidad_recordadas_8', $de0_a22,  set_value('cantidad_recordadas_8', $list[0]->cantidad_recordadas_8),array('id'=>'cantidad_recordadas_8')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("cantidad_recordadas_8", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='cantidad_recordadas_8_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='cantidad_recordadas_8_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Si alguna tarea no se administró o no se completó, elija una opción: </td>
				<td><?= form_dropdown('no_administro_8', $no_administro, set_value('no_administro_8', $list[0]->no_administro_8)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("no_administro_8", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='no_administro_8_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='no_administro_8_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Puntuaci&oacute;n Total</td>
				<td><?= form_input(array('type'=>'text', 'name'=>'puntuacion_8', 'id'=>'puntuacion_8', 'value'=>set_value('puntuacion_8', $list[0]->puntuacion_8), 'readonly'=>'readonly')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntuacion_8", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntuacion_8_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='puntuacion_8_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>9.- Recordando las instrucciones de la prueba</td>
			</tr>
			<tr>
				<td>Puntuación</td>
				<td><?= form_dropdown('puntuacion_9', $puntaje, set_value('puntuacion_9', $list[0]->puntuacion_9), array('id'=>'puntuacion_9')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntuacion_9", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntuacion_9_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='puntuacion_9_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>10.- Comprensión</td>
			</tr>
			<tr>
				<td>Puntuación</td>
				<td><?= form_dropdown('puntuacion_10', $puntaje, set_value('puntuacion_10', $list[0]->puntuacion_10), array('id'=>'puntuacion_10')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntuacion_10", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntuacion_10_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='puntuacion_10_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>11.- Dificultad en la selección de palabras</td>
			</tr>
			<tr>
				<td>Puntuación</td>
				<td><?= form_dropdown('puntuacion_11', $puntaje, set_value('puntuacion_11', $list[0]->puntuacion_11), array('id'=>'puntuacion_11')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntuacion_11", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntuacion_11_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='puntuacion_11_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='background-color:#ccc;font-weight:bold;'>12.- Habilidad para el lenguaje hablado</td>
			</tr>
			<tr>
				<td>Puntuación</td>
				<td><?= form_dropdown('puntuacion_12', $puntaje, set_value('puntuacion_12', $list[0]->puntuacion_12), array('id'=>'puntuacion_12')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntuacion_12", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'adas_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntuacion_12_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'adas_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='puntuacion_12_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td colspan='2' style='text-align:center;'>
					<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'adas_update')){
					?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
					<?= anchor('subject/grid/'. $subject->id, 'Volver', array('class'=>'btn')); ?>
				</td>				
			</tr>			
		</tbody>
	</table>

	<?= form_close(); ?>
	<!-- Querys -->

<b>Creado por:</b> <?= $list[0]->usuario_creacion;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->created_at));?><br />&nbsp;</br>

<!-- Verify -->
<b>Aprobacion del Monitor:</b><br />
	<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
		
		Formulario aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->verify_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'adas_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/adas_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('id', $list[0]->id); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
			
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
			AND strpos($_SESSION['role_options']['subject'], 'adas_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/adas_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('id', $list[0]->id); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
			
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
			AND strpos($_SESSION['role_options']['subject'], 'adas_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/adas_signature', array('class'=>'form-horizontal')); ?>    	
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