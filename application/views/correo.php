<?php date_default_timezone_set('America/Santiago');?>
	<div id='header'>
		<img src="<?= base_url('img/icc_logo.png'); ?>" style='width:70px;' /><br />	
	</div>

	<div id='cuerpo'>
		<br />
			<?php $this->load->view($contenido) ?>
		<br />
	</div>

	<div id='footer' style="text-align:right;">
	<br />	
	Asesorías en Investigación Clínica SpA
	<br />
	</div>
