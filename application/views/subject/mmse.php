<style type="text/css">
	#ui-datepicker-div { display: none; }
</style>
<script type="text/javascript">
$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });	

	$("select[name*=puntaje]").change(function(){
		var total = 0;
		$("select[name*=puntaje]").each(function(index, value){
			if(value.value != ''){
				total = total + parseInt(value.value);
			}
			
		});
		$("#puntaje_total_td").html(total);
		$("input[name=puntaje_total]").val(total);		
	});

	var total2 = 0;
	$("select[name*=puntaje]").each(function(index, value){
		if(value.value != ''){
			total2 = total2 + parseInt(value.value);
		}
		
	});
	$("#puntaje_total_td").html(total2);
	$("input[name=puntaje_total]").val(total2);

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_mmse :input").attr('readonly','readonly');
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_mmse :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_mmse :input").attr('readonly','readonly');
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_mmse :input").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled', 'disabled');
		});
	}	
});
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
<legend style='text-align:center;'>MINI MENTAL STATE EXAMINATION (MMSE) <?= $protocolo;?></legend>
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
<?= form_open('subject/mmse_insert', array('class'=>'form-horizontal','id'=>'form_mmse')); ?>    
	
	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>

    <?= my_validation_errors(validation_errors()); ?>

	<?php
		$data = array(
			    'name'        => 'realizado',			    
			    'value'       => 1,		    
			    #'checked'	  => set_radio('gender', 'male', TRUE),
		    );
	  	$data2 = array(
		    'name'        => 'realizado',			    
		    'value'       => 0,
		    #'checked'	  => set_radio('gender', 'female', TRUE),		    
		    );

	    $tiene_problemas_memoria = array(
		    'name'        => 'tiene_problemas_memoria',
		    'id'          => 'tiene_problemas_memoria',
		    'value'       => '1',
		    'checked'     => set_checkbox('tiene_problemas_memoria','1')			    
	    );

	    $le_puedo_hacer_preguntas = array(
		    'name'        => 'le_puedo_hacer_preguntas',
		    'id'          => 'le_puedo_hacer_preguntas',
		    'value'       => '1',
		    'checked'     => set_checkbox('le_puedo_hacer_preguntas','1')			    
	    );
	?>

	
	<table class="table table-condensed table-bordered table-striped table-hover">
		<tr>
			<td>Realizado: </td>
			<td>
				<?= form_radio($data,$data['value'],set_radio($data['name'], 1, true)); ?> Si
				<?= form_radio($data2,$data2['value'],set_radio($data2['name'], 0)); ?> NO
			</td>
		</tr>
		<tr>
			<td>Fecha: </td>
			<td><?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?></td>
		</tr>
		<tr>
			<td style='font-weight:bold;'>PUNTAJE TOTAL: </td>
			<td id='puntaje_total_td' style='font-weight:bold;'>0</td>
		</tr>
		<tr>
			<td>Se consulta a sujeto...¿Tiene algún problema con su memoria? </td>
			<td><?= form_checkbox($tiene_problemas_memoria);?></td>
		</tr>
		<tr>
			<td>Se consulta a sujeto...¿Le puedo hacer algunas preguntas acerca de su memoria?</td>
			<td><?= form_checkbox($le_puedo_hacer_preguntas);?></td>
		</tr>              
	</table>
	<table class="table table-striped table-bordered table-striped table-hover">
		<tr>    
			<td style='font-weight:bold;background-color:#ccc;'>Pregunta</td>
				<td style='font-weight:bold;background-color:#ccc;'>Respuesta</td>
				<td style='font-weight:bold;background-color:#ccc;'>Puntaje</td>
		</tr>
		
	    <tr>
	    	<td style='font-weight:bold;' colspan='3'>ORIENTACION EN EL TIEMPO</td>	    	
	    </tr>
	    <tr>
	    	<td>¿En qué año estamos?</td>
	    	<td><?= form_input(array('type'=>'text','name'=>'en_que_ano_estamos', 'id'=>'en_que_ano_estamos', 'value'=>set_value('en_que_ano_estamos'))); ?></td>
	    	<td><?= form_dropdown('en_que_ano_estamos_puntaje',$puntaje,set_value('en_que_ano_estamos_puntaje')); ?></td>
	    </tr>

	    <tr>
	    	<td>¿En qué Estación del año estamos?</td>
	    	<td><?= form_input(array('type'=>'text','name'=>'en_que_estacion_estamos', 'id'=>'en_que_estacion_estamos', 'value'=>set_value('en_que_estacion_estamos'))); ?></td>
	    	<td><?= form_dropdown('en_que_estacion_estamos_puntaje',$puntaje,set_value('en_que_estacion_estamos_puntaje')); ?></td>
	    </tr>

	    <tr>
	    	<td>¿En qué Mes estamos?</td>
	    	<td><?= form_input(array('type'=>'text','name'=>'en_que_mes_estamos', 'id'=>'en_que_mes_estamos', 'value'=>set_value('en_que_mes_estamos'))); ?></td>
	    	<td><?= form_dropdown('en_que_mes_estamos_puntaje',$puntaje,set_value('en_que_mes_estamos_puntaje')); ?></td>
	    </tr>

	    <tr>
	    	<td>¿En qué Día de la semana estamos?</td>
	    	<td><?= form_input(array('type'=>'text','name'=>'en_que_dia_estamos', 'id'=>'en_que_dia_estamos', 'value'=>set_value('en_que_dia_estamos'))); ?></td>
	    	<td><?= form_dropdown('en_que_dia_estamos_puntaje',$puntaje,set_value('en_que_dia_estamos_puntaje')); ?></td>
	    </tr>

	    <tr>
	    	<td>¿En qué Fecha estamos?</td>
	    	<td><?= form_input(array('type'=>'text','name'=>'en_que_fecha_estamos', 'id'=>'en_que_fecha_estamos', 'value'=>set_value('en_que_fecha_estamos'))); ?></td>
	    	<td><?= form_dropdown('en_que_fecha_estamos_puntaje',$puntaje,set_value('en_que_fecha_estamos_puntaje')); ?></td>
	    </tr>
	    <tr>
	    	<td style='font-weight:bold;' colspan='3'>ORIENTACION EN EL LUGAR</td>	    	
	    </tr>
	    
		<tr>
			<td>¿Dónde estás ahora?</td>
			<td><?= form_input(array('type'=>'text','name'=>'donde_estas_ahora', 'id'=>'donde_estas_ahora', 'value'=>set_value('donde_estas_ahora'))); ?></td>
			<td><?= form_dropdown('donde_estas_ahora_puntaje',$puntaje,set_value('donde_estas_ahora_puntaje')); ?></td>
		</tr>	
		<tr>
	    	<td>¿En qué Región (provincia) estamos?</td>
			<td><?= form_input(array('type'=>'text','name'=>'en_que_region_estamos', 'id'=>'en_que_region_estamos', 'value'=>set_value('en_que_region_estamos'))); ?></td>
	    	<td><?= form_dropdown('en_que_region_estamos_puntaje',$puntaje,set_value('en_que_region_estamos_puntaje')); ?></td>
	    </tr>		
		<tr>
			<td>¿Comuna (o ciudad/pueblo) estamos?</td>
			<td><?= form_input(array('type'=>'text','name'=>'comuna_estamos', 'id'=>'comuna_estamos', 'value'=>set_value('comuna_estamos'))); ?></td>
			<td><?= form_dropdown('comuna_estamos_puntaje',$puntaje,set_value('comuna_estamos_puntaje')); ?></td>
		</tr>
		<tr>
			<td>¿Ciudad/pueblo (o parte de la ciudad/barrio) estamos?</td>
			<td><?= form_input(array('type'=>'text','name'=>'barrio_estamos', 'id'=>'barrio_estamos', 'value'=>set_value('barrio_estamos'))); ?></td>
			<td><?= form_dropdown('barrio_estamos_puntaje',$puntaje,set_value('barrio_estamos_puntaje')); ?></td>
		</tr>
		<tr>
			<td>¿Edificio (nombre o tipo) estamos?</td>
			<td><?= form_input(array('type'=>'text','name'=>'edificio_estamos', 'id'=>'edificio_estamos', 'value'=>set_value('edificio_estamos'))); ?></td>
			<td><?= form_dropdown('edificio_estamos_puntaje',$puntaje,set_value('edificio_estamos_puntaje')); ?></td>
		</tr>
		<tr>
			<td style='font-style:italic;' colspan='3'>*Los nombres de los lugares se pueden sustituir por nombres alternativos que sean apropiados y más precisos para el escenario. Se deben registrar.</td>
		</tr>	
		<tr>
			<td style='font-weight:bold;' colspan='3'>REGISTRO</td>
		</tr>
		<tr>			
			<td colspan='3'><b>Escuche atentamente. Voy a decir tres palabras. Repítalas una vez que yo las haya dicho. ¿Estás listo? Las palabras son… MANZANA</b>
	 [pausa], PESO [pausa], MESA [pausa]. Ahora dígame esas palabras (se puede repetir hasta cinco veces, pero registre sólo el primer intento).
			</td>
		</tr>
		<tr>
			<td>MANZANA</td>
			<td><?= form_input(array('type'=>'text','name'=>'manzana', 'id'=>'manzana', 'value'=>set_value('manzana'))); ?></td>
			<td><?= form_dropdown('manzana_puntaje',$puntaje,set_value('manzana_puntaje')); ?></td>
		</tr>
		<tr>
			<td>PESO</td>
			<td><?= form_input(array('type'=>'text','name'=>'peso', 'id'=>'peso', 'value'=>set_value('peso'))); ?></td>
			<td><?= form_dropdown('peso_puntaje',$puntaje,set_value('peso_puntaje')); ?></td>
		</tr>
		<tr>
			<td>MESA</td>
			<td><?= form_input(array('type'=>'text','name'=>'mesa', 'id'=>'mesa', 'value'=>set_value('mesa'))); ?></td>
			<td><?= form_dropdown('mesa_puntaje',$puntaje,set_value('mesa_puntaje')); ?></td>
		</tr>
		<tr><td colspan='3'><b>Recuerde esas palabras. Le voy a pedir que me las repita en unos minutos más.</b></td></tr>
		<tr><td colspan='3' style='font-style:italic;'>*Cuando se vuelva a examinar a la persona, el grupo de palabras se pueden sustituir por un grupo alternativo (PONY, MONEDA, NARANJA). Se debe registrar la sustitución.</td></tr>	
	

		<tr>
			<td style='font-weight:bold;' colspan='3'>ATENCIÓN Y CÁLCULO (Series de 7)</td>
		</tr>
		<tr>
			<td colspan='3'><b>Ahora, me gustaría que restara 100 menos 7. Siga restando 7 a los resultados que vaya obteniendo, hasta que le diga que se detenga.</b></td>
		</tr>
		<tr>
			<td>¿Cuánto es 100 menos 7?	[93]</td>
			<td><?= form_input(array('type'=>'text','name'=>'cuanto_93', 'id'=>'cuanto_93', 'value'=>set_value('cuanto_93'))); ?></td>
			<td><?= form_dropdown('cuanto_93_puntaje',$puntaje,set_value('cuanto_93_puntaje')); ?></td>
		<tr>

		<tr>
			<td>Si es necesario diga: Continúe.	[86]</td>
			<td><?= form_input(array('type'=>'text','name'=>'cuanto_86', 'id'=>'cuanto_86', 'value'=>set_value('cuanto_86'))); ?></td>
			<td><?= form_dropdown('cuanto_86_puntaje',$puntaje,set_value('cuanto_86_puntaje')); ?></td>
		</tr>
		<tr>
			<td>Si es necesario diga: Continúe.	[79]</td>
			<td><?= form_input(array('type'=>'text','name'=>'cuanto_79', 'id'=>'cuanto_79', 'value'=>set_value('cuanto_79'))); ?></td>
			<td><?= form_dropdown('cuanto_79_puntaje',$puntaje,set_value('cuanto_79_puntaje')); ?></td>
		</tr>
		<tr>
			<td>Si es necesario diga: Continúa.	[72]</td>
			<td><?= form_input(array('type'=>'text','name'=>'cuanto_72', 'id'=>'cuanto_72', 'value'=>set_value('cuanto_72'))); ?></td>
			<td><?= form_dropdown('cuanto_72_puntaje',$puntaje,set_value('cuanto_72_puntaje')); ?></td>
		</tr>
		<tr>
			<td>Si es necesario diga: Continúa.	[65]</td>
			<td><?= form_input(array('type'=>'text','name'=>'cuanto_65', 'id'=>'cuanto_65', 'value'=>set_value('cuanto_65'))); ?></td>
			<td><?= form_dropdown('cuanto_65_puntaje',$puntaje,set_value('cuanto_65_puntaje')); ?></td>
		</tr>	
		<tr>
			<td colspan='3' style='font-weight:bold;'>MEMORIA</td>			
		</tr>
		<tr>
			<td colspan='3' style='font-weight:bold;'>¿Cuáles eran las tres palabras que le pedí que recordara? [No de pistas]</td>
		</tr>
		<tr>
			<td>MANZANA</td>
			<td><?= form_input(array('type'=>'text','name'=>'manzana_2', 'id'=>'manzana_2', 'value'=>set_value('manzana_2'))); ?></td>
			<td><?= form_dropdown('manzana_2_puntaje',$puntaje,set_value('manzana_2_puntaje')); ?></td>
		</tr>
		<tr>
			<td>PESO</td>
			<td><?= form_input(array('type'=>'text','name'=>'peso_2', 'id'=>'peso_2', 'value'=>set_value('peso_2'))); ?></td>
			<td><?= form_dropdown('peso_2_puntaje',$puntaje,set_value('peso_2_puntaje')); ?></td>
		</tr>
		<tr>
			<td>MESA</td>
			<td><?= form_input(array('type'=>'text','name'=>'mesa_2', 'id'=>'mesa_2', 'value'=>set_value('mesa_2'))); ?></td>
			<td><?= form_dropdown('mesa_2_puntaje',$puntaje,set_value('mesa_2_puntaje')); ?></td>
		</tr>

		<tr>
			<td colspan='3' style='font-weight:bold;'>NOMBRES</td>
		</tr>
		<tr>
			<td><b>¿Qué es esto?</b> [Muestre un lápiz mina o pasta].</td>
			<td><?= form_input(array('type'=>'text','name'=>'que_es_1', 'id'=>'que_es_1', 'value'=>set_value('que_es_1'))); ?></td>
			<td><?= form_dropdown('que_es_1_puntaje',$puntaje,set_value('que_es_1_puntaje')); ?></td>
		</tr>
		<tr>
			<td><b>¿Qué es esto?</b> [Muestre un reloj].</td>
			<td><?= form_input(array('type'=>'text','name'=>'que_es_2', 'id'=>'que_es_2', 'value'=>set_value('que_es_2'))); ?></td>
			<td><?= form_dropdown('que_es_2_puntaje',$puntaje,set_value('que_es_2_puntaje')); ?></td>
		</tr>
		<tr>
			<td colspan='3' style='font-style:italic;'>*Estos objetos se pueden sustituir por objetos alternativos comunes (por ejemplo: lentes, silla, llaves). Se deben registrar.</td>
		</tr>
		<tr>
			<td colspan='3' style='font-weight:bold;'>REPETICION</td>
		</tr>
		<tr>
			<td colspan='3'>Ahora le voy a pedir que repita lo que yo voy a decir. ¿Está listo? <b>“NO SI, O CUANDO, O PORQUÉ”</b> Ahora dígalo usted.</td>
		</tr>
		<tr>
			<td colspan='3' style='font-style:italic;'>[Se puede repetir la prueba hasta 5 veces, pero registre sólo el primer intento.]</td>
		</tr>
		<tr>
			<td>NO SI, O CUANDO, O PORQUÉ.</td>
			<td><?= form_input(array('type'=>'text','name'=>'no_si_cuando_porque', 'id'=>'no_si_cuando_porque', 'value'=>set_value('no_si_cuando_porque'))); ?></td>
			<td><?= form_dropdown('no_si_cuando_porque_puntaje',$puntaje,set_value('no_si_cuando_porque_puntaje')); ?></td>
		</tr>
		<tr>
			<td colspan='3' style='font-weight:bold;'>Por favor utilice las páginas que vienen a continuación del formulario MMSE para realizar los siguientes 4 ejercicios
