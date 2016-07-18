<legend style='text-align:center;'> Registro del Sujeto </legend>
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
			<td><?= $subject->code; ?></td>
			<td><?= $subject->initials; ?></td>		
			<td><?= ((isset($subject->screening_date) AND $subject->screening_date != '0000-00-00') ? date("d-M-Y",strtotime($subject->screening_date)) : ""); ?></td>
			<td><?= ((isset($subject->randomization_date) AND $subject->randomization_date != '0000-00-00') ? date("d-M-Y",strtotime($subject->randomization_date)) : ""); ?></td>
			<td><?= $subject->kit1; ?></td>			
		</tr>
	</tbody>
</table>
<br />
<b>Legend:</b>
<table class="table table-condensed table-bordered">
	<thead>
		<tr style='background-color: #C0C0C0;'><th colspan='4' style='text-align:center;'>Significado de Iconos</th></tr>
	</thead>
	<tbody>
		<tr>
			
			<td><img src='<?php echo base_url('img/document_blank.png'); ?>' style='width:25px;height:25px;'> = Nuevo Registro</td>
			<td><?= img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));?> = El Registro Tiene Errores</td>
			<td><?= img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));?> = Formulario Aprobado y Cerrado</td>
			<td><?= img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));?> = Formulario Aprobado por el Monitor</td>
		</tr>
		<tr>
			<td><?= img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));?> = Registro Completo</td>
			<td><?= img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));?> = Documento Aprobado y Firmado por el PI</td>
			<td colspan='2'><?= img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));?> = Mensaje Abierto del Monitor</td>
		</tr>
	</tbody>
</table>


