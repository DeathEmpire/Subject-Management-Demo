<script src="<?= base_url('js/digito_directo.js') ?>"></script>
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
				"form": "digito_directo",
				"form_nombre" : "Prueba de digito directo",
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
<legend style='text-align:center;'>Prueba de Digito Directo <?= $protocolo; ?></legend>
	
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

	<?= form_open('subject/digito_directo_update', array('class'=>'form-horizontal', 'id'=>'form_digito_directo')); ?>
		
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

		Realizado: 
		<?= form_radio($data,$data['value'],set_radio($data['name'], 1, (($list[0]->realizado == 1) ? true : false))); ?> Si
		<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0, (($list[0]->realizado == 0) ? true : false))); ?> NO
		<br />
			Fecha: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', ((!empty($list[0]->fecha) AND $list[0]->fecha !='0000-00-00') ? date("d/m/Y", strtotime($list[0]->fecha)) : "") ))); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("fecha", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_query' tipo='new' class='query'>";
							}else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";	
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
								echo "<img src='". base_url('img/question.png') ."' id='fecha_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>


		<table class='table table-striped table-hover table-bordered table-condensed'>
			<thead>
				<tr>
					<th></th>
					<th>Item</th>
					<th>Intento</th>
					<th>Respuesta</th>
					<th>Puntaje Intento</th>
					<th>Puntaje Item</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td rowspan='16'>-></td>
					<td rowspan='2'>1</td>
					<td>9-7</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_1a',$valores_intento,set_value('puntaje_intento_1a', $list[0]->puntaje_intento_1a),array('id'=>'puntaje_intento_1a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_1a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_1a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_1a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
					<td rowspan='2' style='vertical-align:middle;'><?= form_dropdown('puntaje_item_1a',$valores_item, set_value('puntaje_item_1a', $list[0]->puntaje_item_1a),array('id'=>'puntaje_item_1a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_item_1a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_item_1a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_item_1a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				</tr>
				<tr>				
					<td>6-3</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_1b',$valores_intento, set_value('puntaje_intento_1b', $list[0]->puntaje_intento_1b),array('id'=>'puntaje_intento_1b')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_1b", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_1b_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_1b_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				</tr>
				<tr>				
					<td rowspan='2'>2</td>
					<td>5-8-2</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_2a',$valores_intento, set_value('puntaje_intento_2a', $list[0]->puntaje_intento_2a),array('id'=>'puntaje_intento_2a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_2a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_2a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_2a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
					<td rowspan='2' style='vertical-align:middle;'><?= form_dropdown('puntaje_item_2a',$valores_item, set_value('puntaje_item_2a', $list[0]->puntaje_item_2a),array('id'=>'puntaje_item_2a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_item_2a", $campos_query)) 
							{								
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_item_2a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_item_2a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				</tr>
				<tr>
					<td>6-9-4</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_2b',$valores_intento, set_value('puntaje_intento_2b', $list[0]->puntaje_intento_2b),array('id'=>'puntaje_intento_2b')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_2b", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_2b_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_2b_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				</tr>
				<tr>
					<td rowspan='2'>3</td>
					<td>7-2-8-6</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_3a',$valores_intento, set_value('puntaje_intento_3a', $list[0]->puntaje_intento_3a),array('id'=>'puntaje_intento_3a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_3a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_3a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_3a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
					<td rowspan='2' style='vertical-align:middle;'><?= form_dropdown('puntaje_item_3a',$valores_item, set_value('puntaje_item_3a', $list[0]->puntaje_item_3a),array('id'=>'puntaje_item_3a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_item_3a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_item_3a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_item_3a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				</tr>
				<tr>
					<td>6-4-3-9</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_3b',$valores_intento, set_value('puntaje_intento_3b', $list[0]->puntaje_intento_3b),array('id'=>'puntaje_intento_3b')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_3b", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_3b_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_3b_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				</tr>
				<tr>
					<td rowspan='2'>4</td>
					<td>4-2-7-3-1</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_4a',$valores_intento, set_value('puntaje_intento_4a', $list[0]->puntaje_intento_4a),array('id'=>'puntaje_intento_4a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_4a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_4a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_4a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
					<td rowspan='2' style='vertical-align:middle;'><?= form_dropdown('puntaje_item_4a',$valores_item, set_value('puntaje_item_4a', $list[0]->puntaje_item_4a),array('id'=>'puntaje_item_4a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_item_4a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_item_4a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_item_4a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				</tr>
				<tr>
					<td>7-5-8-3-6</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_4b',$valores_intento, set_value('puntaje_intento_4b', $list[0]->puntaje_intento_4b),array('id'=>'puntaje_intento_4b')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_4b", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_4b_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_4b_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				</tr>
				<tr>
					<td rowspan='2'>5</td>
					<td>3-9-2-4-8-7</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_5a',$valores_intento, set_value('puntaje_intento_5a', $list[0]->puntaje_intento_5a),array('id'=>'puntaje_intento_5a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_5a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_5a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_5a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
					<td rowspan='2' style='vertical-align:middle;'><?= form_dropdown('puntaje_item_5a',$valores_item, set_value('puntaje_item_5a', $list[0]->puntaje_item_5a),array('id'=>'puntaje_item_5a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_item_5a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_item_5a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_item_5a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				</tr>
				<tr>
					<td>6-1-9-4-7-3</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_5b',$valores_intento, set_value('puntaje_intento_5b', $list[0]->puntaje_intento_5b),array('id'=>'puntaje_intento_5b')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_5b", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_5b_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_5b_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				</tr>
				<tr>
					<td rowspan='2'>6</td>
					<td>4-1-7-9-3-8-6</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_6a',$valores_intento, set_value('puntaje_intento_6a', $list[0]->puntaje_intento_6a),array('id'=>'puntaje_intento_6a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_6a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_6a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_6a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
					<td rowspan='2' style='vertical-align:middle;'><?= form_dropdown('puntaje_item_6a',$valores_item, set_value('puntaje_item_6a', $list[0]->puntaje_item_6a),array('id'=>'puntaje_item_6a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_item_6a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_item_6a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_item_6a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
					</td>
				</tr>
				<tr>
					<td>6-9-1-7-4-2-8</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_6b',$valores_intento, set_value('puntaje_intento_6b', $list[0]->puntaje_intento_6b),array('id'=>'puntaje_intento_6b')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_6b", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_6b_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}	
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_6b_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				</tr>
				<tr>
					<td rowspan='2'>7</td>
					<td>3-8-2-9-6-1-7-4</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_7a',$valores_intento, set_value('puntaje_intento_7a', $list[0]->puntaje_intento_7a),array('id'=>'puntaje_intento_7a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_7a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_7a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}	
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_7a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}	
							}						
							
						}
					?>
				</td>
					<td rowspan='2' style='vertical-align:middle;'><?= form_dropdown('puntaje_item_7a',$valores_item, set_value('puntaje_item_7a', $list[0]->puntaje_item_7a),array('id'=>'puntaje_item_7a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_item_7a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_item_7a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_item_7a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				</tr>
				<tr>
					<td>5-8-1-3-2-6-4-7</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_7b',$valores_intento, set_value('puntaje_intento_7b', $list[0]->puntaje_intento_7b),array('id'=>'puntaje_intento_7b')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_7b", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_7b_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_7b_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				</tr>
				<tr>
					<td rowspan='2'>8</td>
					<td>2-7-5-8-6-3-1-9-4</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_8a',$valores_intento, set_value('puntaje_intento_8a', $list[0]->puntaje_intento_8a),array('id'=>'puntaje_intento_8a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_8a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_8a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_8a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
					<td rowspan='2' style='vertical-align:middle;'><?= form_dropdown('puntaje_item_8a',$valores_item, set_value('puntaje_item_8a', $list[0]->puntaje_item_8a),array('id'=>'puntaje_item_8a')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_item_8a", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_item_8a_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_item_8a_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";
								}
							}						
							
						}
					?>
				</td>
				</tr>
				<tr>
					<td>7-1-3-9-4-2-5-6-8</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_8b',$valores_intento, set_value('puntaje_intento_8b', $list[0]->puntaje_intento_8b),array('id'=>'puntaje_intento_8b')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_intento_8b", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_intento_8b_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."' >";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_intento_8b_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				</tr>				
			</tbody>
		</table>

		<table class='table table-bordered table-hover'>
			<tr>
				<td style='text-align:right;'>MSDD<br><small>(Maximo = 9)</small></td>
				<td>
					<?= form_dropdown('msdd', $de_0a9, set_value('msdd',$list[0]->msdd),array('id'=>'msdd')); ?>					
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("msdd", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='msdd_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='msdd_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
				<td>Digitos Orden Direto (DOD) Puntaje Bruto Total (Maximo = 16)</td>
				<td><?= form_input(array('name'=>'puntaje_bruto', 'id'=>'puntaje_bruto', 'value'=>set_value('puntaje_bruto',$list[0]->puntaje_bruto))); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("puntaje_bruto", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='puntaje_bruto_query' tipo='new' class='query'>";
								}else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
									echo "<img src='". base_url('img/question.png') ."' id='puntaje_bruto_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
								}
							}						
							
						}
					?>
				</td>
			</tr>
		</table>

		<div style='text-align:center;'>
		<?php
			if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'digito_directo_update')){
		?>
			<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
		<?php } ?>
				<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>			
		</div>

		<?= form_close(); ?>
		<b>Creado por:</b> <?= $list[0]->usuario_creacion;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->created_at));?><br />&nbsp;</br>
		<!-- Verify -->
		<b>Aprobacion del Monitor:</b><br />
			<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
				
				Este formulario fue aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->verify_date));?>
			
			<?php
			}
			else{
			
				if(isset($_SESSION['role_options']['subject']) 
					AND strpos($_SESSION['role_options']['subject'], 'digito_directo_verify') 
					AND $list[0]->status == 'Record Complete'
				){
			?>
				<?= form_open('subject/digito_directo_verify', array('class'=>'form-horizontal')); ?>    	
				
				<?= form_hidden('id', $list[0]->id); ?>
				<?= form_hidden('subject_id', $subject->id); ?>
				<?= form_hidden('etapa', $etapa); ?>
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
				
				Este formulario fue cerrado por <?= $list[0]->lock_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->lock_date));?>
			
			<?php
			}
			else{
			
				if(isset($_SESSION['role_options']['subject']) 
					AND strpos($_SESSION['role_options']['subject'], 'digito_directo_lock')
					AND $list[0]->status == 'Form Approved by Monitor'){
			?>
				<?= form_open('subject/digito_directo_lock', array('class'=>'form-horizontal')); ?>
				<?= form_hidden('id', $list[0]->id); ?>    	
				<?= form_hidden('subject_id', $subject->id); ?>
				<?= form_hidden('etapa', $etapa); ?>
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
				
				Este formulario fue firmado por <?= $list[0]->signature_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->signature_date));?>
			
			<?php
			}
			else{
			
				if(isset($_SESSION['role_options']['subject']) 
					AND strpos($_SESSION['role_options']['subject'], 'digito_directo_signature')
					AND $list[0]->status == 'Form Approved and Locked'
				){
			?>
				<?= form_open('subject/digito_directo_signature', array('class'=>'form-horizontal')); ?>    	
				<?= form_hidden('id', $list[0]->id); ?>    	
				<?= form_hidden('subject_id', $subject->id); ?>
				<?= form_hidden('etapa', $etapa); ?>
				<?= form_hidden('current_status', $list[0]->status); ?>
					
				<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

				<?= form_close(); ?>

		<?php }else{
				echo "Pendiente de Firma";
				}
			}
		?>
		<br />
	
