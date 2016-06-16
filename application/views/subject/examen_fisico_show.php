<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker();

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

	<?= form_open('subject/historial_medico_update', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>

	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>
	<?= form_hidden('last_status', $list[0]->status); ?>
	<?= form_hidden('id', $list[0]->id); ?>

		<table class='table table-striped table-hover table-bordered table-condensed'>
			<tr>
				<td>Fecha: </td>
				<td><?= form_input(array('type'=>'text', 'name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha',$list[0]->fecha))); ?></td>
				<td></td>
			</tr>
			<tr style='background-color:#ddd;'>
				<td></td>
				<td></td>
				<td style='font-weight:bold;'>Describa hallazgos</td>
			</tr>
			<tr>
				<td>Tiene el paciente algun hallazgo en el examen fisico: </td>
				<td>
					<?= form_radio(array('name'=>'hallazgo', 'value'=>1, 'checked'=>set_radio('hallazgo', 1, (($list[0]->hallazgo  == 1 ) ? true : false)))); ?> Si 
					<?= form_radio(array('name'=>'hallazgo', 'value'=>0, 'checked'=>set_radio('hallazgo', 0, (($list[0]->hallazgo  == 0 ) ? true : false)))); ?> No
				</td>
				<td></td>
			</tr>			
			<tr>
				<td>Cardiovascular: </td>
				<td>
					<?= form_radio(array('name'=>'cardiovascular','value'=>'1','checked'=>set_radio('cardiovascular', 1,(($list[0]->cardiovascular  == 1 ) ? true : false)  ))); ?> Si
					<?= form_radio(array('name'=>'cardiovascular','value'=>'0','checked'=>set_radio('cardiovascular', 0,(($list[0]->cardiovascular  == 0 ) ? true : false)))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'cardiovascular_desc', 'id'=>'cardiovascular_desc', 'value'=>set_value('cardiovascular_desc', $list[0]->cardiovascular_desc), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Vascular Periferico: </td>
				<td>
					<?= form_radio(array('name'=>'periferico','value'=>'1','checked'=>set_radio('periferico', 1,(($list[0]->periferico  == 1 ) ? true : false)))); ?> Si
					<?= form_radio(array('name'=>'periferico','value'=>'0','checked'=>set_radio('periferico', 0,(($list[0]->periferico  == 0 ) ? true : false)))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'periferico_desc','id'=>'periferico_desc', 'value'=>set_value('periferico_desc', $list[0]->periferico_desc), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Oidos y Garganta: </td>
				<td>
					<?= form_radio(array('name'=>'oidos','value'=>'1','checked'=>set_radio('oidos', 1,(($list[0]->oidos  == 1 ) ? true : false)))); ?> Si
					<?= form_radio(array('name'=>'oidos','value'=>'0','checked'=>set_radio('oidos', 0,(($list[0]->oidos  == 0 ) ? true : false)))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'oidos_desc','id'=>'oidos_desc', 'value'=>set_value('oidos_desc', $list[0]->oidos_desc), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Neurologico: </td>
				<td>
					<?= form_radio(array('name'=>'neurologico','value'=>'1','checked'=>set_radio('neurologico', 1,(($list[0]->neurologico  == 1 ) ? true : false)))); ?> Si
					<?= form_radio(array('name'=>'neurologico','value'=>'0','checked'=>set_radio('neurologico', 0,(($list[0]->neurologico  == 0 ) ? true : false)))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'neurologico_desc','id'=>'neurologico_desc', 'value'=>set_value('neurologico_desc', $list[0]->neurologico_desc), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Pulmones/Respiratorio: </td>
				<td>
					<?= form_radio(array('name'=>'pulmones','value'=>'1','checked'=>set_radio('pulmones', 1,(($list[0]->pulmones  == 1 ) ? true : false)))); ?> Si
					<?= form_radio(array('name'=>'pulmones','value'=>'0','checked'=>set_radio('pulmones', 0,(($list[0]->pulmones  == 0 ) ? true : false)))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'pulmones_desc','id'=>'pulmones_desc', 'value'=>set_value('pulmones_desc', $list[0]->pulmones_desc), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Renal/Urinario: </td>
				<td>
					<?= form_radio(array('name'=>'renal','value'=>'1','checked'=>set_radio('renal', 1,(($list[0]->renal  == 1 ) ? true : false)))); ?> Si
					<?= form_radio(array('name'=>'renal','value'=>'0','checked'=>set_radio('renal', 0,(($list[0]->renal  == 0 ) ? true : false)))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'renal_desc','id'=>'renal_desc', 'value'=>set_value('renal_desc', $list[0]->renal_desc), 'rows'=>3)); ?></td>
			</tr>			
			<tr>
				<td>Ginecologico: </td>
				<td>
					<?= form_radio(array('name'=>'ginecologico','value'=>'1','checked'=>set_radio('ginecologico', 1,(($list[0]->ginecologico  == 1 ) ? true : false)))); ?> Si
					<?= form_radio(array('name'=>'ginecologico','value'=>'0','checked'=>set_radio('ginecologico', 0,(($list[0]->ginecologico  == 0 ) ? true : false)))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'ginecologico_desc','id'=>'ginecologico_desc', 'value'=>set_value('ginecologico_desc', $list[0]->ginecologico_desc), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Endocrino/Metabolico: </td>
				<td>
					<?= form_radio(array('name'=>'endocrino','value'=>'1','checked'=>set_radio('endocrino', 1,(($list[0]->endocrino  == 1 ) ? true : false)))); ?> Si
					<?= form_radio(array('name'=>'endocrino','value'=>'0','checked'=>set_radio('endocrino', 0,(($list[0]->endocrino  == 0 ) ? true : false)))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'endocrino_desc','id'=>'endocrino_desc', 'value'=>set_value('endocrino_desc', $list[0]->endocrino_desc), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Hepatico: </td>
				<td>
					<?= form_radio(array('name'=>'hepatico','value'=>'1','checked'=>set_radio('hepatico', 1,(($list[0]->hepatico  == 1 ) ? true : false)))); ?> Si
					<?= form_radio(array('name'=>'hepatico','value'=>'0','checked'=>set_radio('hepatico', 0,(($list[0]->hepatico  == 0 ) ? true : false)))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'hepatico_desc','id'=>'hepatico_desc', 'value'=>set_value('hepatico_desc', $list[0]->hepatico_desc), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Gastrointestinal: </td>
				<td>
					<?= form_radio(array('name'=>'gastrointestinal','value'=>'1','checked'=>set_radio('gastrointestinal', 1,(($list[0]->gastrointestinal  == 1 ) ? true : false)))); ?> Si
					<?= form_radio(array('name'=>'gastrointestinal','value'=>'0','checked'=>set_radio('gastrointestinal', 0,(($list[0]->gastrointestinal  == 0 ) ? true : false)))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'gastrointestinal_desc','id'=>'gastrointestinal_desc', 'value'=>set_value('gastrointestinal_desc', $list[0]->gastrointestinal_desc), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Muscular/Esqueletico: </td>
				<td>
					<?= form_radio(array('name'=>'muscular','value'=>'1','checked'=>set_radio('muscular', 1,(($list[0]->muscular  == 1 ) ? true : false)))); ?> Si
					<?= form_radio(array('name'=>'muscular','value'=>'0','checked'=>set_radio('muscular', 0,(($list[0]->muscular  == 0 ) ? true : false)))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'muscular_desc','id'=>'muscular_desc', 'value'=>set_value('muscular_desc', $list[0]->muscular_desc), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Cancer: </td>
				<td>
					<?= form_radio(array('name'=>'cancer','value'=>'1','checked'=>set_radio('cancer', 1,(($list[0]->cancer  == 1 ) ? true : false)))); ?> Si
					<?= form_radio(array('name'=>'cancer','value'=>'0','checked'=>set_radio('cancer', 0,(($list[0]->cancer  == 0 ) ? true : false)))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'cancer_desc','id'=>'cancer_desc', 'value'=>set_value('cancer_desc', $list[0]->cancer_desc), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Otros: </td>
				<td></td>
				<td></td>
			</tr>			
			<tr>
				<td colspan='3' style='text-align:center;'>
					<input type='submit' class='btn btn-primary' value='Guardar'>
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
		
	</div>

