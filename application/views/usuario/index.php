<div class="page-header">
	<h1> Users <small>maintenance</small> </h1>
</div>

<?= form_open('usuario/search', array('class'=>'form-search')); ?>
	<?= form_input(array('type'=>'text', 'name'=>'buscar', 'id'=>'buscar', 'placeholder'=>'Search by name...', 'class'=>'input-medium search-query')); ?>	
	<span class="input-group-btn">
    	<button class="btn btn-default" type="submit">Search</button>
    </span>
    <?php
		if(isset($_SESSION['role_options']['usuario']) AND strpos($_SESSION['role_options']['usuario'], 'create')){
	?>
	<?= anchor('usuario/create', 'New', array('class'=>'btn btn-primary')); ?>
	<?php }?>
<?= form_close(); ?>

<table class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th> ID </th>
			<th> Name </th>
			<th> Username </th>
			<th> eMail </th>
			<th> Role </th>
			<th> Center </th>
			<th> Created At </th>
			<th> Updated At </th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($query as $registro): ?>
		<tr>
			<?php
				if(isset($_SESSION['role_options']['usuario']) AND strpos($_SESSION['role_options']['usuario'], 'create')){			
					echo "<td>". anchor('usuario/edit/'.$registro->id, $registro->id) ."</td>";
				}else{
					echo "<td>". $registro->id ."</td>";
				}
			?>
			<td> <?= $registro->name ?> </td>
			<td> <?= $registro->login ?> </td>
			<td> <?= $registro->email ?> </td>
			<td> <?= $registro->perfil_name ?> </td>
			<td> <?= $registro->center ?> </td>
			<td> <?= date("d/m/Y - H:i", strtotime($registro->created)); ?> </td>
			<td> <?= date("d/m/Y - H:i", strtotime($registro->updated)); ?> </td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>