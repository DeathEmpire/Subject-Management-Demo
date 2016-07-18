$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });		

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_digito_directo :input").attr('readonly','readonly');
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
			$("input[name=realizado]").removeAttr('readonly');

		}else{
			$("#form_digito_directo :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled', 'disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_digito_directo :input").attr('readonly','readonly');
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
		$("input[name=realizado]").removeAttr('readonly');

	}else{
		$("#form_digito_directo :input").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled', 'disabled');
		});
	}

	$("#puntaje_intento_1a, #puntaje_intento_1b").change(function(){
		var puntaje = parseInt($("#puntaje_intento_1a").val()) + parseInt($("#puntaje_intento_1b").val());		
		$("#puntaje_item_1a option[value="+puntaje+"]").prop('selected',true);		
	});

});