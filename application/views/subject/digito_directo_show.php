<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker();

	$('select[name^=puntaje_item]').change(function(){

		var total = 0;

		 $('select[name^=puntaje_item]').each(function(){
            if ($(this).val() != '') {
                total += parseInt($(this).val());
            }
        });
		
		$("#segundo_puntaje").html("<b>: "+total+"</b>");
	});

	$('select[name^=puntaje_intento]').change(function(){

		var total = 0;

		 $('select[name^=puntaje_intento]').each(function(){
            if ($(this).val() != '') {
                total += parseInt($(this).val());
            }
        });
		
		$("#primer_puntaje").html(total);
	});

	var total1 = 0;
	 $('select[name^=puntaje_item]').each(function(){
        if ($(this).val() != '') {
            total1 += parseInt($(this).val());
        }
    });	
	$("#segundo_puntaje").html("<b>: "+total1+"</b>");

	var total2 = 0;
	 $('select[name^=puntaje_intento]').each(function(){
        if ($(this).val() != '') {
            total2 += parseInt($(this).val());
        }
    });	
	$("#primer_puntaje").html(total2);

});
</script>
<div class="row">
	<legend style='text-align:center;'>Prueba de Digito Directo</legend>
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
			if(isset($_SESSION['role_options']['query']) AND strstr($_SESSION['role_options']['query'], 'additional_form_query_new')){
					
			?>
				<div id='new_query' style='text-align:right;'>
					<?= form_open('query/additional_form_query_new' , array('class'=>'form-horizontal')); ?>		
					<?= form_hidden('subject_id', $subject->id); ?>
					<?= form_hidden('form', "Digito Directo"); ?>
					<?= form_hidden('etapa', $etapa); ?>
					<?= form_button(array('type'=>'submit', 'content'=>'Nueva Consulta', 'class'=>'btn btn-primary')); ?>
					<?= form_close(); ?>
				</div>
			<?php }?>
	<!-- legend -->

	<?= form_open('subject/digito_directo_update', array('class'=>'form-horizontal')); ?>
		
		<?= my_validation_errors(validation_errors()); ?>
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('etapa', $etapa); ?>
		<?= form_hidden('id', $list[0]->id); ?>
			
			<?php
				$realizado = array(
				    'name'        => 'realizado',
				    'id'          => 'realizado',
				    'value'       => '1',
				    'checked'     => set_checkbox('realizado','1', (($list[0]->realizado == 1) ? true : false))
			    );
			?>

			No Realizado: <?= form_checkbox($realizado);?><br />
			Fecha: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha', $list[0]->fecha))); ?>


			<table class='table table-striped table-hover table-bordered table-condensed'>
				<tr>
					<th></th>
					<th>Item</th>
					<th>Intento</th>
					<th>Respuesta</th>
					<th>Puntaje Intento</th>
					<th>Puntaje Item</th>
				</tr>

				<tr>
					<td rowspan='16'>-></td>
					<td rowspan='2'>1</td>
					<td>9-7</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_1a',$valores_intento,set_value('puntaje_intento_1a', $list[0]->puntaje_intento_1a)); ?></td>
					<td><?= form_dropdown('puntaje_item_1a',$valores_item, set_value('puntaje_item_1a', $list[0]->puntaje_item_1a)); ?></td>
				</tr>
				<tr>				
					<td>6-3</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_1b',$valores_intento, set_value('puntaje_intento_1b', $list[0]->puntaje_intento_1b)); ?></td>
					<td><?= form_dropdown('puntaje_item_1b',$valores_item, set_value('puntaje_item_1b', $list[0]->puntaje_item_1b)); ?></td>
				</tr>
				<tr>				
					<td rowspan='2'>2</td>
					<td>5-8-2</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_2a',$valores_intento, set_value('puntaje_intento_2a', $list[0]->puntaje_intento_2a)); ?></td>
					<td><?= form_dropdown('puntaje_item_2a',$valores_item, set_value('puntaje_item_2a', $list[0]->puntaje_item_2a)); ?></td>
				</tr>
				<tr>
					<td>6-9-4</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_2b',$valores_intento, set_value('puntaje_intento_2b', $list[0]->puntaje_intento_2b)); ?></td>
					<td><?= form_dropdown('puntaje_item_2b',$valores_item, set_value('puntaje_item_2b', $list[0]->puntaje_item_2b)); ?></td>
				</tr>
				<tr>
					<td rowspan='2'>3</td>
					<td>7-2-8-6</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_3a',$valores_intento, set_value('puntaje_intento_3a', $list[0]->puntaje_intento_3a)); ?></td>
					<td><?= form_dropdown('puntaje_item_3a',$valores_item, set_value('puntaje_item_3a', $list[0]->puntaje_item_3a)); ?></td>
				</tr>
				<tr>
					<td>6-4-3-9</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_3b',$valores_intento, set_value('puntaje_intento_3b', $list[0]->puntaje_intento_3b)); ?></td>
					<td><?= form_dropdown('puntaje_item_3b',$valores_item, set_value('puntaje_item_3b', $list[0]->puntaje_item_3b)); ?></td>
				</tr>
				<tr>
					<td rowspan='2'>4</td>
					<td>4-2-7-3-1</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_4a',$valores_intento, set_value('puntaje_intento_4a', $list[0]->puntaje_intento_4a)); ?></td>
					<td><?= form_dropdown('puntaje_item_4a',$valores_item, set_value('puntaje_item_4a', $list[0]->puntaje_item_4a)); ?></td>
				</tr>
				<tr>
					<td>7-5-8-3-6</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_4b',$valores_intento, set_value('puntaje_intento_4b', $list[0]->puntaje_intento_4b)); ?></td>
					<td><?= form_dropdown('puntaje_item_4b',$valores_item, set_value('puntaje_item_4b', $list[0]->puntaje_item_4b)); ?></td>
				</tr>
				<tr>
					<td rowspan='2'>5</td>
					<td>3-9-2-4-8-7</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_5a',$valores_intento, set_value('puntaje_intento_5a', $list[0]->puntaje_intento_5a)); ?></td>
					<td><?= form_dropdown('puntaje_item_5a',$valores_item, set_value('puntaje_item_5a', $list[0]->puntaje_item_5a)); ?></td>
				</tr>
				<tr>
					<td>6-1-9-4-7-3</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_5b',$valores_intento, set_value('puntaje_intento_5b', $list[0]->puntaje_intento_5b)); ?></td>
					<td><?= form_dropdown('puntaje_item_5b',$valores_item, set_value('puntaje_item_5b', $list[0]->puntaje_item_5b)); ?></td>
				</tr>
				<tr>
					<td rowspan='2'>6</td>
					<td>4-1-7-9-3-8-6</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_6a',$valores_intento, set_value('puntaje_intento_6a', $list[0]->puntaje_intento_6a)); ?></td>
					<td><?= form_dropdown('puntaje_item_6a',$valores_item, set_value('puntaje_item_6a', $list[0]->puntaje_item_6a)); ?></td>
				</tr>
				<tr>
					<td>6-9-1-7-4-2-8</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_6b',$valores_intento, set_value('puntaje_intento_6b', $list[0]->puntaje_intento_6b)); ?></td>
					<td><?= form_dropdown('puntaje_item_6b',$valores_item, set_value('puntaje_item_6b', $list[0]->puntaje_item_6b)); ?></td>
				</tr>
				<tr>
					<td rowspan='2'>7</td>
					<td>3-8-2-9-6-1-7-4</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_7a',$valores_intento, set_value('puntaje_intento_7a', $list[0]->puntaje_intento_7a)); ?></td>
					<td><?= form_dropdown('puntaje_item_7a',$valores_item, set_value('puntaje_item_7a', $list[0]->puntaje_item_7a)); ?></td>
				</tr>
				<tr>
					<td>5-8-1-3-2-6-4-7</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_7b',$valores_intento, set_value('puntaje_intento_7b', $list[0]->puntaje_intento_7b)); ?></td>
					<td><?= form_dropdown('puntaje_item_7b',$valores_item, set_value('puntaje_item_7b', $list[0]->puntaje_item_7b)); ?></td>
				</tr>
				<tr>
					<td rowspan='2'>8</td>
					<td>2-7-5-8-6-3-1-9-4</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_8a',$valores_intento, set_value('puntaje_intento_8a', $list[0]->puntaje_intento_8a)); ?></td>
					<td><?= form_dropdown('puntaje_item_8a',$valores_item, set_value('puntaje_item_8a', $list[0]->puntaje_item_8a)); ?></td>
				</tr>
				<tr>
					<td>7-1-3-9-4-2-5-6-8</td>
					<td></td>
					<td><?= form_dropdown('puntaje_intento_8b',$valores_intento, set_value('puntaje_intento_8b', $list[0]->puntaje_intento_8b)); ?></td>
					<td><?= form_dropdown('puntaje_item_8b',$valores_item, set_value('puntaje_item_8b', $list[0]->puntaje_item_8b)); ?></td>
				</tr>		
				<tr>
					<td colspan='4' style='text-align:right;'>MSDD<br><small>(Maximo = 9)</small></td>
					<td id='primer_puntaje' style='font-weight:bold;text-align:center;'></td>
					<td style='text-align:left;'>Dígitos Orden Directo (DOD)<br>Puntaje Bruto Total<span id='segundo_puntaje'></span><br><small>(Maximo = 16)</small></td>							
				</tr>
				<tr>
					<td colspan='6' style='text-align:center;'>
					<?= form_button(array('type'=>'submit', 'content'=>'Enviar', 'class'=>'btn btn-primary')); ?>
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
									<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id .'/Digito Directo', 'Responder',array('class'=>'btn'))); ?></td>						
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
					AND strpos($_SESSION['role_options']['subject'], 'digito_directo_verify') 
					AND $list[0]->status == 'Record Complete'
				){
			?>
				<?= form_open('subject/digito_directo_verify', array('class'=>'form-horizontal')); ?>    	
				
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
					AND strpos($_SESSION['role_options']['subject'], 'digito_directo_lock')
					AND $list[0]->status == 'Form Approved by Monitor'){
			?>
				<?= form_open('subject/digito_directo_lock', array('class'=>'form-horizontal')); ?>
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
					AND strpos($_SESSION['role_options']['subject'], 'digito_directo_signature')
					AND $list[0]->status == 'Form Approved and Locked'
				){
			?>
				<?= form_open('subject/digito_directo_signature', array('class'=>'form-horizontal')); ?>    	
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