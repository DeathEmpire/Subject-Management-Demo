<script type="text/javascript">
$(function(){

	$("#start_date").datepicker();
	$("#end_date").datepicker();

	$("input[name^=on_going]").change(function(){
		if($(this).val() == 0){
			$("#end_date_tr").show();
		}
		else{
			$("#end_date_tr").hide();
		}
	});

	$("select[name=frequency]").change(function(){
		if($(this).val() == "Other"){
			$("#other").show();
		}
		else{
			$("#other").hide();
		}
	});

	if($("select[name=frequency]").val() == "Other"){
		$("#other").show();
	}else{
		$("#other").hide();
	}

});
</script>
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
<br />

<?php
	$data = array(
        'name'        => 'on_going',                
        'value'       => '1',            
        'checked'     => set_radio('on_going', 1),
        );
    $data2 = array(
        'name'        => 'on_going',                
        'value'       => '0',
        'checked'     => set_radio('on_going', 0),           
        );
    $unit_of_measure = array(""=>"",
    						"CAP"=>"CAP",
    						"g"=>"g",
    						"GR"=>"GR",
    						"GTT"=>"GTT",
    						"IU"=>"IU",
    						"LPM"=>"LPM",
    						"mcg"=>"mcg",
    						"mEq"=>"mEq",
    						"mg"=>"mg",
    						"mL"=>"mL",
    						"oz"=>"oz",
    						"PCH"=>"PCH",
    						"PUF"=>"PUF",
    						"SPY"=>"SPY",
    						"SUP"=>"SUP",
    						"TAB"=>"TAB",
    						"TBS"=>"TBS",
    						"TSP"=>"TSP",
    						"uL"=>"uL",
    						"UNIT"=>"UNIT");
    $frequencys = array(""=>"",
    					"BID"=>"BID",
    					"HS"=>"HS",
    					"OTH"=>"OTH",
    					"PRN"=>"PRN",
    					"QAM"=>"QAM",
    					"QD"=>"QD",
    					"QID"=>"QID",
    					"QOD"=>"QOD",
    					"QPM"=>"QPM",
    					"QWK"=>"QWK",
    					"TID"=>"TID",
    					"Before a Meal"=>"Before a Meal",
    					"After a Meal"=>"Afte a Meal",    					
    					"Every Hour (qhr)"=>"Every Hour (qhr)",
    					"Every 4 Hour (q4hr)"=>"Every 4 Hour (q4hr)",
    					"Stat"=>"Stat",
    					"Other"=>"Other");
    $routes = array(""=>"",
    				"ID"=>"ID",
    				"IH"=>"IH",
    				"IM"=>"IM",
    				"IV"=>"IV",
    				"PO"=>"PO",
    				"PR"=>"PR",
    				"PV"=>"PV",
    				"SL"=>"SL",
    				"SQ"=>"SQ",
    				"TOP"=>"TOP",
    				"UNK"=>"UNK",
    				"Inhalation"=>"Inhalation",
    				"Intranasal"=>"Intranasal",
    				"Other"=>"Other");

?>
<?= form_open('subject/concomitant_medication_form_insert', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>

	<table class="table table-striped table-condensed table-bordered">       		
        <tr>
        	<td>Brand Name: </td>
        	<td><?= form_input(array('type'=>'text', 'name'=>'brand_name', 'id'=>'brand_name', 'value'=>set_value('brand_name')));?></td>
		</tr>
		<tr>
        	<td>Generic Name: </td>
        	<td><?= form_input(array('type'=>'text','name'=>'generic_name', 'id'=>'generic_name', 'value'=>set_value('generic_name'))); ?></td>
		</tr>
		<tr>
        	<td>Indication: </td>
        	<td><?= form_input(array('type'=>'text','name'=>'indication', 'id'=>'indication', 'value'=>set_value('indication'))); ?></td>
		</tr>
		<tr>
        	<td>Totaly Daily Dose: </td>
        	<td>
        		<?= form_input(array('type'=>'text','name'=>'daily_dose', 'id'=>'daily_dose', 'size'=>'4','value'=>set_value('daily_dose'))); ?>
				<?= form_dropdown("unit_of_measure",$unit_of_measure,set_value('unit_of_measure')); ?>
        	</td>
		</tr>
		<tr>
        	<td>Frecuency: </td>
        	<td><?= form_dropdown("frequency",$frequencys,set_value('frequency')); ?></td>
		</tr>
		<tr>
        	<td>If other specify: </td>
        	<td><?= form_input(array('type'=>'text','name'=>'other', 'id'=>'other', 'value'=>set_value('other'), "style"=>"display:none;")); ?></td>
		</tr>
		<tr>
        	<td>Route: </td>
        	<td><?= form_dropdown("route",$routes,set_value('route')); ?></td>
		</tr>
		<tr>
        	<td>Start Date: </td>
        	<td><?= form_input(array('type'=>'text','name'=>'start_date', 'id'=>'start_date', 'readonly'=>'readonly', 'style'=>'cursor: pointer;', 'value'=>set_value('start_date'))); ?></td>
		</tr>
		<tr>
        	<td>On Going: </td>
        	<td><?= form_radio($data); ?> Yes <?= form_radio($data2); ?> No</td>
		</tr>
		<tr id="end_date_tr" stlye='display:none;'>
        	<td>End Date: </td>
        	<td><?= form_input(array('type'=>'text','name'=>'end_date', 'id'=>'end_date', 'readonly'=>'readonly', 'style'=>'cursor: pointer;', 'value'=>set_value('end_date'))); ?></td>
		</tr>
		<tr>
            <td colspan='2' style='text-align:center;'><?= form_button(array('type'=>'submit', 'content'=>'Submit', 'class'=>'btn btn-primary')); ?>
            <?= anchor('subject/grid/'.$subject->id, 'Back', array('class'=>'btn')); ?></td>
       </tr>
    </table>
<?= form_close(); ?>