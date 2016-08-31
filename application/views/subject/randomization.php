<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("input[name^=is_randomizable]").change(function(){

		if($(this).val() == 1){
			$("#randomization_date").datepicker({ dateFormat: 'dd/mm/yy' });
			$(".randomization").show();
			$(".buttons_form").show();
		}else{
			$(".randomization").hide();
			$(".buttons_form").hide();
		}

	});

	/*Show Hide Date of Randomizarion at start*/
	if($("input[name^=is_randomizable]:checked").val() == 1){
		$("#randomization_date").datepicker({ dateFormat: 'dd/mm/yy' });
		$(".randomization").show();
		$(".buttons_form").show();
	}else{
		$(".randomization").hide();
		$(".buttons_form").hide();
	}


});	
</script>
<legend style='text-align:center;'>Randomizacion</legend>
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
	$data = array(
        'name'        => 'is_randomizable',                
        'value'       => '1',            
        #'checked'     => set_radio('is_randomizable', 1, TRUE),
        );
    $data2 = array(
        'name'        => 'is_randomizable',                
        'value'       => '0',
        #'checked'     => set_radio('is_randomizable', 0, TRUE),           
        );
    if ($subject->randomization_date == '0000-00-00') {
    	$subject->randomization_date = "";
    }
?>
<?= form_open('subject/randomization_update', array('class'=>'form-horizontal')); ?>
	<?= form_hidden('id', $subject->id); ?>
	<?= form_hidden('center', $subject->center); ?>
	<?= my_validation_errors(validation_errors()); ?>
	<table class="table table-condensed table-bordered">        
        <tr>
            <td>¿ Es el sujeto elegible para randomizacion ? : </td>
            <td>
            	<?= form_radio($data,$data['value'],set_radio($data['name'],$data['value'],($data['value'] == $subject->is_randomizable) ? true : false)); ?> Si 
            	<?= form_radio($data2,$data2['value'],set_radio($data2['name'],$data2['value'],($data2['value'] == $subject->is_randomizable) ? true : false)); ?> No
            </td>
        </tr>

        <tr class='randomization' style='display:none'>
            <td>Fecha de Randomizacion: </td>
            <td><?= form_input(array('type'=>'text', 'name'=>'randomization_date', 'id'=>'randomization_date', 'readonly'=>'readonly', 'style'=>'cursor: pointer;', 'value'=>set_value('randomization_date',(($subject->randomization_date != '0000-00-00' AND $subject->randomization_date != null) ? date('d/m/Y', strtotime($subject->randomization_date)): '') ))); ?></td>
        </tr>

		<tr class='buttons_form' style='display:none'>
            <td colspan='2' style='text-align:center;'>
            	<?php
            		if ($subject->randomization_status != 'Record Complete') {
            	?>
            		<?php
						if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'randomization_update')){
					?>
            			<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
            		<?php }?>	
            			<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
            	<?php	
            		}else{ ?>
						<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
            	<?php }?>
        	</td>
       </tr>
    </table>
<?= form_close(); ?>
<!-- Verify -->
<b>Aprobacion del Monitor:</b><br />
	<?php if(!empty($subject->randomization_verify_user) AND !empty($subject->randomization_verify_date)){ ?>
		
		Formulario aprobado por <?= $subject->verify_user;?> el <?= date("d-M-Y",strtotime($subject->verify_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'randomization_verify') 
			AND $subject->randomization_status == 'Record Complete'
		){
	?>
		<?= form_open('subject/randomization_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('id', $subject->id); ?>
		<?= form_hidden('current_status', $subject->randomization_status); ?>	
			
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
	<?php if(!empty($subject->randomization_lock_user) AND !empty($subject->randomization_lock_date)){ ?>
		
		Formulario cerrado por <?= $subject->randomization_lock_user;?> el <?= date("d-M-Y",strtotime($subject->randomization_lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'randomization_lock')
			AND $subject->randomization_status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/randomization_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('id', $subject->id); ?>
		<?= form_hidden('current_status', $subject->randomization_status); ?>	
			
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
	<?php if(!empty($subject->randomization_signature_user) AND !empty($subject->randomization_signature_date)){ ?>
		
		Formulario Firmado por <?= $subject->randomization_signature_user;?> on <?= date("d-M-Y",strtotime($subject->randomization_signature_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'randomization_signature')
			AND $subject->randomization_status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/randomization_signature', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('id', $subject->id); ?>
		<?= form_hidden('current_status', $subject->randomization_status); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Firma";
		}
	}
?>
<br />

