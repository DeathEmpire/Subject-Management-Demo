<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){

	$("#date_of_deviation").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name^=pre_approved]").change(function(){
		if($(this).val() == 1){
			$("#sponsor_tr").show();
		}else{
			$("#sponsor_tr").hide();
		}
	});
	
	if($("input[name=pre_approved]:checked").val() == 1){
		$("#sponsor_tr").show();
	}else{
		$("#sponsor_tr").hide();
	}
	
});
</script>
<legend style='text-align:center;'>Desviación de Protocolo</legend>
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
        'name'        => 'pre_approved',                
        'value'       => '1',            
        'checked'     => set_radio('pre_approved', 1, (($list[0]->pre_approved == 1) ? true : false) ),
        );
    $data2 = array(
        'name'        => 'pre_approved',                
        'value'       => '0',
        'checked'     => set_radio('pre_approved', 0, (($list[0]->pre_approved == 0) ? true : false) ),           
        );
?>
<div style='display:none;'>
    <div id='dialog_auditoria'><?= ((isset($auditoria) AND !empty($auditoria)) ? $auditoria : ''); ?></div>
</div>
<?php
    if(isset($auditoria) AND !empty($auditoria)){
        echo "<div style='text-align:right;'><a id='ver_auditoria' class='btn btn-info colorbox_inline' href='#dialog_auditoria'>Ver Auditoria</a></div>";
    }
?>
<?= form_open('subject/protocol_deviation_form_update', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('id', $list[0]->id); ?>

	<table class="table table-striped table-condensed table-bordered">       		
        <tr>
        	<td>Fecha de Desviación: </td>
        	<td><?= form_input(array('type'=>'text', 'name'=>'date_of_deviation', 'id'=>'date_of_deviation', 'readonly'=>'readonly', 'style'=>'cursor: pointer;', 'value'=>set_value('date_of_deviation', (($list[0]->date_of_deviation != '0000-00-00') ? date('d/m/Y', strtotime($list[0]->date_of_deviation)) : '') )));?></td>
		</tr>
		<tr>
        	<td>Descripción de la Desviación: </td>
        	<td><?= form_input(array('type'=>'text','name'=>'description', 'id'=>'description', 'value'=>set_value('description', $list[0]->description))); ?></td>
		</tr>
		<tr>
        	<td>¿Está la desviación aprobada por el Patrocinador?: </td>
        	<td><?= form_radio($data); ?> Si <?= form_radio($data2); ?> No</td>
		</tr>
		<tr style='display:none;' id='sponsor_tr'>
        	<td>Nombre de la persona que autoriza: </td>        	
        	<td><?= form_input(array('type'=>'text','name'=>'sponsor_name', 'id'=>'sponsor_name', 'value'=>set_value('sponsor_name', $list[0]->sponsor_name))); ?></td>
		</tr>	
		
		<tr>
            <td colspan='2' style='text-align:center;'><?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
            <?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn btn-default')); ?></td>
       </tr>
    </table>
<?= form_close(); ?>
<b>Creado por:</b> <?= $list[0]->usuario_creacion;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->created));?><br />&nbsp;</br>
<!-- Verify -->
<b>Aprobacion del Monitor:</b><br />
	<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
		
		Formulario aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->verify_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'protocol_deviation_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/protocol_deviation_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>		
		<?= form_hidden('id', $list[0]->id); ?>
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
		
		Formulario cerrado por <?= $list[0]->lock_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'protocol_deviation_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/protocol_deviation_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>		
		<?= form_hidden('id', $list[0]->id); ?>
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
		
		Formulario Firmado por <?= $list[0]->signature_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->signature_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'protocol_deviation_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/protocol_deviation_signature', array('class'=>'form-horizontal')); ?>    	
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