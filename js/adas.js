$(function(){
	$("#fecha").datepicker();

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_adas :input").attr('readonly','readonly');
			
			$("input[name=realizado]").removeAttr('readonly');
			
			$("#guardar").removeAttr('readonly');
			

		}else{
			$("#form_adas :input").removeAttr('readonly');
			$("#puntaje_total").attr('readonly','readonly');
			
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_adas :input").attr('readonly','readonly');
		
		$("input[name=realizado]").removeAttr('readonly');
		
		$("#guardar").removeAttr('readonly');
		

	}else{
		$("#form_adas :input").removeAttr('readonly');
		$("#puntaje_total").attr('readonly','readonly');
		
	}

	$("select[name^=total_correctas_], input[name^=palabras_recordadas_], input[name^=total_recordadas], select[name^=puntuacion_]").change(function(){
		var total = 0;
		/*4 each*/

		$("select[name^=total_correctas_]").each(function(){
			if($('option:selected',this).text() != ''){
				total = total + parseInt($('option:selected',this).text());
			}
		});
		$("select[name^=puntuacion_]").each(function(){
			if($('option:selected',this).text() != ''){
				total = total + parseInt($('option:selected',this).text());
			}
		});
		$("input[name^=palabras_recordadas_]").each(function(){
			if($(this).val() != ''){
				total = total + parseInt($(this).val());
			}
		});
		$("input[name^=total_recordadas]").each(function(){
			if($(this).val() != ''){
				total = total + parseInt($(this).val());
			}
		});

		$("#puntaje_total").val(total);

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

		$("#puntaje_total_1").val(puntaje);

	});

	$("#total_incorrectas_2").change(function(){
		$("#puntuacion_2").val($(this).val());
	});

	$("#total_incorrectas_3").change(function(){
		if($("#paciente_no_dibujo_3").is(':checked')){
			$("#puntuacion_3").val("5");			
		}else{
			$("#puntuacion_3").val($(this).val());	
		}
	});

	$("#paciente_no_dibujo_3").click(function(){
		if($(this).is(":checked")){
			$("#puntuacion_3").val("5");
		}
		else{
			$("#puntuacion_3").val($(this).val());
		}
	});

	$("#total_no_recordadas_4").change(function(){
		$("#puntuacion_4").val($(this).val());
	});


	$("#total_incorrectas_5").change(function(){

		if($(this).val() >= 0 $(this).val() <= 2){
			$("#puntuacion_5").val(0);
		}
		else if($(this).val() >= 3 $(this).val() <= 5){
			$("#puntuacion_5").val(1);
		}
		else if($(this).val() >= 6 $(this).val() <= 8){
			$("#puntuacion_5").val(2);
		}
		else if($(this).val() >= 9 $(this).val() <= 11){
			$("#puntuacion_5").val(3);
		}
		else if($(this).val() >= 12 $(this).val() <= 14){
			$("#puntuacion_5").val(4);
		}
		else if($(this).val() >= 15 $(this).val() <= 17){
			$("#puntuacion_5").val(5);
		}	
		
	});
	
	$("#total_incorrectas_6").change(function(){
		$("#puntuacion_6").val($(this).val());
	});

	$("#total_incorrectas_7").change(function(){
		$("#puntuacion_7").val($(this).val());
	});

	$("#total_incorrectas_8").change(function(){
		var puntaje = parseInt($(this).val()) / 2;
		$("#puntuacion_7").val(puntaje);
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