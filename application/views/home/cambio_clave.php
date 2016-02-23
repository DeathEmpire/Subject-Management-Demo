<?= form_open('home/cambiar_clave', array('class'=>'form-horizontal')); ?>
	<legend> Change Password </legend>

	<?= my_validation_errors(validation_errors()); ?>

	<div class="control-group">
		<?= form_label('Current Password', 'clave_act', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'password', 'name'=>'clave_act', 'id'=>'clave_act', 'value'=>set_value('clave_act'))); ?>
	</div>

	<div class="control-group">
		<?= form_label('New Password', 'clave_new', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'password', 'name'=>'clave_new', 'id'=>'clave_new', 'value'=>set_value('clave_new'))); ?>
	</div>

	<div class="control-group">
		<?= form_label('Reenter New Password', 'clave_rep', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'password', 'name'=>'clave_rep', 'id'=>'clave_rep', 'value'=>set_value('clave_rep'))); ?>
	</div>

	<div class="form-actions">
		<?= form_button(array('type'=>'submit', 'content'=>'Confirm', 'class'=>'btn btn-primary')); ?>
		<?= anchor('home/index', 'Cancel', array('class'=>'btn')); ?>
	</div>
<?= form_close(); ?>
