<script type="text/javascript">
$(function(){
	$("#fecha").datepicker();
});
</script>
<legend style='text-align:center;'>MINI MENTAL STATE EXAMINATION (MMSE)</legend>
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
<?= form_open('subject/mmse_insert', array('class'=>'form-horizontal')); ?>    
	
	<?= form_hidden('subject_id', $subject->id); ?>
	<?= form_hidden('etapa', $etapa); ?>

    <?= my_validation_errors(validation_errors()); ?>

	<?php
		$realizado = array(
		    'name'        => 'realizado',
		    'id'          => 'realizado',
		    'value'       => '1',
		    'checked'     => set_checkbox('realizado','1')			    
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

	

	No Realizado: <?= form_checkbox($realizado);?><br />
	Fecha: <?= form_input(array('type'=>'text','name'=>'fecha', 'id'=>'fecha', 'value'=>set_value('fecha'))); ?><br/>

	¿Tiene algún problema con su memoria? <?= form_checkbox($tiene_problemas_memoria);?><br />

	¿Le puedo hacer algunas preguntas acerca de su memoria? <?= form_checkbox($le_puedo_hacer_preguntas);?><br />

    <table class="table table-condensed table-bordered table-striped table-hover">          
		<tr>    
			<td></td>
			<td>PUNTAJE</td>
		</tr>
	    <tr>
	    	<td style='font-weight:bold;'>ORIENTACION EN EL TIEMPO</td>
	    	<td></td>
	    </tr>
	    <tr>
	    	<td>¿En qué año estamos?</td>
	    	<td><?= form_dropdown('tiempo_en_que_ano_estamos',$puntaje,set_radio('tiempo_en_que_ano_estamos')); ?></td>
	    </tr>

	    <tr>
	    	<td>¿En qué Estación del año estamos?</td>
	    	<td><?= form_dropdown('tiempo_en_que_estacion_estamos',$puntaje,set_radio('tiempo_en_que_estacion_estamos')); ?></td>
	    </tr>

	    <tr>
	    	<td>¿En qué Mes estamos?</td>
	    	<td><?= form_dropdown('tiempo_en_que_mes_estamos',$puntaje,set_radio('tiempo_en_que_mes_estamos')); ?></td>
	    </tr>

	    <tr>
	    	<td>¿En qué Día de la semana estamos?</td>
	    	<td><?= form_dropdown('tiempo_en_que_dia_estamos',$puntaje,set_radio('tiempo_en_que_dia_estamos')); ?></td>
	    </tr>

	    <tr>
	    	<td>¿En qué Fecha estamos?</td>
	    	<td><?= form_dropdown('tiempo_en_que_fecha_estamos',$puntaje,set_radio('tiempo_en_que_fecha_estamos')); ?></td>
	    </tr>
	    <tr>
	    	<td style='font-weight:bold;'>ORIENTACION EN EL LUGAR</td>
	    	<td></td>
	    </tr>
	    <tr>
	    	<td>¿En qué Región (provincia) estamos?</td>
	    	<td><?= form_dropdown('orientacion_en_que_region_estamos',$puntaje,set_radio('orientacion_en_que_region_estamos')); ?></td>
	    </tr>

	</table>
	<br />
	¿Dónde estás ahora? 
	<?= form_input(array('type'=>'text','name'=>'donde_estas_ahora', 'id'=>'donde_estas_ahora', 'value'=>set_value('donde_estas_ahora'))); ?>
	<?= form_dropdown('donde_estas_ahora_puntaje',$puntaje,set_radio('donde_estas_ahora_puntaje')); ?>
	<br/>

	¿Comuna (o ciudad/pueblo) estamos?
	<?= form_input(array('type'=>'text','name'=>'comuna_estamos', 'id'=>'comuna_estamos', 'value'=>set_value('comuna_estamos'))); ?>
	<?= form_dropdown('comuna_estamos_puntaje',$puntaje,set_radio('comuna_estamos_puntaje')); ?>
	<br/>

	¿Ciudad/pueblo (o parte de la ciudad/barrio) estamos?
	<?= form_input(array('type'=>'text','name'=>'barrio_estamos', 'id'=>'barrio_estamos', 'value'=>set_value('barrio_estamos'))); ?>
	<?= form_dropdown('barrios_estamos_punaje',$puntaje,set_radio('barrios_estamos_punaje')); ?>
	<br/>

	¿Edificio (nombre o tipo) estamos?
	<?= form_input(array('type'=>'text','name'=>'edificio_estamos', 'id'=>'edificio_estamos', 'value'=>set_value('edificio_estamos'))); ?>
	<?= form_dropdown('edificio_estamos_puntaje',$puntaje,set_radio('edificio_estamos_puntaje')); ?>
	<br/>

	<p style='font-style:italic;'>*Los nombres de los lugares se puden sustituir por nombres alternativos que sean apropiados y más precisos para el escenario. Se deben registrar.</p>
	<br/>

	REGISTRO*
	<br />
	<b>Escuche atentamente. Voy a decir tres palabras. Repítalas una vez que yo las haya dicho. ¿Estás listo? Las palabras son… MANZANA</b>
	 [pausa], PESO [pausa], MESA [pausa]. Ahora dígame esas palabras (se puede repetir hasta cinco veces, pero registre sólo el primer intento).
	<br />

	MANZANA
	<?= form_input(array('type'=>'text','name'=>'manzana', 'id'=>'manzana', 'value'=>set_value('manzana'))); ?>
	<?= form_dropdown('manzana_puntaje',$puntaje,set_radio('manzana_puntaje')); ?>
	<br/>

	PESO
	<?= form_input(array('type'=>'text','name'=>'peso', 'id'=>'peso', 'value'=>set_value('peso'))); ?>
	<?= form_dropdown('peso_puntaje',$puntaje,set_radio('peso_puntaje')); ?>
	<br/>

	MESA
	<?= form_input(array('type'=>'text','name'=>'mesa', 'id'=>'mesa', 'value'=>set_value('mesa'))); ?>
	<?= form_dropdown('mesa_puntaje',$puntaje,set_radio('mesa_puntaje')); ?>
	<br/>

	<b>Recuerde esas palabras. Le voy a pedir que me las repita en unos minutos más.</b>
	<p style='font-style:italic;'>*Cuando se vuelva a examinar a la persona, el grupo de palabras se ´pueden sustituir por un grupo alternativo
	(PONY, MONEDA, NARANJA). Se debe registrar la sustitución.</p>
	<br />

	ATENCIÓN Y CÁLCULO (Series de 7)
	<br />
	<b>Ahora, me gustaría que restara 100 menos 7. Siga restando 7 a los resultados que vaya obteniendo, hasta que le diga que se detenga.</b>
	<br />
	¿Cuánto es 100 menos 7?	[93]
	<?= form_input(array('type'=>'text','name'=>'cuanto_93', 'id'=>'cuanto_93', 'value'=>set_value('cuanto_93'))); ?>
	<?= form_dropdown('cuanto_93_puntaje',$puntaje,set_radio('cuanto_93_puntaje')); ?>
	<br />

	Si es necesario diga: Continúe.	[86]
	<?= form_input(array('type'=>'text','name'=>'cuanto_86', 'id'=>'cuanto_86', 'value'=>set_value('cuanto_86'))); ?>
	<?= form_dropdown('cuanto_86_puntaje',$puntaje,set_radio('cuanto_86_puntaje')); ?>
	<br />

	Si es necesario diga: Continúe.	[79]
	<?= form_input(array('type'=>'text','name'=>'cuanto_79', 'id'=>'cuanto_79', 'value'=>set_value('cuanto_79'))); ?>
	<?= form_dropdown('cuanto_79_puntaje',$puntaje,set_radio('cuanto_79_puntaje')); ?>
	<br />

	Si es necesario diga: Continúa.	[72]
	<?= form_input(array('type'=>'text','name'=>'cuanto_72', 'id'=>'cuanto_72', 'value'=>set_value('cuanto_72'))); ?>
	<?= form_dropdown('cuanto_72_puntaje',$puntaje,set_radio('cuanto_72_puntaje')); ?>
	<br />

	Si es necesario diga: Continúa.	[65]
	<?= form_input(array('type'=>'text','name'=>'cuanto_65', 'id'=>'cuanto_65', 'value'=>set_value('cuanto_65'))); ?>
	<?= form_dropdown('cuanto_65_puntaje',$puntaje,set_radio('cuanto_65_puntaje')); ?>
	<br />

	<table>
		<tr>
			<td>MEMORIA</td>
			<td>RESPUESTA</td>
			<td>PUNTAJE</td>
		</tr>
		<tr>
			<td colspan='3' style='font-weight:bold;'>¿Cuáles eran las tres palabras que le pedí que recordara? [No de pistas]</td>
		</tr>
		<tr>
			<td>MANZANA</td>
			<td><?= form_input(array('type'=>'text','name'=>'manzana_2', 'id'=>'manzana_2', 'value'=>set_value('manzana_2'))); ?></td>
			<td><?= form_dropdown('manzana_2_puntaje',$puntaje,set_radio('manzana_2_puntaje')); ?></td>
		</tr>
		<tr>
			<td>PESO</td>
			<td><?= form_input(array('type'=>'text','name'=>'peso_2', 'id'=>'peso_2', 'value'=>set_value('peso_2'))); ?></td>
			<td><?= form_dropdown('peso_2_puntaje',$puntaje,set_radio('peso_2_puntaje')); ?></td>
		</tr>
		<tr>
			<td>MESA</td>
			<td><?= form_input(array('type'=>'text','name'=>'mesa_2', 'id'=>'mesa_2', 'value'=>set_value('mesa_2'))); ?></td>
			<td><?= form_dropdown('mesa_2_puntaje',$puntaje,set_radio('mesa_2_puntaje')); ?></td>
		</tr>

		<tr>
			<td colspan='3'>NOMBRES</td>
		</tr>
		<tr>
			<td><b>¿Qué es esto?</b> [Muestre un lápiz mina o pasta].</td>
			<td><?= form_input(array('type'=>'text','name'=>'que_es_1', 'id'=>'que_es_1', 'value'=>set_value('que_es_1'))); ?></td>
			<td><?= form_dropdown('que_es_1_puntaje',$puntaje,set_radio('que_es_1_puntaje')); ?></td>
		</tr>
		<tr>
			<td><b>¿Qué es esto?</b> [Muestre un reloj].</td>
			<td><?= form_input(array('type'=>'text','name'=>'que_es_2', 'id'=>'que_es_2', 'value'=>set_value('que_es_2'))); ?></td>
			<td><?= form_dropdown('que_es_2_puntaje',$puntaje,set_radio('que_es_2_puntaje')); ?></td>
		</tr>
		<tr>
			<td colspan='3' style='font-style:italic;'>*Estos objetos se pueden sustituir por objetos alternativos comunes (por ejemplo: lentes, silla, llaves). Se deben registrar.</td>
		</tr>
		
	</table>
	<br />
	REPETICION
	<br />
	Ahora le voy a pedir que repita lo que yo voy a decir. ¿Está listo? <b>“NO SI, O CUANDO, O PORQUÉ”</b> Ahora dígalo usted.<br />
	<p style='font-style:italic;'>[Se puede repetir la prueba hasta 5 veces, pero registre sólo el primer intento.]</p><br />

	NO SI, O CUANDO, O PORQUÉ.
	<?= form_input(array('type'=>'text','name'=>'no_si_cuando_porque', 'id'=>'no_si_cuando_porque', 'value'=>set_value('no_si_cuando_porque'))); ?>
	<?= form_dropdown('no_si_cuando_porque_puntaje',$puntaje,set_radio('no_si_cuando_porque_puntaje')); ?>
	<br />
	<p style='font-weight:bold;'>Por favor utilice las páginas que vienen a continuación del formulario MMSE para realizar los siguientes 4 ejercicios
(Comprensión: página en blanco, lectura: página que dice “CIERRE LOS OJOS”, Escritura: página en blanco,
Dibujo: página con el diagrama).</p>
	<br />
	<hr>
	COMPRENSION <br />
	<b>Escuche atentamente porque le voy a pedir que haga algo. Tome este papel con la mano derecha</b> [pausa],<b> dóblelo por la mitad</b> [pausa] <b>y póngalo en el piso (o en la mesa).</b>
	<br />
	TOMARLO CON LA MANO DERECHA
	<?= form_input(array('type'=>'text','name'=>'tomar_con_la_mano_derecha', 'id'=>'tomar_con_la_mano_derecha', 'value'=>set_value('tomar_con_la_mano_derecha'))); ?>
	<?= form_dropdown('tomar_con_la_mano_derecha_puntaje',$puntaje,set_radio('tomar_con_la_mano_derecha_puntaje')); ?>
	<br />

	DOBLAR POR LA MITAD
	<?= form_input(array('type'=>'text','name'=>'doblar_por_la_mitad', 'id'=>'doblar_por_la_mitad', 'value'=>set_value('doblar_por_la_mitad'))); ?>
	<?= form_dropdown('doblar_por_la_mitad_puntaje',$puntaje,set_radio('doblar_por_la_mitad_puntaje')); ?>
	<br />

	PONER EN EL PISO	
	<?= form_input(array('type'=>'text','name'=>'poner_en_el_piso', 'id'=>'poner_en_el_piso', 'value'=>set_value('poner_en_el_piso'))); ?>
	<?= form_dropdown('poner_en_el_piso_puntaje',$puntaje,set_radio('poner_en_el_piso_puntaje')); ?>
	<br />
	<hr>
	LECTURA
	<br />
	<b>Por favor lea lo siguiente y haga lo que dice.</b> (Muestre a la persona examinada las palabras en el formulario de estímulo).
	<br />

	CIERRE LOS OJOS
	<?= form_input(array('type'=>'text','name'=>'cierre_los_ojos', 'id'=>'cierre_los_ojos', 'value'=>set_value('cierre_los_ojos'))); ?>
	<?= form_dropdown('cierre_los_ojos_puntaje',$puntaje,set_radio('cierre_los_ojos_puntaje')); ?>
	<br />
	<hr />
	ESCRITURA
	<b>Por favor escriba una oración.</b> [Si la persona examinada no responde diga: <b>Escribe sobre el clima.</b>]<br />
	Ponga la hoja en blanco (sin doblar) frente al paciente y pásele un lápiz mina o pasta. Dé 1 punto si la oración se entiende y contiene un sujeto y un verbo. Ignore los errores de gramática u ortografía.<br />
	<?= form_dropdown('escritura_puntaje',$puntaje,set_radio('escritura_puntaje')); ?>
	<hr />
	DIBUJO<br />
	<b>Por favor copie este dibujo.</b> [Muestre los pentágonos superpuestos en el formulario de estímulo.] <br />
	Dé 1 punto si el dibujo consiste en dos figuras de cinco lados que intersectan para formar una figura de cuatro lados.<br />
	<?= form_dropdown('dibujo_puntaje',$puntaje,set_radio('dibujo_puntaje')); ?>
	<br />
	<hr />
	PUNTAJE TOTAL: <div id='puntaje_total'></div>

<?= form_close(); ?>