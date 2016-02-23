<div class="page-header">

	<h1>Perfiles <small>Opciones de los perfiles</small></h1>	

</div>

<?
foreach($perfiles as $v){
	$arreglo[$v->id] = $v->name;
}
?>

<?= form_open('perfil/search',array('class'=>'form-search'));?>

	<div class="control-group">

		<?= form_dropdown('buscar_id',$arreglo); ?>
		<?= form_button(array('type'=>'submit','content'=>'<i class="icon-search"> </i>','class'=>'btn'));?>		

		<!-- boton pre hechos en boostrap <i class="icon-search"></i>-->

	</div>

<?= form_close();?>

<table class='table table-condensed table-bordered'>

	<thead>

		<tr>

			<th>ID</th>

			<th>Perfil</th>

			<th>Controlador</th>

			<th>Opciones Permitidas</th>

		</tr>

	</thead>

	

	<tbody>

		<?php foreach($query as $v){?>

		<tr>

			<td><?= anchor("perfil/editar_opciones/". $v->id,$v->id);?></td>

			<td><?= $v->perfil;?></td>

			<td><?= $v->controlador;?></td>

			<td><?= $v->accion;?></td>

		</tr>

		<?php }?>

	</tbody>

</table>