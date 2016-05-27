<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

class AuditLib {

	function __construct() {
		$this->CI = & get_instance(); // Esto para acceder a la instancia que carga la librería

		$this->CI->load->model('Model_Audit');        
		$this->CI->load->model('Model_Subject'); 
    }

    function save_audit($description, $subject_id = ''){

    	if(isset($subject_id) AND !empty($subject_id)){
    		$subject = $this->CI->Model_Subject->find($subject_id);
    		if(isset($subject) AND !empty($subject)){
    			$description .= " en el sujeto ". $subject->code;
    		}
    	}

    	$audit_record['user_id'] = $this->CI->session->userdata("usuario_id");
		$audit_record['user_name'] = $this->CI->session->userdata("usuario");
		$audit_record['date'] = date("Y-m-d H:i:s");
		$audit_record['description'] = $description;
    	
    	$this->CI->Model_Audit->insert($audit_record);
    }
}