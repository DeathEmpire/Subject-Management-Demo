<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#birth_date").datepicker({changeMonth: true, changeYear: true, yearRange: '-100:+0',dateFormat: 'dd/mm/yy'});
	$("#sign_consent_date").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name=sign_consent]").change(function(){
		if($(this).val() == 1){
			$("#sign_consent_date").removeAttr('disabled');
			$("#mensaje").hide();
			$("#guardar").show();
		}
		else if($(this).val() == 0){
			$("#sign_consent_date").attr('disabled','disabled');
			$("#mensaje").show();
			$("#guardar").hide();
		}
	});

	if($("input[name=sign_consent]:checked").val() == 0){
		$("#sign_consent_date").attr('disabled','disabled');
		$("#mensaje").show();
		$("#guardar").hide();
	}

	$("#race").change(function(){
		if($(this).val() == 'Otro'){
			$("#race_especificacion").removeAttr('readonly');
		}
		else{
			$("#race_especificacion").attr('readonly','readonly');
		}
	});
	if($("#race").val() == 'Otro'){
		$("#race_especificacion").removeAttr('readonly');
	}
	else{
		$("#race_especificacion").attr('readonly','readonly');
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
				"subject_id": $("input[name=id]").val(),
				"form": "demography",
				"form_nombre" : "Demografia",
				"form_id" : $("input[name=id]").val(),
				"tipo": $(this).attr('tipo')
			},
			function(d){
				
				$("#query_para_campos").html(d);
				$("#query_para_campos").dialog('open');
			}
		);
	});

	$("#birth_date").change(function(){
		var fecha_nac = $(this).val().split("/");
		
		var ano_nac = parseInt(fecha_nac[2]);
		var dia_nac = parseInt(fecha_nac[0]);
		var mes_nac = parseInt(fecha_nac[1]);

		var ano_actual = parseInt("<?php echo date('Y');?>");
		var dia_actual = parseInt("<?php echo date('j');?>");
		var mes_actual = parseInt("<?php echo date('n');?>");

		var edad = ano_actual - ano_nac;
		
		var dif_dia = dia_actual - dia_nac;
		var dif_mes = mes_actual - mes_nac;
		if(dif_mes < 0 || (dif_mes == 0 && dif_dia < 0)){
			edad--;
		}
		$("#edad").val(edad);
	});
});
</script>
<div id='query_para_campos' style='display:none;'></div>
<legend style='text-align:center;'>Demograf&iacute;a - Consentimiento Informado</legend>
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

