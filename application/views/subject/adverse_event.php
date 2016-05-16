<script type="text/javascript">
$(function(){

	$("input[name^=date_of]").datepicker();

	$("input[name^=continuing]").change(function(){
		if($(this).val() == 1){
			$("#date_of_resolution").hide();
		}else{
			$("#date_of_resolution").show();
		}
	});
});
</script>
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
<br />


<?php
	$stages = array(	""=>"",
						"Screening - Baseline period"=>"Screening - Baseline period",
						"Beseline - week 4 period"=>"Beseline - week 4 period",
						"Week 4 - week 12 period"=>"Week 4 - week 12 period",
						"Week 12 - week 24 period"=>"Week 12 - week 24 period"
						);
	$event_categorys = array(	""=>"",
								"Musculoskeletal and Connective Disorder"=>"Musculoskeletal and Connective Disorder",
								"Neurvous System Disorder"=>"Neurvous System Disorder",
								"Psychiatric Disorders"=>"Psychiatric Disorders",
								"Renal Function Disorders"=>"Renal Function Disorders",
								"Respiratory, Thoracic and Mediastinal Disorders"=>"Respiratory, Thoracic and Mediastinal Disorders",
								"Skin and Tissue Disorders"=>"Skin and Tissue Disorders",
								"Vascular Complications"=>"Vascular Complications",
								"Other"=>"Other");
	
	$data = array(
        'name'        => 'continuing',                
        'value'       => '1',            
        'checked'     => set_radio('continuing', 1),
        );
    $data2 = array(
        'name'        => 'continuing',                
        'value'       => '0',
        'checked'     => set_radio('continuing', 0),           
        );
    
    $data3 = array(
        'name'        => 'assessment_of_casuality',                
        'value'       => '1',
        'checked'     => set_radio('assessment_of_casuality', 1),           
        );
    $data4 = array(
        'name'        => 'assessment_of_casuality',                
        'value'       => '0',
        'checked'     => set_radio('assessment_of_casuality', 0),           
        );
    
    $data5 = array(
        'name'        => 'sae',                
        'value'       => '1',
        'checked'     => set_radio('sae', 1),           
        );
    $data6 = array(
        'name'        => 'sae',                
        'value'       => '0',
        'checked'     => set_radio('sae', 0),           
        );

    $data7 = array(
        'name'        => 'action_taken_on_investigation_product',                
        'value'       => 'None',
        'checked'     => set_radio('action_taken_on_investigation_product', 'None'),           
        );
    $data8 = array(
        'name'        => 'action_taken_on_investigation_product',                
        'value'       => 'Discontinued',
        'checked'     => set_radio('action_taken_on_investigation_product', 'Discontinued'),
        );

    $assessment_of_severitys = array(""=>"",
    								"Mild"=>"Mild",
    								"Moderate"=>"Moderate",
    								"Severe"=>"Severe");

    $action_taken_none = array(
	    'name'        => 'action_taken_none',
	    'id'          => 'action_taken_none',
	    'value'       => '1',
	    'checked'     => set_checkbox('action_taken_none','1'),
	    'style'       => 'margin:10px',
    );

    $action_taken_medication = array(
	    'name'        => 'action_taken_medication',
	    'id'          => 'action_taken_medication',
	    'value'       => '1',
	    'checked'     => set_checkbox('action_taken_medication','1'),
	    'style'       => 'margin:10px',
    );

    $action_taken_hospitalization = array(
	    'name'        => 'action_taken_hospitalization',
	    'id'          => 'action_taken_hospitalization',
	    'value'       => '1',
	    'checked'     => set_checkbox('action_taken_hospitalization','1'),
	    'style'       => 'margin:10px',
    );

?>

<?= form_open('subject/adverse_event_form_insert', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>

	<?= form_hidden('subject_id', $subject->id); ?>
	
	<table class="table table-striped table-condensed table-bordered">        
        <tr>
            <td>Provide Stage that Adverse Event Occurred: </td>
            <td><?= form_dropdown("stage",$stages,set_value('stage')); ?></td>
        </tr>        

		<tr>
            <td>Adverse Event Category: </td>
            <td><?= form_dropdown("event_category",$event_categorys,set_value('event_category')); ?></td>
        </tr>  
		
		<tr>
        	<td>Description: </td>
        	<td><?= form_textarea(array('name'=>'event_category_description', 'id'=>'event_category_description', 'value'=>set_value('event_category_description'), 'rows'=>'4','cols'=>'40')); ?></td>
		</tr>

		<tr>
        	<td>Adverse event narrative: </td>
        	<td><?= form_textarea(array('name'=>'event_category_narrative', 'id'=>'event_category_narrative', 'value'=>set_value('event_category_narrative'), 'rows'=>'4','cols'=>'40')); ?></td>
		</tr>

        <tr>
        	<td>Date of Onset: </td>
        	<td><?= form_input(array('type'=>'text', 'name'=>'date_of_onset', 'id'=>'date_of_onset', 'readonly'=>'readonly', 'style'=>'cursor: pointer;', 'value'=>set_value('date_of_onset')));?></td>
		</tr>

		<tr>
        	<td>Continuing: </td>
        	<td><?= form_radio($data); ?> Si <?= form_radio($data2); ?> No</td>
		</tr>

		<tr>
        	<td>Date of Resolution: </td>
        	<td><?= form_input(array('type'=>'text', 'name'=>'date_of_resolution', 'id'=>'date_of_resolution', 'readonly'=>'readonly', 'style'=>'cursor: pointer;', 'value'=>set_value('date_of_resolution')));?></td>
		</tr>

		<tr>
            <td>Assessment of Severity: </td>
            <td><?= form_dropdown("assessment_of_severity",$assessment_of_severitys,set_value('assessment_of_severity')); ?></td>
        </tr>

		<tr>
        	<td>Assessment of Casuality To IP: </td>
        	<td><?= form_radio($data3); ?> Si <?= form_radio($data4); ?> No</td>
		</tr>

		<tr>
        	<td>Was this a serious adverse event (SAE)?: </td>
        	<td><?= form_radio($data5); ?> Si <?= form_radio($data6); ?> No</td>
		</tr>

		<tr>
        	<td>Action Taken / Treatment Administered: (check all that apply): </td>
        	<td><?= form_checkbox($action_taken_none);?>None 
        		<?= form_checkbox($action_taken_medication);?>Medication 
        		<?= form_checkbox($action_taken_hospitalization);?>Hospitalization
        	</td>
		</tr>
		
		<tr>
        	<td>Action Taken on Investigation Product: </td>
        	<td><?= form_radio($data7); ?> None <?= form_radio($data8); ?> Discontinued</td>
		</tr>
		<tr>
            <td colspan='2' style='text-align:center;'><?= form_button(array('type'=>'submit', 'content'=>'Submit', 'class'=>'btn btn-primary')); ?>
            <?= anchor('subject/grid/'.$subject->id, 'Back', array('class'=>'btn')); ?></td>
       </tr>
    </table>
<?= form_close(); ?>