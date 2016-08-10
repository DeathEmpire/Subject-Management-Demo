<script src="<?= base_url('js/historial_medico.js') ?>"></script>
<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">

</script>
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
		<legend style='text-align:center;'>Historia Medica <?= $protocolo;?></legend>
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

	<?= form_open('subject/historial_medico_insert', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>

	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>

	<table class='table table-striped table-hover table-bordered table-condensed table-responsive'>		
		<thead>
			<tr>
				<td style='font-weight:bold;'>1.- ANTECEDENTES DEL SUJETO</td>	
				<td class='span2'></td>		
				<td style='font-weight:bold;' colspan='3'>FECHA DIAGNOSTICO</td>
			</tr>
			<tr>
				<td colspan='2'></td>
				<td>Dia</td>
				<td>Mes</td>
				<td>Año</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Hipertensión arterial:</td>
				<td>
					<?= form_radio('hipertension',1,set_radio('hipertension'));?> SI
					<?= form_radio('hipertension',0,set_radio('hipertension'));?> NO
				</td>
				
				<td><?= form_dropdown('hipertension_dia', $dias_ea, set_value('hipertension_dia'), array('class'=>'input-small')); ?></td>
				<td><?= form_dropdown('hipertension_mes', $meses_ea, set_value('hipertension_mes'), array('class'=>'input-small')); ?></td>
				<td><?= form_dropdown('hipertension_anio', $anio_ea, set_value('hipertension_anio'), array('class'=>'input-small')); ?></td>
				
			</tr>
			<tr>
				<td>Úlcera gastrointestinal: </td>
				<td>
					<?= form_radio('ulcera',1,set_radio('ulcera'));?> SI
					<?= form_radio('ulcera',0,set_radio('ulcera'));?> NO
				</td>
					<td><?= form_dropdown('ulcera_dia', $dias_ea, set_value('ulcera_dia'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('ulcera_mes', $meses_ea, set_value('ulcera_mes'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('ulcera_anio', $anio_ea, set_value('ulcera_anio'), array('class'=>'input-small')); ?></td>
				
			</tr>
			<tr>
				<td>Diabetes mellitus: </td>
				<td>
					<?= form_radio('diabetes',1,set_radio('diabetes'));?> SI
					<?= form_radio('diabetes',0,set_radio('diabetes'));?> NO
				</td>
					<td><?= form_dropdown('diabetes_dia', $dias_ea, set_value('diabetes_dia'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('diabetes_mes', $meses_ea, set_value('diabetes_mes'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('diabetes_anio', $anio_ea, set_value('diabetes_anio'), array('class'=>'input-small')); ?></td>
				
			</tr>
			<tr>
				<td>Hipo/Hipertiroidismo: </td>
				<td>
					<?= form_radio('hipo_hipertiroidismo',1,set_radio('hipo_hipertiroidismo'));?> SI
					<?= form_radio('hipo_hipertiroidismo',0,set_radio('hipo_hipertiroidismo'));?> NO
				</td>
				<td>
					<?= form_dropdown('hipo_hipertiroidismo_dia', $dias_ea, set_value('hipo_hipertiroidismo_dia'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('hipo_hipertiroidismo_mes', $meses_ea, set_value('hipo_hipertiroidismo_mes'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('hipo_hipertiroidismo_anio', $anio_ea, set_value('hipo_hipertiroidismo_anio'), array('class'=>'input-small')); ?></td>
				
			</tr>
			<tr>
				<td>Hiperlipidemia:</td>
				<td>
					<?= form_radio('hiperlipidemia',1,set_radio('hiperlipidemia'));?> SI
					<?= form_radio('hiperlipidemia',0,set_radio('hiperlipidemia'));?> NO
				</td>
				<td>
					<?= form_dropdown('hiperlipidemia_dia', $dias_ea, set_value('hiperlipidemia_dia'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('hiperlipidemia_mes', $meses_ea, set_value('hiperlipidemia_mes'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('hiperlipidemia_anio', $anio_ea, set_value('hiperlipidemia_anio'), array('class'=>'input-small')); ?></td>
				
			</tr>
			<tr>
				<td>EPOC</td>
				<td>
					<?= form_radio('epoc',1,set_radio('epoc'));?> SI
					<?= form_radio('epoc',0,set_radio('epoc'));?> NO
				</td>
				<td>
					<?= form_dropdown('epoc_dia', $dias_ea, set_value('epoc_dia'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('epoc_mes', $meses_ea, set_value('epoc_mes'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('epoc_anio', $anio_ea, set_value('epoc_anio'), array('class'=>'input-small')); ?></td>
				
			</tr>
			<tr>
				<td>Enfermedad coronaria:</td>
				<td>
					<?= form_radio('coronaria',1,set_radio('coronaria'));?> SI
					<?= form_radio('coronaria',0,set_radio('coronaria'));?> NO
				</td>
				<td>
					<?= form_dropdown('coronaria_dia', $dias_ea, set_value('coronaria_dia'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('coronaria_mes', $meses_ea, set_value('coronaria_mes'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('coronaria_anio', $anio_ea, set_value('coronaria_anio'), array('class'=>'input-small')); ?></td>
				
			</tr>
			<tr>
				<td>Rinitis:</td>
				<td>
					<?= form_radio('rinitis',1,set_radio('rinitis'));?> SI
					<?= form_radio('rinitis',0,set_radio('rinitis'));?> NO
				</td>
				<td>
					<?= form_dropdown('rinitis_dia', $dias_ea, set_value('rinitis_dia'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('rinitis_mes', $meses_ea, set_value('rinitis_mes'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('rinitis_anio', $anio_ea, set_value('rinitis_anio'), array('class'=>'input-small')); ?></td>
				
			</tr>
			<tr>
				<td>Accidente vascular encefálico:</td>
				<td>
					<?= form_radio('acc_vascular',1,set_radio('acc_vascular'));?> SI
					<?= form_radio('acc_vascular',0,set_radio('acc_vascular'));?> NO
				</td>
				<td>
					<?= form_dropdown('acc_vascular_dia', $dias_ea, set_value('acc_vascular_dia'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('acc_vascular_mes', $meses_ea, set_value('acc_vascular_mes'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('acc_vascular_anio', $anio_ea, set_value('acc_vascular_anio'), array('class'=>'input-small')); ?></td>
				
			</tr>
			<tr>
				<td>Asma:</td>
				<td>
					<?= form_radio('asma',1,set_radio('asma'));?> SI
					<?= form_radio('asma',0,set_radio('asma'));?> NO
				</td>
				<td>
					<?= form_dropdown('asma_dia', $dias_ea, set_value('asma_dia'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('asma_mes', $meses_ea, set_value('asma_mes'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('asma_anio', $anio_ea, set_value('asma_anio'), array('class'=>'input-small')); ?></td>
				
			</tr>
			<tr>
				<td>Gastritis/Reflujo GE:</td>
				<td>
					<?= form_radio('gastritis',1,set_radio('gastritis'));?> SI
					<?= form_radio('gastritis',0,set_radio('gastritis'));?> NO
				</td>
				<td>
					<?= form_dropdown('gastritis_dia', $dias_ea, set_value('gastritis_dia'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('gastritis_mes', $meses_ea, set_value('gastritis_mes'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('gastritis_anio', $anio_ea, set_value('gastritis_anio'), array('class'=>'input-small')); ?></td>
				
			</tr>
			<tr>
				<td>Cefaleas matinales:</td>
				<td>
					<?= form_radio('cefaleas',1,set_radio('cefaleas'));?> SI
					<?= form_radio('cefaleas',0,set_radio('cefaleas'));?> NO
				</td>
					<td><?= form_dropdown('cefaleas_dia', $dias_ea, set_value('cefaleas_dia'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('cefaleas_mes', $meses_ea, set_value('cefaleas_mes'), array('class'=>'input-small')); ?></td>
					<td><?= form_dropdown('cefaleas_anio', $anio_ea, set_value('cefaleas_anio'), array('class'=>'input-small')); ?></td>
				
			</tr>
		</tbody>
	</table>
			<table class='table table-striped table-bordered table-hover'>
			<thead>
			<tr>
				<td style='background-color:#ccc;'></td>
				<td style='background-color:#ccc;'></td>
				<td style='font-weight:bold;background-color:#ccc;'>Describir</td>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>Alergias:</td>
				<td>
					<?= form_radio('alergia',1,set_radio('alergia'));?> SI
					<?= form_radio('alergia',0,set_radio('alergia'));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'alergia_desc', 'id'=>'alergia_desc', 'value'=>set_value('alergia_desc'), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>Tabaquismo (cantidad):</td>
				<td>
					<?= form_radio('tabaquismo',1,set_radio('tabaquismo'));?> SI
					<?= form_radio('tabaquismo',0,set_radio('tabaquismo'));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'tabaquismo_desc', 'id'=>'tabaquismo_desc', 'value'=>set_value('tabaquismo_desc'), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>Ingesta de Alcohol:</td>
				<td>
					<?= form_radio('ingesta_alcohol',1,set_radio('ingesta_alcohol'));?> SI
					<?= form_radio('ingesta_alcohol',0,set_radio('ingesta_alcohol'));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'ingesta_alcohol_desc', 'id'=>'ingesta_alcohol_desc', 'value'=>set_value('ingesta_alcohol_desc'), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>Consumo de Drogas de abuso:</td>
				<td>
					<?= form_radio('drogas',1,set_radio('drogas'));?> SI
					<?= form_radio('drogas',0,set_radio('drogas'));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'drogas_desc', 'id'=>'drogas_desc', 'value'=>set_value('drogas_desc'), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>¿Ha tenido alguna intervención quirúrgica y/o cirugía?</td>
				<td>
					<?= form_radio('cirugia',1,set_radio('cirugia'));?> SI
					<?= form_radio('cirugia',0,set_radio('cirugia'));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'cirugia_desc', 'id'=>'cirugia_desc', 'value'=>set_value('cirugia_desc'), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>¿Ha donado sangre o ha participado en algún estudio clínico farmacológico en los últimos tres meses?</td>
				<td>
					<?= form_radio('donado_sangre',1,set_radio('donado_sangre'));?> SI
					<?= form_radio('donado_sangre',0,set_radio('donado_sangre'));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'donado_sangre_desc', 'id'=>'donado_sangre_desc', 'value'=>set_value('donado_sangre_desc'), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>¿Está recibiendo o ha recibido en el último mes, algún tratamiento farmacológico?</td>
				<td>
					<?= form_radio('tratamiento_farma',1,set_radio('tratamiento_farma'));?> SI
					<?= form_radio('tratamiento_farma',0,set_radio('tratamiento_farma'));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'tratamiento_farma_desc', 'id'=>'tratamiento_farma_desc', 'value'=>set_value('tratamiento_farma_desc'), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>¿Está recibiendo o ha recibido en el último mes, algún suplemento dietético o vitamínico?</td>
				<td>
					<?= form_radio('suplemento_dietetico',1,set_radio('suplemento_dietetico'));?> SI
					<?= form_radio('suplemento_dietetico',0,set_radio('suplemento_dietetico'));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'suplemento_dietetico_desc', 'id'=>'suplemento_dietetico_desc', 'value'=>set_value('suplemento_dietetico_desc'), 'rows'=>'5')); ?></td>
			</tr>		
			<tr>
				<td>2.- ANTECEDENTES FAMILIARES DE ALZHEIMER (padre, madre, hermanos): </td>
				<td>
					<?= form_radio('alzheimer',1,set_radio('alzheimer'));?> SI
					<?= form_radio('alzheimer',0,set_radio('alzheimer'));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'alzheimer_desc', 'id'=>'alzheimer_desc', 'value'=>set_value('alzheimer_desc'), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>3.- FECHA EN QUE PRESENTÓ PRIMEROS SÍNTOMAS ASOCIADOS A LA EA</td>				
				<td>Fecha: </td>
				<td>
					<?= form_dropdown('dia_ea', $dias_ea, set_value('dia_ea'), array('class'=>'input-small')); ?> / 
					<?= form_dropdown('mes_ea', $meses_ea, set_value('mes_ea'), array('class'=>'input-small')); ?> / 
					<?= form_dropdown('anio_ea', $anio_ea, set_value('anio_ea'), array('class'=>'input-small')); ?>					
				</td>
			</tr>
			<tr>
				<td>4.- ANTECEDENTES MORBIDOS FAMILIARES (padre, madre, hermanos):</td>
				<td>
					<?= form_radio('morbido',1,set_radio('morbido'));?> SI
					<?= form_radio('morbido',0,set_radio('morbido'));?> NO
				</td>
				<td><?= form_textarea(array('type'=>'textarea', 'name'=>'morbido_desc', 'id'=>'morbido_desc', 'value'=>set_value('morbido_desc'), 'rows'=>'5')); ?></td>
			</tr>
			<tr>
				<td>Observaciones (Opcional)</td>
				<td colspan='2'><?= form_textarea(array('type'=>'textarea', 'name'=>'observaciones', 'id'=>'observaciones', 'value'=>set_value('observaciones'), 'rows'=>'10', 'cols'=>'60', 'style'=>'width:98%;')); ?></td>
			</tr>
			<tr>
				<td colspan='3' style='text-align:center;'>
					<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'historial_medico_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
					<?= anchor('subject/grid/'. $subject->id, 'Volver', array('class'=>'btn btn-default')); ?>
				</td>				
			</tr>			
		</tbody>
	</table>

	<?= form_close(); ?>
