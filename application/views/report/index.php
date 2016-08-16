<legend style='text-align:center;'>Reportes</legend>


<?= form_open('report/buscar'); ?>
	<table class="table table-striped table-bordered">
		<tr>
			<td>Formulario: </td>
			<td><?= form_dropdown('formulario', $forms, set_value('formulario')); ?></td>
			<td><?= form_button(array('type'=>'submit', 'content'=>'Buscar', 'class'=>'btn btn-primary')); ?></td>
		</tr>
		<tr>
			<td colspan='3'><?= my_validation_errors(validation_errors()); ?></td>
		</tr>
	</table>

<?= form_close(); ?>

<?php if(isset($list) AND !empty($list)){ 

	echo $list;

} ?>