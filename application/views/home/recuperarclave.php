<?= form_open('home/recuperandoclave', array('class'=>'form-horizontal')); ?>
	<legend> Request new password </legend>

	<?= my_validation_errors(validation_errors()); ?>

	<div class="control-group">
		<?= form_label('Username', 'usuario', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'text', 'name'=>'usuario', 'id'=>'usuario', 'value'=>set_value('usuario'))); ?>
	</div>

	<div class="form-actions">
		<?= form_button(array('type'=>'submit', 'content'=>'Submit', 'class'=>'btn btn-primary')); ?>
		<?= anchor('home/index', 'Cancel', array('class'=>'btn')); ?>
	</div>
<?= form_close(); ?>
