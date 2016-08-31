<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha_alt").datepicker({ dateFormat: 'dd/mm/yy' });	

	$("input[name=realizado_alt]").change(function(){
		if($(this).val() == 0){
			$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").attr('readonly','readonly');
			$("#form_restas :input").each(function(){
				if($(this).attr('name') != 'realizado_alt' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
			$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").attr('disabled','disabled');

		}else{
			$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").removeAttr('readonly');
			$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").removeAttr('disabled');
		}
	});
	if($("input[name=realizado_alt]:checked").val() == 0){
		$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").attr('readonly','readonly');
		$("#form_restas :input").each(function(){
				if($(this).attr('name') != 'realizado_alt' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
		$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").attr('disabled','disabled');
	}else{
		$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha").removeAttr('readonly');
		$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").removeAttr('disabled');
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
				"form": "restas",
				"form_nombre" : "Restas Seriadas",
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
?><div id='query_para_campos' style='display:none;'></div>

<legend style='text-align:center;'>Restas Seriadas <?= $protocolo;?></legend>
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
<div style='display:none;'>
    <div id='dialog_auditoria'><?= ((isset($auditoria) AND !empty($auditoria)) ? $auditoria : ''); ?></div>
</div>
<?php
    if(isset($auditoria) AND !empty($auditoria)){
        echo "<div style='text-align:right;'><a id='ver_auditoria' class='btn btn-info colorbox_inline' href='#dialog_auditoria'>Ver Auditoria</a></div>";
    }
?>
<?= form_open('subject/restas_update', array('class'=>'form-horizontal', 'id'=>'form_restas')); ?>
	
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
	  	$data3 = array(
			    'name'        => 'realizado_alt',			    
			    'value'       => 1,		    
			    #'checked'	  => set_radio('gender', 'male', TRUE),
		    );
	  	$data4 = array(
		    'name'        => 'realizado_alt',
		    'value'       => 0,
		    #'checked'	  => set_radio('gender', 'female', TRUE),		    
		    );

		
		$resta_1_alt = array(
			    'name'        => 'resta_alt_1',
			    'id'          => 'resta_alt_1',
			    'value'       => '1',
			    'checked'	  => (($list[0]->resta_alt_1 == 1) ? true : false)
			    
		    );
		$resta_2_alt = array(
			    'name'        => 'resta_alt_2',
			    'id'          => 'resta_alt_2',
			    'value'       => '1',
			    'checked'	  => (($list[0]->resta_alt_2 == 1) ? true : false)
			    
		    );
		$resta_3_alt = array(
			    'name'        => 'resta_alt_3',
			    'id'          => 'resta_alt_3',
			    'value'       => '1',
			    'checked'	  => (($list[0]->resta_alt_3 == 1) ? true : false)
			    
		    );
		$resta_4_alt = array(
			    'name'        => 'resta_alt_4',
			    'id'          => 'resta_alt_4',
			    'value'       => '1',
			    'checked'	  => (($list[0]->resta_alt_4 == 1) ? true : false)
			    
		    );
		$resta_5_alt = array(
			    'name'        => 'resta_alt_5',
			    'id'          => 'resta_alt_5',
			    'value'       => '1',
			    'checked'	  => (($list[0]->resta_alt_5 == 1) ? true : false)
			    
		    );
	?>
	
	<table class="table table-bordered table-striped table-hover">	
		<tr>
			<td colspan='2' style='background-color:#ccc;'>Resta seriada</td>
		</tr>
		<tr>		
			<td>Realizado: </td>
			<td>
				<?= form_radio($data3,$data3['value'],set_radio($data3['name'], 1,(($list[0]->realizado_alt == 1) ? true : false))); ?> Si
				<?= form_radio($data4,$data4['value'],set_radio($data4['name'], 0,(($list[0]->realizado_alt == 0) ? true : false))); ?> NO
			</td>
		</tr>
		<tr>
			<td>Fecha: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha_alt', 'id'=>'fecha_alt', 'value'=>set_value('fecha_alt', (($list[0]->fecha_alt != '0000-00-00') ?  date('d/m/Y', strtotime($list[0]->fecha_alt)) : '' )  ))); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("fecha_alt", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'restas_verify')){
							echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_alt_query' tipo='new' class='query'>";
							}else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'restas_update')){
							echo "<img src='". base_url('img/question.png') ."' id='fecha_alt_query' tipo='old' style='width:20px;height:20px;' class='query'>";
							}else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";
							}	
						}						
						
					}
				?>
			</td>
		</tr>
		<tr>
			<td style='background-color:#ccc;'>Reste 3 a partir del 20</td>
			<td style='background-color:#ccc;'>Indicar respuestas correctas</td>
		</tr>
		<tr>
			<td>17</td>
			<td><?= form_checkbox($resta_1_alt); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("resta_alt_1", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'restas_verify')){
							echo "<img src='". base_url('img/icon-check.png') ."' id='resta_alt_1_query' tipo='new' class='query'>";
							}else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'restas_update')){
							echo "<img src='". base_url('img/question.png') ."' id='resta_alt_1_query' tipo='old' style='width:20px;height:20px;' class='query'>";
							}else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";
							}	
						}						
						
					}
				?>
			</td>
		</tr>
		<tr>
			<td>14</td>			
			<td><?= form_checkbox($resta_2_alt); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("resta_alt_2", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'restas_verify')){
							echo "<img src='". base_url('img/icon-check.png') ."' id='resta_alt_2_query' tipo='new' class='query'>";
							}else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'restas_update')){
							echo "<img src='". base_url('img/question.png') ."' id='resta_alt_2_query' tipo='old' style='width:20px;height:20px;' class='query'>";
							}else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";
							}	
						}						
						
					}
				?>
			</td>
		</tr>
		<tr>
			<td>11</td>
			<td><?= form_checkbox($resta_3_alt); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("resta_alt_3", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'restas_verify')){
							echo "<img src='". base_url('img/icon-check.png') ."' id='resta_alt_3_query' tipo='new' class='query'>";
							}else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'restas_update')){
							echo "<img src='". base_url('img/question.png') ."' id='resta_alt_3_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";
							}
						}						
						
					}
				?>
			</td>
		</tr>
		<tr>
			<td>8</td>
			<td><?= form_checkbox($resta_4_alt); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("resta_alt_4", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'restas_verify')){
							echo "<img src='". base_url('img/icon-check.png') ."' id='resta_alt_4_query' tipo='new' class='query'>";
							}else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'restas_update')){
							echo "<img src='". base_url('img/question.png') ."' id='resta_alt_4_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";
							}
						}						
						
					}
				?>
			</td>
		</tr>
		<tr>
			<td>5</td>
			<td><?= form_checkbox($resta_5_alt); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("resta_alt_5", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'restas_verify')){
							echo "<img src='". base_url('img/icon-check.png') ."' id='resta_alt_5_query' tipo='new' class='query'>";
							}else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'restas_update')){
								echo "<img src='". base_url('img/question.png') ."' id='resta_alt_5_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}else{
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
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'restas_update')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
	        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
			</td>
		</tr>
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
			AND strpos($_SESSION['role_options']['subject'], 'restas_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/restas_verify', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'restas_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/restas_lock', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'restas_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/restas_signature', array('class'=>'form-horizontal')); ?>    	
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
