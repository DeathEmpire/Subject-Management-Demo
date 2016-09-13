$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });

	jQuery("input[name=realizado]").change(function(){
		if(jQuery(this).val() == 0){
			jQuery("#form_adas :input").attr('readonly','readonly');			
			jQuery("input[name^=realizado]").removeAttr('readonly');
			
			jQuery("#form_adas :input").each(function(){
				if(jQuery(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).attr('type') == 'select')){
					jQuery(this).val('');
				}
			});

			jQuery("#guardar").removeAttr('readonly');
			

		}else{
			jQuery("#form_adas :input").each(function(){
				jQuery(this).attr('readonly', false);
			});
			jQuery("#puntaje_total").attr('readonly','readonly');
			
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_adas :input").attr('readonly','readonly');
		
		jQuery("#form_adas :input").each(function(){
			if(jQuery(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).attr('type') == 'select')){
				jQuery(this).val('');
			}
		});

		$("input[name=realizado]").removeAttr('readonly');
		
		$("#guardar").removeAttr('readonly');
		

	}else{
		$("#form_adas :input").each(function(){
				$(this).removeAttr('readonly');
			});
		$("#puntaje_total").attr('readonly','readonly');
		
	}

	$("#puntaje_total_1, #puntuacion_2, #puntuacion_3, #puntuacion_5, #puntuacion_6, #puntuacion_7, #puntuacion_8, #puntuacion_9, #puntuacion_10, #puntuacion_11, #puntuacion_12, #total_incorrectas_8, select[name*=total_incorrectas], select[name*=palabras_no_recordadas]").change(function(){
		var total = 0;
		
		if($("#puntaje_total_1").val() != ''){
			total = total + parseFloat($("#puntaje_total_1").val());
		}
		if($("#puntuacion_2").val() != ''){
			total = total + parseFloat($("#puntuacion_2").val());
		}
		if($("#puntuacion_3").val() != ''){
			total = total + parseFloat($("#puntuacion_3").val());
		}		
		if($("#puntuacion_5").val() != ''){
			total = total + parseFloat($("#puntuacion_5").val());
		}
		if($("#puntuacion_6").val() != ''){
			total = total + parseFloat($("#puntuacion_6").val());
		}
		if($("#puntuacion_7").val() != ''){
			total = total + parseFloat($("#puntuacion_7").val());
		}
		if($("#puntuacion_8").val() != ''){
			total = total + parseFloat($("#puntuacion_8").val());
		}
		if($("#puntuacion_9").val() != ''){
			total = total + parseFloat($("#puntuacion_9").val());
		}
		if($("#puntuacion_10").val() != ''){
			total = total + parseFloat($("#puntuacion_10").val());
		}
		if($("#puntuacion_11").val() != ''){
			total = total + parseFloat($("#puntuacion_11").val());
		}
		if($("#puntuacion_12").val() != ''){
			total = total + parseFloat($("#puntuacion_12").val());
		}

		$("#puntaje_total").val(total.toFixed(1));

	});

	$("#palabras_no_recordadas_1, #palabras_no_recordadas_2, #palabras_no_recordadas_3").change(function(){

		var puntaje = 0;

		if($("#palabras_no_recordadas_1").val() != ''){
			puntaje = puntaje + parseInt($("#palabras_no_recordadas_1").val());
		}

		if($("#palabras_no_recordadas_2").val() != ''){
			puntaje = puntaje + parseInt($("#palabras_no_recordadas_2").val());
		}

		if($("#palabras_no_recordadas_3").val() != ''){
			puntaje = puntaje + parseInt($("#palabras_no_recordadas_3").val());
		}

		puntaje = puntaje / 3;

		$("#puntaje_total_1").val(puntaje.toFixed(1));

		calcular_puntaje();

	});

	$("#total_incorrectas_2").change(function(){
		$("#puntuacion_2").val($(this).val());

		calcular_puntaje();
	});

	$("#total_incorrectas_3").change(function(){
		if($("#paciente_no_dibujo_3").is(':checked')){
			$("#puntuacion_3").val("5");			
		}else{
			$("#puntuacion_3").val($(this).val());	
		}

		calcular_puntaje();
	});

	$("#paciente_no_dibujo_3").click(function(){
		if($(this).is(":checked")){
			$("#puntuacion_3").val("5");
		}
		else{
			$("#puntuacion_3").val($(this).val());
		}

		calcular_puntaje();
	});

	$("#total_no_recordadas_4").change(function(){
		$("#puntuacion_4").val($(this).val());
		calcular_puntaje();
	});


	$("#total_incorrectas_5").change(function(){

		if($(this).val() >= 0 && $(this).val() <= 2){
			$("#puntuacion_5").val(0);
		}
		else if($(this).val() >= 3 && $(this).val() <= 5){
			$("#puntuacion_5").val(1);
		}
		else if($(this).val() >= 6 && $(this).val() <= 8){
			$("#puntuacion_5").val(2);
		}
		else if($(this).val() >= 9 && $(this).val() <= 11){
			$("#puntuacion_5").val(3);
		}
		else if($(this).val() >= 12 && $(this).val() <= 14){
			$("#puntuacion_5").val(4);
		}
		else if($(this).val() >= 15 && $(this).val() <= 17){
			$("#puntuacion_5").val(5);
		}	
		
		calcular_puntaje();
	});
	
	$("#total_incorrectas_6").change(function(){
		$("#puntuacion_6").val($(this).val());
		calcular_puntaje();
	});

	$("#total_incorrectas_7").change(function(){
		$("#puntuacion_7").val($(this).val());
		calcular_puntaje();
	});

	$("#total_incorrectas_8").change(function(){
		var puntaje = parseInt($(this).val()) / 2;
		$("#puntuacion_8").val(puntaje.toFixed(1));
		calcular_puntaje();
	});

	$("#cantidad_recordadas_8").change(function(){
		if($(this).val() == 0){
			$("#puntuacion_9").val(0);
		}
		else if($(this).val() == 1){
			$("#puntuacion_9").val(1);	
		}
		else if($(this).val() == 2){
			$("#puntuacion_9").val(2);	
		}
		else if($(this).val() == 3 || $(this).val() == 4){
			$("#puntuacion_9").val(3);	
		}
		else if($(this).val() == 5 || $(this).val() == 6){
			$("#puntuacion_9").val(4);	
		}
		else if($(this).val() >= 7){
			$("#puntuacion_9").val(5);	
		}
		else{
			$("#puntuacion_9").val('');		
		}

		calcular_puntaje();
	});

	$("#puntuacion_9").change(function(){

		if($(this).val() == 1 && $("#cantidad_recordadas_8").val() != 0){
			//query
		}
		else if($(this).val() == 2 && $("#cantidad_recordadas_8").val() != 2){
			//query
		}
		else if($(this).val() == 3 && $("#cantidad_recordadas_8").val() != 3 && $("#cantidad_recordadas_8").val() != 4){
			//query
		}
		else if($(this).val() == 4 && $("#cantidad_recordadas_8").val() != 5 && $("#cantidad_recordadas_8").val() != 6){
			//query
		}	
		else if($(this).val() == 5 && $("#cantidad_recordadas_8").val() != 5 && $("#cantidad_recordadas_8").val() < 7){
			//query
		}
		else{
			//bien
		}

	});
});

