<?= form_open("perfil/insert",array("class"=>"form-horizontal")); ?>
	<legend>Crear Perfil</legend>
	
	<?= my_validation_errors(validation_errors()); ?>
	
	<div class="control-group">
		<?= form_label("Nombre: ", 'name', array("class"=>"control-label"));?>
		<?= form_input(array("type"=>"text","name"=>"name","id"=>"name","placeholder"=>"Nombre..."));?>
	</div>
	
	<div class="form-actions">
		<?= form_button(array("type"=>"submit","content"=>"Ingresar","class"=>"btn btn-primary")); ?>
		<?= anchor("perfil/index","Cancelar",array("class"=>"btn"));?> 
	</div>

<?= form_close(); ?>