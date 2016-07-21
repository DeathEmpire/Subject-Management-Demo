<div class="page-header">
	<h1>Perfiles</h1>	
</div>

<?= form_open('perfil/search',array('class'=>'form-search'));?>
	<div class="control-group">
		<?= form_input(array("type"=>"text","name"=>"buscar_nombre","id"=>"buscar_nombre","placeholder"=>"Buscar por nombre ...","value"=>set_value('buscar_nombre'),"class"=>"input-medium"));?>
		
    	<button class="btn btn-default" type="submit">Buscar</button>
   		
		<?= anchor("perfil/ingresar","Nuevo",array("class"=>"btn btn-primary"));?>
		<!-- boton pre hechos en boostrap <i class="icon-search"></i>-->
	</div>
<?= form_close();?>
<br />

<table class='table table-condensed table-bordered'>
	<thead>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Creado</th>
			<th>Actualizado</th>
		</tr>
	</thead>
	
	<tbody>
		<?php foreach($query as $v){?>
		<tr>
			<td><?= anchor("perfil/edit/". $v->id,$v->id);?></td>
			<td><?= $v->name;?></td>
			<td><?= date("d/m/Y H:i:s",strtotime($v->created));?></td>
			<td><?= date("d/m/Y H:i:s",strtotime($v->updated));?></td>
		</tr>
		<?php }?>
	</tbody>
</table>