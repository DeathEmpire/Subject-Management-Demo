<div class="page-header">
	<h1> Opciones del Menu <small> Modificar los menus para un perfil </small> </h1>
	<p><i>No olvidar asignar estas opciones al perfil</i></p>
</div>

<?= form_open('menu_perfil/search', array('class'=>'form-search')); ?>
	<?= form_input(array('type'=>'text', 'name'=>'buscar', 'id'=>'buscar', 'placeholder'=>'Buscar por rol ...', 'class'=>'input-medium search-query')); ?>
	
    	<button class="btn btn-default" type="submit">Buscar</button>
    
	<?= anchor('menu_perfil/create', 'Nuevo', array('class'=>'btn btn-primary')); ?>
<?= form_close(); ?>
<br>
<table class="table table-condensed table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th> ID </th>
			<th> Menu </th>
			<th> Rol </th>
			<th> Creado </th>
			<th> Actualizado </th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($query as $registro): ?>
		<tr>
			<td> <?= anchor('menu_perfil/edit/'.$registro->id, $registro->id); ?> </td>
			<td> <?= $registro->menu_name ?> </td>
			<td> <?= $registro->perfil_name ?> </td>
			<td> <?= date("d/m/Y - H:i", strtotime($registro->created)); ?> </td>
			<td> <?= date("d/m/Y - H:i", strtotime($registro->updated)); ?> </td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
