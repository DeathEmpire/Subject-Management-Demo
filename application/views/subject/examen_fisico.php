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
?>

	<?= form_open('subject/examen_fisico_insert', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>

	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>

		<table class='table table-striped table-hover table-bordered table-condensed'>
			<tr>
				<td>Examen f&iacute;sico realizado: </td>							
				<td><?= form_radio($data); ?> Si <?= form_radio($data2); ?> No</td>
				<td></td>
			</tr>
			<?php if($etapa == 1 OR $etapa == 5 OR $etapa == 6){ ?>			
				<tr>
					<td>La fecha del examen es la misma fecha de la visita?: </td>
					<td>
						<?= form_radio(array('name'=>'misma_fecha', 'value'=>1, 'checked'=>set_radio('misma_fecha', 1))); ?> Si
						<?= form_radio(array('name'=>'misma_fecha', 'value'=>0, 'checked'=>set_radio('misma_fecha', 0))); ?> No
					</td>
					<td></td>
				</tr>
			<?php } else { ?>
					<?= form_hidden('misma_fecha',0); ?>
			<?php } ?>
			<tr>
				<td>Fecha: </td>
				<td><?= form_input(array('type'=>'text', 'name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?></td>
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
					<?= form_radio(array('name'=>'aspecto_general','value'=>'1','checked'=>set_radio('aspecto_general', 1))); ?> Normal
					<?= form_radio(array('name'=>'aspecto_general','value'=>'0','checked'=>set_radio('aspecto_general', 0))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'aspecto_general_desc','id'=>'aspecto_general_desc', 'value'=>set_value('aspecto_general_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Estado nutricional: </td>
				<td>
					<?= form_radio(array('name'=>'estado_nutricional','value'=>'1','checked'=>set_radio('estado_nutricional', 1))); ?> Normal
					<?= form_radio(array('name'=>'estado_nutricional','value'=>'0','checked'=>set_radio('estado_nutricional', 0))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'estado_nutricional_desc','id'=>'estado_nutricional_desc', 'value'=>set_value('renal_desc'), 'rows'=>3)); ?></td>
			</tr>
			<?php if($etapa == 1 OR $etapa == 5 OR $etapa == 6){ ?>
				<tr>
					<td>Piel: </td>
					<td>
						<?= form_radio(array('name'=>'piel','value'=>'1','checked'=>set_radio('piel', 1))); ?> Normal
						<?= form_radio(array('name'=>'piel','value'=>'0','checked'=>set_radio('piel', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'piel_desc','id'=>'piel_desc', 'value'=>set_value('piel_desc'), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Cabeza: </td>
					<td>
						<?= form_radio(array('name'=>'cabeza','value'=>'1','checked'=>set_radio('cabeza', 1))); ?> Normal
						<?= form_radio(array('name'=>'cabeza','value'=>'0','checked'=>set_radio('cabeza', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'cabeza_desc','id'=>'cabeza_desc', 'value'=>set_value('cabeza_desc'), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Ojos: </td>
					<td>
						<?= form_radio(array('name'=>'ojos','value'=>'1','checked'=>set_radio('ojos', 1))); ?> Normal
						<?= form_radio(array('name'=>'ojos','value'=>'0','checked'=>set_radio('ojos', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'ojos_desc','id'=>'ojos_desc', 'value'=>set_value('ojos_desc'), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Nariz: </td>
					<td>
						<?= form_radio(array('name'=>'nariz','value'=>'1','checked'=>set_radio('nariz', 1))); ?> Normal
						<?= form_radio(array('name'=>'nariz','value'=>'0','checked'=>set_radio('nariz', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'nariz_desc','id'=>'nariz_desc', 'value'=>set_value('nariz_desc'), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Oidos: </td>
					<td>
						<?= form_radio(array('name'=>'oidos','value'=>'1','checked'=>set_radio('oidos', 1))); ?> Normal
						<?= form_radio(array('name'=>'oidos','value'=>'0','checked'=>set_radio('oidos', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'oidos_desc','id'=>'oidos_desc', 'value'=>set_value('oidos_desc'), 'rows'=>3)); ?></td>
				</tr>			
				<tr>
					<td>Boca - Garganta: </td>
					<td>
						<?= form_radio(array('name'=>'boca','value'=>'1','checked'=>set_radio('boca', 1))); ?> Normal
						<?= form_radio(array('name'=>'boca','value'=>'0','checked'=>set_radio('boca', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'boca_desc','id'=>'boca_desc', 'value'=>set_value('boca_desc'), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Cuello - adenopat&iacute;as: </td>
					<td>
						<?= form_radio(array('name'=>'cuello','value'=>'1','checked'=>set_radio('cuello', 1))); ?> Normal
						<?= form_radio(array('name'=>'cuello','value'=>'0','checked'=>set_radio('cuello', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'cuello_desc','id'=>'cuello_desc', 'value'=>set_value('cuello_desc'), 'rows'=>3)); ?></td>
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
					<?= form_radio(array('name'=>'pulmones','value'=>'1','checked'=>set_radio('pulmones', 1))); ?> Normal
					<?= form_radio(array('name'=>'pulmones','value'=>'0','checked'=>set_radio('pulmones', 0))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'pulmones_desc','id'=>'pulmones_desc', 'value'=>set_value('pulmones_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Card&iacute;aco: </td>
				<td>
					<?= form_radio(array('name'=>'cardiovascular','value'=>'1','checked'=>set_radio('cardiovascular', 1))); ?> Normal
					<?= form_radio(array('name'=>'cardiovascular','value'=>'0','checked'=>set_radio('cardiovascular', 0))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'cardiovascular_desc', 'id'=>'cardiovascular_desc', 'value'=>set_value('cardiovascular_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Abdomen: </td>
				<td>
					<?= form_radio(array('name'=>'abdomen','value'=>'1','checked'=>set_radio('abdomen', 1))); ?> Normal
					<?= form_radio(array('name'=>'abdomen','value'=>'0','checked'=>set_radio('abdomen', 0))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'abdomen_desc','id'=>'abdomen_desc', 'value'=>set_value('abdomen_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Muscular - Esquel&eacute;tico: </td>
				<td>
					<?= form_radio(array('name'=>'muscular','value'=>'1','checked'=>set_radio('muscular', 1))); ?> Normal
					<?= form_radio(array('name'=>'muscular','value'=>'0','checked'=>set_radio('muscular', 0))); ?> Anormal
				</td>
				<td><?= form_textarea(array('name'=>'muscular_desc','id'=>'muscular_desc', 'value'=>set_value('muscular_desc'), 'rows'=>3)); ?></td>
			</tr>
			<?php if($etapa == 1 OR $etapa == 5 OR $etapa == 6){ ?>
				<tr>
					<td>Extremidades superiores: </td>
					<td>
						<?= form_radio(array('name'=>'ext_superiores','value'=>'1','checked'=>set_radio('ext_superiores', 1))); ?> Normal
						<?= form_radio(array('name'=>'ext_superiores','value'=>'0','checked'=>set_radio('ext_superiores', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'ext_superiores_desc','id'=>'ext_superiores_desc', 'value'=>set_value('ext_superiores_desc'), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Extremidades inferiores: </td>
					<td>
						<?= form_radio(array('name'=>'ext_inferiores','value'=>'1','checked'=>set_radio('ext_inferiores', 1))); ?> Normal
						<?= form_radio(array('name'=>'ext_inferiores','value'=>'0','checked'=>set_radio('ext_inferiores', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'ext_inferiores_desc','id'=>'ext_inferiores_desc', 'value'=>set_value('ext_inferiores_desc'), 'rows'=>3)); ?></td>
				</tr>
				<tr>
					<td>Pulsos perif&eacute;ricos: </td>
					<td>
						<?= form_radio(array('name'=>'periferico','value'=>'1','checked'=>set_radio('periferico', 1))); ?> Normal
						<?= form_radio(array('name'=>'periferico','value'=>'0','checked'=>set_radio('periferico', 0))); ?> Anormal
					</td>
					<td><?= form_textarea(array('name'=>'periferico_desc','id'=>'periferico_desc', 'value'=>set_value('periferico_desc'), 'rows'=>3)); ?></td>
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
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'examen_fisico_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
					<?= anchor('subject/grid/'. $subject->id, 'Volver', array('class'=>'btn')); ?>
				</td>				
			</tr>			
		</table>
	<?= form_close(); ?>
