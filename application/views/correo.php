<?php date_default_timezone_set('America/Santiago');?>
	<div id='header'>
		<img src="<?= base_url('img/logo5.jpg'); ?>" /><br />	
	</div>

	<div id='cuerpo'>
		<br />
			<?= $this->load->view($contenido) ?>
		<br />
	</div>

	<div id='footer' style="text-align:right;">
	<br />
	IWRS Estudio Dentoxol &reg;
	Asesor�as en Investigaci�n Cl�nica SpA
	<br />
	</div>
