<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){

	$("input[name^=date_of]").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name^=continuing]").change(function(){
		if($(this).val() == 1){
			$("#date_of_resolution").hide();
		}else{
			$("#date_of_resolution").show();
		}
	});

	if( $("input[name=continuing]:checked").val() == 1){
		$("#date_of_resolution").hide();
	}else{		
		$("#date_of_resolution").show();
	}
});
</script>
<legend style='text-align:center;'>Evento Adverso/Evento Adverso Serio</legend>
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
	$stages = array(	""=>"",
						"Seleccion - Visita Basal"=>"Selección - Visita Basal",
						"Visita Basal - Semana 4"=>"Visita Basal - Semana 4",
						"Semana 4 - Semana 12"=>"Semana 4 – Semana 12",
						"Semana 12 - Semana 24"=>"Semana 12 - Semana 24"
						);
	$event_categorys = array(	""=>"",
								"Desordenes Musculo esqueletico y Conectivo"=>"Desordenes Musculo esquelético y Conectivo",
								"Desordenes Sistema Nervioso"=>"Desordenes Sistema Nervioso",
								"Desordenes Psiquiatricos"=>"Desordenes Psiquiátricos",
								"Desordenes de la Funcion Renal"=>"Desordenes de la Función Renal",
								"Desordenes Mediastino, Respiratorio y/o Toraxico"=>"Desordenes Mediastino, Respiratorio y/o Toráxico",
								"Desordenes de Tejidos y Piel"=>"Desordenes de Tejidos y Piel",
								"Complicaciones Vasculares"=>"Complicaciones Vasculares",
								"Otros"=>"Otros");
	
	$data = array(
        'name'        => 'continuing',                
        'value'       => '1',            
        'checked'     => set_radio('continuing', 1, (($list[0]->continuing == 1) ? true : false))                 
        );
    $data2 = array(
        'name'        => 'continuing',                
        'value'       => '0',        
        'checked'     => set_radio('continuing', 0, (($list[0]->continuing == 0) ? true : false))                 
        );
    
    $data3 = array(
        'name'        => 'assessment_of_casuality',                
        'value'       => '1',
        'checked'     => set_radio('assessment_of_casuality', 1, (($list[0]->assessment_of_casuality == 1) ? true : false))         
        );
    $data4 = array(
        'name'        => 'assessment_of_casuality',                
        'value'       => '0',        
        'checked'     => set_radio('assessment_of_casuality', 0, (($list[0]->assessment_of_casuality == 0) ? true : false))         
        );
    
    $data5 = array(
        'name'        => 'sae',                
        'value'       => '1',
        'checked'     => set_radio('sae', 1, (($list[0]->sae == 1) ? true : false))      
        );
    $data6 = array(
        'name'        => 'sae',                
        'value'       => '0',        
        'checked'     => set_radio('sae', 0, (($list[0]->sae == 0) ? true : false)) 
        );

    $data7 = array(
        'name'        => 'action_taken_on_investigation_product',                
        'value'       => 'None',        
        'checked'     => set_radio('action_taken_on_investigation_product', 'None', (($list[0]->action_taken_on_investigation_product == 'None') ? true : false)) 
        );
    $data8 = array(
        'name'        => 'action_taken_on_investigation_product',                
        'value'       => 'Discontinued',
        'checked'     => set_radio('action_taken_on_investigation_product', 'Discontinued', (($list[0]->action_taken_on_investigation_product == 'Discontinued') ? true : false)) 
        );

    $assessment_of_severitys = array(""=>"",
    								"Leve"=>"Leve",
    								"Moderado"=>"Moderado",
    								"Severo"=>"Severo");

    $action_taken_none = array(
	    'name'        => 'action_taken_none',
	    'id'          => 'action_taken_none',
	    'value'       => '1',
	    'checked'     => set_checkbox('action_taken_none', 1, ($list[0]->action_taken_none == 1 ) ? true : false),
	    'style'       => 'margin:10px',
    );

    $action_taken_medication = array(
	    'name'        => 'action_taken_medication',
	    'id'          => 'action_taken_medication',
	    'value'       => '1',	    
	    'checked'     => set_checkbox('action_taken_medication', 1, ($list[0]->action_taken_medication == 1 ) ? true : false),
	    'style'       => 'margin:10px',
    );

    $action_taken_hospitalization = array(
	    'name'        => 'action_taken_hospitalization',
	    'id'          => 'action_taken_hospitalization',
	    'value'       => '1',	    
	    'checked'     => set_checkbox('action_taken_hospitalization', 1, ($list[0]->action_taken_hospitalization == 1 ) ? true : false),
	    'style'       => 'margin:10px',
    );

?>

<div style='display:none;'>
	<div id='dialog_auditoria'><?= ((isset($auditoria) AND !empty($auditoria)) ? $auditoria : ''); ?></div>
</div>
<?php
	if(isset($auditoria) AND !empty($auditoria)){
		echo "<div style='text-align:right;'><a id='ver_auditoria' class='btn btn-info colorbox_inline' href='#dialog_auditoria'>Ver Auditoria</a></div>";
	}
?>

