<legend style='text-align:center;'>Concomitant Medication</legend>
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
				<th>Brand Name</th>
				<th>Generic Name</th>
				<th>Indication</th>			
				<th>Daily Dose</th>
				<th>Route</th>
				<th>Start Date</th>
				<th>End Date</th>						
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($list as $v) { ?>
			<tr>
				<td><?= $v->brand_name;?></td>
				<td><?= $v->generic_name;?></td>
				<td><?= $v->indication;?></td>
				<td><?= $v->daily_dose ." ". $v->unit_of_measure ." ". $v->frequency;?></td>
				<td><?= $v->route;?></td>
				<td><?= date("d-M-Y", strtotime($v->start_date)); ?></td>
				<td><?= (($v->on_going == 1) ? "-" : date("d-M-Y", strtotime($v->end_date))); ?></td>				
			</tr>		
		<?php } ?>

		<tr><td colspan='7' style='text-align:center;'><?= anchor('subject/grid/'.$subject->id, 'Back', array('class'=>'btn')); ?></td></tr>
		</tbody>
	</table>


<?php
	}
?>