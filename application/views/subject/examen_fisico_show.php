<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name=hallazgo]").click(function(){
		if($(this).val() == 1){
			//todos los campos habilitados.
			$("input:radio").removeAttr("readonly");
			$("input:radio").removeAttr("disabled");
		}
		else{
			//todos los campos bloqueados.
			$("input:radio").attr("readonly","readonly");
			$("input:radio").attr("disabled","disabled");			

			$("input[name=hallazgo]").removeAttr("readonly");
			$("input[name=hallazgo]").removeAttr("disabled");

		}
	});

	$("input[name=tuvo_cambios]").change(function(){
		if($(this).val() == 1)
		{
			$("#tr_observaciones").show();
		}else{
			$("#tr_observaciones").hide();
			$("#cambios_observaciones").val('');
		}
	});

	if($("input[name=tuvo_cambios]:checked").val() == 1)
	{
		$("#tr_observaciones").show();
	}else{
		$("#tr_observaciones").hide();
		$("#cambios_observaciones").val('');
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
				"form": "examen_fisico",
				"form_nombre" : "Examen Fisico",
				"form_id" : '<?php echo $list[0]->id;?>',
				"tipo": $(this).attr('tipo')
			},
			function(d){
				
				$("#query_para_campos").html(d);
				$("#query_para_campos").dialog('open');
			}
		);
	});


	$("input[name=aspecto_general]").change(function(){		
		if($(this).val() == 1){
			// alert(122);
			$("textarea[name=aspecto_general_desc]").prop('readonly', true);			
		}
		else{
			$("textarea[name=aspecto_general_desc]").removeAttr('readonly');	
		}
	});
	
	$("input[name=piel]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=piel_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=piel_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=cabeza]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=cabeza_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=cabeza_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=ojos]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=ojos_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=ojos_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=nariz]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=nariz_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=nariz_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=boca]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=boca_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=boca_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=oidos]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=oidos_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=oidos_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=cuello]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=cuello_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=cuello_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=pulmones]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=pulmones_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=pulmones_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=cardiovascular]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=cardiovascular_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=cardiovascular_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=abdomen]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=abdomen_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=abdomen_desc]").removeAttr('readonly');	
		}
	});
	$("input[name=muscular]").change(function(){
		if($(this).val() == 1){
			$("textarea[name=muscular_desc]").attr('readonly','readonly');
		}
		else{
			$("textarea[name=muscular_desc]").removeAttr('readonly');	
		}
	});



	if($("input[name=aspecto_general]:checked").val() == 1){			
		$("textarea[name=aspecto_general_desc]").prop('readonly', true);			
	}
	else{
		$("textarea[name=aspecto_general_desc]").removeAttr('readonly');	
	}
	
		
	if($("input[name=piel]:checked").val() == 1){
		$("textarea[name=piel_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=piel_desc]").removeAttr('readonly');	
	}
	

	if($("input[name=cabeza]:checked").val() == 1){
		$("textarea[name=cabeza_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=cabeza_desc]").removeAttr('readonly');	
	}


	if($("input[name=ojos]:checked").val() == 1){
		$("textarea[name=ojos_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=ojos_desc]").removeAttr('readonly');	
	}


	if($("input[name=nariz]:checked").val() == 1){
		$("textarea[name=nariz_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=nariz_desc]").removeAttr('readonly');	
	}


	if($("input[name=boca]:checked").val() == 1){
		$("textarea[name=boca_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=boca_desc]").removeAttr('readonly');	
	}


	if($("input[name=oidos]:checked").val() == 1){
		$("textarea[name=oidos_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=oidos_desc]").removeAttr('readonly');	
	}

	
	if($("input[name=cuello]:checked").val() == 1){
		$("textarea[name=cuello_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=cuello_desc]").removeAttr('readonly');	
	}
	

	if($("input[name=pulmones]:checked").val() == 1){
		$("textarea[name=pulmones_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=pulmones_desc]").removeAttr('readonly');	
	}


	if($("input[name=cardiovascular]:checked").val() == 1){
		$("textarea[name=cardiovascular_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=cardiovascular_desc]").removeAttr('readonly');	
	}


	if($("input[name=abdomen]:checked").val() == 1){
		$("textarea[name=abdomen_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=abdomen_desc]").removeAttr('readonly');	
	}

	
	if($("input[name=muscular]:checked").val() == 1){
		$("textarea[name=muscular_desc]").attr('readonly','readonly');
	}
	else{
		$("textarea[name=muscular_desc]").removeAttr('readonly');	
	}

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
		<legend style='text-align:center;'>Examen Físico <?= (($etapa != 1 AND $etapa != 5 AND $etapa != 6) ? 'Abreviado' : ''); ?><?= $protocolo;?></legend>
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
<div style='display:none;'>
    <div id='dialog_auditoria'><?= ((isset($auditoria) AND !empty($auditoria)) ? $auditoria : ''); ?></div>
