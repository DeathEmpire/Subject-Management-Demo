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
            //Pendiente verificar todos los forms
            $or_where = array('demography_status'=>'Record Complete',
                               'randomization_status'=>'Record Complete',
                               'hachinski_status'=>'Record Complete',
                               'historial_medico_1_status'=>'Record Complete',
                               'historial_medico_2_status'=>'Record Complete',
                               'inclusion_exclusion_1_status'=>'Record Complete',
                               'inclusion_exclusion_2_status'=>'Record Complete',
                               'digito_2_status'=>'Record Complete',                              
                               'digito_4_status'=>'Record Complete',
                               'digito_5_status'=>'Record Complete',
                               'digito_6_status'=>'Record Complete',
                               'ecg_status'=>'Record Complete',
                               'cumplimiento_2_status'=>'Record Complete',
                               'cumplimiento_3_status'=>'Record Complete',
                               'cumplimiento_4_status'=>'Record Complete',
                               'cumplimiento_5_status'=>'Record Complete',
                               'cumplimiento_6_status'=>'Record Complete',
                               'examen_laboratorio_status'=>'Record Complete',
                               'examen_laboratorio_5_status'=>'Record Complete',
                               'examen_laboratorio_6_status'=>'Record Complete',
                               'signos_vitales_1_status'=>'Record Complete',
                               'signos_vitales_2_status'=>'Record Complete',
                               'signos_vitales_4_status'=>'Record Complete',
                               'signos_vitales_5_status'=>'Record Complete',
                               'signos_vitales_6_status'=>'Record Complete',
                               'examen_neurologico_1_status'=>'Record Complete',
                               'examen_neurologico_2_status'=>'Record Complete',
                               'examen_neurologico_3_status'=>'Record Complete',
                               'examen_neurologico_4_status'=>'Record Complete',
                               'examen_neurologico_5_status'=>'Record Complete',
                               'examen_neurologico_6_status'=>'Record Complete',
                               'muestra_de_sangre_1_status'=>'Record Complete',
                               'muestra_de_sangre_5_status'=>'Record Complete',
                               'muestra_de_sangre_6_status'=>'Record Complete',
                               'fin_tratamiento_status'=>'Record Complete',
                               'fin_tratamiento_temprano_status'=>'Record Complete',
                               'tmt_a_2_status'=>'Record Complete',
                               'tmt_a_4_status'=>'Record Complete',
                               'tmt_a_5_status'=>'Record Complete',
                               'tmt_a_6_status'=>'Record Complete',
                               'tmt_b_2_status'=>'Record Complete',
                               'tmt_b_4_status'=>'Record Complete',
                               'tmt_b_5_status'=>'Record Complete',
                               'tmt_b_6_status'=>'Record Complete',
                               'eq_5d_5l_2_status'=>'Record Complete',
                               'eq_5d_5l_3_status'=>'Record Complete',
                               'eq_5d_5l_4_status'=>'Record Complete',
                               'eq_5d_5l_5_status'=>'Record Complete',
                               'eq_5d_5l_6_status'=>'Record Complete',
                               'npi_2_status'=>'Record Complete',
                               'npi_4_status'=>'Record Complete',
                               'npi_5_status'=>'Record Complete',
                               'npi_6_status'=>'Record Complete',
                               'apatia_2_status'=>'Record Complete',
                               'apatia_3_status'=>'Record Complete',
                               'apatia_4_status'=>'Record Complete',
                               'apatia_5_status'=>'Record Complete',
                               'apatia_6_status'=>'Record Complete',
                               'rnm_status'=>'Record Complete',
                               'rnm_2_status'=>'Record Complete',
                               'examen_fisico_1_status'=>'Record Complete',
                               'examen_fisico_2_status'=>'Record Complete',
                               'examen_fisico_3_status'=>'Record Complete',
                               'examen_fisico_4_status'=>'Record Complete',
                               'examen_fisico_5_status'=>'Record Complete',
                               'examen_fisico_6_status'=>'Record Complete',
                               'adas_2_status'=>'Record Complete',
                               'adas_4_status'=>'Record Complete',
                               'adas_5_status'=>'Record Complete',
                               'adas_6_status'=>'Record Complete',
                               'restas_2_status'=>'Record Complete',
                               'restas_4_status'=>'Record Complete',
                               'restas_5_status'=>'Record Complete',
                               'restas_6_status'=>'Record Complete'
                                );
            $result['pendiente_de_verificar'] = $this->CI->Model_Subject->buscarEstadosFormOr($or_where);
            if(isset($result['pendiente_de_verificar']) AND !empty($result['pendiente_de_verificar'])){           
                $verificar = array();
                foreach ($result['pendiente_de_verificar'] as $key => $val){
                    foreach ($val as $k => $v) {
                        if($v == 'Record Complete'){
                            $verificar[$val->id]['form'][] = $k;
                            $verificar[$val->id]['code'][] = $val->code;
                        }
                    }
                }

                $pendientes_verificar_links = array();
                $pendientes_verificar_codigos = array();

                foreach ($verificar as $key => $value) {

                   if(in_array('demography_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/demography/'.$key, 'Demografia');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('randomization_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/randomization/'.$key, 'Randomizacion');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('hachinski_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/hachinski_show/'.$key, 'Escala de Hachinski');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('historial_medico_1_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/historial_medico_show/'. $key .'/1', 'Historia Medica');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('historial_medico_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/historial_medico_show/'. $key .'/2', 'Historia Medica');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('inclusion_exclusion_1_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/inclusion_exclusion_show/'. $key .'/1', 'Inclusion Exclusion');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('inclusion_exclusion_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/inclusion_exclusion_show/'. $key .'/2', 'Inclusion Exclusion');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('digito_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/digito_directo_show/'.$key .'/2', 'Digito Directo');$pendientes_verificar_codigos[] = $value['code'];}                              
                   if(in_array('digito_4_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/digito_directo_show/'.$key .'/4', 'Digito Directo');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('digito_5_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/digito_directo_show/'.$key .'/5', 'Digito Directo');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('digito_6_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/digito_directo_show/'.$key .'/6', 'Digito Directo');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('ecg_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/ecg_show/'.$key, 'ECG');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/cumplimiento_show/'.$key.'/2', 'Cumplimiento');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_3_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/cumplimiento_show/'.$key.'/3', 'Cumplimiento');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_4_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/cumplimiento_show/'.$key.'/4', 'Cumplimiento');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_5_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/cumplimiento_show/'.$key.'/5', 'Cumplimiento');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_6_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/cumplimiento_show/'.$key.'/6', 'Cumplimiento');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_laboratorio_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_laboratorio_show/'.$key .'/1', 'Examen laboratorio');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_laboratorio_5_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_laboratorio_show/'.$key .'/5', 'Examen laboratorio');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_laboratorio_6_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_laboratorio_show/'.$key .'/6', 'Examen laboratorio');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_1_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/signos_vitales_show/'.$key.'/1', 'Signos vitales');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/signos_vitales_show/'.$key.'/2', 'Signos vitales');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_4_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/signos_vitales_show/'.$key.'/4', 'Signos vitales');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_5_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/signos_vitales_show/'.$key.'/5', 'Signos vitales');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_6_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/signos_vitales_show/'.$key.'/6', 'Signos vitales');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_1_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/1', 'Examen neurologico');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/2', 'Examen neurologico');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_3_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/3', 'Examen neurologico');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_4_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/4', 'Examen neurologico');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_5_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/5', 'Examen neurologico');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_6_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/6', 'Examen neurologico');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('muestra_de_sangre_1_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/muestra_de_sangre_show/'.$key.'/1', 'Muestra de Sangre');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('muestra_de_sangre_5_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/muestra_de_sangre_show/'.$key.'/5', 'Muestra de Sangre');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('muestra_de_sangre_6_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/muestra_de_sangre_show/'.$key.'/6', 'Muestra de Sangre');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('fin_tratamiento_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/fin_tratamiento_show/'.$key, 'Fin tratamiento');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('fin_tratamiento_temprano_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/fin_tratamiento_temprano_show/'.$key, 'Fin tratamiento temprano');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('tmt_a_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/tmt_a_show/'.$key.'/2', 'TMT A');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('tmt_a_4_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/tmt_a_show/'.$key.'/4', 'TMT A');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('tmt_a_5_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/tmt_a_show/'.$key.'/5', 'TMT A');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('tmt_a_6_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/tmt_a_show/'.$key.'/6', 'TMT A');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('tmt_b_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/tmt_b_show/'.$key.'/2', 'TMT B');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('tmt_b_4_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/tmt_b_show/'.$key.'/4', 'TMT B');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('tmt_b_5_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/tmt_b_show/'.$key.'/5', 'TMT B');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('tmt_b_6_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/tmt_b_show/'.$key.'/6', 'TMT B');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/2', 'EQ-5D-5L');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_3_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/3', 'EQ-5D-5L');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_4_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/4', 'EQ-5D-5L');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_5_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/5', 'EQ-5D-5L');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_6_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/6', 'EQ-5D-5L');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('npi_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/npi_show/'.$key.'/2', 'NPI');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('npi_4_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/npi_show/'.$key.'/4', 'NPI');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('npi_5_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/npi_show/'.$key.'/5', 'NPI');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('npi_6_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/npi_show/'.$key.'/6', 'NPI');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('apatia_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/apatia_show/'.$key.'/2', 'Apatia');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('apatia_3_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/apatia_show/'.$key.'/3', 'Apatia');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('apatia_4_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/apatia_show/'.$key.'/4', 'Apatia');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('apatia_5_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/apatia_show/'.$key.'/5', 'Apatia');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('apatia_6_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/apatia_show/'.$key.'/6', 'Apatia');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('rnm_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/rnm_show/'.$key .'/1', 'RNM');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('rnm_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/rnm_show/'.$key .'/2', 'RNM');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_1_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_fisico_show/'.$key.'/1', 'Examen Fisico');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_fisico_show/'.$key.'/2', 'Examen Fisico');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_3_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_fisico_show/'.$key.'/3', 'Examen Fisico');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_4_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_fisico_show/'.$key.'/4', 'Examen Fisico');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_5_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_fisico_show/'.$key.'/5', 'Examen Fisico');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_6_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/examen_fisico_show/'.$key.'/6', 'Examen Fisico');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('adas_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/adas_show/'.$key.'/2', 'Adas cog');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('adas_4_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/adas_show/'.$key.'/4', 'Adas cog');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('adas_5_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/adas_show/'.$key.'/5', 'Adas cog');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('adas_6_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/adas_show/'.$key.'/6', 'Adas cog');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('restas_2_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/restas_show/'.$key.'/2', 'Restas Seriadas');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('restas_4_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/restas_show/'.$key.'/4', 'Restas Seriadas');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('restas_5_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/restas_show/'.$key.'/5', 'Restas Seriadas');$pendientes_verificar_codigos[] = $value['code'];}
                   if(in_array('restas_6_status', $value['form'])){ $pendientes_verificar_links[] = anchor('subject/restas_show/'.$key.'/6', 'Restas Seriadas');$pendientes_verificar_codigos[] = $value['code'];}
                   
                }
                
                $result['pendientes_verificar_links'] = $pendientes_verificar_links;
                $result['pendientes_verificar_codigos'] = $pendientes_verificar_codigos;
            }


            /*--------------------------------------------------------------------------------------------------------------------------*/
            
            

            /*--------------------------------------------------------------------------------------------------------------------------------------------*/
            
           

    		#Pending Querys
    		$result['querys'] = $this->CI->Model_Query->allWhere('status = "Abierto"');

    	}
    	elseif($role == 4){
    		#Data Manager

    		//Pendiente cerrar todos los forms
            $or_where = array('demography_status'=>'Form Approved by Monitor',
                               'randomization_status'=>'Form Approved by Monitor',
                               'hachinski_status'=>'Form Approved by Monitor',
                               'historial_medico_1_status'=>'Form Approved by Monitor',
                               'historial_medico_2_status'=>'Form Approved by Monitor',
                               'inclusion_exclusion_1_status'=>'Form Approved by Monitor',
                               'inclusion_exclusion_2_status'=>'Form Approved by Monitor',
                               'digito_2_status'=>'Form Approved by Monitor',                              
                               'digito_4_status'=>'Form Approved by Monitor',
                               'digito_5_status'=>'Form Approved by Monitor',
                               'digito_6_status'=>'Form Approved by Monitor',
                               'ecg_status'=>'Form Approved by Monitor',
                               'cumplimiento_2_status'=>'Form Approved by Monitor',
                               'cumplimiento_3_status'=>'Form Approved by Monitor',
                               'cumplimiento_4_status'=>'Form Approved by Monitor',
                               'cumplimiento_5_status'=>'Form Approved by Monitor',
                               'cumplimiento_6_status'=>'Form Approved by Monitor',
                               'examen_laboratorio_status'=>'Form Approved by Monitor',
                               'examen_laboratorio_5_status'=>'Form Approved by Monitor',
                               'examen_laboratorio_6_status'=>'Form Approved by Monitor',
                               'signos_vitales_1_status'=>'Form Approved by Monitor',
                               'signos_vitales_2_status'=>'Form Approved by Monitor',
                               'signos_vitales_4_status'=>'Form Approved by Monitor',
                               'signos_vitales_5_status'=>'Form Approved by Monitor',
                               'signos_vitales_6_status'=>'Form Approved by Monitor',
                               'examen_neurologico_1_status'=>'Form Approved by Monitor',
                               'examen_neurologico_2_status'=>'Form Approved by Monitor',
                               'examen_neurologico_3_status'=>'Form Approved by Monitor',
                               'examen_neurologico_4_status'=>'Form Approved by Monitor',
                               'examen_neurologico_5_status'=>'Form Approved by Monitor',
                               'examen_neurologico_6_status'=>'Form Approved by Monitor',
                               'muestra_de_sangre_1_status'=>'Form Approved by Monitor',
                               'muestra_de_sangre_5_status'=>'Form Approved by Monitor',
                               'muestra_de_sangre_6_status'=>'Form Approved by Monitor',
                               'fin_tratamiento_status'=>'Form Approved by Monitor',
                               'fin_tratamiento_temprano_status'=>'Form Approved by Monitor',
                               'tmt_a_2_status'=>'Form Approved by Monitor',
                               'tmt_a_4_status'=>'Form Approved by Monitor',
                               'tmt_a_5_status'=>'Form Approved by Monitor',
                               'tmt_a_6_status'=>'Form Approved by Monitor',
                               'tmt_b_2_status'=>'Form Approved by Monitor',
                               'tmt_b_4_status'=>'Form Approved by Monitor',
                               'tmt_b_5_status'=>'Form Approved by Monitor',
                               'tmt_b_6_status'=>'Form Approved by Monitor',
                               'eq_5d_5l_2_status'=>'Form Approved by Monitor',
                               'eq_5d_5l_3_status'=>'Form Approved by Monitor',
                               'eq_5d_5l_4_status'=>'Form Approved by Monitor',
                               'eq_5d_5l_5_status'=>'Form Approved by Monitor',
                               'eq_5d_5l_6_status'=>'Form Approved by Monitor',
                               'npi_2_status'=>'Form Approved by Monitor',
                               'npi_4_status'=>'Form Approved by Monitor',
                               'npi_5_status'=>'Form Approved by Monitor',
                               'npi_6_status'=>'Form Approved by Monitor',
                               'apatia_2_status'=>'Form Approved by Monitor',
                               'apatia_3_status'=>'Form Approved by Monitor',
                               'apatia_4_status'=>'Form Approved by Monitor',
                               'apatia_5_status'=>'Form Approved by Monitor',
                               'apatia_6_status'=>'Form Approved by Monitor',
                               'rnm_status'=>'Form Approved by Monitor',
                               'rnm_2_status'=>'Form Approved by Monitor',
                               'examen_fisico_1_status'=>'Form Approved by Monitor',
                               'examen_fisico_2_status'=>'Form Approved by Monitor',
                               'examen_fisico_3_status'=>'Form Approved by Monitor',
                               'examen_fisico_4_status'=>'Form Approved by Monitor',
                               'examen_fisico_5_status'=>'Form Approved by Monitor',
                               'examen_fisico_6_status'=>'Form Approved by Monitor',
                               'adas_2_status'=>'Form Approved by Monitor',
                               'adas_4_status'=>'Form Approved by Monitor',
                               'adas_5_status'=>'Form Approved by Monitor',
                               'adas_6_status'=>'Form Approved by Monitor',
                               'restas_2_status'=>'Form Approved by Monitor',
                               'restas_4_status'=>'Form Approved by Monitor',
                               'restas_5_status'=>'Form Approved by Monitor',
                               'restas_6_status'=>'Form Approved by Monitor'
                                );
            $result['pendiente_de_cerrar'] = $this->CI->Model_Subject->buscarEstadosFormOr($or_where);
            if(isset($result['pendiente_de_cerrar']) AND !empty($result['pendiente_de_cerrar'])){           
                $cerrar = array();
                foreach ($result['pendiente_de_cerrar'] as $key => $val){
                    foreach ($val as $k => $v) {
                        if($v == 'Record Complete'){
                            $cerrar[$val->id]['form'][] = $k;
                            $cerrar[$val->id]['code'][] = $val->code;
                        }
                    }
                }

                $pendientes_cerrar_links = array();
                $pendientes_cerrar_codigos = array();

                foreach ($aprobar as $key => $value) {

                   if(in_array('demography_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/demography/'.$key, 'Demografia');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('randomization_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/randomization/'.$key, 'Randomizacion');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('hachinski_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/hachinski_show/'.$key, 'Escala de Hachinski');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('historial_medico_1_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/historial_medico_show/'. $key .'/1', 'Historia Medica');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('historial_medico_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/historial_medico_show/'. $key .'/2', 'Historia Medica');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('inclusion_exclusion_1_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/inclusion_exclusion_show/'. $key .'/1', 'Inclusion Exclusion');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('inclusion_exclusion_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/inclusion_exclusion_show/'. $key .'/2', 'Inclusion Exclusion');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('digito_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/digito_directo_show/'.$key .'/2', 'Digito Directo');$pendientes_cerrar_codigos[] = $value['code'];}                              
                   if(in_array('digito_4_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/digito_directo_show/'.$key .'/4', 'Digito Directo');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('digito_5_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/digito_directo_show/'.$key .'/5', 'Digito Directo');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('digito_6_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/digito_directo_show/'.$key .'/6', 'Digito Directo');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('ecg_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/ecg_show/'.$key, 'ECG');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/cumplimiento_show/'.$key.'/2', 'Cumplimiento');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_3_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/cumplimiento_show/'.$key.'/3', 'Cumplimiento');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_4_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/cumplimiento_show/'.$key.'/4', 'Cumplimiento');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_5_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/cumplimiento_show/'.$key.'/5', 'Cumplimiento');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_6_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/cumplimiento_show/'.$key.'/6', 'Cumplimiento');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_laboratorio_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_laboratorio_show/'.$key .'/1', 'Examen laboratorio');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_laboratorio_5_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_laboratorio_show/'.$key .'/5', 'Examen laboratorio');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_laboratorio_6_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_laboratorio_show/'.$key .'/6', 'Examen laboratorio');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_1_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/signos_vitales_show/'.$key.'/1', 'Signos vitales');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/signos_vitales_show/'.$key.'/2', 'Signos vitales');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_4_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/signos_vitales_show/'.$key.'/4', 'Signos vitales');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_5_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/signos_vitales_show/'.$key.'/5', 'Signos vitales');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_6_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/signos_vitales_show/'.$key.'/6', 'Signos vitales');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_1_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/1', 'Examen neurologico');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/2', 'Examen neurologico');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_3_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/3', 'Examen neurologico');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_4_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/4', 'Examen neurologico');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_5_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/5', 'Examen neurologico');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_6_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/6', 'Examen neurologico');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('muestra_de_sangre_1_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/muestra_de_sangre_show/'.$key.'/1', 'Muestra de Sangre');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('muestra_de_sangre_5_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/muestra_de_sangre_show/'.$key.'/5', 'Muestra de Sangre');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('muestra_de_sangre_6_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/muestra_de_sangre_show/'.$key.'/6', 'Muestra de Sangre');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('fin_tratamiento_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/fin_tratamiento_show/'.$key, 'Fin tratamiento');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('fin_tratamiento_temprano_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/fin_tratamiento_temprano_show/'.$key, 'Fin tratamiento temprano');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('tmt_a_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/tmt_a_show/'.$key.'/2', 'TMT A');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('tmt_a_4_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/tmt_a_show/'.$key.'/4', 'TMT A');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('tmt_a_5_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/tmt_a_show/'.$key.'/5', 'TMT A');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('tmt_a_6_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/tmt_a_show/'.$key.'/6', 'TMT A');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('tmt_b_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/tmt_b_show/'.$key.'/2', 'TMT B');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('tmt_b_4_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/tmt_b_show/'.$key.'/4', 'TMT B');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('tmt_b_5_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/tmt_b_show/'.$key.'/5', 'TMT B');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('tmt_b_6_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/tmt_b_show/'.$key.'/6', 'TMT B');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/2', 'EQ-5D-5L');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_3_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/3', 'EQ-5D-5L');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_4_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/4', 'EQ-5D-5L');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_5_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/5', 'EQ-5D-5L');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_6_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/6', 'EQ-5D-5L');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('npi_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/npi_show/'.$key.'/2', 'NPI');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('npi_4_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/npi_show/'.$key.'/4', 'NPI');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('npi_5_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/npi_show/'.$key.'/5', 'NPI');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('npi_6_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/npi_show/'.$key.'/6', 'NPI');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('apatia_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/apatia_show/'.$key.'/2', 'Apatia');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('apatia_3_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/apatia_show/'.$key.'/3', 'Apatia');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('apatia_4_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/apatia_show/'.$key.'/4', 'Apatia');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('apatia_5_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/apatia_show/'.$key.'/5', 'Apatia');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('apatia_6_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/apatia_show/'.$key.'/6', 'Apatia');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('rnm_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/rnm_show/'.$key .'/1', 'RNM');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('rnm_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/rnm_show/'.$key .'/2', 'RNM');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_1_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_fisico_show/'.$key.'/1', 'Examen Fisico');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_fisico_show/'.$key.'/2', 'Examen Fisico');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_3_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_fisico_show/'.$key.'/3', 'Examen Fisico');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_4_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_fisico_show/'.$key.'/4', 'Examen Fisico');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_5_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_fisico_show/'.$key.'/5', 'Examen Fisico');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_6_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/examen_fisico_show/'.$key.'/6', 'Examen Fisico');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('adas_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/adas_show/'.$key.'/2', 'Adas cog');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('adas_4_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/adas_show/'.$key.'/4', 'Adas cog');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('adas_5_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/adas_show/'.$key.'/5', 'Adas cog');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('adas_6_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/adas_show/'.$key.'/6', 'Adas cog');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('restas_2_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/restas_show/'.$key.'/2', 'Restas Seriadas');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('restas_4_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/restas_show/'.$key.'/4', 'Restas Seriadas');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('restas_5_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/restas_show/'.$key.'/5', 'Restas Seriadas');$pendientes_cerrar_codigos[] = $value['code'];}
                   if(in_array('restas_6_status', $value['form'])){ $pendientes_cerrar_links[] = anchor('subject/restas_show/'.$key.'/6', 'Restas Seriadas');$pendientes_cerrar_codigos[] = $value['code'];}
                   
                }
                
                $result['pendientes_cerrar_links'] = $pendientes_cerrar_links;
                $result['pendientes_cerrar_codigos'] = $pendientes_cerrar_codigos;
            }
			
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

    		 //Pendiente firmar todos los forms
            $or_where = array('demography_status'=>'Form Approved and Locked',
                               'randomization_status'=>'Form Approved and Locked',
                               'hachinski_status'=>'Form Approved and Locked',
                               'historial_medico_1_status'=>'Form Approved and Locked',
                               'historial_medico_2_status'=>'Form Approved and Locked',
                               'inclusion_exclusion_1_status'=>'Form Approved and Locked',
                               'inclusion_exclusion_2_status'=>'Form Approved and Locked',
                               'digito_2_status'=>'Form Approved and Locked',                              
                               'digito_4_status'=>'Form Approved and Locked',
                               'digito_5_status'=>'Form Approved and Locked',
                               'digito_6_status'=>'Form Approved and Locked',
                               'ecg_status'=>'Form Approved and Locked',
                               'cumplimiento_2_status'=>'Form Approved and Locked',
                               'cumplimiento_3_status'=>'Form Approved and Locked',
                               'cumplimiento_4_status'=>'Form Approved and Locked',
                               'cumplimiento_5_status'=>'Form Approved and Locked',
                               'cumplimiento_6_status'=>'Form Approved and Locked',
                               'examen_laboratorio_status'=>'Form Approved and Locked',
                               'examen_laboratorio_5_status'=>'Form Approved and Locked',
                               'examen_laboratorio_6_status'=>'Form Approved and Locked',
                               'signos_vitales_1_status'=>'Form Approved and Locked',
                               'signos_vitales_2_status'=>'Form Approved and Locked',
                               'signos_vitales_4_status'=>'Form Approved and Locked',
                               'signos_vitales_5_status'=>'Form Approved and Locked',
                               'signos_vitales_6_status'=>'Form Approved and Locked',
                               'examen_neurologico_1_status'=>'Form Approved and Locked',
                               'examen_neurologico_2_status'=>'Form Approved and Locked',
                               'examen_neurologico_3_status'=>'Form Approved and Locked',
                               'examen_neurologico_4_status'=>'Form Approved and Locked',
                               'examen_neurologico_5_status'=>'Form Approved and Locked',
                               'examen_neurologico_6_status'=>'Form Approved and Locked',
                               'muestra_de_sangre_1_status'=>'Form Approved and Locked',
                               'muestra_de_sangre_5_status'=>'Form Approved and Locked',
                               'muestra_de_sangre_6_status'=>'Form Approved and Locked',
                               'fin_tratamiento_status'=>'Form Approved and Locked',
                               'fin_tratamiento_temprano_status'=>'Form Approved and Locked',
                               'tmt_a_2_status'=>'Form Approved and Locked',
                               'tmt_a_4_status'=>'Form Approved and Locked',
                               'tmt_a_5_status'=>'Form Approved and Locked',
                               'tmt_a_6_status'=>'Form Approved and Locked',
                               'tmt_b_2_status'=>'Form Approved and Locked',
                               'tmt_b_4_status'=>'Form Approved and Locked',
                               'tmt_b_5_status'=>'Form Approved and Locked',
                               'tmt_b_6_status'=>'Form Approved and Locked',
                               'eq_5d_5l_2_status'=>'Form Approved and Locked',
                               'eq_5d_5l_3_status'=>'Form Approved and Locked',
                               'eq_5d_5l_4_status'=>'Form Approved and Locked',
                               'eq_5d_5l_5_status'=>'Form Approved and Locked',
                               'eq_5d_5l_6_status'=>'Form Approved and Locked',
                               'npi_2_status'=>'Form Approved and Locked',
                               'npi_4_status'=>'Form Approved and Locked',
                               'npi_5_status'=>'Form Approved and Locked',
                               'npi_6_status'=>'Form Approved and Locked',
                               'apatia_2_status'=>'Form Approved and Locked',
                               'apatia_3_status'=>'Form Approved and Locked',
                               'apatia_4_status'=>'Form Approved and Locked',
                               'apatia_5_status'=>'Form Approved and Locked',
                               'apatia_6_status'=>'Form Approved and Locked',
                               'rnm_status'=>'Form Approved and Locked',
                               'rnm_2_status'=>'Form Approved and Locked',
                               'examen_fisico_1_status'=>'Form Approved and Locked',
                               'examen_fisico_2_status'=>'Form Approved and Locked',
                               'examen_fisico_3_status'=>'Form Approved and Locked',
                               'examen_fisico_4_status'=>'Form Approved and Locked',
                               'examen_fisico_5_status'=>'Form Approved and Locked',
                               'examen_fisico_6_status'=>'Form Approved and Locked',
                               'adas_2_status'=>'Form Approved and Locked',
                               'adas_4_status'=>'Form Approved and Locked',
                               'adas_5_status'=>'Form Approved and Locked',
                               'adas_6_status'=>'Form Approved and Locked',
                               'restas_2_status'=>'Form Approved and Locked',
                               'restas_4_status'=>'Form Approved and Locked',
                               'restas_5_status'=>'Form Approved and Locked',
                               'restas_6_status'=>'Form Approved and Locked'
                                );
            $result['pendiente_de_firmar'] = $this->CI->Model_Subject->buscarEstadosFormOr($or_where);
            if(isset($result['pendiente_de_firmar']) AND !empty($result['pendiente_de_firmar'])){           
                $firmar = array();
                foreach ($result['pendiente_de_firmar'] as $key => $val){
                    foreach ($val as $k => $v) {
                        if($v == 'Record Complete'){
                            $firmar[$val->id]['form'][] = $k;
                            $firmar[$val->id]['code'][] = $val->code;
                        }
                    }
                }

                $pendientes_firmar_links = array();
                $pendientes_firmar_codigos = array();

                foreach ($firmar as $key => $value) {

                   if(in_array('demography_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/demography/'.$key, 'Demografia');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('randomization_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/randomization/'.$key, 'Randomizacion');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('hachinski_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/hachinski_show/'.$key, 'Escala de Hachinski');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('historial_medico_1_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/historial_medico_show/'. $key .'/1', 'Historia Medica');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('historial_medico_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/historial_medico_show/'. $key .'/2', 'Historia Medica');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('inclusion_exclusion_1_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/inclusion_exclusion_show/'. $key .'/1', 'Inclusion Exclusion');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('inclusion_exclusion_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/inclusion_exclusion_show/'. $key .'/2', 'Inclusion Exclusion');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('digito_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/digito_directo_show/'.$key .'/2', 'Digito Directo');$pendientes_firmar_codigos[] = $value['code'];}                              
                   if(in_array('digito_4_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/digito_directo_show/'.$key .'/4', 'Digito Directo');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('digito_5_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/digito_directo_show/'.$key .'/5', 'Digito Directo');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('digito_6_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/digito_directo_show/'.$key .'/6', 'Digito Directo');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('ecg_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/ecg_show/'.$key, 'ECG');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/cumplimiento_show/'.$key.'/2', 'Cumplimiento');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_3_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/cumplimiento_show/'.$key.'/3', 'Cumplimiento');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_4_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/cumplimiento_show/'.$key.'/4', 'Cumplimiento');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_5_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/cumplimiento_show/'.$key.'/5', 'Cumplimiento');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('cumplimiento_6_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/cumplimiento_show/'.$key.'/6', 'Cumplimiento');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_laboratorio_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_laboratorio_show/'.$key .'/1', 'Examen laboratorio');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_laboratorio_5_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_laboratorio_show/'.$key .'/5', 'Examen laboratorio');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_laboratorio_6_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_laboratorio_show/'.$key .'/6', 'Examen laboratorio');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_1_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/signos_vitales_show/'.$key.'/1', 'Signos vitales');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/signos_vitales_show/'.$key.'/2', 'Signos vitales');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_4_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/signos_vitales_show/'.$key.'/4', 'Signos vitales');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_5_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/signos_vitales_show/'.$key.'/5', 'Signos vitales');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('signos_vitales_6_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/signos_vitales_show/'.$key.'/6', 'Signos vitales');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_1_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/1', 'Examen neurologico');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/2', 'Examen neurologico');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_3_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/3', 'Examen neurologico');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_4_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/4', 'Examen neurologico');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_5_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/5', 'Examen neurologico');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_neurologico_6_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_neurologico_show/'.$key.'/6', 'Examen neurologico');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('muestra_de_sangre_1_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/muestra_de_sangre_show/'.$key.'/1', 'Muestra de Sangre');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('muestra_de_sangre_5_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/muestra_de_sangre_show/'.$key.'/5', 'Muestra de Sangre');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('muestra_de_sangre_6_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/muestra_de_sangre_show/'.$key.'/6', 'Muestra de Sangre');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('fin_tratamiento_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/fin_tratamiento_show/'.$key, 'Fin tratamiento');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('fin_tratamiento_temprano_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/fin_tratamiento_temprano_show/'.$key, 'Fin tratamiento temprano');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('tmt_a_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/tmt_a_show/'.$key.'/2', 'TMT A');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('tmt_a_4_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/tmt_a_show/'.$key.'/4', 'TMT A');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('tmt_a_5_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/tmt_a_show/'.$key.'/5', 'TMT A');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('tmt_a_6_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/tmt_a_show/'.$key.'/6', 'TMT A');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('tmt_b_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/tmt_b_show/'.$key.'/2', 'TMT B');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('tmt_b_4_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/tmt_b_show/'.$key.'/4', 'TMT B');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('tmt_b_5_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/tmt_b_show/'.$key.'/5', 'TMT B');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('tmt_b_6_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/tmt_b_show/'.$key.'/6', 'TMT B');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/2', 'EQ-5D-5L');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_3_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/3', 'EQ-5D-5L');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_4_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/4', 'EQ-5D-5L');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_5_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/5', 'EQ-5D-5L');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('eq_5d_5l_6_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/eq_5d_5l_show/'.$key.'/6', 'EQ-5D-5L');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('npi_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/npi_show/'.$key.'/2', 'NPI');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('npi_4_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/npi_show/'.$key.'/4', 'NPI');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('npi_5_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/npi_show/'.$key.'/5', 'NPI');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('npi_6_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/npi_show/'.$key.'/6', 'NPI');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('apatia_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/apatia_show/'.$key.'/2', 'Apatia');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('apatia_3_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/apatia_show/'.$key.'/3', 'Apatia');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('apatia_4_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/apatia_show/'.$key.'/4', 'Apatia');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('apatia_5_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/apatia_show/'.$key.'/5', 'Apatia');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('apatia_6_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/apatia_show/'.$key.'/6', 'Apatia');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('rnm_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/rnm_show/'.$key .'/1', 'RNM');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('rnm_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/rnm_show/'.$key .'/2', 'RNM');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_1_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_fisico_show/'.$key.'/1', 'Examen Fisico');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_fisico_show/'.$key.'/2', 'Examen Fisico');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_3_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_fisico_show/'.$key.'/3', 'Examen Fisico');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_4_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_fisico_show/'.$key.'/4', 'Examen Fisico');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_5_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_fisico_show/'.$key.'/5', 'Examen Fisico');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('examen_fisico_6_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/examen_fisico_show/'.$key.'/6', 'Examen Fisico');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('adas_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/adas_show/'.$key.'/2', 'Adas cog');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('adas_4_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/adas_show/'.$key.'/4', 'Adas cog');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('adas_5_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/adas_show/'.$key.'/5', 'Adas cog');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('adas_6_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/adas_show/'.$key.'/6', 'Adas cog');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('restas_2_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/restas_show/'.$key.'/2', 'Restas Seriadas');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('restas_4_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/restas_show/'.$key.'/4', 'Restas Seriadas');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('restas_5_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/restas_show/'.$key.'/5', 'Restas Seriadas');$pendientes_firmar_codigos[] = $value['code'];}
                   if(in_array('restas_6_status', $value['form'])){ $pendientes_firmar_links[] = anchor('subject/restas_show/'.$key.'/6', 'Restas Seriadas');$pendientes_firmar_codigos[] = $value['code'];}
                   
                }
                
                $result['pendientes_firmar_links'] = $pendientes_firmar_links;
                $result['pendientes_firmar_codigos'] = $pendientes_firmar_codigos;
            }


    		#Pending Querys
    		$result['querys'] = $this->CI->Model_Query->allWhere('status = "Abierto"');
    		
    	}
    	
    	return $result;

    }
}