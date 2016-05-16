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
					<td><?= $subject->code; ?></td>
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
        'name'        => 'hallazgo',                
        'value'       => '1',            
        'checked'     => set_radio('hallazgo', 1),
        );
    $data2 = array(
        'name'        => 'hallazgo',                
        'value'       => '0',
        'checked'     => set_radio('hallazgo', 0),           
        );

    if(isset($list) AND !empty($list)){
?>

	<?= form_open('subject/historial_medico_update', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>

	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>
	<?= form_hidden('estado_anterior', $list[0]->estado); ?>

		<table class='table table-striped table-hover table-bordered table-condensed'>
			<tr>
				<td>Fecha: </td>
				<td><input type='text' name='fecha' id='fecha' value=''></td>
			</tr>
			<tr>
				<td>Tiene el paciente algun hallazgo en el examen fisico: </td>
				<td><?= form_radio($data); ?> Si <?= form_radio($data2); ?> No</td>
			</tr>			
			<tr>
				<td>Cardiovascular: </td>
				<td>
					<?= form_radio(array('name'=>'cardiovascular','value'=>'1','checked'=>set_radio('cardiovascular', 1))); ?> Si
					<?= form_radio(array('name'=>'cardiovascular','value'=>'0','checked'=>set_radio('cardiovascular', 0))); ?> N0
				</td>
			</tr>
			<tr>
				<td>Vascular Periferico: </td>
				<td>
					<?= form_radio(array('name'=>'periferico','value'=>'1','checked'=>set_radio('periferico', 1))); ?> Si
					<?= form_radio(array('name'=>'periferico','value'=>'0','checked'=>set_radio('periferico', 0))); ?> N0
				</td>
			</tr>
			<tr>
				<td>Oidos y Garganta: </td>
				<td>
					<?= form_radio(array('name'=>'oidos','value'=>'1','checked'=>set_radio('oidos', 1))); ?> Si
					<?= form_radio(array('name'=>'oidos','value'=>'0','checked'=>set_radio('oidos', 0))); ?> N0
				</td>
			</tr>
			<tr>
				<td>Neurologico: </td>
				<td>
					<?= form_radio(array('name'=>'neurologico','value'=>'1','checked'=>set_radio('neurologico', 1))); ?> Si
					<?= form_radio(array('name'=>'neurologico','value'=>'0','checked'=>set_radio('neurologico', 0))); ?> N0
				</td>
			</tr>
			<tr>
				<td>Pulmones/Respiratorio: </td>
				<td>
					<?= form_radio(array('name'=>'pulmones','value'=>'1','checked'=>set_radio('pulmones', 1))); ?> Si
					<?= form_radio(array('name'=>'pulmones','value'=>'0','checked'=>set_radio('pulmones', 0))); ?> N0
				</td>
			</tr>
			<tr>
				<td>Renal/Urinario: </td>
				<td>
					<?= form_radio(array('name'=>'renal','value'=>'1','checked'=>set_radio('renal', 1))); ?> Si
					<?= form_radio(array('name'=>'renal','value'=>'0','checked'=>set_radio('renal', 0))); ?> N0
				</td>
			</tr>			
			<tr>
				<td>Ginecologico: </td>
				<td>
					<?= form_radio(array('name'=>'ginecologico','value'=>'1','checked'=>set_radio('ginecologico', 1))); ?> Si
					<?= form_radio(array('name'=>'ginecologico','value'=>'0','checked'=>set_radio('ginecologico', 0))); ?> N0
				</td>
			</tr>
			<tr>
				<td>Endocrino/Metabolico: </td>
				<td>
					<?= form_radio(array('name'=>'endocrino','value'=>'1','checked'=>set_radio('endocrino', 1))); ?> Si
					<?= form_radio(array('name'=>'endocrino','value'=>'0','checked'=>set_radio('endocrino', 0))); ?> N0
				</td>
			</tr>
			<tr>
				<td>Hepatico: </td>
				<td>
					<?= form_radio(array('name'=>'hepatico','value'=>'1','checked'=>set_radio('hepatico', 1))); ?> Si
					<?= form_radio(array('name'=>'hepatico','value'=>'0','checked'=>set_radio('hepatico', 0))); ?> N0
				</td>
			</tr>
			<tr>
				<td>Gastrointestinal: </td>
				<td>
					<?= form_radio(array('name'=>'gastrointestinal','value'=>'1','checked'=>set_radio('gastrointestinal', 1))); ?> Si
					<?= form_radio(array('name'=>'gastrointestinal','value'=>'0','checked'=>set_radio('gastrointestinal', 0))); ?> N0
				</td>
			</tr>
			<tr>
				<td>Muscular/Esqueletico: </td>
				<td>
					<?= form_radio(array('name'=>'muscular','value'=>'1','checked'=>set_radio('muscular', 1))); ?> Si
					<?= form_radio(array('name'=>'muscular','value'=>'0','checked'=>set_radio('muscular', 0))); ?> N0
				</td>
			</tr>
			<tr>
				<td>Cancer: </td>
				<td>
					<?= form_radio(array('name'=>'cancer','value'=>'1','checked'=>set_radio('cancer', 1))); ?> Si
					<?= form_radio(array('name'=>'cancer','value'=>'0','checked'=>set_radio('cancer', 0))); ?> N0
				</td>
			</tr>
			<tr>
				<td>Otros: </td>
				<td></td>
			</tr>			
			<tr>
				<td colspan='2' style='text-align:center;'><input type='submit' class='btn btn-primary' value='Enviar'></td>				
			</tr>			
		</table>
	<?= form_close(); ?>

	<?php }?>
</div>
<!-- Querys -->
			<?php
				if(isset($querys) AND !empty($querys)){ ?>
					<b>Querys:</b>
					<table class="table table-condensed table-bordered table-striped">
						<thead>
							<tr>
								<th>Date of Query</th>
								<th>User</th>
								<th>Question</th>
								<th>Date of Answer</th>
								<th>User</th>
								<th>Answer</th>					
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
										if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'hachinski_query_show')){
									?>
										<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id, 'Add',array('class'=>'btn'))); ?></td>						
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
						AND $subject->demography_status == 'Record Complete'
					){
				?>
					<?= form_open('subject/historial_medico_verify', array('class'=>'form-horizontal')); ?>    	
					
					<?= form_hidden('id', $list[0]->id); ?>
					<?= form_hidden('subject_id', $subject->id); ?>
					<?= form_hidden('etapa', $etapa); ?>
					<?= form_hidden('current_status', $subject->hachinski_status); ?>
						
					<?= form_button(array('type'=>'submit', 'content'=>'Aprovar Formulario', 'class'=>'btn btn-primary')); ?>

					<?= form_close(); ?>

			<?php }else{
					echo "Este formulario aun no na sido aprovado";
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
						AND $subject->demography_status == 'Form Approved by Monitor'){
				?>
					<?= form_open('subject/historial_medico_lock', array('class'=>'form-horizontal')); ?>
					<?= form_hidden('id', $list[0]->id); ?>    	
					<?= form_hidden('subject_id', $subject->id); ?>
					<?= form_hidden('etapa', $etapa); ?>
					<?= form_hidden('current_status', $subject->hachinski_status); ?>
						
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
						AND $subject->demography_status == 'Form Approved and Locked'
					){
				?>
					<?= form_open('subject/historial_medico_signature', array('class'=>'form-horizontal')); ?>    	
					<?= form_hidden('id', $list[0]->id); ?>    	
					<?= form_hidden('subject_id', $subject->id); ?>
					<?= form_hidden('etapa', $etapa); ?>
					<?= form_hidden('current_status', $subject->hachinski_status); ?>
						
					<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

					<?= form_close(); ?>

			<?php }else{
					echo "Este formulario aun no ha sido firmado";
					}
				}
			?>
			<br />
		<?php } ?>
	</div>

