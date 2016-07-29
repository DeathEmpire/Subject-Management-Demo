<?= form_open('menu_perfil/insert', array('class'=>'form-horizontal')); ?>
	<legend>Nuevo Registro</legend>
	
	<?= my_validation_errors(validation_errors()); ?>
	
	<table class='table table-bordered'>
		<tr>
			<td><?= form_label("Opcion del Menu",'menu_id',array("class"=>"control-label")); ?></td>				
			<td><?= form_dropdown('menu_id', $menus, 0); ?></td>
		</tr>	
		<tr>
			<td><?= form_label("Perfil", "perfil_id",array("class" => "control-label")); ?></td>
			<td><?= form_dropdown('perfil_id', $perfiles, 0); ?></td> 
		</tr>
		<tr>
			<td colspan='2' style='text-align:center;'>
				<?= form_button(array("type"=>"submit",'content'=>'Enviar','class'=>'btn btn-primary')); ?>
				<?= anchor("menu_perfil/index","Cancelar", array("class"=>"btn")); ?>
			</td>
		</tr>
	
	</table>
<?= form_close(); ?>