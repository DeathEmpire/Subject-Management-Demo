<legend style='text-align:center;'>Pendientes (<?= $this->session->userdata('perfil_name');?>)</legend>

<?php

	if(isset($to_do) AND !empty($to_do)){

		#Pendig demography_form_verify
		/*if(isset($to_do['demography_form_verify']) AND !empty($to_do['demography_form_verify'])){ ?>
			<b>Pending Verify a Form: </b>
			<table class='table table-striped table-condensed table-bordered'>
				<thead>
					<th>Formulario</th>					
					<th>Sujeto</th>
					<th>Link</th>					
				</thead>
				<tbody>
				<?php
				foreach ($to_do['demography_form_verify'] as $verify) {?>
					<tr>
						<td>Demografia</td>
						<td><?= $verify->code; ?></td>
						<td><?= anchor('subject/demography/'. $verify->id, 'Ver', array('class'=>'btn')) ;?></td>						
					</tr>

				<?php }	?>

		 		</tbody>
		 	</table>
		<?php }

		#Pendig demography_form_lock
		if(isset($to_do['demography_form_lock']) AND !empty($to_do['demography_form_lock'])){ ?>
			<b>Pending Lock a Form: </b>
			<table class='table table-striped table-condensed table-bordered table-striped table-hover'>
				<thead>
					<th>Formulario</th>					
					<th>Sujeto</th>
					<th>Link</th>					
				</thead>
				<tbody>
				<?php
				foreach ($to_do['demography_form_lock'] as $lock) {?>
					<tr>
						<td>Demografia</td>
						<td><?= $lock->code; ?></td>
						<td><?= anchor('subject/demography/'. $lock->id, 'Ver', array('class'=>'btn')) ;?></td>						
					</tr>

				<?php }	?>

		 		</tbody>
		 	</table>
		<?php }

		#Pendig demography_form_sign
		if(isset($to_do['demography_form_sign']) AND !empty($to_do['demography_form_sign'])){ ?>
			<b>Pending Sign a Form: </b>
			<table class='table table-striped table-condensed table-bordered table-striped table-hover'>
				<thead>
					<th>Formulario</th>					
					<th>Sujeto</th>
					<th>Link</th>				
				</thead>
				<tbody>
				<?php
				foreach ($to_do['demography_form_sign'] as $sign) {?>
					<tr>
						<td>Demogrfia</td>
						<td><?= $sign->code; ?></td>
						<td><?= anchor('subject/demography/'. $sign->id, 'Ver', array('class'=>'btn')) ;?></td>						
					</tr>

				<?php }	?>

		 		</tbody>
		 	</table>
		<?php }*/


		//formularios pendientes de verificacion
		if(isset($to_do['pendientes_verificar_links']) AND !empty($to_do['pendientes_verificar_links'])){?>
			<b>Formularios pendientes de Aprobacion: </b><br>
			<table class='table table-bordered table-striped table-hover table-condensed'>
				<thead>
					<th>Sujeto</th>
					<th>Formulario</th>					
				</thead>
				<tbody>
				<?php
					$cantidad = count($to_do['pendientes_verificar_links']);
					for($i = 0; $i < $cantidad; $i++){

						echo "<tr>							
							<td>". ((is_array($to_do['pendientes_verificar_codigos'][$i])) ? $to_do['pendientes_verificar_codigos'][$i][0] : $to_do['pendientes_verificar_codigos'][$i]) ."</td>
							<td>". $to_do['pendientes_verificar_links'][$i] ."</td>
						</tr>";
					}	
				?>
				</tbody>
			</table>
			
		<?php
		}		

		//formularios pendientes de Cierre
		if(isset($to_do['pendientes_cerrar_links']) AND !empty($to_do['pendientes_cerrar_links'])){?>
			<b>Formularios pendientes de Cierre: </b><br>
			<table class='table table-bordered table-striped table-hover table-condensed'>
				<thead>
					<th>Sujeto</th>
					<th>Formulario</th>					
				</thead>
				<tbody>
				<?php
					$cantidad = count($to_do['pendientes_cerrar_links']);
					for($i = 0; $i < $cantidad; $i++){
						
						echo "<tr>							
							<td>". ((is_array($to_do['pendientes_cerrar_codigos'][$i])) ? $to_do['pendientes_cerrar_codigos'][$i][0] : $to_do['pendientes_cerrar_codigos'][$i]) ."</td>
							<td>". $to_do['pendientes_cerrar_links'][$i] ."</td>
						</tr>";
					}	
				?>
				</tbody>
			</table>
			
		<?php
		}

		//formularios pendientes de firma
		if(isset($to_do['pendientes_firmar_links']) AND !empty($to_do['pendientes_firmar_links'])){?>

			<b>Formularios pendientes de Firma: </b><br>
			<table class='table table-bordered table-striped table-hover table-condensed'>
				<thead>
					<th>Sujeto</th>
					<th>Formulario</th>					
				</thead>
				<tbody>
				<?php
					$cantidad = count($to_do['pendientes_firmar_links']);
					for($i = 0; $i < $cantidad; $i++){						
						echo "<tr>							
							<td>". ((is_array($to_do['pendientes_firmar_codigos'][$i])) ? $to_do['pendientes_firmar_codigos'][$i][0] : $to_do['pendientes_firmar_codigos'][$i]) ."</td>
							<td>". $to_do['pendientes_firmar_links'][$i] ."</td>
						</tr>";
					}	
				?>
				</tbody>
			</table>
			
		<?php
		}

		#Pending Querys
		if(isset($to_do['querys']) AND !empty($to_do['querys'])){
			#List of pending querys in all forms?>
			<b>Querys Pendientes: </b>
			<table class='table table-striped table-condensed table-bordered'>
				<thead>
					<th>Formulario</th>					
					<th>Sujeto</th>
					<th>Visita</th>
					<th>Link</th>					
				</thead>
				<tbody>

			<?php
			foreach ($to_do['querys'] as $query) { 

					#make de links for diferents form
					if($query->form == 'Demography'){
						$link = '';
					}
					
					elseif($query->form == 'Adverse Event'){
						$link = 'query/additional_form_query_show/'. $query->subject_id .'/'. $query->id .'/Adverse Event';
					}
					elseif($query->form == 'Protocol Deviation'){
						$link = 'query/additional_form_query_show/'. $query->subject_id .'/'. $query->id .'/Protocol Deviation';
					}
					elseif($query->form == 'Concomitant Medication'){
						$link = 'query/additional_form_query_show/'. $query->subject_id .'/'. $query->id .'/Concomitant Medication';
					}


					$link = 'subject/'. $query->form ."_show/". $query->subject_id ."/". $query->etapa;

					switch($query->etapa){
						case 1 : $protocolo = "Selección"; break;
						case 2 : $protocolo = "Basal Día 1"; break;
						case 3 : $protocolo = "Semana 4"; break;
						case 4 : $protocolo = "Semana 12"; break;
						case 5 : $protocolo = "Término del Estudio"; break;
						case 6 : $protocolo = "Terminación Temprana"; break;
						default : $protocolo = "Selección"; break;
					}

			?>

				<tr>
					<td><?= $query->form;?></td>
					<td><?= $query->code;?></td>
					<td><?= $protocolo;?></td>
					<td><?= anchor($link, 'Ver', array('class'=>'btn'));?></td>
				</tr>	
				
			<?php }?>
			
				</tbody>
			</table>
  <?php }

	}
?>