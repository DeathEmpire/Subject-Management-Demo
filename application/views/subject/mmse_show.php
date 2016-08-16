<script src="<?= base_url('js/mmse.js') ?>"></script>
<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
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
				"form": "mmse",
				"form_nombre" : "Mini Mental State Examination (MMSE)",
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
<legend style='text-align:center;'>MINI MENTAL STATE EXAMINATION (MMSE) <?= $protocolo;?></legend>
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
	if(isset($list) AND !empty($list)){
?>	
<?= form_open('subject/mmse_update', array('class'=>'form-horizontal','id'=>'form_mmse')); ?>    
	
	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('id', $list[0]->id); ?>
	<?= form_hidden('etapa', $etapa); ?>

    <?= my_validation_errors(validation_errors()); ?>

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

	    $tiene_problemas_memoria = array(
		    'name'        => 'tiene_problemas_memoria',
		    'id'          => 'tiene_problemas_memoria',
		    'value'       => '1',
		    #'checked'     => set_checkbox('tiene_problemas_memoria','1')			    
	    );

	    $le_puedo_hacer_preguntas = array(
		    'name'        => 'le_puedo_hacer_preguntas',
		    'id'          => 'le_puedo_hacer_preguntas',
		    'value'       => '1',
		    #'checked'     => set_checkbox('le_puedo_hacer_preguntas','1')			    
	    );
	?>

	<table class="table table-condensed table-bordered table-striped table-hover">          
		<tr>
			<td>Realizado: 
			<td>
				<?= form_radio($data, 1, set_radio($data['name'], 1, (($list[0]->realizado == 1) ? true : false))); ?> Si
				<?= form_radio($data2, 2, set_radio($data2['name'], '0', (($list[0]->realizado == '0') ? true : false))); ?> NO
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
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
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
			<td style='font-weight:bold;'>PUNTAJE TOTAL: </td>
			<td id='puntaje_total_td' style='font-weight:bold;'>0</td>
		</tr>
		<tr>
			<td>Se consulta a sujeto...¿Tiene algún problema con su memoria?</td>
			<td><?= form_checkbox($tiene_problemas_memoria, 1, set_checkbox('tiene_problemas_memoria',1,(($list[0]->tiene_problemas_memoria == 1) ? true : false)));?>
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("tiene_problemas_memoria", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='tiene_problemas_memoria_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='tiene_problemas_memoria_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>Se consulta a sujeto...¿Le puedo hacer algunas preguntas acerca de su memoria?</td>
			<td><?= form_checkbox($le_puedo_hacer_preguntas, 1, set_checkbox('le_puedo_hacer_preguntas',1,(($list[0]->le_puedo_hacer_preguntas == 1) ? true : false)));?>
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("le_puedo_hacer_preguntas", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='le_puedo_hacer_preguntas_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='le_puedo_hacer_preguntas_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
					}
				?>
			</td>
		</tr>   
	</table>
	<table class="table table-condensed table-bordered table-striped table-hover">
		<tr>    
			<td style='font-weight:bold;background-color:#ccc;'>Pregunta</td>
			<td style='font-weight:bold;background-color:#ccc;'>Respuesta</td>			
			<td style='font-weight:bold;background-color:#ccc;'>Puntaje</td>
			<td style='font-weight:bold;background-color:#ccc;'>&nbsp;&nbsp;&nbsp;</td>
		</tr>
	    <tr>
	    	<td style='font-weight:bold;' colspan='4'>ORIENTACION EN EL TIEMPO</td>	    	
	    </tr>
	    <tr>
	    	<td>¿En qué año estamos?</td>
	    	<td><?= form_input(array('type'=>'text','name'=>'en_que_ano_estamos', 'id'=>'en_que_ano_estamos', 'value'=>set_value('en_que_ano_estamos', $list[0]->en_que_ano_estamos))); ?></td>
	    	<td><?= form_dropdown('en_que_ano_estamos_puntaje',$puntaje,set_value('en_que_ano_estamos_puntaje', $list[0]->en_que_ano_estamos_puntaje)); ?></td>
	    	<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("en_que_ano_estamos", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='en_que_ano_estamos_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='en_que_ano_estamos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
	    	<td>¿En qué Estación del año estamos?</td>
	    	<td><?= form_input(array('type'=>'text','name'=>'en_que_estacion_estamos', 'id'=>'en_que_estacion_estamos', 'value'=>set_value('en_que_estacion_estamos', $list[0]->en_que_estacion_estamos))); ?></td>
	    	<td><?= form_dropdown('en_que_estacion_estamos_puntaje',$puntaje,set_value('en_que_estacion_estamos_puntaje', $list[0]->en_que_estacion_estamos_puntaje)); ?></td>
	    	<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("en_que_estacion_estamos_puntaje", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='en_que_estacion_estamos_puntaje_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='en_que_estacion_estamos_puntaje_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
	    	<td>¿En qué Mes estamos?</td>
	    	<td><?= form_input(array('type'=>'text','name'=>'en_que_mes_estamos', 'id'=>'en_que_mes_estamos', 'value'=>set_value('en_que_mes_estamos', $list[0]->en_que_mes_estamos))); ?></td>
	    	<td><?= form_dropdown('en_que_mes_estamos_puntaje',$puntaje,set_value('en_que_mes_estamos_puntaje', $list[0]->en_que_mes_estamos_puntaje)); ?></td>
	    	<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("en_que_mes_estamos_puntaje", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='en_que_mes_estamos_puntaje_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='en_que_mes_estamos_puntaje_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
	    	<td>¿En qué Día de la semana estamos?</td>
	    	<td><?= form_input(array('type'=>'text','name'=>'en_que_dia_estamos', 'id'=>'en_que_dia_estamos', 'value'=>set_value('en_que_dia_estamos', $list[0]->en_que_dia_estamos))); ?></td>
	    	<td><?= form_dropdown('en_que_dia_estamos_puntaje',$puntaje,set_value('en_que_dia_estamos_puntaje', $list[0]->en_que_dia_estamos_puntaje)); ?></td>
	    	<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("en_que_dia_estamos_puntaje", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='en_que_dia_estamos_puntaje_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='en_que_dia_estamos_puntaje_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
	    	<td>¿En qué Fecha estamos?</td>
	    	<td><?= form_input(array('type'=>'text','name'=>'en_que_fecha_estamos', 'id'=>'en_que_fecha_estamos', 'value'=>set_value('en_que_fecha_estamos', $list[0]->en_que_fecha_estamos))); ?></td>
	    	<td><?= form_dropdown('en_que_fecha_estamos_puntaje',$puntaje,set_value('en_que_fecha_estamos_puntaje', $list[0]->en_que_fecha_estamos_puntaje)); ?></td>
	    	<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("en_que_fecha_estamos", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='en_que_fecha_estamos_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='en_que_fecha_estamos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
	    	<td style='font-weight:bold;' colspan='4'>ORIENTACION EN EL LUGAR</td>	    	
	    </tr>	    
	    <tr>
	    	<td>¿En qué Región (provincia) estamos?</td>
	    	<td><?= form_input(array('type'=>'text','name'=>'en_que_region_estamos', 'id'=>'en_que_region_estamos', 'value'=>set_value('en_que_region_estamos', $list[0]->en_que_region_estamos))); ?></td>
	    	<td><?= form_dropdown('en_que_region_estamos_puntaje',$puntaje,set_value('en_que_region_estamos_puntaje', $list[0]->en_que_region_estamos_puntaje)); ?></td>
	    	<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("en_que_region_estamos", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id=en_que_region_estamos'_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='en_que_region_estamos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>¿En qué Comuna (o ciudad/pueblo) estamos?</td>
			<td><?= form_input(array('type'=>'text','name'=>'comuna_estamos', 'id'=>'comuna_estamos', 'value'=>set_value('comuna_estamos', $list[0]->comuna_estamos))); ?></td>
			<td><?= form_dropdown('comuna_estamos_puntaje',$puntaje,set_value('comuna_estamos_puntaje', $list[0]->comuna_estamos_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("comuna_estamos", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='comuna_estamos_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='comuna_estamos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>¿En qué Ciudad/pueblo (o parte de la ciudad/barrio) estamos?</td>
			<td><?= form_input(array('type'=>'text','name'=>'barrio_estamos', 'id'=>'barrio_estamos', 'value'=>set_value('barrio_estamos', $list[0]->barrio_estamos))); ?></td>
			<td><?= form_dropdown('barrio_estamos_puntaje',$puntaje,set_value('barrio_estamos_puntaje', $list[0]->barrio_estamos_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("barrio_estamos", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='barrio_estamos_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='barrio_estamos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>¿En qué Edificio (nombre o tipo) estamos?</td>
			<td><?= form_input(array('type'=>'text','name'=>'edificio_estamos', 'id'=>'edificio_estamos', 'value'=>set_value('edificio_estamos', $list[0]->edificio_estamos))); ?></td>
			<td><?= form_dropdown('edificio_estamos_puntaje',$puntaje,set_value('edificio_estamos_puntaje', $list[0]->edificio_estamos_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("edificio_estamos", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='edificio_estamos_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='edificio_estamos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>¿En que Piso del Edificio (número de habitación o dirección) estamos?</td>
			<td><?= form_input(array('type'=>'text','name'=>'edificio_estamos2', 'id'=>'edificio_estamos2', 'value'=>set_value('edificio_estamos2', $list[0]->edificio_estamos2))); ?></td>
			<td><?= form_dropdown('edificio_estamos2_puntaje',$puntaje,set_value('edificio_estamos2_puntaje', $list[0]->edificio_estamos2_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("edificio_estamos2", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='edificio_estamos2_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='edificio_estamos2_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td style='font-style:italic;' colspan='4'>*Los nombres de los lugares se pueden sustituir por nombres alternativos que sean apropiados y más precisos para el escenario. Se deben registrar.</td>
		</tr>	
		<tr>
			<td style='font-weight:bold;' colspan='4'>REGISTRO</td>
		</tr>
		<tr>			
			<?php if($etapa == 1 OR $etapa == 5){ ?>
				<td colspan='4'><b>Escuche atentamente. Voy a decir tres palabras. Repítalas una vez que yo las haya dicho. ¿Estás listo? Las palabras son… ÁRBOL</b>
		 [pausa], MESA [pausa], AVIÓN [pausa]. Ahora dígame esas palabras (se puede repetir hasta cinco veces, pero registre sólo el primer intento).
				</td>
			<?php } elseif($etapa == 4){ ?>
					<td colspan='4'><b>Escuche atentamente. Voy a decir tres palabras. Repítalas una vez que yo las haya dicho. ¿Estás listo? Las palabras son… PELOTA</b>
		 [pausa], BANDERA [pausa], MANZANA [pausa]. Ahora dígame esas palabras (se puede repetir hasta cinco veces, pero registre sólo el primer intento).
				</td>
			<?php }else{ ?>
				<td colspan='4'><b>Escuche atentamente. Voy a decir tres palabras. Repítalas una vez que yo las haya dicho. ¿Estás listo? Las palabras son… MANZANA</b>
		 [pausa], PESO [pausa], MESA [pausa]. Ahora dígame esas palabras (se puede repetir hasta cinco veces, pero registre sólo el primer intento).
				</td>

			<?php } ?>
		</tr>
		<tr>
			<td><?= (($etapa == 1 OR $etapa == 5) ? 'ÁRBOL' : (($etapa == 4) ? 'PELOTA' : 'MANZANA' ));?></td>
			<td><?= form_input(array('type'=>'text','name'=>'manzana', 'id'=>'manzana', 'value'=>set_value('manzana', $list[0]->manzana))); ?></td>
			<td><?= form_dropdown('manzana_puntaje',$puntaje,set_value('manzana_puntaje', $list[0]->manzana_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("manzana", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='manzana_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='manzana_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td><?= (($etapa == 1 OR $etapa == 5) ? 'MESA' : (($etapa == 4) ? 'BANDERA' : 'PESO' ));?></td>
			<td><?= form_input(array('type'=>'text','name'=>'peso', 'id'=>'peso', 'value'=>set_value('peso', $list[0]->peso))); ?></td>
			<td><?= form_dropdown('peso_puntaje',$puntaje,set_value('peso_puntaje', $list[0]->peso_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("peso", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='peso_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='peso_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td><?= (($etapa == 1 OR $etapa == 5) ? 'AVIÓN' : (($etapa == 4) ? 'MANZANA' : 'MESA' ));?></td>
			<td><?= form_input(array('type'=>'text','name'=>'mesa', 'id'=>'mesa', 'value'=>set_value('mesa', $list[0]->mesa))); ?></td>
			<td><?= form_dropdown('mesa_puntaje',$puntaje,set_value('mesa_puntaje', $list[0]->mesa_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("mesa", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='mesa_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='mesa_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
					}
				?>
			</td>
		</tr>
		<tr><td colspan='4'><b>Recuerde esas palabras. Le voy a pedir que me las repita en unos minutos más.</b></td></tr>
		<tr><td colspan='4' style='font-style:italic;'>*Cuando se vuelva a examinar a la persona, el grupo de palabras se pueden sustituir por un grupo alternativo (PONY, MONEDA, NARANJA). Se debe registrar la sustitución.</td></tr>	
	

		<tr>
			<td style='font-weight:bold;' colspan='4'>ATENCIÓN Y CÁLCULO (Series de 7)</td>
		</tr>
		<tr><td colspan='4'>A.-</td></tr>
		<tr>
			<td colspan='4'><b>Ahora, me gustaría que restara 100 menos 7. Siga restando 7 a los resultados que vaya obteniendo, hasta que le diga que se detenga.</b></td>
		</tr>
		<tr>
			<td>¿Cuánto es 100 menos 7?	[93]</td>
			<td><?= form_input(array('type'=>'text','name'=>'cuanto_93', 'id'=>'cuanto_93', 'value'=>set_value('cuanto_93', $list[0]->cuanto_93))); ?></td>
			<td><?= form_dropdown('cuanto_93_puntaje',$puntaje,set_value('cuanto_93_puntaje', $list[0]->cuanto_93_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("cuanto_93", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='cuanto_93_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='cuanto_93_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
					}
				?>
			</td>
		<tr>

		<tr>
			<td>Si es necesario diga: Continúe.	[86]</td>
			<td><?= form_input(array('type'=>'text','name'=>'cuanto_86', 'id'=>'cuanto_86', 'value'=>set_value('cuanto_86', $list[0]->cuanto_86))); ?></td>
			<td><?= form_dropdown('cuanto_86_puntaje',$puntaje,set_value('cuanto_86_puntaje', $list[0]->cuanto_86_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("cuanto_86", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='cuanto_86_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='cuanto_86_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>Si es necesario diga: Continúe.	[79]</td>
			<td><?= form_input(array('type'=>'text','name'=>'cuanto_79', 'id'=>'cuanto_79', 'value'=>set_value('cuanto_79', $list[0]->cuanto_79))); ?></td>
			<td><?= form_dropdown('cuanto_79_puntaje',$puntaje,set_value('cuanto_79_puntaje', $list[0]->cuanto_79_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("cuanto_79", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='cuanto_79_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='cuanto_79_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>Si es necesario diga: Continúa.	[72]</td>
			<td><?= form_input(array('type'=>'text','name'=>'cuanto_72', 'id'=>'cuanto_72', 'value'=>set_value('cuanto_72', $list[0]->cuanto_72))); ?></td>
			<td><?= form_dropdown('cuanto_72_puntaje',$puntaje,set_value('cuanto_72_puntaje', $list[0]->cuanto_72_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("cuanto_72", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='cuanto_72_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='cuanto_72_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>Si es necesario diga: Continúa.	[65]</td>
			<td><?= form_input(array('type'=>'text','name'=>'cuanto_65', 'id'=>'cuanto_65', 'value'=>set_value('cuanto_65', $list[0]->cuanto_65))); ?></td>
			<td><?= form_dropdown('cuanto_65_puntaje',$puntaje,set_value('cuanto_65_puntaje', $list[0]->cuanto_65_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("cuanto_65", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='cuanto_65_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='cuanto_65_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td colspan='2'>Puntaje total seccion a</td>			
			<td><?= form_dropdown('puntaje_seccion_a',array(''=>'','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'),set_value('puntaje_seccion_a', $list[0]->puntaje_seccion_a), array('id'=>'puntaje_seccion_a')); ?></td>
		</tr>
		<tr><td colspan='3'>B.-</td></tr>
		<tr>
			<td>Pídale al paciente que deletree la palabra "MUNDO" (usted puede ayudarlo) Luego dígale. "Ahora deletréela de atrás para adelante" (espere máximo 30")</td>
			<td><?= form_input(array('type'=>'text','name'=>'mundo_respuesta', 'id'=>'mundo_respuesta', 'value'=>set_value('mundo_respuesta', $list[0]->mundo_respuesta))); ?></td>
			<td><?= form_dropdown('mundo_puntaje',$puntaje,set_value('mundo_puntaje', $list[0]->mundo_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("mundo_puntaje", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='mundo_puntaje_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='mundo_puntaje_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td colspan='4' style='font-weight:bold;'>MEMORIA</td>			
		</tr>
		<tr>
			<td colspan='4' style='font-weight:bold;'>¿Cuáles eran las tres palabras que le pedí que recordara? [No de pistas]</td>
		</tr>
		<tr>
			<td><?= (($etapa == 1 OR $etapa == 5) ? 'ÁRBOL' : (($etapa == 4) ? 'PELOTA' : 'MANZANA' ));?></td>
			<td><?= form_input(array('type'=>'text','name'=>'manzana_2', 'id'=>'manzana_2', 'value'=>set_value('manzana_2', $list[0]->manzana_2))); ?></td>
			<td><?= form_dropdown('manzana_2_puntaje',$puntaje,set_value('manzana_2_puntaje', $list[0]->manzana_2_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("manzana_2", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='manzana_2_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='manzana_2_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td><?= (($etapa == 1 OR $etapa == 5) ? 'MESA' : (($etapa == 4) ? 'BANDERA' : 'PESO' ));?></td>
			<td><?= form_input(array('type'=>'text','name'=>'peso_2', 'id'=>'peso_2', 'value'=>set_value('peso_2', $list[0]->peso_2))); ?></td>
			<td><?= form_dropdown('peso_2_puntaje',$puntaje,set_value('peso_2_puntaje', $list[0]->peso_2_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("peso_2", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='peso_2_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='peso_2_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td><?= (($etapa == 1 OR $etapa == 5) ? 'AVIÓN' : (($etapa == 4) ? 'MANZANA' : 'MESA' ));?></td>
			<td><?= form_input(array('type'=>'text','name'=>'mesa_2', 'id'=>'mesa_2', 'value'=>set_value('mesa_2', $list[0]->mesa_2))); ?></td>
			<td><?= form_dropdown('mesa_2_puntaje',$puntaje,set_value('mesa_2_puntaje', $list[0]->mesa_2_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("mesa_2", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='mesa_2_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='mesa_2_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td colspan='4' style='font-weight:bold;'>NOMBRES</td>
		</tr>
		<tr>
			<td><b>¿Qué es esto?</b><?= form_input(array('type'=>'text','name'=>'mostrado_que_es_1', 'id'=>'mostrado_que_es_1', 'value'=>set_value('mostrado_que_es_1', $list[0]->mostrado_que_es_2))); ?></td>
			<td><?= form_input(array('type'=>'text','name'=>'que_es_1', 'id'=>'que_es_1', 'value'=>set_value('que_es_1', $list[0]->que_es_1))); ?></td>
			<td><?= form_dropdown('que_es_1_puntaje',$puntaje,set_value('que_es_1_puntaje', $list[0]->que_es_1_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("que_es_1", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='que_es_1_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='que_es_1_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td><b>¿Qué es esto?</b><?= form_input(array('type'=>'text','name'=>'mostrado_que_es_2', 'id'=>'mostrado_que_es_2', 'value'=>set_value('mostrado_que_es_2', $list[0]->mostrado_que_es_2))); ?></td>
			<td><?= form_input(array('type'=>'text','name'=>'que_es_2', 'id'=>'que_es_2', 'value'=>set_value('que_es_2', $list[0]->que_es_2))); ?></td>
			<td><?= form_dropdown('que_es_2_puntaje',$puntaje,set_value('que_es_2_puntaje', $list[0]->que_es_2_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("que_es_2", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='que_es_2_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='que_es_2_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td colspan='4' style='font-style:italic;'>*Estos objetos se pueden sustituir por objetos alternativos comunes (por ejemplo: lentes, silla, llaves). Se deben registrar.</td>
		</tr>
		<tr>
			<td colspan='4' style='font-weight:bold;'>REPETICION</td>
		</tr>
		<tr>
			<td colspan='4'>Ahora le voy a pedir que repita lo que yo voy a decir. ¿Está listo? <b>“NO SI, O CUANDO, O PORQUÉ”</b> Ahora dígalo usted.</td>
		</tr>
		<tr>
			<td colspan='4' style='font-style:italic;'>[Se puede repetir la prueba hasta 5 veces, pero registre sólo el primer intento.]</td>
		</tr>
		<tr>
			<td>NO SI, O CUANDO, O PORQUÉ.</td>
			<td><?= form_input(array('type'=>'text','name'=>'no_si_cuando_porque', 'id'=>'no_si_cuando_porque', 'value'=>set_value('no_si_cuando_porque', $list[0]->no_si_cuando_porque))); ?></td>
			<td><?= form_dropdown('no_si_cuando_porque_puntaje',$puntaje,set_value('no_si_cuando_porque_puntaje', $list[0]->no_si_cuando_porque_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("no_si_cuando_porque", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='no_si_cuando_porque_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='no_si_cuando_porque_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td colspan='4' style='font-weight:bold;'>Por favor utilice las páginas que vienen a continuación del formulario MMSE para realizar los siguientes 4 ejercicios
(Comprensión: página en blanco, lectura: página que dice “CIERRE LOS OJOS”, Escritura: página en blanco,
Dibujo: página con el diagrama).</td>
		</tr>
		<tr>	
			<td colspan='4' style='font-weight:bold;'>COMPRENSION </td>
		</tr>
		<tr>
			<td colspan='4'><b>Escuche atentamente porque le voy a pedir que haga algo. Tome este papel con la mano derecha</b> [pausa],<b> dóblelo por la mitad</b> [pausa] <b>y póngalo en el piso (o en la mesa).</b></td>
		</tr>
		<tr>	
			<td>TOMARLO CON LA MANO DERECHA</td>
			<td><?= form_input(array('type'=>'text','name'=>'tomar_con_la_mano_derecha', 'id'=>'tomar_con_la_mano_derecha', 'value'=>set_value('tomar_con_la_mano_derecha', $list[0]->tomar_con_la_mano_derecha))); ?></td>
			<td><?= form_dropdown('tomar_con_la_mano_derecha_puntaje',$puntaje,set_value('tomar_con_la_mano_derecha_puntaje', $list[0]->tomar_con_la_mano_derecha_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("tomar_con_la_mano_derecha", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='tomar_con_la_mano_derecha_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='tomar_con_la_mano_derecha_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>DOBLAR POR LA MITAD
			<td><?= form_input(array('type'=>'text','name'=>'doblar_por_la_mitad', 'id'=>'doblar_por_la_mitad', 'value'=>set_value('doblar_por_la_mitad', $list[0]->doblar_por_la_mitad))); ?></td>
			<td><?= form_dropdown('doblar_por_la_mitad_puntaje',$puntaje,set_value('doblar_por_la_mitad_puntaje', $list[0]->doblar_por_la_mitad_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("doblar_por_la_mitad", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='doblar_por_la_mitad_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='doblar_por_la_mitad_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>PONER EN EL PISO	
			<td><?= form_input(array('type'=>'text','name'=>'poner_en_el_piso', 'id'=>'poner_en_el_piso', 'value'=>set_value('poner_en_el_piso', $list[0]->poner_en_el_piso))); ?></td>
			<td><?= form_dropdown('poner_en_el_piso_puntaje',$puntaje,set_value('poner_en_el_piso_puntaje', $list[0]->poner_en_el_piso_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("poner_en_el_piso", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='poner_en_el_piso_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='poner_en_el_piso_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td colspan='4' style='font-weight:bold;'>LECTURA</td>
		</tr>
		<tr>
			<td colspan='4'><b>Por favor lea lo siguiente y haga lo que dice.</b> (Muestre a la persona examinada las palabras en el formulario de estímulo).</td>
		</tr>
		<tr>
			<td>CIERRE LOS OJOS</td>
			<td><?= form_input(array('type'=>'text','name'=>'cierre_los_ojos', 'id'=>'cierre_los_ojos', 'value'=>set_value('cierre_los_ojos', $list[0]->cierre_los_ojos))); ?></td>
			<td><?= form_dropdown('cierre_los_ojos_puntaje',$puntaje,set_value('cierre_los_ojos_puntaje', $list[0]->cierre_los_ojos_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("cierre_los_ojos", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='cierre_los_ojos_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='cierre_los_ojos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td colspan='4' style='font-weight:bold;'>ESCRITURA</td>
		</tr>
		<tr>
			<td colspan='4'><b>Por favor escriba una oración.</b> [Si la persona examinada no responde diga: <b>Escribe sobre el clima.</b>]</td>
		</tr>
		<tr>
			<td colspan='4'>Ponga la hoja en blanco (sin doblar) frente al paciente y pásele un lápiz mina o pasta. Dé 1 punto si la oración se entiende y contiene un sujeto y un verbo. Ignore los errores de gramática u ortografía.</td>
		</tr>
		<tr>
			<td colspan='3'><?= form_dropdown('escritura_puntaje',$puntaje,set_value('escritura_puntaje', $list[0]->escritura_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("escritura_puntaje", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='escritura_puntaje_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='escritura_puntaje_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td colspan='4' style='font-weight:bold;'>DIBUJO</td>
		</tr>
		<tr>
			<td colspan='4'><b>Por favor copie este dibujo.</b> [Muestre los pentágonos superpuestos en el formulario de estímulo.]</td>
		</tr>
		<tr>
			<td colspan='4'>Dé 1 punto si el dibujo consiste en dos figuras de cinco lados que intersectan para formar una figura de cuatro lados.</td>
		</tr>
		<tr>
			<td colspan='3'><?= form_dropdown('dibujo_puntaje',$puntaje,set_value('dibujo_puntaje', $list[0]->dibujo_puntaje)); ?></td>
			<td>
	    		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("dibujo_puntaje", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'mmse_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='dibujo_puntaje_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'mmse_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='dibujo_puntaje_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td colspan='4' style='text-align:center;'>
				<?= form_hidden('puntaje_total'); ?>
				<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'mmse_update')){
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
			AND strpos($_SESSION['role_options']['subject'], 'mmse_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/mmse_verify', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'mmse_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/mmse_lock', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'mmse_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/mmse_signature', array('class'=>'form-horizontal')); ?>    	
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