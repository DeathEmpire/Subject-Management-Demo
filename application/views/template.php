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
        <script src="<?= base_url('js/colorbox/jquery.colorbox-min.js') ?>"></script>
        <link href="<?= base_url('css/colorbox.css') ?>" rel="stylesheet">
		<link href="<?= base_url('css/jquery-ui.css') ?>" rel="stylesheet">
        <link href="<?= base_url('css/font-awesome.css') ?>" rel="stylesheet">
        <script src="<?= base_url('js/jquery-idletimer-master/src/idle-timer.js') ?>"></script>
        <script>
        $(function(){
            var
                session = {
                    //Logout Settings
                    inactiveTimeout: 900000,     //(ms) The time until we display a warning message
                    warningTimeout: 900000,      //(ms) The time until we log them out
                    minWarning: 900000,           //(ms) If they come back to page (on mobile), The minumum amount, before we just log them out
                    warningStart: null,         //Date time the warning was started
                    warningTimer: null,         //Timer running every second to countdown to logout
                    logout: function () {       //Logout function once warningTimeout has expired
                        window.location = "<?php echo base_url('home/salir'); ?>";
                        //$("#mdlLoggedOut").modal("show");
                    },

                    //Keepalive Settings
                    keepaliveTimer: null,
                    keepaliveUrl: "",
                    keepaliveInterval: 900000,     //(ms) the interval to call said url
                    keepAlive: function () {
                        $.ajax({ url: session.keepaliveUrl });
                    }
                }
            ;


            $(document).on("idle.idleTimer", function (event, elem, obj) {
                //Get time when user was last active
                var
                    diff = (+new Date()) - obj.lastActive - obj.timeout,
                    warning = (+new Date()) - diff
                ;
                
                //On mobile js is paused, so see if this was triggered while we were sleeping
                if (diff >= session.warningTimeout || warning <= session.minWarning) {
                    window.location = "<?php echo base_url('home/salir'); ?>";
                    // $("#mdlLoggedOut").modal("show");
                } else {
                    //Show dialog, and note the time
                    // $('#sessionSecondsRemaining').html(Math.round((session.warningTimeout - diff) / 1000));
                    // $("#myModal").modal("show");
                    session.warningStart = (+new Date()) - diff;

                    //Update counter downer every second
                    session.warningTimer = setInterval(function () {
                        var remaining = Math.round((session.warningTimeout / 1000) - (((+new Date()) - session.warningStart) / 1000));
                        if (remaining >= 0) {
                            // $('#sessionSecondsRemaining').html(remaining);
                        } else {
                            session.logout();
                        }
                    }, 1000)
                }
            });

            // create a timer to keep server session alive, independent of idle timer
            session.keepaliveTimer = setInterval(function () {
                session.keepAlive();
            }, session.keepaliveInterval);

           

            //Set up the timer, if inactive for 10 seconds log them out
            $(document).idleTimer(session.inactiveTimeout);

            $(".colorbox_inline").colorbox({inline:true, width:"80%"});
        });
        </script>
		<title>Manejo de Sujetos</title>
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
                    <a class="brand" href="#"> <img src='<?php echo base_url('img/icc_logo.png'); ?>' style='width:50px;'> </a>

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
                <div class="span1">
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
                <div class="span11">
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
