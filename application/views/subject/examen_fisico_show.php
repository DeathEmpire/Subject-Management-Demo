<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name=hallazgo]").click(function(){
		if($(this).val() == 1){
			//todos los campos habilitados.
			$("input:radio").removeAttr("readonly");
			$("input:radio").removeAttr("disabled");
		}
		else{
			//todos los campos bloqueados.
			$("input:radio").attr("readonly","readonly");
			$("input:radio").attr("disabled","disabled");			

			$("input[name=hallazgo]").removeAttr("readonly");
			$("input[name=hallazgo]").removeAttr("disabled");

		}
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

		<legend style='text-align:center;'>Examen Físico <?= (($etapa != 1 AND $etapa != 5 AND $etapa != 6) ? 'Abreviado' : ''); ?><?= $protocolo;?></legend>
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
		<?php
			if(isset($_SESSION['role_options']['query']) AND strstr($_SESSION['role_options']['query'], 'additional_form_query_new')){
				
		?>
			<div id='new_query' style='text-align:right;'>
				<?= form_open('query/additional_form_query_new' , array('class'=>'form-horizontal')); ?>		
				<?= form_hidden('subject_id', $subject->id); ?>
				<?= form_hidden('form', "Historial Medico"); ?>
				<?= form_hidden('etapa', $etapa); ?>
				<?= form_button(array('type'=>'submit', 'content'=>'Query', 'class'=>'btn btn-primary')); ?>
				<?= form_close(); ?>
			</div>
		<?php }?>
		<br />

