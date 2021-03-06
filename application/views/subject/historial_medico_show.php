<script src="<?= base_url('js/historial_medico.js') ?>"></script>
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
					"form": "historial_medico",
					"form_nombre" : "Historia Medica",
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
		<legend style='text-align:center;'>Historia Medica <?= $protocolo;?></legend>
		
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
	<div style='display:none;'>
    	<div id='dialog_auditoria'><?= ((isset($auditoria) AND !empty($auditoria)) ? $auditoria : ''); ?></div>
	</div>
	<?php
	    if(isset($auditoria) AND !empty($auditoria)){
	        echo "<div style='text-align:right;'><a id='ver_auditoria' class='btn btn-info colorbox_inline' href='#dialog_auditoria'>Ver Auditoria</a></div>";
	    }
	?>
	<?= form_open('subject/historial_medico_update', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>

	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>
	<?= form_hidden('id', $list[0]->id); ?>

	<table class='table table-striped table-hover table-bordered table-condensed'>		
		<thead>
			<tr>
				<td style='font-weight:bold;'>1.- ANTECEDENTES DEL SUJETO</td>	
				<td class='span2'></td>		
				<td style='font-weight:bold;' colspan='3'>FECHA DIAGNOSTICO</td>
			</tr>
			<tr>
				<td colspan='2'></td>
				<td>Dia</td>
				<td>Mes</td>
				<td>Año</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Hipertensión arterial:</td>
				<td>
					<?= form_radio('hipertension',1,set_radio('hipertension', 1,(($list[0]->hipertension == 1) ? true : false) ));?> SI
					<?= form_radio('hipertension',0,set_radio('hipertension', 0,(($list[0]->hipertension == "0") ? true : false)));?> NO
				</td>
				<td>
					<?= form_dropdown('hipertension_dia', $dias_ea, set_value('hipertension_dia', $list[0]->hipertension_dia), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('hipertension_mes', $meses_ea, set_value('hipertension_mes', $list[0]->hipertension_mes), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('hipertension_anio', $anio_ea, set_value('hipertension_anio', $list[0]->hipertension_anio), array('class'=>'input-small')); ?>	
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("hipertension", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='hipertension_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='hipertension_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Úlcera gastrointestinal: </td>
				<td>
					<?= form_radio('ulcera',1,set_radio('ulcera', 1,(($list[0]->ulcera == 1) ? true : false)));?> SI
					<?= form_radio('ulcera',0,set_radio('ulcera', 0,(($list[0]->ulcera == "0") ? true : false)));?> NO
				</td>
				<td>
					<?= form_dropdown('ulcera_dia', $dias_ea, set_value('ulcera_dia', $list[0]->ulcera_dia), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('ulcera_mes', $meses_ea, set_value('ulcera_mes', $list[0]->ulcera_mes), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('ulcera_anio', $anio_ea, set_value('ulcera_anio', $list[0]->ulcera_anio), array('class'=>'input-small')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("ulcera", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='ulcera_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='ulcera_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Diabetes mellitus: </td>
				<td>
					<?= form_radio('diabetes',1,set_radio('diabetes', 1,(($list[0]->diabetes == 1) ? true : false)));?> SI
					<?= form_radio('diabetes',0,set_radio('diabetes', 0,(($list[0]->diabetes == "0") ? true : false)));?> NO
				</td>
				<td>
					<?= form_dropdown('diabetes_dia', $dias_ea, set_value('diabetes_dia', $list[0]->diabetes_dia), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('diabetes_mes', $meses_ea, set_value('diabetes_mes', $list[0]->diabetes_mes), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('diabetes_anio', $anio_ea, set_value('diabetes_anio', $list[0]->diabetes_anio), array('class'=>'input-small')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("diabetes", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='diabetes_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='diabetes_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Hipo/Hipertiroidismo: </td>
				<td>
					<?= form_radio('hipo_hipertiroidismo',1,set_radio('hipo_hipertiroidismo', 1,(($list[0]->hipo_hipertiroidismo == 1) ? true : false)));?> SI
					<?= form_radio('hipo_hipertiroidismo',0,set_radio('hipo_hipertiroidismo', 0,(($list[0]->hipo_hipertiroidismo == "0") ? true : false)));?> NO
				</td>
				<td>
					<?= form_dropdown('hipo_hipertiroidismo_dia', $dias_ea, set_value('hipo_hipertiroidismo_dia', $list[0]->hipo_hipertiroidismo_dia), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('hipo_hipertiroidismo_mes', $meses_ea, set_value('hipo_hipertiroidismo_mes', $list[0]->hipo_hipertiroidismo_mes), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('hipo_hipertiroidismo_anio', $anio_ea, set_value('hipo_hipertiroidismo_anio', $list[0]->hipo_hipertiroidismo_anio), array('class'=>'input-small')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("hipo_hipertiroidismo", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='hipo_hipertiroidismo_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='hipo_hipertiroidismo_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Hiperlipidemia:</td>
				<td>
					<?= form_radio('hiperlipidemia',1,set_radio('hiperlipidemia', 1,(($list[0]->hiperlipidemia == 1) ? true : false)));?> SI
					<?= form_radio('hiperlipidemia',0,set_radio('hiperlipidemia', 0,(($list[0]->hiperlipidemia == "0") ? true : false)));?> NO
				</td>
				<td>
					<?= form_dropdown('hiperlipidemia_dia', $dias_ea, set_value('hiperlipidemia_dia', $list[0]->hiperlipidemia_dia), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('hiperlipidemia_mes', $meses_ea, set_value('hiperlipidemia_mes', $list[0]->hiperlipidemia_mes), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('hiperlipidemia_anio', $anio_ea, set_value('hiperlipidemia_anio', $list[0]->hiperlipidemia_anio), array('class'=>'input-small')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("hiperlipidemia", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='hiperlipidemia_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='hiperlipidemia_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>EPOC</td>
				<td>
					<?= form_radio('epoc',1,set_radio('epoc', 1,(($list[0]->epoc == 1) ? true : false)));?> SI
					<?= form_radio('epoc',0,set_radio('epoc', 0,(($list[0]->epoc == "0") ? true : false)));?> NO
				</td>
				<td>
					<?= form_dropdown('epoc_dia', $dias_ea, set_value('epoc_dia', $list[0]->epoc_dia), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('epoc_mes', $meses_ea, set_value('epoc_mes', $list[0]->epoc_mes), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('epoc_anio', $anio_ea, set_value('epoc_anio', $list[0]->epoc_anio), array('class'=>'input-small')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("epoc", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='epoc_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='epoc_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Enfermedad coronaria:</td>
				<td>
					<?= form_radio('coronaria',1,set_radio('coronaria', 1,(($list[0]->coronaria == 1) ? true : false)));?> SI
					<?= form_radio('coronaria',0,set_radio('coronaria', 0,(($list[0]->coronaria == "0") ? true : false)));?> NO
				</td>
				<td>
					<?= form_dropdown('coronaria_dia', $dias_ea, set_value('coronaria_dia', $list[0]->coronaria_dia), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('coronaria_mes', $meses_ea, set_value('coronaria_mes', $list[0]->coronaria_mes), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('coronaria_anio', $anio_ea, set_value('coronaria_anio', $list[0]->coronaria_anio), array('class'=>'input-small')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("coronaria", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='coronaria_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='coronaria_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Rinitis:</td>
				<td>
					<?= form_radio('rinitis',1,set_radio('rinitis', 1,(($list[0]->rinitis == 1) ? true : false)));?> SI
					<?= form_radio('rinitis',0,set_radio('rinitis', 0,(($list[0]->rinitis == "0") ? true : false)));?> NO
				</td>
				<td>
					<?= form_dropdown('rinitis_dia', $dias_ea, set_value('rinitis_dia', $list[0]->rinitis_dia), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('rinitis_mes', $meses_ea, set_value('rinitis_mes', $list[0]->rinitis_mes), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('rinitis_anio', $anio_ea, set_value('rinitis_anio', $list[0]->rinitis_anio), array('class'=>'input-small')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("rinitis", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='rinitis_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='rinitis_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Accidente vascular encefálico:</td>
				<td>
					<?= form_radio('acc_vascular',1,set_radio('acc_vascular', 1,(($list[0]->acc_vascular == 1) ? true : false)));?> SI
					<?= form_radio('acc_vascular',0,set_radio('acc_vascular', 0,(($list[0]->acc_vascular == "0") ? true : false)));?> NO
				</td>
				<td>
					<?= form_dropdown('acc_vascular_dia', $dias_ea, set_value('acc_vascular_dia', $list[0]->acc_vascular_dia), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('acc_vascular_mes', $meses_ea, set_value('acc_vascular_mes', $list[0]->acc_vascular_mes), array('class'=>'input-small')); ?></td> 
					<td><?= form_dropdown('acc_vascular_anio', $anio_ea, set_value('acc_vascular_anio', $list[0]->acc_vascular_anio), array('class'=>'input-small')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("acc_vascular", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='acc_vascular_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='acc_vascular_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Asma:</td>
				<td>
					<?= form_radio('asma',1,set_radio('asma', 1,(($list[0]->asma == 1) ? true : false)));?> SI
					<?= form_radio('asma',0,set_radio('asma', 0,(($list[0]->asma == "0") ? true : false)));?> NO
				</td>
				<td>
					<?= form_dropdown('asma_dia', $dias_ea, set_value('asma_dia', $list[0]->asma_dia), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('asma_mes', $meses_ea, set_value('asma_mes', $list[0]->asma_mes), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('asma_anio', $anio_ea, set_value('asma_anio', $list[0]->asma_anio), array('class'=>'input-small')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("asma", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='asma_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='asma_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Gastritis/Reflujo GE:</td>
				<td>
					<?= form_radio('gastritis',1,set_radio('gastritis', 1,(($list[0]->gastritis == 1) ? true : false)));?> SI
					<?= form_radio('gastritis',0,set_radio('gastritis', 0,(($list[0]->gastritis == "0") ? true : false)));?> NO
				</td>
				<td>
					<?= form_dropdown('gastritis_dia', $dias_ea, set_value('gastritis_dia', $list[0]->gastritis_dia), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('gastritis_mes', $meses_ea, set_value('gastritis_mes', $list[0]->gastritis_mes), array('class'=>'input-small')); ?></td> 
					<td><?= form_dropdown('gastritis_anio', $anio_ea, set_value('gastritis_anio', $list[0]->gastritis_anio), array('class'=>'input-small')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("gastritis", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='gastritis_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='gastritis_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Cefaleas matinales:</td>
				<td>
					<?= form_radio('cefaleas',1,set_radio('cefaleas', 1,(($list[0]->cefaleas == 1) ? true : false)));?> SI
					<?= form_radio('cefaleas',0,set_radio('cefaleas', 0,(($list[0]->cefaleas == "0") ? true : false)));?> NO
				</td>
				<td>
					<?= form_dropdown('cefaleas_dia', $dias_ea, set_value('cefaleas_dia', $list[0]->cefaleas_dia), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('cefaleas_mes', $meses_ea, set_value('cefaleas_mes', $list[0]->cefaleas_mes), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('cefaleas_anio', $anio_ea, set_value('cefaleas_anio', $list[0]->cefaleas_anio), array('class'=>'input-small')); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("cefaleas", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='cefaleas_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='cefaleas_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
	<table class='table table-bordered table-hover table-striped'>
		<thead>
			<tr>
				<td style='background-color:#ccc;'></td>
				<td style='background-color:#ccc;'>
				<td style='font-weight:bold;background-color:#ccc;'>Describir</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Alergias:</td>
				<td>
					<?= form_radio('alergia',1,set_radio('alergia', 1,(($list[0]->alergia == 1) ? true : false)));?> SI
					<?= form_radio('alergia',0,set_radio('alergia', 0,(($list[0]->alergia == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'alergia_desc', 'id'=>'alergia_desc', 'value'=>set_value('alergia_desc', $list[0]->alergia_desc), 'rows'=>'5')); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("alergia", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='alergia_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='alergia_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?></td>
			</tr>
			<tr>
				<td>Tabaquismo (cantidad):</td>
				<td>
					<?= form_radio('tabaquismo',1,set_radio('tabaquismo', 1,(($list[0]->tabaquismo == 1) ? true : false)));?> SI
					<?= form_radio('tabaquismo',0,set_radio('tabaquismo', 0,(($list[0]->tabaquismo == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'tabaquismo_desc', 'id'=>'tabaquismo_desc', 'value'=>set_value('tabaquismo_desc', $list[0]->tabaquismo_desc), 'rows'=>'5')); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("tabaquismo", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='tabaquismo_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='tabaquismo_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?></td>
			</tr>
			<tr>
				<td>Ingesta de Alcohol:</td>
				<td>
					<?= form_radio('ingesta_alcohol',1,set_radio('ingesta_alcohol', 1,(($list[0]->ingesta_alcohol == 1) ? true : false)));?> SI
					<?= form_radio('ingesta_alcohol',0,set_radio('ingesta_alcohol', 0,(($list[0]->ingesta_alcohol == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'ingesta_alcohol_desc', 'id'=>'ingesta_alcohol_desc', 'value'=>set_value('ingesta_alcohol_desc', $list[0]->ingesta_alcohol_desc), 'rows'=>'5')); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("ingesta_alcohol", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='ingesta_alcohol_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='ingesta_alcohol_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Consumo de Drogas de abuso:</td>
				<td>
					<?= form_radio('drogas',1,set_radio('drogas', 1,(($list[0]->drogas == 1) ? true : false)));?> SI
					<?= form_radio('drogas',0,set_radio('drogas', 0,(($list[0]->drogas == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'drogas_desc', 'id'=>'drogas_desc', 'value'=>set_value('drogas_desc', $list[0]->drogas_desc), 'rows'=>'5')); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("drogas", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='drogas_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='drogas_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>¿Ha tenido alguna intervención quirúrgica y/o cirugía?</td>
				<td>
					<?= form_radio('cirugia',1,set_radio('cirugia', 1,(($list[0]->cirugia == 1) ? true : false)));?> SI
					<?= form_radio('cirugia',0,set_radio('cirugia', 0,(($list[0]->cirugia == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'cirugia_desc', 'id'=>'cirugia_desc', 'value'=>set_value('cirugia_desc', $list[0]->cirugia_desc), 'rows'=>'5')); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("cirugia", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='cirugia_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='cirugia_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>¿Ha donado sangre o ha participado en algún estudio clínico farmacológico en los últimos tres meses?</td>
				<td>
					<?= form_radio('donado_sangre',1,set_radio('donado_sangre', 1,(($list[0]->donado_sangre == 1) ? true : false)));?> SI
					<?= form_radio('donado_sangre',0,set_radio('donado_sangre', 0,(($list[0]->donado_sangre == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'donado_sangre_desc', 'id'=>'donado_sangre_desc', 'value'=>set_value('donado_sangre_desc', $list[0]->donado_sangre_desc), 'rows'=>'5')); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("donado_sangre", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='donado_sangre_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='donado_sangre_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>¿Está recibiendo o ha recibido en el último mes, algún tratamiento farmacológico?</td>
				<td>
					<?= form_radio('tratamiento_farma',1,set_radio('tratamiento_farma', 1,(($list[0]->tratamiento_farma == 1) ? true : false)));?> SI
					<?= form_radio('tratamiento_farma',0,set_radio('tratamiento_farma', 0,(($list[0]->tratamiento_farma == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'tratamiento_farma_desc', 'id'=>'tratamiento_farma_desc', 'value'=>set_value('tratamiento_farma_desc', $list[0]->tratamiento_farma_desc), 'rows'=>'5')); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("tratamiento_farma", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='tratamiento_farma_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='tratamiento_farma_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>¿Está recibiendo o ha recibido en el último mes, algún suplemento dietético o vitamínico?</td>
				<td>
					<?= form_radio('suplemento_dietetico',1,set_radio('suplemento_dietetico', 1,(($list[0]->suplemento_dietetico == 1) ? true : false)));?> SI
					<?= form_radio('suplemento_dietetico',0,set_radio('suplemento_dietetico', 0,(($list[0]->suplemento_dietetico == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'suplemento_dietetico_desc', 'id'=>'suplemento_dietetico_desc', 'value'=>set_value('suplemento_dietetico_desc', $list[0]->suplemento_dietetico_desc), 'rows'=>'5')); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("suplemento_dietetico", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='suplemento_dietetico_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='suplemento_dietetico_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>2.- ANTECEDENTES FAMILIARES DE ALZHEIMER (padre, madre, hermanos): </td>
				<td>
					<?= form_radio('alzheimer',1,set_radio('alzheimer', 1,(($list[0]->alzheimer == 1) ? true : false)));?> SI
					<?= form_radio('alzheimer',0,set_radio('alzheimer', 0,(($list[0]->alzheimer == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'alzheimer_desc', 'id'=>'alzheimer_desc', 'value'=>set_value('alzheimer_desc', $list[0]->alzheimer_desc), 'rows'=>'5')); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("alzheimer", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='alzheimer_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='alzheimer_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>3.- FECHA EN QUE PRESENTÓ PRIMEROS SÍNTOMAS ASOCIADOS A LA EA</td>				
				<td>Fecha: </td>
				<td>
					<?= form_dropdown('dia_ea', $dias_ea, set_value('dia_ea', $list[0]->dia_ea), array('class'=>'input-small')); ?> / 
					<?= form_dropdown('mes_ea', $meses_ea, set_value('mes_ea', $list[0]->mes_ea), array('class'=>'input-small')); ?> / 
					<?= form_dropdown('anio_ea', $anio_ea, set_value('anio_ea', $list[0]->anio_ea), array('class'=>'input-small')); ?>	
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("fecha_ea", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_ea_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='fecha_ea_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>4.- ANTECEDENTES MORBIDOS FAMILIARES (padre, madre, hermanos):</td>
				<td>
					<?= form_radio('morbido',1,set_radio('morbido', 1,(($list[0]->morbido == 1) ? true : false)));?> SI
					<?= form_radio('morbido',0,set_radio('morbido', 0,(($list[0]->morbido == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'morbido_desc', 'id'=>'morbido_desc', 'value'=>set_value('morbido_desc', $list[0]->morbido_desc), 'rows'=>'5')); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("morbido", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='morbido_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='morbido_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
				<td>Observaciones (Opcional)</td>
				<td colspan='2'><?= form_textarea(array('type'=>'textarea', 'name'=>'observaciones', 'id'=>'observaciones', 'value'=>set_value('observaciones', $list[0]->observaciones), 'rows'=>'10', 'cols'=>'60', 'style'=>'width:98%;')); ?>
				<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("observaciones", $campos_query))  
							{
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='observaciones_query' tipo='new' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";		
								}
								
							}
							else 
							{	
								if(strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){					
									echo "<img src='". base_url('img/question.png') ."' id='observaciones_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?></td>
			</tr>
			<tr>
				<td colspan='3' style='text-align:center;'>
					<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'historial_medico_update') AND $list[0]->status != 'Form Approved and Locked'){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
					<?= anchor('subject/grid/'. $subject->id, 'Volver', array('class'=>'btn btn-default')); ?>
				</td>				
			</tr>			
		</tbody>
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
			AND strpos($_SESSION['role_options']['subject'], 'historial_medico_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/historial_medico_verify', array('class'=>'form-horizontal')); ?>    	
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

<!--Lock-->
<br /><b>Cierre:</b><br />
	<?php if(!empty($list[0]->lock_user) AND !empty($list[0]->lock_date)){ ?>
		
		Formulario cerrado por <?= $list[0]->lock_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'historial_medico_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/historial_medico_lock', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'historial_medico_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/historial_medico_signature', array('class'=>'form-horizontal')); ?>    	
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