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