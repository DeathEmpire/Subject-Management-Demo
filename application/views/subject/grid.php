<legend style='text-align:center;'> Subject Record </legend>
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
<b>Legend:</b>
<table class="table table-condensed table-bordered">
	<thead>
		<tr style='background-color: #C0C0C0;'><th colspan='4' style='text-align:center;'>Link Icon Legend</th></tr>
	</thead>
	<tbody>
		<tr>
			<td><?= img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));?> = New Record</td>
			<td><?= img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));?> = Record Contains Error(s)</td>
			<td><?= img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));?> = Form Approved and Locked</td>
			<td><?= img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));?> = Form Approved by Monitor</td>
		</tr>
		<tr>
			<td><?= img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));?> = Record Complete</td>
			<td><?= img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));?> = Document Approved and Signed by PI</td>
			<td colspan='2'><?= img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));?> = Open Monitor Messagge(s)</td>
		</tr>
	</tbody>
</table>


<b>Schelduled Visits:</b>
<table class="table table-condensed table-bordered">
	<thead>
		<tr style='background-color: #C0C0C0;'>
			<th rowspan='2' style='text-align:center;vertical-align:middle;'>Forms</th>
			<th colspan='5' style='text-align:center;'>Visit Intervals</th>
		</tr>
		<tr style='background-color: #C0C0C0;'>
			<th>Screening</th>
			<th>Baseline</th>
			<th>Week 4</th>
			<th>Week 12</th>
			<th>Week 24</th>		
		</tr>
	</thead>
	<tbody>		
		<tr>
			<td>Demography</td>
			<?php
				if(empty($subject->demography_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
				}
				elseif ($subject->demography_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->demography_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->demography_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->demography_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->demography_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->demography_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
				}
				else{
					$icon = '*';		
				}
				
			?>
			<td style='text-align:center;'><?= anchor('subject/demography/'.$subject->id, $icon); ?></td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
		</tr>
		<tr>
			<td>Inclusion/Exclusion Criteria</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
		</tr>
		<tr>
			<td>Medical History</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
		</tr>
		<tr>
			<td>MMSE</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
		</tr>
		<tr>
			<td>Hachinski</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
		</tr>
		<tr>
			<td>Thyroid profile</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
		</tr>
		<tr>
			<td>Lab tests</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
		</tr>
		<tr>
			<td>ECG</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
		</tr>
		<tr>
			<td>Brain scanner</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
		</tr>
		<tr>
			<td>Physical examination</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
		</tr>
		<tr>
			<td>Neurological examination</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
		</tr>
		<tr>
			<td>Vital signs</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
		</tr>
		<tr>
			<td>Adas-cog</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
		</tr>
		<tr>
			<td>Randomization</td> 

			<?php
				#print_r($subject);
				if(empty($subject->randomization_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
				}
				elseif ($subject->randomization_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->randomization_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->randomization_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->randomization_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->randomization_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->randomization_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
				}
				else{
					$icon = '*';		
				}
				
			?>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'><?= anchor('subject/randomization/'.$subject->id, $icon);?></td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
			<td style='text-align:center;'>-</td>
		</tr>
	</tbody>
</table>

<!--<small>*Note: If any unscheduled visits ocurr during these study days, please record de information on the applicable case report form (CRFs) under the section "Unscheduled Events".</small>-->

<br />&nbsp;<br />
<b>Aditional Forms:</b>
<table class='table table-condensed table-bordered'>
	<thead>
		<tr style='background-color: #C0C0C0;'>
			<th>Form</th>
			<th colspan='2'>Links</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Adverse Event/Serious Adverse Event</td>
			<?php
				if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'adverse_event_form')){
			?>
				<td><?= anchor('subject/adverse_event_form/'.$subject->id,'Add'); ?></td>
			<?php }?>	
			<td><?= anchor('subject/adverse_event_show/'.$subject->id,'Show'); ?></td>
		</tr>
		<tr>	
			<td>Protocol Deviation</td>
			<?php
				if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'protocol_deviation_form')){
			?>
				<td><?= anchor('subject/protocol_deviation_form/'.$subject->id,'Add'); ?></td>
			<?php }?>

			<td><?= anchor('subject/protocol_deviation_show/'.$subject->id,'Show'); ?></td>
		</tr>
		<tr>	
			<td>Concomitant Medication</td>
			<?php
				if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'concomitant_medication_form')){
			?>
				<td><?= anchor('subject/concomitant_medication_form/'.$subject->id,'Add'); ?></td>
			<?php }?>
			<td><?= anchor('subject/concomitant_medication_show/'.$subject->id,'Show'); ?></td>
		</tr>		
	</tbody>
</table>