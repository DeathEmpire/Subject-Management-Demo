<div class="page-header">
	<h1>Menu Options<small> Add options to the left menu </small> </h1>
</div>

<?= form_open('menu/search', array('class'=>'form-search')); ?>
	<?= form_input(array('type'=>'text', 'name'=>'buscar', 'id'=>'buscar', 'placeholder'=>'Search by name...', 'class'=>'input-medium search-query')); ?>
	<span class="input-group-btn">
    	<button class="btn btn-default" type="submit">Search</button>
    </span>
	<?= anchor('menu/create', 'New', array('class'=>'btn btn-primary')); ?>
<?= form_close(); ?>

<table class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th> ID </th>
			<th> Name </th>
			<th> Controller </th>
			<th> Action </th>
			<th> URL </th>
			<th> Order </th>
			<th> Created At </th>
			<th> Updated At </th>
			<th> Access</th>
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
			<td> <?= anchor("menu/menu_perfiles/". $registro->id,'<i class="icon-lock"></i>'); ?> </td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>