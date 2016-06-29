
<legend style='text-align:center;'> Sujetos </legend>


<?= form_open('subject/search', array('class'=>'form-search')); ?>
	<?= form_input(array('type'=>'text', 'name'=>'buscar', 'id'=>'buscar', 'placeholder'=>'Buscar por id...', 'class'=>'input-medium search-query')); ?>	
	<span class="input-group-btn">
    	<button class="btn btn-default" type="submit">Buscar</button>
    </span>
    <?php
	if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'create')){
				?>
		<?= anchor('subject/create', '+ Nuevo', array('class'=>'btn btn-primary')); ?>			
	<?php } ?>
	
<?= form_close(); ?>
<table class="table table-condensed table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th> ID del sujeto </th>
			<th> Centro </th>
			<th> Iniciales </th>
			<th> Fecha de Ingreso </th>
			<th> Fecha de Randomizacion </th>			
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