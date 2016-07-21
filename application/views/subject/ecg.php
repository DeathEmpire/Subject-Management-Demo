<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_ecg :input").attr('readonly','readonly');
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});			
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_ecg :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled', 'disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_ecg :input").attr('readonly','readonly');
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_ecg :input").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled', 'disabled');
		});
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
<legend style='text-align:center;'>Electrocardiograma de reposo (ECG) <?= $protocolo;?></legend>
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

<?= form_open('subject/ecg_insert', array('class'=>'form-horizontal','id'=>'form_ecg')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
		
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
	
		Realizado:
		<?= form_radio($data,$data['value'],set_radio($data['name'], 1)); ?> Si
		<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
		<br />
		Fecha: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?>


		<table class='table table-striped table-hover table-bordered table-condensed'>
			<thead>
				<tr>
					<th></th>
					<th></th>
					<th></th>
					<th>Normal - Anormal</th>				
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Ritmo Sinusal</td>
					<td><?= form_radio('ritmo_sinusal', 1, set_radio('ritmo_sinusal', 1)); ?> Si</td>
					<td><?= form_radio('ritmo_sinusal', 0, set_radio('ritmo_sinusal', 0)); ?> No</td>
					<td>
						<?= form_radio('ritmo_sinusal_normal_anormal', 1, set_radio('ritmo_sinusal_normal_anormal', 1)); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('ritmo_sinusal_normal_anormal', 0, set_radio('ritmo_sinusal_normal_anormal', 0)); ?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>Resultado</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>FC</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'fc', 'id'=>'fc', 'value'=>set_value('fc'))); ?></td>
					<td>Lat/min</td>
					<td>
						<?= form_radio('fc_normal_anormal', 1, set_radio('fc_normal_anormal', 1)); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('fc_normal_anormal', 0, set_radio('fc_normal_anormal', 0)); ?>
					</td>
				</tr>
				<tr>
					<td>PR</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'pr', 'id'=>'pr', 'value'=>set_value('pr'))); ?></td>
					<td>ms</td>
					<td>
						<?= form_radio('pr_normal_anormal', 1, set_radio('pr_normal_anormal', 1)); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('pr_normal_anormal', 0, set_radio('pr_normal_anormal', 0)); ?>
					</td>
				</tr>
				<tr>
					<td>QRS</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'qrs', 'id'=>'qrs', 'value'=>set_value('qrs'))); ?></td>
					<td>ms</td>
					<td>
						<?= form_radio('qrs_normal_anormal', 1, set_radio('qrs_normal_anormal', 1)); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('qrs_normal_anormal', 0, set_radio('qrs_normal_anormal', 0)); ?>
					</td>
				</tr>
				<tr>
					<td>QT</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'qt', 'id'=>'qt', 'value'=>set_value('qt'))); ?></td>
					<td>ms</td>
					<td>
						<?= form_radio('qt_normal_anormal', 1, set_radio('qt_normal_anormal', 1)); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('qt_normal_anormal', 0, set_radio('qt_normal_anormal', 0)); ?>
					</td>
				</tr>
				<tr>
					<td>QTc</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'qtc', 'id'=>'qtc', 'value'=>set_value('qtc'))); ?></td>
					<td>ms</td>
					<td>
						<?= form_radio('qtc_normal_anormal', 1, set_radio('qtc_normal_anormal', 1)); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('qtc_normal_anormal', 0, set_radio('qtc_normal_anormal', 0)); ?>
					</td>
				</tr>
				<tr>
					<td>Eje QRS</td>
					<td><?= form_input(array('type'=>'text', 'name'=>'qrs2', 'id'=>'qrs2', 'value'=>set_value('qrs2'))); ?></td>
					<td>°</td>
					<td>
						<?= form_radio('qrs2_normal_anormal', 1, set_radio('qrs2_normal_anormal', 1)); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('qrs2_normal_anormal', 0, set_radio('qrs2_normal_anormal', 0)); ?>
					</td>
				</tr>
				<tr>
					<td colspan='3'>INTERPRETACIÓN ECG:</td>
					<td><?= form_radio('interpretacion_ecg', 1, set_radio('interpretacion_ecg', 1)); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?= form_radio('interpretacion_ecg', 0, set_radio('interpretacion_ecg', 0)); ?>
					</td>
				</tr>
				<tr>
					<td>Comentarios: </td>		
					<td colspan='3'>
						<?= form_textarea(array('name'=>'comentarios', 'id'=>'comentarios', 'value'=>set_value('comentarios'), 'rows'=>'4','cols'=>'40')); ?>
					</td>
				</tr>
			
				<tr>
					<td colspan='4' style='text-align:center;'>
						<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'ecg_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
	            		<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
	            	</td>
				</tr>
			</tbody>
		</table>
		


	<?= form_close(); ?>
