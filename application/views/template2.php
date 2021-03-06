<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        
        <link href="<?= base_url('css/micss.css') ?>" rel="stylesheet">
        <script src="<?= base_url('js/jquery.js') ?>"></script>
        <script src="<?= base_url('js/jquery-ui.js') ?>"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <link href="<?= base_url('css/jquery-ui.css') ?>" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <script src="<?= base_url('js/jquery-idletimer-master/src/idle-timer.js') ?>"></script>
        <script src="<?= base_url('js/colorbox/jquery.colorbox-min.js') ?>"></script>
        <link href="<?= base_url('css/colorbox.css') ?>" rel="stylesheet">
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

            $("#fecha").change(function(){
                var datos = $("input[name=etapa]").val() || 0;
                $.post("<?php echo base_url('subject/fechaEnRango');?>",
                        {                   
                            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>', 
                            "etapa": datos,                 
                            "fecha_randomizacion": "<?php echo ((isset($subject->randomization_date)) ? $subject->randomization_date : '');?>",
                            "fecha": $(this).val()
                        },
                        function(d){
                            if(d != ''){
                                $("#td_mensaje_desviacion").html(d);
                                $("#mensaje_desviacion").show();
                            }
                            else{
                                $("#td_mensaje_desviacion").html('');
                                $("#mensaje_desviacion").hide();
                            }
                            
                        }
                );
            });
        });
        </script>
        <title>Manejo de Sujetos</title>
        <style>
            body {
              padding-top: 70px;
            }
            footer {
              padding-left: 15px;
              padding-right: 15px;
            }
            #header {
                position: fixed;
                z-index: 10;
                right: 0;
                left: 0;
                top: 0;
            }
            .headroom {
                transition: transform 200ms linear;
            }
            .headroom--pinned {
                transform: translateY(0%);
            }
            .headroom--unpinned {
                transform: translateY(-100%);
            }
            .animated{-webkit-animation-duration:.5s;-moz-animation-duration:.5s;-o-animation-duration:.5s;animation-duration:.5s;-webkit-animation-fill-mode:both;-moz-animation-fill-mode:both;-o-animation-fill-mode:both;animation-fill-mode:both}@-webkit-keyframes slideDown{0%{-webkit-transform:translateY(-100%)}100%{-webkit-transform:translateY(0)}}@-moz-keyframes slideDown{0%{-moz-transform:translateY(-100%)}100%{-moz-transform:translateY(0)}}@-o-keyframes slideDown{0%{-o-transform:translateY(-100%)}100%{-o-transform:translateY(0)}}@keyframes slideDown{0%{transform:translateY(-100%)}100%{transform:translateY(0)}}.animated.slideDown{-webkit-animation-name:slideDown;-moz-animation-name:slideDown;-o-animation-name:slideDown;animation-name:slideDown}@-webkit-keyframes slideUp{0%{-webkit-transform:translateY(0)}100%{-webkit-transform:translateY(-100%)}}@-moz-keyframes slideUp{0%{-moz-transform:translateY(0)}100%{-moz-transform:translateY(-100%)}}@-o-keyframes slideUp{0%{-o-transform:translateY(0)}100%{-o-transform:translateY(-100%)}}@keyframes slideUp{0%{transform:translateY(0)}100%{transform:translateY(-100%)}}.animated.slideUp{-webkit-animation-name:slideUp;-moz-animation-name:slideUp;-o-animation-name:slideUp;animation-name:slideUp}@-webkit-keyframes swingInX{0%{-webkit-transform:perspective(400px) rotateX(-90deg)}100%{-webkit-transform:perspective(400px) rotateX(0deg)}}@-moz-keyframes swingInX{0%{-moz-transform:perspective(400px) rotateX(-90deg)}100%{-moz-transform:perspective(400px) rotateX(0deg)}}@-o-keyframes swingInX{0%{-o-transform:perspective(400px) rotateX(-90deg)}100%{-o-transform:perspective(400px) rotateX(0deg)}}@keyframes swingInX{0%{transform:perspective(400px) rotateX(-90deg)}100%{transform:perspective(400px) rotateX(0deg)}}.animated.swingInX{-webkit-transform-origin:top;-moz-transform-origin:top;-ie-transform-origin:top;-o-transform-origin:top;transform-origin:top;-webkit-backface-visibility:visible!important;-webkit-animation-name:swingInX;-moz-backface-visibility:visible!important;-moz-animation-name:swingInX;-o-backface-visibility:visible!important;-o-animation-name:swingInX;backface-visibility:visible!important;animation-name:swingInX}@-webkit-keyframes swingOutX{0%{-webkit-transform:perspective(400px) rotateX(0deg)}100%{-webkit-transform:perspective(400px) rotateX(-90deg)}}@-moz-keyframes swingOutX{0%{-moz-transform:perspective(400px) rotateX(0deg)}100%{-moz-transform:perspective(400px) rotateX(-90deg)}}@-o-keyframes swingOutX{0%{-o-transform:perspective(400px) rotateX(0deg)}100%{-o-transform:perspective(400px) rotateX(-90deg)}}@keyframes swingOutX{0%{transform:perspective(400px) rotateX(0deg)}100%{transform:perspective(400px) rotateX(-90deg)}}.animated.swingOutX{-webkit-transform-origin:top;-webkit-animation-name:swingOutX;-webkit-backface-visibility:visible!important;-moz-animation-name:swingOutX;-moz-backface-visibility:visible!important;-o-animation-name:swingOutX;-o-backface-visibility:visible!important;animation-name:swingOutX;backface-visibility:visible!important}@-webkit-keyframes flipInX{0%{-webkit-transform:perspective(400px) rotateX(90deg);opacity:0}100%{-webkit-transform:perspective(400px) rotateX(0deg);opacity:1}}@-moz-keyframes flipInX{0%{-moz-transform:perspective(400px) rotateX(90deg);opacity:0}100%{-moz-transform:perspective(400px) rotateX(0deg);opacity:1}}@-o-keyframes flipInX{0%{-o-transform:perspective(400px) rotateX(90deg);opacity:0}100%{-o-transform:perspective(400px) rotateX(0deg);opacity:1}}@keyframes flipInX{0%{transform:perspective(400px) rotateX(90deg);opacity:0}100%{transform:perspective(400px) rotateX(0deg);opacity:1}}.animated.flipInX{-webkit-backface-visibility:visible!important;-webkit-animation-name:flipInX;-moz-backface-visibility:visible!important;-moz-animation-name:flipInX;-o-backface-visibility:visible!important;-o-animation-name:flipInX;backface-visibility:visible!important;animation-name:flipInX}@-webkit-keyframes flipOutX{0%{-webkit-transform:perspective(400px) rotateX(0deg);opacity:1}100%{-webkit-transform:perspective(400px) rotateX(90deg);opacity:0}}@-moz-keyframes flipOutX{0%{-moz-transform:perspective(400px) rotateX(0deg);opacity:1}100%{-moz-transform:perspective(400px) rotateX(90deg);opacity:0}}@-o-keyframes flipOutX{0%{-o-transform:perspective(400px) rotateX(0deg);opacity:1}100%{-o-transform:perspective(400px) rotateX(90deg);opacity:0}}@keyframes flipOutX{0%{transform:perspective(400px) rotateX(0deg);opacity:1}100%{transform:perspective(400px) rotateX(90deg);opacity:0}}.animated.flipOutX{-webkit-animation-name:flipOutX;-webkit-backface-visibility:visible!important;-moz-animation-name:flipOutX;-moz-backface-visibility:visible!important;-o-animation-name:flipOutX;-o-backface-visibility:visible!important;animation-name:flipOutX;backface-visibility:visible!important}@-webkit-keyframes bounceInDown{0%{opacity:0;-webkit-transform:translateY(-200px)}60%{opacity:1;-webkit-transform:translateY(30px)}80%{-webkit-transform:translateY(-10px)}100%{-webkit-transform:translateY(0)}}@-moz-keyframes bounceInDown{0%{opacity:0;-moz-transform:translateY(-200px)}60%{opacity:1;-moz-transform:translateY(30px)}80%{-moz-transform:translateY(-10px)}100%{-moz-transform:translateY(0)}}@-o-keyframes bounceInDown{0%{opacity:0;-o-transform:translateY(-200px)}60%{opacity:1;-o-transform:translateY(30px)}80%{-o-transform:translateY(-10px)}100%{-o-transform:translateY(0)}}@keyframes bounceInDown{0%{opacity:0;transform:translateY(-200px)}60%{opacity:1;transform:translateY(30px)}80%{transform:translateY(-10px)}100%{transform:translateY(0)}}.animated.bounceInDown{-webkit-animation-name:bounceInDown;-moz-animation-name:bounceInDown;-o-animation-name:bounceInDown;animation-name:bounceInDown}@-webkit-keyframes bounceOutUp{0%{-webkit-transform:translateY(0)}30%{opacity:1;-webkit-transform:translateY(20px)}100%{opacity:0;-webkit-transform:translateY(-200px)}}@-moz-keyframes bounceOutUp{0%{-moz-transform:translateY(0)}30%{opacity:1;-moz-transform:translateY(20px)}100%{opacity:0;-moz-transform:translateY(-200px)}}@-o-keyframes bounceOutUp{0%{-o-transform:translateY(0)}30%{opacity:1;-o-transform:translateY(20px)}100%{opacity:0;-o-transform:translateY(-200px)}}@keyframes bounceOutUp{0%{transform:translateY(0)}30%{opacity:1;transform:translateY(20px)}100%{opacity:0;transform:translateY(-200px)}}.animated.bounceOutUp{-webkit-animation-name:bounceOutUp;-moz-animation-name:bounceOutUp;-o-animation-name:bounceOutUp;animation-name:bounceOutUp}
            /* Off Canvas */
            @media screen and (max-width: 768px) {
              .row-offcanvas {
                position: relative;
                -webkit-transition: all 0.4s ease-out;
                -moz-transition: all 0.4s ease-out;
                transition: all 0.4s ease-out;
              }

              .row-offcanvas-left
              #sidebarLeft {
                left: -50%;
              }

              .row-offcanvas-left.active {
                left: 50%;
              }
             
              .row-offcanvas-right 
              #sidebarRight {
                right: -50%;
              }

              .row-offcanvas-right.active {
                right: 50%;
              }

              .sidebar-offcanvas {
                position: absolute;
                top: 0;
                width: 50%;
                margin-left: 10px;
              }
              #offcanvasleft,#offcanvasright{margin-top:10px;}
            }
        </style>
        <script>
            $(function(){
                $('#offcanvasleft').click(function() {
                  $('.row-offcanvas-left').toggleClass('active');
                });
            });
        </script>
    </head>

    <body>
    <?php date_default_timezone_set('America/Santiago'); ?>
        <!-- Barra superior fija con opciones principales de menú -->
        <header id="header" class="headroom">
            <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
                <div class="container-fluid">

                    <div class="navbar-header">
                        <p class="pull-left visible-xs">
                            <button id="offcanvasleft" class="btn btn-xs" type="button" data-toggle="offcanvasleft"><i class="glyphicon glyphicon-chevron-left"></i></button>
                        </p>
                        <p class="pull-right visible-xs">
                            <button id="offcanvasright" class="btn btn-xs" type="button" data-toggle="offcanvasright"><i class="glyphicon glyphicon-chevron-right"></i></button>
                        </p>
                        <button class="navbar-toggle" type="button" data-target=".navbar-collapse" data-toggle="collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="brand" href="#"> <img src='<?php echo base_url('img/icc_logo.png'); ?>' style='width:50px;'> </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?= my_menu_ppal(); ?>  
                        </ul>
                    </div>
                    <!-- /.nav-collapse -->

                </div>
                <!-- /.container -->
            </div>
            <!-- /.navbar -->
        </header>       

        <!-- Contenido dividos en 2, una parte izquierda para el menú, una parte central para las vistas -->
        <?php 
            $segment = $this->uri->segment(2);            
        ?>
        <div class="container-fluid">
            <div class="row-fluid">             
                <!-- Menú del sistema -->
                 <div class="row row-offcanvas row-offcanvas-left">
                    <div class="row-offcanvas row-offcanvas-right">                        
                        <div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebarLeft" role="navigation">
                        <?php
                        
                        
                        if(null !== $this->session->userdata('usuario')){ ?>
                                <div class="well sidebar-nav" style='position: fixed'>
                                    <ul class="nav">                                    
                                        <?= my_menu_app(); ?>
                                    </ul>
                                </div>
                                <!--/.well -->
                        <?php } ?>
                        </div>
                        <!--/span-->

                         <!-- Contenido de la aplicación -->
                        <div class="col-xs-12 col-sm-10">

                            <div class="row">
                                <?php $this->load->view($contenido) ?>
                            </div>
                            <!--/row-->
                        </div>
                        <!--/span-->
                    </div>

                </div>               
               
                
            </div>

            <hr>

            <footer>
                <p style="text-align:right;"> <?= piePagina(); ?> </p>
            </footer>
        </div>



    </body>
</html>
