<legend style='text-align:center;'>Electrocardiograma de reposo (ECG)</legend>
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
				<th>Visita</th>
				<th>Fecha</th>
				<th>Ritmo Sinusal</th>
				<th>FC</th>
				<th>PR</th>
				<th>QRS</th>
				<th>QT</th>
				<th>QTc</th>
				<th>Eje QRS</th>
				<th>Iterpretación ECG</th>
				<th>Observaciones</th>
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
					<td><?= $v->etapa; ?></td>
					<td><?= (($v->fecha != '0000-00-00') ? date("d/m/Y", strtotime($v->fecha)) : "");?></td>
					<td><?= (($v->ritmo_sinusal == 1) ? 'Si' : 'No' ); ?></td>
					<td><?= $v->fc; ?></td>
					<td><?= $v->pr; ?></td>
					<td><?= $v->qrs; ?></td>
					<td><?= $v->qt; ?></td>
					<td><?= $v->qtc; ?></td>
					<td><?= $v->qrs2; ?></td>
					<td><?= (($v->interpretacion_ecg == 1) ? 'Normal' : 'Anormal' ); ?></td>
					<td><?= $v->comentarios; ?></td>
					<td><?= anchor('subject/ecg_adicional_show/'. $subject->id .'/'.$v->id,'Ver', array('class'=>'btn btn-default')); ?></td>
				</tr>

			<?php	}
			?>


		</tbody>
	</table>
	


<?php
	}else{
		echo "<div style='text-align:center;font-weight:bold;'>El sujeto no tiene agregado formulario de signos vitales adicional.</div>";
	}
?>