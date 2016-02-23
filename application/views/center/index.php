
<legend style='text-align:center;'> Centers </legend>


<?= form_open('center/search', array('class'=>'form-search')); ?>
	<?= form_input(array('type'=>'text', 'name'=>'buscar', 'id'=>'buscar', 'placeholder'=>'Search by id...', 'class'=>'input-medium search-query')); ?>	
	<span class="input-group-btn">
    	<button class="btn btn-default" type="submit">Search</button>
    </span>
	<?= anchor('center/create', 'New', array('class'=>'btn btn-primary')); ?>
<?= form_close(); ?>

<table class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th> Center ID </th>
			<th> Center Name </th>			
			<th> Created At </th>			
		</tr>
	</thead>

	<tbody>
		<?php foreach ($query as $registro): ?>
		<tr>
			<td> <?= anchor('center/edit/'.$registro->id, $registro->id); ?> </td>			
			<td> <?= $registro->name ?> </td>
			<td> <?= date("d-M-Y", strtotime($registro->created)); ?> </td>
			
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>