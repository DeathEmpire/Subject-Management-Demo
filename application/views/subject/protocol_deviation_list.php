<legend style='text-align:center;'>Desviación de Protocolo</legend>
<b>Sujeto Actual:</b>
<table class="table table-condensed table-bordered">
	<thead>
		<tr style='background-color: #C0C0C0;'>
			<th>Centro</th>
			<th>ID del Sujeto</th>
			<th>Iniciales</th>
			<th>Fecha de Ingreso</th>
			<th>Fecha de Randomizacion</th>
			<th>Kit Asignado</th>		
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?= $subject->center_name; ?></td>
			<td><?= anchor('subject/grid/'.$subject->id, $subject->code); ?></td>
			<td><?= $subject->initials; ?></td>		
			<td><?= ((isset($subject->screening_date) AND $subject->screening_date != '0000-00-00') ? date("d-M-Y",strtotime($subject->screening_date)) : ""); ?></td>
			<td><?= ((isset($subject->randomization_date) AND $subject->randomization_date != '0000-00-00') ? date("d-M-Y",strtotime($subject->randomization_date)) : ""); ?></td>
			<td><?= $subject->kit1; ?></td>			
		</tr>
	</tbody>
</table>
<br />

<?php 
	if(isset($lista) AND !empty($lista)){
		//mostramos todos los adicionales que tiene el paciente
?>
	<table class='table table-striped table-bordered table-hover'>
		<thead>
			<tr>
				<td>Estado</td>				
				<th>Fecha</th>
				<th>Descripcion</th>
				<th>¿Está la desviación aprobada por el Patrocinador?</th>
				<th>Patrocinador</th>				
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($lista as $v) {
			?>
				<tr>
					<?php
						
						if(!isset($v->status) OR empty($v->status)){
							$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
						}
						elseif ($v->status == 'Record Complete') {
							$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
						}
						elseif ($v->status == 'Document Approved and Signed by PI') {
							$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
						}
						elseif ($v->status == 'Form Approved and Locked') {
							$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
						}
						elseif ($v->status == 'Form Approved by Monitor') {
							$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
						}
						elseif ($v->status == 'Query') {
							$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
						}
						elseif ($v->status == 'Error') {
							$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
						}
						else{
							$icon = '*';		
						}

					?>
					<td><?= $icon; ?></td>					
					<td><?= (($v->date_of_deviation != '0000-00-00') ? date("d/m/Y", strtotime($v->date_of_deviation)) : "");?></td>
					<td><?= $v->description; ?></td>
					<td><?= (($v->pre_approved == 1) ? 'Si' : 'No'); ?></td>
					<td><?= $v->sponsor_name; ?></td>
					
					<td><?= anchor('subject/protocol_deviation_show/'. $subject->id .'/'.$v->id,'Ver', array('class'=>'btn btn-default')); ?></td>
				</tr>

			<?php	}
			?>


		</tbody>
	</table>
	


<?php
	}else{
		echo "<div style='text-align:center;font-weight:bold;'>El sujeto no tiene agregado formulario de desviación de protocolo.</div>";
	}
?>