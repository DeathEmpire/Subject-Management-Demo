<div class="page-header">

	<h1>Opciones del Perfil <small>Agregar o remover opciones de un Perfil</small></h1>	

</div>

<?php
foreach($perfiles as $v){
	$arreglo[$v->id] = $v->name;
}
?>

<?= form_open('perfil/search',array('class'=>'form-search'));?>

	<div class="control-group">

		Perfil: <?= form_dropdown('buscar_id',$arreglo); ?>
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

				if($seccion == 'Principal'){
					continue;
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
							echo form_checkbox(array('name'=>'ver_consulta', 'value'=>'demography_query_show,additional_form_query_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
							echo form_checkbox(array('name'=>'agregar_consulta', 'value'=>'demography_query_new,demography_query_insert,demography_query_show,additional_form_query_new,additional_form_query_insert,additional_form_query_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
							echo form_checkbox(array('name'=>'responder_consulta', 'value'=>'demography_query_show,demography_query_update,additional_form_query_show,additional_form_query_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Responder<br>";							
						}			
						elseif ($seccion == 'Sujetos') {
							echo "<div style='font-weight:bold;'>Sujetos</div>";
								echo form_checkbox(array('name'=>'ver_sujetos_form', 'value'=>'index,search,my_validation,grid', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_sujetos_form', 'value'=>'create,insert,my_validation,grid', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_sujetos_form', 'value'=>'edit,update,my_validation,grid', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";

							echo "<div style='font-weight:bold;'>Formulario ADAS COG</div>";
								echo form_checkbox(array('name'=>'ver_adas_form', 'value'=>'adas_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_adas_form', 'value'=>'adas,adas_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_adas_form', 'value'=>'adas_show,adas_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_adas', 'value'=>'adas_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_adas', 'value'=>'adas_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_adas', 'value'=>'adas_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";		

							echo "<div style='font-weight:bold;'>Formulario Apatia</div>";
								echo form_checkbox(array('name'=>'ver_apatia_form', 'value'=>'apatia_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_apatia_form', 'value'=>'apatia,apatia_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_apatia_form', 'value'=>'apatia_show,apatia_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_apatia', 'value'=>'apatia_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_apatia', 'value'=>'apatia_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_apatia', 'value'=>'apatia_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";		

							echo "<div style='font-weight:bold;'>Formulario Cumplimiento</div>";
								echo form_checkbox(array('name'=>'ver_cumplimiento_form', 'value'=>'cumplimiento_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_cumplimiento_form', 'value'=>'cumplimiento,cumplimiento_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_cumplimiento_form', 'value'=>'cumplimiento_show,cumplimiento_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_cumplimiento', 'value'=>'cumplimiento_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_cumplimiento', 'value'=>'cumplimiento_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_cumplimiento', 'value'=>'cumplimiento_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";			

							echo "<div style='font-weight:bold;'>Formulario Demografia</div>";
								echo form_checkbox(array('name'=>'ver_demografia_form', 'value'=>'demography,grid', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_demografia_form', 'value'=>'demography_update,grid', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_demografia_form', 'value'=>'demography_update,grid', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_demografia', 'value'=>'demography_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_demografia', 'value'=>'demography_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_demografia', 'value'=>'demography_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";

							echo "<div style='font-weight:bold;'>Formulario Digito Directo</div>";
								echo form_checkbox(array('name'=>'ver_digito_directo_form', 'value'=>'digito_directo_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_digito_directo_form', 'value'=>'digito_directo,digito_directo_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_digito_directo_form', 'value'=>'digito_directo_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_digito_directo', 'value'=>'digito_directo_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_digito_directo', 'value'=>'digito_directo_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_digito_directo', 'value'=>'digito_directo_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";

							echo "<div style='font-weight:bold;'>Formulario ECG</div>";
								echo form_checkbox(array('name'=>'ver_ecg_form', 'value'=>'ecg_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_ecg_form', 'value'=>'ecg,ecg_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_ecg_form', 'value'=>'ecg_show,ecg_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_ecg', 'value'=>'ecg_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_ecg', 'value'=>'ecg_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_ecg', 'value'=>'ecg_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";	

							echo "<div style='font-weight:bold;'>Formulario EQ-5D-5L</div>";
								echo form_checkbox(array('name'=>'ver_eq_5d_5l_form', 'value'=>'eq_5d_5l_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_eq_5d_5l_form', 'value'=>'eq_5d_5l,eq_5d_5l_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_eq_5d_5l_form', 'value'=>'eq_5d_5l_show,eq_5d_5l_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_eq_5d_5l', 'value'=>'eq_5d_5l_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_eq_5d_5l', 'value'=>'eq_5d_5l_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_eq_5d_5l', 'value'=>'eq_5d_5l_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";		

							echo "<div style='font-weight:bold;'>Formulario Examen Fisico</div>";
								echo form_checkbox(array('name'=>'ver_examen_fisico_form', 'value'=>'examen_fisico_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_examen_fisico_form', 'value'=>'examen_fisico,examen_fisico_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_examen_fisico_form', 'value'=>'examen_fisico_show,examen_fisico_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_examen_fisico', 'value'=>'examen_fisico_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_examen_fisico', 'value'=>'examen_fisico_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_examen_fisico', 'value'=>'examen_fisico_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";			

							echo "<div style='font-weight:bold;'>Formulario Examen Laboratorio</div>";
								echo form_checkbox(array('name'=>'ver_examen_laboratorio_form', 'value'=>'examen_laboratorio_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_examen_laboratorio_form', 'value'=>'examen_laboratorio,examen_laboratorio_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_examen_laboratorio_form', 'value'=>'examen_laboratorio_show,examen_laboratorio_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_examen_laboratorio', 'value'=>'examen_laboratorio_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_examen_laboratorio', 'value'=>'examen_laboratorio_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_examen_laboratorio', 'value'=>'examen_laboratorio_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";	

							echo "<div style='font-weight:bold;'>Formulario Examen Neurologico</div>";
								echo form_checkbox(array('name'=>'ver_examen_neurologico_form', 'value'=>'examen_neurologico_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_examen_neurologico_form', 'value'=>'examen_neurologico,examen_neurologico_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_examen_neurologico_form', 'value'=>'examen_neurologico_show,examen_neurologico_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_examen_neurologico', 'value'=>'examen_neurologico_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_examen_neurologico', 'value'=>'examen_neurologico_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_examen_neurologico', 'value'=>'examen_neurologico_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";	

							echo "<div style='font-weight:bold;'>Formulario Fin Tratamiento</div>";
								echo form_checkbox(array('name'=>'ver_fin_tratamiento_form', 'value'=>'fin_tratamiento_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_fin_tratamiento_form', 'value'=>'fin_tratamiento,fin_tratamiento_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_fin_tratamiento_form', 'value'=>'fin_tratamiento_show,fin_tratamiento_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_fin_tratamiento', 'value'=>'fin_tratamiento_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_fin_tratamiento', 'value'=>'fin_tratamiento_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_fin_tratamiento', 'value'=>'fin_tratamiento_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";		

							echo "<div style='font-weight:bold;'>Formulario Fin Tratamiento Temprano</div>";
								echo form_checkbox(array('name'=>'ver_fin_tratamiento_temprano_form', 'value'=>'fin_tratamiento_temprano_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_fin_tratamiento_temprano_form', 'value'=>'fin_tratamiento_temprano,fin_tratamiento_temprano_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_fin_tratamiento_temprano_form', 'value'=>'fin_tratamiento_temprano_show,fin_tratamiento_temprano_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_fin_tratamiento_temprano', 'value'=>'fin_tratamiento_temprano_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_fin_tratamiento_temprano', 'value'=>'fin_tratamiento_temprano_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_fin_tratamiento_temprano', 'value'=>'fin_tratamiento_temprano_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";										

							echo "<div style='font-weight:bold;'>Formulario Hachinski</div>";
								echo form_checkbox(array('name'=>'ver_hachinski_form', 'value'=>'grid,hachinski_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_hachinski_form', 'value'=>'hachinski_insert, hachinski_form', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_hachinski_form', 'value'=>'hachinski_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_hachinski', 'value'=>'hachinski_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_hachinski', 'value'=>'hachinski_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_hachinski', 'value'=>'hachinski_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";

							echo "<div style='font-weight:bold;'>Formulario Historial Medico</div>";
								echo form_checkbox(array('name'=>'ver_historial_medico_form', 'value'=>'historial_medico_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_historial_medico_form', 'value'=>'historial_medico,historial_medico_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_historial_medico_form', 'value'=>'historial_medico_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_historial_medico', 'value'=>'historial_medico_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_historial_medico', 'value'=>'historial_medico_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_historial_medico', 'value'=>'historial_medico_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";

							echo "<div style='font-weight:bold;'>Formulario Inclusion Exclusion</div>";
								echo form_checkbox(array('name'=>'ver_inclusion_form', 'value'=>'grid,inclusion_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_inclusion_form', 'value'=>'inclusion_insert,inclusion', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_inclusion_form', 'value'=>'inclusion_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_inclusion', 'value'=>'inclusion_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_inclusion', 'value'=>'inclusion_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_inclusion', 'value'=>'inclusion_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";	

							echo "<div style='font-weight:bold;'>Formulario MMSE</div>";
								echo form_checkbox(array('name'=>'ver_mmse_form', 'value'=>'mmse_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_mmse_form', 'value'=>'mmse,mmse_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_mmse_form', 'value'=>'mmse_show,mmse_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_mmse', 'value'=>'mmse_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_mmse', 'value'=>'mmse_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_mmse', 'value'=>'mmse_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";	

							echo "<div style='font-weight:bold;'>Formulario Muestra de Sangre</div>";
								echo form_checkbox(array('name'=>'ver_muestra_de_sangre_form', 'value'=>'muestra_de_sangre_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_muestra_de_sangre_form', 'value'=>'muestra_de_sangre,muestra_de_sangre_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_muestra_de_sangre_form', 'value'=>'muestra_de_sangre_show,muestra_de_sangre_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_muestra_de_sangre', 'value'=>'muestra_de_sangre_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_muestra_de_sangre', 'value'=>'muestra_de_sangre_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_muestra_de_sangre', 'value'=>'muestra_de_sangre_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";		

							echo "<div style='font-weight:bold;'>Formulario NPI</div>";
								echo form_checkbox(array('name'=>'ver_npi_form', 'value'=>'npi_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_npi_form', 'value'=>'npi,npi_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_npi_form', 'value'=>'npi_show,npi_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_npi', 'value'=>'npi_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_npi', 'value'=>'npi_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_npi', 'value'=>'npi_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";										

							echo "<div style='font-weight:bold;'>Formulario Restas Seriadas</div>";
								echo form_checkbox(array('name'=>'ver_restas_form', 'value'=>'restas_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_restas_form', 'value'=>'restas,restas_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_restas_form', 'value'=>'restas_show,restas_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_restas', 'value'=>'restas_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_restas', 'value'=>'restas_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_restas', 'value'=>'restas_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";	

							echo "<div style='font-weight:bold;'>Formulario RNM</div>";
								echo form_checkbox(array('name'=>'ver_rnm_form', 'value'=>'rnm_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_rnm_form', 'value'=>'rnm,rnm_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_rnm_form', 'value'=>'rnm_show,rnm_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_rnm', 'value'=>'rnm_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_rnm', 'value'=>'rnm_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_rnm', 'value'=>'rnm_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";		

							echo "<div style='font-weight:bold;'>Formulario Signos Vitales</div>";
								echo form_checkbox(array('name'=>'ver_signos_vitales_form', 'value'=>'signos_vitales_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_signos_vitales_form', 'value'=>'signos_vitales,signos_vitales_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_signos_vitales_form', 'value'=>'signos_vitales_show,signos_vitales_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_signos_vitales', 'value'=>'signos_vitales_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_signos_vitales', 'value'=>'signos_vitales_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_signos_vitales', 'value'=>'signos_vitales_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";	

							echo "<div style='font-weight:bold;'>Formulario TMT A</div>";
								echo form_checkbox(array('name'=>'ver_tmt_a_form', 'value'=>'tmt_a_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_tmt_a_form', 'value'=>'tmt_a,tmt_a_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_tmt_a_form', 'value'=>'tmt_a_show,tmt_a_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_tmt_a', 'value'=>'tmt_a_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_tmt_a', 'value'=>'tmt_a_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_tmt_a', 'value'=>'tmt_a_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";		

							echo "<div style='font-weight:bold;'>Formulario TMT B</div>";
								echo form_checkbox(array('name'=>'ver_tmt_b_form', 'value'=>'tmt_b_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_tmt_b_form', 'value'=>'tmt_b,tmt_b_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								echo form_checkbox(array('name'=>'actualizar_tmt_b_form', 'value'=>'tmt_b_show,tmt_b_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";
								echo form_checkbox(array('name'=>'cerrar_tmt_b', 'value'=>'tmt_b_lock', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Cerrar<br>";
								echo form_checkbox(array('name'=>'aprobar_tmt_b', 'value'=>'tmt_b_verify', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Aprobar<br>";
								echo form_checkbox(array('name'=>'firmar_tmt_b', 'value'=>'tmt_b_signature', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Firmar<br>";			

							echo "<div style='font-weight:bold;'>Randomizacion</div>";
								echo form_checkbox(array('name'=>'ver_randomizacion_form', 'value'=>'randomization', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_randomizacion_form', 'value'=>'randomization_update', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								#echo form_checkbox(array('name'=>'responder_randomizacion_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";						
									
							echo "<div style='font-weight:bold;'>Formularios Adicionales</div>";
								echo form_checkbox(array('name'=>'ver_adicionales_form', 'value'=>'adverse_event_show,concomitant_medication_show,protocol_deviation_show', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Ver<br>";
								echo form_checkbox(array('name'=>'agregar_adicionales_form', 'value'=>'protocol_deviation_form,adverse_event_form,adverse_event_form_insert,concomitant_medication_form,protocol_deviation_form_insert,concomitant_medication_form_insert', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Agregar<br>";
								#echo form_checkbox(array('name'=>'actualizar_adicionales_form', 'value'=>'', 'perfil'=>$v->role, 'controller'=>$v->controller)) . " Editar<br>";							
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