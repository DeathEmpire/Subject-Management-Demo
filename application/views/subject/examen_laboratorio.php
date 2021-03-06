<script src="<?= base_url('js/examen_laboratorio.js') ?>"></script>
<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<?php
	switch($etapa){
		case 1 : $protocolo = "(Selección)"; break;
		case 2 : $protocolo = "(Basal Día 1)"; break;
		case 3 : $protocolo = "(Semana 4)"; break;
		case 4 : $protocolo = "(Semana 12)"; break;
		case 5 : $protocolo = "(Término del Estudio)"; break;
		case 6 : $protocolo = "(Terminación Temprana)"; break;
		default : $protocolo = ""; break;
	}
?>
<legend style='text-align:center;'>Examen Laboratorio <?= $protocolo;?></legend>
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
<!-- legend -->
<?= form_open('subject/examen_laboratorio_insert', array('class'=>'form-horizontal','id'=>'form_examen_laboratorio')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('etapa', $etapa); ?>

	<?php
       		$si = array(
			    'name'        => 'realizado',			    
			    'value'       => 1,		    			    
			    'checked'     => set_radio('realizado', 1)
			    );
	   		$no = array(
			    'name'        => 'realizado',			    
			    'value'       => 0,	
			    'checked'     => set_radio('realizado', 0)
			    );			

	   		$normal_anormal = array(''=>'',
	   								'1'=>'Normal',
	   								'0'=>'Anormal');

	   		$hecho = array(''=>'','1'=>'Si','0'=>'No');
       	?>	

		Realizado <?= form_radio($si); ?> Si <?= form_radio($no); ?> No<br />
		Fecha: <?= form_input(array('type'=>'text', 'name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?>		
		<div id='mensaje_desviacion' style='display:none;'>
			<div id='td_mensaje_desviacion' class='alert alert-danger'></div>
		</div>
		<br />&nbsp;<br />
		<table class='table table-bordered table-striped table-hover'>
			<thead>
				<tr>
					<th style='text-align:center;'>Hematológico</th>
					<th style='text-align:center;'>Realizado</th>
					<th style='text-align:center;'>Valor</th>
					<th style='text-align:center;'>Unidad</th>					
					<th style='width:200px;text-align:center;'>Normal</th>					
					<th style='width:200px;text-align:center;'>Anormal sin significancia clinica </th>
					<th style='width:200px;text-align:center;'>Anormal con significancia clinica</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Hematocrito</td>
					<td><?= form_dropdown('hecho_1', $hecho, set_value('hecho_1'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'hematocrito', 'id'=>'hematocrito', 'value'=>set_value('hematocrito')));?></td>
					<td>%</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'hematocrito_nom_anom','value'=>'Normal','checked'=>set_radio('hematocrito_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'hematocrito_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('hematocrito_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'hematocrito_nom_anom','value'=>'Anormal_con','checked'=>set_radio('hematocrito_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Hemoglobina</td>
					<td><?= form_dropdown('hecho_2', $hecho, set_value('hecho_2'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'hemoglobina', 'id'=>'hemoglobina', 'value'=>set_value('hemoglobina')));?></td>
					<td>g/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'hemoglobina_nom_anom','value'=>'Normal','checked'=>set_radio('hemoglobina_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'hemoglobina_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('hemoglobina_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'hemoglobina_nom_anom','value'=>'Anormal_con','checked'=>set_radio('hemoglobina_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Recuento eritrocitos (RBC)</td>
					<td><?= form_dropdown('hecho_3', $hecho, set_value('hecho_3'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'eritocritos', 'id'=>'eritocritos', 'value'=>set_value('eritocritos')));?></td>
					<td>M/µl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'eritocritos_nom_anom','value'=>'Normal','checked'=>set_radio('eritocritos_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'eritocritos_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('eritocritos_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'eritocritos_nom_anom','value'=>'Anormal_con','checked'=>set_radio('eritocritos_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Recuento leucocitos (WBC)</td>
					<td><?= form_dropdown('hecho_4', $hecho, set_value('hecho_4'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'leucocitos', 'id'=>'leucocitos', 'value'=>set_value('leucocitos')));?></td>
					<td>/µl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'leucocitos_nom_anom','value'=>'Normal','checked'=>set_radio('leucocitos_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'leucocitos_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('leucocitos_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'leucocitos_nom_anom','value'=>'Anormal_con','checked'=>set_radio('leucocitos_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Neutrófilos</td>
					<td><?= form_dropdown('hecho_5', $hecho, set_value('hecho_5'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'neutrofilos', 'id'=>'neutrofilos', 'value'=>set_value('neutrofilos')));?></td>
					<td>/µl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'neutrofilos_nom_anom','value'=>'Normal','checked'=>set_radio('neutrofilos_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'neutrofilos_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('neutrofilos_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'neutrofilos_nom_anom','value'=>'Anormal_con','checked'=>set_radio('neutrofilos_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Linfocitos</td>
					<td><?= form_dropdown('hecho_6', $hecho, set_value('hecho_6'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'linfocitos', 'id'=>'linfocitos', 'value'=>set_value('linfocitos')));?></td>
					<td>/µl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'linfocitos_nom_anom','value'=>'Normal','checked'=>set_radio('linfocitos_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'linfocitos_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('linfocitos_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'linfocitos_nom_anom','value'=>'Anormal_con','checked'=>set_radio('linfocitos_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Monocitos</td>
					<td><?= form_dropdown('hecho_7', $hecho, set_value('hecho_7'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'monocitos', 'id'=>'monocitos', 'value'=>set_value('monocitos')));?></td>
					<td>/µl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'monocitos_nom_anom','value'=>'Normal','checked'=>set_radio('monocitos_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'monocitos_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('monocitos_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'monocitos_nom_anom','value'=>'Anormal_con','checked'=>set_radio('monocitos_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Eosinófilos</td>
					<td><?= form_dropdown('hecho_8', $hecho, set_value('hecho_8'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'eosinofilos', 'id'=>'eosinofilos', 'value'=>set_value('eosinofilos')));?></td>
					<td>/µl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'eosinofilos_nom_anom','value'=>'Normal','checked'=>set_radio('eosinofilos_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'eosinofilos_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('eosinofilos_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'eosinofilos_nom_anom','value'=>'Anormal_con','checked'=>set_radio('eosinofilos_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Basófilos</td>
					<td><?= form_dropdown('hecho_9', $hecho, set_value('hecho_9'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'basofilos', 'id'=>'basofilos', 'value'=>set_value('basofilos')));?></td>
					<td>/µl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'basofilos_nom_anom','value'=>'Normal','checked'=>set_radio('basofilos_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'basofilos_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('basofilos_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'basofilos_nom_anom','value'=>'Anormal_con','checked'=>set_radio('basofilos_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Recuento plaquetas</td>
					<td><?= form_dropdown('hecho_10', $hecho, set_value('hecho_10'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'recuento_plaquetas', 'id'=>'recuento_plaquetas', 'value'=>set_value('recuento_plaquetas')));?></td>
					<td>x mm<sup>3</sup></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'recuento_plaquetas_nom_anom','value'=>'Normal','checked'=>set_radio('recuento_plaquetas_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'recuento_plaquetas_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('recuento_plaquetas_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'recuento_plaquetas_nom_anom','value'=>'Anormal_con','checked'=>set_radio('recuento_plaquetas_nom_anom', 'Anormal_con')));?></td>
				</tr>			
			</tbody>
		</table>
		<br />&nbsp;<br />
		<table class='table table-bordered table-striped table-hover'>
			<thead>
				<tr>
					<th style='text-align:center;'>Bioquímico</th>
					<th style='text-align:center;'>Realizado</th>
					<th style='text-align:center;'>Valor</th>
					<th style='text-align:center;'>Unidad</th>
					<th style='width:200px;text-align:center;'>Normal</th>					
					<th style='width:200px;text-align:center;'>Anormal sin significancia clinica </th>
					<th style='width:200px;text-align:center;'>Anormal con significancia clinica</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Glucosa (ayunas)</td>
					<td><?= form_dropdown('hecho_11', $hecho, set_value('hecho_11'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'glucosa_ayunas', 'id'=>'glucosa_ayunas', 'value'=>set_value('glucosa_ayunas')));?></td>
					<td>mg/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'glucosa_ayunas_nom_anom','value'=>'Normal','checked'=>set_radio('glucosa_ayunas_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'glucosa_ayunas_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('glucosa_ayunas_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'glucosa_ayunas_nom_anom','value'=>'Anormal_con','checked'=>set_radio('glucosa_ayunas_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>BUN</td>
					<td><?= form_dropdown('hecho_12', $hecho, set_value('hecho_12'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'bun', 'id'=>'bun', 'value'=>set_value('bun')));?></td>
					<td>mg/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'bun_nom_anom','value'=>'Normal','checked'=>set_radio('bun_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'bun_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('bun_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'bun_nom_anom','value'=>'Anormal_con','checked'=>set_radio('bun_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Creatinina</td>
					<td><?= form_dropdown('hecho_13', $hecho, set_value('hecho_13'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'creatinina', 'id'=>'creatinina', 'value'=>set_value('creatinina')));?></td>
					<td>mg/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'creatinina_nom_anom','value'=>'Normal','checked'=>set_radio('creatinina_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'creatinina_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('creatinina_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'creatinina_nom_anom','value'=>'Anormal_con','checked'=>set_radio('creatinina_nom_anom', 'Anormal_con')));?></td>				</tr>
				<tr>
					<td>Bilirrubina total</td>
					<td><?= form_dropdown('hecho_14', $hecho, set_value('hecho_14'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'bilirrubina_total', 'id'=>'bilirrubina_total', 'value'=>set_value('bilirrubina_total')));?></td>
					<td>mg/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'bilirrubina_total_nom_anom','value'=>'Normal','checked'=>set_radio('bilirrubina_total_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'bilirrubina_total_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('bilirrubina_total_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'bilirrubina_total_nom_anom','value'=>'Anormal_con','checked'=>set_radio('bilirrubina_total_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Proteínas totales</td>
					<td><?= form_dropdown('hecho_15', $hecho, set_value('hecho_15'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'proteinas_totales', 'id'=>'proteinas_totales', 'value'=>set_value('proteinas_totales')));?></td>
					<td>g/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'proteinas_totales_nom_anom','value'=>'Normal','checked'=>set_radio('proteinas_totales_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'proteinas_totales_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('proteinas_totales_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'proteinas_totales_nom_anom','value'=>'Anormal_con','checked'=>set_radio('proteinas_totales_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Fosfatasas alcalinas</td>
					<td><?= form_dropdown('hecho_16', $hecho, set_value('hecho_16'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'fosfatasas_alcalinas', 'id'=>'fosfatasas_alcalinas', 'value'=>set_value('fosfatasas_alcalinas')));?></td>
					<td>U/l</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'fosfatasas_alcalinas_nom_anom','value'=>'Normal','checked'=>set_radio('fosfatasas_alcalinas_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'fosfatasas_alcalinas_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('fosfatasas_alcalinas_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'fosfatasas_alcalinas_nom_anom','value'=>'Anormal_con','checked'=>set_radio('fosfatasas_alcalinas_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>AST</td>
					<td><?= form_dropdown('hecho_17', $hecho, set_value('hecho_17'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'ast', 'id'=>'ast', 'value'=>set_value('ast')));?></td>
					<td>U/l</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'ast_nom_anom','value'=>'Normal','checked'=>set_radio('ast_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'ast_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('ast_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'ast_nom_anom','value'=>'Anormal_con','checked'=>set_radio('ast_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>ALT</td>
					<td><?= form_dropdown('hecho_18', $hecho, set_value('hecho_18'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'alt', 'id'=>'alt', 'value'=>set_value('alt')));?></td>
					<td>U/l</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'alt_nom_anom','value'=>'Normal','checked'=>set_radio('alt_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'alt_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('alt_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'alt_nom_anom','value'=>'Anormal_con','checked'=>set_radio('alt_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Calcio (Ca)</td>
					<td><?= form_dropdown('hecho_19', $hecho, set_value('hecho_19'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'calcio', 'id'=>'calcio', 'value'=>set_value('calcio')));?></td>
					<td><?= form_dropdown('calcio_unidad_medida',$medidas1,set_value('calcio_unidad_medida')); ?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'calcio_nom_anom','value'=>'Normal','checked'=>set_radio('calcio_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'calcio_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('calcio_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'calcio_nom_anom','value'=>'Anormal_con','checked'=>set_radio('calcio_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Sodio (Na)</td>
					<td><?= form_dropdown('hecho_20', $hecho, set_value('hecho_20'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'sodio', 'id'=>'sodio', 'value'=>set_value('sodio')));?></td>
					<td><?= form_dropdown('sodio_unidad_medida',$medidas1,set_value('sodio_unidad_medida')); ?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'sodio_nom_anom','value'=>'Normal','checked'=>set_radio('sodio_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'sodio_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('sodio_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'sodio_nom_anom','value'=>'Anormal_con','checked'=>set_radio('sodio_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Potasio (K)</td>
					<td><?= form_dropdown('hecho_21', $hecho, set_value('hecho_21'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'potasio', 'id'=>'potasio', 'value'=>set_value('potasio')));?></td>
					<td><?= form_dropdown('potasio_unidad_medida',$medidas1,set_value('potasio_unidad_medida')); ?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'potasio_nom_anom','value'=>'Normal','checked'=>set_radio('potasio_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'potasio_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('potasio_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'potasio_nom_anom','value'=>'Anormal_con','checked'=>set_radio('potasio_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Cloro (Cl)</td>
					<td><?= form_dropdown('hecho_22', $hecho, set_value('hecho_22'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'cloro', 'id'=>'cloro', 'value'=>set_value('cloro')));?></td>
					<td><?= form_dropdown('cloro_unidad_medida',$medidas1,set_value('cloro_unidad_medida')); ?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'cloro_nom_anom','value'=>'Normal','checked'=>set_radio('cloro_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'cloro_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('cloro_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'cloro_nom_anom','value'=>'Anormal_con','checked'=>set_radio('cloro_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Ácido úrico</td>
					<td><?= form_dropdown('hecho_23', $hecho, set_value('hecho_23'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'acido_urico', 'id'=>'acido_urico', 'value'=>set_value('acido_urico')));?></td>
					<td>mg/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'acido_urico_nom_anom','value'=>'Normal','checked'=>set_radio('acido_urico_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'acido_urico_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('acido_urico_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'acido_urico_nom_anom','value'=>'Anormal_con','checked'=>set_radio('acido_urico_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Albúmina</td>
					<td><?= form_dropdown('hecho_24', $hecho, set_value('hecho_24'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'albumina', 'id'=>'albumina', 'value'=>set_value('albumina')));?></td>
					<td>mg/dl</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'albumina_nom_anom','value'=>'Normal','checked'=>set_radio('albumina_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'albumina_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('albumina_nom_anom', 'Anormal_sin')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'albumina_nom_anom','value'=>'Anormal_con','checked'=>set_radio('albumina_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<th colspan='6'>Análisis de Orina</th>					
				</tr>
				<tr>
					<td>pH</td>
					<td><?= form_dropdown('hecho_25', $hecho, set_value('hecho_25'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'orina_ph', 'id'=>'orina_ph', 'value'=>set_value('orina_ph')));?></td>
					<td></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_ph_nom_anom','value'=>'Normal','checked'=>set_radio('orina_ph_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_ph_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('orina_ph_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_ph_nom_anom','value'=>'Anormal_con','checked'=>set_radio('orina_ph_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Glucosa (qual)</td>
					<td><?= form_dropdown('hecho_26', $hecho, set_value('hecho_26'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'orina_glucosa', 'id'=>'orina_glucosa', 'value'=>set_value('orina_glucosa')));?></td>
					<td><?= form_dropdown('glucosa_unidad_medida',$medidas2,set_value('glucosa_unidad_medida')); ?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_glucosa_nom_anom','value'=>'Normal','checked'=>set_radio('orina_glucosa_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_glucosa_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('orina_glucosa_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_glucosa_nom_anom','value'=>'Anormal_con','checked'=>set_radio('orina_glucosa_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Proteína (qual)</td>
					<td><?= form_dropdown('hecho_27', $hecho, set_value('hecho_27'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'orina_proteinas', 'id'=>'orina_proteinas', 'value'=>set_value('orina_proteinas')));?></td>
					<td>mUI/ml</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_proteinas_nom_anom','value'=>'Normal','checked'=>set_radio('orina_proteinas_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_proteinas_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('orina_proteinas_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_proteinas_nom_anom','value'=>'Anormal_con','checked'=>set_radio('orina_proteinas_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Sangre (qual)</td>
					<td><?= form_dropdown('hecho_28', $hecho, set_value('hecho_28'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'orina_sangre', 'id'=>'orina_sangre', 'value'=>set_value('orina_sangre')));?></td>
					<td>mUI/ml</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_sangre_nom_anom','value'=>'Normal','checked'=>set_radio('orina_sangre_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_sangre_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('orina_sangre_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_sangre_nom_anom','value'=>'Anormal_con','checked'=>set_radio('orina_sangre_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Cetonas</td>
					<td><?= form_dropdown('hecho_29', $hecho, set_value('hecho_29'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'orina_cetonas', 'id'=>'orina_cetonas', 'value'=>set_value('orina_cetonas')));?></td>
					<td>mmol/l</td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_cetonas_nom_anom','value'=>'Normal','checked'=>set_radio('orina_cetonas_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_cetonas_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('orina_cetonas_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'orina_cetonas_nom_anom','value'=>'Anormal_con','checked'=>set_radio('orina_cetonas_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<?php if($etapa == 1){ ?>
					<tr>
						<td>Microscopía (Solamente si la tira reactiva es positiva para sangre o proteína.)</td>
						<td><?= form_dropdown('hecho_30', $hecho, set_value('hecho_30'));?></td>
						<td><?= form_input(array('type'=>'text', 'name'=>'orina_microscospia', 'id'=>'orina_microscospia', 'value'=>set_value('orina_microscospia')));?></td>
						<td></td>
						<td style='text-align:center;'><?= form_radio(array('name'=>'orina_microscospia_nom_anom','value'=>'Normal','checked'=>set_radio('orina_microscospia_nom_anom', 'Normal')));?></td>					
						<td style='text-align:center;'><?= form_radio(array('name'=>'orina_microscospia_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('orina_microscospia_nom_anom', 'Anormal_sin')));?></td>
						<td style='text-align:center;'><?= form_radio(array('name'=>'orina_microscospia_nom_anom','value'=>'Anormal_con','checked'=>set_radio('orina_microscospia_nom_anom', 'Anormal_con')));?></td>
					</tr>
				<?php }else{ ?>
					<?= form_hidden('hecho_30',''); ?>
					<?= form_hidden('orina_microscospia',''); ?>
					<?= form_hidden('orina_microscospia_nom_anom',''); ?>
				<?php }?>
			</tbody>
		</table>
		<br />
		&nbsp;			
		<br />
		Otros:
		<br />
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th style='text-align:center;'>Sangre</th>
					<th style='text-align:center;'>Realizado</th>
					<th style='text-align:center;'>Valor</th>					
					<th style='width:200px;text-align:center;'>Normal</th>					
					<th style='width:200px;text-align:center;'>Anormal sin significancia clinica </th>
					<th style='width:200px;text-align:center;'>Anormal con significancia clinica</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Homocisteina&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><?= form_dropdown('hecho_31', $hecho, set_value('hecho_31'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'otros_sangre_homocisteina', 'id'=>'otros_sangre_homocisteina', 'value'=>set_value('otros_sangre_homocisteina')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_sangre_homocisteina_nom_anom','value'=>'Normal','checked'=>set_radio('otros_sangre_homocisteina_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_sangre_homocisteina_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('otros_sangre_homocisteina_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_sangre_homocisteina_nom_anom','value'=>'Anormal_con','checked'=>set_radio('otros_sangre_homocisteina_nom_anom', 'Anormal_con')));?></td>
				</tr>
			</tbody>
		</table>
		<br />
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th style='text-align:center;'>Otros</th>
					<th style='text-align:center;'>Realizado</th>
					<th style='text-align:center;'>Valor</th>					
					<th style='width:200px;text-align:center;'>Normal</th>					
					<th style='width:200px;text-align:center;'>Anormal sin significancia clinica </th>
					<th style='width:200px;text-align:center;'>Anormal con significancia clinica</th>
					
				</tr>
			</thead>
			<tbody>
				<?php if($etapa == 1){ ?>
					<tr>
						<td>Perfil Tiroideo</td>
						<td><?= form_dropdown('hecho_32', $hecho, set_value('hecho_32'));?></td>
						<td><?= form_input(array('type'=>'text', 'name'=>'otros_perfil_tiroideo', 'id'=>'otros_perfil_tiroideo', 'value'=>set_value('otros_perfil_tiroideo')));?></td>
						<td style='text-align:center;'><?= form_radio(array('name'=>'otros_perfil_tiroideo_nom_anom','value'=>'Normal','checked'=>set_radio('otros_perfil_tiroideo_nom_anom', 'Normal')));?></td>					
						<td style='text-align:center;'><?= form_radio(array('name'=>'otros_perfil_tiroideo_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('otros_perfil_tiroideo_nom_anom', 'Anormal_sin')));?></td>
						<td style='text-align:center;'><?= form_radio(array('name'=>'otros_perfil_tiroideo_nom_anom','value'=>'Anormal_con','checked'=>set_radio('otros_perfil_tiroideo_nom_anom', 'Anormal_con')));?></td>
					</tr>
				<?php } else{ ?>
					<?= form_hidden('otros_perfil_tiroideo','No Aplica');?>
					<?= form_hidden('otros_perfil_tiroideo_nom_anom','No Aplica');?>					
				<?php } ?>
				<tr>
					<td>Nivel plasmático de V B12</td>
					<td><?= form_dropdown('hecho_33', $hecho, set_value('hecho_33'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'otros_nivel_b12', 'id'=>'otros_nivel_b12', 'value'=>set_value('otros_nivel_b12')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_nivel_b12_nom_anom','value'=>'Normal','checked'=>set_radio('otros_nivel_b12_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_nivel_b12_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('otros_nivel_b12_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_nivel_b12_nom_anom','value'=>'Anormal_con','checked'=>set_radio('otros_nivel_b12_nom_anom', 'Anormal_con')));?></td>
				</tr>
				<tr>
					<td>Nivel plasmático de ácido fólico</td>
					<td><?= form_dropdown('hecho_34', $hecho, set_value('hecho_34'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'otros_acido_folico', 'id'=>'otros_acido_folico', 'value'=>set_value('otros_acido_folico')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_acido_folico_nom_anom','value'=>'Normal','checked'=>set_radio('otros_acido_folico_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_acido_folico_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('otros_acido_folico_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_acido_folico_nom_anom','value'=>'Anormal_con','checked'=>set_radio('otros_acido_folico_nom_anom', 'Anormal_con')));?></td>
				</tr>				
				<tr>
					<td>HbA1C (No aplica <input type='checkbox' name='no_aplica_hba1c' id='no_aplica_hba1c' value='1' />)</td>
					<td><?= form_dropdown('hecho_35', $hecho, set_value('hecho_35'));?></td>
					<td><?= form_input(array('type'=>'text', 'name'=>'otros_hba1c', 'id'=>'otros_hba1c', 'value'=>set_value('otros_hba1c')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_hba1c_nom_anom','value'=>'Normal','checked'=>set_radio('otros_hba1c_nom_anom', 'Normal')));?></td>					
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_hba1c_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('otros_hba1c_nom_anom', 'Anormal_sin')));?></td>
					<td style='text-align:center;'><?= form_radio(array('name'=>'otros_hba1c_nom_anom','value'=>'Anormal_con','checked'=>set_radio('otros_hba1c_nom_anom', 'Anormal_con')));?></td>
				</tr>				
				
				<?php if($etapa == 1){ ?>	
					<tr>
						<td>Sífilis (R.P.R)</td>
						<td><?= form_dropdown('hecho_36', $hecho, set_value('hecho_36'));?></td>
						<td><?= form_input(array('type'=>'text', 'name'=>'sifilis', 'id'=>'sifilis', 'value'=>set_value('sifilis')));?></td>
						<td style='text-align:center;'><?= form_radio(array('name'=>'sifilis_nom_anom','value'=>'Normal','checked'=>set_radio('sifilis_nom_anom', 'Normal')));?></td>					
						<td style='text-align:center;'><?= form_radio(array('name'=>'sifilis_nom_anom','value'=>'Anormal_sin','checked'=>set_radio('sifilis_nom_anom', 'Anormal_sin')));?></td>
						<td style='text-align:center;'><?= form_radio(array('name'=>'sifilis_nom_anom','value'=>'Anormal_con','checked'=>set_radio('sifilis_nom_anom', 'Anormal_con')));?></td>
					</tr>
				<?php } else{ ?>
					<?= form_hidden('sifilis','No Aplica');?>
					<?= form_hidden('sifilis_nom_anom','No Aplica');?>					
				<?php } ?>
			</tbody>
		</table>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Observaciones</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<?= form_textarea('observaciones', set_value('observaciones'), array('rows'=>'4','style'=>'width:100%;')); ?>
					</td>
				</tr>
			</tbody>

		</table>
		<hr />
		<div style="text-align:center;">
			<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'examen_laboratorio_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
            <?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn btn-default')); ?>
		</div>

<?= form_close(); ?>