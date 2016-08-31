<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

	$('#comprimidos_utilizados, #dias').change(function(){
		if($('#comprimidos_utilizados').val() != '' && $('#dias').val() != '')
		{
			var valor = ($('#comprimidos_utilizados').val() / 2 / $('#dias').val()) * 100;		
			$('#porcentaje_cumplimiento	').val(valor);
		}
	});

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_cumplimiento :input").attr('readonly','readonly');
			$("#form_cumplimiento :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_cumplimiento :input").removeAttr('readonly');
		}
	});
	if($("input[name=realizado]:checked").val() == 0) {
		$("#form_cumplimiento :input").attr('readonly','readonly');
		$("#form_cumplimiento :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
		$("input[name=realizado]").removeAttr('readonly');
	}else{
		$("#form_cumplimiento :input").removeAttr('readonly');
	}

	$("#comprimidos_entregados, #comprimidos_utilizados, #comprimidos_devueltos").change(function(){
		// if($("#comprimidos_entregados").val() != '' && $("#comprimidos_utilizados").val() != '' && $("#comprimidos_devueltos").val() != ''){
			var perdidos = 0;

			perdidos = parseInt($("#comprimidos_entregados").val()) - parseInt($("#comprimidos_utilizados").val()) - parseInt($("#comprimidos_devueltos").val());

			if(perdidos > 0){
				$("input[name=se_perdio_algun_comprimido][value=1]").prop("checked",true);
				$("#comprimidos_perdidos").val(perdidos);
			}else{
				$("input[name=se_perdio_algun_comprimido][value=0]").prop("checked",true);
				$("#comprimidos_perdidos").val(0);
			}
		// }
	});

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
				"form": "cumplimiento",
				"form_nombre" : "Cumplimiento",
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
<legend style='text-align:center;'>Cumplimiento <?= $protocolo;?></legend>
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
<div style='display:none;'>
	<div id='dialog_auditoria'><?= ((isset($auditoria) AND !empty($auditoria)) ? $auditoria : ''); ?></div>
</div>
<?php
	if(isset($auditoria) AND !empty($auditoria)){
		echo "<div style='text-align:right;'><a id='ver_auditoria' class='btn btn-info colorbox_inline' href='#dialog_auditoria'>Ver Auditoria</a></div>";
	}
?>
<?= form_open('subject/cumplimiento_update', array('class'=>'form-horizontal','id'=>'form_cumplimiento')); ?>
	
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
	<table class="table table-bordered table-striper table-hover">
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
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}
						else
						{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_update')){
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
			<td>Numero cápsulas entregadas: </td>
			<td><?= form_input(array('type'=>'text','name'=>'comprimidos_entregados', 'id'=>'comprimidos_entregados', 'maxlength'=>'3','value'=>set_value('comprimidos_entregados', $list[0]->comprimidos_entregados))); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("comprimidos_entregados", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='comprimidos_entregados_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";	
							}	
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_update')){
								echo "<img src='". base_url('img/question.png') ."' id='comprimidos_entregados_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>Numero cápsulas utilizadas: </td>
			<td><?= form_input(array('type'=>'text','name'=>'comprimidos_utilizados', 'id'=>'comprimidos_utilizados', 'maxlength'=>'3','value'=>set_value('comprimidos_utilizados', $list[0]->comprimidos_utilizados))); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("comprimidos_utilizados", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='comprimidos_utilizados_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_update')){
								echo "<img src='". base_url('img/question.png') ."' id='comprimidos_utilizados_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>Numero cápsulas devueltas: </td>
			<td><?= form_input(array('type'=>'text','name'=>'comprimidos_devueltos', 'id'=>'comprimidos_devueltos', 'maxlength'=>'3','value'=>set_value('comprimidos_devueltos', $list[0]->comprimidos_devueltos))); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("comprimidos_devueltos", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='comprimidos_devueltos_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_update')){
								echo "<img src='". base_url('img/question.png') ."' id='comprimidos_devueltos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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

		<?php
       		$si = array(
			    'name'        => 'se_perdio_algun_comprimido',			    
			    'value'       => 1,		    			    
			    'checked'     => set_radio('se_perdio_algun_comprimido', 1, (($list[0]->se_perdio_algun_comprimido == 1) ? true : false))
			    );
	   		$no = array(
			    'name'        => 'se_perdio_algun_comprimido',			    
			    'value'       => 0,	
			    'checked'     => set_radio('se_perdio_algun_comprimido', 0, (($list[0]->se_perdio_algun_comprimido == 0) ? true : false))
			    );
       	?>
			<td>Se perdio alguna cápsula: </td>
			<td><?= form_radio($si); ?> Si <?= form_radio($no); ?> No 
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("se_perdio_algun_comprimido", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='se_perdio_algun_comprimido_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_update')){
								echo "<img src='". base_url('img/question.png') ."' id='se_perdio_algun_comprimido_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."'' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
		</tr>
		<tr>		
			<td>Número de cápsulas perdidas: </td>
			<td><?= form_input(array('type'=>'text','name'=>'comprimidos_perdidos', 'id'=>'comprimidos_perdidos', 'maxlength'=>'3','value'=>set_value('comprimidos_perdidos', $list[0]->comprimidos_perdidos))); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("comprimidos_perdidos", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='comprimidos_perdidos_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_update')){
								echo "<img src='". base_url('img/question.png') ."' id='comprimidos_perdidos_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>Días (desde entrega anterior hasta Día de visita): </td>
			<td><?= form_input(array('type'=>'text','name'=>'dias', 'id'=>'dias', 'maxlength'=>'3','value'=>set_value('dias', $list[0]->dias))); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("dias", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='dias_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";	
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_update')){
								echo "<img src='". base_url('img/question.png') ."' id='dias_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>% cumplimiento: </td>
			<td><?= form_input(array('type'=>'text','name'=>'porcentaje_cumplimiento', 'id'=>'porcentaje_cumplimiento', 'maxlength'=>'5','value'=>set_value('porcentaje_cumplimiento', $list[0]->porcentaje_cumplimiento))); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("porcentaje_cumplimiento", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='porcentaje_cumplimiento_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";	
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'cumplimiento_update')){
								echo "<img src='". base_url('img/question.png') ."' id='porcentaje_cumplimiento_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'cumplimiento_update')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
	        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
			</td>
		</tr>
	</table>
<?= form_close(); ?>
<?php }?>
<b>Creado por:</b> <?= $list[0]->usuario_creacion;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->created_at));?><br />&nbsp;</br>

<!-- Verify -->
<b>Aprobacion del Monitor:</b><br />
	<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
		
		Formulario aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->verify_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'cumplimiento_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/cumplimiento_verify', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'cumplimiento_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/cumplimiento_lock', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'cumplimiento_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/cumplimiento_signature', array('class'=>'form-horizontal')); ?>    	
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