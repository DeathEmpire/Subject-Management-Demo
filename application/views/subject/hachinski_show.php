<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });	

	$('input[type=checkbox]').click(function(){

		var total = 0;

		 $('input[type=checkbox]').each(function(){
            if (this.checked) {
                total += parseInt($(this).val());
            }
        });

		if(total >= 5){
			$("#tr_no_cumple").show();
		}
		else{
			$("#tr_no_cumple").hide();
		} 

		$("#td_total").text(total);
		$("#total").val(total);
	});
	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_hach :input").attr('readonly','readonly');
			$("#form_hach :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});			
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_hach :input").removeAttr('readonly');			
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_hach :input").attr('readonly','readonly');
		$("#form_hach :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});		
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_hach :input").removeAttr('readonly');		
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
				"form": "hachinski",
				"form_nombre" : "Escala de Hachinski",
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
<legend style='text-align:center;'>Escala de Hachinski</legend>
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
	<?php if(isset($list) AND !empty($list)){  ?>	
		<!-- legend -->
		
			<div style='display:none;'>
			    <div id='dialog_auditoria'><?= ((isset($auditoria) AND !empty($auditoria)) ? $auditoria : ''); ?></div>
			</div>
			<?php
			    if(isset($auditoria) AND !empty($auditoria)){
			        echo "<div style='text-align:right;'><a id='ver_auditoria' class='btn btn-info colorbox_inline' href='#dialog_auditoria'>Ver Auditoria</a></div>";
			    }
			?>

		
			<?= form_open('subject/hachinski_update', array('id'=>'form_hach')); ?>	
			
				<input type='hidden' name='total' id='total' value='<?php echo $list[0]->total; ?>' />
				<input type='hidden' name='subject_id' id='subject_id' value='<?php echo $subject->id; ?>' />
				<input type='hidden' name='id' value='<?php echo $list[0]->id; ?>' />
				<input type='hidden' name='last_status' id='last_status' value='<?php echo $subject->hachinski_status; ?>' />
				<table class="table table-condensed table-bordered table-striped table-hover">
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
					<tr>
						<td>Realizado:</td>
						<td>
							<?= form_radio($data,$data['value'],set_radio($data['name'], 1, (($list[0]->realizado == 1) ? true : false))); ?> Si
							<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0, (($list[0]->realizado == 0) ? true : false))); ?> NO
						</td>
					</tr>
					<tr>
						<td>Fecha: </td>
						<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', ((!empty($list[0]->fecha) AND $list[0]->fecha != '0000-00-00') ? date("d/m/Y", strtotime($list[0]->fecha)) : "") ))); ?>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("fecha", $campos_query)) 
								{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_query' tipo='new' class='query'>";
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";
									}
								}else{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
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
					<tr id='mensaje_desviacion' style='display:none;'>
						<td colspan='2' id='td_mensaje_desviacion' class='alert alert-danger'></td>
					</tr>
					<tr>
						<td>Comienzo Brusco: </td>
						<td><?= form_checkbox(array('name'=>'comienzo_brusco','id'=>'comienzo_brusco', 'checked'=>set_checkbox('comienzo_brusco','2',($list[0]->comienzo_brusco == 2) ? true : false ), 'value'=>'2')); ?>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("comienzo_brusco", $campos_query)) 
								{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='comienzo_brusco_query' tipo='new' class='query'>";
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";	
									}
								}else{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
										echo "<img src='". base_url('img/question.png') ."' id='comienzo_brusco_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
						<td>Deterioro escalonado: </td>						
						<td><?= form_checkbox(array('name'=>'deterioro_escalonado','id'=>'deterioro_escalonado', 'checked'=>set_checkbox('deterioro_escalonado','1',($list[0]->deterioro_escalonado == 1) ? true : false ), 'value'=>'1')); ?>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("deterioro_escalonado", $campos_query)) 
								{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='deterioro_escalonado_query' tipo='new' class='query'>";
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";	
									}
								}else{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
										echo "<img src='". base_url('img/question.png') ."' id='deterioro_escalonado_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
						<td>Curso fluctuante: </td>						
						<td><?= form_checkbox(array('name'=>'curso_fluctante','id'=>'curso_fluctante', 'checked'=>set_checkbox('curso_fluctante','2',($list[0]->curso_fluctante == 2) ? true : false ), 'value'=>'2')); ?>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("curso_fluctante", $campos_query)) 
								{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='curso_fluctante_query' tipo='new' class='query'>";
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."' id='curso_fluctante_query' tipo='new' class='query'>";	
									}
								}else{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
										echo "<img src='". base_url('img/question.png') ."' id='curso_fluctante_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
						<td>Desorientación nocturna: </td>
						<td><?= form_checkbox(array('name'=>'desorientacion_noctura','id'=>'desorientacion_noctura', 'checked'=>set_checkbox('desorientacion_noctura','1',($list[0]->desorientacion_noctura == 1) ? true : false ), 'value'=>'1')); ?>
						<?php
						if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("desorientacion_noctura", $campos_query)) 
								{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='desorientacion_noctura_query' tipo='new' class='query'>";
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";	
									}
								}else{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
										echo "<img src='". base_url('img/question.png') ."' id='desorientacion_noctura_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
						<td>Preservación relativa de la personalidad: </td>
						<td><?= form_checkbox(array('name'=>'preservacion_relativa','id'=>'preservacion_relativa', 'checked'=>set_checkbox('preservacion_relativa','1',($list[0]->preservacion_relativa == 1) ? true : false ), 'value'=>'1')); ?>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("preservacion_relativa", $campos_query)) 
								{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='preservacion_relativa_query' tipo='new' class='query'>";
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";	
									}
								}else{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
										echo "<img src='". base_url('img/question.png') ."' id='preservacion_relativa_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
						<td>Depresión: </td>
						<td><?= form_checkbox(array('name'=>'depresion','id'=>'depresion', 'checked'=>set_checkbox('depresion','1',($list[0]->depresion == 1) ? true : false ), 'value'=>'1')); ?>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("depresion", $campos_query)) 
								{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='depresion_query' tipo='new' class='query'>";
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";	
									}
								}else{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
										echo "<img src='". base_url('img/question.png') ."' id='depresion_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
						<td>Somatización: </td>
						<td><?= form_checkbox(array('name'=>'somatizacion','id'=>'somatizacion', 'checked'=>set_checkbox('somatizacion','1',($list[0]->somatizacion == 1) ? true : false ), 'value'=>'1')); ?>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("somatizacion", $campos_query)) 
								{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='somatizacion_query' tipo='new' class='query'>";
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";	
									}
								}else{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
										echo "<img src='". base_url('img/question.png') ."' id='somatizacion_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
						<td>Labilidad emocional: </td>
						<td><?= form_checkbox(array('name'=>'labilidad_emocional','id'=>'labilidad_emocional', 'checked'=>set_checkbox('labilidad_emocional','1',($list[0]->labilidad_emocional == 1) ? true : false ), 'value'=>'1')); ?>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("labilidad_emocional", $campos_query)) 
								{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='labilidad_emocional_query' tipo='new' class='query'>";
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";	
									}
								}else{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
										echo "<img src='". base_url('img/question.png') ."' id='labilidad_emocional_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
						<td>Historia de HTA: </td>
						<td><?= form_checkbox(array('name'=>'hta','id'=>'hta', 'checked'=>set_checkbox('hta','1',($list[0]->hta == 1) ? true : false ), 'value'=>'1')); ?>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("hta", $campos_query)) 
								{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='hta_query' tipo='new' class='query'>";
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";	
									}
								}else{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
										echo "<img src='". base_url('img/question.png') ."' id='hta_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
						<td>Historia de ictus previos: </td>
						<td><?= form_checkbox(array('name'=>'ictus_previos','id'=>'ictus_previos', 'checked'=>set_checkbox('ictus_previos','2',($list[0]->ictus_previos == 2) ? true : false ), 'value'=>'2')); ?>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("ictus_previos", $campos_query)) 
								{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='ictus_previos_query' tipo='new' class='query'>";
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";	
									}
								}else{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
										echo "<img src='". base_url('img/question.png') ."' id='ictus_previos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
						<td>Evidencia de arteriosclerosis asociada: </td>
						<td><?= form_checkbox(array('name'=>'evidencia_arteriosclerosis','id'=>'evidencia_arteriosclerosis', 'checked'=>set_checkbox('evidencia_arteriosclerosis','1',($list[0]->evidencia_arteriosclerosis == 1) ? true : false ), 'value'=>'1')); ?>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("evidencia_arteriosclerosis", $campos_query)) 
								{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='evidencia_arteriosclerosis_query' tipo='new' class='query'>";
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";	
									}
								}else{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
										echo "<img src='". base_url('img/question.png') ."' id='evidencia_arteriosclerosis_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
						<td>Síntomas neurológicos focales: </td>
						<td><?= form_checkbox(array('name'=>'sintomas_neurologicos','id'=>'sintomas_neurologicos', 'checked'=>set_checkbox('sintomas_neurologicos','2',($list[0]->sintomas_neurologicos == 2) ? true : false ), 'value'=>'2')); ?>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("sintomas_neurologicos", $campos_query)) 
								{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='sintomas_neurologicos_query' tipo='new' class='query'>";
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";	
									}
								}else{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
										echo "<img src='". base_url('img/question.png') ."' id='sintomas_neurologicos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
						<td>Signos neurológicos focales: </td>
						<td><?= form_checkbox(array('name'=>'signos_neurologicos','id'=>'signos_neurologicos', 'checked'=>set_checkbox('signos_neurologicos','2',($list[0]->signos_neurologicos == 2) ? true : false ), 'value'=>'2')); ?>
						<?php
							if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
							{
								
								if(!in_array("signos_neurologicos", $campos_query)) 
								{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_verify')){
										echo "<img src='". base_url('img/icon-check.png') ."' id='signos_neurologicos_query' tipo='new' class='query'>";
									}
									else{
										echo "<img src='". base_url('img/icon-check.png') ."'>";	
									}	
								}else{
									if(strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
										echo "<img src='". base_url('img/question.png') ."' id='signos_neurologicos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
						<td><b>Puntaje Total: </b></td>
						<td style='text-align:rigth;font-weight:bold;' id='td_total'><?php echo $list[0]->total; ?></td>
					</tr>
					<tr>
						<td colspan='2' style='text-align:right;font-weight:bold;font-style:italic;'>Puntaje de isquemia de Hachinski modificada debe ser ≤ 4, según criterios de inclusión.</td>
					</tr>
					<tr id="tr_no_cumple" style='display:none;'>
						<td colspan='2' class='alert alert-warning'><b>Revisar, no cumple con criterios de inclusión. Si no tiene autorización escrita del patrocinador, este sujeto debe ser excluido.</b></td>
					</tr>
					<tr>
						<td colspan='2' style='text-align:center;'>
							<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'hachinski_update') AND $list[0]->status != 'Form Approved and Locked'){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
							<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
						</td>
					</tr>
				</table>
			<?= form_close(); ?>

			<b>Creado por:</b> <?= $list[0]->created_by;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->created_at));?><br />&nbsp;</br>
			<!-- Verify -->
			<b>Aprobacion del Monitor:</b><br />
				<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
					
					Este formulario fue aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->verify_date));?>
				
				<?php
				}
				else{
				
					if(isset($_SESSION['role_options']['subject']) 
						AND strpos($_SESSION['role_options']['subject'], 'hachinski_verify') 
						AND $list[0]->status == 'Record Complete'
					){
				?>
					<?= form_open('subject/hachinski_verify', array('class'=>'form-horizontal')); ?>    	
					
					<?= form_hidden('id', $list[0]->id); ?>
					<?= form_hidden('subject_id', $subject->id); ?>
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
						AND strpos($_SESSION['role_options']['subject'], 'hachinski_lock')
						AND $list[0]->status == 'Form Approved by Monitor'){
				?>
					<?= form_open('subject/hachinski_lock', array('class'=>'form-horizontal')); ?>
					<?= form_hidden('id', $list[0]->id); ?>    	
					<?= form_hidden('subject_id', $subject->id); ?>
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
						AND strpos($_SESSION['role_options']['subject'], 'hachinski_signature')
						AND $list[0]->status == 'Form Approved and Locked'
					){
				?>
					<?= form_open('subject/hachinski_signature', array('class'=>'form-horizontal')); ?>    	
					<?= form_hidden('id', $list[0]->id); ?>    	
					<?= form_hidden('subject_id', $subject->id); ?>
					<?= form_hidden('current_status', $list[0]->status); ?>
						
					<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

					<?= form_close(); ?>

			<?php }else{
					echo "Pendiente de Firma";
					}
				}
			?>
			<br />
		<?php } ?>
	

