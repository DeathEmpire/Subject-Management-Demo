<legend style='text-align:center;'>Adverse Event/Serious Adverse Event</legend>
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
<!-- New Query-->
<?php
	if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'additional_form_query_new')){
?>
	<div id='new_query' style='text-align:right;'>
		<?= form_open('query/additional_form_query_new', array('class'=>'form-horizontal')); ?>
		<?= form_hidden('subject_id', $subject->id); ?>
		<?= form_hidden('form', "Adverse Event"); ?>
		<?= form_button(array('type'=>'submit', 'content'=>'New Query', 'class'=>'btn btn-primary')); ?>
		<?= form_close(); ?>
	</div>
<?php }?>
<!-- End Query-->
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
<!-- Querys -->
<?php
	if(isset($querys) AND !empty($querys)){ ?>
		<b>Querys:</b>
		<table class="table table-condensed table-bordered table-stripped">
			<thead>
				<tr>
					<th>Fecha de Consulta</th>
								<th>Usuario</th>
								<th>Consulta</th>
								<th>Fecha de Respuesta</th>
								<th>Usuario</th>
								<th>Respuesta</th>				
				</tr>
			</thead>
			<tbody>
				
			<?php
				foreach ($querys as $query) { ?>
					<tr>
						<td><?= date("d-M-Y H:i:s", strtotime($query->created)); ?></td>
						<td><?= $query->question_user; ?></td>
						<td><?= $query->question; ?></td>						
						<td><?= (($query->answer_date != "0000-00-00 00:00:00") ? date("d-M-Y H:i:s", strtotime($query->answer_date)) : ""); ?></td>
						<td><?= $query->answer_user; ?></td>
						<?php
							if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'additional_form_query_show')){
						?>
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/additional_form_query_show/'. $subject->id .'/'.$query->id .'/Adverse Event', 'Add',array('class'=>'btn'))); ?></td>						
						<?php }else{?>
							<td><?= $query->answer; ?></td>
						<?php }?>
					</tr>					
			<?php }?>	

			</tbody>
		</table>

<?php } ?>