<?= form_open('subject/adverse_event_form_update', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>

	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('id', $list[0]->id); ?>
	
	<table class="table table-striped table-condensed table-bordered">        
        <tr>
            <td>Etapa en que ocurre el Evento Adverso: </td>
            <td><?= form_dropdown("stage",$stages,set_value('stage',$list[0]->stage)); ?></td>
        </tr>        

		<tr>
            <td>Categoría del Evento Adverso: </td>
            <td><?= form_dropdown("event_category",$event_categorys,set_value('event_category',$list[0]->event_category)); ?></td>
        </tr>  
		
		<tr>
        	<td>Descripción: </td>
        	<td><?= form_textarea(array('name'=>'event_category_description', 'id'=>'event_category_description', 'value'=>set_value('event_category_description',$list[0]->event_category_description), 'rows'=>'4','cols'=>'40')); ?></td>
		</tr>

		<tr>
        	<td>Narrativa del Evento Adverso: </td>
        	<td><?= form_textarea(array('name'=>'event_category_narrative', 'id'=>'event_category_narrative', 'value'=>set_value('event_category_narrative',$list[0]->event_category_narrative), 'rows'=>'4','cols'=>'40')); ?></td>
		</tr>

        <tr>
        	<td>Fecha Inicio: </td>
        	<td><?= form_input(array('type'=>'text', 'name'=>'date_of_onset', 'id'=>'date_of_onset', 'readonly'=>'readonly', 'style'=>'cursor: pointer;', 'value'=>set_value('date_of_onset', (($list[0]->date_of_onset != '0000-00-00') ? date('d/m/Y', strtotime($list[0]->date_of_onset)) : '')  )));?></td>
		</tr>

		<tr>
        	<td>Continúa: </td>
        	<td><?= form_radio($data); ?> Si <?= form_radio($data2); ?> No</td>
		</tr>

		<tr>
        	<td>Fecha Resolución: </td>
        	<td><?= form_input(array('type'=>'text', 'name'=>'date_of_resolution', 'id'=>'date_of_resolution', 'readonly'=>'readonly', 'style'=>'cursor: pointer;', 'value'=>set_value('date_of_resolution',(($list[0]->date_of_resolution != '0000-00-00') ? date('d/m/Y', strtotime($list[0]->date_of_resolution)) : '') )));?></td>
		</tr>

		<tr>
            <td>Evaluación de Severidad: </td>
            <td><?= form_dropdown("assessment_of_severity",$assessment_of_severitys,set_value('assessment_of_severity',$list[0]->assessment_of_severity)); ?></td>
        </tr>

		<tr>
        	<td>¿Está el Evento relacionado con el Producto de Investigación? : </td>
        	<td><?= form_radio($data3); ?> Si <?= form_radio($data4); ?> No</td>
		</tr>

		<tr>
        	<td>¿Es un Evento Adverso Serio? (SAE)? : </td>
        	<td><?= form_radio($data5); ?> Si <?= form_radio($data6); ?> No</td>
		</tr>

		<tr>
        	<td>Acción tomada/Tratamiento administrado: </td>
        	<td><?= form_checkbox($action_taken_none);?>Ninguna 
        		<?= form_checkbox($action_taken_medication);?>Medicación 
        		<?= form_checkbox($action_taken_hospitalization);?>Hospitalización
        	</td>
		</tr>
		
		<tr>
        	<td>Se toma acción con el Producto de Investigación: </td>
        	<td><?= form_radio($data7); ?> Ninguna <?= form_radio($data8); ?> Discontinuado</td>
		</tr>
		<tr>
            <td colspan='2' style='text-align:center;'><?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
            <?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn btn-default')); ?></td>
       </tr>
    </table>
<?= form_close(); ?>
<b>Creado por:</b> <?= $list[0]->usuario_creacion;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->created));?><br />&nbsp;</br>
<!-- Verify -->
<b>Aprobacion del Monitor:</b><br />
	<?php if(!empty($list[0]->verify_user) AND !empty($list[0]->verify_date)){ ?>
		
		Formulario aprobado por <?= $list[0]->verify_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->verify_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'adverse_event_verify') 
			AND $list[0]->status == 'Record Complete'
		){
	?>
		<?= form_open('subject/adverse_event_verify', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>		
		<?= form_hidden('id', $list[0]->id); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Verificar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Aprobacion";
		}
	}
?>
<br />

<!--Signature/Lock-->
<br /><b>Cierre:</b><br />
	<?php if(!empty($list[0]->lock_user) AND !empty($list[0]->lock_date)){ ?>
		
		Formulario cerrado por <?= $list[0]->lock_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->lock_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'adverse_event_lock')
			AND $list[0]->status == 'Form Approved by Monitor'){
	?>
		<?= form_open('subject/adverse_event_lock', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>		
		<?= form_hidden('id', $list[0]->id); ?>
		<?= form_hidden('current_status', $list[0]->status); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Cerrar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Cierre";
		}
	}
?>
<br />
<!--Signature-->
	<br /><b>Firma:</b><br />
	<?php if(!empty($list[0]->signature_user) AND !empty($list[0]->signature_date)){ ?>
		
		Formulario Firmado por <?= $list[0]->signature_user;?> el <?= date("d-M-Y H:i:s",strtotime($list[0]->signature_date));?>
	
	<?php
	}
	else{
	
		if(isset($_SESSION['role_options']['subject']) 
			AND strpos($_SESSION['role_options']['subject'], 'adverse_event_signature')
			AND $list[0]->status == 'Form Approved and Locked'
		){
	?>
		<?= form_open('subject/adverse_event_signature', array('class'=>'form-horizontal')); ?>    	
		<?= form_hidden('subject_id', $subject->id); ?>		
		<?= form_hidden('current_status', $list[0]->status); ?>
		<?= form_hidden('id', $list[0]->id); ?>
			
		<?= form_button(array('type'=>'submit', 'content'=>'Firmar', 'class'=>'btn btn-primary')); ?>

		<?= form_close(); ?>

<?php }else{
		echo "Pendiente de Firma";
		}
	}
?>
<br />