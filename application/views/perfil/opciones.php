<div class="page-header">

	<h1>Opciones de Roles <small>Agregar o remover opciones de un Rol</small></h1>	

</div>

<?php
foreach($perfiles as $v){
	$arreglo[$v->id] = $v->name;
}
?>

<?= form_open('perfil/search',array('class'=>'form-search'));?>

	<div class="control-group">

		Role: <?= form_dropdown('buscar_id',$arreglo); ?>
		<?= form_button(array('type'=>'submit','content'=>'Filtrar','class'=>'btn'));?>

		<!-- boton pre hechos en boostrap <i class="icon-search"></i>-->

	</div>

<?= form_close();?>

<table class='table table-condensed table-bordered'>

	<thead>

		<tr>			
			<th>Rol</th>
			<th>Seccion</th>
			<th>Opciones</th>
		</tr>

	</thead>

	

	<tbody>
	
		<?php 
		if(isset($opciones) AND !empty($opciones)){
			foreach($opciones as $v){

				switch ($v->controller) {
					case 'center':
						$seccion = 'Centros';
						break;
					case 'home':
						$seccion = 'Principal';
						break;
					case 'menu':
						$seccion = 'Menus';
						break;
					case 'menu_perfil':
						$seccion = 'Menu de Roles';
						break;
					case 'perfil':
						$seccion = 'Perfiles';
						break;
					case 'usuario':
						$seccion = 'Usuarios';
						break;
					case 'subject':
						$seccion = 'Sujetos';
						break;						
					case 'to_do':
						$seccion = 'Pendientes';
						break;	
					case 'query':
						$seccion = 'Consultas';
						break;
					case 'audit':
						$seccion = 'Auditoria';
						break;		
					default:
						$seccion = $v->controller;
						break;
				}

				?>

			

				<tr>
					<!--<td><?php 
						//echo anchor("perfil/editar_opciones/". $v->id,$v->id);
					?></td>-->
					<td><?= $v->role_name;?></td>
					<td><?= $seccion;?></td>
					<td>
					<?php

						/*Opciones segun la seccion*/
						if($seccion == 'Principal'){
							echo form_checkbox(array('name'=>'ingresar_al_sistema', 'value'=>'index,cambio_clave,salir,acceso_denegado,ingreso,ingresar,loginok,cambiar_clave,cambiook,recuperarclave,recuperandoclave,existeusuario', 'perfil'=>$v->role, 'controller'=>$v->controller, 'checked'=>true))
							. " Ingresar al Sistema";
						}
						elseif($seccion == 'Centros'){
							echo form_checkbox(array('name'=>'ver_centros', 'value'=>'index,search', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
							echo form_checkbox(array('name'=>'crear_centros', 'value'=>'create,insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Crear<br>";
							echo form_checkbox(array('name'=>'editar_centros', 'value'=>'edit,update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
						}
						elseif($seccion == 'Menus'){
							echo form_checkbox(array('name'=>'ver_menus', 'value'=>'index,search,my_validation,menu_perfiles,mp_noasig,mp_asig', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
							echo form_checkbox(array('name'=>'crear_menus', 'value'=>'create,insert,my_validation,menu_perfiles,mp_noasig,mp_asig', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Crear<br>";
							echo form_checkbox(array('name'=>'editar_menus', 'value'=>'edit,update,my_validation,menu_perfiles,mp_noasig,mp_asig', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
							echo form_checkbox(array('name'=>'eliminar_menus', 'value'=>'delete,my_validation,menu_perfiles,mp_noasig,mp_asig', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Eliminar<br>";							      
						}
						elseif($seccion == 'Menu de Roles'){
							echo form_checkbox(array('name'=>'ver_menu_perfil', 'value'=>'index,search,my_validation', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
							echo form_checkbox(array('name'=>'crear_menu_perfil', 'value'=>'create,insert,my_validation', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Crear<br>";
							echo form_checkbox(array('name'=>'editar_menu_perfil', 'value'=>'edit,update,my_validation', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
							echo form_checkbox(array('name'=>'eliminar_menu_perfil', 'value'=>'delete,my_validation', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Eliminar<br>";							      								    
						}
						elseif($seccion == 'Perfiles'){
							echo form_checkbox(array('name'=>'ver_perfil', 'value'=>'index,search,norep,ingresar,opciones', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
							echo form_checkbox(array('name'=>'crear_perfil', 'value'=>'create,insert,norep,ingresar,opciones', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Crear<br>";
							echo form_checkbox(array('name'=>'editar_perfil', 'value'=>'edit,update,norep,ingresar,opciones', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
							echo form_checkbox(array('name'=>'eliminar_perfil', 'value'=>'delete,norep,ingresar,opciones', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Eliminar<br>";							      								    							    
						}
						elseif($seccion == 'Usuarios'){
							echo form_checkbox(array('name'=>'ver_usuarios', 'value'=>'index,search', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
							echo form_checkbox(array('name'=>'crear_usuarios', 'value'=>'create,insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Crear<br>";
							echo form_checkbox(array('name'=>'editar_usuarios', 'value'=>'edit,update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
							echo form_checkbox(array('name'=>'eliminar_usuarios', 'value'=>'delete', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Eliminar<br>";							      								    							    
						}
						elseif($seccion == 'Auditoria'){
							echo form_checkbox(array('name'=>'ver_auditoria', 'value'=>'index,show,search', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";							
						}
						elseif($seccion == 'Pendientes'){
							echo form_checkbox(array('name'=>'ver_pendientes', 'value'=>'index,earch,create,edit,insert,update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
						}				
						elseif($seccion == 'Consultas'){
							echo "<div style='font-weight:bold;'>Demografia</div>";
							echo form_checkbox(array('name'=>'ver_demografia_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
							echo form_checkbox(array('name'=>'agregar_demografia_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
							echo form_checkbox(array('name'=>'responder_demografia_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Responder<br>";
							#demography_query_new  demography_query_insert  demography_query_show  demography_query_update  additional_form_query_new additional_form_query_insert  additional_form_query_show  additional_form_query_update 
							
							echo "<div style='font-weight:bold;'>Hachinski Modificado</div>";							
							echo form_checkbox(array('name'=>'ver_hachinski_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
							echo form_checkbox(array('name'=>'agregar_hachinski_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
							echo form_checkbox(array('name'=>'responder_hachinski_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Responder<br>";
							
							echo "<div style='font-weight:bold;'>Historial Medico</div>";							
							echo form_checkbox(array('name'=>'ver_historial_medico_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
							echo form_checkbox(array('name'=>'agregar_historial_medico_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
							echo form_checkbox(array('name'=>'responder_historial_medico_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Responder<br>";

							echo "<div style='font-weight:bold;'>Inclusion Exclusion</div>";							
							echo form_checkbox(array('name'=>'ver_inclusion_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
							echo form_checkbox(array('name'=>'agregar_inclusion_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
							echo form_checkbox(array('name'=>'responder_inclusion_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Responder<br>";

							echo "<div style='font-weight:bold;'>Formularios Adicionales</div>";							
							echo form_checkbox(array('name'=>'ver_adicional_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
							echo form_checkbox(array('name'=>'agregar_adicional_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
							echo form_checkbox(array('name'=>'responder_adicional_consulta', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Responder<br>";							

						}			
						elseif ($seccion == 'Sujetos') {
							echo "<div style='font-weight:bold;'>Sujetos</div>";
								echo form_checkbox(array('name'=>'ver_sujetos_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_sujetos_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'responder_sujetosv_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";

							echo "<div style='font-weight:bold;'>Formulario Demografia</div>";
								echo form_checkbox(array('name'=>'ver_demografia_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_demografia_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'responder_sujetos_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";

							echo "<div style='font-weight:bold;'>Formulario Inclusion Exclusion</div>";
								echo form_checkbox(array('name'=>'ver_inclusion_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_inclusion_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'responder_inclusion_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";

							echo "<div style='font-weight:bold;'>Formulario Hachinski</div>";
								echo form_checkbox(array('name'=>'ver_hachinski_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_hachinski_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'responder_hachinski_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";

							echo "<div style='font-weight:bold;'>Formulario Historial Medico</div>";
								echo form_checkbox(array('name'=>'ver_historila_medico_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_historila_medico_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'responder_historila_medico_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";

							echo "<div style='font-weight:bold;'>Randomizacion</div>";
								echo form_checkbox(array('name'=>'ver_randomizacion_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_randomizacion_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'responder_randomizacion_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";

							#index  search  my_validation  create  insert  edit  update  grid  demography  demography_update  randomization  randomization_update adverse_event_form  adverse_event_form_insert  adverse_event_show  protocol_deviation_form  protocol_deviation_form_insert  protocol_deviation_show concomitant_medication_form  concomitant_medication_form_insert  concomitant_medication_show 						
						}						
						else{
							$actions = explode(",", $v->actions);
							foreach ($actions as $action) { 
								echo $action ." ". form_checkbox('actions_'. $v->controller .'[]',$action,set_checkbox('actions_'. $v->controller .'[]',$action));
							}
						}
					?>
					
					</td>
					
				</tr>

		<?php 
			}
		}
	?>

	</tbody>

</table>