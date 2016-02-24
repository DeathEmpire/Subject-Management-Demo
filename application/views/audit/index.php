<div class="page-header">
	<h1>Audit</h1>
</div>

<?= form_open('audit/search', array('class'=>'form-search')); ?>
	<?= form_input(array('type'=>'text', 'name'=>'buscar', 'id'=>'buscar', 'placeholder'=>'Search by name...', 'class'=>'input-medium search-query')); ?>	
	<span class="input-group-btn">
    	<button class="btn btn-default" type="submit">Search</button>
    </span>	
<?= form_close(); ?>

<table class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th> ID </th>			
			<th> User Name</th>
			<th> Description </th>
			<th> Date </th>			
		</tr>
	</thead>
	<tbody>
		<?php foreach ($query as $registro): ?>
		<tr>
			<td> <?= $registro->id; ?> </td>
			<td> <?= $registro->user_name ?> </td>			
			<td> <?= $registro->description ?> </td>			
			<td> <?= date("d-M-Y - H:i:s", strtotime($registro->date)); ?> </td>			
		</tr>
		<?php endforeach; ?>
		<tr><td colspan='4' style='text-align:right;'><?= $links; ?></td></tr>
	</tbody>
</table>