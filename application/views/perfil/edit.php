<?= form_open("perfil/update",array("class"=>"form-horizontal")); ?>
	<legend>Actualizar Perfil</legend>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden("id",$registro->id);?>
	<table class='table table-bordered table-striped'>
		<tr>
			<td><?= form_label("Nombre: ", 'name', array("class"=>"control-label"));?></td>
			<td><?= form_input(array("type"=>"text","name"=>"name","id"=>"name","value"=>$registro->name));?></td>
		</tr>
		
		<tr>
			<td><?= form_label("Creado: ", 'created', array("class"=>"control-label"));?></td>
			<td>
				<span class="uneditable-input"><?= $registro->created;?></span>
				<?= form_hidden("created",$registro->created);?>
			</td>
		</tr>
		<tr>
			<td><?= form_label("Modificado: ", 'updated', array("class"=>"control-label"));?></td>
			<td>
				<span class="uneditable-input"><?= date("Y-m-d H:i:s");?></span>
				<?= form_hidden("updated",date("Y-m-d H:i:s"));?>
			</td>
		</tr>
		
		<tr>
            <td colspan='2' style='text-align:center;'>
				<?= form_button(array("type"=>"submit","content"=>"Actualizar","class"=>"btn btn-primary")); ?>
				<?= anchor("perfil/index","Cancelar",array("class"=>"btn"));?> 			
			</td>
		</tr>
	</table>

<?= form_close(); ?>