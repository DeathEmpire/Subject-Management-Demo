<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_ecg :input").attr('readonly','readonly');
			$("#form_ecg :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});			
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_ecg :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled', 'disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_ecg :input").attr('readonly','readonly');
		$("#form_ecg :input").each(function(){
			if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
				$(this).val('');
			}
		});
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_ecg :input").removeAttr('readonly');
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
				"etapa": 0,
				"subject_id": $("input[name=subject_id]").val(),
				"form": "ecg",
				"form_nombre" : "Electrocardiograma de reposo (ECG)",
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
<div id='query_para_campos' style='display:none;'></div>
<legend style='text-align:center;'>Electrocardiograma de reposo (ECG)</legend>
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
<?= form_open('subject/ecg_update', array('class'=>'form-horizontal','id'=>'form_ecg')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
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
		<?= form_radio($data,$data['value'],set_radio($data['name'], 1, (($list[0]->realizado == 1) ? true : false) )); ?> Si
		<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0, (($list[0]->realizado == 0) ? true : false) ) ) ; ?> NO
		<br />
		Fecha: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', ((!empty($list[0]->fecha) AND $list[0]->fecha !='0000-00-00') ? date("d/m/Y", strtotime($list[0]->fecha)) : "") ))); ?>
		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("fecha", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_query' tipo='new' class='query'>";
							}else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
								echo "<img src='". base_url('img/question.png') ."' id='fecha_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>


		<table class='table table-striped table-hover table-bordered table-condensed'>
			<thead>
				<tr>
					<th></th>
					<th></th>
					<th></th>
					<th>Normal - Anormal</th>				
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Ritmo Sinusal</td>
					<td><?= form_radio('ritmo_sinusal', 1, set_radio('ritmo_sinusal', 1, (($list[0]->ritmo_sinusal == 1) ? true : false))); ?> Si</td>
					<td><?= form_radio('ritmo_sinusal', 0, set_radio('ritmo_sinusal', 0, (($list[0]->ritmo_sinusal == 0) ? true : false))); ?> No
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("ritmo_sinusal", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='ritmo_sinusal_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";	
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='ritmo_sinusal_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
			</td>
					<td>
						<?= form_radio('ritmo_sinusal_normal_anormal', 1, set_radio('ritmo_sinusal_normal_anormal', 1, (($list[0]->ritmo_sinusal_normal_anormal == 1) ? true : false))); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('ritmo_sinusal_normal_anormal', 0, set_radio('ritmo_sinusal_normal_anormal', 0, (($list[0]->ritmo_sinusal_normal_anormal == 0) ? true : false))); ?>
						<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("ritmo_sinusal_normal_anormal", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='ritmo_sinusal_normal_anormal_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";	
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='ritmo_sinusal_normal_anormal_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";		
								}
							}						
							
						}
					?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>Resultado</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>FC</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'fc', 'id'=>'fc', 'value'=>set_value('fc', $list[0]->fc))); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("fc", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='fc_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='fc_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";
								}
							}						
							
						}
					?>
				</td>
					<td>Lat/min</td>
					<td>
						<?= form_radio('fc_normal_anormal', 1, set_radio('fc_normal_anormal', 1, (($list[0]->fc_normal_anormal == 1) ? true : false))); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('fc_normal_anormal', 0, set_radio('fc_normal_anormal', 0, (($list[0]->fc_normal_anormal == 0) ? true : false))); ?>
						<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("fc_normal_anormal", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='fc_normal_anormal_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='fc_normal_anormal_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";
								}
							}						
							
						}
					?>
					</td>
				</tr>
				<tr>
					<td>PR</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'pr', 'id'=>'pr', 'value'=>set_value('pr', $list[0]->pr))); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("pr", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='pr_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='pr_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";
								}
							}						
							
						}
					?>
				</td>
					<td>ms</td>
					<td>
						<?= form_radio('pr_normal_anormal', 1, set_radio('pr_normal_anormal', 1, (($list[0]->pr_normal_anormal == 1) ? true : false))); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('pr_normal_anormal', 0, set_radio('pr_normal_anormal', 0, (($list[0]->pr_normal_anormal == 0) ? true : false))); ?>
						<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("pr_normal_anormal", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='pr_normal_anormal_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='pr_normal_anormal_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";
								}
							}						
							
						}
					?>
					</td>
				</tr>
				<tr>
					<td>QRS</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'qrs', 'id'=>'qrs', 'value'=>set_value('qrs', $list[0]->qrs))); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("qrs", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='qrs_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='qrs_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";
								}
							}						
							
						}
					?>
				</td>
					<td>ms</td>
					<td>
						<?= form_radio('qrs_normal_anormal', 1, set_radio('qrs_normal_anormal', 1, (($list[0]->qrs_normal_anormal == 1) ? true : false))); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('qrs_normal_anormal', 0, set_radio('qrs_normal_anormal', 0, (($list[0]->qrs_normal_anormal == 0) ? true : false))); ?>
						<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("qrs_normal_anormal", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='qrs_normal_anormal_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='qrs_normal_anormal_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";
								}
							}						
							
						}
					?>
					</td>
				</tr>
				<tr>
					<td>QT</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'qt', 'id'=>'qt', 'value'=>set_value('qt', $list[0]->qt))); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("qt", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='qt_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='qt_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";
								}
							}						
							
						}
					?>
				</td>
					<td>ms</td>
					<td>
						<?= form_radio('qt_normal_anormal', 1, set_radio('qt_normal_anormal', 1, (($list[0]->qt_normal_anormal == 1) ? true : false))); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('qt_normal_anormal', 0, set_radio('qt_normal_anormal', 0, (($list[0]->qt_normal_anormal == 0) ? true : false))); ?>
						<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("qt_normal_anormal", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='qt_normal_anormal_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='qt_normal_anormal_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";
								}
							}						
							
						}
					?>
					</td>
				</tr>
				<tr>
					<td>QTc</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'qtc', 'id'=>'qtc', 'value'=>set_value('qtc', $list[0]->qtc))); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("qtc", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='qtc_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='qtc_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";
								}
							}						
							
						}
					?>
				</td>
					<td>ms</td>
					<td>
						<?= form_radio('qtc_normal_anormal', 1, set_radio('qtc_normal_anormal', 1, (($list[0]->qtc_normal_anormal == 1) ? true : false))); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('qtc_normal_anormal', 0, set_radio('qtc_normal_anormal', 0, (($list[0]->qtc_normal_anormal == 0) ? true : false))); ?>
						<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("qtc_normal_anormal", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='qtc_normal_anormal_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='qtc_normal_anormal_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";
								}
							}						
							
						}
					?>
					</td>
				</tr>
				<tr>
					<td>Eje QRS</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'qrs2', 'id'=>'qrs2', 'value'=>set_value('qrs2', $list[0]->qrs2))); ?>
					<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("qrs2", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='qrs2_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='qrs2_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";
								}
							}						
							
						}
					?>
				</td>
					<td>°</td>
					<td>
						<?= form_radio('qrs2_normal_anormal', 1, set_radio('qrs2_normal_anormal', 1, (($list[0]->qrs2_normal_anormal == 1) ? true : false))); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('qrs2_normal_anormal', 0, set_radio('qrs2_normal_anormal', 0, (($list[0]->qrs2_normal_anormal == 0) ? true : false))); ?>
						<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("qrs2_normal_anormal", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='qrs2_normal_anormal_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='qrs2_normal_anormal_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";
								}
							}						
							
						}
					?>
					</td>
				</tr>
				<tr>
					<td colspan='3'>INTERPRETACIÓN ECG:</td>
					<td><?= form_radio('interpretacion_ecg', 1, set_radio('interpretacion_ecg', 1, (($list[0]->interpretacion_ecg == 1) ? true : false))); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('interpretacion_ecg', 0, set_radio('interpretacion_ecg', 0, (($list[0]->interpretacion_ecg == 0) ? true : false))); ?>
						<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("interpretacion_ecg", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='interpretacion_ecg_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='interpretacion_ecg_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";
								}
							}						
							
						}
					?>
					</td>
				</tr>
				<tr>
					<td>Comentarios: </td>		
					<td colspan='3'>
						<?= form_textarea(array('name'=>'comentarios', 'id'=>'comentarios', 'value'=>set_value('comentarios', $list[0]->comentarios), 'rows'=>'4','cols'=>'40')); ?>
						<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
						{
							
							if(!in_array("comentarios", $campos_query)) 
							{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_verify')){
									echo "<img src='". base_url('img/icon-check.png') ."' id='comentarios_query' tipo='new' class='query'>";
								}
								else{
									echo "<img src='". base_url('img/icon-check.png') ."'>";
								}
							}else{
								if(strpos($_SESSION['role_options']['subject'], 'ecg_update')){
									echo "<img src='". base_url('img/question.png') ."' id='comentarios_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
								}
								else{
									echo "<img src='". base_url('img/question.png') ."'style='width:20px;height:20px;'>";
								}
							}							
							
						}
					?>
					</td>
				</tr>
			
				<tr>
					<td colspan='4' style='text-align:center;'>
						<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'ecg_update')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
	            		<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
	            	</td>
				</tr>
			</tbody>
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
			AND strpos($_SESSION['role_options']['subject'], 'ecg_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/ecg_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>		
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
			AND strpos($_SESSION['role_options']['subject'], 'ecg_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/ecg_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>		
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
			AND strpos($_SESSION['role_options']['subject'], 'ecg_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/ecg_signature', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>		
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