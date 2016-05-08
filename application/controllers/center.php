<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Center extends CI_Controller {

	// Constructor de la clase
	function __construct() {
		parent::__construct();

		$this->load->model('Model_Center');		
		#$this->load->library('usuarioLib');
		#$this->form_validation->set_message('required', 'Debe ingresar campo %s');        
    }

    function index(){

    	$data['contenido'] = 'center/index';
		$data['titulo'] = 'Centros';
		$data['query'] = $this->Model_Center->all();		
		
		$this->auditlib->save_audit("Vio lista de centros");

		$this->load->view('template', $data);


    }

     public function search() {
		$data['contenido'] = 'center/index';
		$data['titulo'] = 'Centros';
		$value = $this->input->post('buscar');
		$data['query'] = $this->Model_Center->allFiltered('center.id', $value);
		$this->auditlib->save_audit("Busco un centro");
		$this->load->view('template', $data);
	}   

	public function create() {
		$data['contenido'] = 'center/create';
		$data['titulo'] = 'Nuevo Centro';
		$this->auditlib->save_audit("Ingreso al formulario para agregar un centro");		
		$this->load->view('template', $data);
	}

	public function insert() {
		$registro = $this->input->post();

		/*Validacion Datos Centro*/
		$this->form_validation->set_rules('name', 'Nombre del Centro', 'required|xss_clean');
		$this->form_validation->set_rules('direccion', 'Direccion', 'required|xss_clean');
		$this->form_validation->set_rules('ciudad_localidad', 'Ciudad', 'required|xss_clean');
		$this->form_validation->set_rules('estado_provincia', 'Estado', 'required|xss_clean');
		$this->form_validation->set_rules('zip_postal', 'Zip', 'xss_clean');
		$this->form_validation->set_rules('pais', 'Pais', 'required|xss_clean');

		/*Validacion Contacto*/
		$this->form_validation->set_rules('contacto_nombre', 'Nombre del Contacto', 'xss_clean');
		$this->form_validation->set_rules('contacto_codigo__pais', 'Codigo Pais', 'xss_clean');
		$this->form_validation->set_rules('contacto_fono', 'Telefono', 'xss_clean');
		$this->form_validation->set_rules('contacto_fax', 'Fax', 'xss_clean');
		$this->form_validation->set_rules('contacto_email', 'Email', 'xss_clean');

		/*Validacion Adicionales*/
		$this->form_validation->set_rules('type', 'Tipo', 'xss_clean');
		$this->form_validation->set_rules('disabled', 'Deshabilitado', 'xss_clean');

		if(isset($registro['disabled']) AND $registro['disabled'] == '1'){			
			$this->form_validation->set_rules('last_disabled', 'Fecha', 'required|xss_clean');
			$this->form_validation->set_rules('disabled_reason', 'Rason', 'required|xss_clean');
		}
		else{			
			$this->form_validation->set_rules('last_disabled', 'Fecha', 'xss_clean');	
			$this->form_validation->set_rules('disabled_reason', 'Rason', 'xss_clean');
		}
		
		#$this->form_validation->set_rules('', '', 'xss_clean');
		#$this->form_validation->set_rules('', '', 'xss_clean');		
        

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        }
        else {						
			
			$registro['created'] = date('Y/m/d H:i:s');
			$registro['updated'] = date('Y/m/d H:i:s');
			
			$this->Model_Center->insert($registro);			
			$this->auditlib->save_audit("Creo un nuevo centro");
			redirect('center/index');
        }
	}

	public function edit($id) {
		// $id = $this->uri->segment(3);

		$data['contenido'] = 'center/edit';
		$data['titulo'] = 'Actualizar Centro';
		$data['registro'] = $this->Model_Center->find($id);
		#centros
		$this->auditlib->save_audit("Entro a el formulario para editar centros");
		$this->load->view('template', $data);
	}

	public function update() {
		$registro = $this->input->post();

		$this->form_validation->set_rules('name', 'Nombre del Centro', 'required|xss_clean');
		if($this->form_validation->run() == FALSE) {
			$this->edit($registro['id']);
		}
		else {
			$registro['updated'] = date('Y/m/d H:i');
			$this->Model_Center->update($registro);
			$this->auditlib->save_audit("Actualizo un centro");
			redirect('center/index');
		}
	}
}