<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');
	
	if(!function_exists("autentificar")){

		function autentificar(){
			$CI = & get_instance();
			
			$controlador = $CI->uri->segment(1);
			$accion = $CI->uri->segment(2);			
			$url = $controlador ."/". $accion;
			
			$libres = array(
							"/",
							"home/index",
							"home/acceso_denegado",
							"home/acerca_de",
							"home/ingreso",
							"home/salir",
							"home/ingresar",							
							"home/recuperarclave",							
							"home/recuperandoclave",							
							"home/recuperarclaveok",							
						);
			if(in_array($url,$libres)){
				echo $CI->output->get_output();//para seguir con lo que se queria
			}
			else{				
				if($CI->session->userdata('usuario')){
					if(autorizar()){
					
						if($url != "home/cambio_clave" AND $url != "home/cambiar_clave"){
							/* Validacion para que alla cambiado la clave al ingresar la primera vez y que sea obligatorio cada 4 meses */
							$CI->load->library("usuarioLib");
							if($CI->usuariolib->obligarcambioclave()){
								redirect("home/cambio_clave");
							}
							else{
								echo $CI->output->get_output();
							}						
						}
						else{
							echo $CI->output->get_output();
						}
					}
					else{
						redirect("home/acceso_denegado");
					}
				}
				else{
					redirect("home/acceso_denegado");
				}				
			}
		}

	}
	
	function autorizar(){
		$CI = & get_instance();
		
		$perfil_id = $CI->session->userdata('perfil_id');
		
		//con controlador buscar en la tabla la opcion del menu
		$CI->load->library("menuLib");
		$controlador = $CI->uri->segment(1);		
		$accion = $CI->uri->segment(2);
	/* 	$menu_id = $CI->menulib->findByControlador($controlador,$accion)->id;
		// echo $menu_id;
		//validar q el controlador este en la tabla
		if(!$menu_id){
			return false;
		}
		
		//recuperar de la tabla permisos la combinacion menu perfil
		$CI->load->library("menu_PerfilLib");
		$acceso = $CI->menu_perfillib->findByMenuAndPerfil($menu_id,$perfil_id);
		// print_r($acceso);
		if(!$acceso){
			return false;
		}
		else{ */
			
			//nueva validacion agregada por accion del controlador
			$CI->load->library("opciones_PerfilLib");
			$permitido = $CI->opciones_perfillib->permitido($perfil_id,$controlador,$accion);
			if($permitido){
				return true;
			}
			else{
				return false;
			}
		/* } */
	}