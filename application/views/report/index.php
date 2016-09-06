<script src="<?= base_url('js/export/src/jquery.table2excel.js') ?>"></script>
<legend style='text-align:center;'>Reportes</legend>
<script type="text/javascript">
$(function(){

	$("#exportar").click(function(){
		$("#tabla").table2excel({
		    // exclude CSS class
		    //exclude: ".noExl",		
		    name: "Reportes",		
		    filename: "Reportes_<?php echo date('Ymdhi'); ?>",		
		    fileext: ".xls",
			exclude_img: true,
			exclude_links: true,
			exclude_inputs: true
		  });
	});

	$("#btn_pdf").click(function(){
		$("#form_pdf").submit();
	});
});
</script>

<?= form_open('report/buscar'); ?>
	<table class="table table-striped table-bordered">
		<tr>
			<td>Formulario: </td>
			<td><?= form_dropdown('formulario', $forms, set_value('formulario')); ?></td>
			<td><?= form_button(array('type'=>'submit', 'content'=>'Buscar', 'class'=>'btn btn-primary')); ?></td>
		</tr>
		<tr>
			<td colspan='3'><?= my_validation_errors(validation_errors()); ?></td>
		</tr>
	</table>

<?= form_close(); ?>

<?php if(isset($list) AND !empty($list)){ 

	if(!strstr($list, 'No se encontraron resultados.')){
		?>	
		<p>
			<?= form_open('report/mostrarPdf', array('id'=>'form_pdf')); ?>
				<button type='button' class='btn btn-success fa fa-file-excel-o' id='exportar'></button>
				<input type='hidden' name='datos' value='<?= $list; ?>'>
				<button type='button' class='btn btn-danger fa fa-file-pdf-o' id='btn_pdf'></button>
			<?= form_close(); ?>
		</p>
	<?php
	}
	
	echo $list;

} ?>