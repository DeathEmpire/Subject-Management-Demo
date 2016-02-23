
<legend style='text-align:center;'> Subject Report </legend>


<?= form_open('subject/search', array('class'=>'form-search')); ?>
	<?= form_input(array('type'=>'text', 'name'=>'buscar', 'id'=>'buscar', 'placeholder'=>'Search by id...', 'class'=>'input-medium search-query')); ?>	
	<span class="input-group-btn">
    	<button class="btn btn-default" type="submit">Search</button>
    </span>
	<?= anchor('subject/create', 'New', array('class'=>'btn btn-primary')); ?>
<?= form_close(); ?>

<table class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th> Subject ID </th>
			<th> Center </th>
			<th> Initials </th>
			<th> Enrollement Date </th>
			<th> Randomization Date </th>			
		</tr>
	</thead>

	<tbody>
		<?php foreach ($query as $registro): ?>
		<tr>
			<td> <?= anchor('subject/grid/'.$registro->id, $registro->code); ?> </td>
			<td> <?= $registro->center_name ?> </td>
			<td> <?= $registro->initials ?> </td>
			<td> <?= date("d-M-Y", strtotime($registro->screening_date)); ?> </td>
			<td> <?= ( (isset($registro->randomization_date) AND $registro->randomization_date != '0000-00-00') ? date("d-M-Y", strtotime($registro->randomization_date)) : "--" ); ?> </td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>