</div>
<?php
    if(isset($auditoria) AND !empty($auditoria)){
        echo "<div style='text-align:right;'><a id='ver_auditoria' class='btn btn-info colorbox_inline' href='#dialog_auditoria'>Ver Auditoria</a></div>";
    }
?>
	<?= form_open('subject/examen_fisico_update', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>

	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>
	<?= form_hidden('last_status', $list[0]->status); ?>
	<?= form_hidden('id', $list[0]->id); ?>

		<table class='table table-striped table-hover table-bordered table-condensed'>
			<tr>
				<td>Examen f&iacute;sico realizado: </td>
				<td>
					<?= form_radio(array('name'=>'hallazgo', 'value'=>1, 'checked'=>set_radio('hallazgo', 1, (($list[0]->hallazgo  == 1 ) ? true : false)))); ?> Si 
					<?= form_radio(array('name'=>'hallazgo', 'value'=>0, 'checked'=>set_radio('hallazgo', 0, (($list[0]->hallazgo  == "0" ) ? true : false)))); ?> No
				</td>
				<td></td>
			</tr>
			<?php if($etapa == 1 OR $etapa == 5 OR $etapa == 6){ ?>
				<tr>
					<td>La fecha del examen es la misma fecha de la visita?: </td>
					<td>
						<?= form_radio(array('name'=>'misma_fecha', 'value'=>1, 'checked'=>set_radio('misma_fecha', 1, (($list[0]->misma_fecha  == 1 ) ? true : false)))); ?> Si 
						<?= form_radio(array('name'=>'misma_fecha', 'value'=>0, 'checked'=>set_radio('misma_fecha', 0, (($list[0]->misma_fecha  == "0" ) ? true : false)))); ?> No
					</td>
					<td></td>
				</tr>
			<?php } else { ?>
					<?= form_hidden('misma_fecha',0); ?>
			<?php } ?>
			
			<tr>
				<td>Fecha: </td>
				<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', ((!empty($list[0]->fecha) AND $list[0]->fecha != '0000-00-00') ? date("d/m/Y", strtotime($list[0]->fecha)) : "") ))); ?></td>
				<td>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("fecha", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){					
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
			<tr style='background-color:#ddd;'>
				<td></td>
				<td></td>
				<td style='font-weight:bold;'>Describa hallazgos</td>
			</tr>
						
			
				<tr>
					<td>Aspecto general: </td>
					<td>
						<?= form_radio(array('name'=>'aspecto_general','value'=>'1','checked'=>set_radio('aspecto_general', 1,(($list[0]->aspecto_general  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'aspecto_general','value'=>'0','checked'=>set_radio('aspecto_general', 0,(($list[0]->aspecto_general  == "0" ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'aspecto_general_desc','id'=>'aspecto_general_desc', 'value'=>set_value('aspecto_general_desc', $list[0]->aspecto_general_desc), 'rows'=>3)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("aspecto_general", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='aspecto_general_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='aspecto_general_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Piel: </td>
					<td>
						<?= form_radio(array('name'=>'piel','value'=>'1','checked'=>set_radio('piel', 1,(($list[0]->piel  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'piel','value'=>'0','checked'=>set_radio('piel', 0,(($list[0]->piel  == "0" ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'piel_desc','id'=>'piel_desc', 'value'=>set_value('piel_desc', $list[0]->piel_desc), 'rows'=>3)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("piel", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='piel_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='piel_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Cabeza: </td>
					<td>
						<?= form_radio(array('name'=>'cabeza','value'=>'1','checked'=>set_radio('cabeza', 1,(($list[0]->cabeza  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'cabeza','value'=>'0','checked'=>set_radio('cabeza', 0,(($list[0]->cabeza  == "0" ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'cabeza_desc','id'=>'cabeza_desc', 'value'=>set_value('cabeza_desc', $list[0]->cabeza_desc), 'rows'=>3)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("cabeza", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='cabeza_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='cabeza_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Ojos: </td>
					<td>
						<?= form_radio(array('name'=>'ojos','value'=>'1','checked'=>set_radio('ojos', 1,(($list[0]->ojos  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'ojos','value'=>'0','checked'=>set_radio('ojos', 0,(($list[0]->ojos  == "0" ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'ojos_desc','id'=>'ojos_desc', 'value'=>set_value('ojos_desc', $list[0]->ojos_desc), 'rows'=>3)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("ojos", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='ojos_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='ojos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Nariz: </td>
					<td>
						<?= form_radio(array('name'=>'nariz','value'=>'1','checked'=>set_radio('nariz', 1,(($list[0]->nariz  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'nariz','value'=>'0','checked'=>set_radio('nariz', 0,(($list[0]->nariz  == "0" ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'nariz_desc','id'=>'nariz_desc', 'value'=>set_value('nariz_desc', $list[0]->nariz_desc), 'rows'=>3)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("nariz", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='nariz_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='nariz_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Oidos: </td>
					<td>
						<?= form_radio(array('name'=>'oidos','value'=>'1','checked'=>set_radio('oidos', 1,(($list[0]->oidos  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'oidos','value'=>'0','checked'=>set_radio('oidos', 0,(($list[0]->oidos  == "0" ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'oidos_desc','id'=>'oidos_desc', 'value'=>set_value('oidos_desc', $list[0]->oidos_desc), 'rows'=>3)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("oidos", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='oidos_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='oidos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Boca - Garganta: </td>
					<td>
						<?= form_radio(array('name'=>'boca','value'=>'1','checked'=>set_radio('boca', 1,(($list[0]->boca  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'boca','value'=>'0','checked'=>set_radio('boca', 0,(($list[0]->boca  == "0" ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'boca_desc','id'=>'boca_desc', 'value'=>set_value('boca_desc', $list[0]->boca_desc), 'rows'=>3)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("boca", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='boca_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='boca_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					<td>Cuello - adenopat&iacute;as: </td>
					<td>
						<?= form_radio(array('name'=>'cuello','value'=>'1','checked'=>set_radio('cuello', 1,(($list[0]->cuello  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'cuello','value'=>'0','checked'=>set_radio('cuello', 0,(($list[0]->cuello  == "0" ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'cuello_desc','id'=>'cuello_desc', 'value'=>set_value('cuello_desc', $list[0]->cuello_desc), 'rows'=>3)); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("cuello", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='cuello_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='cuello_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<?= form_hidden('piel',''); ?>
				<?= form_hidden('piel_desc',''); ?>
				<?= form_hidden('cabeza',''); ?>
				<?= form_hidden('cabeza_desc',''); ?>
				<?= form_hidden('ojos',''); ?>
				<?= form_hidden('ojos_desc',''); ?>
				<?= form_hidden('nariz',''); ?>
				<?= form_hidden('nariz_desc',''); ?>
				<?= form_hidden('oidos',''); ?>
				<?= form_hidden('oidos_desc',''); ?>
				<?= form_hidden('boca',''); ?>
				<?= form_hidden('boca_desc',''); ?>
				<?= form_hidden('cuello',''); ?>
				<?= form_hidden('cuello_desc',''); ?>
			<?php }?>			
			<tr>
				<td>Pecho, pulm&oacute;n: </td>
				<td>
					<?= form_radio(array('name'=>'pulmones','value'=>'1','checked'=>set_radio('pulmones', 1,(($list[0]->pulmones  == 1 ) ? true : false)))); ?> Normal
					<?= form_radio(array('name'=>'pulmones','value'=>'0','checked'=>set_radio('pulmones', 0,(($list[0]->pulmones  == "0" ) ? true : false)))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'pulmones_desc','id'=>'pulmones_desc', 'value'=>set_value('pulmones_desc', $list[0]->pulmones_desc), 'rows'=>3)); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("pulmones", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='pulmones_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='pulmones_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Card&iacute;aco: </td>
				<td>
					<?= form_radio(array('name'=>'cardiovascular','value'=>'1','checked'=>set_radio('cardiovascular', 1,(($list[0]->cardiovascular  == 1 ) ? true : false)  ))); ?> Normal
					<?= form_radio(array('name'=>'cardiovascular','value'=>'0','checked'=>set_radio('cardiovascular', 0,(($list[0]->cardiovascular  == "0" ) ? true : false)))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'cardiovascular_desc', 'id'=>'cardiovascular_desc', 'value'=>set_value('cardiovascular_desc', $list[0]->cardiovascular_desc), 'rows'=>3)); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("cardiovascular", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='cardiovascular_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='cardiovascular_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Abdomen: </td>
				<td>
					<?= form_radio(array('name'=>'abdomen','value'=>'1','checked'=>set_radio('abdomen', 1,(($list[0]->abdomen  == 1 ) ? true : false)))); ?> Normal
					<?= form_radio(array('name'=>'abdomen','value'=>'0','checked'=>set_radio('abdomen', 0,(($list[0]->abdomen  == "0" ) ? true : false)))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'abdomen_desc','id'=>'abdomen_desc', 'value'=>set_value('abdomen_desc', $list[0]->abdomen_desc), 'rows'=>3)); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("abdomen", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='abdomen_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='abdomen_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Muscular - Esquel&eacute;tico: </td>
				<td>
					<?= form_radio(array('name'=>'muscular','value'=>'1','checked'=>set_radio('muscular', 1,(($list[0]->muscular  == 1 ) ? true : false)))); ?> Normal
					<?= form_radio(array('name'=>'muscular','value'=>'0','checked'=>set_radio('muscular', 0,(($list[0]->muscular  == "0" ) ? true : false)))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'muscular_desc','id'=>'muscular_desc', 'value'=>set_value('muscular_desc', $list[0]->muscular_desc), 'rows'=>3)); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("muscular", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='muscular_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='muscular_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
				</td>
			</tr>

			<?php if($etapa != 1 AND $etapa != 5 AND $etapa != 6){ ?>

				<tr>
					<td>¿Tuvo el sujeto algún cambio desde la visita anterior?</td>
					<td>						
						<?= form_radio(array('name'=>'tuvo_cambios', 'value'=>1, 'checked'=>set_radio('tuvo_cambios', 1, (($list[0]->tuvo_cambios == 1) ? true : false)  ))); ?> Si
						<?= form_radio(array('name'=>'tuvo_cambios', 'value'=>0, 'checked'=>set_radio('tuvo_cambios', 0, (($list[0]->tuvo_cambios == 0) ? true : false)  ))); ?> No
					</td>
				</tr>
				<tr id='tr_observaciones' style='display:none;'>
					<td>Observaciones</td>
					<td>
						<?= form_textarea(array('name'=>'cambios_observaciones','id'=>'cambios_observaciones', 'value'=>set_value('cambios_observaciones', $list[0]->cambios_observaciones), 'rows'=>3, 'style'=>'width:100%;')); ?>
					</td>	
				</tr>
					
			<?php }else{ ?>
					<?= form_hidden('tuvo_cambios',''); ?>
					<?= form_hidden('cambios_observaciones',''); ?>
			<?php }?>

			<tr>
				<td colspan='3' style='text-align:center;'>
					<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
					<?= anchor('subject/grid/'. $subject->id, 'Volver', array('class'=>'btn')); ?>
				</td>				
			</tr>			
		</table>
	<?= form_close(); ?>

	<?php }?>

			<b>Creado por:</b> <?= $list[0]->usuario_creacion;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->created_at));?><br />&nbsp;</br>
			<!-- Verify -->
			<b>Aprobacion del Monitor:</b><br />
				<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
					
					Este formulario fue aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->verify_date));?>
				
				<?php
				}
				else{
				
					if(isset($_SESSION['role_options']['subject']) 
						AND strpos($_SESSION['role_options']['subject'], 'examen_fisico_verify') 
						AND $list[0]->status == 'Record Complete'
					){
				?>
					<?= form_open('subject/examen_fisico_verify', array('class'=>'form-horizontal')); ?>    	
					
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
						AND strpos($_SESSION['role_options']['subject'], 'examen_fisico_lock')
						AND $list[0]->status == 'Form Approved by Monitor'){
				?>
					<?= form_open('subject/examen_fisico_lock', array('class'=>'form-horizontal')); ?>
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
						AND strpos($_SESSION['role_options']['subject'], 'examen_fisico_signature')
						AND $list[0]->status == 'Form Approved and Locked'
					){
				?>
					<?= form_open('subject/examen_fisico_signature', array('class'=>'form-horizontal')); ?>    	
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
		
	

