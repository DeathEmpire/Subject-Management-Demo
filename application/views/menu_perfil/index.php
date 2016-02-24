<div class="page-header">
	<h1> Roles Menu <small>Add a menu option to a specific user role </small> </h1>
</div>

<?= form_open('menu_perfil/search', array('class'=>'form-search')); ?>
	<?= form_input(array('type'=>'text', 'name'=>'buscar', 'id'=>'buscar', 'placeholder'=>'Search by role...', 'class'=>'input-medium search-query')); ?>
	<span class="input-group-btn">
    	<button class="btn btn-default" type="submit">Search</button>
    </span>
	<?= anchor('menu_perfil/create', 'New', array('class'=>'btn btn-primary')); ?>
<?= form_close(); ?>

<table class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th> ID </th>
			<th> Menu </th>
			<th> Role </th>
			<th> Created At </th>
			<th> Updated At </th>
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
