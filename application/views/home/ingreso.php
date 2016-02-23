<?= form_open('home/ingresar', array('class'=>'form-horizontal')); ?>
	<legend> Login </legend>

	<?= my_validation_errors(validation_errors()); ?>

	<div class="control-group">
		<?= form_label('Username', 'login', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'text', 'name'=>'login', 'id'=>'login', 'placeholder'=>'Username...', 'value'=>set_value('login'))); ?>
	</div>

	<div class="control-group">
		<?= form_label('Password', 'password', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'password', 'name'=>'password', 'id'=>'password', 'value'=>set_value('password'))); ?>
	</div>

	<div style="font-style:italic;text-align:right;"><a href="recuperarclave">forgot password</a></div>
	
	<div class="form-actions">
		<?= form_button(array('type'=>'submit', 'content'=>'Submit', 'class'=>'btn btn-primary')); ?>
		<?= anchor('home/index', 'Cancel', array('class'=>'btn')); ?>
	</div>
<?= form_close(); ?>
	