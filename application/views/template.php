<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet" media="screen">
		<link href="<?= base_url('css/bootstrap-responsive.css') ?>" rel="stylesheet">
		<link href="<?= base_url('css/micss.css') ?>" rel="stylesheet">
		<script src="<?= base_url('js/jquery.js') ?>"></script>
		<script src="<?= base_url('js/jquery-ui.js') ?>"></script>
    	<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
		<link href="<?= base_url('css/jquery-ui.css') ?>" rel="stylesheet">
		<title>Subject Management</title>
	</head>

	<body>
	<?php date_default_timezone_set('America/Santiago'); ?>
		<!-- Barra superior fija con opciones principales de menú -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#"> <?= $titulo ?> </a>

                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <?= my_menu_ppal(); ?>							
                        </ul>						
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido dividos en 2, una parte izquierda para el menú, una parte central para las vistas -->
		<div class="container-fluid">
            <div class="row-fluid">            	
                <!-- Menú del sistema -->
                <div class="span2">
                    <?php
                        if(null !== $this->session->userdata('usuario')){
                            $detect = new Mobile_Detect();
                            
                            if($detect->isMobile() || $detect->isTablet() || $detect->isAndroidOS() || $detect->isiOS()){ 
                                /*Mobile Users*/
                        ?>
                            <div class="well sidebar-nav">
                                <ul class="nav nav-list">
                                    <?= my_menu_app(); ?>
                                </ul>
                            </div>

                        <?php   }else{ 
                            /*Desktop Users*/                            
                            ?>

                            <div class="well sidebar-nav" style='position: fixed;'>
                                <ul class="nav nav-list">
                                    <?= my_menu_app(); ?>
                                </ul>
                            </div>
                    <?php    }
                     } ?>    
                </div>                
                <!-- Contenido de la aplicación -->
                <div class="span10">
                	<?php $this->load->view($contenido) ?>
                </div>
            </div>

            <hr>

            <footer>
            	<p style="text-align:right;"> <?= piePagina(); ?> </p>
            </footer>
        </div>


	</body>
</html>
