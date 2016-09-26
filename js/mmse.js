$(function(){
	$("#fecha").datepicker({ dateFormat: 'dd/mm/yy' });	


	$("select[name=cuanto_93_puntaje], select[name=cuanto_86_puntaje], select[name=cuanto_79_puntaje], select[name=cuanto_72_puntaje], select[name=cuanto_65_puntaje]").change(function(){
		var puntaje_a = 0;

		puntaje_a = (parseInt($("select[name=cuanto_93_puntaje]").val()) || 0) + (parseInt($("select[name=cuanto_86_puntaje]").val()) || 0) + (parseInt($("select[name=cuanto_79_puntaje]").val()) || 0) + (parseInt($("select[name=cuanto_72_puntaje]").val()) || 0) + (parseInt($("select[name=cuanto_65_puntaje]").val()) || 0);

		$("#puntaje_seccion_a").val(puntaje_a);

	});

	$("select[name*=puntaje]").change(function(){
		var total = 0;
		$("select[name*=puntaje]").each(function(index, value){
			
			if(value.name != 'cuanto_93_puntaje' && value.name != 'cuanto_86_puntaje' && value.name != 'cuanto_79_puntaje' && value.name != 'cuanto_72_puntaje'
				&& value.name != 'cuanto_65_puntaje' && value.name != 'puntaje_seccion_a' && value.name != 'mundo_puntaje'
			){
				if(value.value != ''){
					total = total + parseInt(value.value);
				}
			}
			
		});

		if($("select[name=puntaje_seccion_a]").val() != '' && $("select[name=mundo_puntaje]").val() != ''){
			if( $("select[name=puntaje_seccion_a]").val() >= $("select[name=mundo_puntaje]").val()){
				total = total + parseInt($("select[name=puntaje_seccion_a]").val());
			}
			else{
				total = total + parseInt($("select[name=mundo_puntaje]").val());	
			}
		}
		else if($("select[name=puntaje_seccion_a]").val() != ''){
			total = total + parseInt($("select[name=puntaje_seccion_a]").val());
		}
		else if($("select[name=mundo_puntaje]").val() != ''){
			total = total + parseInt($("select[name=mundo_puntaje]").val());	
		}

		$("#puntaje_total_td").html(total);
		$("input[name=puntaje_total]").val(total);		
	});

	var total2 = 0;
	$("select[name*=puntaje]").each(function(index, value){
		if(value.name != 'cuanto_93_puntaje' && value.name != 'cuanto_86_puntaje' && value.name != 'cuanto_79_puntaje' && value.name != 'cuanto_72_puntaje'
			&& value.name != 'cuanto_65_puntaje' && value.name != 'puntaje_seccion_a' && value.name != 'mundo_puntaje'
		){
			if(value.value != ''){
				total2 = total2 + parseInt(value.value);
			}
		}
		
	});
	if($("select[name=puntaje_seccion_a]").val() != '' && $("select[name=mundo_puntaje]").val() != ''){
		if( $("select[name=puntaje_seccion_a]").val() >= $("select[name=mundo_puntaje]").val()){
			total2 = total2 + parseInt($("select[name=puntaje_seccion_a]").val());
		}
		else{
			total2 = total2 + parseInt($("select[name=mundo_puntaje]").val());	
		}
	}
	else if($("select[name=puntaje_seccion_a]").val() != ''){
		total2 = total2 + parseInt($("select[name=puntaje_seccion_a]").val());
	}
	else if($("select[name=mundo_puntaje]").val() != ''){
		total2 = total2 + parseInt($("select[name=mundo_puntaje]").val());	
	}
	$("#puntaje_total_td").html(total2);
	$("input[name=puntaje_total]").val(total2);





	


	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_mmse :input").attr('readonly','readonly');
			$("#form_mmse :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
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
		$("#form_mmse :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
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

	//le_puedo_hacer_preguntas 
	$("input[name=le_puedo_hacer_preguntas]").change(function(){
		if($(this).is(":checked")){			

			$("#form_mmse :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});

		}else{
			$("#form_mmse :input").attr('readonly','readonly');
			$("#form_mmse :input").each(function(){
				if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
					$(this).val('');
				}
			});
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});
			$("input[name=realizado]").removeAttr('readonly');
			$("input[name=le_puedo_hacer_preguntas]").removeAttr('readonly');
			$("input[name=fecha]").removeAttr('readonly');
		}
	});

	if($("input[name=le_puedo_hacer_preguntas]").is(":checked"))
	{			

		$("#form_mmse :input").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});

	}else{
		$("#form_mmse :input").attr('readonly','readonly');
		$("#form_mmse :input").each(function(){
			if($(this).attr('name') != 'realizado' && ($(this).attr('type') == 'text' || $(this).is('select') || $(this).attr('type') == 'number')){
				$(this).val('');
			}
		});
		$('select option:not(:selected)').each(function(){
			$(this).attr('disabled', 'disabled');
		});
		$("input[name=realizado]").removeAttr('readonly');
		$("input[name=le_puedo_hacer_preguntas]").removeAttr('readonly');
		$("input[name=fecha]").removeAttr('readonly');
	}



	
	$("#realizar_a").click(function(){
		if($(this).is(':checked')){
			$("input[name=cuanto_93]").prop('readonly', false);			
			$("select[name=cuanto_93_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', false);
			});
			
			$("input[name=cuanto_86]").prop('readonly', false);			
			$("select[name=cuanto_86_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', false);
			});
			
			$("input[name=cuanto_79]").prop('readonly', false);			
			$("select[name=cuanto_79_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', false);
			});
			
			$("input[name=cuanto_72]").prop('readonly', false);			
			$("select[name=cuanto_72_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', false);
			});
			
			$("input[name=cuanto_65]").prop('readonly', false);			
			$("select[name=cuanto_65_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', false);
			});
			$("#realizar_b").prop('disabled',true);
		}
		else{
			$("input[name=cuanto_93]").prop('readonly', true);
			$("select[name=cuanto_93_puntaje]").val('');
			$("select[name=cuanto_93_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', true);
			});
			
			$("input[name=cuanto_86]").prop('readonly', true);
			$("select[name=cuanto_86_puntaje]").val('');
			$("select[name=cuanto_86_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', true);
			});
			
			$("input[name=cuanto_79]").prop('readonly', true);
			$("select[name=cuanto_79_puntaje]").val('');
			$("select[name=cuanto_79_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', true);
			});
			
			$("input[name=cuanto_72]").prop('readonly', true);
			$("select[name=cuanto_72_puntaje]").val('');
			$("select[name=cuanto_72_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', true);
			});
			
			$("input[name=cuanto_65]").prop('readonly', true);
			$("select[name=cuanto_65_puntaje]").val('');
			$("select[name=cuanto_65_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', true);
			});			
			
			$("select[name=puntaje_seccion_a]").val('');

			$("#realizar_b").prop('disabled',false);
		}
	});
	
	if($("#realizar_a").is(':checked')){
			$("input[name=cuanto_93]").prop('readonly', false);			
			$("select[name=cuanto_93_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', false);
			});
			
			$("input[name=cuanto_86]").prop('readonly', false);			
			$("select[name=cuanto_86_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', false);
			});
			
			$("input[name=cuanto_79]").prop('readonly', false);			
			$("select[name=cuanto_79_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', false);
			});
			
			$("input[name=cuanto_72]").prop('readonly', false);			
			$("select[name=cuanto_72_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', false);
			});
			
			$("input[name=cuanto_65]").prop('readonly', false);			
			$("select[name=cuanto_65_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', false);
			});
			$("#realizar_b").prop('disabled',true);
		}
		else{
			$("input[name=cuanto_93]").prop('readonly', true);
			$("select[name=cuanto_93_puntaje]").val('');
			$("select[name=cuanto_93_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', true);
			});
			
			$("input[name=cuanto_86]").prop('readonly', true);
			$("select[name=cuanto_86_puntaje]").val('');
			$("select[name=cuanto_86_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', true);
			});
			
			$("input[name=cuanto_79]").prop('readonly', true);
			$("select[name=cuanto_79_puntaje]").val('');
			$("select[name=cuanto_79_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', true);
			});
			
			$("input[name=cuanto_72]").prop('readonly', true);
			$("select[name=cuanto_72_puntaje]").val('');
			$("select[name=cuanto_72_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', true);
			});
			
			$("input[name=cuanto_65]").prop('readonly', true);
			$("select[name=cuanto_65_puntaje]").val('');
			$("select[name=cuanto_65_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled', true);
			});
			
			$("#realizar_b").prop('disabled',false);
		}

	$("#realizar_b").click(function(){
		if($(this).is(':checked')){
			$("#realizar_a").prop('disabled',true);	
			$("input[name=mundo_respuesta]").prop('readonly', false);
			$("select[name=mundo_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled',false);
			});
		}
		else{
			$("#realizar_a").prop('disabled',false);	
			$("input[name=mundo_respuesta]").prop('readonly', true);
			$("select[name=mundo_puntaje]").val('');
			$("select[name=mundo_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled',true);
			});
		}
	});
	if($("#realizar_b").is(':checked')){
			$("#realizar_a").prop('disabled',true);	
			$("input[name=mundo_respuesta]").prop('readonly', false);
			$("select[name=mundo_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled',false);
			});
		}
		else{
			$("#realizar_a").prop('disabled',false);	
			$("input[name=mundo_respuesta]").prop('readonly', true);
			$("select[name=mundo_puntaje]").val('');
			$("select[name=mundo_puntaje] option:not(:selected)").each(function(){
				$(this).prop('disabled',true);
			});
		}
});