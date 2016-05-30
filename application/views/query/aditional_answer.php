<legend style='text-align:center;'>Consulta <?= $form;?></legend>
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
<?= form_open('query/additional_form_query_update', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>	
	<?= form_hidden('id', $query->id); ?>
	<?= form_hidden('form', $form); ?>	
	<?php if(isset($etapa)){
		echo form_hidden('etapa', $etapa);
	}
	?>
	
	<table class="table table-striped table-condensed table-bordered">        
        <tr>
            <td>Consulta: </td>
            <td><?= $query->question;?></td>
        </tr>
        <tr>
            <td>Respuesta: </td>
            <td><?= form_textarea(array('name'=>'answer', 'id'=>'answer', 'value'=>set_value('answer'), 'rows'=>'4','cols'=>'40')); ?></td>
        </tr>
        <tr>
            <td colspan='2' style='text-align:center;'><?= form_button(array('type'=>'submit', 'content'=>'Enviar', 'class'=>'btn btn-primary')); ?>
            
			<?php 
				if($form == 'Adverse Event'){
					echo anchor('subject/adverse_event_show/'.$subject->id, 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'Protocol Deviation'){
					echo anchor('subject/protocol_deviation_show/'.$subject->id, 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'Concomitant Medication'){
					echo anchor('subject/concomitant_medication_show/'.$subject->id, 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'Historial Medico'){
					echo anchor('subject/historial_medico_show/'. $registro['subject_id'] .'/'. $registro['etapa'], 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'Inclusion Exclusion'){
					echo anchor('subject/inclusion_show/'. $registro['subject_id'] .'/'. $registro['etapa'], 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'Hachinski'){
					echo anchor('subject/hachinski_show/'. $registro['subject_id'], 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'Cumplimiento'){
					echo anchor('subject/cumplimiento_show/'. $registro['subject_id'] .'/'. $registro['etapa'], 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'Digito Directo'){
					echo anchor('subject/digito_directo_show/'. $registro['subject_id'] .'/'. $registro['etapa'], 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'ECG'){
					echo anchor('subject/ecg_show/'. $registro['subject_id'], 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'Examen Laboratorio'){
					echo anchor('subject/examen_laboratorio_show/'. $registro['subject_id'], 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'Examen Neurologico'){
					echo anchor('subject/examen_neurologico_show/'. $registro['subject_id'] .'/'. $registro['etapa'], 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'Fin Tratamiento'){
					echo anchor('subject/fin_tratamiento_show/'. $registro['subject_id'], 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'Fin Tratamiento Temprano'){
					echo anchor('subject/fin_tratamiento_temprano_show/'. $registro['subject_id'], 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'Historial Medico'){
					echo anchor('subject/historial_medico_show/'. $registro['subject_id'] .'/'. $registro['etapa'], 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'MMSE'){
					echo anchor('subject/mmse_show/'. $registro['subject_id'] .'/'. $registro['etapa'], 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'Muestra de Sangre'){
					echo anchor('subject/muestra_de_sangre_show/'. $registro['subject_id'] .'/'. $registro['etapa'], 'Volver', array('class'=>'btn'));
				}
				elseif($form == 'Sginos Vitales'){
					echo anchor('subject/signos_vitales_show/'. $registro['subject_id'] .'/'. $registro['etapa'], 'Volver', array('class'=>'btn'));
				}
			?>
            </td>
       </tr>  
    </table>
<?= form_close();?>