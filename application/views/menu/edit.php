<?= form_open('menu/update', array('class'=>'form-horizontal')); ?>
	<legend> Actualizar Registro </legend>

	<?= my_validation_errors(validation_errors()); ?>

	<div class="control-group">
		<?= form_label('ID', 'id', array('class'=>'control-label')); ?>
		<span class="uneditable-input"> <?= $registro->id; ?> </span>
		<?= form_hidden('id', $registro->id); ?>
	</div>

	<div class="control-group">
		<?= form_label('Nombre', 'name', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'text', 'name'=>'name', 'id'=>'name', 'value'=>$registro->name)); ?>
	</div>

	<div class="control-group">
		<?= form_label('Controlador', 'controlador', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'text', 'name'=>'controlador', 'id'=>'controlador', 'value'=>$registro->controlador)); ?>
	</div>

	<div class="control-group">
		<?= form_label('Accion', 'accion', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'text', 'name'=>'accion', 'id'=>'accion', 'value'=>$registro->accion)); ?>
	</div>

	<div class="control-group">
		<?= form_label('URL', 'url', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'text', 'name'=>'url', 'id'=>'url', 'value'=>$registro->url)); ?>
	</div>

	<div class="control-group">
		<?= form_label('Orden', 'orden', array('class'=>'control-label')); ?>
		<?= form_input(array('type'=>'number', 'name'=>'orden', 'id'=>'orden', 'value'=>$registro->orden)); ?>
	</div>

	<div class="control-group">
		<?= form_label('Creado', 'created', array('class'=>'control-label')); ?>
		<span class="uneditable-input"> <?= date("d/m/Y - H:i", strtotime($registro->created)); ?> </span>
		<?= form_hidden('created', $registro->created); ?>
	</div>

	<div class="control-group">
		<?= form_label('Modificado', 'updated', array('class'=>'control-label')); ?>
		<span class="uneditable-input"> <?= date("d/m/Y - H:i", strtotime($registro->updated)); ?> </span>
		<?= form_hidden('updated', $registro->updated); ?>
	</div>

	<div class="form-actions">
		<?= form_button(array('type'=>'submit', 'content'=>'Aceptar', 'class'=>'btn btn-primary')); ?>
		<?= anchor('menu/index', 'Cancelar', array('class'=>'btn')); ?>
		<?= anchor('menu/delete/'.$registro->id, 'Eliminar', array('class'=>'btn btn-warning', 'onClick'=>"return confirm('¿Está Seguro?')")); ?>
	</div>
<?= form_close(); ?>
