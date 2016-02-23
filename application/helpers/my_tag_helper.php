<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Muestra TODOS errores de validación de un formulario
if ( ! function_exists('my_validation_errors')) {

	function my_validation_errors($errors) {
		$salida = '';

		$cada = explode("\n",$errors);
		
		$list_ = "<ul>";
		
		foreach ($cada as $v) {			
			if(!empty($v)){
				$list_ .= "<li>". trim($v) ."</li>";
			}
		}

		$list_ .= "</ul>";

		if ($errors) {
			$salida = '<div class="alert alert-error">';
			$salida = $salida.'<button type="button" class="close" data-dismiss="alert"> × </button>';
			$salida = $salida.'<h4> Validation Errors </h4>';
			$salida = $salida.'<small><br />'. $list_ .'</small>';
			$salida = $salida.'</div>';
		}
		return $salida;
	}

}

// Opciones de menú de la barra superior (las opciones dependen si hay session o no)
if ( ! function_exists('my_menu_ppal')) {

	function my_menu_ppal() {
		$opciones = '<li>'.anchor('home/index', 'Home').'</li>';
		// $opciones = $opciones.'<li>'.anchor('home/acerca_de', 'Acerca De').'</li>';

		if (get_instance()->session->userdata('usuario')) {
			$opciones = $opciones.'<li>'.anchor('home/cambio_clave', 'Change Password').'</li>';
			$opciones = $opciones.'<li>'.anchor('home/salir', 'Sign Out').'</li>';
		}
		else {
			$opciones = $opciones.'<li>'.anchor('home/ingreso', 'Sign In').'</li>';
		}

		return $opciones;
	}

}

if ( ! function_exists('my_menu_app')) {

	function my_menu_app() {
		$opciones = null;

		if (get_instance()->session->userdata('usuario')) {
			
			//obtengo todos los menus permitidos
			get_instance()->load->model('Model_Menu_Perfil');
			$query = get_instance()->Model_Menu_Perfil->allFiltered('perfil_id',get_instance()->session->userdata('perfil_id'));			
			$arreglo = array();
			foreach($query as $v){
				$arreglo[] = $v->menu_id;
			}
			
			$mostrar = implode(",",$arreglo);
			
			$opciones = '';
			get_instance()->load->model('Model_Menu');
			// $query = get_instance()->Model_Menu->allForMenu();
			$query = get_instance()->Model_Menu->allFiltered2("id",$mostrar);

			foreach ($query as $opcion) {
				if ($opcion->url != '') {
					$irA = $opcion->url;
					$param = array('target'=>'_blank');
				}
				else {
					$irA = $opcion->controlador.'/'.$opcion->accion;
					$param = array();
				}
				
				$opciones = $opciones.'<li>'.anchor($irA, $opcion->name, $param).'</li>';
				
			}
		}

		return $opciones;
	}

	function piePagina(){

		if(get_instance()->session->userdata('perfil_name') !== null AND get_instance()->session->userdata('usuario') !== null){

			return get_instance()->session->userdata('usuario') ." (". get_instance()->session->userdata('perfil_name') .") - ". date('d/m/Y H:i');
		
		}else{
			return date('d/m/Y H:i');
		}
		
	}

}