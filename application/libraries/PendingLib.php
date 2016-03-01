<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

class PendingLib {

	function __construct() {
		$this->CI = & get_instance(); // Esto para acceder a la instancia que carga la librería

		$this->CI->load->model('Model_Subject');
        $this->CI->load->model('Model_Query');

    }


    public function pending_by_role(){ 

    	$result = array();
    	$role = $this->CI->session->userdata('perfil_id');

    	if($role == 1){
    		#Administrator
    	}
    	elseif($role == 2){
    		#Co-Investigator
    	}
    	elseif($role == 3){
    		#CRA

    		#Pending Verify Form
    		$result['demography_form_verify'] = $this->CI->Model_Subject->allFilteredWhere(array('demography_status'=>'Record Complete'));
    		#Pending Querys
    		$result['querys'] = $this->CI->Model_Query->allWhere('answer = ""');

    	}
    	elseif($role == 4){
    		#Data Manager

    		#Pending Lock a Form
			$result['demography_form_lock'] = $this->CI->Model_Subject->allFilteredWhere(array('demography_status'=>'Document Approved and Signed by PI'));
			#Pending Querys
    		$result['querys'] = $this->CI->Model_Query->allWhere('answer = ""');    		
    	}
    	elseif($role == 5){
    		#Sponsor
    	}
    	elseif($role == 6){
    		#Warehouse Admin
    	}
    	elseif($role == 7){
    		#Study Coordinator
    	}
    	elseif($role == 8){
    		#Principal Investigator

    		#Pending Sign a Demography Form
    		$result['demography_form_sign'] = $this->CI->Model_Subject->allFilteredWhere(array('demography_status'=>'Form Approved and Locked'));

    		#Pending Querys
    		$result['querys'] = $this->CI->Model_Query->allWhere('answer = ""');
    		
    	}
    	
    	return $result;

    }
}