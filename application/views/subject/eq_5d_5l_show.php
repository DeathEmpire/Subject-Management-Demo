<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });	

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_eq :input").attr('readonly','readonly');
			$("#form_eq :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_eq :input").removeAttr('readonly');
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_eq :input").attr('readonly','readonly');
		$("#form_eq :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_eq :input").removeAttr('readonly');
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
				"form": "eq_5d_5l",
				"form_nombre" : "EQ-5D-5L",
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
<legend style='text-align:center;'>EQ-5D-3L <?= $protocolo;?></legend>
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
<?= form_open('subject/eq_5d_5l_update', array('class'=>'form-horizontal', 'id'=>'form_eq')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('etapa', $etapa); ?>
	<?= form_hidden('id', $list[0]->id); ?>
	<?= form_hidden('last_status', $list[0]->status); ?>
	<?php
		$data = array(
			    'name'        => 'realizado',			    
			    'value'       => 1,		    
			    'checked'     => set_radio('realizado', 1, (($list[0]->realizado == 1) ? true : false))
		    );
	  	$data2 = array(
		    'name'        => 'realizado',			    
		    'value'       => 0,
		    'checked'     => set_radio('realizado', 1, (($list[0]->realizado == 0) ? true : false))	    
		    );	   
	?>
	<table class="table table-bordered table-striper table-hover">
		<tr>		
			<td>Realizado: </td>
			<td>
				<?= form_radio($data,$data['value'],set_radio($data['name'], 1, true)); ?> Si
				<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
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
							if(strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_update')){					
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
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>MOVILIDAD</td>			
		</tr>
		
		<tr>
			<td>No tiene problemas para caminar</td>
			<td><?= form_radio('movilidad','No tiene problemas para caminar',set_radio('movilidad', 'No tiene problemas para caminar', (($list[0]->movilidad == 'No tiene problemas para caminar') ? true : false) )); ?></td>
		</tr>
		<tr>
			<td>Tiene algunos problemas para caminar</td>
			<td><?= form_radio('movilidad','Tiene algunos problemas para caminar',set_radio('movilidad', 'Tiene algunos problemas para caminar', (($list[0]->movilidad == 'Tiene algunos problemas para caminar') ? true : false) )); ?></td>
		</tr>
		<tr>
			<td>Debe estar en cama</td>
			<td><?= form_radio('movilidad','Debe estar en cama',set_radio('movilidad', 'Debe estar en cama', (($list[0]->movilidad == 'Debe estar en cama') ? true : false) )); ?></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("movilidad", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='movilidad_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='movilidad_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>CUIDADO PERSONAL</td>			
		</tr>
		<tr>
			<td>No tiene problemas con su cuidado personal</td>
			<td><?= form_radio('autocuidado','No tiene problemas con su cuidado personal',set_radio('autocuidado', 'No tiene problemas con su cuidado personal', (($list[0]->movilidad == 'No tiene problemas con su cuidado personal') ? true : false) )); ?></td>
		</tr>
		<tr>
			<td>Tiene algunos problemas para lavarse o vestirse solo/a</td>
			<td><?= form_radio('autocuidado','Tiene algunos problemas para lavarse o vestirse solo/a',set_radio('autocuidado', 'Tiene algunos problemas para lavarse o vestirse solo/a', (($list[0]->movilidad == 'Tiene algunos problemas para lavarse o vestirse solo/a') ? true : false) )); ?></td>
		</tr>		
		<tr>
			<td>Es incapas de lavarse o vestirse solo/a</td>
			<td><?= form_radio('autocuidado','Es incapas de lavarse o vestirse solo/a',set_radio('autocuidado', 'Es incapas de lavarse o vestirse solo/a', (($list[0]->movilidad == 'Es incapas de lavarse o vestirse solo/a') ? true : false) )); ?></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("autocuidado", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='autocuidado_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='autocuidado_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>ACTIVIDADES HABITUALES <small>(Ej: Trabajar, estudiar, hacer las tareas domésticas, actividades familiares o realizadas durante el tiempo libre)</small></td>			
		</tr>
		<tr>
			<td>No tiene problemas para realizar sus actividades habituales</td>
			<td><?= form_radio('actividades_habituales','No tiene problemas para realizar sus actividades habituales',set_radio('actividades_habituales', 'No tiene problemas para realizar sus actividades habituales', (($list[0]->movilidad == 'No tiene problemas para realizar sus actividades habituales') ? true : false) )); ?></td>
		</tr>
		<tr>
			<td>Tiene algunos problemas para realizar sus actividades habituales</td>
			<td><?= form_radio('actividades_habituales','Tiene algunos problemas para realizar sus actividades habituales',set_radio('actividades_habituales', 'Tiene algunos problemas para realizar sus actividades habituales', (($list[0]->movilidad == 'Tiene algunos problemas para realizar sus actividades habituales') ? true : false) )); ?></td>
		</tr>		
		<tr>
			<td>Es incapaz de realizar sus actividades habituales</td>
			<td><?= form_radio('actividades_habituales','Es incapaz de realizar sus actividades habituales',set_radio('actividades_habituales', 'Es incapaz de realizar sus actividades habituales', (($list[0]->movilidad == 'Es incapaz de realizar sus actividades habituales') ? true : false) )); ?></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("actividades_habituales", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='actividades_habituales_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='actividades_habituales_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>DOLOR MALESTAR</td>			
		</tr>
		<tr>
			<td>No tiene dolor ni malestar</td>
			<td><?= form_radio('dolor_malestar','No tiene dolor ni malestar',set_radio('dolor_malestar', 'No tiene dolor ni malestar', (($list[0]->movilidad == 'No tiene dolor ni malestar') ? true : false) )); ?></td>
		</tr>
		<tr>
			<td>Tiene un dolor o malestar moderado</td>
			<td><?= form_radio('dolor_malestar','Tiene un dolor o malestar moderado',set_radio('dolor_malestar', 'Tiene un dolor o malestar moderado', (($list[0]->movilidad == 'Tiene un dolor o malestar moderado') ? true : false) )); ?></td>
		</tr>				
		<tr>
			<td>Tiene mucho dolor o malestar</td>
			<td><?= form_radio('dolor_malestar','Tiene mucho dolor o malestar',set_radio('dolor_malestar', 'Tiene mucho dolor o malestar', (($list[0]->movilidad == 'Tiene mucho dolor o malestar') ? true : false) )); ?></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("dolor_malestar", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='dolor_malestar_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='dolor_malestar_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td style='font-weight:bold;background-color:#ddd;' colspan='2'>ANGUSTIA DEPRESION</td>			
		</tr>
		<tr>
			<td>No está angustiado/a o deprimido/a</td>
			<td><?= form_radio('angustia_depresion','No está angustiado/a o deprimido/a',set_radio('angustia_depresion', 'No está angustiado/a o deprimido/a', (($list[0]->movilidad == 'No está angustiado/a o deprimido/a') ? true : false) )); ?></td>
		</tr>		
		<tr>
			<td>Está moderadamente angustiado/a o deprimido/a</td>
			<td><?= form_radio('angustia_depresion','Está moderadamente angustiado/a o deprimido/a',set_radio('angustia_depresion', 'Está moderadamente angustiado/a o deprimido/a', (($list[0]->movilidad == 'Está moderadamente angustiado/a o deprimido/a') ? true : false) )); ?></td>
		</tr>		
		<tr>
			<td>Está muy angustiado/a o deprimido/a</td>
			<td><?= form_radio('angustia_depresion','Está muy angustiado/a o deprimido/a',set_radio('angustia_depresion', 'Está muy angustiado/a o deprimido/a', (($list[0]->movilidad == 'Está muy angustiado/a o deprimido/a') ? true : false) )); ?></td>
		</tr>				
		<tr>
			<td style='font-weight:bold;background-color:#ddd;'>SU SALUD HOY = </td>
			<td style='font-weight:bold;background-color:#ddd;'><?= form_input(array('type'=>'number', 'name'=>'salud_hoy', 'id'=>'salud_hoy', 'value'=>set_value('salud_hoy'))); ?></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("angustia_depresion", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='angustia_depresion_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='angustia_depresion_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td style='font-weight:bold;background-color:#ddd;'>SU SALUD HOY = </td>
			<td style='font-weight:bold;background-color:#ddd;'><?= form_input(array('type'=>'number', 'name'=>'salud_hoy', 'id'=>'salud_hoy', 'value'=>set_value('salud_hoy', $list[0]->salud_hoy))); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("salud_hoy", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='salud_hoy_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='salud_hoy_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_update') AND $list[0]->status != 'Form Approved and Locked'){
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
			AND strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/eq_5d_5l_verify', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/eq_5d_5l_lock', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'eq_5d_5l_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/eq_5d_5l_signature', array('class'=>'form-horizontal')); ?>    	
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