<?= form_open('menu/insert', array('class'=>'form-horizontal')); ?>
	<legend> New Menu Option </legend>

	<?= my_validation_errors(validation_errors()); ?>

	<div class="control-group">
		<?= form_label('Name', 'name', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'text', 'name'=>'name', 'id'=>'name', 'value'=>set_value('name'))); ?>
	</div>

	<div class="control-group">
		<?= form_label('Controller', 'controlador', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'text', 'name'=>'controlador', 'id'=>'controlador', 'value'=>set_value('controlador'))); ?>
	</div>

	<div class="control-group">
		<?= form_label('Action', 'accion', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'text', 'name'=>'accion', 'id'=>'accion', 'value'=>set_value('accion'))); ?>
	</div>

	<div class="control-group">
		<?= form_label('URL', 'url', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'text', 'name'=>'url', 'id'=>'url', 'value'=>set_value('url'))); ?>
	</div>

	<div class="control-group">
		<?= form_label('Order', 'orden', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'number', 'name'=>'orden', 'id'=>'orden', 'value'=>set_value('orden'))); ?>
	</div>

	<div class="form-actions">
		<?= form_button(array('type'=>'submit', 'content'=>'Submit', 'class'=>'btn btn-primary')); ?>
		<?= anchor('menu/index', 'Cancel', array('class'=>'btn')); ?>
	</div>
<?= form_close(); ?>
