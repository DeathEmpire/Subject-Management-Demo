<legend style='text-align:center;'>Signos Vitales (Adicional)</legend>
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
				<th>Fecha</th>
				<th>Presion Sistolica</th>
				<th>Presion Diastolica</th>
				<th>Frecuencia Cardiaca</th>
				<th>Frecuencia Respiratoria</th>
				<th>Temperatura</th>
				<th>Peso</th>
				<th>Obervaciones</th>
				<th>Usuario</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($lista as $v) {
			?>
				<tr>
					<td><?= (($v->fecha != '0000-00-00') ? date("d/m/Y", strtotime($v->fecha)) : "");?></td>
					<td><?= $v->presion_sistolica;?></td>
					<td><?= $v->presion_diastolica;?></td>
					<td><?= $v->frecuencia_cardiaca;?></td>
					<td><?= $v->frecuencia_respiratoria;?></td>
					<td><?= $v->temperatura;?></td>
					<td><?= $v->peso;?></td>
					<td><?= $v->observaciones;?></td>
					<td><?= $v->usuario_creacion;?></td>
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