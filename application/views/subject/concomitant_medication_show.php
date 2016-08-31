<style type="text/css">
    #ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){

	$("#start_date").datepicker({ dateFormat: 'dd/mm/yy' });
	$("#end_date").datepicker({ dateFormat: 'dd/mm/yy' });

	$("input[name^=on_going]").change(function(){
		if($(this).val() == 0){
			$("#end_date_tr").show();
		}
		else{
			$("#end_date_tr").hide();
		}
	});

	if($("input[name^=on_going]:checked").val() == 0){
			$("#end_date_tr").show();
		}
		else{
			$("#end_date_tr").hide();
		}

	$("select[name=frequency]").change(function(){
		if($(this).val() == "Otro"){
			$("#other").show();
		}
		else{
			$("#other").hide();
		}
	});


	if($("select[name=frequency]").val() == "Otro"){
		$("#other").show();
	}else{
		$("#other").hide();
	}

});
</script>
<legend style='text-align:center;'>Medicación Concomitante</legend>
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
	$data = array(
        'name'        => 'on_going',                
        'value'       => '1',            
        'checked'     => set_radio('on_going', 1, (($list[0]->on_going == 1) ? true : false) ),
        );
    $data2 = array(
        'name'        => 'on_going',                
        'value'       => '0',
        'checked'     => set_radio('on_going', 0, (($list[0]->on_going == 0) ? true : false) ),
        );
    $unit_of_measure = array(""=>"",
    						"CAP"=>"CAP",
    						"g"=>"g",
    						"GR"=>"GR",
    						"GTT"=>"GTT",
    						"IU"=>"IU",
    						"LPM"=>"LPM",
    						"mcg"=>"mcg",
    						"mEq"=>"mEq",
    						"mg"=>"mg",
    						"mL"=>"mL",
    						"oz"=>"oz",
    						"PCH"=>"PCH",
    						"PUF"=>"PUF",
    						"SPY"=>"SPY",
    						"SUP"=>"SUP",
    						"TAB"=>"TAB",
    						"TBS"=>"TBS",
    						"TSP"=>"TSP",
    						"uL"=>"uL",
    						"Unidad"=>"Unidad");
    $frequencys = array(""=>"",
    					"BID"=>"BID",
    					"HS"=>"HS",
    					"OTH"=>"OTH",
    					"PRN"=>"PRN",
    					"QAM"=>"QAM",
    					"QD"=>"QD",
    					"QID"=>"QID",
    					"QOD"=>"QOD",
    					"QPM"=>"QPM",
    					"QWK"=>"QWK",
    					"TID"=>"TID",
    					"Antes de cada comida"=>"Antes de cada comida",
    					"Despues de cada comida"=>"Despues de cada comida",    					
    					"Cada Horas (qhr)"=>"Cada Horas (qhr)",
    					"Cada 4 Horas (q4hr)"=>"Cada 4 Horas (q4hr)",
    					"Stat"=>"Stat",
    					"Otro"=>"Otro");
    $routes = array(""=>"",
    				"ID"=>"ID",
    				"IH"=>"IH",
    				"IM"=>"IM",
    				"IV"=>"IV",
    				"PO"=>"PO",
    				"PR"=>"PR",
    				"PV"=>"PV",
    				"SL"=>"SL",
    				"SQ"=>"SQ",
    				"TOP"=>"TOP",
    				"UNK"=>"UNK",
    				"Inhalacion"=>"Inhalación",
    				"Intranasal"=>"Intranasal",
    				"Otro"=>"Otro");

?>
<div style='display:none;'>
    <div id='dialog_auditoria'><?= ((isset($auditoria) AND !empty($auditoria)) ? $auditoria : ''); ?></div>
</div>
<?php
    if(isset($auditoria) AND !empty($auditoria)){
        echo "<div style='text-align:right;'><a id='ver_auditoria' class='btn btn-info colorbox_inline' href='#dialog_auditoria'>Ver Auditoria</a></div>";
    }
