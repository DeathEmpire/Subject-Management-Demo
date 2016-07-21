<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha, #fecha_alt").datepicker({ dateFormat: 'dd/mm/yy' });
	
	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").attr('readonly','readonly');			
			$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").attr('disabled','disabled');

		}else{
			$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").removeAttr('readonly');
			$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").removeAttr('disabled');
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").attr('readonly','readonly');
		$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").attr('disabled','disabled');
	}else{
		$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").removeAttr('readonly');
		$("#resta_1, #resta_2, #resta_3, #resta_4, #resta_5, #fecha").removeAttr('disabled');
	}

	$("input[name=realizado_alt]").change(function(){
		if($(this).val() == 0){
			$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").attr('readonly','readonly');
			$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").attr('disabled','disabled');

		}else{
			$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").removeAttr('readonly');
			$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").removeAttr('disabled');
		}
	});
	if($("input[name=realizado_alt]:checked").val() == 0){
		$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").attr('readonly','readonly');
		$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").attr('disabled','disabled');
	}else{
		$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha").removeAttr('readonly');
		$("#resta_1_alt, #resta_2_alt, #resta_3_alt, #resta_4_alt, #resta_5_alt, #fecha_alt").removeAttr('disabled');
	}
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
	?>
	<table class="table table-bordered table-striped table-hover">
		<tr>
			<td colspan='2' style='background-color:#ccc;'>Resta seriada</td>
		</tr>
		<tr>		
			<td>Realizado: </td>
			<td>
				<?= form_radio($data,$data['value'],set_radio($data['name'], 1, (($list[0]->realizado == 1) ? true : false))); ?> Si
				<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0, (($list[0]->realizado == 0) ? true : false))); ?> NO
			</td>
		</tr>
		<tr>
			<td>Fecha: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', ((!empty($list[0]->fecha) AND $list[0]->fecha !='0000-00-00') ? date("d/m/Y", strtotime($list[0]->fecha)) : "") ))); ?></td>
		</tr>
		<tr>
			<td style='background-color:#ccc;'>Resta 7 a partir de  100</td>
			<td style='background-color:#ccc;'>Indicar respuestas correctas</td>
		</tr>
	<?php 
		$resta_1 = array(
			    'name'        => 'resta_1',
			    'id'          => 'resta_1',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_1','1', (($list[0]->resta_1 == 1) ? true : false) )			    
		    );
		$resta_2 = array(
			    'name'        => 'resta_2',
			    'id'          => 'resta_2',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_2','1', (($list[0]->resta_2 == 1) ? true : false))			    
		    );
		$resta_3 = array(
			    'name'        => 'resta_3',
			    'id'          => 'resta_3',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_3','1', (($list[0]->resta_3 == 1) ? true : false))			    
		    );
		$resta_4 = array(
			    'name'        => 'resta_4',
			    'id'          => 'resta_4',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_4','1', (($list[0]->resta_4 == 1) ? true : false))			    
		    );
		$resta_5 = array(
			    'name'        => 'resta_5',
			    'id'          => 'resta_5',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_5','1', (($list[0]->resta_5 == 1) ? true : false))			    
		    );
		$resta_1_alt = array(
			    'name'        => 'resta_alt_1',
			    'id'          => 'resta_alt_1',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_alt_1','1', (($list[0]->resta_alt_1 == 1) ? true : false))			    
		    );
		$resta_2_alt = array(
			    'name'        => 'resta_alt_2',
			    'id'          => 'resta_alt_2',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_alt_2','1', (($list[0]->resta_alt_2 == 1) ? true : false))			    
		    );
		$resta_3_alt = array(
			    'name'        => 'resta_alt_3',
			    'id'          => 'resta_alt_3',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_alt_3','1', (($list[0]->resta_alt_3 == 1) ? true : false))			    
		    );
		$resta_4_alt = array(
			    'name'        => 'resta_alt_4',
			    'id'          => 'resta_alt_4',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_alt_4','1', (($list[0]->resta_alt_4 == 1) ? true : false))			    
		    );
		$resta_5_alt = array(
			    'name'        => 'resta_alt_5',
			    'id'          => 'resta_alt_5',
			    'value'       => '1',
			    'checked'     => set_checkbox('resta_alt_5','1', (($list[0]->resta_alt_5 == 1) ? true : false))			    
		    );
	?>
		<tr>
			<td>93</td>
			<td><?= form_checkbox($resta_1); ?></td>
		</tr>
		<tr>
			<td>86</td>
			<td><?= form_checkbox($resta_2); ?></td>
		</tr>
		<tr>
			<td>79</td>
			<td><?= form_checkbox($resta_3); ?></td>
		</tr>
		<tr>
			<td>72</td>
			<td><?= form_checkbox($resta_4); ?></td>
		</tr>
		<tr>
			<td>65</td>
			<td><?= form_checkbox($resta_5); ?></td>
		</tr>
	</table>
	<br />
	<table class="table table-bordered table-striped table-hover">	
		<tr>
			<td colspan='2' style='background-color:#ccc;'>Resta seriada alternativa</td>
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
			<td><?= form_input(array('type'=>'text','name'=>'fecha_alt', 'id'=>'fecha_alt', 'value'=>set_value('fecha_alt', $list[0]->fecha_alt))); ?></td>
		</tr>
		<tr>
			<td style='background-color:#ccc;'>Reste 3 a partir del 20</td>
			<td style='background-color:#ccc;'>Indicar respuestas correctas</td>
		</tr>
		<tr>
			<td>17</td>
			<td><?= form_checkbox($resta_1_alt); ?></td>
		</tr>
		<tr>
			<td>14</td>			
			<td><?= form_checkbox($resta_2_alt); ?></td>
		</tr>
		<tr>
			<td>11</td>
			<td><?= form_checkbox($resta_3_alt); ?></td>
		</tr>
		<tr>
			<td>8</td>
			<td><?= form_checkbox($resta_4_alt); ?></td>
		</tr>
		<tr>
			<td>5</td>
			<td><?= form_checkbox($resta_5_alt); ?></td>
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
<!-- Querys -->
<?php
	if(isset($querys) AND !empty($querys)){ ?>
		<b>Querys:</b>
		<table class="table table-condensed table-bordered table-stripped">
			<thead>
				<tr>
					<th>Fecha de Consulta</th>
								<th>Usuario</th>
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
							if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'additional_form_query_show')){
						?>
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id .'/Restas Seriadas', 'Responder',array('class'=>'btn'))); ?></td>						
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
	<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
		
		Formulario aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y",strtotime($list[0]->verify_date));?>
	
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
		
		Formulario cerrado por <?= $list[0]->lock_user;?> el <?= date("d-M-Y",strtotime($list[0]->lock_date));?>
	
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
