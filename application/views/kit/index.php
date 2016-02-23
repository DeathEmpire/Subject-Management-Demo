<div class="page-header">
	<h1> Kits <small> List of Kits </small> </h1>
</div>
<?php 	
	if(!isset($id)){
		$id = "";
	}
	
	if(!isset($tipo)){
		$tipo = "";
		$t_selected = "";
	}
	else{
		$t_selected = $tipo;
	}
	
	if(!isset($ubicacion_actual)){
		$ubicacion_actual = "X";
		$c_selected = "X";
	}
	else{
		$c_selected = $ubicacion_actual;
	}
	
	if(!isset($disponible)){		
		$d_selected = "";
	}
	else{
		$d_selected = $disponible;
	}
	

	
	$cent = array();
	
	if(isset($centers)){
		foreach($centers as $k => $v){
			$cent[$v->id] = $v->name;
		}
	}

	$centros = array();
	$centros['Search by location'] = array("X"=>"","00"=>"Central Warehouse") + $cent;
	
	//$centros = array();
	//$centros['Search by location'] = array("X"=>"","00"=>"Central Warehouse","01"=>"01","02"=>"02","03"=>"03","04"=>"04");
	
	$centros2 = array();
	$centros2 = array(""=>"","01"=>"01","02"=>"02","03"=>"03","04"=>"04");
	
	$tipos = array();
	$tipos['Search by type'] = array(""=>"", "A"=>"A", "P"=>"P");
	
	$disponibles = array();
	$disponibles['Disponible'] = array(""=>"", "1"=>"SI", "NO"=>"NO");
?>
<?= form_open('kit/search', array('class'=>'form-search')); ?>
	<?= form_label('Search: ', 'id', array('class'=>'control-label')); ?>   	
	<?= form_input(array('type'=>'text', 'name'=>'id', 'id'=>'id', 'placeholder'=>'Search by id', 'class'=>'input-medium search-query', 'value'=>$id)); ?>
	<?= form_dropdown('tipo',$tipos,$t_selected); ?>
	<?= form_dropdown('ubicacion_actual',$centros,$c_selected); ?>
	<?= form_dropdown('disponible',$disponibles,$d_selected); ?>
	
	<?= form_button(array('type'=>'submit', 'content'=>'Serach', 'class'=>'btn')); ?>
	<!--anchor('medicamentos/create', 'Agregar', array('class'=>'btn btn-primary'));-->
<?= form_close(); ?>

<table class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th>To Assign</th>
			<th> KIT </th>
			<th> Type </th>
			<th> Available </th>
			<th> Center </th>			
			<th> Subject </th>			
		</tr>
	</thead>

	<tbody>
		<?= form_open("kit/CambiarBodega"); ?>
		<?php foreach ($query as $registro): ?>
		<tr>
			<?php if($registro->center_id == 0){
				echo "<td><input type='checkbox' name='cambiar[]' class='cambiar' value='". $registro->id ."' /></td>";
			}
			else{
				echo "<td>&nbsp;</td>";
			}	
			?>
			<td> <?= $registro->id ?> </td>
			<td> <?= $registro->type ?> </td>
			<td> <?= $registro->available ?> </td>
			<td> <?= ($registro->center_id == 0) ? "Central Warehouse" : $registro->name ?> </td>			
			<td> <?= $registro->subject_id ?> </td>			
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<hr />
<div style="text-align:center;">
	
	Send Center: <?= form_dropdown('center',$cent); ?><br />
	<?= form_button(array('type'=>'submit', 'class'=>'btn', 'name'=>'enviar', "id"=>"enviar", "onclick"=>"return enviar();",'content'=>'Submit')); ?>
	<?= form_close(); ?>
</div>
<script>
$(function(){
	
	$.fn.valList = function(){
		return $.map( this, function (elem) {
			  return elem.value || "";
		}).join( "," );
	};
	
	function enviar(){
		var seleccionado = $("input:checked").valList(); 
		if(seleccionado == ""){
			alert("You must select at least one kit to send");
			return false;
		}
		else if($("select[name^=centros]").val() == ""){
			alert("You must select the center to which the kits will be sent");
			return false;
		}
		else{
			if(confirm("Sure to send the kits "+ seleccionado + " to center "+ $("select[name^=centros]").val())){
				return true;
			}
			else{
				return false;
			}
		}
	}

/*
	$("#enviar").click(function(){
		// Validar que por lo menos tenga un medicamento seleccionado y el centro luego mostrar resumen de lo seleccionado apra enviar

		
		var seleccionado = $("input:checked").valList(); 
		if(seleccionado == ""){
			alert("You must select at least one kit to send");
			return false;
		}
		else if($("select[name^=centros]").val() == ""){
			alert("You must select the center to which the kits will be sent");
			return false;
		}
		else{
			if(confirm("Sure to send the kits "+ seleccionado + " to center "+ $("select[name^=centros]").val())){
				$.post("CambiarBodega",
						{
							//"SubjectManagement" : $("input[name=SubjectManagement]").val(),
							"medicamento":seleccionado,
							"bodega":$("select[name^=centros]").val()
						},
					function(d){
						if(d == ""){
							location.reload();							
						}
						else{
							location.reload();
						}						
					}
				);
			}
			else{
				return false;
			}
		}
	});*/
	
})
</script>