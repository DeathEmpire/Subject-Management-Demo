<?= form_open("perfil/update",array("class"=>"form-horizontal")); ?>
	<legend>Actualizar Perfil</legend>
	
	<?= my_validation_errors(validation_errors()); ?>
	
	<div class="control-group">
		<?= form_label("ID: ", 'id', array("class"=>"control-label"));?>
		<span class="uneditable-input"><?= $registro->id;?></span>
		<?= form_hidden("id",$registro->id);?>
	</div>
	
	<div class="control-group">
		<?= form_label("Nombre: ", 'name', array("class"=>"control-label"));?>
		<?= form_input(array("type"=>"text","name"=>"name","id"=>"name","value"=>$registro->name));?>
	</div>
	
	<div class="control-group">
		<?= form_label("Creado: ", 'created', array("class"=>"control-label"));?>
		<span class="uneditable-input"><?= $registro->created;?></span>
		<?= form_hidden("created",$registro->created);?>
	</div>
	<div class="control-group">
		<?= form_label("Modificado: ", 'updated', array("class"=>"control-label"));?>
		<span class="uneditable-input"><?= date("Y-m-d H:i:s");?></span>
		<?= form_hidden("updated",date("Y-m-d H:i:s"));?>
	</div>
	
	<div class="form-actions">
		<?= form_button(array("type"=>"submit","content"=>"Actualizar","class"=>"btn btn-primary")); ?>
		<?= anchor("perfil/index","Cancel",array("class"=>"btn"));?> 
		<?= anchor("perfil/eliminar/". $registro->id,"Delete",array("class"=>"btn btn-warning","onclick"=>"return confirm('Are you Sure?')"));?> 
	</div>

<?= form_close(); ?>