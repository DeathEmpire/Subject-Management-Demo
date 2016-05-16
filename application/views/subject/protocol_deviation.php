<script type="text/javascript">
$(function(){

	$("#date_of_deviation").datepicker();

	$("input[name^=pre_approved]").change(function(){
		if($(this).val() == 1){
			$("#sponsor_tr").show();
		}else{
			$("#sponsor_tr").hide();
		}
	});
});
</script>
<legend style='text-align:center;'>Protocol Deviation</legend>
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
        'name'        => 'pre_approved',                
        'value'       => '1',            
        'checked'     => set_radio('pre_approved', 1),
        );
    $data2 = array(
        'name'        => 'pre_approved',                
        'value'       => '0',
        'checked'     => set_radio('pre_approved', 0),           
        );
?>
<?= form_open('subject/protocol_deviation_form_insert', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>

	<table class="table table-striped table-condensed table-bordered">       		
        <tr>
        	<td>Date of Deviation: </td>
        	<td><?= form_input(array('type'=>'text', 'name'=>'date_of_deviation', 'id'=>'date_of_deviation', 'readonly'=>'readonly', 'style'=>'cursor: pointer;', 'value'=>set_value('date_of_deviation')));?></td>
		</tr>
		<tr>
        	<td>Description of deviation: </td>
        	<td><?= form_input(array('type'=>'text','name'=>'description', 'id'=>'description', 'value'=>set_value('description'))); ?></td>
		</tr>
		<tr>
        	<td>Was the Protocol Deviation Pre-Approved by Sponsor?: </td>
        	<td><?= form_radio($data); ?> Yes <?= form_radio($data2); ?> No</td>
		</tr>
		<tr style='display:none;' id='sponsor_tr'>
        	<td>Name of the Sponsor designee approving the deviation: </td>        	
        	<td><?= form_input(array('type'=>'text','name'=>'sponsor_name', 'id'=>'sponsor_name', 'value'=>set_value('sponsor_name'))); ?></td>
		</tr>	
		
		<tr>
            <td colspan='2' style='text-align:center;'><?= form_button(array('type'=>'submit', 'content'=>'Submit', 'class'=>'btn btn-primary')); ?>
            <?= anchor('subject/grid/'.$subject->id, 'Back', array('class'=>'btn')); ?></td>
       </tr>
    </table>
<?= form_close(); ?>