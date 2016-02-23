<?php
switch(date("m")){
	
	case "01" : $nom_mes = "Enero"; break;
	case "02" : $nom_mes = "Febrero"; break;
	case "03" : $nom_mes = "Marzo"; break;
	case "04" : $nom_mes = "Abril"; break;
	case "05" : $nom_mes = "Mayo"; break;
	case "06" : $nom_mes = "Junio"; break;
	case "07" : $nom_mes = "Julio"; break;
	case "08" : $nom_mes = "Agosto"; break;
	case "09" : $nom_mes = "Septiembre"; break;
	case "10" : $nom_mes = "Octubre"; break;
	case "11" : $nom_mes = "Noviembre"; break;
	case "12" : $nom_mes = "Diciembre"; break;
	default : $nom_mes = date("F"); break;

}
?>
Con fecha: <?= date("d"); ?> de <?= $nom_mes; ?> del <?= date("Y");?> a las <?= date("H:i"); ?><br />&nbsp;<br />
Se informa que hay un stock bajo en el centro.: <?= $registro['centro']; ?><br />
El Stock Actual es:<br />&nbsp;<br />
<table border='0'>
	<tr><td>Activos: </td><td><?= $registro['activos']; ?></td></tr>
	<tr><td>Placebos: </td><td><?= $registro['placebos']; ?></td></tr>
	<tr><td>Total: </td><td><?= $registro['total']; ?></td></tr>
</table><br />