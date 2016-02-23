<legend style='text-align:center;'>Adverse Event/Serious Adverse Event</legend>
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

<?php
	if(isset($list) AND !empty($list)){
?>		

	<table class="table table-condensed table-bordered table-striped">
		<thead>
			<tr>
				<th>Stage</th>
				<th>Event Category</th>
				<th>Description</th>
				<th>Narrative</th>
				<th>Date of Onset</th>
				<th>Date of Resolution</th>
				<th>Assessment of Severity</th>
				<th>Assessment of Casuality</th>			
				<th>SAE</th>
				<th>Action Taken</th>
				<th>Action Taken on Investigation Product</th>			
			</tr>
		</thead>
		<tbody>
		
		<?php
		foreach ($list as $v) { ?>
			
				<tr>
					<td><?= $v->stage;?></td>
					<td><?= $v->event_category;?></td>
					<td><?= $v->event_category_description;?></td>
					<td><?= $v->event_category_narrative;?></td>
					<td><?= date("d-M-Y", strtotime($v->date_of_onset));?></td>
					<td><?= (($v->continuing == 1) ? "-" : date("d-M-Y", strtotime($v->date_of_resolution))); ?></td>
					<td><?= $v->assessment_of_severity;?></td>
					<td><?= (($v->assessment_of_casuality == 1) ? "Yes" : "No");?></td>
					<td><?= (($v->sae == 1) ? "Yes" : "No"); ?></td>
					<td>
						<?= (($v->action_taken_none == 1) ? "None<br />" : ""); ?>
						<?= (($v->action_taken_medication == 1) ? "Medication<br />" : ""); ?>
						<?= (($v->action_taken_hospitalization == 1) ? "Hospitalization<br />" :""); ?>
					</td>
					<td><?= (($v->action_taken_on_investigation_product == 1) ? "Yes" : "No"); ?></td>
				</tr>			
		<?php } ?>
		<tr><td colspan='10' style='text-align:center;'><?= anchor('subject/grid/'.$subject->id, 'Back', array('class'=>'btn')); ?></td></tr>
		</tbody>		
	</table>


<?php
	}
?>