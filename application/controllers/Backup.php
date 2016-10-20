<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Backup extends CI_Controller {



	// Constructor de la clase

	function __construct() {

		parent::__construct();		

		

    }



    function index(){

    	$data['contenido'] = 'backup/index';

		$data['titulo'] = 'Descargar Respaldo de Datos';		

		$this->load->view('template2', $data);

	}



	public function create(){

		$dbname = 'medcrf_icc';
		$dbhost = 'localhost';
		$dbuser = 'medcrf_icc';
		$dbpass = 'n9H%2{d*VH!?';

		$backupFile = $dbname . date("Y-m-d-H-i-s") . '.gz';
		$command = "mysqldump -ubackup -h $dbhost -u $dbuser -p$dbpass $dbname --quick | gzip > './files/$backupFile'";
		system($command);

		$data['contenido'] = 'backup/index';
		$data['titulo'] = 'Descargar Respaldo de Datos';		
		$data['archivo'] = $backupFile;

		$this->load->view('template2', $data);		

	}

}