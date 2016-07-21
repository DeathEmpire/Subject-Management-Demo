<div class="page-header">
	<h1>Menu<small> Agregar opciones al menu izquierdo </small> </h1>
</div>

<?= form_open('menu/search', array('class'=>'form-search')); ?>
	<?= form_input(array('type'=>'text', 'name'=>'buscar', 'id'=>'buscar', 'placeholder'=>'Buscar por nombre...', 'class'=>'input-medium search-query')); ?>
	
    	<button class="btn btn-default" type="submit">Buscar</button>
    
	<?= anchor('menu/create', 'Nuevo', array('class'=>'btn btn-primary')); ?>
<?= form_close(); ?>
<br />
<table class="table table-condensed table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th> ID </th>
			<th> Nombre </th>
			<th> Controlador </th>
			<th> Accion </th>
			<th> URL </th>
			<th> Orden </th>
			<th> Creado </th>
			<th> Actualizado </th>
			<!--<th> Accesos</th>-->
		</tr>
	</thead>

	<tbody>
		<?php foreach ($query as $registro): ?>
		<tr>
			<td> <?= anchor('menu/edit/'.$registro->id, $registro->id); ?> </td>
			<td> <?= $registro->name ?> </td>
			<td> <?= $registro->controlador ?> </td>
			<td> <?= $registro->accion ?> </td>
			<td> <?= $registro->url ?> </td>
			<td> <?= $registro->orden ?> </td>
			<td> <?= date("d/m/Y - H:i", strtotime($registro->created)); ?> </td>
			<td> <?= date("d/m/Y - H:i", strtotime($registro->updated)); ?> </td>
			<!--<td> <?php 
				//echo anchor("menu/menu_perfiles/". $registro->id,'<i class="icon-lock"></i>'); 
				?> 
			</td>-->
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>