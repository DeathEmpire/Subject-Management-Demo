$(function(){
	$("#fecha").datepicker();	

	$("input[name=realizado]").change(function(){
		if($(this).val() == 0){
			$("#form_npi :input").attr('readonly','readonly');
			$("input[name=realizado]").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});

		}else{
			$("#form_npi :input").removeAttr('readonly');
			$('select option:not(:selected)').each(function(){
				$(this).removeAttr('disabled');
			});
		}
	});
	if($("input[name=realizado]:checked").val() == 0){
		$("#form_npi :input").attr('readonly','readonly');
		$("input[name=realizado]").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
				$(this).attr('disabled', 'disabled');
			});

	}else{
		$("#form_npi :input").removeAttr('readonly');
		$('select option:not(:selected)').each(function(){
			$(this).removeAttr('disabled');
		});
	}

	$("input[name*=delirio]").change(function(){
		if($("input[name=delirio_frecuencia]").val() != '' && $("input[name=delirio_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=delirio_frecuencia]").val()) * parseInt($("input[name=delirio_severidad]").val());

			$("input[name=delirio_puntaje]").val(puntaje);
		}
	});
	$("input[name*=alucinaciones]").change(function(){
		if($("input[name=alucinaciones_frecuencia]").val() != '' && $("input[name=alucinaciones_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=alucinaciones_frecuencia]").val()) * parseInt($("input[name=alucinaciones_severidad]").val());

			$("input[name=alucinaciones_puntaje]").val(puntaje);
		}
	});
	$("input[name*=agitacion]").change(function(){
		if($("input[name=agitacion_frecuencia]").val() != '' && $("input[name=agitacion_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=agitacion_frecuencia]").val()) * parseInt($("input[name=agitacion_severidad]").val());

			$("input[name=agitacion_puntaje]").val(puntaje);
		}
	});
	
	$("input[name*=depresion]").change(function(){
		if($("input[name=depresion_frecuencia]").val() != '' && $("input[name=depresion_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=depresion_frecuencia]").val()) * parseInt($("input[name=depresion_severidad]").val());

			$("input[name=depresion_puntaje]").val(puntaje);
		}
	});
	
	$("input[name*=ansiedad]").change(function(){
		if($("input[name=ansiedad_frecuencia]").val() != '' && $("input[name=ansiedad_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=ansiedad_frecuencia]").val()) * parseInt($("input[name=ansiedad_severidad]").val());

			$("input[name=ansiedad_puntaje]").val(puntaje);
		}
	});
	
	$("input[name*=elacion]").change(function(){
		if($("input[name=elacion_frecuencia]").val() != '' && $("input[name=elacion_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=elacion_frecuencia]").val()) * parseInt($("input[name=elacion_severidad]").val());

			$("input[name=elacion_puntaje]").val(puntaje);
		}
	});
	
	$("input[name*=apatia]").change(function(){
		if($("input[name=apatia_frecuencia]").val() != '' && $("input[name=apatia_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=apatia_frecuencia]").val()) * parseInt($("input[name=apatia_severidad]").val());

			$("input[name=apatia_puntaje]").val(puntaje);
		}
	});
	
	$("input[name*=deshinibicion]").change(function(){
		if($("input[name=deshinibicion_frecuencia]").val() != '' && $("input[name=deshinibicion_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=deshinibicion_frecuencia]").val()) * parseInt($("input[name=deshinibicion_severidad]").val());

			$("input[name=deshinibicion_puntaje]").val(puntaje);
		}
	});
	
	$("input[name*=irritabilidad]").change(function(){
		if($("input[name=irritabilidad_frecuencia]").val() != '' && $("input[name=irritabilidad_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=irritabilidad_frecuencia]").val()) * parseInt($("input[name=irritabilidad_severidad]").val());

			$("input[name=irritabilidad_puntaje]").val(puntaje);
		}
	});
	
	$("input[name*=conducta]").change(function(){
		if($("input[name=conducta_frecuencia]").val() != '' && $("input[name=conducta_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=conducta_frecuencia]").val()) * parseInt($("input[name=conducta_severidad]").val());

			$("input[name=conducta_puntaje]").val(puntaje);
		}
	});
	
	$("input[name*=trastornos_sueno]").change(function(){
		if($("input[name=trastornos_sueno_frecuencia]").val() != '' && $("input[name=trastornos_sueno_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=trastornos_sueno_frecuencia]").val()) * parseInt($("input[name=trastornos_sueno_severidad]").val());

			$("input[name=trastornos_sueno_puntaje]").val(puntaje);
		}
	});
	
	$("input[name*=trastornos_apetito]").change(function(){
		if($("input[name=trastornos_apetito_frecuencia]").val() != '' && $("input[name=trastornos_apetito_severidad]").val() != ''){

			var puntaje = parseInt($("input[name=trastornos_apetito_frecuencia]").val()) * parseInt($("input[name=trastornos_apetito_severidad]").val());

			$("input[name=trastornos_apetito_puntaje]").val(puntaje);
		}
	});
	
	
});