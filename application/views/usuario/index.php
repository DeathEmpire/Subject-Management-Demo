<div>
	<div class="page-header">
		<h1> Usuarios </h1>
	</div>

	<?= form_open('usuario/search', array('class'=>'form-search')); ?>
		<?= form_input(array('type'=>'text', 'name'=>'buscar', 'id'=>'buscar', 'placeholder'=>'Buscar por nombre ...', 'class'=>'input-medium search-query')); ?>	
		
	    	<button class="btn btn-default" type="submit">Buscar</button>
	    	<?php
			if(isset($_SESSION['role_options']['usuario']) AND strpos($_SESSION['role_options']['usuario'], 'create')){
			?>
				<?= anchor('usuario/create', 'Nuevo', array('class'=>'btn btn-primary')); ?>
			<?php }?>
	    
	    
	<?= form_close(); ?>
	<br />
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th> ID </th>
				<th> Nombre </th>
				<th> Username </th>
				<th> eMail </th>
				<th> Perfil </th>
				<th> Centro </th>
				<th> Creado </th>
				<th> Actualizado </th>
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
</div>