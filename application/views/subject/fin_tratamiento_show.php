<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha_visita, #fecha_ultima_dosis").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name=termino_el_estudio]").click(function(){
		if($(this).val() == 0){
			$("#tr_no").show();
		}
		else{
			$("#tr_no").hide();
		}
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
				"etapa": 0,
				"subject_id": $("input[name=subject_id]").val(),
				"form": "fin_tratamiento",
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
<legend style='text-align:center;'>Fin Tratamiento</legend>
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
<?= form_open('subject/fin_tratamiento_update', array('class'=>'form-horizontal','id'=>'form_fin_tratamiento')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>		
	<?= form_hidden('id', $list[0]->id); ?>		
	 
	<?php
			$no_aplica = array(
			    'name'        => 'no_aplica',
			    'id'          => 'no_aplica',
			    'value'       => '1',
			    'checked'     => set_checkbox('no_aplica','1',(($list[0]->no_aplica == 1) ? true : false))			    
		    );
		?>
	<table class="table table-bordered table-striper table-hover">
		<tr>			
			<td>No aplica, terminación temprana: </td><td><?= form_checkbox($no_aplica);?></td>
		</tr>
		<tr>			
			<td>Fecha Visita:</td>
			<td> <?= form_input(array('type'=>'text','name'=>'fecha_visita', 'id'=>'fecha_visita', 'value'=>set_value('fecha_visita', ((!empty($list[0]->fecha_visita) AND $list[0]->fecha_visita != '0000-00-00') ? date("d/m/Y",strtotime($list[0]->fecha_visita)) : "")))); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("fecha_visita", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_visita_query' tipo='new' class='query'>";
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_update')){
								echo "<img src='". base_url('img/question.png') ."' id='fecha_visita_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>Fecha ultima dosis: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha_ultima_dosis', 'id'=>'fecha_ultima_dosis', 'value'=>set_value('fecha_ultima_dosis', ((!empty($list[0]->fecha_ultima_dosis) AND $list[0]->fecha_ultima_dosis != '0000-00-00') ? date("d/m/Y",strtotime($list[0]->fecha_ultima_dosis)) : "")))); ?>
			<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("fecha_ultima_dosis", $campos_query)) 
						{	
							if(strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='fecha_ultima_dosis_query' tipo='new' class='query'>";
							}else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_update')){
								echo "<img src='". base_url('img/question.png') ."' id='fecha_ultima_dosis_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			    'name'        => 'termino_el_estudio',			    
			    'value'       => 1,		    			    
			    'checked'     => set_radio('termino_el_estudio', 1,(($list[0]->termino_el_estudio == 1) ? true : false))
			    );
	   		$no = array(
			    'name'        => 'termino_el_estudio',			    
			    'value'       => 0,	
			    'checked'     => set_radio('termino_el_estudio', 0,(($list[0]->termino_el_estudio == 0) ? true : false))
			    );
       	?>
			<td>¿Sujeto terminó el estudio? </td><td><?= form_radio($si); ?> Si <?= form_radio($no); ?> No 
		<?php
					if($list[0]->status == 'Record Complete' OR $list[0]->status == 'Query' )
					{
						
						if(!in_array("termino_el_estudio", $campos_query)) 
						{
							if(strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='termino_el_estudio_query' tipo='new' class='query'>";
							}else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";
							}
						}else{
							if(strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_update')){
								echo "<img src='". base_url('img/question.png') ."' id='termino_el_estudio_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";	
							}
						}						
						
					}
				?>
			</td>
		</tr>
		<tr id='tr_no' style='display:none;'>
			<td colspan='2' style='font-weight:bold;background-color:red;'>En este caso debe llenar el Fin de tratamiento terminación temprana, y marcar no aplica en esta página)</td>
		</tr>
		<tr>
			<td colspan='2' style='text-align:center;'>
				<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_update')){
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
			AND strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/fin_tratamiento_verify', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/fin_tratamiento_lock', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'fin_tratamiento_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/fin_tratamiento_signature', array('class'=>'form-horizontal')); ?>    	
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