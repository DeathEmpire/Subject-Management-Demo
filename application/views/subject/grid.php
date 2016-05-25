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
		<tr style='background-color: #C0C0C0;'><th colspan='4' style='text-align:center;'>Link Icon Legend</th></tr>
	</thead>
	<tbody>
		<tr>
			<td><?= img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));?> = Nuevo Registro</td>
			<td><?= img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));?> = El Registro Tiene Errores</td>
			<td><?= img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));?> = Formulario Aprovado y Cerrado</td>
			<td><?= img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));?> = Formulario Aprovado por el Monitor</td>
		</tr>
		<tr>
			<td><?= img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));?> = Registro Completo</td>
			<td><?= img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));?> = Documento Aprovado y Firmado por el PI</td>
			<td colspan='2'><?= img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));?> = Mensaje Abierto del Monitor</td>
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
			<th>Selección (Día 28 a Basal)</th>
			<th>Basal Día 1</th>
			<th>Semana 4</th>
			<th>Semana 12</th>
			<th>Semana 24/ Término del Estudio/ (+/- 4 días)</th>		
			<th>Terminación Temprana</th>
		</tr>
	</thead>
	<tbody>		
		<tr>
			<td>Demografía</td>
			<?php
				if(empty($subject->demography_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
				}
				elseif ($subject->demography_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->demography_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->demography_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->demography_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->demography_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->demography_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
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
			<td>Criterios de Inclusion/Exclusion</td>
			<?php
				if(empty($subject->inclusion_exclusion_1_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
					$link = 'subject/inclusion/'.$subject->id ."/1";
				}
				elseif ($subject->inclusion_exclusion_1_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/1";
				}
				elseif ($subject->inclusion_exclusion_1_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/1";
				}
				elseif ($subject->inclusion_exclusion_1_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/1";
				}
				elseif ($subject->inclusion_exclusion_1_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/1";
				}
				elseif ($subject->inclusion_exclusion_1_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/1";
				}
				elseif ($subject->inclusion_exclusion_1_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
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
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
					$link = 'subject/inclusion/'.$subject->id ."/2";
				}
				elseif ($subject->inclusion_exclusion_2_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/2";
				}
				elseif ($subject->inclusion_exclusion_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/2";
				}
				elseif ($subject->inclusion_exclusion_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/2";
				}
				elseif ($subject->inclusion_exclusion_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/2";
				}
				elseif ($subject->inclusion_exclusion_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/inclusion_show/'.$subject->id ."/2";
				}
				elseif ($subject->inclusion_exclusion_2_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
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
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
					$link = 'subject/historial_medico/'.$subject->id ."/1";
				}
				elseif ($subject->historial_medico_1_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/1";
				}
				elseif ($subject->historial_medico_1_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/1";
				}
				elseif ($subject->historial_medico_1_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/1";
				}
				elseif ($subject->historial_medico_1_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/1";
				}
				elseif ($subject->historial_medico_1_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/1";
				}
				elseif ($subject->historial_medico_1_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
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
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
					$link = 'subject/historial_medico/'.$subject->id ."/2";
				}
				elseif ($subject->historial_medico_2_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/2";
				}
				elseif ($subject->historial_medico_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/2";
				}
				elseif ($subject->historial_medico_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/2";
				}
				elseif ($subject->historial_medico_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/2";
				}
				elseif ($subject->historial_medico_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/historial_medico_show/'.$subject->id ."/2";
				}
				elseif ($subject->historial_medico_2_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));
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
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
					$link = 'subject/mmse/'.$subject->id ."/1";
				}
				elseif ($subject->mmse_1_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/1";
				}
				elseif ($subject->mmse_1_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/1";
				}
				elseif ($subject->mmse_1_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/1";
				}
				elseif ($subject->mmse_1_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/1";
				}
				elseif ($subject->mmse_1_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/1";
				}
				elseif ($subject->mmse_1_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
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
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
					$link = 'subject/mmse/'.$subject->id ."/4";
				}
				elseif ($subject->mmse_4_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/4";
				}
				elseif ($subject->mmse_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/4";
				}
				elseif ($subject->mmse_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/4";
				}
				elseif ($subject->mmse_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/4";
				}
				elseif ($subject->mmse_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/4";
				}
				elseif ($subject->mmse_4_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
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
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
					$link = 'subject/mmse/'.$subject->id ."/5";
				}
				elseif ($subject->mmse_5_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/5";
				}
				elseif ($subject->mmse_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/5";
				}
				elseif ($subject->mmse_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/5";
				}
				elseif ($subject->mmse_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/5";
				}
				elseif ($subject->mmse_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/5";
				}
				elseif ($subject->mmse_5_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/5";
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>
			<?php
				if(empty($subject->mmse_6_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
					$link = 'subject/mmse/'.$subject->id ."/6";
				}
				elseif ($subject->mmse_6_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/6";
				}
				elseif ($subject->mmse_6_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/6";
				}
				elseif ($subject->mmse_6_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/6";
				}
				elseif ($subject->mmse_6_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/6";
				}
				elseif ($subject->mmse_6_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/6";
				}
				elseif ($subject->mmse_6_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/mmse_show/'.$subject->id ."/6";
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>
		</tr>
		
		<?php
				if(empty($subject->hachinski_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
					$link = 'subject/hachinski_form/'.$subject->id;
				}
				elseif ($subject->hachinski_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/hachinski_show/'.$subject->id;
				}
				elseif ($subject->hachinski_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/hachinski_show/'.$subject->id;
				}
				elseif ($subject->hachinski_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/hachinski_show/'.$subject->id;
				}
				elseif ($subject->hachinski_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/hachinski_show/'.$subject->id;
				}
				elseif ($subject->hachinski_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/hachinski_show/'.$subject->id;
				}
				elseif ($subject->hachinski_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/hachinski_show/'.$subject->id;
				}
				else{
					$icon = '*';		
					$link = "";
				}
				
			?>
		<tr>
			<td>Escala de Hachinski modificada</td>
			<td style='text-align:center;'><?= anchor($link, $icon); ?></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>Pruebas de Laboratorio</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>Electrocardiograma de reposo (ECG)</td>
			<?php
				if(empty($subject->ecg_status)){
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
					$link = 'subject/ecg/'.$subject->id;
				}
				elseif ($subject->ecg_status == 'Record Complete') {
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/ecg_show/'.$subject->id;
				}
				elseif ($subject->ecg_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/ecg_show/'.$subject->id;
				}
				elseif ($subject->ecg_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/ecg_show/'.$subject->id;
				}
				elseif ($subject->ecg_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/ecg_show/'.$subject->id;
				}
				elseif ($subject->ecg_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/ecg_show/'.$subject->id;
				}
				elseif ($subject->ecg_status == 'Error') {					
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
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
			<td>RNM o TC</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
		</tr>
		<tr>
			<td>Examen físico</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
		</tr>
		<tr>
			<td>Examen neurológico</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
		</tr>
		<tr>
			<td>Signos vitales/peso</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
		</tr>
		<tr>
			<td>Randomizacion</td> 

			<?php
				#print_r($subject);
				if(empty($subject->randomization_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
				}
				elseif ($subject->randomization_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->randomization_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->randomization_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->randomization_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->randomization_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
				}
				elseif ($subject->randomization_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
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
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
		</tr>
		<tr>
			<td>NPI</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
		</tr>
		<tr>
			<td>TMT A</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
		</tr>
		<tr>
			<td>TMT B</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
		</tr>
		<tr>
			<td>Prueba de dígito directo</td>
			<td style='text-align:center;'></td>
			<?php
				#print_r($subject);
				if(empty($subject->digito_2_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
					$link = 'subject/digito_directo/'.$subject->id .'/2';
				}
				elseif ($subject->digito_2_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/2';
				}
				elseif ($subject->digito_2_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/2';
				}
				elseif ($subject->digito_2_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/2';
				}
				elseif ($subject->digito_2_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/2';
				}
				elseif ($subject->digito_2_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/2';
				}
				elseif ($subject->digito_2_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
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
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
					$link = 'subject/digito_directo/'.$subject->id .'/4';
				}
				elseif ($subject->digito_4_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/4';
				}
				elseif ($subject->digito_4_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/4';
				}
				elseif ($subject->digito_4_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/4';
				}
				elseif ($subject->digito_4_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/4';
				}
				elseif ($subject->digito_4_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/4';
				}
				elseif ($subject->digito_4_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
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
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
					$link = 'subject/digito_directo/'.$subject->id .'/5';
				}
				elseif ($subject->digito_5_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/5';
				}
				elseif ($subject->digito_5_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/5';
				}
				elseif ($subject->digito_5_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/5';
				}
				elseif ($subject->digito_5_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/5';
				}
				elseif ($subject->digito_5_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/5';
				}
				elseif ($subject->digito_5_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/5';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
			<?php
				#print_r($subject);
				if(empty($subject->digito_6_status)){					
					$icon = img(array('src'=>base_url('img/document_blank.png'),'width'=>'25','height'=>'25'));
					$link = 'subject/digito_directo/'.$subject->id .'/6';
				}
				elseif ($subject->digito_6_status == 'Record Complete') {					
					$icon = img(array('src'=>base_url('img/document_write.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/6';
				}
				elseif ($subject->digito_6_status == 'Document Approved and Signed by PI') {
					$icon = img(array('src'=>base_url('img/document_check.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/6';
				}
				elseif ($subject->digito_6_status == 'Form Approved and Locked') {
					$icon = img(array('src'=>base_url('img/document_lock.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/6';
				}
				elseif ($subject->digito_6_status == 'Form Approved by Monitor') {
					$icon = img(array('src'=>base_url('img/document_approved_monitor.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/6';
				}
				elseif ($subject->digito_6_status == 'Query') {
					$icon = img(array('src'=>base_url('img/document_question.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/6';
				}
				elseif ($subject->digito_6_status == 'Error') {
					$icon = img(array('src'=>base_url('img/document_error.png'),'width'=>'25','height'=>'25'));	
					$link = 'subject/digito_directo_show/'.$subject->id .'/6';
				}
				else{
					$icon = '*';		
					$link = '';
				}
				
			?>
			<td style='text-align:center;'><?= anchor($link, $icon);?></td>
		</tr>
		<tr>
			<td>Prueba de restas seriadas</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
		</tr>
		<tr>
			<td>Escala de evaluación de apatía</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
		</tr>
		<tr>
			<td>EQ-5D-3L</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
		</tr>
		<tr>
			<td>Cumplimiento</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
		</tr>
		<tr>
			<td>Muestras de sangre para estudio de biomarcadores</td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
		</tr>
		<tr>
			<td>Fin de Tratamieto</td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'></td>
			<td style='text-align:center;'>X</td>
			<td style='text-align:center;'>X</td>
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
			<td>Adverse Event/Serious Adverse Event</td>
			<?php
				if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'adverse_event_form')){
			?>
				<td><?= anchor('subject/adverse_event_form/'.$subject->id,'Add'); ?></td>
			<?php }?>	
			<td><?= anchor('subject/adverse_event_show/'.$subject->id,'Show'); ?></td>
		</tr>
		<tr>	
			<td>Protocol Deviation</td>
			<?php
				if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'protocol_deviation_form')){
			?>
				<td><?= anchor('subject/protocol_deviation_form/'.$subject->id,'Add'); ?></td>
			<?php }?>

			<td><?= anchor('subject/protocol_deviation_show/'.$subject->id,'Show'); ?></td>
		</tr>
		<tr>	
			<td>Concomitant Medication</td>
			<?php
				if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'concomitant_medication_form')){
			?>
				<td><?= anchor('subject/concomitant_medication_form/'.$subject->id,'Add'); ?></td>
			<?php }?>
			<td><?= anchor('subject/concomitant_medication_show/'.$subject->id,'Show'); ?></td>
		</tr>		
	</tbody>
</table>