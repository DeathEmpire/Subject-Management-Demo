<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#fecha").attr('readonly','readonly');
			$("#form_columbia :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
		}
		else{
			$("#fecha").removeAttr('readonly');
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#fecha").attr('readonly','readonly');
		$("#form_columbia :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
	}
	else{
		$("#fecha").removeAttr('readonly');
	}

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_columbia :input").attr('readonly','readonly');
			$("#form_columbia :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_columbia :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled', 'disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_columbia :input").attr('readonly','readonly');
		$("#form_columbia :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_columbia :input").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled', 'disabled');
		});
	}

});
</script>

<legend style='text-align:center;'>Escala de Columbia</legend>
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
<!-- legend -->
<?= form_open('subject/escala_de_columbia_insert', array('class'=>'form-horizontal','id'=>'form_columbia')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>			
	 
	<?php
			$data = array(
			    'name'        => 'realizado',			    
			    'value'       => 1,		    
			    #'checked'	  => set_radio('gender', 'male', TRUE),
		    );
	  	$data2 = array(
		    'name'        => 'realizado',			    
		    'value'       => 0,
		    #'checked'	  => set_radio('gender', 'female', TRUE),		    
		    );
		?>
	<table class="table table-bordered table-striper table-hover">
		<tr>
			<td>Realizado:</td>
			<td>
				<?= form_radio($data,$data['value'],set_radio($data['name'], 1)); ?> Si
				<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
			</td>
		</tr>
		<tr>
			<td>Fecha: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?></td>
		</tr>		

		<tr>
			<td colspan='2' style='text-align:center;'>
				<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'tmt_a_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
	        	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
			</td>
		</tr>
	</table>

<?= form_close(); ?>