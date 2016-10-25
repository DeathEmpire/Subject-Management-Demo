<div class="page-header">

	<h1> Correos <small> Lista de Correos </small> </h1>

</div>



<?= form_open('correos/search', array('class'=>'form-search')); ?>

	<?= form_input(array('type'=>'text', 'name'=>'buscar', 'id'=>'buscar', 'placeholder'=>'Buscar por nombre', 'class'=>'input-medium search-query')); ?>

	<?= form_button(array('type'=>'submit', 'content'=>'<i class="fa fa-search"> </i>', 'class'=>'btn')); ?>

	<?= anchor('correos/create', 'Agregar', array('class'=>'btn btn-primary')); ?>

<?= form_close(); ?>

<p style='text-align:center;font-style:italic;'>Para utilizar una <b>nueva</b> lista de correos debe contactarse con el desarrollador.</p>

<table class="table table-condensed table-bordered">

	<thead>

		<tr>

			<th> ID </th>

			<th> Nombre </th>		

			<th> Centro </th>
			
			<th> Descripcion </th>	
			
			<th> Correos </th>		
					

		</tr>

	</thead>



	<tbody>

		<?php 
			if(isset($query) AND count($query) > 0){
			foreach ($query as $registro): ?>

		<tr>

			<td> <? echo "<a href='". $this->config->base_url() ."correos/edit/".$registro->id."'>". $registro->id ."</a>"; ?> </td>
			<td> <?= $registro->nombre ?> </td>
			<td> <?= $registro->centro ?> </td>				
			<td> <?= $registro->descripcion ?> </td>			
			<td> <?= $registro->correos ?> </td>	
		</tr>

		<?php endforeach; } ?>

	</tbody>

</table>