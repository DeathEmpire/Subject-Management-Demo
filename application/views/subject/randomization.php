<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("input[name^=is_randomizable]").change(function(){

		if($(this).val() == 1){
			$("#randomization_date").datepicker();
			$(".randomization").show();
			$(".buttons_form").show();
		}else{
			$(".randomization").hide();
			$(".buttons_form").hide();
		}

	});

	/*Show Hide Date of Randomizarion at start*/
	if($("input[name^=is_randomizable]:checked").val() == 1){
		$("#randomization_date").datepicker();
		$(".randomization").show();
		$(".buttons_form").show();
	}else{
		$(".randomization").hide();
		$(".buttons_form").hide();
	}


});	
</script>
<legend style='text-align:center;'>Randomizacion</legend>
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
        'name'        => 'is_randomizable',                
        'value'       => '1',            
        #'checked'     => set_radio('is_randomizable', 1, TRUE),
        );
    $data2 = array(
        'name'        => 'is_randomizable',                
        'value'       => '0',
        #'checked'     => set_radio('is_randomizable', 0, TRUE),           
        );
    if ($subject->randomization_date == '0000-00-00') {
    	$subject->randomization_date = "";
    }
?>
<?= form_open('subject/randomization_update', array('class'=>'form-horizontal')); ?>
	<?= form_hidden('id', $subject->id); ?>
	<?= form_hidden('center', $subject->center); ?>
	<?= my_validation_errors(validation_errors()); ?>
	<table class="table table-condensed table-bordered">        
        <tr>
            <td>¿ Es el sujeto elegible para randomizacion ? : </td>
            <td>
            	<?= form_radio($data,$data['value'],set_radio($data['name'],$data['value'],($data['value'] == $subject->is_randomizable) ? true : false)); ?> Si 
            	<?= form_radio($data2,$data2['value'],set_radio($data2['name'],$data2['value'],($data2['value'] == $subject->is_randomizable) ? true : false)); ?> No
            </td>
        </tr>

        <tr class='randomization' style='display:none'>
            <td>Fecha de Randomizacion: </td>
            <td><?= form_input(array('type'=>'text', 'name'=>'randomization_date', 'id'=>'randomization_date', 'readonly'=>'readonly', 'style'=>'cursor: pointer;', 'value'=>set_value('randomization_date',$subject->randomization_date))); ?></td>
        </tr>

		<tr class='buttons_form' style='display:none'>
            <td colspan='2' style='text-align:center;'>
            	<?php
            		if ($subject->randomization_status != 'Record Complete') {
            	?>
            		<?php
						if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'randomization_update')){
					?>
            			<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
            		<?php }?>	
            			<?= anchor('subject/grid/'.$subject->id, 'Back', array('class'=>'btn')); ?>
            	<?php	
            		}else{ ?>
						<?= anchor('subject/grid/'.$subject->id, 'Back', array('class'=>'btn')); ?>
            	<?php }?>
        	</td>
       </tr>
    </table>
<?= form_close(); ?>

