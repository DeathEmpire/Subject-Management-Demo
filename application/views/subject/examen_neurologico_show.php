<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker();
});
</script>
<legend style='text-align:center;'>Examen Neurologico</legend>
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
<!-- New Query-->
<?php
	if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'additional_form_query_new')){
?>
	<div id='new_query' style='text-align:right;'>
		<?= form_open('query/additional_form_query_new', array('class'=>'form-horizontal')); ?>
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('form', "Examen Neurologico"); ?>
		<?= form_button(array('type'=>'submit', 'content'=>'Query', 'class'=>'btn btn-primary')); ?>
		<?= form_close(); ?>
	</div>
<?php }?>
<!-- End Query-->
<?php
	if(isset($list) AND !empty($list)){
?>	
<?= form_open('subject/examen_neurologico_update', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('etapa', $etapa); ?>	
	<?= form_hidden('id', $list[0]->id); ?>
	 
	
		<?php
       		$si = array(
			    'name'        => 'realizado',			    
			    'value'       => 1,		    			    
			    'checked'     => set_radio('realizado', 1, (($list[0]->realizado == 1) ? true : false))
			    );
	   		$no = array(
			    'name'        => 'realizado',			    
			    'value'       => 0,	
			    'checked'     => set_radio('realizado', 0, (($list[0]->realizado == 0) ? true : false))
			    );
	   		$si2 = array(
			    'name'        => 'fecha_examen_misma_visita',			    
			    'value'       => 1,		    			    
			    'checked'     => set_radio('fecha_examen_misma_visita', 1, (($list[0]->fecha_examen_misma_visita == 1) ? true : false))
			    );
	   		$no2 = array(
			    'name'        => 'fecha_examen_misma_visita',			    
			    'value'       => 0,	
			    'checked'     => set_radio('fecha_examen_misma_visita', 0, (($list[0]->fecha_examen_misma_visita == 0) ? true : false))
			    );

	   		$normal_anormal = array(''=>'',
	   								'1'=>'Normal',
	   								'0'=>'Anormal');
       	?>	

		Examen Neurológico realizado <?= form_radio($si); ?> Si <?= form_radio($no); ?> No<br />
		La fecha del examen neurológico es la misma fecha de la visita?	 <?= form_radio($si2); ?> Si <?= form_radio($no2); ?> No<br />
 
		Si la respuesta es “NO”, por favor reporte fecha del examen: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha',$list[0]->fecha))); ?><br />
		<br />
		<table class='table table-bordered table-striped table-hover'>
			<tr>
				<th>Examen</th>
				<th>Normal/Anormal</th>
				<th>Detallar si es “Anormal” y clínicamente significativo</th>
			</tr>
			<tr>
				<td>Nervios craneanos</td>
				<td><?= form_dropdown("nervios_craneanos_normal_anormal",$normal_anormal,set_value('nervios_craneanos_normal_anormal',$list[0]->nervios_craneanos_normal_anormal)); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'nervios_craneanos', 'id'=>'nervios_craneanos', 'value'=>set_value('nervios_craneanos',$list[0]->nervios_craneanos)));?></td>
			</tr>
			<tr>
				<td>Examen motor</td>
				<td><?= form_dropdown("examen_motor_normal_anormal",$normal_anormal,set_value('examen_motor_normal_anormal',$list[0]->examen_motor_normal_anormal)); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'examen_motor', 'id'=>'examen_motor', 'value'=>set_value('examen_motor',$list[0]->examen_motor)));?></td>
			</tr>
			<tr>
				<td>Examen sensitivo</td>
				<td><?= form_dropdown("examen_sensitivo_normal_anormal",$normal_anormal,set_value('examen_sensitivo_normal_anormal',$list[0]->examen_sensitivo_normal_anormal)); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'examen_sensitivo', 'id'=>'examen_sensitivo', 'value'=>set_value('examen_sensitivo',$list[0]->examen_sensitivo)));?></td>
			</tr>
			<tr>
				<td>Reflejos</td>
				<td><?= form_dropdown("reflejos_normal_anormal",$normal_anormal,set_value('reflejos_normal_anormal',$list[0]->reflejos_normal_anormal)); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'reflejos', 'id'=>'reflejos', 'value'=>set_value('reflejos',$list[0]->reflejos)));?></td>
			</tr>
			<tr>
				<td>Función cerebelosa</td>
				<td><?= form_dropdown("funcion_cerebelosa_normal_anormal",$normal_anormal,set_value('funcion_cerebelosa_normal_anormal',$list[0]->funcion_cerebelosa_normal_anormal)); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'funcion_cerebelosa', 'id'=>'funcion_cerebelosa', 'value'=>set_value('funcion_cerebelosa',$list[0]->funcion_cerebelosa)));?></td>
			</tr>
			<tr>
				<td>Marcha</td>
				<td><?= form_dropdown("marcha_normal_anormal",$normal_anormal,set_value('marcha_normal_anormal',$list[0]->marcha_normal_anormal)); ?></td>
				<td><?= form_input(array('type'=>'text','name'=>'marcha', 'id'=>'marcha', 'value'=>set_value('marcha',$list[0]->marcha)));?></td>
			</tr>		
			<tr>
				<td style='font-weight:bold;' colspan='3'>Anormalidades de significancia clínica en la visita de screening deben reportarse como historia médica si el consentimiento informado está firmado.</td>
			</tr>
			<tr>
				<td style='font-weight:bold;' colspan='3'>Anormalidades de significancia clínica después de la visita de screening deben reportarse como eventos adversos.</td>
			</tr>
			<tr>
				<td colspan='3' style='text-align:center;'>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
            		<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
				</td>
			</tr>
		</table>

		
<?= form_close(); ?>
<?php }?>

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
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id .'/Examen Neurologico', 'Responder',array('class'=>'btn'))); ?></td>						
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
			AND strpos($_SESSION['role_options']['subject'], 'examen_neurologico_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/examen_neurologico_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
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
		
		Formulario cerrado por <?= $list[0]->lock_user;?> el <?= date("d-M-Y",strtotime($list[0]->lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'examen_neurologico_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/examen_neurologico_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
			
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
			AND strpos($_SESSION['role_options']['subject'], 'examen_neurologico_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/examen_neurologico_signature', array('class'=>'form-horizontal')); ?>
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiene de Firma";
		}
	}
?>
<br />