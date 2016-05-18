<?= form_open('home/recuperandoclave', array('class'=>'form-horizontal')); ?>
	<legend> Recuperar password </legend>

	<?= my_validation_errors(validation_errors()); ?>

	<div class="control-group">
		<?= form_label('Nombre de Usuario', 'usuario', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'text', 'name'=>'usuario', 'id'=>'usuario', 'value'=>set_value('usuario'))); ?>
	</div>

	<div class="form-actions">
		<?= form_button(array('type'=>'submit', 'content'=>'Enviar', 'class'=>'btn btn-primary')); ?>
		<?= anchor('home/index', 'Cancelar', array('class'=>'btn')); ?>
	</div>
<?= form_close(); ?>