?>
<?= form_open('subject/concomitant_medication_form_update', array('class'=>'form-horizontal')); ?>
	
	<?= my_validation_errors(validation_errors()); ?>
	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('id', $list[0]->id); ?>

	<table class="table table-striped table-condensed table-bordered">       		
        <tr>
        	<td>Nombre Comercial: </td>
        	<td><?= form_input(array('type'=>'text', 'name'=>'brand_name', 'id'=>'brand_name', 'value'=>set_value('brand_name', $list[0]->brand_name)));?></td>
		</tr>
		<tr>
        	<td>Nombre Genérico: </td>
        	<td><?= form_input(array('type'=>'text','name'=>'generic_name', 'id'=>'generic_name', 'value'=>set_value('generic_name', $list[0]->generic_name))); ?></td>
		</tr>
		<tr>
        	<td>Indicación: </td>
        	<td><?= form_input(array('type'=>'text','name'=>'indication', 'id'=>'indication', 'value'=>set_value('indication', $list[0]->indication))); ?></td>
		</tr>
		<tr>
        	<td>Dosis total diaria : </td>
        	<td>
        		<?= form_input(array('type'=>'text','name'=>'daily_dose', 'id'=>'daily_dose', 'size'=>'4','value'=>set_value('daily_dose', $list[0]->daily_dose))); ?>
				<?= form_dropdown("unit_of_measure",$unit_of_measure,set_value('unit_of_measure', $list[0]->unit_of_measure)); ?>
        	</td>
		</tr>
		<tr>
        	<td>Frecuencia: </td>
        	<td><?= form_dropdown("frequency",$frequencys,set_value('frequency', $list[0]->frequency)); ?></td>
		</tr>
		<tr>
        	<td>Si es otra especificar: </td>
        	<td><?= form_input(array('type'=>'text','name'=>'other', 'id'=>'other', 'value'=>set_value('other'), "style"=>"display:none;")); ?></td>
		</tr>
		<tr>
        	<td>Ruta: </td>
        	<td><?= form_dropdown("route",$routes,set_value('route', $list[0]->route)); ?></td>
		</tr>
		<tr>
        	<td>Fecha de inicio: </td>
        	<td><?= form_input(array('type'=>'text','name'=>'start_date', 'id'=>'start_date', 'readonly'=>'readonly', 'style'=>'cursor: pointer;', 'value'=>set_value('start_date', (($list[0]->start_date != '0000-00-00') ? date('d/m/Y', strtotime($list[0]->start_date)) : '')))); ?></td>
		</tr>
		<tr>
        	<td>Continúa: </td>
        	<td><?= form_radio($data); ?> Yes <?= form_radio($data2); ?> No</td>
		</tr>
		<tr id="end_date_tr" stlye='display:none;'>
        	<td>Fecha término: </td>
        	<td><?= form_input(array('type'=>'text','name'=>'end_date', 'id'=>'end_date', 'readonly'=>'readonly', 'style'=>'cursor: pointer;', 'value'=>set_value('end_date', (($list[0]->end_date != '0000-00-00') ? date('d/m/Y', strtotime($list[0]->end_date)) : '')  ))); ?></td>
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
            AND strpos($_SESSION['role_options']['subject'], 'concomitant_medication_verify') 
            AND $list[0]->status == 'Record Complete'
        ){
    ?>
        <?= form_open('subject/concomitant_medication_verify', array('class'=>'form-horizontal')); ?>     
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
            AND strpos($_SESSION['role_options']['subject'], 'concomitant_medication_lock')
            AND $list[0]->status == 'Form Approved by Monitor'){
    ?>
        <?= form_open('subject/concomitant_medication_lock', array('class'=>'form-horizontal')); ?>       
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
            AND strpos($_SESSION['role_options']['subject'], 'concomitant_medication_signature')
            AND $list[0]->status == 'Form Approved and Locked'
        ){
    ?>
        <?= form_open('subject/concomitant_medication_signature', array('class'=>'form-horizontal')); ?>      
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