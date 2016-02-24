<div class="page-header">
	<h1>Roles <small>Maintenance</small></h1>	
</div>

<?= form_open('perfil/search',array('class'=>'form-search'));?>
	<div class="control-group">
		<?= form_input(array("type"=>"text","name"=>"buscar_nombre","id"=>"buscar_nombre","placeholder"=>"Search by name...","value"=>set_value('buscar_nombre'),"class"=>"input-medium"));?>
		<span class="input-group-btn">
    		<button class="btn btn-default" type="submit">Search</button>
   		</span>
		<?= anchor("perfil/ingresar","New",array("class"=>"btn btn-primary"));?>
		<!-- boton pre hechos en boostrap <i class="icon-search"></i>-->
	</div>
<?= form_close();?>


<table class='table table-condensed table-bordered'>
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Created At</th>
			<th>Updated At</th>
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