<?php

    if(isset($list) AND !empty($list)){
?>

	<?= form_open('subject/examen_fisico_update', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>

	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>
	<?= form_hidden('last_status', $list[0]->status); ?>
	<?= form_hidden('id', $list[0]->id); ?>

		<table class='table table-striped table-hover table-bordered table-condensed'>
			<tr>
				<td>Examen f&iacute;sico realizado: </td>
				<td>
					<?= form_radio(array('name'=>'hallazgo', 'value'=>1, 'checked'=>set_radio('hallazgo', 1, (($list[0]->hallazgo  == 1 ) ? true : false)))); ?> Si 
					<?= form_radio(array('name'=>'hallazgo', 'value'=>0, 'checked'=>set_radio('hallazgo', 0, (($list[0]->hallazgo  == 0 ) ? true : false)))); ?> No
				</td>
				<td></td>
			</tr>
			<?php if($etapa == 1 OR $etapa == 5 OR $etapa == 6){ ?>
				<tr>
					<td>La fecha del examen es la misma fecha de la visita?: </td>
					<td>
						<?= form_radio(array('name'=>'misma_fecha', 'value'=>1, 'checked'=>set_radio('misma_fecha', 1, (($list[0]->misma_fecha  == 1 ) ? true : false)))); ?> Si 
						<?= form_radio(array('name'=>'misma_fecha', 'value'=>0, 'checked'=>set_radio('misma_fecha', 0, (($list[0]->misma_fecha  == 0 ) ? true : false)))); ?> No
					</td>
					<td></td>
				</tr>
			<?php } else { ?>
					<?= form_hidden('misma_fecha',0); ?>
			<?php } ?>
			
			<tr>
				<td>Fecha: </td>
				<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', ((!empty($list[0]->fecha) AND $list[0]->fecha != '0000-00-00') ? date("d/m/Y", strtotime($list[0]->fecha)) : "") ))); ?></td>
				<td></td>
			</tr>
			<tr style='background-color:#ddd;'>
				<td></td>
				<td></td>
				<td style='font-weight:bold;'>Describa hallazgos</td>
			</tr>
						
			
				<tr>
					<td>Aspecto general: </td>
					<td>
						<?= form_radio(array('name'=>'aspecto_general','value'=>'1','checked'=>set_radio('aspecto_general', 1,(($list[0]->aspecto_general  == 1 ) ? true : false)))); ?> Anormalrmal
						<?= form_radio(array('name'=>'aspecto_general','value'=>'0','checked'=>set_radio('aspecto_general', 0,(($list[0]->aspecto_general  == 0 ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'aspecto_general_desc','id'=>'aspecto_general_desc', 'value'=>set_value('aspecto_general_desc', $list[0]->aspecto_general_desc), 'rows'=>3)); ?></td>
				</tr>
			
			<tr>
				<td>Estado nutricional: </td>
				<td>
					<?= form_radio(array('name'=>'estado_nutricional','value'=>'1','checked'=>set_radio('estado_nutricional', 1,(($list[0]->estado_nutricional  == 1 ) ? true : false)))); ?> Normal
					<?= form_radio(array('name'=>'estado_nutricional','value'=>'0','checked'=>set_radio('estado_nutricional', 0,(($list[0]->estado_nutricional  == 0 ) ? true : false)))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'estado_nutricional_desc','id'=>'estado_nutricional_desc', 'value'=>set_value('renal_desc', $list[0]->estado_nutricional_desc), 'rows'=>3)); ?></td>
			</tr>
			<?php if($etapa == 1 OR $etapa == 5 OR $etapa == 6){ ?>
				<tr>
					<td>Piel: </td>
					<td>
						<?= form_radio(array('name'=>'piel','value'=>'1','checked'=>set_radio('piel', 1,(($list[0]->piel  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'piel','value'=>'0','checked'=>set_radio('piel', 0,(($list[0]->piel  == 0 ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'piel_desc','id'=>'piel_desc', 'value'=>set_value('piel_desc', $list[0]->piel_desc), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Cabeza: </td>
					<td>
						<?= form_radio(array('name'=>'cabeza','value'=>'1','checked'=>set_radio('cabeza', 1,(($list[0]->cabeza  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'cabeza','value'=>'0','checked'=>set_radio('cabeza', 0,(($list[0]->cabeza  == 0 ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'cabeza_desc','id'=>'cabeza_desc', 'value'=>set_value('cabeza_desc', $list[0]->cabeza_desc), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Ojos: </td>
					<td>
						<?= form_radio(array('name'=>'ojos','value'=>'1','checked'=>set_radio('ojos', 1,(($list[0]->ojos  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'ojos','value'=>'0','checked'=>set_radio('ojos', 0,(($list[0]->ojos  == 0 ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'ojos_desc','id'=>'ojos_desc', 'value'=>set_value('ojos_desc', $list[0]->ojos_desc), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Nariz: </td>
					<td>
						<?= form_radio(array('name'=>'nariz','value'=>'1','checked'=>set_radio('nariz', 1,(($list[0]->nariz  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'nariz','value'=>'0','checked'=>set_radio('nariz', 0,(($list[0]->nariz  == 0 ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'nariz_desc','id'=>'nariz_desc', 'value'=>set_value('nariz_desc', $list[0]->nariz_desc), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Oidos: </td>
					<td>
						<?= form_radio(array('name'=>'oidos','value'=>'1','checked'=>set_radio('oidos', 1,(($list[0]->oidos  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'oidos','value'=>'0','checked'=>set_radio('oidos', 0,(($list[0]->oidos  == 0 ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'oidos_desc','id'=>'oidos_desc', 'value'=>set_value('oidos_desc', $list[0]->oidos_desc), 'rows'=>3)); ?></td>
				</tr>			
				<tr>
					<td>Boca - Garganta: </td>
					<td>
						<?= form_radio(array('name'=>'boca','value'=>'1','checked'=>set_radio('boca', 1,(($list[0]->boca  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'boca','value'=>'0','checked'=>set_radio('boca', 0,(($list[0]->boca  == 0 ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'boca_desc','id'=>'boca_desc', 'value'=>set_value('boca_desc', $list[0]->boca_desc), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Cuello - adenopat&iacute;as: </td>
					<td>
						<?= form_radio(array('name'=>'cuello','value'=>'1','checked'=>set_radio('cuello', 1,(($list[0]->cuello  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'cuello','value'=>'0','checked'=>set_radio('cuello', 0,(($list[0]->cuello  == 0 ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'cuello_desc','id'=>'cuello_desc', 'value'=>set_value('cuello_desc', $list[0]->cuello_desc), 'rows'=>3)); ?></td>
				</tr>
			<?php } else { ?>
				<?= form_hidden('piel',''); ?>
				<?= form_hidden('piel_desc',''); ?>
				<?= form_hidden('cabeza',''); ?>
				<?= form_hidden('cabeza_desc',''); ?>
				<?= form_hidden('ojos',''); ?>
				<?= form_hidden('ojos_desc',''); ?>
				<?= form_hidden('nariz',''); ?>
				<?= form_hidden('nariz_desc',''); ?>
				<?= form_hidden('oidos',''); ?>
				<?= form_hidden('oidos_desc',''); ?>
				<?= form_hidden('boca',''); ?>
				<?= form_hidden('boca_desc',''); ?>
				<?= form_hidden('cuello',''); ?>
				<?= form_hidden('cuello_desc',''); ?>
			<?php }?>			
			<tr>
				<td>Pecho, pulm&oacute;n: </td>
				<td>
					<?= form_radio(array('name'=>'pulmones','value'=>'1','checked'=>set_radio('pulmones', 1,(($list[0]->pulmones  == 1 ) ? true : false)))); ?> Normal
					<?= form_radio(array('name'=>'pulmones','value'=>'0','checked'=>set_radio('pulmones', 0,(($list[0]->pulmones  == 0 ) ? true : false)))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'pulmones_desc','id'=>'pulmones_desc', 'value'=>set_value('pulmones_desc', $list[0]->pulmones_desc), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Card&iacute;aco: </td>
				<td>
					<?= form_radio(array('name'=>'cardiovascular','value'=>'1','checked'=>set_radio('cardiovascular', 1,(($list[0]->cardiovascular  == 1 ) ? true : false)  ))); ?> Normal
					<?= form_radio(array('name'=>'cardiovascular','value'=>'0','checked'=>set_radio('cardiovascular', 0,(($list[0]->cardiovascular  == 0 ) ? true : false)))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'cardiovascular_desc', 'id'=>'cardiovascular_desc', 'value'=>set_value('cardiovascular_desc', $list[0]->cardiovascular_desc), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Abdomen: </td>
				<td>
					<?= form_radio(array('name'=>'abdomen','value'=>'1','checked'=>set_radio('abdomen', 1,(($list[0]->abdomen  == 1 ) ? true : false)))); ?> Normal
					<?= form_radio(array('name'=>'abdomen','value'=>'0','checked'=>set_radio('abdomen', 0,(($list[0]->abdomen  == 0 ) ? true : false)))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'abdomen_desc','id'=>'abdomen_desc', 'value'=>set_value('abdomen_desc', $list[0]->abdomen_desc), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Muscular - Esquel&eacute;tico: </td>
				<td>
					<?= form_radio(array('name'=>'muscular','value'=>'1','checked'=>set_radio('muscular', 1,(($list[0]->muscular  == 1 ) ? true : false)))); ?> Normal
					<?= form_radio(array('name'=>'muscular','value'=>'0','checked'=>set_radio('muscular', 0,(($list[0]->muscular  == 0 ) ? true : false)))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'muscular_desc','id'=>'muscular_desc', 'value'=>set_value('muscular_desc', $list[0]->muscular_desc), 'rows'=>3)); ?></td>
			</tr>
			<?php if($etapa == 1 OR $etapa == 5 OR $etapa == 6){ ?>
				<tr>
					<td>Extremidades superiores: </td>
					<td>
						<?= form_radio(array('name'=>'ext_superiores','value'=>'1','checked'=>set_radio('ext_superiores', 1,(($list[0]->ext_superiores  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'ext_superiores','value'=>'0','checked'=>set_radio('ext_superiores', 0,(($list[0]->ext_superiores  == 0 ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'ext_superiores_desc','id'=>'ext_superiores_desc', 'value'=>set_value('ext_superiores_desc', $list[0]->ext_superiores_desc), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Extremidades inferiores: </td>
					<td>
						<?= form_radio(array('name'=>'ext_inferiores','value'=>'1','checked'=>set_radio('ext_inferiores', 1,(($list[0]->ext_inferiores  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'ext_inferiores','value'=>'0','checked'=>set_radio('ext_inferiores', 0,(($list[0]->ext_inferiores  == 0 ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'ext_inferiores_desc','id'=>'ext_inferiores_desc', 'value'=>set_value('ext_inferiores_desc', $list[0]->ext_inferiores_desc), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Pulsos perif&eacute;ricos: </td>
					<td>
						<?= form_radio(array('name'=>'periferico','value'=>'1','checked'=>set_radio('periferico', 1,(($list[0]->periferico  == 1 ) ? true : false)))); ?> Normal
						<?= form_radio(array('name'=>'periferico','value'=>'0','checked'=>set_radio('periferico', 0,(($list[0]->periferico  == 0 ) ? true : false)))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'periferico_desc','id'=>'periferico_desc', 'value'=>set_value('periferico_desc', $list[0]->periferico_desc), 'rows'=>3)); ?></td>
				</tr>
			<?php } else { ?>
				<?= form_hidden('ext_superiores',''); ?>
				<?= form_hidden('ext_superiores_desc',''); ?>
				<?= form_hidden('ext_inferiores',''); ?>
				<?= form_hidden('ext_inferiores_desc',''); ?>
				<?= form_hidden('periferico',''); ?>
				<?= form_hidden('periferico_desc',''); ?>
			<?php }?>			
			<tr>
				<td colspan='3' style='text-align:center;'>
					<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'examen_fisico_update')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
					<?= anchor('subject/grid/'. $subject->id, 'Volver', array('class'=>'btn')); ?>
				</td>				
			</tr>			
		</table>
	<?= form_close(); ?>

	<?php }?>

<!-- Querys -->
			<?php
				if(isset($querys) AND !empty($querys)){ ?>
					<b>Querys:</b>
					<table class="table table-condensed table-bordered table-striped">
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
										<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id, 'Responder',array('class'=>'btn'))); ?></td>						
									<?php }else{?>
										<td><?= $query->answer; ?></td>
									<?php }?>
								</tr>					
						<?php }?>	

						</tbody>
					</table>

			<?php } ?>
			<!-- Verify -->
			<b>Monitor Approve:</b><br />
				<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
					
					Este formulario fue aprobado por <?= $list[0]->verify_user;?> on <?= date("d-M-Y",strtotime($list[0]->verify_date));?>
				
				<?php
				}
				else{
				
					if(isset($_SESSION['role_options']['subject']) 
						AND strpos($_SESSION['role_options']['subject'], 'historial_medico_verify') 
						AND $list[0]->status == 'Record Complete'
					){
				?>
					<?= form_open('subject/historial_medico_verify', array('class'=>'form-horizontal')); ?>    	
					
					<?= form_hidden('id', $list[0]->id); ?>
					<?= form_hidden('subject_id', $subject->id); ?>
					<?= form_hidden('etapa', $etapa); ?>
					<?= form_hidden('current_status', $list[0]->status); ?>
						
					<?= form_button(array('type'=>'submit', 'content'=>'Aprobar Formulario', 'class'=>'btn btn-primary')); ?>

					<?= form_close(); ?>

			<?php }else{
					echo "Este formulario aun no na sido aprobado";
					}
				}
			?>
			<br />

			<!--Signature/Lock-->
			<br /><b>Lock:</b><br />
				<?php if(!empty($list[0]->lock_user) AND !empty($list[0]->lock_date)){ ?>
					
					Este formulario fue cerrado por <?= $list[0]->lock_user;?> on <?= date("d-M-Y",strtotime($list[0]->lock_date));?>
				
				<?php
				}
				else{
				
					if(isset($_SESSION['role_options']['subject']) 
						AND strpos($_SESSION['role_options']['subject'], 'historial_medico_lock')
						AND $list[0]->status == 'Form Approved by Monitor'){
				?>
					<?= form_open('subject/historial_medico_lock', array('class'=>'form-horizontal')); ?>
					<?= form_hidden('id', $list[0]->id); ?>    	
					<?= form_hidden('subject_id', $subject->id); ?>
					<?= form_hidden('etapa', $etapa); ?>
					<?= form_hidden('current_status', $list[0]->status); ?>
						
					<?= form_button(array('type'=>'submit', 'content'=>'Cerrar Formulario', 'class'=>'btn btn-primary')); ?>

					<?= form_close(); ?>

			<?php }else{
					echo "Este formulario aun no ha sido cerrado";
					}
				}
			?>
			<br />
			<!--Signature-->
				<br /><b>Signature:</b><br />
				<?php if(!empty($list[0]->signature_user) AND !empty($list[0]->signature_date)){ ?>
					
					Este formulario fue firmado por <?= $list[0]->signature_user;?> on <?= date("d-M-Y",strtotime($list[0]->signature_date));?>
				
				<?php
				}
				else{
				
					if(isset($_SESSION['role_options']['subject']) 
						AND strpos($_SESSION['role_options']['subject'], 'historial_medico_signature')
						AND $list[0]->status == 'Form Approved and Locked'
					){
				?>
					<?= form_open('subject/historial_medico_signature', array('class'=>'form-horizontal')); ?>    	
					<?= form_hidden('id', $list[0]->id); ?>    	
					<?= form_hidden('subject_id', $subject->id); ?>
					<?= form_hidden('etapa', $etapa); ?>
					<?= form_hidden('current_status', $list[0]->status); ?>
						
					<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

					<?= form_close(); ?>

			<?php }else{
					echo "Este formulario aun no ha sido firmado";
					}
				}
			?>
			<br />
		
	

