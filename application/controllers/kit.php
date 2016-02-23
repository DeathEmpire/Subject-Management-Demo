<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kit extends CI_Controller {

	// Constructor de la clase
	function __construct() {
		parent::__construct();

		$this->load->model('Model_Kit');
		$this->load->library('kitLib');
		
    }

	public function index() {
		$data['contenido'] = 'kit/index';
		$data['titulo'] = 'Kits';
		$data['query'] = $this->Model_Kit->all();

		$this->load->Model("Model_Center");
		$data['centers'] = $this->Model_Center->all();
		
		$this->auditlib->save_audit("View Kit Index");

		$this->load->view('template', $data);
	}

 	public function search() {
		$data['contenido'] = 'kit/index';
		$data['titulo'] = 'Kits';
		$recibe = $this->input->post();
		
		$where = array();
		
		if(isset($recibe['id']) AND !empty($recibe['id'])){
			$where['kit.id'] =$recibe['id'];
			$data['id'] = $recibe['id'];
		}
		if(isset($recibe['tipo']) AND !empty($recibe['tipo'])){
			$where['type'] = $recibe['tipo'];
			$data['tipo'] = $recibe['tipo'];
		}				
		if(isset($recibe['disponible']) AND !empty($recibe['disponible'])){			
			$data['disponible'] = $recibe['disponible'];

		if($recibe['disponible'] == "NO"){
			$recibe['disponible']=0;
		}					

		$where['available'] = $recibe['disponible'];				}
		
		if(isset($recibe['ubicacion_actual']) AND !empty($recibe['ubicacion_actual']) AND $recibe['ubicacion_actual'] != 'X'){
			if($recibe['ubicacion_actual'] == "00"){
				$recibe['ubicacion_actual'] = 0;
			}
			$where['center_id'] = $recibe['ubicacion_actual'];
			$data['ubicacion_actual'] = $recibe['ubicacion_actual'];
		}		
		
		$data['query'] = $this->Model_Kit->allFilteredWhere($where);
		
		$this->load->Model("Model_Center");
		$data['centers'] = $this->Model_Center->all();

		$this->auditlib->save_audit("Search for a kit");
		// $data['query'] = $this->Model_Medicamentos->allFiltered('medicamentos.tipo', $value);
		$this->load->view('template', $data);
	}

	public function CambiarBodega(){
		$registro = $this->input->post();
		
		$cambiar['center_id'] = $registro['center'];
		#$medicamentos = explode(",",$registro['medicamento']);		
		$medicamentos = $registro['cambiar'];
		
		foreach($medicamentos as $v){
			$cambiar['id'] = $v;
			$this->Model_Kit->update($cambiar);
		}
		/* Enviar correo con datos del nuevo centro del medicamento */				
		/*
		$this->load->helper("phpmailer");
		
		
		$data['contenido'] = 'kit/correo';		
		$data['registro']['centro'] = $cambiar['ubicacion_actual'];
		$data['registro']['producto'] = $registro['medicamento'];
		
		$message = $this->load->view("correo",$data,true);
		$this->load->model("Model_Lista_Correos");
		$correos = $this->Model_Lista_Correos->allFiltered("nombre","Bodegas");
		
		send_email($correos->correos, "", "Solicitud de Despacho", $message);
		*/

		$data['contenido'] = 'kit/index';
		$data['titulo'] = 'kit';
		
		$data['query'] = $this->Model_Kit->all();
		
		$this->load->Model("Model_Center");
		$data['centers'] = $this->Model_Center->all();

		$this->auditlib->save_audit("Assign kits to a center");

		$this->load->view('template', $data);
	}
	
}
