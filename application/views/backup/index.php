
<?php 
	if(isset($archivo) AND !empty($archivo)){

		echo "El archivo de genero correctamente: <a href='". base_url('files/'. $archivo) ."' class='btn btn-primary'>Descargar</a>";
	}else{ ?>
		<?= form_open('backup/create'); ?>

		Generar archivo de respaldo de datos: <input type='submit' name='enviar' value='Generar' class='btn btn-primary'>

		<?= form_close(); ?>

<?php	
	}	

?>