<b>Visitas Programadas:</b>
<table class="table table-condensed table-bordered table-striped table-hover">
	<thead>
		<tr style='background-color: #C0C0C0;'>
			<th rowspan='2' style='text-align:center;vertical-align:middle;'>Actividad del Protocolo</th>
			<th colspan='6' style='text-align:center;'>Intervalo de Visitas</th>
		</tr>
		<tr style='background-color: #C0C0C0;'>
			<th class='span2'>Selección (Día 28 a Basal)</th>
			<th class='span2'>Basal Día 1</th>
			<th class='span2'>Semana 4</th>
			<th class='span2'>Semana 12</th>
			<th class='span2'>Semana 24/ Término del Estudio/ (+/- 4 días)</th>		
			<th class='span2'>Terminación Temprana</th>
		</tr>
	</thead>
	<tbody>		
		<tr>
			<td>Demografía - Consentimiento Informado</td>
			<?php
				if(empty($subject->demography_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
				}
				elseif ($subject->demography_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
				}
				elseif ($subject->demography_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
				}
				elseif ($subject->demography_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
				}
				elseif ($subject->demography_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
				}
				elseif ($subject->demography_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
				}
				elseif ($subject->demography_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
				}
				else{
					$icon = '*';		
				}
				
			?>
			<td style='text-align:center;'><?= anchor('subject/demography/'.$subject->id, $icon); ?></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>Criterios de Inclusión/Exclusión</td>
			<?php
				if(empty($subject->inclusion_exclusion_1_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/inclusion/'.$subject->id ."/1";
				}
				elseif ($subject->inclusion_exclusion_1_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/1";
				}
				elseif ($subject->inclusion_exclusion_1_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/1";
				}
				elseif ($subject->inclusion_exclusion_1_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/1";
				}
				elseif ($subject->inclusion_exclusion_1_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/1";
				}
				elseif ($subject->inclusion_exclusion_1_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/1";
				}
				elseif ($subject->inclusion_exclusion_1_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/1";
				}
				else{
					$icon = '*';	
					$link = '';	
				}
				
			?>			
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>
			<?php
				if(empty($subject->inclusion_exclusion_2_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/inclusion/'.$subject->id ."/2";
				}
				elseif ($subject->inclusion_exclusion_2_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/2";
				}
				elseif ($subject->inclusion_exclusion_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/2";
				}
				elseif ($subject->inclusion_exclusion_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/2";
				}
				elseif ($subject->inclusion_exclusion_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/2";
				}
				elseif ($subject->inclusion_exclusion_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/2";
				}
				elseif ($subject->inclusion_exclusion_2_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/2";
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>			
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>Historia Médica</td>
			<?php
				if(empty($subject->historial_medico_1_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/historial_medico/'.$subject->id ."/1";
				}
				elseif ($subject->historial_medico_1_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/1";
				}
				elseif ($subject->historial_medico_1_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/1";
				}
				elseif ($subject->historial_medico_1_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/1";
				}
				elseif ($subject->historial_medico_1_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/1";
				}
				elseif ($subject->historial_medico_1_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/1";
				}
				elseif ($subject->historial_medico_1_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/1";
				}
				else{
					$icon = '*';
					$link = '';		
				}
				
			?>			
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>
			<?php
				if(empty($subject->historial_medico_2_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/historial_medico/'.$subject->id ."/2";
				}
				elseif ($subject->historial_medico_2_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/2";
				}
				elseif ($subject->historial_medico_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/2";
				}
				elseif ($subject->historial_medico_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/2";
				}
				elseif ($subject->historial_medico_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/2";
				}
				elseif ($subject->historial_medico_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/2";
				}
				elseif ($subject->historial_medico_2_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/historial_medico_show/'.$subject->id ."/2";
				}
				else{
					$icon = '*';
					$link = '';		
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>MMSE</td>
			<?php
				if(empty($subject->mmse_1_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/mmse/'.$subject->id ."/1";
				}
				elseif ($subject->mmse_1_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/1";
				}
				elseif ($subject->mmse_1_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/1";
				}
				elseif ($subject->mmse_1_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/1";
				}
				elseif ($subject->mmse_1_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/1";
				}
				elseif ($subject->mmse_1_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/1";
				}
				elseif ($subject->mmse_1_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/1";
				}
				else{
					$icon = '*';
					$link = '';		
				}
				
			?>			
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>			
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<?php
				if(empty($subject->mmse_4_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/mmse/'.$subject->id ."/4";
				}
				elseif ($subject->mmse_4_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/4";
				}
				elseif ($subject->mmse_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/4";
				}
				elseif ($subject->mmse_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/4";
				}
				elseif ($subject->mmse_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/4";
				}
				elseif ($subject->mmse_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/4";
				}
				elseif ($subject->mmse_4_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/4";
				}
				else{
					$icon = '*';
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>
			<?php
				if(empty($subject->mmse_5_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/mmse/'.$subject->id ."/5";
				}
				elseif ($subject->mmse_5_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/5";
				}
				elseif ($subject->mmse_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/5";
				}
				elseif ($subject->mmse_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/5";
				}
				elseif ($subject->mmse_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/5";
				}
				elseif ($subject->mmse_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/5";
				}
				elseif ($subject->mmse_5_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/mmse_show/'.$subject->id ."/5";
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>			
			<td style='text-align:center;'></td>
		</tr>
		
		<?php
				if(empty($subject->hachinski_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/hachinski_form/'.$subject->id;
				}
				elseif ($subject->hachinski_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/hachinski_show/'.$subject->id;
				}
				elseif ($subject->hachinski_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/hachinski_show/'.$subject->id;
				}
				elseif ($subject->hachinski_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/hachinski_show/'.$subject->id;
				}
				elseif ($subject->hachinski_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/hachinski_show/'.$subject->id;
				}
				elseif ($subject->hachinski_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/hachinski_show/'.$subject->id;
				}
				elseif ($subject->hachinski_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/hachinski_show/'.$subject->id;
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
		<tr>
			<td>Escala de Hachinski</td>
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>Examenes de Laboratorio</td>
			<?php
				if(empty($subject->examen_laboratorio_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_laboratorio/'.$subject->id .'/1';
				}
				elseif ($subject->examen_laboratorio_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_laboratorio_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_laboratorio_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_laboratorio_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_laboratorio_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_laboratorio_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/1';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<?php
				if(empty($subject->examen_laboratorio_5_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_laboratorio/'.$subject->id .'/5';
				}
				elseif ($subject->examen_laboratorio_5_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_laboratorio_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_laboratorio_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_laboratorio_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_laboratorio_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_laboratorio_5_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>
			<?php
				if(empty($subject->examen_laboratorio_6_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_laboratorio/'.$subject->id .'/6';
				}
				elseif ($subject->examen_laboratorio_6_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_laboratorio_6_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_laboratorio_6_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_laboratorio_6_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_laboratorio_6_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_laboratorio_6_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_laboratorio_show/'.$subject->id .'/6';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>
		</tr>
		<tr>
			<td>Electrocardiograma de reposo (ECG)</td>
			<?php
				if(empty($subject->ecg_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/ecg/'.$subject->id;
				}
				elseif ($subject->ecg_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/ecg_show/'.$subject->id;
				}
				elseif ($subject->ecg_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/ecg_show/'.$subject->id;
				}
				elseif ($subject->ecg_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/ecg_show/'.$subject->id;
				}
				elseif ($subject->ecg_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/ecg_show/'.$subject->id;
				}
				elseif ($subject->ecg_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/ecg_show/'.$subject->id;
				}
				elseif ($subject->ecg_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/ecg_show/'.$subject->id;
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>Resonancia Magnética o Tomografía Computarizada</td>
			<?php
				if(empty($subject->rnm_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/rnm/'.$subject->id .'/1';
				}
				elseif ($subject->rnm_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/rnm_show/'.$subject->id .'/1';
				}
				elseif ($subject->rnm_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/rnm_show/'.$subject->id .'/1';
				}
				elseif ($subject->rnm_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/rnm_show/'.$subject->id .'/1';
				}
				elseif ($subject->rnm_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/rnm_show/'.$subject->id .'/1';
				}
				elseif ($subject->rnm_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/rnm_show/'.$subject->id .'/1';
				}
				elseif ($subject->rnm_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/rnm_show/'.$subject->id .'/1';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				if(empty($subject->rnm_2_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/rnm/'.$subject->id .'/2';
				}
				elseif ($subject->rnm_2_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/rnm_show/'.$subject->id .'/2';
				}
				elseif ($subject->rnm_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/rnm_show/'.$subject->id .'/2';
				}
				elseif ($subject->rnm_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/rnm_show/'.$subject->id .'/2';
				}
				elseif ($subject->rnm_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/rnm_show/'.$subject->id .'/2';
				}
				elseif ($subject->rnm_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/rnm_show/'.$subject->id .'/2';
				}
				elseif ($subject->rnm_2_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/rnm_show/'.$subject->id .'/2';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>Examen físico</td>
			<?php
				if(empty($subject->examen_fisico_1_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_fisico/'.$subject->id .'/1';
				}
				elseif ($subject->examen_fisico_1_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_fisico_1_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_fisico_1_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_fisico_1_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_fisico_1_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_fisico_1_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/1';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				if(empty($subject->examen_fisico_2_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_fisico/'.$subject->id .'/2';
				}
				elseif ($subject->examen_fisico_2_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/2';
				}
				elseif ($subject->examen_fisico_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/2';
				}
				elseif ($subject->examen_fisico_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/2';
				}
				elseif ($subject->examen_fisico_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/2';
				}
				elseif ($subject->examen_fisico_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/2';
				}
				elseif ($subject->examen_fisico_2_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/2';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				if(empty($subject->examen_fisico_3_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_fisico/'.$subject->id .'/3';
				}
				elseif ($subject->examen_fisico_3_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/3';
				}
				elseif ($subject->examen_fisico_3_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/3';
				}
				elseif ($subject->examen_fisico_3_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/3';
				}
				elseif ($subject->examen_fisico_3_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/3';
				}
				elseif ($subject->examen_fisico_3_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/3';
				}
				elseif ($subject->examen_fisico_3_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/3';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				if(empty($subject->examen_fisico_4_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_fisico/'.$subject->id .'/4';
				}
				elseif ($subject->examen_fisico_4_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/4';
				}
				elseif ($subject->examen_fisico_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/4';
				}
				elseif ($subject->examen_fisico_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/4';
				}
				elseif ($subject->examen_fisico_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/4';
				}
				elseif ($subject->examen_fisico_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/4';
				}
				elseif ($subject->examen_fisico_4_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/4';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				if(empty($subject->examen_fisico_5_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_fisico/'.$subject->id .'/5';
				}
				elseif ($subject->examen_fisico_5_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_fisico_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_fisico_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_fisico_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_fisico_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_fisico_5_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				if(empty($subject->examen_fisico_6_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_fisico/'.$subject->id .'/6';
				}
				elseif ($subject->examen_fisico_6_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_fisico_6_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_fisico_6_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_fisico_6_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_fisico_6_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_fisico_6_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_fisico_show/'.$subject->id .'/6';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
		</tr>
		<tr>
			<td>Examen neurológico</td>
			<?php
				if(empty($subject->examen_neurologico_1_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_neurologico/'.$subject->id .'/1';
				}
				elseif ($subject->examen_neurologico_1_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_neurologico_1_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_neurologico_1_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_neurologico_1_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_neurologico_1_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/1';
				}
				elseif ($subject->examen_neurologico_1_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/1';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				if(empty($subject->examen_neurologico_2_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_neurologico/'.$subject->id .'/2';
				}
				elseif ($subject->examen_neurologico_2_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/2';
				}
				elseif ($subject->examen_neurologico_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/2';
				}
				elseif ($subject->examen_neurologico_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/2';
				}
				elseif ($subject->examen_neurologico_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/2';
				}
				elseif ($subject->examen_neurologico_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/2';
				}
				elseif ($subject->examen_neurologico_2_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/2';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				if(empty($subject->examen_neurologico_3_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_neurologico/'.$subject->id .'/3';
				}
				elseif ($subject->examen_neurologico_3_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/3';
				}
				elseif ($subject->examen_neurologico_3_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/3';
				}
				elseif ($subject->examen_neurologico_3_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/3';
				}
				elseif ($subject->examen_neurologico_3_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/3';
				}
				elseif ($subject->examen_neurologico_3_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/3';
				}
				elseif ($subject->examen_neurologico_3_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/3';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				if(empty($subject->examen_neurologico_4_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_neurologico/'.$subject->id .'/4';
				}
				elseif ($subject->examen_neurologico_4_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/4';
				}
				elseif ($subject->examen_neurologico_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/4';
				}
				elseif ($subject->examen_neurologico_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/4';
				}
				elseif ($subject->examen_neurologico_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/4';
				}
				elseif ($subject->examen_neurologico_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/4';
				}
				elseif ($subject->examen_neurologico_4_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/4';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				if(empty($subject->examen_neurologico_5_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_neurologico/'.$subject->id .'/5';
				}
				elseif ($subject->examen_neurologico_5_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_neurologico_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_neurologico_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_neurologico_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_neurologico_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/5';
				}
				elseif ($subject->examen_neurologico_5_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				if(empty($subject->examen_neurologico_6_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/examen_neurologico/'.$subject->id .'/6';
				}
				elseif ($subject->examen_neurologico_6_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_neurologico_6_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_neurologico_6_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_neurologico_6_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_neurologico_6_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/6';
				}
				elseif ($subject->examen_neurologico_6_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/examen_neurologico_show/'.$subject->id .'/6';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
		</tr>
		<tr>
			<td>Signos vitales/peso</td>
			<?php
				if(empty($subject->signos_vitales_1_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/signos_vitales/'.$subject->id .'/1';
				}
				elseif ($subject->signos_vitales_1_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/1';
				}
				elseif ($subject->signos_vitales_1_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/1';
				}
				elseif ($subject->signos_vitales_1_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/1';
				}
				elseif ($subject->signos_vitales_1_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/1';
				}
				elseif ($subject->signos_vitales_1_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/1';
				}
				elseif ($subject->signos_vitales_1_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/1';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				if(empty($subject->signos_vitales_2_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/signos_vitales/'.$subject->id .'/2';
				}
				elseif ($subject->signos_vitales_2_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/2';
				}
				elseif ($subject->signos_vitales_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/2';
				}
				elseif ($subject->signos_vitales_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/2';
				}
				elseif ($subject->signos_vitales_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/2';
				}
				elseif ($subject->signos_vitales_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/2';
				}
				elseif ($subject->signos_vitales_2_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/2';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<td style='text-align:center;'></td>
			<?php
				if(empty($subject->signos_vitales_4_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/signos_vitales/'.$subject->id .'/4';
				}
				elseif ($subject->signos_vitales_4_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/4';
				}
				elseif ($subject->signos_vitales_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/4';
				}
				elseif ($subject->signos_vitales_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/4';
				}
				elseif ($subject->signos_vitales_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/4';
				}
				elseif ($subject->signos_vitales_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/4';
				}
				elseif ($subject->signos_vitales_4_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/4';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				if(empty($subject->signos_vitales_5_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/signos_vitales/'.$subject->id .'/5';
				}
				elseif ($subject->signos_vitales_5_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/5';
				}
				elseif ($subject->signos_vitales_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/5';
				}
				elseif ($subject->signos_vitales_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/5';
				}
				elseif ($subject->signos_vitales_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/5';
				}
				elseif ($subject->signos_vitales_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/5';
				}
				elseif ($subject->signos_vitales_5_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				if(empty($subject->signos_vitales_6_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/signos_vitales/'.$subject->id .'/6';
				}
				elseif ($subject->signos_vitales_6_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/6';
				}
				elseif ($subject->signos_vitales_6_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/6';
				}
				elseif ($subject->signos_vitales_6_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/6';
				}
				elseif ($subject->signos_vitales_6_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/6';
				}
				elseif ($subject->signos_vitales_6_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/6';
				}
				elseif ($subject->signos_vitales_6_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/signos_vitales_show/'.$subject->id .'/6';
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
		</tr>
		<tr>
			<td>Randomizacion</td> 

			<?php
				#print_r($subject);
				if(empty($subject->randomization_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
				}
				elseif ($subject->randomization_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
				}
				elseif ($subject->randomization_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
				}
				elseif ($subject->randomization_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
				}
				elseif ($subject->randomization_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
				}
				elseif ($subject->randomization_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
				}
				elseif ($subject->randomization_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
				}
				else{
					$icon = '*';		
				}
				
			?>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'><?= anchor('subject/randomization/'.$subject->id, $icon);?></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>ADAS-cog</td>
			<td style='text-align:center;'></td>
			<?php
				#print_r($subject);
				if(empty($subject->adas_2_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/adas/'.$subject->id .'/2';
				}
				elseif ($subject->adas_2_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/2';
				}
				elseif ($subject->adas_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/2';
				}
				elseif ($subject->adas_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/2';
				}
				elseif ($subject->adas_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/2';
				}
				elseif ($subject->adas_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/2';
				}
				elseif ($subject->adas_2_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/2';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<td style='text-align:center;'></td>
			<?php
				#print_r($subject);
				if(empty($subject->adas_4_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/adas/'.$subject->id .'/4';
				}
				elseif ($subject->adas_4_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/4';
				}
				elseif ($subject->adas_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/4';
				}
				elseif ($subject->adas_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/4';
				}
				elseif ($subject->adas_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/4';
				}
				elseif ($subject->adas_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/4';
				}
				elseif ($subject->adas_4_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/4';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				#print_r($subject);
				if(empty($subject->adas_5_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/adas/'.$subject->id .'/5';
				}
				elseif ($subject->adas_5_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/5';
				}
				elseif ($subject->adas_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/5';
				}
				elseif ($subject->adas_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/5';
				}
				elseif ($subject->adas_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/5';
				}
				elseif ($subject->adas_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/5';
				}
				elseif ($subject->adas_5_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				#print_r($subject);
				if(empty($subject->adas_6_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/adas/'.$subject->id .'/6';
				}
				elseif ($subject->adas_6_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/6';
				}
				elseif ($subject->adas_6_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/6';
				}
				elseif ($subject->adas_6_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/6';
				}
				elseif ($subject->adas_6_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/6';
				}
				elseif ($subject->adas_6_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/6';
				}
				elseif ($subject->adas_6_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/adas_show/'.$subject->id .'/6';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
		</tr>
		<tr>
			<td>NPI</td>
			<td style='text-align:center;'></td>
			<?php
				#print_r($subject);
				if(empty($subject->npi_2_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/npi/'.$subject->id .'/2';
				}
				elseif ($subject->npi_2_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/2';
				}
				elseif ($subject->npi_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/2';
				}
				elseif ($subject->npi_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/2';
				}
				elseif ($subject->npi_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/2';
				}
				elseif ($subject->npi_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/2';
				}
				elseif ($subject->npi_2_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/2';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<td style='text-align:center;'></td>
			<?php
				#print_r($subject);
				if(empty($subject->npi_4_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/npi/'.$subject->id .'/4';
				}
				elseif ($subject->npi_4_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/4';
				}
				elseif ($subject->npi_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/4';
				}
				elseif ($subject->npi_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/4';
				}
				elseif ($subject->npi_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/4';
				}
				elseif ($subject->npi_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/4';
				}
				elseif ($subject->npi_4_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/4';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				#print_r($subject);
				if(empty($subject->npi_5_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/npi/'.$subject->id .'/5';
				}
				elseif ($subject->npi_5_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/5';
				}
				elseif ($subject->npi_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/5';
				}
				elseif ($subject->npi_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/5';
				}
				elseif ($subject->npi_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/5';
				}
				elseif ($subject->npi_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/5';
				}
				elseif ($subject->npi_5_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/npi_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>			
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>TMT A</td>
			<td style='text-align:center;'></td>
			<?php
				#print_r($subject);
				if(empty($subject->tmt_a_2_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/tmt_a/'.$subject->id .'/2';
				}
				elseif ($subject->tmt_a_2_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/2';
				}
				elseif ($subject->tmt_a_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/2';
				}
				elseif ($subject->tmt_a_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/2';
				}
				elseif ($subject->tmt_a_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/2';
				}
				elseif ($subject->tmt_a_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/2';
				}
				elseif ($subject->tmt_a_2_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/2';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<td style='text-align:center;'></td>
			<?php
				#print_r($subject);
				if(empty($subject->tmt_a_4_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/tmt_a/'.$subject->id .'/4';
				}
				elseif ($subject->tmt_a_4_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/4';
				}
				elseif ($subject->tmt_a_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/4';
				}
				elseif ($subject->tmt_a_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/4';
				}
				elseif ($subject->tmt_a_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/4';
				}
				elseif ($subject->tmt_a_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/4';
				}
				elseif ($subject->tmt_a_4_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/4';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				#print_r($subject);
				if(empty($subject->tmt_a_5_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/tmt_a/'.$subject->id .'/5';
				}
				elseif ($subject->tmt_a_5_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/5';
				}
				elseif ($subject->tmt_a_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/5';
				}
				elseif ($subject->tmt_a_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/5';
				}
				elseif ($subject->tmt_a_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/5';
				}
				elseif ($subject->tmt_a_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/5';
				}
				elseif ($subject->tmt_a_5_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_a_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>			
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>TMT B</td>
			<td style='text-align:center;'></td>
			<?php
				#print_r($subject);
				if(empty($subject->tmt_b_2_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/tmt_b/'.$subject->id .'/2';
				}
				elseif ($subject->tmt_b_2_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/2';
				}
				elseif ($subject->tmt_b_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/2';
				}
				elseif ($subject->tmt_b_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/2';
				}
				elseif ($subject->tmt_b_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/2';
				}
				elseif ($subject->tmt_b_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/2';
				}
				elseif ($subject->tmt_b_2_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/2';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<td style='text-align:center;'></td>
			<?php
				#print_r($subject);
				if(empty($subject->tmt_b_4_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/tmt_b/'.$subject->id .'/4';
				}
				elseif ($subject->tmt_b_4_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/4';
				}
				elseif ($subject->tmt_b_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/4';
				}
				elseif ($subject->tmt_b_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/4';
				}
				elseif ($subject->tmt_b_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/4';
				}
				elseif ($subject->tmt_b_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/4';
				}
				elseif ($subject->tmt_b_4_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/4';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				#print_r($subject);
				if(empty($subject->tmt_b_5_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/tmt_b/'.$subject->id .'/5';
				}
				elseif ($subject->tmt_b_5_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/5';
				}
				elseif ($subject->tmt_b_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/5';
				}
				elseif ($subject->tmt_b_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/5';
				}
				elseif ($subject->tmt_b_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/5';
				}
				elseif ($subject->tmt_b_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/5';
				}
				elseif ($subject->tmt_b_5_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/tmt_b_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>			
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>Prueba de dígito directo</td>
			<td style='text-align:center;'></td>
			<?php
				#print_r($subject);
				if(empty($subject->digito_2_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/digito_directo/'.$subject->id .'/2';
				}
				elseif ($subject->digito_2_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/2';
				}
				elseif ($subject->digito_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/2';
				}
				elseif ($subject->digito_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/2';
				}
				elseif ($subject->digito_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/2';
				}
				elseif ($subject->digito_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/2';
				}
				elseif ($subject->digito_2_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/2';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<td style='text-align:center;'></td>
			<?php
				#print_r($subject);
				if(empty($subject->digito_4_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/digito_directo/'.$subject->id .'/4';
				}
				elseif ($subject->digito_4_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/4';
				}
				elseif ($subject->digito_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/4';
				}
				elseif ($subject->digito_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/4';
				}
				elseif ($subject->digito_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/4';
				}
				elseif ($subject->digito_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/4';
				}
				elseif ($subject->digito_4_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/4';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				#print_r($subject);
				if(empty($subject->digito_5_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/digito_directo/'.$subject->id .'/5';
				}
				elseif ($subject->digito_5_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/5';
				}
				elseif ($subject->digito_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/5';
				}
				elseif ($subject->digito_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/5';
				}
				elseif ($subject->digito_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/5';
				}
				elseif ($subject->digito_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/5';
				}
				elseif ($subject->digito_5_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>			
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>Prueba de restas seriadas</td>
			<td style='text-align:center;'></td>
			<?php				
				if(empty($subject->restas_2_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/restas/'.$subject->id .'/2';
				}
				elseif ($subject->restas_2_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/2';
				}
				elseif ($subject->restas_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/2';
				}
				elseif ($subject->restas_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/2';
				}
				elseif ($subject->restas_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/2';
				}
				elseif ($subject->restas_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/2';
				}
				elseif ($subject->restas_2_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/2';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<td style='text-align:center;'></td>
			<?php				
				if(empty($subject->restas_4_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/restas/'.$subject->id .'/4';
				}
				elseif ($subject->restas_4_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/4';
				}
				elseif ($subject->restas_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/4';
				}
				elseif ($subject->restas_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/4';
				}
				elseif ($subject->restas_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/4';
				}
				elseif ($subject->restas_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/4';
				}
				elseif ($subject->restas_4_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/4';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php				
				if(empty($subject->restas_5_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/restas/'.$subject->id .'/5';
				}
				elseif ($subject->restas_5_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/5';
				}
				elseif ($subject->restas_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/5';
				}
				elseif ($subject->restas_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/5';
				}
				elseif ($subject->restas_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/5';
				}
				elseif ($subject->restas_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/5';
				}
				elseif ($subject->restas_5_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/restas_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>			
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>Escala de evaluación de apatía</td>
			<td style='text-align:center;'></td>
			<?php				
				if(empty($subject->apatia_2_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/apatia/'.$subject->id .'/2';
				}
				elseif ($subject->apatia_2_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/2';
				}
				elseif ($subject->apatia_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/2';
				}
				elseif ($subject->apatia_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/2';
				}
				elseif ($subject->apatia_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/2';
				}
				elseif ($subject->apatia_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/2';
				}
				elseif ($subject->apatia_2_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/2';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php				
				if(empty($subject->apatia_3_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/apatia/'.$subject->id .'/3';
				}
				elseif ($subject->apatia_3_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/3';
				}
				elseif ($subject->apatia_3_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/3';
				}
				elseif ($subject->apatia_3_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/3';
				}
				elseif ($subject->apatia_3_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/3';
				}
				elseif ($subject->apatia_3_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/3';
				}
				elseif ($subject->apatia_3_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/3';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php				
				if(empty($subject->apatia_4_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/apatia/'.$subject->id .'/4';
				}
				elseif ($subject->apatia_4_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/4';
				}
				elseif ($subject->apatia_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/4';
				}
				elseif ($subject->apatia_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/4';
				}
				elseif ($subject->apatia_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/4';
				}
				elseif ($subject->apatia_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/4';
				}
				elseif ($subject->apatia_4_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/4';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php				
				if(empty($subject->apatia_5_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/apatia/'.$subject->id .'/5';
				}
				elseif ($subject->apatia_5_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/5';
				}
				elseif ($subject->apatia_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/5';
				}
				elseif ($subject->apatia_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/5';
				}
				elseif ($subject->apatia_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/5';
				}
				elseif ($subject->apatia_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/5';
				}
				elseif ($subject->apatia_5_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php				
				if(empty($subject->apatia_6_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/apatia/'.$subject->id .'/6';
				}
				elseif ($subject->apatia_6_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/6';
				}
				elseif ($subject->apatia_6_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/6';
				}
				elseif ($subject->apatia_6_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/6';
				}
				elseif ($subject->apatia_6_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/6';
				}
				elseif ($subject->apatia_6_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/6';
				}
				elseif ($subject->apatia_6_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/apatia_show/'.$subject->id .'/6';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
		</tr>
		<tr>
			<td>EQ-5D-5L</td>
			<td style='text-align:center;'></td>
			<?php				
				if(empty($subject->eq_5d_5l_2_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/eq_5d_5l/'.$subject->id .'/2';
				}
				elseif ($subject->eq_5d_5l_2_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/2';
				}
				elseif ($subject->eq_5d_5l_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/2';
				}
				elseif ($subject->eq_5d_5l_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/2';
				}
				elseif ($subject->eq_5d_5l_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/2';
				}
				elseif ($subject->eq_5d_5l_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/2';
				}
				elseif ($subject->eq_5d_5l_2_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/2';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php				
				if(empty($subject->eq_5d_5l_3_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/eq_5d_5l/'.$subject->id .'/3';
				}
				elseif ($subject->eq_5d_5l_3_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/3';
				}
				elseif ($subject->eq_5d_5l_3_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/3';
				}
				elseif ($subject->eq_5d_5l_3_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/3';
				}
				elseif ($subject->eq_5d_5l_3_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/3';
				}
				elseif ($subject->eq_5d_5l_3_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/3';
				}
				elseif ($subject->eq_5d_5l_3_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/3';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php				
				if(empty($subject->eq_5d_5l_4_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/eq_5d_5l/'.$subject->id .'/4';
				}
				elseif ($subject->eq_5d_5l_4_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/4';
				}
				elseif ($subject->eq_5d_5l_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/4';
				}
				elseif ($subject->eq_5d_5l_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/4';
				}
				elseif ($subject->eq_5d_5l_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/4';
				}
				elseif ($subject->eq_5d_5l_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/4';
				}
				elseif ($subject->eq_5d_5l_4_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/4';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php				
				if(empty($subject->eq_5d_5l_5_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/eq_5d_5l/'.$subject->id .'/5';
				}
				elseif ($subject->eq_5d_5l_5_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/5';
				}
				elseif ($subject->eq_5d_5l_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/5';
				}
				elseif ($subject->eq_5d_5l_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/5';
				}
				elseif ($subject->eq_5d_5l_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/5';
				}
				elseif ($subject->eq_5d_5l_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/5';
				}
				elseif ($subject->eq_5d_5l_5_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/eq_5d_5l_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>			
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>Cumplimiento</td>
			<td style='text-align:center;'></td>
			<?php				
				if(empty($subject->cumplimiento_2_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/cumplimiento/'.$subject->id .'/2';
				}
				elseif ($subject->cumplimiento_2_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/2';
				}
				elseif ($subject->cumplimiento_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/2';
				}
				elseif ($subject->cumplimiento_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/2';
				}
				elseif ($subject->cumplimiento_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/2';
				}
				elseif ($subject->cumplimiento_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/2';
				}
				elseif ($subject->cumplimiento_2_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/2';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php				
				if(empty($subject->cumplimiento_3_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/cumplimiento/'.$subject->id .'/3';
				}
				elseif ($subject->cumplimiento_3_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/3';
				}
				elseif ($subject->cumplimiento_3_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/3';
				}
				elseif ($subject->cumplimiento_3_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/3';
				}
				elseif ($subject->cumplimiento_3_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/3';
				}
				elseif ($subject->cumplimiento_3_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/3';
				}
				elseif ($subject->cumplimiento_3_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/3';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php				
				if(empty($subject->cumplimiento_4_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/cumplimiento/'.$subject->id .'/4';
				}
				elseif ($subject->cumplimiento_4_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/4';
				}
				elseif ($subject->cumplimiento_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/4';
				}
				elseif ($subject->cumplimiento_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/4';
				}
				elseif ($subject->cumplimiento_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/4';
				}
				elseif ($subject->cumplimiento_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/4';
				}
				elseif ($subject->cumplimiento_4_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/4';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php				
				if(empty($subject->cumplimiento_5_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/cumplimiento/'.$subject->id .'/5';
				}
				elseif ($subject->cumplimiento_5_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/5';
				}
				elseif ($subject->cumplimiento_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/5';
				}
				elseif ($subject->cumplimiento_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/5';
				}
				elseif ($subject->cumplimiento_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/5';
				}
				elseif ($subject->cumplimiento_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/5';
				}
				elseif ($subject->cumplimiento_5_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php				
				if(empty($subject->cumplimiento_6_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/cumplimiento/'.$subject->id .'/6';
				}
				elseif ($subject->cumplimiento_6_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/6';
				}
				elseif ($subject->cumplimiento_6_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/6';
				}
				elseif ($subject->cumplimiento_6_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/6';
				}
				elseif ($subject->cumplimiento_6_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/6';
				}
				elseif ($subject->cumplimiento_6_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/6';
				}
				elseif ($subject->cumplimiento_6_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/cumplimiento_show/'.$subject->id .'/6';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
		</tr>
		<tr>
			<td>Muestras de sangre para estudio de biomarcadores</td>
			<?php				
				if(empty($subject->muestra_de_sangre_1_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/muestra_de_sangre/'.$subject->id .'/1';
				}
				elseif ($subject->muestra_de_sangre_1_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/1';
				}
				elseif ($subject->muestra_de_sangre_1_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/1';
				}
				elseif ($subject->muestra_de_sangre_1_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/1';
				}
				elseif ($subject->muestra_de_sangre_1_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/1';
				}
				elseif ($subject->muestra_de_sangre_1_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/1';
				}
				elseif ($subject->muestra_de_sangre_1_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/1';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<?php				
				if(empty($subject->muestra_de_sangre_5_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/muestra_de_sangre/'.$subject->id .'/5';
				}
				elseif ($subject->muestra_de_sangre_5_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/5';
				}
				elseif ($subject->muestra_de_sangre_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/5';
				}
				elseif ($subject->muestra_de_sangre_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/5';
				}
				elseif ($subject->muestra_de_sangre_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/5';
				}
				elseif ($subject->muestra_de_sangre_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/5';
				}
				elseif ($subject->muestra_de_sangre_5_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php				
				if(empty($subject->muestra_de_sangre_6_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/muestra_de_sangre/'.$subject->id .'/6';
				}
				elseif ($subject->muestra_de_sangre_6_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/6';
				}
				elseif ($subject->muestra_de_sangre_6_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/6';
				}
				elseif ($subject->muestra_de_sangre_6_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/6';
				}
				elseif ($subject->muestra_de_sangre_6_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/6';
				}
				elseif ($subject->muestra_de_sangre_6_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/6';
				}
				elseif ($subject->muestra_de_sangre_6_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/muestra_de_sangre_show/'.$subject->id .'/6';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
		</tr>
		<tr>
			<td>Fin de Tratamiento</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<?php				
				if(empty($subject->fin_tratamiento_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/fin_tratamiento/'.$subject->id;
				}
				elseif ($subject->fin_tratamiento_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/fin_tratamiento_show/'.$subject->id;
				}
				elseif ($subject->fin_tratamiento_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/fin_tratamiento_show/'.$subject->id;
				}
				elseif ($subject->fin_tratamiento_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/fin_tratamiento_show/'.$subject->id;
				}
				elseif ($subject->fin_tratamiento_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/fin_tratamiento_show/'.$subject->id;
				}
				elseif ($subject->fin_tratamiento_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/fin_tratamiento_show/'.$subject->id;
				}
				elseif ($subject->fin_tratamiento_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/fin_tratamiento_show/'.$subject->id;
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php				
				if(empty($subject->fin_tratamiento_temprano_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'style'=>'width:25px;height:25px;'));
					$link = 'subject/fin_tratamiento_temprano/'.$subject->id;
				}
				elseif ($subject->fin_tratamiento_temprano_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/fin_tratamiento_temprano_show/'.$subject->id;
				}
				elseif ($subject->fin_tratamiento_temprano_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/fin_tratamiento_temprano_show/'.$subject->id;
				}
				elseif ($subject->fin_tratamiento_temprano_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/fin_tratamiento_temprano_show/'.$subject->id;
				}
				elseif ($subject->fin_tratamiento_temprano_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/fin_tratamiento_temprano_show/'.$subject->id;
				}
				elseif ($subject->fin_tratamiento_temprano_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/fin_tratamiento_temprano_show/'.$subject->id;
				}
				elseif ($subject->fin_tratamiento_temprano_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'style'=>'width:25px;height:25px;'));	
					$link = 'subject/fin_tratamiento_temprano_show/'.$subject->id;
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
		</tr>
	</tbody>
</table>

<!--<small>*Note: If any unscheduled visits ocurr during these study days, please record de information on the applicable case report form (CRFs) under the section "Unscheduled Events".</small>-->

<br />&nbsp;<br />
<b>Formularios Adicionales:</b>
<table class='table table-condensed table-bordered'>
	<thead>
		<tr style='background-color: #C0C0C0;'>
			<th>Formulario</th>
			<th colspan='2'>Links</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Eventos Adversos</td>
			<?php
				if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'adverse_event_form')){
			?>
				<td><?= anchor('subject/adverse_event_form/'.$subject->id,'Agregar'); ?></td>
			<?php }?>	
			<td><?= anchor('subject/adverse_event_show/'.$subject->id,'Ver'); ?></td>
		</tr>
		<tr>	
			<td>Protocol Deviation</td>
			<?php
				if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'protocol_deviation_form')){
			?>
				<td><?= anchor('subject/protocol_deviation_form/'.$subject->id,'Agregar'); ?></td>
			<?php }?>

			<td><?= anchor('subject/protocol_deviation_show/'.$subject->id,'Ver'); ?></td>
		</tr>
		<tr>	
			<td>Concomitant Medication</td>
			<?php
				if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'concomitant_medication_form')){
			?>
				<td><?= anchor('subject/concomitant_medication_form/'.$subject->id,'Agregar'); ?></td>
			<?php }?>
			<td><?= anchor('subject/concomitant_medication_show/'.$subject->id,'Ver'); ?></td>
		</tr>		
	</tbody>
</table>