<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });	

	$('input[type=checkbox]').click(function(){

		var total = 0;

		 $('input[type=checkbox]').each(function(){
            if (this.checked) {
                total += parseInt($(this).val());
            }
        });

		$("#td_total").text(total);
		$("#total").val(total);
	});
	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_hach :input").attr('readonly','readonly');			
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_hach :input").removeAttr('readonly');			
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_hach :input").attr('readonly','readonly');		
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_hach :input").removeAttr('readonly');		
	}
});	
</script>	
	
		<legend style='text-align:center;'>Escala de Hachinski</legend>
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
	<?php if(isset($list) AND !empty($list)){  ?>	
		<!-- legend -->
		
			<!-- New Query-->
			<?php
				if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'additional_form_query_new')){
			?>
				<div id='new_query' style='text-align:right;'>
					<?= form_open('query/additional_form_query_new', array('class'=>'form-horizontal')); ?>
					<?= form_hidden('subject_id', $subject->id); ?>
					<?= form_hidden('form', "Hachinski"); ?>
					<?= form_button(array('type'=>'submit', 'content'=>'Query', 'class'=>'btn btn-primary')); ?>
					<?= form_close(); ?>
				</div>
			<?php }?>
			<!-- End Query-->

		
			<?= form_open('subject/hachinski_update', array('id'=>'form_hach')); ?>	
			
				<input type='hidden' name='total' id='total' value='<?php echo $list[0]->total; ?>' />
				<input type='hidden' name='subject_id' id='subject_id' value='<?php echo $subject->id; ?>' />
				<input type='hidden' name='id' value='<?php echo $list[0]->id; ?>' />
				<input type='hidden' name='last_status' id='last_status' value='<?php echo $subject->hachinski_status; ?>' />
				<table class="table table-condensed table-bordered table-striped table-hover">
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
					?>				
					<tr>
						<td>Realizado:</td>
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
						<td>Comienzo Brusco: </td>
						<td><?= form_checkbox(array('name'=>'comienzo_brusco','id'=>'comienzo_brusco', 'checked'=>set_checkbox('comienzo_brusco','2',($list[0]->comienzo_brusco == 2) ? true : false ), 'value'=>'2')); ?></td>
					</tr>
					
					<tr>
						<td>Deterioro escalonado: </td>						
						<td><?= form_checkbox(array('name'=>'deterioro_escalonado','id'=>'deterioro_escalonado', 'checked'=>set_checkbox('deterioro_escalonado','1',($list[0]->deterioro_escalonado == 1) ? true : false ), 'value'=>'1')); ?></td>
					</tr>
					<tr>
						<td>Curso fluctuante: </td>						
						<td><?= form_checkbox(array('name'=>'curso_fluctante','id'=>'curso_fluctante', 'checked'=>set_checkbox('curso_fluctante','2',($list[0]->curso_fluctante == 2) ? true : false ), 'value'=>'2')); ?></td>
					</tr>
					<tr>
						<td>Desorientación nocturna: </td>
						<td><?= form_checkbox(array('name'=>'desorientacion_noctura','id'=>'desorientacion_noctura', 'checked'=>set_checkbox('desorientacion_noctura','1',($list[0]->desorientacion_noctura == 1) ? true : false ), 'value'=>'1')); ?></td>						
					</tr>
					<tr>
						<td>Preservación relativa de la personalidad: </td>
						<td><?= form_checkbox(array('name'=>'preservacion_relativa','id'=>'preservacion_relativa', 'checked'=>set_checkbox('preservacion_relativa','1',($list[0]->preservacion_relativa == 1) ? true : false ), 'value'=>'1')); ?></td>												
					</tr>
					<tr>
						<td>Depresión: </td>
						<td><?= form_checkbox(array('name'=>'depresion','id'=>'depresion', 'checked'=>set_checkbox('depresion','1',($list[0]->depresion == 1) ? true : false ), 'value'=>'1')); ?></td>
					</tr>
					<tr>
						<td>Somatización: </td>
						<td><?= form_checkbox(array('name'=>'somatizacion','id'=>'somatizacion', 'checked'=>set_checkbox('somatizacion','1',($list[0]->somatizacion == 1) ? true : false ), 'value'=>'1')); ?></td>
					</tr>
					<tr>
						<td>Labilidad emocional: </td>
						<td><?= form_checkbox(array('name'=>'labilidad_emocional','id'=>'labilidad_emocional', 'checked'=>set_checkbox('labilidad_emocional','1',($list[0]->labilidad_emocional == 1) ? true : false ), 'value'=>'1')); ?></td>
					</tr>
					<tr>
						<td>Historia de HTA: </td>
						<td><?= form_checkbox(array('name'=>'hta','id'=>'hta', 'checked'=>set_checkbox('hta','1',($list[0]->hta == 1) ? true : false ), 'value'=>'1')); ?></td>						
					</tr>
					<tr>
						<td>Historia de ictus previos: </td>
						<td><?= form_checkbox(array('name'=>'ictus_previos','id'=>'ictus_previos', 'checked'=>set_checkbox('ictus_previos','2',($list[0]->ictus_previos == 2) ? true : false ), 'value'=>'2')); ?></td>
					</tr>
					<tr>
						<td>Evidencia de arteriosclerosis asociada: </td>
						<td><?= form_checkbox(array('name'=>'evidencia_arteriosclerosis','id'=>'evidencia_arteriosclerosis', 'checked'=>set_checkbox('evidencia_arteriosclerosis','1',($list[0]->evidencia_arteriosclerosis == 1) ? true : false ), 'value'=>'1')); ?></td>						
					</tr>
					<tr>
						<td>Síntomas neurológicos focales: </td>
						<td><?= form_checkbox(array('name'=>'sintomas_neurologicos','id'=>'sintomas_neurologicos', 'checked'=>set_checkbox('sintomas_neurologicos','2',($list[0]->sintomas_neurologicos == 2) ? true : false ), 'value'=>'2')); ?></td>						
					</tr>
					<tr>
						<td>Signos neurológicos focales: </td>
						<td><?= form_checkbox(array('name'=>'signos_neurologicos','id'=>'signos_neurologicos', 'checked'=>set_checkbox('signos_neurologicos','2',($list[0]->signos_neurologicos == 2) ? true : false ), 'value'=>'2')); ?></td>						
					</tr>
					<tr>
						<td><b>Puntaje Total: </b></td>
						<td style='text-align:rigth;font-weight:bold;' id='td_total'><?php echo $list[0]->total; ?></td>
					</tr>
					<tr>
						<td colspan='2' style='text-align:right;font-weight:bold;font-style:italic;'>Puntaje de isquemia de Hachinski modificada ≤ 4, según criterios de inclusión.</td>
					</tr>
					<tr>
						<td colspan='2' style='text-align:center;'>
							<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'hachinski_update')){
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
						AND strpos($_SESSION['role_options']['subject'], 'hachinski_verify') 
						AND $list[0]->status == 'Record Complete'
					){
				?>
					<?= form_open('subject/hachinski_verify', array('class'=>'form-horizontal')); ?>    	
					
					<?= form_hidden('id', $list[0]->id); ?>
					<?= form_hidden('subject_id', $subject->id); ?>
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
						AND strpos($_SESSION['role_options']['subject'], 'hachinski_lock')
						AND $list[0]->status == 'Form Approved by Monitor'){
				?>
					<?= form_open('subject/hachinski_lock', array('class'=>'form-horizontal')); ?>
					<?= form_hidden('id', $list[0]->id); ?>    	
					<?= form_hidden('subject_id', $subject->id); ?>
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
						AND strpos($_SESSION['role_options']['subject'], 'hachinski_signature')
						AND $list[0]->status == 'Form Approved and Locked'
					){
				?>
					<?= form_open('subject/hachinski_signature', array('class'=>'form-horizontal')); ?>    	
					<?= form_hidden('id', $list[0]->id); ?>    	
					<?= form_hidden('subject_id', $subject->id); ?>
					<?= form_hidden('current_status', $list[0]->status); ?>
						
					<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

					<?= form_close(); ?>

			<?php }else{
					echo "Este formulario aun no ha sido firmado";
					}
				}
			?>
			<br />
		<?php } ?>
	

