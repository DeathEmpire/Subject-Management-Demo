<script src="<?= base_url('js/npi.js') ?>"></script>
<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>

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
<legend style='text-align:center;'>NPI <?= $protocolo;?></legend>
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
<?= form_open('subject/npi_update', array('class'=>'form-horizontal', 'id'=>'form_npi')); ?>
	
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

	  	$status = array(''=>'','1'=>'Si','0'=>'No');
	?>
	<table class="table table-bordered table-striper table-hover">
		<tr>		
			<td>Realizado: </td>
			<td>
				<?= form_radio($data,$data['value'],set_radio($data['name'], 1)); ?> Si
				<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
			</td>
		</tr>
		<tr>
			<td>Fecha: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', ((!empty($list[0]->fecha) AND $list[0]->fecha !='0000-00-00') ? date("d/m/Y", strtotime($list[0]->fecha)) : "") ))); ?></td>
		</tr>

		<tr>
			<td>Puntaje Total de NPI: </td>
			<td><?= form_input(array('type'=>'number','name'=>'puntaje_total_npi', 'id'=>'puntaje_total_npi', 'value'=>set_value('puntaje_total_npi', $list[0]->puntaje_total_npi), 'readonly'=>'readonly')); ?></td>
		</tr>

		<tr>
			<td>Puntaje total para Angustia de el (la) Cuidador(a): </td>
			<td><?= form_input(array('type'=>'number','name'=>'puntaje_total_para_angustia', 'id'=>'puntaje_total_para_angustia', 'value'=>set_value('puntaje_total_para_angustia', $list[0]->puntaje_total_para_angustia), 'readonly'=>'readonly')); ?></td>
		</tr>
	</table>
	<br>
	
	Para cada categoría se responde Sí, por favor complete Frecuencia, Severidad y Angustia:<br />	
	<table class="table table-bordered table-striper table-hover">
		<thead>
			<tr>
				<td></td>
				<td>Categoría</td>
				<td>Status (Sí / No)</td>
				<td>Frecuencia</td>
				<td>Severidad</td>
				<td>Puntaje (Frecuencia * Severidad)</td>
				<td>Angustia</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>Delirios</td>
				<td><?= form_dropdown('delirio_status', $status, set_value('delirio_status', $list[0]->delirio_status)); ?></td>
				<td><?= form_dropdown('delirio_frecuencia', $frecuencia, set_value('delirio_frecuencia', $list[0]->delirio_frecuencia), array('id'=>'delirio_frecuencia')); ?></td>
				<td><?= form_dropdown('delirio_severidad',  $severidad, set_value('delirio_severidad', $list[0]->delirio_severidad), array('id'=>'delirio_severidad')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'delirio_puntaje', 'id'=>'delirio_puntaje','value'=>set_value('delirio_puntaje', $list[0]->delirio_puntaje), 'readonly'=>'readonly')); ?></td>
				<td><?= form_dropdown('delirio_angustia', $angustia, set_value('delirio_angustia', $list[0]->delirio_angustia), array('id'=>'delirio_angustia')); ?></td>				
			</tr>
			<tr>
				<td>2</td>
				<td>Alucinaciones</td>
				<td><?= form_dropdown('alucinaciones_status', $status, set_value('alucinaciones_status', $list[0]->alucinaciones_status)); ?></td>
				<td><?= form_dropdown('alucinaciones_frecuencia', $frecuencia, set_value('alucinaciones_frecuencia', $list[0]->alucinaciones_frecuencia), array('id'=>'alucinaciones_frecuencia')); ?></td>
				<td><?= form_dropdown('alucinaciones_severidad', $severidad, set_value('alucinaciones_severidad', $list[0]->alucinaciones_severidad), array('id'=>'alucinaciones_severidad')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'alucinaciones_puntaje', 'id'=>'alucinaciones_puntaje','value'=>set_value('alucinaciones_puntaje', $list[0]->alucinaciones_puntaje), 'readonly'=>'readonly')); ?></td>
				<td><?= form_dropdown('alucinaciones_angustia', $angustia, set_value('alucinaciones_angustia', $list[0]->alucinaciones_angustia), array('id'=>'alucinaciones_angustia')); ?></td>				
			</tr>
			<tr>
				<td>3</td>
				<td>Agitación / Agresividad</td>
				<td><?= form_dropdown('agitacion_status', $status, set_value('agitacion_status', $list[0]->agitacion_status)); ?></td>
				<td><?= form_dropdown('agitacion_frecuencia', $frecuencia, set_value('agitacion_frecuencia', $list[0]->agitacion_frecuencia), array('id'=>'agitacion_frecuencia')); ?></td>
				<td><?= form_dropdown('agitacion_severidad', $severidad, set_value('agitacion_severidad', $list[0]->agitacion_severidad), array('id'=>'agitacion_severidad')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'agitacion_puntaje', 'id'=>'agitacion_puntaje','value'=>set_value('agitacion_puntaje', $list[0]->agitacion_puntaje), 'readonly'=>'readonly')); ?></td>
				<td><?= form_dropdown('agitacion_angustia', $angustia, set_value('agitacion_angustia', $list[0]->agitacion_angustia), array('id'=>'agitacion_angustia')); ?></td>				
			</tr>
			<tr>
				<td>4</td>
				<td>Depresión</td>				
				<td><?= form_dropdown('depresion_status', $status, set_value('depresion_status', $list[0]->depresion_status)); ?></td>
				<td><?= form_dropdown('depresion_frecuencia', $frecuencia, set_value('depresion_frecuencia', $list[0]->depresion_frecuencia), array('id'=>'depresion_frecuencia')); ?></td>
				<td><?= form_dropdown('depresion_severidad', $severidad, set_value('depresion_severidad', $list[0]->depresion_severidad), array('id'=>'depresion_severidad')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'depresion_puntaje', 'id'=>'depresion_puntaje','value'=>set_value('depresion_puntaje', $list[0]->depresion_puntaje), 'readonly'=>'readonly')); ?></td>
				<td><?= form_dropdown('depresion_angustia', $angustia, set_value('depresion_angustia', $list[0]->depresion_angustia), array('id'=>'depresion_angustia')); ?></td>				
			</tr>
			<tr>
				<td>5</td>
				<td>Ansiedad</td>
				<td><?= form_dropdown('ansiedad_status', $status, set_value('ansiedad_status', $list[0]->ansiedad_status)); ?></td>
				<td><?= form_dropdown('ansiedad_frecuencia',$frecuencia, set_value('ansiedad_frecuencia', $list[0]->ansiedad_frecuencia), array('id'=>'ansiedad_frecuencia')); ?></td>
				<td><?= form_dropdown('ansiedad_severidad', $severidad, set_value('ansiedad_severidad', $list[0]->ansiedad_severidad), array('id'=>'ansiedad_severidad')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'ansiedad_puntaje', 'id'=>'ansiedad_puntaje','value'=>set_value('ansiedad_puntaje', $list[0]->ansiedad_puntaje), 'readonly'=>'readonly')); ?></td>
				<td><?= form_dropdown('ansiedad_angustia', $angustia, set_value('ansiedad_angustia', $list[0]->ansiedad_angustia), array('id'=>'ansiedad_angustia')); ?></td>				
			</tr>
			<tr>
				<td>6</td>
				<td>Elación / Euforia</td>
				<td><?= form_dropdown('elacion_status', $status, set_value('elacion_status', $list[0]->elacion_status)); ?></td>
				<td><?= form_dropdown('elacion_frecuencia',$frecuencia, set_value('elacion_frecuencia', $list[0]->elacion_frecuencia), array('id'=>'elacion_frecuencia')); ?></td>
				<td><?= form_dropdown('elacion_severidad', $severidad, set_value('elacion_severidad', $list[0]->elacion_severidad), array('id'=>'elacion_severidad')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'elacion_puntaje', 'id'=>'elacion_puntaje','value'=>set_value('elacion_puntaje', $list[0]->elacion_puntaje), 'readonly'=>'readonly')); ?></td>
				<td><?= form_dropdown('elacion_angustia', $angustia, set_value('elacion_angustia', $list[0]->elacion_angustia), array('id'=>'elacion_angustia')); ?></td>				
			</tr>
			<tr>
				<td>7</td>
				<td>Apatía / Indiferencia</td>
				<td><?= form_dropdown('apatia_status', $status, set_value('apatia_status', $list[0]->apatia_status)); ?></td>
				<td><?= form_dropdown('apatia_frecuencia',$frecuencia, set_value('apatia_frecuencia', $list[0]->apatia_frecuencia), array('id'=>'apatia_frecuencia')); ?></td>
				<td><?= form_dropdown('apatia_severidad', $severidad, set_value('apatia_severidad', $list[0]->apatia_severidad), array('id'=>'apatia_severidad')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'apatia_puntaje', 'id'=>'apatia_puntaje','value'=>set_value('apatia_puntaje', $list[0]->apatia_puntaje), 'readonly'=>'readonly')); ?></td>
				<td><?= form_dropdown('apatia_angustia', $angustia, set_value('apatia_angustia', $list[0]->apatia_angustia), array('id'=>'apatia_angustia')); ?></td>				
			</tr>

			<tr>
				<td>8</td>
				<td>Deshinibición</td>
				<td><?= form_dropdown('deshinibicion_status', $status, set_value('deshinibicion_status', $list[0]->deshinibicion_status)); ?></td>
				<td><?= form_dropdown('deshinibicion_frecuencia',$frecuencia, set_value('deshinibicion_frecuencia', $list[0]->deshinibicion_frecuencia), array('id'=>'deshinibicion_frecuencia')); ?></td>
				<td><?= form_dropdown('deshinibicion_severidad', $severidad, set_value('deshinibicion_severidad', $list[0]->deshinibicion_severidad), array('id'=>'deshinibicion_severidad')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'deshinibicion_puntaje', 'id'=>'deshinibicion_puntaje','value'=>set_value('deshinibicion_puntaje', $list[0]->deshinibicion_puntaje), 'readonly'=>'readonly')); ?></td>
				<td><?= form_dropdown('deshinibicion_angustia', $angustia, set_value('deshinibicion_angustia', $list[0]->deshinibicion_angustia), array('id'=>'deshinibicion_angustia')); ?></td>				
			</tr>
			
			<tr>
				<td>9</td>
				<td>Irritabilidad</td>
				<td><?= form_dropdown('irritabilidad_status', $status, set_value('irritabilidad_status', $list[0]->irritabilidad_status)); ?></td>
				<td><?= form_dropdown('irritabilidad_frecuencia', $frecuencia, set_value('irritabilidad_frecuencia', $list[0]->irritabilidad_frecuencia), array('id'=>'irritabilidad_frecuencia')); ?></td>
				<td><?= form_dropdown('irritabilidad_severidad',  $severidad, set_value('irritabilidad_severidad', $list[0]->irritabilidad_severidad), array('id'=>'irritabilidad_severidad')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'irritabilidad_puntaje', 'id'=>'irritabilidad_puntaje','value'=>set_value('irritabilidad_puntaje', $list[0]->irritabilidad_puntaje), 'readonly'=>'readonly')); ?></td>
				<td><?= form_dropdown('irritabilidad_angustia', $angustia, set_value('irritabilidad_angustia', $list[0]->irritabilidad_angustia), array('id'=>'irritabilidad_angustia')); ?></td>				
			</tr>
			<tr>
				<td>10</td>
				<td>Conducta Motora Aberrante</td>
				<td><?= form_dropdown('conducta_status', $status, set_value('conducta_status', $list[0]->conducta_status)); ?></td>
				<td><?= form_dropdown('conducta_frecuencia',$frecuencia, set_value('conducta_frecuencia', $list[0]->conducta_frecuencia), array('id'=>'conducta_frecuencia')); ?></td>
				<td><?= form_dropdown('conducta_severidad', $severidad, set_value('conducta_severidad', $list[0]->conducta_severidad), array('id'=>'conducta_severidad')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'conducta_puntaje', 'id'=>'conducta_puntaje','value'=>set_value('conducta_puntaje', $list[0]->conducta_puntaje), 'readonly'=>'readonly')); ?></td>
				<td><?= form_dropdown('conducta_angustia', $angustia, set_value('conducta_angustia', $list[0]->conducta_angustia), array('id'=>'conducta_angustia')); ?></td>				
			</tr>
			<tr>
				<td>11</td>
				<td>Trastornos del sueño y de la Conducta</td>
				<td><?= form_dropdown('trastornos_sueno_status', $status, set_value('trastornos_sueno_status', $list[0]->trastornos_sueno_status)); ?></td>
				<td><?= form_dropdown('trastornos_sueno_frecuencia',$frecuencia, set_value('trastornos_sueno_frecuencia', $list[0]->trastornos_sueno_frecuencia), array('id'=>'trastornos_sueno_frecuencia')); ?></td>
				<td><?= form_dropdown('trastornos_sueno_severidad', $severidad, set_value('trastornos_sueno_severidad', $list[0]->trastornos_sueno_severidad), array('id'=>'trastornos_sueno_severidad')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'trastornos_sueno_puntaje', 'id'=>'trastornos_sueno_puntaje','value'=>set_value('trastornos_sueno_puntaje', $list[0]->trastornos_sueno_puntaje), 'readonly'=>'readonly')); ?></td>
				<td><?= form_dropdown('trastornos_sueno_angustia', $angustia, set_value('trastornos_sueno_angustia', $list[0]->trastornos_sueno_angustia), array('id'=>'trastornos_sueno_angustia')); ?></td>				
			</tr>
			<tr>
				<td>12</td>
				<td>Trastornos del apetito y de la alimentación</td>
				<td><?= form_dropdown('trastornos_apetito_status', $status, set_value('trastornos_apetito_status', $list[0]->trastornos_apetito_status)); ?></td>
				<td><?= form_dropdown('trastornos_apetito_frecuencia', $frecuencia, set_value('trastornos_apetito_frecuencia', $list[0]->trastornos_apetito_frecuencia), array('id'=>'trastornos_apetito_frecuencia')); ?></td>
				<td><?= form_dropdown('trastornos_apetito_severidad', $severidad, set_value('trastornos_apetito_severidad', $list[0]->trastornos_apetito_severidad), array('id'=>'trastornos_apetito_severidad')); ?></td>
				<td><?= form_input(array('type'=>'number', 'name'=>'trastornos_apetito_puntaje', 'id'=>'trastornos_apetito_puntaje','value'=>set_value('trastornos_apetito_puntaje', $list[0]->trastornos_apetito_puntaje), 'readonly'=>'readonly')); ?></td>
				<td><?= form_dropdown('trastornos_apetito_angustia', $angustia, set_value('trastornos_apetito_angustia', $list[0]->trastornos_apetito_angustia), array('id'=>'trastornos_apetito_angustia')); ?></td>				
			</tr>
			<tr>
				<td colspan='7' style='text-align:center;'>
					<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'npi_update')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
		        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
				</td>
			</tr>
		</tbody>
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
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id .'/NPI', 'Responder',array('class'=>'btn'))); ?></td>						
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
			AND strpos($_SESSION['role_options']['subject'], 'npi_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/npi_verify', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'npi_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/npi_lock', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'npi_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/npi_signature', array('class'=>'form-horizontal')); ?>    	
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