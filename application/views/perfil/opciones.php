<div class="page-header">

	<h1>Roles Options <small>Add / Remove options to a role</small></h1>	

</div>

<?php
foreach($perfiles as $v){
	$arreglo[$v->id] = $v->name;
}
?>

<?= form_open('perfil/search',array('class'=>'form-search'));?>

	<div class="control-group">

		Role: <?= form_dropdown('buscar_id',$arreglo); ?>
		<?= form_button(array('type'=>'submit','content'=>'Search','class'=>'btn'));?>

		<!-- boton pre hechos en boostrap <i class="icon-search"></i>-->

	</div>

<?= form_close();?>

<table class='table table-condensed table-bordered'>

	<thead>

		<tr>
			<th>ID</th>
			<th>Role</th>
			<th>Controller</th>
			<th>Options</th>
		</tr>

	</thead>

	

	<tbody>

		<?php foreach($query as $v){?>

		<tr>
			<td><?= anchor("perfil/editar_opciones/". $v->id,$v->id);?></td>
			<td><?= $v->role;?></td>
			<td><?= ucfirst($v->controller);?></td>
			<td>
			<?php
				$actions = explode(",", $v->actions);
				foreach ($actions as $action) { 
				echo $action ." ". form_checkbox('actions_'. $v->controller .'[]',$action,set_checkbox('actions_'. $v->controller .'[]',$action));
			} 
			?>
			
			</td>
			
		</tr>

		<?php }?>

	</tbody>

</table>