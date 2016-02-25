<legend style='text-align:center;'>Demographycs</legend>
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
<!-- legend -->
<?php
	if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'demography_query_new')){
?>
	<div id='new_query' style='text-align:right;'>
		<?= form_open('query/demography_query_new', array('class'=>'form-horizontal')); ?>
		<?= form_hidden('id', $subject->id); ?>
		<?= form_button(array('type'=>'submit', 'content'=>'New Query', 'class'=>'btn btn-primary')); ?>
		<?= form_close(); ?>
	</div>
<?php }?>

<?= form_open('subject/demography_update', array('class'=>'form-horizontal')); ?>    
	
	<?= form_hidden('id', $subject->id); ?>

    <?= my_validation_errors(validation_errors()); ?>

    <table class="table table-condensed table-bordered table-striped">
        <tr>
        	<td><?= form_label('Date of Birth: ', 'birth_date', array('class'=>'control-label')); ?></td>
        	<td><?= form_input(array('type'=>'text', 'name'=>'birth_date', 'id'=>'birth_date', 'value'=>set_value('birth_date',$subject->birth_date))); ?></td>
    	</tr>
    
	    <?php
		    $data = array(
			    'name'        => 'gender',
			    'id'          => 'gender',
			    'value'       => 'male',		    
			    #'checked'	  => set_radio('gender', 'male', TRUE),
			    );
		  	$data2 = array(
			    'name'        => 'gender',
			    'id'          => 'gender',
			    'value'       => 'female',
			    #'checked'	  => set_radio('gender', 'female', TRUE),		    
			    );
		      
	    ?>
	    <tr>
	        <td><?= form_label('Gender: ', 'gender', array('class'=>'control-label')); ?></td>
	        <td>
	        	<?= form_radio($data,$data['value'],set_radio($data['name'],$data['value'],($data['value'] == $subject->gender) ? true : false)); ?> Male 
	        	<?= form_radio($data2,$data2['value'],set_radio($data2['name'],$data2['value'],($data2['value'] == $subject->gender) ? true : false)); ?> Female
	        </td>
	    </tr>        
	
		<?php
		    $data3 = array(
			    'name'        => 'is_hispanic',
			    'id'          => 'is_hispanic',
			    'value'       => '1',
			    #'checked'	  => set_radio('is_hispanic', '1', TRUE),
			    );
		  	$data4 = array(
			    'name'        => 'is_hispanic',
			    'id'          => 'is_hispanic',
			    'value'       => '0',		    
			    #'checked'	  => set_radio('is_hispanic', '0', TRUE),
			    );
		      
	    ?>
		<tr>
	        <td><?= form_label('Ethnicity: ', 'is_hispanic', array('class'=>'control-label')); ?></td>
	        <td>
	        	<?= form_radio($data3,$data3['value'],set_radio($data3['name'],$data3['value'],($data3['value'] == $subject->is_hispanic) ? true : false)); ?> Hispanic/Latino 
	        	<?= form_radio($data4,$data4['value'],set_radio($data4['name'],$data4['value'],($data4['value'] == $subject->is_hispanic) ? true : false)); ?> Non Hispanic/Latino
	        </td>
	    </tr> 
		<?php
			$races = array(""=>"","White"=>"White","African American"=>"African American","Asian"=>"Asian");
		?>
		<tr>
        	<td><?= form_label('Race: ', 'race', array('class'=>'control-label')); ?></td>
        	<td><?= form_dropdown('race', $races, set_value('race',$subject->race)); ?></td>
    	</tr>
		
		<?php
				if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'demography_update')){
			?>
	    <tr>

	        <td colspan='2' style='text-align:center;'><?= form_button(array('type'=>'submit', 'content'=>'Submit', 'class'=>'btn btn-primary')); ?>
	        <?= anchor('subject/grid/'. $subject->id, 'Cancel', array('class'=>'btn')); ?></td>
	    </tr>
	    <?php }?>
	</table>
<?= form_close(); ?>
<!-- Querys -->
<?php
	if(isset($querys) AND !empty($querys)){ ?>
		<b>Querys:</b>
		<table class="table table-condensed table-bordered table-stripped">
			<thead>
				<tr>
					<th>Date of Query</th>
					<th>User</th>
					<th>Question</th>
					<th>Date of Answer</th>
					<th>User</th>
					<th>Answer</th>					
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
							if(isset($_SESSION['role_options']['query']) AND strpos($_SESSION['role_options']['query'], 'demography_query_show')){
						?>
							<td><?= (($query->answer != '') ? $query->answer : anchor('query/demography_query_show/'. $subject->id .'/'.$query->id, 'Add',array('class'=>'btn'))); ?></td>						
						<?php }else{?>
							<td><?= $query->answer; ?></td>
						<?php }?>
					</tr>					
			<?php }?>	

			</tbody>
		</table>

<?php } ?>
<!--Signature-->
<div id="signature" class="table">
	<b>Signature:</b><br />
	<?php if(!empty($subject->demography_signature_user) AND !empty($subject->demography_signature_date)){ ?>
		
		This form was signed by <?= $subject->demography_signature_user;?> on <?= date("d-M-Y",strtotime($subject->demography_signature_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'demography_signature')){
	?>
		<?= form_open('subject/demography_signature', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('id', $subject->id); ?>
		<?= form_hidden('current_status', $subject->demography_status); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Add Signature', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "This form has not yet been signed";
		}
	}
?>
<br />
<!--Signature/Lock-->
<br /><b>Signature Lock:</b><br />
	<?php if(!empty($subject->demography_lock_user) AND !empty($subject->demography_lock_date)){ ?>
		
		This form was locked by <?= $subject->demography_lock_user;?> on <?= date("d-M-Y",strtotime($subject->demography_lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'demography_lock')){
	?>
		<?= form_open('subject/demography_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('id', $subject->id); ?>
		<?= form_hidden('current_status', $subject->demography_status); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Lock Form', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "This form has not yet been locked";
		}
	}
?>
</div>