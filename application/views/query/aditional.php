<legend style='text-align:center;'><?= $form;?> Query</legend>
<b>Current Subject:</b>
<table class="table table-condensed table-bordered">
	<thead>
		<tr style='background-color: #C0C0C0;'>
			<th>Center</th>
			<th>Subject ID</th>
			<th>Subject Initials</th>
			<th>Enrollement Date</th>
			<th>Randomization Date</th>
			<th>Treatment Kit Assigment 1</th>
			<th>Treatment Kit Assigment 2</th>		
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
			<td><?= $subject->kit2; ?></td>	
		</tr>
	</tbody>
</table>
<br />
<?= form_open('query/additional_form_query_insert', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('form', $form); ?>
	
	<table class="table table-striped table-condensed table-bordered">        
        <tr>
            <td>Question: </td>
            <td><?= form_textarea(array('name'=>'question', 'id'=>'question', 'value'=>set_value('question'), 'rows'=>'4','cols'=>'40')); ?></td>
        </tr>
        <tr>
            <td colspan='2' style='text-align:center;'><?= form_button(array('type'=>'submit', 'content'=>'Submit', 'class'=>'btn btn-primary')); ?>
            <?php 
				if($form == 'Adverse Event'){
					echo anchor('subject/adverse_event_show/'.$subject->id, 'Back', array('class'=>'btn'));
				}
				elseif($form == 'Protocol Deviation'){
					echo anchor('subject/protocol_deviation_show/'.$subject->id, 'Back', array('class'=>'btn'));
				}
				elseif($form == 'Concomitant Medication'){
					echo anchor('subject/concomitant_medication_show/'.$subject->id, 'Back', array('class'=>'btn'));
				}
			?>
			</td>
       </tr>  
    </table>
<?= form_close();?>