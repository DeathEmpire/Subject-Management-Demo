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
				<td style='font-weight:bold;'>Tiene el paciente algun hallazgo en el examen fisico: </td>
				<td><?= form_radio($data); ?> Si <?= form_radio($data2); ?> No</td>
				<td></td>
			</tr>			
			<tr>
				<td>Cardiovascular: </td>
				<td>
					<?= form_radio(array('name'=>'cardiovascular','value'=>'1','checked'=>set_radio('cardiovascular', 1))); ?> Si
					<?= form_radio(array('name'=>'cardiovascular','value'=>'0','checked'=>set_radio('cardiovascular', 0))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'cardiovascular_desc','id'=>'cardiovascular_desc', 'value'=>set_value('cardiovascular_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Vascular Periferico: </td>
				<td>
					<?= form_radio(array('name'=>'periferico','value'=>'1','checked'=>set_radio('periferico', 1))); ?> Si
					<?= form_radio(array('name'=>'periferico','value'=>'0','checked'=>set_radio('periferico', 0))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'periferico_desc','id'=>'periferico_desc', 'value'=>set_value('periferico_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Oidos y Garganta: </td>
				<td>
					<?= form_radio(array('name'=>'oidos','value'=>'1','checked'=>set_radio('oidos', 1))); ?> Si
					<?= form_radio(array('name'=>'oidos','value'=>'0','checked'=>set_radio('oidos', 0))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'oidos_desc','id'=>'oidos_desc', 'value'=>set_value('oidos_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Neurologico: </td>
				<td>
					<?= form_radio(array('name'=>'neurologico','value'=>'1','checked'=>set_radio('neurologico', 1))); ?> Si
					<?= form_radio(array('name'=>'neurologico','value'=>'0','checked'=>set_radio('neurologico', 0))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'neurologico_desc','id'=>'neurologico_desc', 'value'=>set_value('neurologico_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Pulmones/Respiratorio: </td>
				<td>
					<?= form_radio(array('name'=>'pulmones','value'=>'1','checked'=>set_radio('pulmones', 1))); ?> Si
					<?= form_radio(array('name'=>'pulmones','value'=>'0','checked'=>set_radio('pulmones', 0))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'pulmones_desc','id'=>'pulmones_desc', 'value'=>set_value('pulmones_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Renal/Urinario: </td>
				<td>
					<?= form_radio(array('name'=>'renal','value'=>'1','checked'=>set_radio('renal', 1))); ?> Si
					<?= form_radio(array('name'=>'renal','value'=>'0','checked'=>set_radio('renal', 0))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'renal_desc','id'=>'renal_desc', 'value'=>set_value('renal_desc'), 'rows'=>3)); ?></td>
			</tr>			
			<tr>
				<td>Ginecologico: </td>
				<td>
					<?= form_radio(array('name'=>'ginecologico','value'=>'1','checked'=>set_radio('ginecologico', 1))); ?> Si
					<?= form_radio(array('name'=>'ginecologico','value'=>'0','checked'=>set_radio('ginecologico', 0))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'ginecologico_desc','id'=>'ginecologico_desc', 'value'=>set_value('ginecologico_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Endocrino/Metabolico: </td>
				<td>
					<?= form_radio(array('name'=>'endocrino','value'=>'1','checked'=>set_radio('endocrino', 1))); ?> Si
					<?= form_radio(array('name'=>'endocrino','value'=>'0','checked'=>set_radio('endocrino', 0))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'endocrino_desc','id'=>'endocrino_desc', 'value'=>set_value('endocrino_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Hepatico: </td>
				<td>
					<?= form_radio(array('name'=>'hepatico','value'=>'1','checked'=>set_radio('hepatico', 1))); ?> Si
					<?= form_radio(array('name'=>'hepatico','value'=>'0','checked'=>set_radio('hepatico', 0))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'hepatico_desc','id'=>'hepatico_desc', 'value'=>set_value('hepatico_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Gastrointestinal: </td>
				<td>
					<?= form_radio(array('name'=>'gastrointestinal','value'=>'1','checked'=>set_radio('gastrointestinal', 1))); ?> Si
					<?= form_radio(array('name'=>'gastrointestinal','value'=>'0','checked'=>set_radio('gastrointestinal', 0))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'gastrointestinal_desc','id'=>'gastrointestinal_desc', 'value'=>set_value('gastrointestinal_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Muscular/Esqueletico: </td>
				<td>
					<?= form_radio(array('name'=>'muscular','value'=>'1','checked'=>set_radio('muscular', 1))); ?> Si
					<?= form_radio(array('name'=>'muscular','value'=>'0','checked'=>set_radio('muscular', 0))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'muscular_desc','id'=>'muscular_desc', 'value'=>set_value('muscular_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Cancer: </td>
				<td>
					<?= form_radio(array('name'=>'cancer','value'=>'1','checked'=>set_radio('cancer', 1))); ?> Si
					<?= form_radio(array('name'=>'cancer','value'=>'0','checked'=>set_radio('cancer', 0))); ?> No
				</td>
				<td><?= form_textarea(array('name'=>'cancer_desc','id'=>'cancer_desc', 'value'=>set_value('cancer_desc'), 'rows'=>3)); ?></td>
			</tr>
			<tr>
				<td>Otros: </td>
				<td></td>
				<td></td>
			</tr>			
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
</div>