(Comprensión: página en blanco, lectura: página que dice “CIERRE LOS OJOS”, Escritura: página en blanco,
Dibujo: página con el diagrama).</td>
		</tr>
		<tr>	
			<td colspan='3' style='font-weight:bold;'>COMPRENSION </td>
		</tr>
		<tr>
			<td colspan='3'><b>Escuche atentamente porque le voy a pedir que haga algo. Tome este papel con la mano derecha</b> [pausa],<b> dóblelo por la mitad</b> [pausa] <b>y póngalo en el piso (o en la mesa).</b></td>
		</tr>
		<tr>	
			<td>TOMARLO CON LA MANO DERECHA</td>
			<td><?= form_input(array('type'=>'text','name'=>'tomar_con_la_mano_derecha', 'id'=>'tomar_con_la_mano_derecha', 'value'=>set_value('tomar_con_la_mano_derecha'))); ?></td>
			<td><?= form_dropdown('tomar_con_la_mano_derecha_puntaje',$puntaje,set_value('tomar_con_la_mano_derecha_puntaje')); ?></td>
		</tr>
		<tr>
			<td>DOBLAR POR LA MITAD
			<td><?= form_input(array('type'=>'text','name'=>'doblar_por_la_mitad', 'id'=>'doblar_por_la_mitad', 'value'=>set_value('doblar_por_la_mitad'))); ?></td>
			<td><?= form_dropdown('doblar_por_la_mitad_puntaje',$puntaje,set_value('doblar_por_la_mitad_puntaje')); ?></td>
		</tr>
		<tr>
			<td>PONER EN EL PISO	
			<td><?= form_input(array('type'=>'text','name'=>'poner_en_el_piso', 'id'=>'poner_en_el_piso', 'value'=>set_value('poner_en_el_piso'))); ?></td>
			<td><?= form_dropdown('poner_en_el_piso_puntaje',$puntaje,set_value('poner_en_el_piso_puntaje')); ?></td>
		</tr>
		<tr>
			<td colspan='3' style='font-weight:bold;'>LECTURA</td>
		</tr>
		<tr>
			<td colspan='3'><b>Por favor lea lo siguiente y haga lo que dice.</b> (Muestre a la persona examinada las palabras en el formulario de estímulo).</td>
		</tr>
		<tr>
			<td>CIERRE LOS OJOS</td>
			<td><?= form_input(array('type'=>'text','name'=>'cierre_los_ojos', 'id'=>'cierre_los_ojos', 'value'=>set_value('cierre_los_ojos'))); ?></td>
			<td><?= form_dropdown('cierre_los_ojos_puntaje',$puntaje,set_value('cierre_los_ojos_puntaje')); ?></td>
		</tr>
		<tr>
			<td colspan='3' style='font-weight:bold;'>ESCRITURA</td>
		</tr>
		<tr>
			<td colspan='3'><b>Por favor escriba una oración.</b> [Si la persona examinada no responde diga: <b>Escribe sobre el clima.</b>]</td>
		</tr>
		<tr>
			<td colspan='3'>Ponga la hoja en blanco (sin doblar) frente al paciente y pásele un lápiz mina o pasta. Dé 1 punto si la oración se entiende y contiene un sujeto y un verbo. Ignore los errores de gramática u ortografía.</td>
		</tr>
		<tr>
			<td colspan='3'><?= form_dropdown('escritura_puntaje',$puntaje,set_value('escritura_puntaje')); ?></td>
		</tr>
		<tr>
			<td colspan='3' style='font-weight:bold;'>DIBUJO</td>
		</tr>
		<tr>
			<td colspan='3'><b>Por favor copie este dibujo.</b> [Muestre los pentágonos superpuestos en el formulario de estímulo.]</td>
		</tr>
		<tr>
			<td colspan='3'>Dé 1 punto si el dibujo consiste en dos figuras de cinco lados que intersectan para formar una figura de cuatro lados.</td>
		</tr>
		<tr>
			<td colspan='3'><?= form_dropdown('dibujo_puntaje',$puntaje,set_value('dibujo_puntaje')); ?></td>
		</tr>	
		
		<tr>
			<td colspan='3' style='text-align:center;'>
				<?= form_hidden('puntaje_total'); ?>
				<?php
					if(isset($_SESSION['role_options']['subject']) AND strpos($_SESSION['role_options']['subject'], 'mmse_insert')){
				?>
					<?= form_button(array('type'=>'submit', 'content'=>'Guardar', 'class'=>'btn btn-primary')); ?>
				<?php } ?>
            	<?= anchor('subject/grid/'.$subject->id, 'Volver', array('class'=>'btn')); ?>
			</td>
		</tr>
	</table>
<?= form_close(); ?>