<?= form_open('subject/demography_update', array('class'=>'form-horizontal')); ?>    
	
	<?= form_hidden('id', $subject->id); ?>
	<?= form_hidden('center', $subject->center); ?>

    <?= my_validation_errors(validation_errors()); ?>

    <table class="table table-condensed table-bordered table-striped table-hover">
       	<?php
       		$sign_consent_1 = array(
			    'name'        => 'sign_consent',			    
			    'value'       => 1,		    			    			    );
	   		$sign_consent_0 = array(
			    'name'        => 'sign_consent',			    
			    'value'       => 0,		    			    
			    );
       	?>

       	<tr>
       		<td style='font-weight:bold;' colspan='2'>1.- Consentimiento Informado</td>
       	</tr>
       	
       	<tr>	
       		<td>Firmado: </td>
       		<td>
       			<?= form_radio('sign_consent',1,set_radio('sign_consent',1,((1 == $subject->sign_consent) ? true : false))); ?> Si
	        	<?= form_radio('sign_consent',0,set_radio('sign_consent',0,(('0' == $subject->sign_consent) ? true : false))); ?> No
	        </td>
       	</tr>
       	<tr id='mensaje' style='display:none;'>
       		<td colspan='2' style='font-weight:bold;'>Si el sujeto no ha firmado el Consentimiento Informado no puede participar en el estudio</td>
       	</tr>
       	<tr>       		
       		<td>Fecha: </td>
       		<td>
       			<?= form_input(array('type'=>'text', 'name'=>'sign_consent_date', 'id'=>'sign_consent_date', 'value'=>set_value('sign_consent_date', $subject->sign_consent_date)));?>
				<?php
					if($subject->demography_status == 'Record Complete' OR $subject->demography_status == 'Query' )
					{
						
						if(!in_array("sign_consent_date", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'demography_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='sign_consent_date_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'demography_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='sign_consent_date_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
        	<td style='font-weight:bold;' colspan='2'>2.- Demograf&iacute;a</td>
        </tr>		
		<tr>
			<td>Iniciales Sujeto: </td>
			<td><?= form_input(array('type'=>'text', 'name'=>'initials', 'id'=>'initials', 'maxlength'=>'3' , 'value'=>set_value('initials', $subject->initials) ) ); ?>
			<?php
					if($subject->demography_status == 'Record Complete' OR $subject->demography_status == 'Query' )
					{
						
						if(!in_array("", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'demography_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='initials_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'demography_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='initials_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
			<td>Edad: </td>
			<td><?= form_input(array('type'=>'number', 'name'=>'edad', 'id'=>'edad', 'maxlength'=>'2' , 'value'=>set_value('edad', $subject->edad) ) ); ?>
				<?php
					if($subject->demography_status == 'Record Complete' OR $subject->demography_status == 'Query' )
					{
						
						if(!in_array("edad", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'demography_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='edad_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'demography_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='edad_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>
		</tr>
		<?php
		    $data = array(
			    'name'        => 'gender',			    
			    'value'       => 'male',		    
			    #'checked'	  => set_radio('gender', 'male', TRUE),
			    );
		  	$data2 = array(
			    'name'        => 'gender',			    
			    'value'       => 'female',
			    #'checked'	  => set_radio('gender', 'female', TRUE),		    
			    );
		      
	    ?>
	    <tr>
	        <td><?= form_label('Sexo: ', 'gender'); ?></td>
	        <td>
	        	<?= form_radio($data,$data['value'],set_radio($data['name'],$data['value'],($data['value'] == $subject->gender) ? true : false)); ?> Masc
	        	<?= form_radio($data2,$data2['value'],set_radio($data2['name'],$data2['value'],($data2['value'] == $subject->gender) ? true : false)); ?> Fem
	        	<?php
					if($subject->demography_status == 'Record Complete' OR $subject->demography_status == 'Query' )
					{
						
						if(!in_array("gender", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'demography_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='gender_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'demography_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='gender_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
        	<td><?= form_label('Fecha de Nacimiento: ', 'birth_date'); ?></td>
        	<td><?= form_input(array('type'=>'text', 'name'=>'birth_date', 'id'=>'birth_date', 'readonly'=>'readonly', 'style'=>'cursor: pointer;','value'=>set_value('birth_date',$subject->birth_date))); ?>
        	<?php
					if($subject->demography_status == 'Record Complete' OR $subject->demography_status == 'Query' )
					{
						
						if(!in_array("birth_date", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'demography_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='birth_date_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'demography_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='birth_date_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
        	<td><?= form_label('Etnia/Raza: ', 'race'); ?></td>
        	<td>
        		<?= form_dropdown('race',$etnias,set_value('race', $subject->race), array('id'=>'race')); ?>        		
        		Especificar: <?= form_input(array('type'=>'text','name'=>'race_especificacion','id'=>'race_especificacion', 'value'=>set_value('race_especificacion', $subject->race_especificacion))); ?>
        		<?php
					if($subject->demography_status == 'Record Complete' OR $subject->demography_status == 'Query' )
					{
						
						if(!in_array("race", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'demography_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='race_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'demography_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='race_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
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
    		<td><?= form_label('Grado de Escolaridad: ', 'escolaridad'); ?></td>
    		<td><?= form_dropdown('escolaridad', $escolaridad, set_value('escolaridad',$subject->escolaridad)); ?>
    		<?php
					if($subject->demography_status == 'Record Complete' OR $subject->demography_status == 'Query' )
					{
						
						if(!in_array("escolaridad", $campos_query))  
						{
							if(strpos($_SESSION['role_options']['subject'], 'demography_verify')){
								echo "<img src='". base_url('img/icon-check.png') ."' id='escolaridad_query' tipo='new' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/icon-check.png') ."'>";		
							}
							
						}
						else 
						{	
							if (strpos($_SESSION['role_options']['subject'], 'demography_update')){					
								echo "<img src='". base_url('img/question.png') ."' id='escolaridad_query' tipo='old' style='width:20px;height:20px;' class='query'>";	
							}
							else{
								echo "<img src='". base_url('img/question.png') ."' style='width:20px;height:20px;'>";		
							}
						}						
						
					}
				?>
			</td>

    	</tr>
		
		<?php
				if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'demography_update')){
			?>
	    <tr>
	    	<td colspan='2' style='text-align:center;'>
				<?php if(empty($subject->demography_signature_user) AND empty($subject->demography_lock_user) AND empty($subject->demography_verify_user)){ ?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary', 'id'=>'guardar')); ?>			
				<?php }?>
		        
		        <?= anchor('subject/grid/'. $subject->id, 'Volver', array('class'=>'btn')); ?>
	    	</td>
		</tr>
	    <?php }?>
	</table>
<?= form_close(); ?>
<!-- Querys -->
<?php
	if(isset($querys) AND !empty($querys)){ ?>
		<b>Consultas:</b>
		<table class="table table-condensed table-bordered table-stripped">
			<thead>
				<tr>
					<th>Fecha de Consulta</th>
					<th>Usuasio</th>
					<th>Consulta</th>
					<th>Fecha de Respuesta</th>
					<th>Usuario</th>
					<th>Respuesta</th>					
				</tr>
			</thead>
			<tbody>
				
			<?php
				foreach ($querys as $query) { ?>
					<tr>
						<td><?= date("d-M-Y H:i:s", strtotime($query->created)); ?></td>
						<td><?= $query->question_user; ?></td>
						<td><?= $query->question; ?></td>						
						<td><?= (($query->answer_date != "0000-00-00 00:00:00") ? date("d-M-Y H:i:s", strtotime($query->answer_date)) : ""); ?></td>
						<td><?= $query->answer_user; ?></td>
						<?php
							if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'demography_query_show')){
						?>
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/demography_query_show/'. $subject->id .'/'.$query->id, 'Add',array('class'=>'btn'))); ?></td>						
						<?php }else{?>
							<td><?= $query->answer; ?></td>
						<?php }?>
					</tr>					
			<?php }?>	

			</tbody>
		</table>

<?php } ?>

<!-- Verify -->
<b>Aprobacion del Monitor:</b><br />
	<?php if(!empty($subject->demography_verify_user) AND !empty($subject->demography_verify_date)){ ?>
		
		Formulario aprobado por <?= $subject->demography_verify_user;?> el <?= date("d-M-Y H:i:s",strtotime($subject->demography_verify_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'demography_verify') 
			AND $subject->demography_status == 'Record Complete'
		){
	?>
		<?= form_open('subject/demography_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('id', $subject->id); ?>
		<?= form_hidden('current_status', $subject->demography_status); ?>
			
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
	<?php if(!empty($subject->demography_lock_user) AND !empty($subject->demography_lock_date)){ ?>
		
		Formulario cerrado por <?= $subject->demography_lock_user;?> el <?= date("d-M-Y H:i:s",strtotime($subject->demography_lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'demography_lock')
			AND $subject->demography_status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/demography_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('id', $subject->id); ?>
		<?= form_hidden('current_status', $subject->demography_status); ?>
			
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
	<?php if(!empty($subject->demography_signature_user) AND !empty($subject->demography_signature_date)){ ?>
		
		Formulario Firmado por <?= $subject->demography_signature_user;?> el <?= date("d-M-Y H:i:s",strtotime($subject->demography_signature_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'demography_signature')
			AND $subject->demography_status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/demography_signature', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('id', $subject->id); ?>
		<?= form_hidden('current_status', $subject->demography_status); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Firma";
		}
	}
?>
<br />