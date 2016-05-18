<?= form_open('menu_perfil/insert', array('class'=>'form-horizontal')); ?>
	<legend>Nuevo Registro</legend>
	
	<?= my_validation_errors(validation_errors()); ?>
	
	<div class="control-group">
		<?= form_label("Opcion del Menu",'menu_id',array("class"=>"control-label")); ?>
		<?= form_dropdown('menu_id', $menus, 0); ?>		
	</div>
	
	<div class="control-group">
		<?= form_label("Perfil", "perfil_id",array("class" => "control-label")); ?>
		<?= form_dropdown('perfil_id', $perfiles, 0); ?> 
		<!--form_multiselect('perfil_id', $perfiles, array(1)); //se le para al arreglo los ids de los selecionados-->
	</div>
	
	<div class="form-actions">
		<?= form_button(array("type"=>"submit",'content'=>'Enviar','class'=>'btn btn-primary')); ?>
		<?= anchor("menu_perfil/index","Cancelar", array("class"=>"btn")); ?>
	</div>
<?= form_close(); ?>