function calcular_puntaje(){
	var total = 0;
		
		if($("#puntaje_total_1").val() != ''){
			total = total + parseFloat($("#puntaje_total_1").val());
		}
		if($("#puntuacion_2").val() != ''){
			total = total + parseFloat($("#puntuacion_2").val());
		}
		if($("#puntuacion_3").val() != ''){
			total = total + parseFloat($("#puntuacion_3").val());
		}		
		if($("#puntuacion_5").val() != ''){
			total = total + parseFloat($("#puntuacion_5").val());
		}
		if($("#puntuacion_6").val() != ''){
			total = total + parseFloat($("#puntuacion_6").val());
		}
		if($("#puntuacion_7").val() != ''){
			total = total + parseFloat($("#puntuacion_7").val());
		}
		if($("#puntuacion_8").val() != ''){
			total = total + parseFloat($("#puntuacion_8").val());
		}
		if($("#puntuacion_9").val() != ''){
			total = total + parseFloat($("#puntuacion_9").val());
		}
		if($("#puntuacion_10").val() != ''){
			total = total + parseFloat($("#puntuacion_10").val());
		}
		if($("#puntuacion_11").val() != ''){
			total = total + parseFloat($("#puntuacion_11").val());
		}
		if($("#puntuacion_12").val() != ''){
			total = total + parseFloat($("#puntuacion_12").val());
		}

		$("#puntaje_total").val(total.toFixed(1));
}