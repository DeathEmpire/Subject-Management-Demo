<legend style='text-align:center;'>Consulta Demograf&iacute;a</legend>
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
<?= form_open('query/demography_query_insert', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('demography_status', $subject->demography_status); ?>
	
	<table class="table table-striped table-condensed table-bordered">        
        <tr>
            <td>Consulta: </td>
            <td><?= form_textarea(array('name'=>'question', 'id'=>'question', 'value'=>set_value('question'), 'rows'=>'4','cols'=>'40')); ?></td>
        </tr>
        <tr>
            <td colspan='2' style='text-align:center;'><?= form_button(array('type'=>'submit', 'content'=>'Enviar', 'class'=>'btn btn-primary')); ?>
            <?= anchor('subject/demography/'.$subject->id, 'Cancelar', array('class'=>'btn')); ?></td>
       </tr>  
    </table>
<?= form_close();?>