<script src="<?= base_url('js/historial_medico.js') ?>"></script>
<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">

</script>
<div class="row">
		<legend style='text-align:center;'>Historia Medica</legend>
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

	<?= form_open('subject/historial_medico_update', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>

	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>
	<?= form_hidden('id', $list[0]->id); ?>

	<table class='table table-striped table-hover table-bordered table-condensed'>		
		<thead>
			<tr>
				<td colspan='2' style='font-weight:bold;'>1.- ANTECEDENTES DEL SUJETO</td>			
				<td style='font-weight:bold;'>FECHA DIAGNOSTICO</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Hipertensión arterial:</td>
				<td>
					<?= form_radio('hipertension',1,set_radio('hipertension', 1,(($list[0]->hipertension == 1) ? true : false) ));?> SI
					<?= form_radio('hipertension',0,set_radio('hipertension', 0,(($list[0]->hipertension == "0") ? true : false)));?> NO
				</td>
				<td><?= form_input(array('type'=>'text', 'name'=>'hipertension_fecha_diagnostico', 'id'=>'hipertension_fecha_diagnostico', 'value'=>set_value('hipertension_fecha_diagnostico', $list[0]->hipertension_fecha_diagnostico))); ?></td>
			</tr>
			<tr>
				<td>Úlcera gastrointestinal: </td>
				<td>
					<?= form_radio('ulcera',1,set_radio('ulcera', 1,(($list[0]->ulcera == 1) ? true : false)));?> SI
					<?= form_radio('ulcera',0,set_radio('ulcera', 0,(($list[0]->ulcera == "0") ? true : false)));?> NO
				</td>
				<td><?= form_input(array('type'=>'text', 'name'=>'ulcera_fecha_diagnostico', 'id'=>'ulcera_fecha_diagnostico', 'value'=>set_value('ulcera_fecha_diagnostico', $list[0]->ulcera_fecha_diagnostico))); ?></td>
			</tr>
			<tr>
				<td>Diabetes mellitus: </td>
				<td>
					<?= form_radio('diabetes',1,set_radio('diabetes', 1,(($list[0]->diabetes == 1) ? true : false)));?> SI
					<?= form_radio('diabetes',0,set_radio('diabetes', 0,(($list[0]->diabetes == "0") ? true : false)));?> NO
				</td>
				<td><?= form_input(array('type'=>'text', 'name'=>'diabetes_fecha_diagnostico', 'id'=>'diabetes_fecha_diagnostico', 'value'=>set_value('diabetes_fecha_diagnostico', $list[0]->diabetes_fecha_diagnostico))); ?></td>
			</tr>
			<tr>
				<td>Hipo/Hipertiroidismo: </td>
				<td>
					<?= form_radio('hipo_hipertiroidismo',1,set_radio('hipo_hipertiroidismo', 1,(($list[0]->hipo_hipertiroidismo == 1) ? true : false)));?> SI
					<?= form_radio('hipo_hipertiroidismo',0,set_radio('hipo_hipertiroidismo', 0,(($list[0]->hipo_hipertiroidismo == "0") ? true : false)));?> NO
				</td>
				<td><?= form_input(array('type'=>'text', 'name'=>'hipo_hipertiroidismo_fecha_diagnostico', 'id'=>'hipo_hipertiroidismo_fecha_diagnostico', 'value'=>set_value('hipo_hipertiroidismo_fecha_diagnostico', $list[0]->hipo_hipertiroidismo_fecha_diagnostico))); ?></td>
			</tr>
			<tr>
				<td>Hiperlipidemia:</td>
				<td>
					<?= form_radio('hiperlipidemia',1,set_radio('hiperlipidemia', 1,(($list[0]->hiperlipidemia == 1) ? true : false)));?> SI
					<?= form_radio('hiperlipidemia',0,set_radio('hiperlipidemia', 0,(($list[0]->hiperlipidemia == "0") ? true : false)));?> NO
				</td>
				<td><?= form_input(array('type'=>'text', 'name'=>'hiperlipidemia_fecha_diagnostico', 'id'=>'hiperlipidemia_fecha_diagnostico', 'value'=>set_value('hiperlipidemia_fecha_diagnostico', $list[0]->hiperlipidemia_fecha_diagnostico))); ?></td>
			</tr>
			<tr>
				<td>EPOC</td>
				<td>
					<?= form_radio('epoc',1,set_radio('epoc', 1,(($list[0]->epoc == 1) ? true : false)));?> SI
					<?= form_radio('epoc',0,set_radio('epoc', 0,(($list[0]->epoc == "0") ? true : false)));?> NO
				</td>
				<td><?= form_input(array('type'=>'text', 'name'=>'epoc_fecha_diagnostico', 'id'=>'epoc_fecha_diagnostico', 'value'=>set_value('epoc_fecha_diagnostico', $list[0]->epoc_fecha_diagnostico))); ?></td>
			</tr>
			<tr>
				<td>Enfermedad coronaria:</td>
				<td>
					<?= form_radio('coronaria',1,set_radio('coronaria', 1,(($list[0]->coronaria == 1) ? true : false)));?> SI
					<?= form_radio('coronaria',0,set_radio('coronaria', 0,(($list[0]->coronaria == "0") ? true : false)));?> NO
				</td>
				<td><?= form_input(array('type'=>'text', 'name'=>'coronaria_fecha_diagnostico', 'id'=>'coronaria_fecha_diagnostico', 'value'=>set_value('coronaria_fecha_diagnostico', $list[0]->coronaria_fecha_diagnostico))); ?></td>
			</tr>
			<tr>
				<td>Rinitis:</td>
				<td>
					<?= form_radio('rinitis',1,set_radio('rinitis', 1,(($list[0]->rinitis == 1) ? true : false)));?> SI
					<?= form_radio('rinitis',0,set_radio('rinitis', 0,(($list[0]->rinitis == "0") ? true : false)));?> NO
				</td>
				<td><?= form_input(array('type'=>'text', 'name'=>'rinitis_fecha_diagnostico', 'id'=>'rinitis_fecha_diagnostico', 'value'=>set_value('rinitis_fecha_diagnostico', $list[0]->rinitis_fecha_diagnostico))); ?></td>
			</tr>
			<tr>
				<td>Accidente vascular encefálico:</td>
				<td>
					<?= form_radio('acc_vascular',1,set_radio('acc_vascular', 1,(($list[0]->acc_vascular == 1) ? true : false)));?> SI
					<?= form_radio('acc_vascular',0,set_radio('acc_vascular', 0,(($list[0]->acc_vascular == "0") ? true : false)));?> NO
				</td>
				<td><?= form_input(array('type'=>'text', 'name'=>'acc_vascular_fecha_diagnostico', 'id'=>'acc_vascular_fecha_diagnostico', 'value'=>set_value('acc_vascular_fecha_diagnostico', $list[0]->acc_vascular_fecha_diagnostico))); ?></td>
			</tr>
			<tr>
				<td>Asma:</td>
				<td>
					<?= form_radio('asma',1,set_radio('asma', 1,(($list[0]->asma == 1) ? true : false)));?> SI
					<?= form_radio('asma',0,set_radio('asma', 0,(($list[0]->asma == "0") ? true : false)));?> NO
				</td>
				<td><?= form_input(array('type'=>'text', 'name'=>'asma_fecha_diagnostico', 'id'=>'asma_fecha_diagnostico', 'value'=>set_value('asma_fecha_diagnostico', $list[0]->asma_fecha_diagnostico))); ?></td>
			</tr>
			<tr>
				<td>Gastritis/Reflujo GE:</td>
				<td>
					<?= form_radio('gastritis',1,set_radio('gastritis', 1,(($list[0]->gastritis == 1) ? true : false)));?> SI
					<?= form_radio('gastritis',0,set_radio('gastritis', 0,(($list[0]->gastritis == "0") ? true : false)));?> NO
				</td>
				<td><?= form_input(array('type'=>'text', 'name'=>'gastritis_fecha_diagnostico', 'id'=>'gastritis_fecha_diagnostico', 'value'=>set_value('gastritis_fecha_diagnostico', $list[0]->gastritis_fecha_diagnostico))); ?></td>
			</tr>
			<tr>
				<td>Cefaleas matinales:</td>
				<td>
					<?= form_radio('cefaleas',1,set_radio('cefaleas', 1,(($list[0]->cefaleas == 1) ? true : false)));?> SI
					<?= form_radio('cefaleas',0,set_radio('cefaleas', 0,(($list[0]->cefaleas == "0") ? true : false)));?> NO
				</td>
				<td><?= form_input(array('type'=>'text', 'name'=>'cefaleas_fecha_diagnostico', 'id'=>'cefaleas_fecha_diagnostico', 'value'=>set_value('cefaleas_fecha_diagnostico', $list[0]->cefaleas_fecha_diagnostico))); ?></td>
			</tr>
			<tr>
				<td colspan='2' style='background-color:#ccc;'></td>
				<td style='font-weight:bold;background-color:#ccc;'>Describir</td>
			</tr>
			<tr>
				<td>Alergias:</td>
				<td>
					<?= form_radio('alergia',1,set_radio('alergia', 1,(($list[0]->alergia == 1) ? true : false)));?> SI
					<?= form_radio('alergia',0,set_radio('alergia', 0,(($list[0]->alergia == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'alergia_desc', 'id'=>'alergia_desc', 'value'=>set_value('alergia_desc', $list[0]->alergia_desc), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>Tabaquismo (cantidad):</td>
				<td>
					<?= form_radio('tabaquismo',1,set_radio('tabaquismo', 1,(($list[0]->tabaquismo == 1) ? true : false)));?> SI
					<?= form_radio('tabaquismo',0,set_radio('tabaquismo', 0,(($list[0]->tabaquismo == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'tabaquismo_desc', 'id'=>'tabaquismo_desc', 'value'=>set_value('tabaquismo_desc', $list[0]->tabaquismo_desc), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>Ingesta de Alcohol:</td>
				<td>
					<?= form_radio('ingesta_alcohol',1,set_radio('ingesta_alcohol', 1,(($list[0]->ingesta_alcohol == 1) ? true : false)));?> SI
					<?= form_radio('ingesta_alcohol',0,set_radio('ingesta_alcohol', 0,(($list[0]->ingesta_alcohol == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'ingesta_alcohol_desc', 'id'=>'ingesta_alcohol_desc', 'value'=>set_value('ingesta_alcohol_desc', $list[0]->ingesta_alcohol_desc), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>Consumo de Drogas de abuso:</td>
				<td>
					<?= form_radio('drogas',1,set_radio('drogas', 1,(($list[0]->drogas == 1) ? true : false)));?> SI
					<?= form_radio('drogas',0,set_radio('drogas', 0,(($list[0]->drogas == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'drogas_desc', 'id'=>'drogas_desc', 'value'=>set_value('drogas_desc', $list[0]->drogas_desc), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>¿Ha tenido alguna intervención quirúrgica y/o cirugía?</td>
				<td>
					<?= form_radio('cirugia',1,set_radio('cirugia', 1,(($list[0]->cirugia == 1) ? true : false)));?> SI
					<?= form_radio('cirugia',0,set_radio('cirugia', 0,(($list[0]->cirugia == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'cirugia_desc', 'id'=>'cirugia_desc', 'value'=>set_value('cirugia_desc', $list[0]->cirugia_desc), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>¿Ha donado sangre o ha participado en algún estudio clínico farmacológico en los últimos tres meses?</td>
				<td>
					<?= form_radio('donado_sangre',1,set_radio('donado_sangre', 1,(($list[0]->donado_sangre == 1) ? true : false)));?> SI
					<?= form_radio('donado_sangre',0,set_radio('donado_sangre', 0,(($list[0]->donado_sangre == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'donado_sangre_desc', 'id'=>'donado_sangre_desc', 'value'=>set_value('donado_sangre_desc', $list[0]->donado_sangre_desc), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>¿Está recibiendo o ha recibido en el último mes, algún tratamiento farmacológico?</td>
				<td>
					<?= form_radio('tratamiento_farma',1,set_radio('tratamiento_farma', 1,(($list[0]->tratamiento_farma == 1) ? true : false)));?> SI
					<?= form_radio('tratamiento_farma',0,set_radio('tratamiento_farma', 0,(($list[0]->tratamiento_farma == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'tratamiento_farma_desc', 'id'=>'tratamiento_farma_desc', 'value'=>set_value('tratamiento_farma_desc', $list[0]->tratamiento_farma_desc), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>¿Está recibiendo o ha recibido en el último mes, algún suplemento dietético o vitamínico?</td>
				<td>
					<?= form_radio('suplemento_dietetico',1,set_radio('suplemento_dietetico', 1,(($list[0]->suplemento_dietetico == 1) ? true : false)));?> SI
					<?= form_radio('suplemento_dietetico',0,set_radio('suplemento_dietetico', 0,(($list[0]->suplemento_dietetico == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'suplemento_dietetico_desc', 'id'=>'suplemento_dietetico_desc', 'value'=>set_value('suplemento_dietetico_desc', $list[0]->suplemento_dietetico_desc), 'rows'=>'5')); ?></td>
			</tr>		
			<tr>
				<td>2.- ANTECEDENTES FAMILIARES DE ALZHEIMER (padre, madre, hermanos): </td>
				<td>
					<?= form_radio('alzheimer',1,set_radio('alzheimer', 1,(($list[0]->alzheimer == 1) ? true : false)));?> SI
					<?= form_radio('alzheimer',0,set_radio('alzheimer', 0,(($list[0]->alzheimer == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'alzheimer_desc', 'id'=>'alzheimer_desc', 'value'=>set_value('alzheimer_desc', $list[0]->alzheimer_desc), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>3.- FECHA EN QUE PRESENTÓ PRIMEROS SÍNTOMAS ASOCIADOS A LA EA</td>				
				<td>Año: </td>
				<td><?= form_input(array('type'=>'number', 'name'=>'fecha_ea', 'id'=>'fecha_ea', 'value'=>set_value('fecha_ea', $list[0]->fecha_ea), 'masxlenght'=>'4')); ?></td>
			</tr>
			<tr>
				<td>4.- ANTECEDENTES MORBIDOS FAMILIARES (padre, madre, hermanos):</td>
				<td>
					<?= form_radio('morbido',1,set_radio('morbido', 1,(($list[0]->morbido == 1) ? true : false)));?> SI
					<?= form_radio('morbido',0,set_radio('morbido', 0,(($list[0]->morbido == "0") ? true : false)));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'morbido_desc', 'id'=>'morbido_desc', 'value'=>set_value('morbido_desc', $list[0]->morbido_desc), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>Observaciones (Opcional)</td>
				<td colspan='2'><?= form_textarea(array('type'=>'textarea', 'name'=>'obervaciones', 'id'=>'obervaciones', 'value'=>set_value('obervaciones', $list[0]->obervaciones), 'rows'=>'10', 'cols'=>'60', 'style'=>'width:98%;')); ?></td>
			</tr>
			<tr>
				<td colspan='3' style='text-align:center;'>
					<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'historial_medico_update')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
					<?= anchor('subject/grid/'. $subject->id, 'Volver', array('class'=>'btn')); ?>
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
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id .'/Historial Medico', 'Responder',array('class'=>'btn'))); ?></td>						
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
			AND strpos($_SESSION['role_options']['subject'], 'historial_medico_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/historial_medico_verify', array('class'=>'form-horizontal')); ?>    	
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

<!--Lock-->
<br /><b>Cierre:</b><br />
	<?php if(!empty($list[0]->lock_user) AND !empty($list[0]->lock_date)){ ?>
		
		Formulario cerrado por <?= $list[0]->lock_user;?> el <?= date("d-M-Y",strtotime($list[0]->lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'historial_medico_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/historial_medico_lock', array('class'=>'form-horizontal')); ?>    	
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
			AND strpos($_SESSION['role_options']['subject'], 'historial_medico_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/historial_medico_signature', array('class'=>'form-horizontal')); ?>    	
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