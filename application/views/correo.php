<?php date_default_timezone_set('America/Santiago');?>
	<div id='header'>
		<img src="<?= base_url('img/icc_logo.png'); ?>" /><br />	
	</div>

	<div id='cuerpo'>
		<br />
			<?= $this->load->view($contenido) ?>
		<br />
	</div>

	<div id='footer' style="text-align:right;">
	<br />
	Nombre Estudio &reg;
	Asesor�as en Investigaci�n Cl�nica SpA
	<br />
	</div>
